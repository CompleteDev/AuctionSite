<?php

    class EditHomePageMDL
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function UpdateMainInfo($data)
        {
            $this->db->query('UPDATE home_main SET call_to_action = :cta,phone = :phone,email_us = :email,header = :hdr,main_info = :leftinf,right_info = :rightinf,footer_info = :ftrinf');
            $this->db->bind(':cta', $data['CallToAction']);
            $this->db->bind(':phone', $data['phone']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':hdr', $data['mainHeader']);
            $this->db->bind(':leftinf', $data['leftInfo']);
            $this->db->bind(':rightinf', $data['rightInfo']);
            $this->db->bind(':ftrinf', $data['maindFooter']);
            $this->db->execute();
        }

        public function insertError($error)
        {
            $this->db->query('INSERT INTO error_log(error_text) VALUES(:etext)');
            $this->db->bind(':etext', $error);

            $this->db->execute();
        }
    }