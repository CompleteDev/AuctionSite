<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 3/3/2019
 * Time: 12:34 PM
 */

    class AdminTestimonial extends Controller
    {
        public  function __construct()
        {
            $this->adminModel = $this->model('AdminMDL');
            $this->testimonalMDL = $this->model('admintestimonialsMDL');
        }

        public  function getTestimonialInfo()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['testimonialID'];
                $results = $this->testimonalMDL->TestimonalInfo($id);
                echo json_encode($results);
            }
        }

        public  function updateTestimonial()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['TestimonialID'];
                $tText = $_POST['TestimonialText'];
                $tCust = $_POST['TestimonalCustomer'];

                $this->testimonalMDL->updateThisTestimonial($id, $tText, $tCust);
            }
        }

        public  function DeleteTestimonial()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $id = $_POST['TestimonalID'];
                $this->testimonalMDL->DetleteThisTestimonail($id);
            }
        }

        public  function AddTestimonial()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);
                $TestimonalCustomer = filter_var($_POST['TestimonalCustomer'],FILTER_SANITIZE_STRING);

                $data =
                    [
                        'TestimonialText' => $purifier->purify(trim($_POST['TestimonialText'])),
                        'TestimonalCustomer' => $TestimonalCustomer,
                    ];

                $this->testimonalMDL->insertTestimonial($data);
            }
        }
    }