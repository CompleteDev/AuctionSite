<?php

class MPAuctionMDL
{
    private $db;



    public function __construct()

    {

        $this->db = new Database;

    }

    public function GettingMinBid($PID)
    {
        $this->db->query('SELECT COALESCE(MAX(amb.bid_amount),psb.parcel_starting_bid) AS bid_amount,mpi.parcel_increment,pct.parcel_type,
                                   pca.parcel_acres,COALESCE(amb.bid_by_acre,0) AS byacre,psb.parcel_starting_bid  
                                   FROM auction_mp_parcel_startbid psb  
                                   LEFT JOIN auction_mp_bids amb ON amb.parcel_id = psb.parcel_id AND amb.bid_id = (SELECT bid_id FROM auction_mp_bids WHERE parcel_id = psb.parcel_id ORDER BY bid_id DESC LIMIT 1) 
                                   INNER JOIN auction_mp_parcel_incr mpi ON mpi.parcel_id = psb.parcel_id 
                                   INNER JOIN auction_mp_parcel_type pct ON pct.parcel_id = psb.parcel_id 
                                   INNER JOIN auction_mp_parcel_acre pca ON pca.parcel_id = psb.parcel_id
                                   WHERE psb.parcel_id = :pid 
                                   GROUP BY psb.parcel_starting_bid,mpi.parcel_increment,pct.parcel_type,pca.parcel_acres,byacre');
        $this->db->bind(':pid', $PID);

        $row = $this->db->single();

        return $row;
    }

    public function GetWinner($PID)
    {
    	$this->db->query('SELECT usr.first_name,usr.last_name,mpb.user_id 
    	                      FROM auction_mp_bids mpb 
    	                      INNER JOIN users usr ON usr.user_id = mpb.user_id 
    	                      WHERE mpb.parcel_id = :pid ORDER BY mpb.bid_id DESC LIMIT 1');
    	$this->db->bind(':pid', $PID);

    	return $this->db->single();
    }

    public function GetStartEnd($MPID)
    {
        $this->db->query('SELECT start_end_id,mp_id,start_date,start_time,end_date,end_time FROM auction_mp_start_end WHERE mp_id = :mpid');
        $this->db->bind(':mpid', $MPID);

        return $this->db->single();
    }

    public function isAuctionComplete($MPID)
    {
        $this->db->query('SELECT mp_completed FROM auction_mp_master WHERE mp_id = :mpid');
        $this->db->bind(':mpid', $MPID);

        return $this->db->single();
    }

    public function CheckBid($PID,$BidAmount)
    {
    	$this->db->query('SELECT bid_id FROM auction_mp_bids WHERE parcel_id = :pid AND bid_amount = :bamn');
    	$this->db->bind(':pid', $PID);
    	$this->db->bind(':bamn', $BidAmount);

	    $row = $this->db->single();

	    if($this->db->rowCount() > 0)
	    {
		    return 1;
	    }
	    else
	    {
		    return 0;
	    }
    }

    public function PlaceNewBid($PID,$UserID,$ByAcre,$BidAmount,$BidType)
    {
    	$this->db->query('INSERT INTO auction_mp_bids(parcel_id,user_id,bid_by_acre,bid_amount,bid_type_id) VALUES(:pid,:usr,:bya,:amnt,:btype)');
    	$this->db->bind(':pid', $PID);
    	$this->db->bind(':usr', $UserID);
    	$this->db->bind(':bya', $ByAcre);
    	$this->db->bind(':amnt', $BidAmount);
    	$this->db->bind(':btype', $BidType);
    	$this->db->execute();
    }

	public function insertError($error)
	{
		$this->db->query('INSERT INTO error_log(error_text) VALUES(:etext)');
		$this->db->bind(':etext', $error);

		$this->db->execute();
	}

	public function GetCurrentWinner($PID)
	{
		$this->db->query('SELECT bid_amount,bid_by_acre,user_id FROM auction_mp_bids WHERE parcel_id = :pid ORDER BY bid_id DESC LIMIT 1');
		$this->db->bind(':pid', $PID);

		$row = $this->db->single();

		if($this->db->rowCount() > 0)
		{
			return $row->user_id;
		}
		else
		{
			return 0;
		}
	}

    public function PlaceByAcreAutoBids($PID,$totalAcres)
    {
	    $loop = true;
	    while($loop == true)
	    {
		    foreach($this->getMaxBids($PID, $this->getHighestCurrantBid($PID)->bid_by_acre) as $mxinfo)
		    {
			    //place bid using next_bid
			    if($this->getHighestCurrantBid($PID)->user_id != $mxinfo->user_id)
			    {
				    $next_bid = $this->getHighestCurrantBid($PID)->bid_by_acre + 25;
				    //Add Check to see if bid amount exists make sure can't go over max amount set
				    if($this->getUsersMaxBid($mxinfo->user_id)->max_bid >= $next_bid)
				    {
					    //function to see if there are multiple matching bids and if the current bidder in the loop is the oldest bid then place bid
					    if($this->isUsersMaxBid($mxinfo->user_id,$next_bid,$PID) == true)
					    {
						    //Are there more than 1 of the same
						    if($this->isThereMoreThanOne($PID,$next_bid) == true)
						    {
							    //Here need to make sure they are the 1st to place Max Bid
							    if($this->isHighestMultiple($mxinfo->user_id, $next_bid, $PID) == true)
							    {
								    $this->PlaceNewBid($PID,$mxinfo->user_id, $next_bid, $next_bid * $totalAcres, 2);
							    }
							    else
							    {
								    // We will have the 1st bidder place the bid
								    //Get the userID
								    $FirstMaxBidderID = $this->getTheFirstMaxBidder($next_bid,$PID)->user_id;
								    $this->PlaceNewBid($PID,$FirstMaxBidderID,$next_bid, $next_bid * $totalAcres, 3);
							    }
						    }
						    else
						    {
							    $this->PlaceNewBid($PID,$mxinfo->user_id, $next_bid, $next_bid * $totalAcres, 2);
						    }

					    }
					    else
					    {
						    $this->PlaceNewBid($PID,$mxinfo->user_id, $next_bid, $next_bid * $totalAcres, 2);
					    }


				    }

			    }
		    }
		    if($this->maxBidCount($PID, $this->getHighestCurrantBid($PID)->bid_by_acre + 25) == true)
		    {
			    //Check to see if time to end loop
			    $loop = false;
		    }
	    }
    }

	public function PlaceByPriceAutoBids($PID,$Increment)
	{
		$HighBidInfo = $this->getHighestCurrantBid($PID);;
		$MaxBidInfo = $this->GetMaxByPriceBids($PID,$HighBidInfo->bid_amount);
		try
		{
			foreach($MaxBidInfo as $maxByPriceBid)
			{
				if($maxByPriceBid->user_id != $HighBidInfo->user_id)
				{
					$this->PlaceNewBid($PID,$maxByPriceBid->user_id,0,$HighBidInfo->bid_amount + $Increment,2);
				}
			}
		}
		catch (exception $e)
		{
			$this->insertError($e);
		}

	}

	public function SetMaxAcreIncr($PID)
	{
		$CurrentHighBid = $this->GetHighBidForAcre($PID);
		$Incr = $this->GetParcelIncrement($PID);
		$this->db->query('SELECT amount FROM auction_by_acre_amounts WHERE amount > :amnt');
		$this->db->bind(':amnt', $CurrentHighBid + $Incr);

		$results = $this->db->resultSet();
		return $results;
	}

	public function GetParcelIncrement($PID)
	{
		$this->db->query('SELECT parcel_id,parcel_increment FROM auction_mp_parcel_incr WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);
		$results = $this->db->single();
		if ($this->db->rowCount() > 0)
		{
			return $results;
		}
		else
		{
			return 0;
		}
	}

	public function GetHighBidForMaxAcre($PID)
	{
		$this->db->query('SELECT bid_amount,bid_by_acre,user_id FROM auction_mp_bids WHERE parcel_id = :pid ORDER BY bid_id DESC LIMIT 1');
		$this->db->bind(':pid', $PID);

		$row = $this->db->single();

		if($this->db->rowCount() > 0)
		{
			return $row->bid_by_acre;
		}
		else
		{
			return 0;
		}
	}

	public function GetHighBidForAcre($PID)
	{
		$this->db->query('SELECT bid_amount,bid_by_acre,user_id FROM auction_mp_bids WHERE parcel_id = :pid ORDER BY bid_id DESC LIMIT 1');
		$this->db->bind(':pid', $PID);

		$row = $this->db->single();

		if($this->db->rowCount() > 0)
		{
			return $row->bid_by_acre;
		}
		else
		{
			return $this->GetStartingBid($PID)->parcel_starting_bid;
		}
	}

	public function GetStartingBid($PID)
	{
		$this->db->query('SELECT parcel_starting_bid FROM auction_mp_parcel_startbid WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);

		return $this->db->single();
	}

	public function GetHighBidForPrice($PID)
	{
		$this->db->query('SELECT bid_amount,bid_by_acre,user_id FROM auction_mp_bids WHERE parcel_id = :pid ORDER BY bid_id DESC LIMIT 1');
		$this->db->bind(':pid', $PID);
		$row = $this->db->single();

		if($this->db->rowCount() > 0)
		{
			return $row->bid_amount;
		}
		else
		{
			return $this->GetStartingBid($PID)->parcel_starting_bid;
		}
	}

	public function InsertMaxBid($UserID,$PID,$ByAcre,$MaxPrice)
	{
		$this->db->query('INSERT INTO auction_mp_max_bids(user_id,parcel_id,max_by_acre,max_amount) VALUES(:usr,:pid,:byacre,:amnt)');
		$this->db->bind(':usr', $UserID);
		$this->db->bind(':pid', $PID);
		$this->db->bind(':byacre', $ByAcre);
		$this->db->bind(':amnt', $MaxPrice);

		$this->db->execute();
	}

	public function GetMaxByPriceBids($PID,$HighBid)
	{
		$this->db->query('SELECT user_id,max_by_acre,max_amount FROM auction_mp_max_bids WHERE parcel_id = :pid AND max_amount > :highbid ORDER BY max_by_acre ASC, max_date DESC');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':highbid', $HighBid);

		return $this->db->resultSet();
	}

    public function getMaxBids($PID, $HighBid)
    {
    	$this->db->query('SELECT user_id,max_by_acre,max_amount FROM auction_mp_max_bids WHERE parcel_id = :pid AND max_by_acre > :highbid ORDER BY max_by_acre ASC, max_date DESC');
    	$this->db->bind(':pid', $PID);
    	$this->db->bind(':highbid', $HighBid);

    	return $this->db->resultSet();
    }

    public function getHighestCurrantBid($PID)
    {
    	$this->db->query('SELECT bid_amount,bid_by_acre,user_id FROM auction_mp_bids WHERE parcel_id = :pid ORDER BY bid_id DESC LIMIT 1');
    	$this->db->bind(':pid', $PID);

    	return $this->db->single();
    }

    public function getUsersMaxBid($UserID)
    {
    	$this->db->query('SELECT MAX(max_by_acre) AS max_bid FROM auction_mp_max_bids WHERE user_id = :usr');
    	$this->db->bind(':usr', $UserID);

    	return $this->db->single();
    }

	public function isThereMoreThanOne($PID, $amount)
	{
		$this->db->query('SELECT max_bid_id FROM auction_mp_max_bids WHERE parcel_id = :pid AND max_by_acre = :amount');
		$this->db->bind(':pid', $PID);
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

	public function isHighestMultiple($id, $amount, $PID)
	{
		$this->db->query('SELECT user_id FROM auction_mp_max_bids WHERE parcel_id = :pid AND max_by_acre = :amount ORDER BY max_date ASC LIMIT 1');
		$this->db->bind(':pid', $PID);
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

	public function isUsersMaxBid($UserID, $amount, $PID)
	{
		$this->db->query('SELECT max_by_acre FROM auction_mp_max_bids WHERE parcel_id = :pid AND user_id = :usr ORDER BY max_by_acre DESC LIMIT 1');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':usr', $UserID);

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

	public function getTheFirstMaxBidder($amount, $PID)
	{
		$this->db->query('SELECT user_id FROM auction_mp_max_bids WHERE parcel_id = :pid AND max_by_acre = :amount ORDER BY max_date ASC LIMIT 1');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':amount', $amount);

		$row = $this->db->single();

		return $row;
	}

	public function maxBidCount($PID, $nextBid)
	{
		$this->db->query('SELECT DISTINCT max_by_acre FROM auction_mp_max_bids WHERE parcel_id = :pid AND max_by_acre >= :nb');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':nb', $nextBid);

		$row = $this->db->single();

		if($this->db->rowCount() == 1)
		{
			if($this->isMultipleMax($PID, $row->max_by_acre) == true)
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

	public function isMultipleMax($PID, $mxamount)
	{
		$this->db->query('SELECT max_by_acre FROM auction_mp_max_bids WHERE parcel_id = :pid AND max_by_acre = :nb');
		$this->db->bind(':pid', $PID);
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

	public function UpdateAuctionEndTime($MPID,$EndDate,$EndTime)
	{
		$this->db->query('UPDATE auction_mp_start_end SET end_date = :edate, end_time = :etime WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':edate', $EndDate);
		$this->db->bind(':etime', $EndTime);

		$this->db->execute();
	}

	public function EndAuction($MPID)
	{
		$this->db->query('UPDATE auction_mp_master SET mp_completed = 1 WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);

		$this->db->execute();
	}

	public function GetLastBidTime($MPID)
	{
		$this->db->query('SELECT bid_date FROM auction_mp_bids WHERE parcel_id IN (SELECT parcel_id FROM auction_mp_parcel_main WHERE mp_id = :mpid) ORDER BY bid_date DESC LIMIT 1');
		$this->db->bind(':mpid', $MPID);
		$row = $this->db->single();
		if($this->db->rowCount() > 0)
		{
			return $row;
		}
		else
		{
			return 0;
		}
	}

	public function GetGridInfo($MPID,$UserID)
	{
		$this->db->query('SELECT pmn.mp_id,pmn.parcel_title,mpi.parcel_img_name,pmn.parcel_id,COALESCE(acb.bid_amount,sbd.parcel_starting_bid) AS CurrentBid,sbd.parcel_starting_bid,
                              COALESCE(CONCAT(usr.first_name," " ,usr.last_name),"None") AS UserName,usr.user_id,api.parcel_increment,COALESCE(bnum.bid_number,"None") AS BidNum,
                              COALESCE(acb.bid_by_acre,0) AS byacre,pct.parcel_type,pca.parcel_acres,COALESCE(mbd.max_amount,"None") AS maxbids,COALESCE(mbd.user_id,"None") AS maxuser,COALESCE(mbd.max_by_acre,"None") AS maxacre 
		                      FROM auction_mp_parcel_main pmn 
		                      INNER JOIN auction_mp_parcel_imgs mpi ON mpi.parcel_id = pmn.parcel_id AND mpi.parcel_img_order = 1 
		                      LEFT JOIN auction_mp_bids acb ON acb.parcel_id = pmn.parcel_id AND acb.bid_id = (SELECT bid_id FROM auction_mp_bids WHERE parcel_id = pmn.parcel_id ORDER BY bid_id DESC LIMIT 1) 
		                      INNER JOIN auction_mp_parcel_startbid sbd ON sbd.parcel_id = pmn.parcel_id 
		                      INNER JOIN auction_mp_parcel_incr api ON api.parcel_id = pmn.parcel_id
		                      INNER JOIN auction_mp_parcel_type pct ON pct.parcel_id = pmn.parcel_id
                              INNER JOIN auction_mp_parcel_acre pca ON pca.parcel_id = pmn.parcel_id
		                      LEFT JOIN users usr ON usr.user_id = acb.user_id 
                              LEFT JOIN user_bid_number bnum ON bnum.user_id = usr.user_id 
                              LEFT JOIN auction_mp_max_bids mbd ON mbd.parcel_id = pmn.parcel_id AND mbd.max_bid_id = (SELECT max_bid_id FROM landmark_supergroovycms_db.auction_mp_max_bids WHERE parcel_id = pmn.parcel_id AND user_id = :usr ORDER BY max_bid_id DESC LIMIT 1)
		                      WHERE pmn.mp_id = :mpid ORDER BY pmn.parcel_id ASC');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':usr', $UserID);
		return $this->db->resultSet();
	}

	public function GetAuctionEmails($PID, $userid)
	{
		$this->db->query('SELECT DISTINCT usrs.email_address 
                                   FROM auction_mp_bids ab 
                                   INNER JOIN users usrs ON usrs.user_id = ab.user_id 
                                   WHERE ab.parcel_id = :pid AND ab.user_id NOT IN(:usid)');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':usid', $userid);

		$results = $this->db->resultSet();

		return $results;
	}



}