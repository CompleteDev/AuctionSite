<?php

    class SharedMDL
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function uploadSingleImage($imgFile,$imgName,$Location)
        {
            $extension = strtolower(end(explode(".", $imgFile[$imgName]['name'])));
            $allowed_type = array("jpg", "jpeg", "png");
            if(in_array($extension, $allowed_type))
            {
                $new_name = rand() . "." . $extension;

                $path = $Location . $new_name;


                if (move_uploaded_file($imgFile[$imgName]['tmp_name'], $path))
                {

                }
                else
                {
                    $this->insertError('Failed!!!');
                    die();
                }
            }
            return $new_name;
        }

        function generateRandomString($length)
        {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        public function uploadMultiFiles($imgFile,$imgName,$Location)
        {

        }

        public function insertError($error)
        {
            $this->db->query('INSERT INTO error_log(error_text) VALUES(:etext)');
            $this->db->bind(':etext', $error);

            $this->db->execute();
        }
    }