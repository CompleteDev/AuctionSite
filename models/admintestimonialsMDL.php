<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 3/3/2019
 * Time: 11:32 AM
 */

    class admintestimonialsMDL
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function GetTestimonials()
        {
            $this->db->query('SELECT test_id,test_customer FROM testimonials WHERE 1 ORDER BY test_id ASC');
            $results = $this->db->resultSet();

            return $results;
        }

        public function updateThisTestimonial($id, $tText, $tCustomer)
        {
            $this->db->query('UPDATE testimonials SET test_text = :ttext, test_customer = :tcust WHERE test_id = :tid');
            $this->db->bind(':tid', $id);
            $this->db->bind(':ttext', $tText);
            $this->db->bind(':tcust', $tCustomer);

            $this->db->execute();
        }
        public function TestimonalInfo($id)
        {
            $this->db->query('SELECT test_id,test_text,test_customer FROM testimonials WHERE test_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public function DetleteThisTestimonail($id)
        {
            $this->db->query('DELETE FROM testimonials WHERE test_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }

        public  function insertTestimonial($data)
        {
            $lastOrderNum = $this->getLastOrderNum();

            $this->db->query('INSERT INTO testimonials(test_text,test_customer,test_order) VALUES(:ttext,:cust,:ord)');
            $this->db->bind(':ttext', $data['TestimonialText']);
            $this->db->bind(':cust', $data['TestimonalCustomer']);
            $this->db->bind(':ord', $lastOrderNum+1);

            $this->db->execute();
        }

        private function getLastOrderNum()
        {
            $this->db->query('SELECT MAX(test_order) AS ord_num FROM testimonials');
            return $this->db->single()->ord_num;
        }
}