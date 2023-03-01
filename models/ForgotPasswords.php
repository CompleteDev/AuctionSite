<?php


    class ForgotPasswords
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function getUserID($email)
        {
            $this->db->query('SELECT user_id FROM users WHERE email_address = :addy');
            $this->db->bind(':addy', $email);
            $row = $this->db->single();

            if($this->db->rowCount() == 1)
            {
                return $row;
            }
            else
            {
                return false;
            }

        }

        public function InsertCode($id,$randChar)
        {
            $randomNumber = rand(10000000,999999999);
            $this->db->query('INSERT INTO user_forgot_pw(user_id,forgot_code) VALUES(:useid,:fcode)');
            $this->db->bind(':useid', $id);
            $this->db->bind(':fcode', $randomNumber . $id . $randChar);

            $this->db->execute();
        }

        public function GetUsersCode($userID)
        {
            $this->db->query('SELECT forgot_code FROM user_forgot_pw WHERE user_id = :usrid AND forgot_status = 0 ORDER BY forgot_id DESC LIMIT 1');
            $this->db->bind(':usrid', $userID);

            $row = $this->db->single();

            return $row;
        }

        public function GetForgotUserID($rcode)
        {
            $this->db->query('SELECT user_id FROM user_forgot_pw WHERE forgot_code = :fcode');
            $this->db->bind(':fcode', $rcode);
            $row = $this->db->single();

            if($this->db->rowCount() == 1)
            {
                return $row;
            }
            else
            {
                return false;
            }
        }

        public function UpdateUserPW($id, $newPW)
        {
            $this->db->query('UPDATE users SET password = :pw WHERE user_id = :usid');
            $this->db->bind(':usid', $id);
            $this->db->bind(':pw', $newPW);

            $this->db->execute();
        }

        public function isValidCode($fid)
        {
            $this->db->query('SELECT forgot_id FROM user_forgot_pw WHERE forgot_code = :code AND forgot_status = 0');
            $this->db->bind(':code', $fid);

            $row = $this->db->single();
            if($this->db->rowCount() == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function UpdateFCode($fid)
        {
            $this->db->query('UPDATE user_forgot_pw SET forgot_status = 1 WHERE forgot_code = :fid');
            $this->db->bind(':fid', $fid);

            $this->db->execute();
        }
    }