<?php

    class ListingPage
    {
        private $db;

        public  function __construct()
        {
            $this->db = new Database;
        }

        public  function getListingInfo($id)
        {
            $this->db->query('SELECT lst.listing_id,lst.listing_title,lst.listing_type_id,lsti.listing_info_text,lsti.listing_directions,lsti.listing_info_main_image,
                                   lst.listing_city,lst.listing_state,lst.listing_price,lst.total_acres,sts.state_abrv,lb.brochure_name,lv.video_url
                                   FROM listings lst 
                                   LEFT JOIN listing_info lsti ON lsti.listing_id = lst.listing_id 
                                   LEFT JOIN listing_images imgs ON imgs.listing_id = lst.listing_id 
                                   LEFT JOIN listing_states sts ON sts.state_id = lst.listing_state
                                   LEFT JOIN listing_brochure lb ON lb.listing_id = lst.listing_id
                                   LEFT JOIN listing_video lv ON lv.listing_id = lst.listing_id
                                   WHERE lst.listing_id = :lstid');
            $this->db->bind(':lstid', $id);

            $row = $this->db->single();

            return $row;
        }



        public function getImages($id)
        {
            $this->db->query('SELECT listing_image_id,listing_image,order_by FROM listing_images WHERE listing_id = :id ORDER BY order_by ASC');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            return $results;
        }


        public function getPDF($id)
        {
            $this->db->query('SELECT brochure_id, brochure_name FROM listing_brochure WHERE listing_id = :id');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            return $results;
        }

        public function getAuctionPDF($id)
        {
            $this->db->query('SELECT brochure_id, brochure FROM auction_brochure WHERE auction_id = :id');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            return $results;
        }

        public function getTheAuctionPDF($id)
        {
            $this->db->query('SELECT brochure_id, brochure FROM auction_brochure WHERE auction_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }


        public function deleteListingImage($imgID, $listingID)
        {
            $this->db->query('DELETE FROM listing_images WHERE listing_image_id = :imgid');
            $this->db->bind(':imgid', $imgID);

            $this->db->execute();

            $this->reorganizeImages($listingID);
        }

        public function deleteAuctionImage($imgID, $AuctionID)
        {
            $this->db->query('DELETE FROM auction_images WHERE 	auction_image_id = :imgid');
            $this->db->bind(':imgid', $imgID);

            $this->db->execute();

            $this->reorganizeAuctionImages($AuctionID);
        }

        public function reorganizeAuctionImages($AuctionID)
        {
            $this->db->query('SELECT auction_image_id FROM auction_images WHERE auction_id = :lstid ORDER BY order_by ASC');
            $this->db->bind(':lstid', $AuctionID);

            $results = $this->db->resultSet();
            $orderby = 1;
            foreach ($results as $item)
            {
                $this->updateAuctionImageOrder($item->auction_image_id, $orderby);
                $orderby++;
            }
        }

        public function updateAuctionImageOrder($imgID, $orderby)
        {
            $this->db->query('UPDATE auction_images SET order_by = :ordby WHERE auction_image_id = :imgid');
            $this->db->bind(':imgid', $imgID);
            $this->db->bind(':ordby', $orderby);

            $this->db->execute();
        }

        public function deleteListingPDF($pdfID, $listingID)
        {
            $this->db->query('DELETE FROM listing_brochure WHERE brochure_id = :bid AND listing_id = :id');
            $this->db->bind(':id', $listingID);
            $this->db->bind(':bid', $pdfID);

            $this->db->execute();
        }

        public function deleteAuctionPDF($pdfID, $Auction)
        {
            $this->db->query('DELETE FROM auction_brochure WHERE brochure_id = :bid AND auction_id = :id');
            $this->db->bind(':id', $Auction);
            $this->db->bind(':bid', $pdfID);

            $this->db->execute();
        }

        public function reorganizeImages($listingID)
        {
            $this->db->query('SELECT listing_image_id FROM listing_images WHERE listing_id = :lstid ORDER BY order_by ASC');
            $this->db->bind(':lstid', $listingID);

            $results = $this->db->resultSet();
            $orderby = 1;
            foreach ($results as $item)
            {
                $this->updateImageOrder($item->listing_image_id, $orderby);
                $orderby++;
            }
        }

        public function updateImageOrder($imgID, $orderby)
        {
            $this->db->query('UPDATE listing_images SET order_by = :ordby WHERE listing_image_id = :imgid');
            $this->db->bind(':imgid', $imgID);
            $this->db->bind(':ordby', $orderby);

            $this->db->execute();
        }

        public function getCurrentBid($id)
        {
            $currentbid = 0.00;
            $this->db->query('SELECT MAX(bid_amount) AS bid_amount FROM auction_bids WHERE auction_id = :actid');
            $this->db->bind(':actid', $id);

            $row = $this->db->single();

            if($this->db->rowCount() > 0)
            {
                $currentbid = $row->bid_amount;
            }

            return $currentbid;
        }

        public  function getMinBid($id)
        {
            $minbid = 0.00;
            $currentbid = $this->getCurrentBid($id);
            $listingPrice = $this->getAuctionInfo($id)->starting_bid;
            $theMinBidAmount = $this->getSetBid($listingPrice);
            if($currentbid == 0)
            {
                $minbid = $listingPrice + $theMinBidAmount->min_bid;
            }
            else
            {
                $minbid = $currentbid + $theMinBidAmount->min_bid;
            }

            return $minbid;
        }

        public  function getMinBidForBidding($id)
        {
            $minbid = 0.00;
            $currentbid = $this->getCurrentBid($id);
            $listingPrice = $this->getAuctionInfo($id)->starting_bid;
            $theMinBidAmount = $this->getSetBid($listingPrice);
            if($currentbid == 0)
            {
                $minbid = $listingPrice + $theMinBidAmount->min_bid;
            }
            else
            {
                $minbid = $currentbid + $theMinBidAmount->min_bid;
            }

            return $minbid;
        }

        public  function getSetBid($ListPrice)
        {
            $this->db->query('SELECT min_bid FROM bid_structure WHERE :lstprice BETWEEN min_price AND max_price');
            $this->db->bind(':lstprice', $ListPrice);

            $row = $this->db->single();

            return $row;
        }

        public function GettingMinBid($id)
        {
            $this->db->query('SELECT COALESCE(MAX(ab.bid_amount),aol.starting_bid) AS bid_amount 
                                   FROM auction_online aol 
                                   LEFT JOIN auction_bids ab ON ab.auction_id = aol.online_aucton_id 
                                   WHERE aol.online_aucton_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public function GetMinBidByAcre($id)
        {
            $this->db->query('SELECT COALESCE(MAX(ab.bid_by_acre),aol.starting_by_acres) AS bid_amount 
                                   FROM auction_online aol 
                                   LEFT JOIN auction_bids ab ON ab.auction_id = aol.online_aucton_id 
                                   WHERE aol.online_aucton_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public  function getAuctionInfo($id)
        {
            $this->db->query('SELECT online_aucton_id,listing_title,listing_short_description,main_img,additional_disclosures,closing,closing_date,closing_expenses,default_remedies, 
                                  end_date,end_time,farm_service_agency_info,leases,legal_description,listing_short_description,listing_title,main_img,mineral_etc, 
                                  property_condition,purchase_agreement,sale_procedure,starting_bid,start_date,start_time,title,end_date,end_time,completed,by_acre,total_acres,bid_increment,starting_by_acres,video_url 
                                  FROM auction_online 
                                  WHERE online_aucton_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;

        }

        public function getByAcreList($id)
        {
            $NextBid = $this->GetHighestMaxBidByAcre($id)->bid_by_acre;
            $this->db->querry('SELECT amount FROM auction_by_acre_amounts WHERE amount > :nbid');
            $this->db->bind(':nbid', $NextBid);

            $results = $this->db->resultSet();

            return $results;
        }

        public function GetHighestMaxBidByAcre($id)
        {

        }

        public  function getAuctionImages($id)
        {
            $this->db->query('SELECT auction_image_id,listing_image,order_by FROM auction_images WHERE auction_id = :id ORDER BY order_by ASC');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            return $results;

        }

        public function GetListingMainImage($id)
        {
            $this->db->query('SELECT listing_info_main_image FROM listing_info WHERE listing_id = :lstid');
            $this->db->bind(':lstid', $id);

            $row = $this->db->single();

            return $row;
        }

        public function GetAuctionMainImage($id)
        {
            $this->db->query('SELECT main_img FROM auction_online WHERE online_aucton_id = :auctionid');
            $this->db->bind(':auctionid', $id);

            $row = $this->db->single();

            return $row;
        }



        public function getCurrentInfo($id)
        {
            $this->db->query('SELECT ab.auction_bid_id,ab.auction_id,ab.bid_amount,ab.bid_date,usr.first_name,bnum.bid_number,ab.user_id  
                                  FROM auction_bids ab 
                                  LEFT JOIN users usr ON usr.user_id = ab.user_id 
                                  LEFT JOIN user_bid_number bnum ON bnum.user_id = usr.user_id
                                  WHERE auction_id = :id 
                                  ORDER BY ab.bid_amount DESC LIMIT 1');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public function AuctionComplete($id)
        {
            $this->db->query('UPDATE auction_online SET completed = 1 WHERE online_aucton_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }

        public function isAuctionComplete($id)
        {
            $this->db->query('SELECT completed FROM auction_online WHERE online_aucton_id = :olid');
            $this->db->bind(':olid', $id);

            $row = $this->db->single();

            return $row;
        }

        public function getWinnerEmail($id)
        {
            $this->db->query('SELECT usr.email_address
                                  FROM auction_bids ab 
                                  INNER JOIN users usr ON usr.user_id = ab.user_id 
                                  WHERE auction_id = :olid ORDER BY bid_amount DESC LIMIT 1');
            $this->db->bind(':olid', $id);

            $row = $this->db->single();

            return $row;
        }
        public function insertError($error)
        {
            $this->db->query('INSERT INTO error_log(error_text) VALUES(:etext)');
            $this->db->bind(':etext', $error);

            $this->db->execute();
        }

        public function GetMaxBid($auctionid, $userid)
        {
            $this->db->query('SELECT max_bid_id,max_amount FROM auction_max_bids WHERE user_id = :usrid AND auction_id = :aid ORDER BY max_amount DESC LIMIT 1');
            $this->db->bind(':usrid', $userid);
            $this->db->bind(':aid', $auctionid);

            $row = $this->db->single();

            return $row;
        }

        public function NewAuctionEndTime($id, $NewDate, $NewTime)
        {
            $this->db->query('UPDATE auction_online SET end_date = :newday, end_time = :newtime WHERE online_aucton_id = :id');
            $this->db->bind(':id', $id);
            $this->db->bind(':newday', $NewDate);
            $this->db->bind(':newtime', $NewTime);

            $this->db->execute();
        }
    }