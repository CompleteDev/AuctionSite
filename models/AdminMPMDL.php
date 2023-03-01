<?php


class AdminMPMDL
{
	private $db;



	public function __construct()

	{

		$this->db = new Database;

	}

	public function GetMPAuctionsList()
	{
		$this->db->query('SELECT mp_id,mp_title,mp_active,mp_completed FROM auction_mp_master');

		return $this->db->resultSet();
	}

	public function GetMPAuctionTitle($MPID)
	{
		$this->db->query('SELECT mp_title FROM auction_mp_master WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);

		return $this->db->single();
	}

	public function UpdateMPTitle($MPID,$NewTitle)
	{
		$this->db->query('UPDATE auction_mp_master SET mp_title = :ttl WHERE mp_id = :mid');
		$this->db->bind(':mid', $MPID);
		$this->db->bind(':ttl', $NewTitle);

		$this->db->execute();
	}

	public function CreateMaster($Title)
	{
		$this->db->query('INSERT INTO auction_mp_master(mp_title) VALUES(:title)');
		$this->db->bind(':title', $Title);

		$this->db->execute();
	}

	public function GetLastMPMasterID()
	{
		$this->db->query('SELECT mp_id FROM auction_mp_master ORDER BY mp_id DESC LIMIT 1');

		return $this->db->single();
	}

	public function InsertTerms($MPID)
	{
		$this->db->query('INSERT INTO auction_mp_terms(mp_id,legal_description,title,mineral_etc,leases,farm_service_agency_info,property_condition,
                              purchase_agreement,closing_expenses,closing_date,sale_procedure,default_remedies,additional_disclosures,closing) 
                              SELECT :mpid,legal_description,title,mineral_etc,leases,farm_service_agency_info,property_condition,purchase_agreement,
                              closing_expenses,closing_date,sale_procedure,default_remedies,additional_disclosures,closing FROM auction_terms');
		$this->db->bind(':mpid', $MPID);

		$this->db->execute();
	}

	public function GetTerms($MPID)
	{
		$this->db->query('SELECT legal_description,title,mineral_etc,leases,farm_service_agency_info,property_condition,
                              purchase_agreement,closing_expenses,closing_date,
		                      sale_procedure,default_remedies,additional_disclosures,closing FROM auction_mp_terms WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);

		return $this->db->single();
	}

	public function UpdateTerms($MPID,$TermType,$TermInfo)
	{
		$strSQL = 'UPDATE auction_mp_terms SET ' . $TermType . ' = :tinfo WHERE mp_id = :mpid';
		$this->db->query($strSQL);
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':tinfo', $TermInfo);

		$this->db->execute();
	}

	public function GetPrimaryImage($MPID)
	{
		$this->db->query('SELECT primary_image_id,image_name FROM auction_mp_primaryimage WHERE mp_master_id = :masterid');
		$this->db->bind(':masterid', $MPID);
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

	public function InsertNewPrimaryImage($MPID,$ImageName)
	{
		$this->db->query('INSERT INTO auction_mp_primaryimage(mp_master_id,image_name) VALUES(:mpid,:imgname)');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':imgname', $ImageName);

		$this->db->execute();
	}

	public function UpdatePrimaryImage($MPID,$ImageName)
	{
		$this->db->query('UPDATE auction_mp_primaryimage SET image_name = :imgname WHERE mp_master_id = :mpid');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':imgname', $ImageName);

