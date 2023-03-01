<?php

    class EditServicesMDL
    {
        private $db;

        public  function __construct()
        {
            $this->db = new Database;
        }

        public  function updateServices($sectionID, $section, $sectionText)
        {
            $this->db->query('UPDATE services SET services = :serv, service_text = :servtext WHERE section_id = :secid');
            $this->db->bind(':secid', $sectionID);
            $this->db->bind(':serv', $section);
            $this->db->bind(':servtext', $sectionText);

            $this->db->execute();
        }
    }