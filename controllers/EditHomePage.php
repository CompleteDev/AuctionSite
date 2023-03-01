<?php
    class EditHomePage extends Controller
    {
        public  function __construct()
        {
            $this->editHomeModel = $this->model('EditHomePageMDL');
            $this->listingsModel = $this->model('Listings');
        }

        public function updateHomePage()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);

                $CallToAction = filter_var($_POST['calltoaction'],FILTER_SANITIZE_STRING);
                $phone = filter_var($_POST['phonenumber'],FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['emailaddress'],FILTER_SANITIZE_STRING);
                $mainHeader = filter_var($_POST['mainInfoheader'],FILTER_SANITIZE_STRING);
                $mainFooter = filter_var($_POST['mainInfoFooter'],FILTER_SANITIZE_STRING);
                $data =
                    [
                        'CallToAction' => trim($CallToAction),
                        'phone' => trim($phone),
                        'email' => trim($email),
                        'mainHeader' => trim($mainHeader),
                        'maindFooter' => trim($mainFooter),
                        'leftInfo' => $purifier->purify(trim($_POST['mainLeftInfo'])),
                        'rightInfo' => $purifier->purify(trim($_POST['mainRightInfo'])),
                    ];

                $this->editHomeModel->UpdateMainInfo($data);

            }
        }
    }