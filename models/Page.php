<?php

    class Page
    {
        private  $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public  function getMainPageInfo()
        {
            $this->db->query('SELECT call_to_action,brand_img,phone,email_us,header,main_info,right_info,main_info_img,footer_info FROM home_main');

            $row = $this->db->single();

            return $row;
        }

        public  function getAboutTitle($id)
        {
            $this->db->query('SELECT title FROM home_about_section WHERE home_about_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }
        public  function getAboutInfo($id)
        {
            $this->db->query('SELECT hs.title, hi.home_item
                                   FROM home_about_section hs
                                   INNER JOIN home_about_items hi ON hi.section_id = hs.home_about_id
                                   WHERE hs.home_about_id = :id');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            return $results;
        }
        public  function getFeatured($featid)
        {
            $this->db->query('SELECT mf.feature_title,lst.listing_title,li.listing_info_main_image,lst.listing_id,total_acres,lst.listing_city,ls.state_abrv 
                                   FROM main_features mf
                                   LEFT JOIN listings lst ON lst.listing_id = mf.feature_id
                                   LEFT JOIN listing_info li ON li.listing_id = lst.listing_id
                                   LEFT JOIN listing_states ls ON ls.state_id = lst.listing_state
                                   WHERE main_features_id = :featid');
            $this->db->bind(':featid', $featid);

            $row = $this->db->single();

            return $row;
        }

        public  function getcarouselImgs()
        {
            $this->db->query('SELECT img_name,img_order,img_text FROM home_carousel ORDER BY img_order ASC');

            $results = $this->db->resultSet();

            return $results;
        }

        ///Associates
        public  function getAsscoiates()
        {
            $this->db->query('SELECT name,title,about,image,phone FROM associates');

            $results = $this->db->resultSet();

            return $results;
        }

        public  function getServices()
        {
            $this->db->query('SELECT srv.services AS main_services, srv.service_text AS main_text, lmsrv.services AS lm_services, lmsrv.service_text AS lmservice_text, lhsrv.services AS lh_services,  
                                  lhsrv.service_text AS lhservice_text, finsrv.services AS fin_services, finsrv.service_text AS fin_text, relsrv.services AS rel_service, relsrv.service_text AS rel_text 
                                  FROM services srv 
                                  INNER JOIN services lmsrv ON lmsrv.services_id = 2 
                                  INNER JOIN services lhsrv ON lhsrv.services_id = 3 
                                  INNER JOIN services finsrv ON finsrv.services_id = 4 
                                  INNER JOIN services relsrv on relsrv.services_id = 5 
                                  WHERE srv.services_id = 1');

            $row = $this->db->single();

            return $row;
        }

        public  function getListingByTypes($id)
        {
            $this->db->query('SELECT lst.listing_id,lst.listing_title,lst.listing_tag_line,lst.listing_price,lst.total_acres,inf.listing_info_main_image,lst.listing_city,sts.state_abrv,lst.listing_zip,lst.listing_date 
                                  FROM listings lst 
                                  LEFT JOIN listing_info inf ON inf.listing_id = lst.listing_id
                                  LEFT JOIN listing_states sts ON sts.state_id = lst.listing_state
                                  LEFT JOIN listing_categories ctg ON ctg.listing_id = lst.listing_id
                                  WHERE lst.hide = 0 AND lst.listing_type_id = :id');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            return $results;
        }

        public  function getAllListings()
        {
            $this->db->query('SELECT lst.listing_id,lst.listing_title,lst.listing_tag_line,lst.listing_price,lst.total_acres,lst.listing_date,inf.listing_info_main_image,lst.listing_city,sts.state_abrv,lst.listing_zip,lt.listing_type,sold 
                                  FROM listings lst 
                                  INNER JOIN listing_info inf ON inf.listing_id = lst.listing_id
                                  INNER JOIN listing_states sts ON sts.state_id = lst.listing_state
                                  LEFT JOIN listing_types lt ON lt.listing_type_id = lst.listing_type_id 
                                  WHERE hide = 0 and sold = 0  ORDER BY lst.listing_id DESC');

            $results = $this->db->resultSet();

            return $results;
        }


	    public function getAuctions()
	    {
		    $this->db->query('SELECT online_aucton_id,listing_title,listing_short_description,main_img,start_date,end_date,0 AS atype 
                                  FROM auction_online 
                                  WHERE active = 1 
                                  UNION 
                                  SELECT amp.mp_id AS online_aucton_id,amp.mp_title AS listing_title,adc.primary_desc AS listing_short_description, 
                                  img.image_name AS main_img,mse.start_date,mse.end_date,1 atype 
                                  FROM landmark_supergroovycms_db.auction_mp_master amp 
                                  INNER JOIN landmark_supergroovycms_db.auction_mp_primarydesc adc ON adc.mp_master_id = amp.mp_id 
                                  INNER JOIN landmark_supergroovycms_db.auction_mp_primaryimage img ON img.mp_master_id = amp.mp_id 
                                  INNER JOIN landmark_supergroovycms_db.auction_mp_start_end mse ON mse.mp_id = amp.mp_id 
                                  WHERE amp.mp_active = 1');

		    $results = $this->db->resultSet();

		    return $results;
	    }

        public function isUserActive($id)
        {
            $this->db->query('SELECT active FROM users WHERE user_id = :usid');
            $this->db->bind(':usid', $id);
            $row = $this->db->single();

            return $row;
        }

        public  function getTestimonals()
        {
            $this->db->query('SELECT test_text,test_customer FROM testimonials ORDER BY test_id ASC');

            $results = $this->db->resultSet();

            return $results;
        }

        public function getTheTerms()
        {
            $this->db->query('SELECT terms,terms_body FROM terms_conditions');

            $row = $this->db->single();

            return $row;
        }

        public function VerifyEmail($code)
        {
            $this->db->query('UPDATE user_email_verified SET verified = 1 WHERE email_code = :code');
            $this->db->bind(':code', $code);

            $this->db->execute();
        }

        public function InsertNewContact($Email)
        {
            $this->db->query('INSERT INTO contact_list (contact_email) VALUES(:cemail)');
            $this->db->bind(':cemail', $Email);

            $this->db->execute();
        }
    }