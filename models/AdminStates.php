<?php

    class AdminStates
    {
        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }

        public  function insertNewState($data)
        {
            $this->db->query('INSERT INTO listing_states(state,state_abrv) VALUES(:sta,:abrv)');
            $this->db->bind(':sta', $data['state']);
            $this->db->bind(':abrv', $data['abbreviation']);

            $this->db->execute();
        }

        public  function updateState($data)
        {
            $this->db->query('UPDATE listing_states SET state = :sta, state_abrv = :abrv WHERE state_id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':sta', $data['state']);
            $this->db->bind(':abrv', $data['abbreviation']);

            $this->db->execute();
        }

        public  function getStateInfo($id)
        {
            $this->db->query('SELECT state_id,state,state_abrv FROM listing_states WHERE state_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public  function deleteState($id)
        {
            $this->db->query('DELETE FROM listing_states WHERE state_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }
    }