		$this->db->execute();
	}

	public function GetPrimaryDescriptions($MPID)
	{
		$this->db->query('SELECT primary_desc FROM auction_mp_primarydesc WHERE mp_master_id = :mpid');
		$this->db->bind(':mpid', $MPID);
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

	public function InsertNewPrimaryDesc($MPID,$PDesc)
	{
		$this->db->query('INSERT INTO auction_mp_primarydesc(mp_master_id,primary_desc) VALUES(:mpid,:pdesc)');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':pdesc', $PDesc);

		$this->db->execute();
	}

	public function UpdatePrimaryDesc($MPID,$PDesc)
	{
		$this->db->query('UPDATE auction_mp_primarydesc SET primary_desc = :pdesc WHERE mp_master_id = :mpid');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':pdesc', $PDesc);

		$this->db->execute();
	}

	public function GetMPPDF($MPID)
	{
		$this->db->query('SELECT mp_pdf_id,mp_pdf FROM auction_mp_pdf WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
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

	public function InsertMPPDF($MPID,$MPPDF)
	{
		$this->db->query('INSERT INTO auction_mp_pdf(mp_id,mp_pdf) VALUES(:mpid,:pdf)');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':pdf', $MPPDF);

		$this->db->execute();
	}

	public function UpdateMPPDF($MPID,$MPPDF)
	{
		$this->db->query('UPDATE auction_mp_pdf SET mp_pdf = :pdf WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':pdf', $MPPDF);

		$this->db->execute();
	}

	public function GetMPVideo($MPID)
	{
		$this->db->query('SELECT mp_video_id,mp_video FROM auction_mp_video WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
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

	public function InsertMPVideo($MPID,$Video)
	{
		$this->db->query('INSERT INTO auction_mp_video(mp_id,mp_video) VALUES(:mpid,:video)');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':video', $Video);

		$this->db->execute();
	}

	public function UpateMPVideo($MPID,$Video)
	{
		$this->db->query('UPDATE auction_mp_video SET mp_video = :video WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':video', $Video);

		$this->db->execute();
	}

	public function GetMPDates($MPID)
	{
		$this->db->query('SELECT mp_id,start_date,start_time,end_date,end_time FROM auction_mp_start_end WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
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

	public function InsertStartEnd($MPID,$StartDate,$StartTime,$EndDate,$EndTime)
	{
		$this->db->query('INSERT INTO auction_mp_start_end(mp_id,start_date,start_time,end_date,end_time) VALUES(:mpid,:sdate,:stime,:edate,:etime)');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':sdate', $StartDate);
		$this->db->bind(':stime', $StartTime);
		$this->db->bind(':edate', $EndDate);
		$this->db->bind(':etime', $EndTime);

		$this->db->execute();
	}

	public function UpdateStartEnd($MPID,$StartDate,$StartTime,$EndDate,$EndTime)
	{
		$this->db->query('UPDATE auction_mp_start_end SET start_date = :sdate,start_time = :stime,end_date = :edate,end_time = :etime WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':sdate', $StartDate);
		$this->db->bind(':stime', $StartTime);
		$this->db->bind(':edate', $EndDate);
		$this->db->bind(':etime', $EndTime);

		$this->db->execute();
	}

	public function GetParcels($MPID)
	{
		$this->db->query('SELECT parcel_id,mp_id,parcel_title,parcel_active FROM auction_mp_parcel_main WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);

		return $this->db->resultSet();
	}

	public function CreateParcel($MPID, $ParcelTitle)
	{
		$this->db->query('INSERT INTO auction_mp_parcel_main(mp_id,parcel_title,parcel_active) VALUES(:mpid,:ptitle,:pactive)');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':ptitle', $ParcelTitle);
		$this->db->bind(':pactive', 0);
		$this->db->execute();
	}

	public function GetMPID($PID)
	{
		$this->db->query('SELECT mp_id FROM auction_mp_parcel_main WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);
		$results = $this->db->single();

		return $results;
	}

	public function GetParcelTitle($PID)
	{
		$this->db->query('SELECT parcel_title FROM auction_mp_parcel_main WHERE parcel_id = :pid');
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

	public function UpdateParcelTitle($PID,$PTitle)
	{
		$this->db->query('UPDATE auction_mp_parcel_main SET parcel_title = :ptitle WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':ptitle', $PTitle);

		$this->db->execute();
	}

	public function GetParcelDescriptions($PID)
	{
		$this->db->query('SELECT parcel_desc FROM auction_mp_parcel_desc WHERE parcel_id = :pid');
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

	public function InsertParcelDesc($PID,$PDesc)
	{
		$this->db->query('INSERT INTO auction_mp_parcel_desc(parcel_id,parcel_desc) VALUES(:pid,:pdesc)');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':pdesc', $PDesc);

		$this->db->execute();
	}

	public function UpdateParcelDesc($PID,$PDesc)
	{
		$this->db->query('UPDATE auction_mp_parcel_desc SET parcel_desc = :pdesc WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':pdesc', $PDesc);

		$this->db->execute();
	}

	public function GetParcelFirstImage($PID)
	{
		$this->db->query('SELECT parcel_img_name FROM landmark_supergroovycms_db.auction_mp_parcel_imgs WHERE parcel_id = :pid ORDER BY parcel_img_order ASC LIMIT 1');
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

	public function GetParcelImages($PID)
	{
		$this->db->query('SELECT parcel_img_id,parcel_id,parcel_img_name,parcel_img_order FROM auction_mp_parcel_imgs WHERE parcel_id = :pid ORDER BY parcel_img_order');
		$this->db->bind(':pid', $PID);

		return $this->db->resultSet();
	}

	public function UpdateImageOrder($data,$id)
	{
		if(array_key_exists("Order", $data))
		{
			foreach($data as $key => $value)
			{

				$updates[] = "$key = $value";
				$this->db->query('UPDATE auction_mp_parcel_imgs SET parcel_img_order = :ordr WHERE parcel_img_id = :id');
				$this->db->bind(':id', $id);
				$this->db->bind(':ordr', $value);
				$this->db->execute();
			}

		}
	}

	public function InsertImage($PID,$ImgName)
	{
		$ImageOrder = $this->GetImageOrder($PID)->imagecount + 1;
		$this->db->query('INSERT INTO auction_mp_parcel_imgs(parcel_id,parcel_img_name,parcel_img_order) VALUES(:pid,:img,:sort)');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':img', $ImgName);
		$this->db->bind(':sort', $ImageOrder);

		$this->db->execute();
	}

	public function GetImageOrder($PID)
	{
		$this->db->query('SELECT COUNT(parcel_img_id) AS imagecount FROM auction_mp_parcel_imgs WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);

		$row = $this->db->single();

		return $row;
	}

	public function DeleteParcelImage($ImgID,$PID)
	{
		$this->db->query('DELETE FROM auction_mp_parcel_imgs WHERE parcel_img_id = :imgid');
		$this->db->bind(':imgid', $ImgID);

		$this->db->execute();

		$this->ReOrderParcelImages($PID);
	}

	public function ReOrderParcelImages($PID)
	{
		$ImgOrder = 1;
		$this->db->query('SELECT parcel_img_id,parcel_img_order FROM auction_mp_parcel_imgs WHERE parcel_id = :pid ORDER BY parcel_img_order ASC');
		$this->db->bind(':pid', $PID);

		$results = $this->db->resultSet();

		foreach ($results as $result)
		{
			$ImgId = $result->parcel_img_id;
			$this->UpdateParcelImgOrder($ImgId,$ImgOrder);
			$ImgOrder = $ImgOrder + 1;
		}
	}

	public function UpdateParcelImgOrder($ImgId,$ImgOrder)
	{
		$this->db->query('UPDATE auction_mp_parcel_imgs SET parcel_img_order = :porder WHERE parcel_img_id = :pimgid');
		$this->db->bind(':pimgid', $ImgId);
		$this->db->bind(':porder', $ImgOrder);

		$this->db->execute();
	}

	public function GetStartingBid($PID)
	{
		$this->db->query('SELECT parcel_startbid_id,parcel_id,parcel_starting_bid FROM landmark_supergroovycms_db.auction_mp_parcel_startbid WHERE parcel_id = :pid');
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

	public function InsertStartingBid($PID,$StartingBid)
	{
		$this->db->query('INSERT INTO auction_mp_parcel_startbid(parcel_id,parcel_starting_bid) VALUES(:pid,:sbid)');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':sbid', $StartingBid);

		$this->db->execute();
	}

	public function UpdateStartingBid($PID,$StartingBid)
	{
		$this->db->query('UPDATE auction_mp_parcel_startbid SET parcel_starting_bid = :sbid WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':sbid', $StartingBid);

		$this->db->execute();
	}

	public function GetParcelAuctionType($PID)
	{
		$this->db->query('SELECT parcel_id,parcel_type FROM auction_mp_parcel_type WHERE parcel_id = :pid');
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

	public function InsertAuctionType($PID,$AuctionTypeID)
	{
		$this->db->query('INSERT INTO auction_mp_parcel_type(parcel_id,parcel_type)  VALUES(:pid,:ptype)');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':ptype', $AuctionTypeID);

		$this->db->execute();
	}

	public function UpdateAuctionType($PID,$AuctionTypeID)
	{
		$this->db->query('UPDATE auction_mp_parcel_type SET parcel_type = :ptype WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':ptype', $AuctionTypeID);

		$this->db->execute();
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

	public function InsertParcelInc($PID,$Incr)
	{
		$this->db->query('INSERT INTO auction_mp_parcel_incr(parcel_id,parcel_increment) VALUES(:pid,:pincr)');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':pincr', $Incr);

		$this->db->execute();
	}

	public function UpdateParcelInc($PID,$Incr)
	{
		$this->db->query('UPDATE auction_mp_parcel_incr SET parcel_increment = :pincr WHERE parcel_id = :pid');
		$this->db->bind(':pid', $PID);
		$this->db->bind(':pincr', $Incr);

		$this->db->execute();
	}

	public function GetParcelAcres($PID)
	{
		$this->db->query('SELECT parcel_acres FROM auction_mp_parcel_acre WHERE parcel_id = :pid');
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

	public function InsertParcelAcre($PID,$Acres)
    {
        $this->db->query('INSERT INTO auction_mp_parcel_acre(parcel_id,parcel_acres) VALUES(:pid,:pacr)');
        $this->db->bind(':pid', $PID);
        $this->db->bind(':pacr', $Acres);

        $this->db->execute();
    }

    public function UpdateParcelAcre($PID,$Acres)
    {
        $this->db->query('UPDATE auction_mp_parcel_acre SET parcel_acres = :pacr WHERE parcel_id = :pid');
        $this->db->bind(':pid', $PID);
        $this->db->bind(':pacr', $Acres);

        $this->db->execute();
    }

	//For Primary MP Page
    public function GetParcelBaseInfo($MPID)
    {
        $this->db->query('SELECT pmn.mp_id,pmn.parcel_title,mpi.parcel_img_name,pmn.parcel_id 
                              FROM auction_mp_parcel_main pmn 
                              INNER JOIN auction_mp_parcel_imgs mpi ON mpi.parcel_id = pmn.parcel_id AND mpi.parcel_img_order = 1 
                              WHERE pmn.mp_id = :mpid');
        $this->db->bind(':mpid', $MPID);

        return $this->db->resultSet();
    }

	public function getBiddingHistory($PID)
	{
		$this->db->query('SELECT ab.parcel_id,ab.bid_amount,ab.bid_date,usr.first_name,usr.last_name, ubn.bid_number, abt.bid_type 
                                   FROM auction_mp_bids ab 
                                   INNER JOIN users usr ON usr.user_id = ab.user_id 
                                   INNER JOIN user_bid_number ubn ON ubn.user_id = usr.user_id 
                                   INNER JOIN auction_bid_type abt ON abt.bid_type_id = ab.bid_type_id 
                                   WHERE ab.parcel_id = :pid ORDER BY ab.bid_id DESC ');
		$this->db->bind(':pid', $PID);

		$results = $this->db->resultSet();

		return $results;
	}

	public function MPVisibility($MPID,$Status)
	{
		$this->db->query('UPDATE auction_mp_master SET mp_active = :visstat WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':visstat', $Status);

		$this->db->execute();
	}

	public function MPActiveStatus($MPID, $Status)
	{
		$this->db->query('UPDATE auction_mp_master SET mp_completed = :comstat WHERE mp_id = :mpid');
		$this->db->bind(':mpid', $MPID);
		$this->db->bind(':comstat', $Status);

		$this->db->execute();
	}


}