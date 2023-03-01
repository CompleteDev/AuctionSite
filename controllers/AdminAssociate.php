<?php

    class AdminAssociate extends Controller
    {
        public  function __construct()
        {
            $this->assModel = $this->model('AdminAssociates');
            $this->oShared = $this->model('SharedMDL');
        }

        public  function insertNewAssociate()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);

                $id = $_POST['associateID'];
                $associateFullName = filter_var($_POST['associateFullName'],FILTER_SANITIZE_STRING);
                $associateTitle = filter_var($_POST['associateTitle'],FILTER_SANITIZE_STRING);

                $data =
                    [
                        'id' => $id,
                        'associateFullName' => trim($associateFullName),
                        'associateTitle' => trim($associateTitle),
                        'aboutAssociate' => $purifier->purify(trim($_POST['aboutAssociate'])),
                    ];

               /* if($id == '')
                {
                    $imgName = $this->oShared->uploadSingleImage($_FILES,'associateImage', $_SERVER["DOCUMENT_ROOT"] . '/public/img/associates/');
                    $this->assModel->InsertAssociate($data,$imgName);
                }
                else
                {
                    $imgName = $this->oShared->uploadSingleImage($_FILES,'associateImage', $_SERVER["DOCUMENT_ROOT"] . '/public/img/associates/');
                    $this->assModel->UpdateAssociate($data,$imgName);
                }*/
                
                $imgName = $this->oShared->uploadSingleImage($_FILES,'associateImage', $_SERVER["DOCUMENT_ROOT"] . '/public/img/associates/');
                
                 if($id == '')
                {
                    $this->assModel->InsertAssociate($data,$imgName);
                }
                else
                {
                    $this->assModel->UpdateAssociate($data);
                    if($imgName != "")
                    {
                        $this->assModel->UpdateAssociateImage($data,$imgName);
                    }
                    
                }
            }
        }

        public  function getAssociateInfo()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['associateID'];
                $results = $this->assModel->getAssInfo($id);
                echo json_encode($results);
            }
        }

        public  function deleteAssociate()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['AssociateID'];
                $this->assModel->DeleteAssociate($id);
            }
        }
    }