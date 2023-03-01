<?php
    class Admin extends Controller
    {
        public function __construct()
        {
            $this->adminModel = $this->model('AdminMDL');
            $this->userModel = $this->model('User');
            $this->stateMDL = $this->model('AdminStates');
            $this->userMDL = $this->model('AdminUsers');
            $this->testimonalMDL = $this->model('admintestimonialsMDL');
            $this->oShared = $this->model('SharedMDL');
        }

        public function index()
        {
            if (!isset($_SESSION['admin_id'])) {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
            }
            $listings = $this->adminModel->getAllListings();
            $listing_types = $this->adminModel->getListingTypes();
            $states = $this->adminModel->getStates();
            $Auctionsinfo = $this->adminModel->getAuctionListings();
            $auctiontc = $this->adminModel->getAuctionTandC();
            $hiddenlistings = $this->adminModel->getHidden();
            $soldListings = $this->adminModel->getSold();
            $data =
                [
                    'pageTitle' => 'Dashboard',
                    'listings' => $listings,
                    'auctioninfo' => $Auctionsinfo,
                    'listing_types' => $listing_types,
                    'states' => $states,
                    'auctiontc' => $auctiontc,
                    'hiddenlistings' => $hiddenlistings,
                    'soldListings' => $soldListings,
                ];

            $this->view('admin/index', $data);
        }

        public function auctioninfo($id)
        {
            if (!isset($_SESSION['admin_id'])) {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
            }
            $auctionid = $this->adminModel->getBiddingID($id);
            $data =
                [
                    'pageTitle' => 'Info',
                    'auctionid' => $auctionid,
                ];

            $this->view('admin/auctioninfo', $data);
        }

	    public function adminmp($MPID)
	    {
		    if (!isset($_SESSION['admin_id']))
		    {
			    flash('register_success', 'Log into your admin account!', 'alert alert-danger');

			    redirect('admin/adminlogin');
		    }
		    $data =
			    [
				    'pageTitle' => 'Multi-Parcel',
				    'MPID' => $MPID,
			    ];

		    $this->view('admin/adminmp', $data);
	    }

	    public function adminmpparcel($ParcelID)
	    {
		    if (!isset($_SESSION['admin_id']))
		    {
			    flash('register_success', 'Log into your admin account!', 'alert alert-danger');

			    redirect('admin/adminlogin');
		    }
		    $data =
			    [
				    'pageTitle' => 'Parcel',
				    'PID' => $ParcelID,
			    ];

		    $this->view('admin/adminmpparcel', $data);
	    }

	    public function MPBidInfo($ParcelID)
	    {
		    if (!isset($_SESSION['admin_id']))
		    {
			    flash('register_success', 'Log into your admin account!', 'alert alert-danger');

			    redirect('admin/adminlogin');
		    }
		    $data =
			    [
				    'pageTitle' => 'Parcel',
				    'PID' => $ParcelID,
			    ];

		    $this->view('admin/mphistory', $data);
	    }

        public function admincontacts()
        {
            if (!isset($_SESSION['admin_id'])) {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
            }
            $data =
                [
                    'pageTitle' => 'Contacts',
                ];

            $this->view('admin/admincontacts', $data);
        }

        public function bidInfo()
        {
            if(!isset($_SESSION['admin_id']))
            {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
            }
            $AuctionID = $_POST['AuctionID'];
            $results = $this->adminModel->getBiddingHistory($AuctionID);
            echo json_encode($results);
        }

        public function adminusers()
        {
            if(!isset($_SESSION['admin_id']))
            {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
                die('here Redirect!');
            }
            $listing_types = $this->adminModel->getListingTypes();
            $states = $this->adminModel->getStates();
            $users = $this->userMDL->getUsers(1);
            $ia_users = $this->userMDL->getUsers(0);
            $auctiontc = $this->adminModel->getAuctionTandC();
            $data =
                [
                    'pageTitle' => 'Dashboard-Admin',
                    'users' => $users,
                    'ia_users' => $ia_users,
                    'listing_types' => $listing_types,
                    'states' => $states,
                    'auctiontc' => $auctiontc
                    //'title' => 'Super Groovy CMS/Framework',
                    //'description' => 'Something Groovy is coming your way!'
                ];

            $this->view('admin/adminusers', $data);
        }

        public function adminpages()
        {
            $pages = $this->adminModel->getPages();
            $mainPageInfo = $this->adminModel->getMainPageInfo();
            $services = $this->adminModel->getServices();
            $listing_types = $this->adminModel->getListingTypes();
            $states = $this->adminModel->getStates();
            $auctiontc = $this->adminModel->getAuctionTandC();
            if(!isset($_SESSION['admin_id']))
            {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');

            }

            $data =
                [
                    'pageTitle' => 'Dashboard-Pages',
                    'pages' => $pages,
                    'mainPageInfo' => $mainPageInfo,
                    'services' => $services,
                    'listing_types' => $listing_types,
                    'states' => $states,
                    'auctiontc' => $auctiontc
                ];

            $this->view('admin/adminpages', $data);
        }

        public function adminstates()
        {
            if(!isset($_SESSION['admin_id']))
            {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
            }
            $listing_types = $this->adminModel->getListingTypes();
            $states = $this->adminModel->getStates();
            $auctiontc = $this->adminModel->getAuctionTandC();
            $data =
                [
                    'pageTitle' => 'Dashboard-States',
                    'listing_types' => $listing_types,
                    'states' => $states,
                    'auctiontc' => $auctiontc
                ];

            $this->view('admin/adminstates', $data);
        }
        public function adminlistingtypes()
        {
            if(!isset($_SESSION['admin_id']))
            {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
            }
            $listing_types = $this->adminModel->getListingTypes();
            $states = $this->adminModel->getStates();
            $auctiontc = $this->adminModel->getAuctionTandC();
            $data =
                [
                    'pageTitle' => 'Dashboard-Types',
                    'listing_types' => $listing_types,
                    'states' => $states,
                    'auctiontc' => $auctiontc
                ];

            $this->view('admin/adminlistingtypes', $data);
        }

        public function admintestimonials()
        {
            if(!isset($_SESSION['admin_id']))
            {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
            }
            $testimonals = $this->testimonalMDL->GetTestimonials();
            $data =
                [
                    'pageTitle' => 'Dashboard-Testimonials',
                    'testimonals' => $testimonals,
                ];
            $this->view('admin/admintestimonials', $data);
        }

        public function adminassociates()
        {
            $associates = $this->adminModel->getAssociates();
            $listing_types = $this->adminModel->getListingTypes();
            $states = $this->adminModel->getStates();
            $auctiontc = $this->adminModel->getAuctionTandC();
            if(!isset($_SESSION['admin_id']))
            {
                flash('register_success', 'Log into your admin account!', 'alert alert-danger');
                redirect('admin/adminlogin');
            }
            $data =
                [
                    'pageTitle' => 'Dashboard-Associates',
                    'associates' => $associates,
                    'listing_types' => $listing_types,
                    'states' => $states,
                    'auctiontc' => $auctiontc
                ];

            $this->view('admin/adminassociates', $data);
        }

        public function GetContactList()
        {
            $results = $this->adminModel->GetContactList();
            echo json_encode($results);
        }

        public function adminlogin()
        {
            //check for post
            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //Process form
                $data =[
                    'pageTitle' => 'Dashboard',
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),

                    'email_err' => '',
                    'password_err' => ''
                ];

                if(empty($data['email']))
                {
                    $data['email_err'] = 'Please enter email';
                }
                if(empty($data['password']))
                {
                    $data['email_err'] = 'Please enter Password';
                }

                //check for user/email
                if($this->userModel->findUserByEmail($data['email']))
                {
                    //User found

                }
                else
                {
                    //user not found
                    $data['email_err'] = 'No User Found';
                }
                if(empty($data['email_err']) && empty($data['password_err']))
                {
                    //Validated
                    //check and set logged in user
                    $loggedInUser = $this->adminModel->adminlogin($data['email'], $data['password']);
                    if($loggedInUser)
                    {
                        //create session
                        $this->createAdminSessions($loggedInUser);
                    }
                    else
                    {
                        $data['password_err'] = 'Password incorrect';
                        $this->view('admin/adminlogin', $data);
                    }
                }
                else
                {
                    //Load View with errors
                    $this->view('admin/adminlogin', $data);
                }
            }
            else
            {
                //Init Data
                $data =[
                    'email' => '',
                    'password' => '',

                    'email_err' => '',
                    'password_err' => ''
                ];

                //load view
                $this->view('admin/adminlogin', $data);
            }
        }


        public function createAdminSessions($admin)
        {
            $_SESSION['admin_id'] = $admin->admin_id;
            $_SESSION['admin_name'] = $admin->first_name;
            redirect('admin/index');
        }

        public  function adminLogOut()
        {
            unset($_SESSION['admin_id']);
            unset($_SESSION['admin_name']);
            session_destroy();
            redirect('pages/index');
        }


    }