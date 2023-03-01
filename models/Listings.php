<?php

    class Listings
    {

        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function insertMainListingInfo($data)
        {
            $this->db->query('INSERT INTO listings(listing_title,listing_tag_line,listing_city,listing_state,listing_zip,listing_price,total_acres,admin_id,listing_type_id) 
                                   VALUES(:title,:tagline,:city,:state,:zip,:price,:acres,:admin,:lsttype)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':tagline', $data['addinfo']);
            $this->db->bind(':city', $data['city']);
            $this->db->bind(':state', $data['state']);
            $this->db->bind(':zip', $data['zip']);
            $this->db->bind(':price', $data['price']);
            $this->db->bind(':admin', $_SESSION['admin_id']);
            $this->db->bind(':acres', $data['acres']);
            $this->db->bind(':lsttype', $data['listingtype']);

            if($this->db->execute())
            {
                try
                {
                    $lastid = $this->getLastID();
                    $this->insertAdditionalInfo($data,$lastid->listing_id);
                    if($data['yturl'] != '')
                    {
                        $this->InsertVideoURL($lastid->listing_id, $data['yturl']);
                    }
                }
                catch (Exception $e)
                {
                    $this->insertError($e);
                }

            }
            else
            {
                die('Nope!!');
            }

            return $lastid->listing_id;

        }

        public function InsertVideoURL($LastID, $VideoURL)
        {
            $this->db->query('INSERT INTO listing_video(listing_id,video_url) VALUES(:lid,:vurl)');
            $this->db->bind(':lid', $LastID);
            $this->db->bind(':vurl', $VideoURL);

            $this->db->execute();
        }
        public function insertListingTypes($id, $typeID)
        {
            $this->db->query('INSERT INTO listing_categories(listing_id,listing_type_id) VALUES(:id,:typeid)');
            $this->db->bind(':id', $id);
            $this->db->bind(':typeid', $typeID);

            $this->db->execute();
        }

        public function getLastID()
        {

            $this->db->query('SELECT listing_id FROM listings ORDER BY listing_id DESC LIMIT 1');
            if($row = $this->db->single())
            {
                return $row;
            }
            else
            {
                $this->insertError('Did not get ID');
            }


        }

        public  function insertListID($id)
        {
            $this->db->query('INSERT INTO listiid(list_id) VALUES(:lstid)');
            $this->db->bind(':lstid', $id);

            $this->db->execute();
        }
        public  function insertAdditionalInfo($data,$lastid)
        {
            try
            {
                $this->db->query('INSERT INTO listing_info(listing_id,listing_info_text,listing_directions,listing_info_main_image) 
                                       VALUES (:lstid,:info,:direc,:mimg)');
                $this->db->bind(':lstid', $lastid);
                $this->db->bind(':info', $data['description']);
                $this->db->bind(':direc', $data['directions']);
                $this->db->bind(':mimg', $data['primaryimg']);

                $this->db->execute();
            }
            catch (Exception $e)
            {
                $this->insertError($e);
            }


        }

        public function insertError($error)
        {
            $this->db->query('INSERT INTO error_log(error_text) VALUES(:etext)');
            $this->db->bind(':etext', $error);

            $this->db->execute();
        }

        public  function insertAddImages($id,$img_name,$order_by)
        {
            $this->db->query('INSERT INTO listing_images(listing_id,listing_image,order_by) VALUES(:lstid,:img,:ordby)');
            $this->db->bind(':lstid', $id);
            $this->db->bind(':img', $img_name);
            $this->db->bind(':ordby', $order_by);

            $this->db->execute();
        }

        public  function insertAddAuctionImages($id,$img_name,$order_by)
        {
            $this->db->query('INSERT INTO auction_images(auction_id,listing_image,order_by) VALUES(:lstid,:img,:ordby)');
            $this->db->bind(':lstid', $id);
            $this->db->bind(':img', $img_name);
            $this->db->bind(':ordby', $order_by);

            $this->db->execute();
        }

        public function insertBrochure($brochure, $listingID)
        {
            $this->db->query('INSERT INTO listing_brochure(listing_id,brochure_name) VALUES(:listid,:broch)');
            $this->db->bind(':listid', $listingID);
            $this->db->bind(':broch', $brochure);

            $this->db->execute();
        }

        public function insertAuctionBrochure($brochure, $AuctionID)
        {
            $this->db->query('INSERT INTO auction_brochure(auction_id,brochure) VALUES(:id,:broch)');
            $this->db->bind(':id', $AuctionID);
            $this->db->bind(':broch', $brochure);

            $this->db->execute();
        }
        public function setAsFeatured($id,$type)
        {
            $updateType = '';
            switch($type)
            {
                case LiveAuctions:
                    $updateType = 'Featured Auction';
                    break;
                case OnlineAuctions:
                    $updateType = 'Featured Online Auction';
                    break;
                default:
                    $updateType = 'Featured Private Sale';

            }
            $this->db->query('UPDATE main_features SET feature_id = :id WHERE feature_title = :ftype');
            $this->db->bind(':id', $id);
            $this->db->bind(':ftype', $updateType);

            $this->db->execute();
        }

        public  function getListingInfo($id)
        {
            $this->db->query('SELECT lst.listing_id,lst.listing_title,lst.listing_tag_line,lst.listing_city,lst.listing_state,lst.listing_price,lst.total_acres,lst.listing_type_id, 
                                   linf.listing_info_text,linf.listing_directions,linf.listing_info_main_image,lst.listing_zip,sts.State,ltv.video_url 
                                   FROM listings lst
                                   INNER JOIN listing_info linf ON linf.listing_id = lst.listing_id
                                   INNER JOIN listing_states sts ON sts.state_id = lst.listing_state
                                   LEFT JOIN listing_video ltv ON ltv.listing_id = lst.listing_id
                                   WHERE lst.listing_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public  function updateListing($data)
        {
            $this->updateMainListing($data);
            $this->updateAdditionalInfo($data);
            if($data['edit_yturl'] != '')
            {
                if($this->DoesVideoExist($data) == 1)
                {
                    $this->UpdateVideoURL($data);
                }
                else
                {
                    $this->InsertNewVideo($data);
                }
            }
            else
            {
                if($this->DoesVideoExist($data) == 1)
                {
                    $this->DeleteVideoURL($data);
                }
            }
            
        }
        public function DoesVideoExist($data)
        {
            $VidYes = 1;
            $this->db->query('SELECT listing_video_id FROM listing_video WHERE listing_id = :listid');
            $this->db->bind(':listid', $data['listingid']);
            $row = $this->db->single();


            if($this->db->rowCount() == 0)
            {
                $VidYes = 0;
            }

            return $VidYes;
        }

        public function UpdateVideoURL($data)
        {
            $this->db->query('UPDATE listing_video SET video_url = :vidurl WHERE listing_id = :listid');
            $this->db->bind(':listid', $data['listingid']);
            $this->db->bind(':vidurl', $data['edit_yturl']);

            $this->db->execute();
        }
        public function DeleteVideoURL($data)
        {
            $this->db->query('delete from listing_video WHERE listing_id = :listid');
            $this->db->bind(':listid', $data['listingid']);

            $this->db->execute();
        }

        public function InsertNewVideo($data)
        {
            $this->db->query('INSERT INTO listing_video(listing_id,video_url) VALUES(:lid,:vurl)');
            $this->db->bind(':lid', $data['listingid']);
            $this->db->bind(':vurl' , $data['edit_yturl']);

            $this->db->execute();

        }


        public  function updateMainListing($data)
        {
            $this->db->query('UPDATE listings SET listing_title = :title, listing_tag_line = :tag, listing_city = :city, listing_state = :state, listing_zip = :zip, listing_price = :ppacre, total_acres = :acres,
                                   listing_type_id = :typeid WHERE listing_id = :id');
            $this->db->bind(':id', $data['listingid']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':tag', $data['addinfo']);
            $this->db->bind(':city', $data['city']);
            $this->db->bind(':state', $data['state']);
            $this->db->bind(':zip', $data['zip']);
            $this->db->bind(':acres', $data['acres']);
            $this->db->bind(':ppacre', $data['price']);
            $this->db->bind(':typeid', $data['listingtype']);

            $this->db->execute();
        }

        public  function updateAdditionalInfo($data)
        {
            $this->db->query('UPDATE listing_info SET listing_info_text = :txt, listing_directions = :direct WHERE listing_id = :id');
            $this->db->bind(':id', $data['listingid']);
            $this->db->bind(':txt', $data['description']);
            $this->db->bind(':direct', $data['directions']);

            $this->db->execute();
        }

        public function UpdateAuctonMainImage($Image, $AuctionID)
        {
            $this->db->query('UPDATE auction_online SET main_img = :mainimg WHERE online_aucton_id = :auctonid');
            $this->db->bind(':auctonid', $AuctionID);
            $this->db->bind(':mainimg', $Image);

            $this->db->execute();
        }

        public function UpdateListingMainImage($Image, $ListingID)
        {
            $this->db->query('UPDATE listing_info SET listing_info_main_image = :lstimg WHERE listing_id = :lstid');
            $this->db->bind(':lstid', $ListingID);
            $this->db->bind(':lstimg', $Image);

            $this->db->execute();
        }

        public function UpdateMainImage($imgName, $id)
        {
            $this->insertError($imgName . ' ' . $id . 'Is to be uploaded');
            $this->db->query('UPDATE listing_info SET listing_info_main_image = :lstimg  WHERE listing_id = :lstid');
            $this->db->bind(':lstid', $id);
            $this->db->bind(':lstimg', $imgName);
           

            $this->db->execute();
        }

        public function MoveAuctionImage($id, $imageID, $position)
        {
            $imagePos = $this->getAuctionImagePosition($imageID);
            $newPos;
            $otherImage;
            $otherImagePos;
            if($position == 'Down')
            {
                $newPos = $imagePos->order_by + 1;
                $otherImage = $this->getOtherAuctionImageID($id, $newPos);
                $otherImagePos = $this->getAuctionImagePosition($otherImage->auction_image_id);
                $this->MoveTheAuctionImage($imageID, $newPos);
                $this->MoveTheAuctionImage($otherImage->auction_image_id, $otherImagePos->order_by - 1);
            }
            else
            {
                $newPos = $imagePos->order_by - 1;
                $otherImage = $this->getOtherAuctionImageID($id, $newPos);
                $otherImagePos = $this->getAuctionImagePosition($otherImage->auction_image_id);
                $this->MoveTheAuctionImage($imageID, $newPos);
                $this->MoveTheAuctionImage($otherImage->auction_image_id, $otherImagePos->order_by + 1);
            }
        }

        public function getAuctionImagePosition($imageId)
        {
            $this->db->query('SELECT order_by FROM auction_images WHERE auction_image_id = :aiid');
            $this->db->bind(':aiid', $imageId);

            $row = $this->db->single();

            return $row;
        }

        public function getOtherAuctionImageID($id, $position)
        {
            $this->db->query('SELECT auction_image_id FROM auction_images WHERE auction_id = :auid AND order_by = :pos');
            $this->db->bind(':auid', $id);
            $this->db->bind(':pos', $position);

            $row = $this->db->single();

            return $row;
        }

        public  function MoveTheAuctionImage($imageID, $position)
        {
            $this->db->query('UPDATE auction_images SET order_by = :ordr WHERE auction_image_id = :auimgid');
            $this->db->bind(':auimgid', $imageID);
            $this->db->bind(':ordr', $position);

            $this->db->execute();
        }

        public function MoveImage($id, $imageID, $position)
        {
            $imagePos = $this->getImagePosition($imageID);
            $newPos;
            $otherImage;
            $otherImagePos;
            if($position == 'Down')
            {
                $newPos = $imagePos->order_by + 1;
                $otherImage = $this->getOtherImageID($id, $newPos);
                $otherImagePos = $this->getImagePosition($otherImage->listing_image_id);
                $this->MoveTheImage($imageID, $newPos);
                $this->MoveTheImage($otherImage->listing_image_id, $otherImagePos->order_by - 1);

            }
            else
            {
                $newPos = $imagePos->order_by - 1;
                $otherImage = $this->getOtherImageID($id, $newPos);
                $otherImagePos = $this->getImagePosition($otherImage->listing_image_id);
                $this->MoveTheImage($imageID, $newPos);
                $this->MoveTheImage($otherImage->listing_image_id, $otherImagePos->order_by + 1);
            }
        }

        public function getImagePosition($imageID)
        {
            $this->db->query('SELECT order_by FROM listing_images WHERE listing_image_id = :liid');
            $this->db->bind(':liid', $imageID);

            $row = $this->db->single();

            return $row;
        }

        public function getOtherImageID($id, $position)
        {
            $this->db->query('SELECT listing_image_id FROM listing_images WHERE listing_id = :id AND order_by = :ordr');
            $this->db->bind(':id', $id);
            $this->db->bind(':ordr', $position);

            $row = $this->db->single();

            return $row;
        }

        public function MoveTheImage($imageID, $position)
        {
            $this->db->query('UPDATE listing_images SET order_by = :ordr WHERE listing_image_id = :liid');
            $this->db->bind(':liid', $imageID);
            $this->db->bind(':ordr', $position);

            $this->db->execute();
        }

        public function getLastImgOrder($id)
        {

            $imgCount = 0;
            $this->db->query('SELECT MAX(order_by) AS ordr FROM listing_images WHERE listing_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();


            if($this->db->rowCount() > 0)
            {
                $imgCount = $row->ordr;
            }

            return $imgCount;

        }

        public function getLastAuctionImgOrder($id)
        {

            $imgCount = 0;
            $this->db->query('SELECT MAX(order_by) AS ordr FROM auction_images WHERE auction_id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();


            if($this->db->rowCount() > 0)
            {
                $imgCount = $row->ordr;
            }

            return $imgCount;

        }

        public  function UpdateListingPDF($data)
        {
            if($this->isThereAPDF($data) == 0)
            {
                //insert new
                $this->insertNewPDF($data);
            }
            else
            {
                //update
                $this->updatePDF($data);
            }
        }

        public  function UpdateAuctionPDF($data)
        {
            if($this->isThereAnAuctionPDF($data) == 0)
            {
                //insert new
                $this->insertNewAuctionPDF($data);
            }
            else
            {
                //update
                $this->updatePDFAuction($data);
            }
        }

        public function insertNewPDF($data)
        {
            $this->db->query('INSERT INTO listing_brochure(listing_id,brochure_name) VALUES(:id,:broch)');
            $this->db->bind(':id', $data['LisitingID']);
            $this->db->bind(':broch', $data['NewPDF']);

            $this->db->execute();
        }

        public function insertNewAuctionPDF($data)
        {
            $this->db->query('INSERT INTO auction_brochure(auction_id,brochure) VALUES(:id,:broch)');
            $this->db->bind(':id', $data['AuctionID']);
            $this->db->bind(':broch', $data['NewPDF']);

            $this->db->execute();
        }

        public function updatePDFAuction($data)
        {
            $this->db->query('UPDATE auction_brochure SET brochure = :broch WHERE auction_id = :id');
            $this->db->bind(':id', $data['AuctionID']);
            $this->db->bind(':broch', $data['NewPDF']);

            $this->db->execute();
        }

        public function updatePDF($data)
        {
            $this->db->query('UPDATE listing_brochure SET brochure_name = :broch WHERE listing_id = :id');
            $this->db->bind(':id', $data['LisitingID']);
            $this->db->bind(':broch', $data['NewPDF']);

            $this->db->execute();
        }
        public function isThereAPDF($data)
        {
            $PDFCount = 0;
            $this->db->query('SELECT brochure_id FROM listing_brochure WHERE listing_id = :id');
            $this->db->bind(':id', $data['LisitingID']);

            $row = $this->db->single();
            if($this->db->rowCount() > 0)
            {
                $PDFCount = 1;
            }

            return $PDFCount;
        }

        public function isThereAnAuctionPDF($data)
        {
            $PDFCount = 0;
            $this->db->query('SELECT brochure_id FROM auction_brochure WHERE auction_id = :id');
            $this->db->bind(':id', $data['AuctionID']);

            $row = $this->db->single();
            if($this->db->rowCount() > 0)
            {
                $PDFCount = 1;
            }

            return $PDFCount;
        }

        public function HideThisListing($id)
        {
            $this->db->query('UPDATE listings SET hide = 1 WHERE listing_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }

        public function showListing($id)
        {
            $this->db->query('UPDATE listings SET hide = 0 WHERE listing_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }

        public function showAuction($id)
        {
            $this->db->query('UPDATE auction_online SET active = 1 WHERE online_aucton_id = :aucid');
            $this->db->bind(':aucid', $id);

            $this->db->execute();
        }

        public function hideAuction($id)
        {
            $this->db->query('UPDATE auction_online SET active = 0 WHERE online_aucton_id = :aucid');
            $this->db->bind(':aucid', $id);

            $this->db->execute();
        }

        public function MarkSold($id)
        {
            $this->db->query('UPDATE listings SET sold = 1 WHERE listing_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }
        public  function deleteListing($id)
        {
            //$this->deleteAdditionalInfo($id);
            //$this->deleteImages($id);
            //$this->deleteMainInfo($id);
        }

        public function deleteAdditionalInfo($id)
        {
            $this->db->query('DELETE FROM listing_info WHERE listing_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }

        public function deleteImages($id)
        {
            $this->db->query('DELETE FROM listing_images WHERE listing_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }

        public function deleteMainInfo($id)
        {
            $this->db->query('DELETE FROM listings WHERE listing_id = :id');
            $this->db->bind(':id', $id);

            $this->db->execute();
        }

        public function createNewOnlineAuction($data)
        {
            $this->db->query('INSERT INTO auction_online(start_date,start_time,end_date,end_time,starting_bid,listing_title,total_acres,starting_by_acres,bid_increment,listing_short_description,legal_description,title,mineral_etc,leases, 
                                   farm_service_agency_info,property_condition,purchase_agreement,closing_expenses,closing_date,sale_procedure,default_remedies,additional_disclosures,closing,main_img,video_url,by_acre) 
                                   VALUES(:sdt,:stime,:edt,:etime,:bid,:lsttitle,:ttlacres,:strtacres,:bidinc,:shrtdesc,:lgldescr,:ttl,:mineral,:leases,:farm,:prpcond,:agrement,:closingexp,:clsdt,:saleprod,:rem,:disclose,:cls,:mimg,:videours,:byacre)');
            $this->db->bind(':sdt', $data['start_date']);
            $this->db->bind(':stime', $data['start_time'] . ':' . $data['start_min']);
            $this->db->bind(':edt', $data['end_date']);
            $this->db->bind(':etime', $data['end_time'] . ':' . $data['end_min']);
            $this->db->bind(':bid', $data['starting_bid']);
            $this->db->bind(':lsttitle', $data['auction_title']);
            $this->db->bind(':ttlacres', $data['totalAcres']);
            $this->db->bind(':strtacres', $data['StartingPerAcre']);
            $this->db->bind(':bidinc', $data['BidIncrement']);
            $this->db->bind(':shrtdesc', $data['short_desc']);
            $this->db->bind(':lgldescr', $data['legal_description']);
            $this->db->bind(':ttl', $data['legal_title']);
            $this->db->bind(':mineral', $data['auction_Mineral']);
            $this->db->bind(':leases', $data['auction_Leases']);
            $this->db->bind(':farm', $data['auctionFarmServiceAgency']);
            $this->db->bind(':prpcond', $data['auctionPropertyCondition']);
            $this->db->bind(':agrement', $data['auctionPurchaseAgreement']);
            $this->db->bind(':closingexp', $data['auctionClosingExpenses']);
            $this->db->bind(':clsdt', $data['auctionClosingDate']);
            $this->db->bind(':saleprod', $data['auctionSaleProcedure']);
            $this->db->bind(':rem', $data['auctionDefaultRemedies']);
            $this->db->bind(':disclose', $data['auctionAdditionalDisclosures']);
            $this->db->bind(':cls', $data['auctionContactInfo']);
            $this->db->bind(':mimg', $data['imgName']);
            $this->db->bind(':videours', $data['Video_URL']);
            $this->db->bind(':byacre', $data['auctionType']);
            $this->db->execute();

            $lastid = $this->getLastAuctionID();

            return $lastid->online_aucton_id;
        }

        public function updateOnlineAuction($data)
        {
            $this->db->query('UPDATE auction_online SET start_date = :sdt, start_time = :stime, end_date = :edt, end_time = :etime, starting_bid = :bid,
                                  listing_title = :lsttitle, total_acres = :ttlacres, starting_by_acres = :startacre, bid_increment = :bidinc, listing_short_description = :shrtdesc, legal_description = :lgldescr,
                                  title = :ttl, mineral_etc = :mineral, leases = :leases, farm_service_agency_info = :farm, property_condition = :prpcond,
                                  purchase_agreement = :agrement, closing_expenses = :closingexp, closing_date = :clsdt, sale_procedure = :saleprod, 
                                  default_remedies = :rem, additional_disclosures = :disclose, closing = :cls, by_acre = :byacre ,video_url = :videourl
                                  WHERE online_aucton_id = :olid ');
            $this->db->bind(':olid', $data['AuctionID']);
            $this->db->bind(':sdt', $data['start_date']);
            $this->db->bind(':stime', $data['start_time'] . ':' . $data['start_min']);
            $this->db->bind(':edt', $data['end_date']);
            $this->db->bind(':etime', $data['end_time'] . ':' . $data['end_min']);
            $this->db->bind(':bid', $data['starting_bid']);
            $this->db->bind(':lsttitle', $data['auction_title']);
            $this->db->bind(':ttlacres', $data['totalAcres']);
            $this->db->bind(':startacre', $data['StartingBidPerAcre']);
            $this->db->bind(':bidinc', $data['BidIncrement']);
            $this->db->bind(':shrtdesc', $data['short_desc']);
            $this->db->bind(':lgldescr', $data['legal_description']);
            $this->db->bind(':ttl', $data['legal_title']);
            $this->db->bind(':mineral', $data['auction_Mineral']);
            $this->db->bind(':leases', $data['auction_Leases']);
            $this->db->bind(':farm', $data['auctionFarmServiceAgency']);
            $this->db->bind(':prpcond', $data['auctionPropertyCondition']);
            $this->db->bind(':agrement', $data['auctionPurchaseAgreement']);
            $this->db->bind(':closingexp', $data['auctionClosingExpenses']);
            $this->db->bind(':clsdt', $data['auctionClosingDate']);
            $this->db->bind(':saleprod', $data['auctionSaleProcedure']);
            $this->db->bind(':rem', $data['auctionDefaultRemedies']);
            $this->db->bind(':disclose', $data['auctionAdditionalDisclosures']);
            $this->db->bind(':cls', $data['auctionContactInfo']);
            $this->db->bind(':byacre', $data['auctionType']);
            $this->db->bind(':videourl', $data['Video_URL']);
            $this->db->execute();

        }

        public  function getLastAuctionID()
        {
            $this->db->query('SELECT online_aucton_id FROM auction_online ORDER BY online_aucton_id DESC LIMIT 1');
            if($row = $this->db->single())
            {
                return $row;
            }
            else
            {
                $this->insertError('Did not get ID');
            }
        }

        public function insertAuctionImages($lastid,$new_name,$order_by)
        {
            $this->db->query('INSERT INTO auction_images(auction_id,listing_image,order_by) VALUES(:aucid,:lstimg,:ordby)');
            $this->db->bind(':aucid', $lastid);
            $this->db->bind(':lstimg', $new_name);
            $this->db->bind(':ordby', $order_by);

            $this->db->execute();
        }

    }