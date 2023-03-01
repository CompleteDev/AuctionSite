<?php
/**
 * Created by PhpStorm.
 * User: mike.richardson
 * Date: 1/28/2019
 * Time: 7:44 AM
 */

    class AdminUsers
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function getUsers($act)
        {
            $this->db->query('SELECT usr.user_id,usr.first_name,usr.last_name,ev.verified 
                                   FROM users usr 
                                   INNER JOIN user_email_verified ev ON ev.user_id = usr.user_id 
                                   WHERE usr.active = :act
                                   ORDER BY usr.first_name ASC');
            $this->db->bind(':act', $act);

            $results = $this->db->resultSet();

            return $results;
        }

        public  function getUserInfo($id)
        {
            $this->db->query('SELECT usrs.user_id, usrs.first_name, usrs.last_name, usrs.email_address, usi.address, usi.city, usi.state, usi.zip, usi.primary_phone,ubn.bid_number,ev.verified, COALESCE(adm.admin_id, 0) AS admin_id 
                                   FROM users usrs 
                                   LEFT JOIN user_info usi ON usi.user_id = usrs.user_id
                                   LEFT JOIN admin_users adm ON adm.user_id = usrs.user_id
                                   LEFT JOIN user_bid_number ubn ON ubn.user_id = usrs.user_id
                                   LEFT JOIN user_email_verified ev ON ev.user_id = usrs.user_id 
                                   WHERE usrs.user_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public function ActivateSelectedUser($id)
        {
            $this->db->query('UPDATE users SET active = 1 WHERE user_id = :usrid');
            $this->db->bind(':usrid', $id);

            $this->db->execute();
        }

        public function LockSelectedUser($id)
        {
            $this->db->query('UPDATE users SET active = 0 WHERE user_id = :usrid');
            $this->db->bind(':usrid', $id);

            $this->db->execute();
        }

        public function updateUser($data)
        {
            $this->db->query('UPDATE users SET first_name = :fname, last_name = :lname, email_address = :eaddy WHERE user_id = :usrid');
            $this->db->bind(':usrid', $data['id']);
            $this->db->bind(':fname', $data['userFirstName']);
            $this->db->bind(':lname', $data['userLastName']);
            $this->db->bind(':eaddy', $data['userEmail']);

            $this->db->execute();

            $this->updateUserInfo($data);
        }

        public function updateUserInfo($data)
        {
            $this->db->query('UPDATE user_info SET address = :addy, city = :city, state = :state, zip = :zip, primary_phone = :pphone WHERE user_id = :usrid');
            $this->db->bind(':usrid', $data['id']);
            $this->db->bind(':addy', $data['userAddress']);
            $this->db->bind(':city', $data['userCity']);
            $this->db->bind(':state', $data['userState']);
            $this->db->bind(':zip', $data['userZip']);
            $this->db->bind(':pphone', $data['userPrimPhone']);

            $this->db->execute();
        }

        public function setAsAdmin($id)
        {
            $this->db->query('INSERT INTO admin_users(user_id,active) VALUES(:usrid,:actv)');
            $this->db->bind(':usrid', $id);
            $this->db->bind(':actv', 1);

            $this->db->execute();
        }

        public function removeAdmin($id)
        {
            $this->db->query('DELETE FROM admin_users WHERE user_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }

        public  function isAdmin($id)
        {
            $Is_Admin = 0;
            $this->db->query('SELECT admin_id FROM admin_users WHERE user_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            if($this->db->rowCount() > 0)
            {
                $Is_Admin = 1;
            }

            return $Is_Admin;
        }

        public function DeleteUser($UserID)
        {
            $this->db->query('DELETE FROM users WHERE user_id = :usrid');
            $this->db->bind(':usrid', $UserID);

            $this->db->execute();
        }

    }