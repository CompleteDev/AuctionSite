<?php

class LogUserIn extends Controller
{
    public  function __construct()
    {
	    $this->userModel = $this->model('User');
	    $this->pageModel = $this->model('Page');
	    $this->userAdminMDL = $this->model('AdminUsers');
	    $this->oShared = $this->model('SharedMDL');
	    $this->send_messaging = $this->model('Messaging');
    }

    public function LogUserIn()
    {
	    $Email = $_POST['UserName'];
	    $Password = $_POST['Password'];
	    $loggedInUser = $this->userModel->login($Email, $Password);
	    if($loggedInUser)
	    {
	    	$this->oShared->insertError("logging in");
		    //create session
		    $this->createUserSession($loggedInUser);
		    $results = ['results' => 'LoggedIn'];
		    echo json_encode($results);
	    }
	    else
	    {
		    $this->oShared->insertError("Failed");
		    $results = ['results' => 'Failed'];
		    echo json_encode($results);
	    }
    }

    public function ModalLogIn()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	$Email = $_POST['UserName'];
        	$Password = $_POST['Password'];
            $data =
                [
                    'email' => trim($_POST['UserName']),
                    'password' => trim($_POST['Password']),
                ];

            if($this->userModel->findUserByEmail($data['email']))
            {
                $loggedInUser = $this->userModel->login($Email, $Password);
                if($loggedInUser)
                {
                    //create session
                    $this->createUserSession($loggedInUser);
	                $results = ['results' => 'LoggedIn'];
	                echo json_encode($results);
                }
                else
                {
	                $results = ['results' => 'Failed'];
	                echo json_encode($results);
                }

            }
            else
            {
	            $results = ['results' => 'Failed'];
	            echo json_encode($results);
            }
        }
    }

	public function  ModalRegistration()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data =
				[
					'reg_first_name' => trim($_POST['reg_first_name']),
					'reg_last_name' => trim($_POST['reg_last_name']),
					'reg_email' => trim($_POST['reg_email']),
					'streetaddress' => trim($_POST['streetaddress']),
					'city' => trim($_POST['city']),
					'state' => trim($_POST['state']),
					'zip' => trim($_POST['zip']),
					'phone' => trim($_POST['phone']),
					'fourss' => trim($_POST['fourss']),
					'password' => trim($_POST['password']),
				];
			if($this->userModel->findUserByEmail($data['reg_email']))
			{
				$results = ['reply' => 'Exists'];
				echo json_encode($results);
			}
			else
			{
				$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

				$this->userModel->register($data);
				$this->send_messaging->insertEmail('New User','4023367611@vtext.com','mike@supergroovymail.com', 'There has been a new Registration'  . "\r\n"  . trim($_POST['reg_first_name']) . ' ' . trim($_POST['reg_last_name']));
				$this->send_messaging->insertEmail('New User','landmarketers@gmail.com','info@landmarketers.com', 'There has been a new Registration'  . "\r\n"  . trim($_POST['reg_first_name']) . ' ' . trim($_POST['reg_last_name']));
				//$this->send_messaging->insertEmail('New User','landmarketers@gmail.com','info@landmarketers.com', 'There has been a new Registration'  . "\r\n"  . trim($_POST['reg_first_name']) . ' ' . trim($_POST['reg_last_name']));
				$bidderinfo = $this->userModel->getBidderInfo(trim($_POST['reg_email']));
				$this->send_messaging->insertEmail('Verify Email',(trim($_POST['reg_email'])),'info@landmarketers.com','Thank you for registering with the Land Marketers online auction platform. Please have your financial institution send your Letter of Good Standing to us via email to Office@landmarketers.com, Once we recieve the Letter of Good Standing your account will be activated shortly.' . "\r\n"  .  'Please click the link below to verify your email address'  . "\r\n"  . 'https://www.landmarketers.com/pages/verifyemail/' . $bidderinfo->email_code  . "\r\n"  .  "\r\n". 'Your bidder number is: ' . $bidderinfo->bid_number . "\r\n".'Thank You' . "\r\n". "Land Marketers");
				$results = ['reply' => 'Good'];
				echo json_encode($results);
			}

		}
	}

	public  function createUserSession($user)
	{
		$_SESSION['user_id'] = $user->user_id;
		$_SESSION['user_emial'] = $user->email;
		$_SESSION['user_name'] = $user->first_name;
		//redirect('users/profile/' . $_SESSION['user_id']);
	}

	public  function  logout()
	{
		unset($_SESSION['user_id']);
		unset($_SESSION['user_emial']);
		unset($_SESSION['user_name']);
		session_destroy();
		$results = ['results' => 'LoggedOut'];
		echo json_encode($results);
	}

	public  function isLoggedIn()
	{
		if(isset($_SESSION['user_id']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}