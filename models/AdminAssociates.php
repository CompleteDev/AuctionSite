<?php

    class AdminAssociates
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public  function getAssInfo($id)
        {
            $this->db->query('SELECT associates_id,name,title,about,image FROM associates WHERE associates_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public  function InsertAssociate($data,$imgName)
        {
            $this->db->query('INSERT INTO associates(name,title,about,image) VALUES(:name,:title,:about,:img)');
            $this->db->bind(':name', $data['associateFullName']);
            $this->db->bind(':title', $data['associateTitle']);
            $this->db->bind(':about', $data['aboutAssociate']);
            $this->db->bind(':img', $imgName);

            $this->db->execute();
        }

        public  function UpdateAssociate($data)
        {
            $this->db->query('UPDATE associates SET name = :name, title = :title, about = :about WHERE associates_id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':name', $data['associateFullName']);
            $this->db->bind(':title', $data['associateTitle']);
            $this->db->bind(':about', $data['aboutAssociate']);
        
            $this->db->execute();
        }
        public  function UpdateAssociateImage($data,$imgName)
        {
            $this->db->query('UPDATE associates SET image = :img WHERE associates_id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':img', $imgName);
        
            $this->db->execute();
        }

        public  function DeleteAssociate($id)
        {
            $this->db->query('DELETE FROM associates WHERE associates_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
        }

        public function insertError($error)
        {
            $this->db->query('INSERT INTO error_log(error_text) VALUES(:etext)');
            $this->db->bind(':etext', $error);

            $this->db->execute();
        }

    }