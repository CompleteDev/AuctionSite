<?php

    class AdminMDL
    {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function adminlogin($email, $password)
        {
            $this->db->query('SELECT ausr.admin_id, usr.first_name, usr.password
                                   FROM admin_users ausr
                                   INNER JOIN users usr ON usr.user_id = ausr.user_id
                                   WHERE usr.email_address = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();

            $hashed_password = $row->password;
            if (password_verify($password, $hashed_password)) {
                return $row;
            } else {
                return false;
            }
        }

        public function getAllListings()
        {
            $this->db->query('SELECT lst.listing_id, lst.listing_title, lst.listing_city, lsty.listing_type 
                                   FROM listings lst 
                                   LEFT JOIN listing_types lsty ON lsty.listing_type_id = lst.listing_type_id 
                                   WHERE hide = 0 AND sold = 0
                                   ORDER BY lst.listing_id ASC');
            $results = $this->db->resultSet();

            return $results;
        }

        public function getHidden()
        {
            $this->db->query('SELECT lst.listing_id, lst.listing_title, lst.listing_city, lsty.listing_type 
                                   FROM listings lst 
                                   INNER JOIN listing_types lsty ON lsty.listing_type_id = lst.listing_type_id 
                                   WHERE hide = 1
                                   ORDER BY lst.listing_id ASC');
            $results = $this->db->resultSet();

            return $results;
        }

        public function getSold()
        {
            $this->db->query('SELECT lst.listing_id, lst.listing_title, lst.listing_city, lsty.listing_type 
                                   FROM listings lst 
                                   INNER JOIN listing_types lsty ON lsty.listing_type_id = lst.listing_type_id 
                                   WHERE hide = 0 AND sold = 1
                                   ORDER BY lst.listing_id ASC');
            $results = $this->db->resultSet();

            return $results;
        }

        public function showListing($id)
        {
            $this->db->query('SELECT lst.listing_id, lst.listing_title, lst.listing_city, lsty.listing_type, li.listing_info_text 
                                   FROM listings lst 
                                   INNER JOIN listing_types lsty ON lsty.listing_type_id = lst.listing_type_id 
                                   INNER JOIN listing_info li ON li.listing_id = lst.listing_id 
                                   WHERE lst.listing_id  = :listid');
            $this->db->bind(':listid', $id);

            $row = $this->db->single();

            return $row;
        }

        public function getListingsByType($typeid)
        {
            $this->db->query('SELECT lst.listing_id, lst.listing_title, lst.listing_city, lsty.listing_type 
                                   FROM listings lst 
                                   INNER JOIN listing_types lsty ON lsty.listing_type_id = lst.listing_type_id 
                                   WHERE lst.listing_type_id = :typeid
                                   ORDER BY lst.listing_id ASC');
            $this->db->bind(':typeid', $typeid);
            $results = $this->db->resultSet();

            return $results;
        }

        public function getListingTypes()
        {
            $this->db->query('SELECT listing_type,listing_type_id FROM listing_types');

            $results = $this->db->resultSet();

            return $results;
        }

        public function getStates()
        {
            $this->db->query('SELECT state_id,state,state_abrv FROM listing_states');

            $results = $this->db->resultSet();

            return $results;
        }

        public function getPages()
        {
            $this->db->query('SELECT page,page_id,is_multi FROM pages ORDER BY page_id ASC');

            $results = $this->db->resultSet();

            return $results;
        }

        public function getMainPageInfo()
        {
            $this->db->query('SELECT call_to_action,phone,email_us,main_info,right_info,footer_info,brand_img,header FROM home_main');

            $row = $this->db->single();

            return $row;
        }

        public  function getServices()
        {
            $this->db->query('SELECT services FROM services');

            $row = $this->db->single();

            return $row;
        }

        public  function getAssociates()
        {
            $this->db->query('SELECT associates_id,name FROM associates');
            $results = $this->db->resultSet();

            return $results;

        }

        public  function getAuctionListings()
        {
            $this->db->query('SELECT online_aucton_id,start_date,start_time,end_date,end_time,starting_bid,listing_title,active FROM auction_online');

            $results = $this->db->resultSet();

            return $results;
        }

        public function getBiddingHistory($id)
        {

            $this->db->query('SELECT ab.auction_id,ab.bid_amount,ab.bid_date,usr.first_name,usr.last_name, ubn.bid_number, abt.bid_type 
                                   FROM auction_bids ab 
                                   INNER JOIN users usr ON usr.user_id = ab.user_id 
                                   INNER JOIN user_bid_number ubn ON ubn.user_id = usr.user_id 
                                   INNER JOIN auction_bid_type abt ON abt.bid_type_id = ab.bid_type_id 
                                   WHERE ab.auction_id = :aid ORDER BY ab.auction_bid_id DESC ');
            $this->db->bind(':aid', $id);

            $results = $this->db->resultSet();

            return $results;

        }

        public function getBiddingID($id)
        {

            $this->db->query('SELECT ab.auction_id,ab.bid_amount,ab.bid_date,usr.first_name,usr.last_name, ubn.bid_number, abt.bid_type 
                                   FROM auction_bids ab 
                                   INNER JOIN users usr ON usr.user_id = ab.user_id 
                                   INNER JOIN user_bid_number ubn ON ubn.user_id = usr.user_id 
                                   INNER JOIN auction_bid_type abt ON abt.bid_type_id = ab.bid_type_id 
                                   WHERE ab.auction_id = :aid ORDER BY ab.auction_bid_id DESC ');
            $this->db->bind(':aid', $id);

            $row = $this->db->single();

            return $row;

        }

        public function getAuctionTandC()
        {
            $this->db->query('SELECT legal_description,title,mineral_etc,leases,farm_service_agency_info,property_condition,purchase_agreement, 
                                   closing_expenses,closing_date,sale_procedure,default_remedies,additional_disclosures,closing FROM auction_terms');

            $row = $this->db->single();

            return $row;
        }

        public function GetContactList()
        {
            $this->db->query('SELECT contact_id,contact_email FROM contact_list');

            $results = $this->db->resultSet();

            return $results;
        }

    }