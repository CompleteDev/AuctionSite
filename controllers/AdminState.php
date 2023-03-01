<?php
/**
 * Created by PhpStorm.
 * User: mike.richardson
 * Date: 1/16/2019
 * Time: 11:22 AM
 */

    class AdminState extends Controller
    {
        public  function __construct()
        {
            $this->adminModel = $this->model('AdminMDL');
            $this->stateMDL = $this->model('AdminStates');
        }

        public  function insertNewState()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $state = filter_var($_POST['state'],FILTER_SANITIZE_STRING);
                $abbreviation = filter_var($_POST['abbreviation'],FILTER_SANITIZE_STRING);
                $id = $_POST['stateid'];

                $data =
                    [
                        'state' => $state,
                        'abbreviation' => $abbreviation,
                        'id' => $id,
                    ];

                if($id == '')
                {
                    $this->stateMDL->insertNewState($data);
                }
                else
                {
                    $this->stateMDL->updateState($data);
                }

            }
        }

        public function getStateInfo()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['stateid'];
                $results = $this->stateMDL->getStateInfo($id);
                echo json_encode($results);
            }
        }

        public function deleteState()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['stateid'];
                $this->stateMDL->deleteState($id);
            }
        }

    }