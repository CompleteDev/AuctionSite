<?php

class User_InteractionMDL
{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public  function addToUserWatchList($data)
    {
        $this->db->query('INSERT INTO user_watch(listing_id,user_id) VALUES(:lstid,:usrid)');
        $this->db->bind(':lstid', $data['listingID']);
        $this->db->bind(':usrid', $data['userID']);

        $this->db->execute();
    }

    public function doesBidExist($data)
    {
        $this->db->query('SELECT auction_bid_id FROM auction_bids WHERE auction_id = :aid AND bid_amount = :bamnt');
        $this->db->bind(':aid', $data['ListingID']);
        $this->db->bind(':bamnt', $data['newBid']);

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

    public function placeAutoBids($data)
    {
        $last_bid = $this->getHighestCurrantBid($data['AuctionID'])->bid_by_acre;
        $max_user = $this->getHighestCurrantBid($data['AuctionID'])->user_id;
        $next_bid = $last_bid + 25;

        if($max_user != $data['UserID'])
        {
            $this->addBid($data['AuctionID'],$data['UserID'],$next_bid,$next_bid * $data['totalAcres'], 2);
        }
    }

    public function placeMaxBids($id, $totalAcres)
    {
        $loop = true;
        while($loop == true)
        {
            foreach($this->getMaxBidsByAcre($id, $this->getHighestCurrantBid($id)->bid_by_acre) as $mxinfo)
            {
                //place bid using next_bid
                if($this->getHighestCurrantBid($id)->user_id != $mxinfo->user_id)
                {
                    $next_bid = $this->getHighestCurrantBid($id)->bid_by_acre + 25;
                    //Add Check to see if bid amount exists make sure can't go over max amount set
                    if($this->getUsersMaxBid($mxinfo->user_id)->max_bid >= $next_bid)
                    {
                        //function to see if there are multiple matching bids and if the current bidder in the loop is the oldest bid then place bid
                        if($this->isUsersMaxBid($mxinfo->user_id,$next_bid,$id) == true)
                        {
                            //Are there more than 1 of the same
                            if($this->isThereMoreThanOne($id,$next_bid) == true)
                            {
                                //Here need to make sure they are the 1st to place Max Bid
                                if($this->isHighestMultiple($mxinfo->user_id, $next_bid, $id) == true)
                                {
                                    $this->addBid($id,$mxinfo->user_id, $next_bid, $next_bid * $totalAcres, 2);
                                }
                                else
                                {
                                    // We will have the 1st bidder place the bid
                                    //Get the userID
                                    $FirstMaxBidderID = $this->getTheFirstMaxBidder($next_bid,$id)->user_id;
                                    $this->addBid($id,$FirstMaxBidderID,$next_bid, $next_bid * $totalAcres, 3);
                                }
                            }
                            else
                            {
                                $this->addBid($id,$mxinfo->user_id, $next_bid, $next_bid * $totalAcres, 2);
                            }

                        }
                        else
                        {
                            $this->addBid($id,$mxinfo->user_id, $next_bid, $next_bid * $totalAcres, 2);
                        }


                    }

                }
            }
            if($this->maxBidCount($id, $this->getHighestCurrantBid($id)->bid_by_acre + 25) == true)
            {
                //Check to see if time to end loop
                $loop = false;
            }
        }

    }

    public function isThereMoreThanOne($auctionID, $amount)
    {
        $this->db->query('SELECT max_bid_id FROM auction_max_bids WHERE auction_id = :aucid AND max_by_acre = :amount');
        $this->db->bind(':aucid', $auctionID);
        $this->db->bind(':amount', $amount);

        $row = $this->db->single();
        if($this->db->rowCount() > 1)
        {
            return true;
        }
        else
        {
            return false;
        }


    }

    public function isUsersMaxBid($userID, $amount, $aucitonID)
    {
        $this->db->query('SELECT max_by_acre FROM auction_max_bids WHERE auction_id = :aucid AND user_id = :usrid ORDER BY max_by_acre DESC LIMIT 1');
        $this->db->bind('aucid', $aucitonID);
        $this->db->bind(':usrid', $userID);

        $row = $this->db->single();

        if($amount == $row->max_by_acre)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getTheFirstMaxBidder($amount, $auctionID)
    {
        $this->db->query('SELECT user_id FROM auction_max_bids WHERE auction_id = :aid AND max_by_acre = :amount ORDER BY max_date ASC LIMIT 1');
        $this->db->bind(':aid', $auctionID);
        $this->db->bind(':amount', $amount);

        $row = $this->db->single();

        return $row;
    }

    public function isHighestMultiple($id, $amount, $auctionID)
    {
        $this->db->query('SELECT user_id FROM auction_max_bids WHERE auction_id = :aid AND max_by_acre = :amount ORDER BY max_date ASC LIMIT 1');
        $this->db->bind(':aid', $auctionID);
        $this->db->bind(':amount', $amount);

        $row = $this->db->single();

        if($row->user_id == $id)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function maxBidCount($id, $nextBid)
    {
        $this->db->query('SELECT DISTINCT max_by_acre FROM auction_max_bids WHERE auction_id = :id AND max_by_acre >= :nb');
        $this->db->bind(':id', $id);
        $this->db->bind(':nb', $nextBid);

        $row = $this->db->single();

        if($this->db->rowCount() == 1)
        {
            if($this->isMultipleMax($id, $row->max_by_acre) == true)
            {
                return false;
            }
            else
            {
                return true;
            }

        }
        elseif ($this->db->rowCount() == 0)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function isMultipleMax($id, $mxamount)
    {
        $this->db->query('SELECT max_by_acre FROM auction_max_bids WHERE auction_id = :id AND max_by_acre = :nb');
        $this->db->bind(':id', $id);
        $this->db->bind(':nb', $mxamount);

        $row = $this->db->single();

        if($this->db->rowCount() > 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getUsersMaxBid($userID)
    {
        $this->db->query('SELECT MAX(max_by_acre) AS max_bid FROM auction_max_bids WHERE user_id = :id');
        $this->db->bind(':id', $userID);

        $row = $this->db->single();

        return $row;

    }

    public function checkHighBidLoop($id,$highBid)
    {
        $this->db->query('SELECT bid_by_acre,user_id FROM auction_bids WHERE auction_id = :id AND bid_by_acre > :bba ORDER BY bid_by_acre DESC LIMIT 1');
        $this->db->bind(':id', $id);
        $this->db->bind(':bba', $highBid + 25);
        $row = $this->db->single();

        return $row;
    }


    public function getHighestCurrantBid($id)
    {
        $this->db->query('SELECT bid_by_acre,user_id FROM auction_bids WHERE auction_id = :id  ORDER BY bid_by_acre DESC LIMIT 1');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;

    }

    public function getMaxBidsByAcre($id, $highBid)
    {
        $this->db->query('SELECT max_bid_id,user_id,max_by_acre FROM auction_max_bids WHERE auction_id = :id AND max_by_acre > :hb ORDER BY max_by_acre ASC, max_date DESC');
        $this->db->bind(':id', $id);
        $this->db->bind(':hb', $highBid);
        $results = $this->db->resultSet();

        return $results;

    }

    public function addBid($listingID, $userID, $pricePerAcre, $newBid, $bidType)
    {
        //$this->insertError('In Add bid');
        $now = new DateTime(null, new DateTimeZone('America/Chicago'));
        //$now->setTimezone('America/Chicago');
        $this->db->query('INSERT INTO auction_bids(auction_id,user_id,bid_by_acre,bid_amount,bid_date,bid_type_id) VALUES(:actid,:usrid,:byacre,:bdamt,:bdt,:btype)');
        $this->db->bind(':actid', $listingID);
        $this->db->bind(':usrid', $userID);
        $this->db->bind(':byacre', $pricePerAcre);
        $this->db->bind(':bdamt', $newBid);
        $this->db->bind(':bdt', $now->format('Y-m-d H:i:s'));
        $this->db->bind(':btype', $bidType);

        $this->db->execute();
    }

    public function insertMaxBid($data)
    {
        $this->db->query('INSERT INTO auction_max_bids(user_id,auction_id,max_amount) VALUES(:usr,:autid,:mamount)');
        $this->db->bind(':usr', $data['userID']);
        $this->db->bind(':autid', $data['AuctionID']);
        $this->db->bind(':mamount', $data['MaxBid']);

        $this->db->execute();
    }

    public function settingMaxBidByAcre($AuctionID)
    {
        $max_bid_setting = $this->getHighestMaxBid($AuctionID)->by_acre;
        $this->db->query('SELECT amount FROM auction_by_acre_amounts WHERE amount > :amnt');
        $this->db->bind(':amnt', $max_bid_setting);

        $results = $this->db->resultSet();
        return $results;
    }

    public function getHighestMaxBid($id)
    {
        $this->db->query('SELECT COALESCE(max(bid_by_acre),0) AS by_acre FROM auction_bids WHERE auction_id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function insertMaxBidByAcre($data)
    {
        $this->db->query('INSERT INTO auction_max_bids(user_id,auction_id,max_by_acre,max_amount) VALUES(:usr,:acid,:byacre,:mxamount)');
        $this->db->bind(':usr', $data['UserID']);
        $this->db->bind(':acid', $data['AuctionID']);
        $this->db->bind(':byacre', $data['MaxAmount']);
        $this->db->bind(':mxamount', $data['MaxAmount'] * $data['totalAcres']);

        $this->db->execute();
    }

    public function GetAuctionEmails($autionID, $userid)
    {
        $this->db->query('SELECT DISTINCT usrs.email_address 
                                   FROM auction_bids ab 
                                   INNER JOIN users usrs ON usrs.user_id = ab.user_id 
                                   WHERE ab.auction_id = :aid AND ab.user_id NOT IN(:usid)');
        $this->db->bind(':aid', $autionID);
        $this->db->bind(':usid', $userid);

        $results = $this->db->resultSet();

        return $results;
    }

    public function insertError($error)
    {
        $this->db->query('INSERT INTO error_log(error_text) VALUES(:etext)');
        $this->db->bind(':etext', $error);

        $this->db->execute();
    }

}