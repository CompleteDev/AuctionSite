<?php
/**
 * Created by PhpStorm.
 * User: mike.richardson
 * Date: 11/21/2018
 * Time: 7:27 AM
 */

    class Posts extends Controller
    {
        public  function __construct()
        {
            if(!isset($_SESSION['user_id']))
            {
                redirect('users/login');
            }
        }

        public  function  index()
        {
            $data = [];
            $this->view('posts/index', $data);
        }

    }