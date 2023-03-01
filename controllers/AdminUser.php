<?php
/**
 * Created by PhpStorm.
 * User: mike.richardson
 * Date: 1/28/2019
 * Time: 8:32 AM
 */

    class AdminUser extends Controller
    {
        public  function __construct()
        {
            $this->userMDL = $this->model('AdminUsers');
            $this->oShared = $this->model('SharedMDL');

        }

        public function getUserInfo()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['userid'];
                $results = $this->userMDL->getUserInfo($id);
                echo json_encode($results);
            }
        }

        public function ActivateUser()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['userID'];

                $this->userMDL->ActivateSelectedUser($id);
                $this->view('pages/info');
            }
        }

        public function LockUser()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['userID'];

                $this->userMDL->LockSelectedUser($id);

            }
        }

        public function DeleteUser()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['userID'];
                $this->userMDL->DeleteUser($id);
            }
        }

        public function updateUser()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['userID'];
                $userFirstName = filter_var($_POST['firstName'],FILTER_SANITIZE_STRING);
                $userLastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
                $userEmail = filter_var($_POST['emailAddress'], FILTER_SANITIZE_EMAIL);
                $userAddress = filter_var($_POST['userAddress'], FILTER_SANITIZE_STRING);
                $userCity = filter_var($_POST['userCity'], FILTER_SANITIZE_STRING);
                $userState = filter_var($_POST['userState'], FILTER_SANITIZE_STRING);
                $userZip = filter_var($_POST['userZip'], FILTER_SANITIZE_NUMBER_FLOAT);
                $userPrimPhone = filter_var($_POST['userPriPhone'], FILTER_SANITIZE_STRING);
                $isExistingAdmin = $_POST['isAdmin'];
                $alreadyAdmin = $this->userMDL->isAdmin($id);

                if($isExistingAdmin == 1)
                {
                    if($alreadyAdmin == 0)
                    {
                        $this->userMDL->setAsAdmin($id);
                    }
                }
                else
                {
                    if($alreadyAdmin == 1)
                    {
                        $this->userMDL->removeAdmin($id);
                    }
                }

                $data =
                [
                    'id' => $id,
                    'userFirstName' => $userFirstName,
                    'userLastName' => $userLastName,
                    'userEmail' => $userEmail,
                    'userAddress' => $userAddress,
                    'userCity' => $userCity,
                    'userState' => $userState,
                    'userZip' => $userZip,
                    'userPrimPhone' => $userPrimPhone,
                ];

                $this->userMDL->updateUser($data);

            }
        }
    }