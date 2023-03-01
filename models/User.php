<?php
/**
 * Created by PhpStorm.
 * User: mike.richardson
 * Date: 11/20/2018
 * Time: 1:33 PM
 */

    class User
    {
        private $db;

        public  function __construct()
        {
            $this->db = new Database;
            //$this->send_messaging  = new Messaging;
        }

        //Find user by email

        public  function findUserByEmail($email)
        {
            $this->db->query('SELECT user_id FROM users WHERE email_address = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            if($this->db->rowCount() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public  function register($data)
        {
            $this->insertError('In Reg');
            $this->db->query('INSERT INTO users(first_name,last_name,email_address,password,active) VALUES(:f_name,:l_name,:email,:password,:active)');
            $this->db->bind(':f_name', $data['reg_first_name']);
            $this->db->bind(':l_name', $data['reg_last_name']);
            $this->db->bind(':email', $data['reg_email']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':active', 0);

            //Execute
            if($this->db->execute())
            {
                $usrid = $this->getLastUser();
                $this->insertUserInfo($data,$usrid->usrid);
                $this->insertPhoneVerify($usrid->usrid);
                $this->insertEmailVerify($usrid->usrid, $data['reg_email']);
                $this->createBidderNumber($usrid->usrid);
                return true;
            }
            else
            {
                return false;
            }
        }

        public  function insertUserInfo($data,$id)
        {
            $this->db->query('INSERT INTO user_info(user_id,address,city,state,zip,primary_phone,four_ss) VALUES(:usid,:aadr,:city,:state,:zip,:phone,:ss)');
            $this->db->bind(':usid', $id);
            $this->db->bind(':aadr', $data['streetaddress']);
            $this->db->bind(':city', $data['city']);
            $this->db->bind(':state', $data['state']);
            $this->db->bind(':zip', $data['zip']);
            $this->db->bind(':phone', $data['phone']);
            $this->db->bind(':ss', $data['fourss']);
            $this->db->execute();
        }

        public function insertPhoneVerify($id)
        {
            $randomNumber = rand(1000,9999);
            $this->db->query('INSERT INTO user_phone_verify(user_id,phone_code) VALUES(:usrid,:pcode)');
            $this->db->bind(':usrid', $id);
            $this->db->bind(':pcode', $randomNumber);

            $this->db->execute();
        }

        public function insertEmailVerify($id, $email)
        {
            $randomNumber = rand(1000,9999);
            $this->db->query('INSERT INTO user_email_verified(user_id,email_code) VALUES(:usrid,:ecode)');
            $this->db->bind(':usrid', $id);
            $this->db->bind(':ecode', $id.$randomNumber);

             $this->db->execute();



        }

        public function getBidderInfo($email)
        {
            $this->db->query('SELECT usr.user_id,ubn.bid_number,uev.email_code 
                                  FROM users usr 
                                  INNER JOIN user_bid_number ubn ON ubn.user_id = usr.user_id 
                                  INNER JOIN user_email_verified uev ON uev.user_id = usr.user_id
                                  WHERE usr.email_address = :emaddy');
            $this->db->bind(':emaddy', $email);

            $row = $this->db->single();

            return $row;
        }


        public function createBidderNumber($id)
        {
            $the_year = date("Y");
            $year_bidder_count = $this->getCurrentBidNumbers($the_year) + 1;
            $bidNumber = '';
            if($year_bidder_count < 10)
            {
                $bidNumber = $the_year . '-' . '00' . $year_bidder_count;
            }
            elseif ($year_bidder_count < 100 && $year_bidder_count >= 10)
            {
                $bidNumber = $the_year . '-' . '0' . $year_bidder_count;
            }
            else
            {
                $bidNumber = $the_year . '-' .  $year_bidder_count;
            }

            $this->db->query('INSERT INTO user_bid_number(user_id,the_year,bid_number) VALUES(:usrid,:tyear,:bnum)');
            $this->db->bind(':usrid', $id);
            $this->db->bind(':tyear', $the_year);
            $this->db->bind(':bnum', $bidNumber);

            $this->db->execute();

        }

        public function getCurrentBidNumbers($the_year)
        {
            $this->db->query('SELECT user_bid_id FROM user_bid_number WHERE the_year = :thisyear');
            $this->db->bind(':thisyear', $the_year);

            $results = $this->db->resultSet();

            $total_numbers = $this->db->rowCount();

            return $total_numbers;

        }

        public function getLastUser()
        {
            $this->db->query('SELECT MAX(user_id) AS usrid FROM users');

            $row = $this->db->single();

            return $row;
        }

        public  function login($email, $password)
        {
            $this->db->query('SELECT user_id,first_name,email_address,password FROM users WHERE email_address = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password))
            {
                return $row;
            }
            else
            {
                return false;
            }


        }

        public function getWatching($id)
        {
            $this->db->query('SELECT lst.listing_title,typ.listing_type,lst.listing_city,lst.listing_price 
                                   FROM user_watch usw 
                                   INNER JOIN listings lst ON lst.listing_id = usw.listing_id 
                                   INNER JOIN listing_types typ ON typ.listing_type_id = lst.listing_type_id 
                                   WHERE usw.user_id = :id');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            return $results;
        }

        public  function getBidHistory($id)
        {
            $this->db->query('SELECT lst.listing_title,lst.listing_city,MAX(acb.bid_amount) AS my_high_bid,MAX(hgbd.bid_amount) AS high_bid 
                                   FROM auction_bids acb 
                                   INNER JOIN listings lst ON lst.listing_id = acb.auction_id 
                                   INNER JOIN auction_bids hgbd ON hgbd.auction_id = acb.auction_id 
                                   WHERE acb.user_id = :id AND :id IN (SELECT user_id FROM auction_bids WHERE auction_id = 116)');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            return $results;
        }

        public function getTheTerms()
        {
            $this->db->query('SELECT terms,terms_body FROM terms_conditions');

            $row = $this->db->single();

            return $row;
        }

        public function insertError($error)
        {
            $this->db->query('INSERT INTO error_log(error_text) VALUES(:etext)');
            $this->db->bind(':etext', $error);

            $this->db->execute();
        }
    }