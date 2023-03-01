<?php

class MPAuction extends Controller
{
    public function __construct()

    {

        $this->adminModel = $this->model('AdminMDL');
        $this->oShared = $this->model('SharedMDL');
        $this->oMPMDL = $this->model('MPAuctionMDL');
        $this->oAdminMP = $this->model('AdminMPMDL');
	    $this->send_messaging = $this->model('Messaging');
    }

    public function getTheMinBid()

    {

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $PID = $_POST['PID'];
	        $results = $this->oMPMDL->GettingMinBid($PID);
            echo json_encode($results);

        }
    }

    public function GetWinner()
    {
	    if($_SERVER['REQUEST_METHOD'] == 'POST')
	    {
		    $PID = $_POST['PID'];
		    $results = $this->oMPMDL->GetWinner($PID);

		    echo json_encode($results);

	    }
    }

    public function GetStartEnd()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $PID = $_POST['PID'];
            $MPID =  $this->oAdminMP->GetMPID($PID)->mp_id;

            $results = $this->oMPMDL->GetStartEnd($MPID);

            echo json_encode($results);

        }
    }

    public function GetEndDate()

    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $PID = $_POST['PID'];
            $MPID =  $this->oAdminMP->GetMPID($PID)->mp_id;

            $results = $this->oMPMDL->GetStartEnd($MPID);

            echo json_encode($results);
        }

    }

    public function GetEndDateMP()
    {
	    if($_SERVER['REQUEST_METHOD'] == 'POST')
	    {
		    $MPID = $_POST['MPID'];
		    $results = $this->oMPMDL->GetStartEnd($MPID);

		    echo json_encode($results);
	    }
    }

    public function GetAuctionStatus()

    {

        if($_SERVER['REQUEST_METHOD'] == 'POST')

        {
            $PID = $_POST['PID'];
            $MPID =  $this->oAdminMP->GetMPID($PID)->mp_id;

            $results = $this->oMPMDL->isAuctionComplete($MPID);

            echo json_encode($results);
        }

    }

    public function GetAuctionStatusMP()
    {
	    if($_SERVER['REQUEST_METHOD'] == 'POST')

	    {
		    $MPID = $_POST['MPID'];
		    $results = $this->oMPMDL->isAuctionComplete($MPID);

		    echo json_encode($results);
	    }
    }

    public function PlaceNewBid()
    {
	    if($_SERVER['REQUEST_METHOD'] == 'POST')
	    {
		    $PID = $_POST['PID'];
		    $NextBid = $_POST['NextBid'];
		    $UserID = $_POST['SessionID'];
		    $ByAcre = $_POST['BidIncr'];
		    $NextBid = str_replace('$','', $NextBid);
		    $NextBid = str_replace(',', '', $NextBid);
		    $this->oShared->insertError($NextBid);
		    if($this->oAdminMP->CheckBid == 0)
		    {
		    	//$this->oMPMDL->PlaceNewBid($PID,$UserID,$ByAcre,$TotalPrice,1);

		    	if($this->oAdminMP->GetParcelAuctionType($PID)->parcel_type == 1)
			    {
				    $TotalAcres = $this->oAdminMP->GetParcelAcres($PID)->parcel_acres;
				    $TotalPrice = $NextBid * $TotalAcres;
				    $this->oMPMDL->PlaceNewBid($PID,$UserID,$NextBid,$TotalPrice,1);
				    $this->oMPMDL->PlaceByAcreAutoBids($PID,$TotalAcres);
			    }
			    else
			    {
			    	$Increment = $this->oAdminMP->GetParcelIncrement($PID)->parcel_increment;
				    $this->oMPMDL->PlaceNewBid($PID,$UserID,$ByAcre,$NextBid,1);
			    	$this->oMPMDL->PlaceByPriceAutoBids($PID,$Increment);
			    }
			    $this->send_messaging->insertEmail('New Bid - No Reply','andrea.landmarketers@gmail.com','info@landmarketers.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/Pages/mpacutionpage/' . $PID);
			    $this->send_messaging->insertEmail('New Bid - No Reply','landmarketers@gmail.com','info@landmarketers.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/Pages/mpacutionpage/' . $PID);
			    $this->SendAuctionNotifications($PID,$UserID);

			    $results = ['results' => 'Done'];
			    echo json_encode($results);
		    }
		    else
		    {
			    $results = ['results' => 'Exists'];
			    echo json_encode($results);
		    }

	    }
    }

	public function SendAuctionNotifications($PID, $userid)
	{
		$usrnotify = $this->oMPMDL->GetAuctionEmails($PID, $userid);
		foreach($usrnotify as $usrNotify)
		{
			$this->send_messaging->insertEmail('New Bid - No Reply',$usrNotify->email_address,'info@landmarketers.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/Pages/mpacutionpage/' . $PID . "\r\n" . 'Thank You' . "\r\n" . 'LandMarketers.com');
		}
	}

    public function InsertMaxBids()
    {
	    $PID = $_POST['PID'];
	    $BidAmount = $_POST['BidAmount'];
	    $UserID = $_POST['UserID'];
	    $AuctionType = $this->oAdminMP->GetParcelAuctionType($PID)->parcel_type;
	    $CurrentWinner = $this->oMPMDL->GetCurrentWinner($PID);
	    if($AuctionType == 1)
	    {
		    $TotalAcres = $this->oAdminMP->GetParcelAcres($PID)->parcel_acres;
		    $LastByAcre = $this->oMPMDL->GetHighBidForAcre($PID);
		    $BidIncr = $this->oAdminMP->GetParcelIncrement($PID)->parcel_increment;
		    $ByAcre = $LastByAcre + $BidIncr;
		    $Amount = $ByAcre * $TotalAcres;
		    $ByAcreMax = $BidAmount * $TotalAcres;
	    	$this->oMPMDL->InsertMaxBid($UserID,$PID,$BidAmount,$ByAcreMax);
	    	if($CurrentWinner != $UserID)
		    {
			    $this->oMPMDL->PlaceNewBid($PID,$UserID,$ByAcre,$Amount,2);
		    }
		    $results = ['results' => 'Done'];
		    echo json_encode($results);
	    }
	    else
	    {
		    $this->oMPMDL->InsertMaxBid($UserID,$PID,0,$BidAmount);
		    $BidIncr = $this->oAdminMP->GetParcelIncrement($PID)->parcel_increment;
		    $LastBid = $this->oMPMDL->GetHighBidForPrice($PID);
		    if($LastBid == 0)
		    {
		    	$LastBid = $this->oAdminMP->GetStartingBid($PID)->parcel_starting_bid;
		    }
		    $Amount = $LastBid + $BidIncr;
		    if($CurrentWinner != $UserID)
		    {
			    $this->oMPMDL->PlaceNewBid($PID,$UserID,0,$Amount,2);
		    }
		    $results = ['results' => 'Done'];
		    echo json_encode($results);
	    }

    }

    public function SetMaxAcreIncr()
    {
	    $PID = $_POST['PID'];

	    $results = $this->oMPMDL->SetMaxAcreIncr($PID);
	    echo json_encode($results);
    }

    public function SetMaxPriceIncr()
    {
	    $PID = $_POST['PID'];
	    $results = $this->oMPMDL->GettingMinBid($PID);
	    echo json_encode($results);
    }

    public function CheckToEnd()
    {
	    $MPID = $_POST['MPID'];
	    $PID = $_POST['PID'];
	    if($MPID == '')
	    {
		    $MPID =  $this->oAdminMP->GetMPID($PID)->mp_id;
	    }


	    $GetEndDateTime = $this->oAdminMP->GetMPDates($MPID);

	    $EndDateTimeString = $GetEndDateTime->end_date . ' ' . $GetEndDateTime->end_time;
	    $now = new DateTime(null, new DateTimeZone('America/Chicago'));
	    $EndDateTime = new DateTime($EndDateTimeString);
	    $NowDateTime = $now->format('Y-m-d H:i:s');


	    if($NowDateTime >= $EndDateTime->format('Y-m-d H:i:s'))
	    {
		    $GetLastBidDateTime = $this->oMPMDL->GetLastBidTime($MPID)->bid_date;
	    	if($GetLastBidDateTime != 0)
		    {
			    $LastBidDateTime = new DateTime($GetLastBidDateTime);
			    $TimeDif = $now->diff($LastBidDateTime);
			    //$MinSinceLast = ($TimeDif->days * 24 * 60) + ($TimeDif->h * 60) + $TimeDif->i;
			    $SecondsSinceLast = ($TimeDif->i * 60) + $TimeDif->s;
			    if($SecondsSinceLast < 240)
			    {
				    //Update End time 4 min rule
				    $NewDateTime = $LastBidDateTime->modify('+4 minutes');
				    $NewDate = $NewDateTime->format('Y-m-d');
				    $NewTime = $NewDateTime->format('H:i:s');
				    $this->oMPMDL->UpdateAuctionEndTime($MPID,$NewDate,$NewTime);

				    $results = ['results' => '4Min'];
				    echo json_encode($results);
			    }
			    else
			    {
				    //End Auction
				    $this->oMPMDL->EndAuction($MPID);
				    $results = ['results' => 'Ended'];
				    echo json_encode($results);
			    }
		    }
	    	else
		    {
			    //End Auction
			    $this->oMPMDL->EndAuction($MPID);
			    $results = ['results' => 'Ended'];
			    echo json_encode($results);
		    }
	    }
	    else
	    {
		    $results = ['results' => 'NotDone'];
		    echo json_encode($results);
	    }

    }

    public function UpdateAuctionEndTime()
    {
	    $MPID = trim($_POST['MPID']);
	    $NewDate = trim($_POST['LastBidDay']);
	    $NewTime = trim($_POST['LastBidTimeMin']);
	    $PID = $_POST['PID'];
	    if($MPID == '')
	    {
		    $MPID =  $this->oAdminMP->GetMPID($PID)->mp_id;
	    }

	    $this->oMPMDL->UpdateAuctionEndTime($MPID,$NewDate,$NewTime);
	    $results = ['results' => 'Done'];
	    echo json_encode($results);
    }

    public function EndAuction()
    {
	    $MPID = $_POST['MPID'];
	    $PID = $_POST['PID'];
	    if($MPID == '')
	    {
		    $MPID =  $this->oAdminMP->GetMPID($PID)->mp_id;
	    }

	    $this->oMPMDL->EndAuction($MPID);

	    $results = ['results' => 'Done'];
	    echo json_encode($results);
    }

    public function GetLastBidTime()
    {
	    $MPID = $_POST['MPID'];
	    $PID = $_POST['PID'];
	    if($MPID == '')
	    {
		    $MPID =  $this->oAdminMP->GetMPID($PID)->mp_id;
	    }

	    $results = $this->oMPMDL->GetLastBidTime($MPID);
	    if($results == 0)
	    {
		    $results = ['results' => 'None'];
		    echo json_encode($results);
	    }
	    else
	    {
	    	echo json_encode($results);
	    }
    }

	public function GetGridInfo()
	{
		$MPID = $_POST['MPID'];
		$UserID = $_POST['UserID'];
		$results = $this->oMPMDL->GetGridInfo($MPID,$UserID);

		echo json_encode($results);
	}

	public function GetGridInfoForParcelPage()
	{
		$PID = $_POST['PID'];
		$MPID =  $this->oAdminMP->GetMPID($PID)->mp_id;
		$UserID = $_POST['UserID'];
		$results = $this->oMPMDL->GetGridInfo($MPID,$UserID);

		echo json_encode($results);
	}
}