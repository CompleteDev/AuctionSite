<?php
/**
 * Created by PhpStorm.
 * User: mike.richardson
 * Date: 2/18/2019
 * Time: 8:07 AM
 */
    class Users_Interactions extends Controller
    {
        public function __construct()
        {
            $this->userModel = $this->model('User');
            $this->interactMDL = $this->model('User_InteractionMDL');
            $this->send_messaging = $this->model('Messaging');
            $this->oShared = $this->model('SharedMDL');
        }
        public function addToWatchList()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $listingID = $_POST['ListingID'];
                $userID = $_POST['UserID'];
                $data =
                    [
                        'listingID' => $listingID,
                        'userID' => $userID,
                    ];
                $this->interactMDL->addToUserWatchList($data);
            }
        }
        public  function isWatching()
        {
        }
        public function SetMaxBid()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $auctionid = $_POST['AuctionID'];
                $userID = $_POST['UserID'];
                $MaxBid = $_POST['MaxBidAmount'];
                $data =
                    [
                        'AuctionID' => $auctionid,
                        'userID' => $userID,
                        'MaxBid' => $MaxBid,
                    ];
                $this->interactMDL->insertMaxBid($data);
            }
        }
        public function setMaxBidByAcre()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $AuctionID = trim($_POST['AuctionID']);
                $results = $this->interactMDL->settingMaxBidByAcre($AuctionID);

                echo json_encode($results);
            }
        }
        public function setUserMaxBidByAcre()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $AuctionID = trim($_POST['AuctionID']);
                $MaxAmount = $_POST['MaxAmount'];
                $UserID = $_POST['UserID'];
                $totalAcres = $_POST['totalAcres'];
                $data =
                    [
                       'AuctionID' => $AuctionID,
                        'MaxAmount' => $MaxAmount,
                        'UserID' => $UserID,
                        'totalAcres' => $totalAcres,
                    ];

                $this->interactMDL->insertMaxBidByAcre($data);
                $this->interactMDL->placeAutoBids($data);
                $this->interactMDL->placeMaxBids($AuctionID, $totalAcres);
                $this->send_messaging->insertEmail('New Bid - No Reply','andrea.landmarketers@gmail.com','info@landmarketers.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/pages/auctionListing/' . $AuctionID);
                //$this->send_messaging->SendEmail('New Bid - TEST!!!','andrea.landmarketers@gmail.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/pages/auctionListing/' . $listingID);
                //$this->send_messaging->SendSMS('New Bid', '4026400582@email.uscc.net', 'SMS Test!');
                $this->SendAuctionNotifications($AuctionID, $UserID);
            }
        }
        public  function placeBid()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $listingID = $_POST['ListingID'];
                $userID = $_POST['UserID'];
                $newBid = $_POST['newBid'];
                $pricePerAcre = trim($_POST['pricePerAcre']);
                $totalAcres = trim($_POST['totalAcres']);
                $data =
                    [
                        'ListingID' => $listingID,
                        'userID' => $userID,
                        'newBid' => $newBid,
                        'pricePerAcre' => $pricePerAcre,
                    ];
                if($this->interactMDL->doesBidExist($data))
                {
                    $results = ['reply' => 'Exists'];
                    echo json_encode($results);
                }
                else
                {
                    $this->interactMDL->addBid($listingID,$userID,$pricePerAcre,$newBid,1);
                    $this->interactMDL->placeMaxBids($listingID, $totalAcres);
                    $this->send_messaging->insertEmail('New Bid - No Reply','andrea.landmarketers@gmail.com','info@landmarketers.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/pages/auctionListing/' . $listingID);
                    $this->send_messaging->insertEmail('New Bid - No Reply','landmarketers@gmail.com','info@landmarketers.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/pages/auctionListing/' . $listingID);
                    //$this->send_messaging->SendEmail('New Bid - TEST!!!','andrea.landmarketers@gmail.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/pages/auctionListing/' . $listingID);
                    //$this->send_messaging->SendSMS('3089401698@vtext.com', 'SMS Test!');
                    $this->SendAuctionNotifications($listingID, $userID);
                    $results = ['reply' => 'Good'];
                    echo json_encode($results);
                }
            }
        }
        public function SendAuctionNotifications($id, $userid)
        {
            $usrnotify = $this->interactMDL->GetAuctionEmails($id, $userid);
            foreach($usrnotify as $usrNotify)
            {
                $this->send_messaging->insertEmail('New Bid - No Reply',$usrNotify->email_address,'info@landmarketers.com', 'There has been a new bid on'  . "\r\n"  . 'https://www.landmarketers.com/pages/auctionListing/' . $id . "\r\n" . 'Thank You' . "\r\n" . 'LandMarketers.com');
                //$this->send_messaging->SendEmail('New Bid - NO REPLY', $usrNotify->email_address, 'There has been a new bid on an auction you are interested in' . "\r\n"  . 'https://www.landmarketers.com/pages/auctionListing/' . $id . "\r\n" . 'Thank You' . "\r\n" . 'LandMarketers.com');
            }
        }
    }