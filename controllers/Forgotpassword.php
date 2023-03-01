<?php


    class Forgotpassword extends Controller
    {
        public function __construct()
        {
            $this->fogortPW = $this->model('ForgotPasswords');
            $this->send_messaging = $this->model('Messaging');
            $this->oShared = $this->model('SharedMDL');
        }

        public function forgotpassword()
        {

            $this->view('pages/forgotpassword');
        }

        public function GetUserID()
        {
            $userEmail = $_POST['email'];

            if($userID = $this->fogortPW->getUserID($userEmail))
            {
                $randChar = $this->oShared->generateRandomString(10);
                $this->fogortPW->InsertCode($userID->user_id, $randChar);
                $emailCode =  $this->fogortPW->GetUsersCode($userID->user_id);
                $this->send_messaging->insertEmail('Password Reset', $userEmail, 'info@landmarketers.com', 'Please click this link to reset your password'
                    . "\r\n"  . 'https://www.landmarketers.com/Forgotpassword/resetpw/' . $emailCode->forgot_code . "\r\n"  . 'Thank you' . "\r\n"  . 'Land Marketers');
                $results = ['reply' => 'Exists'];
                echo json_encode($results);
            }
            else
            {
                $results = ['reply' => 'Nope'];
                echo json_encode($results);
            }
        }

            public function resetpw($code)
            {
                $data =
                    [
                        'code' => $code,
                    ];
                $this->view('pages/resetpw', $data);
            }

        public function UpdatePassword()
        {
            $ResetCode = $_POST['ResetID'];
            $NewPW = $_POST['Password'];

            if($this->fogortPW->isValidCode($ResetCode) == true)
            {
                $NewPW = password_hash($NewPW, PASSWORD_DEFAULT);

                $UserID = $this->fogortPW->GetForgotUserID($ResetCode);
                $this->fogortPW->UpdateUserPW($UserID->user_id, $NewPW);
                $this->fogortPW->UpdateFCode($ResetCode);
                $results = ['reply' => 'Exists'];
                echo json_encode($results);
            }
            else
            {
                $results = ['reply' => 'Nope'];
                echo json_encode($results);
            }

        }
    }