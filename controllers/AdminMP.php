<?php
class AdminMP extends Controller

{

	public function __construct()

	{

		$this->adminModel = $this->model('AdminMDL');
		$this->oShared = $this->model('SharedMDL');
		$this->oAdminMP = $this->model('AdminMPMDL');
	}

	public function GetMPAuctionsList()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$results = $this->oAdminMP->GetMPAuctionsList();
		echo json_encode($results);
	}

	public function GetMPAuctionTitle()
	{
		$MPID = $_POST['MPID'];
		$results = $this->oAdminMP->GetMPAuctionTitle($MPID);
		echo json_encode($results);
	}

	public function UpdateMPTitle()
	{
		$MPID = $_POST['MPID'];
		$MPTitle = $_POST['MPTitle'];
		$this->oAdminMP->UpdateMPTitle($MPID,$MPTitle);
		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function CreateMaster()
	{
		$MPTitle = $_POST['MPTitle'];
		$this->oAdminMP->CreateMaster($MPTitle);

		$results = $this->oAdminMP->GetLastMPMasterID();
		$this->oAdminMP->InsertTerms($results->mp_id);
		echo json_encode($results);
	}

	public function GetPrimaryImage()
	{
		$MPID = $_POST['MPID'];
		$results = $this->oAdminMP->GetPrimaryImage($MPID);
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

	public function UpdateMPPrimaryImage($MPID)
	{
		$img_ext = strtolower(end(explode(".", $_FILES['file']['name'])));
		if ($img_ext == 'jpg' || $img_ext == 'webp' || $img_ext == 'png')
		{
			$img_name = $MPID . rand() . "." . $img_ext;
			$img_path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/" . $img_name;
			$image_name = $_FILES['mainImage']['tmp_name'];
			list($width, $height, $type, $attr) = getimagesize( $image_name );
			$new_width = 700;
			$new_height = 525;
			$src = imagecreatefromstring( file_get_contents( $image_name ) );
			$dst = imagecreatetruecolor( $new_width, $new_height );
			imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
			imagedestroy( $src );
			if($img_ext == "png")
			{
				imagepng( $dst, $image_name );
			}
			else
			{
				imagejpeg( $dst, $image_name );
			}
			imagedestroy( $dst );
			if (move_uploaded_file($_FILES['file']['tmp_name'], $img_path))
			{

				$results = $this->oAdminMP->GetPrimaryImage($MPID);
				if($results == 0)
				{
					//Insert New Image
					$this->oAdminMP->InsertNewPrimaryImage($MPID,$img_name);
				}
				else
				{
					//Update Image
					$this->oAdminMP->UpdatePrimaryImage($MPID,$img_name);
				}
			}
			else
			{
				$this->oShared->insertError('Failed');
				die();
			}

		}
	}

	public function GetPrimaryDescriptions()
	{
		$MPID = $_POST['MPID'];
		$results = $this->oAdminMP->GetPrimaryDescriptions($MPID);
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

	public function UpdatePrimaryDescription()
	{
		$MPID = $_POST['MPID'];
		$MPDesc = $_POST['MPDesc'];
		$results = $this->oAdminMP->GetPrimaryDescriptions($MPID);
		if($results == 0)
		{
			//Insert New Desc
			$this->oAdminMP->InsertNewPrimaryDesc($MPID,$MPDesc);
		}
		else
		{
			$this->oShared->insertError('In Update Function');
			//Update Desc
			$this->oAdminMP->UpdatePrimaryDesc($MPID,$MPDesc);
		}
		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetMPPDF()
	{
		$MPID = $_POST['MPID'];
		$results = $this->oAdminMP->GetMPPDF($MPID);
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

	public function InsertUpdatePDF($MPID)
	{
		$pdf_ext = strtolower(end(explode(".", $_FILES['file']['name'])));
		if ($pdf_ext == 'pdf')
		{
			$pdf_name = $MPID . rand() . "." . $pdf_ext;
			$pdf_path = $_SERVER['DOCUMENT_ROOT'] . "/public/brochures/" . $pdf_name;
			if (move_uploaded_file($_FILES['file']['tmp_name'], $pdf_path))
			{

				$results = $this->oAdminMP->GetMPPDF($MPID);
				if($results == 0)
				{
					//Insert New Image
					$this->oAdminMP->InsertMPPDF($MPID,$pdf_name);
				}
				else
				{
					//Update Image
					$this->oAdminMP->UpdateMPPDF($MPID,$pdf_name);
				}
			}
			else
			{
				$this->oShared->insertError('Failed');
				die();
			}

		}
	}

	public function GetMPVideo()
	{
		$MPID = $_POST['MPID'];
		$results = $this->oAdminMP->GetMPVideo($MPID);
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

	public function InsertUpdateMPVideo()
	{
		$MPID = $_POST['MPID'];
		$MPVideo = $_POST['MPVideo'];
		$results = $this->oAdminMP->GetMPVideo($MPID);
		if($results == 0)
		{
			//Insert New Desc
			$this->oAdminMP->InsertMPVideo($MPID,$MPVideo);
		}
		else
		{
			//Update Desc
			$this->oAdminMP->UpateMPVideo($MPID,$MPVideo);
		}
		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetMPDates()
	{
		$MPID = $_POST['MPID'];
		$results = $this->oAdminMP->GetMPDates($MPID);
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

	public function UpdateStartEnd()
	{
		$MPID = $_POST['MPID'];
		$TheStartDate = $_POST['TheStartDate'];
		$TheEndDate = $_POST['TheEndDate'];
		$StartTime = $_POST['StartTime'];
		$EndTime = $_POST['EndTime'];
		$results = $this->oAdminMP->GetMPDates($MPID);
		if($results == 0)
		{
			$this->oAdminMP->InsertStartEnd($MPID,$TheStartDate,$StartTime,$TheEndDate,$EndTime);
		}
		else
		{
			$this->oAdminMP->UpdateStartEnd($MPID,$TheStartDate,$StartTime,$TheEndDate,$EndTime);
		}

		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetTerms()
	{
		$MPID = $_POST['MPID'];
		$results = $this->oAdminMP->GetTerms($MPID);
		echo json_encode($results);
	}

	public function UpdateTerms()
	{
		$MPID = $_POST['MPID'];
		$TCTypeID = $_POST['TCTypeID'];
		$TCInfo = $_POST['TCInfo'];

		$this->oAdminMP->UpdateTerms($MPID,$TCTypeID,$TCInfo);

		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetParcels()
	{
		$MPID = $_POST['MPID'];
		$results = $this->oAdminMP->GetParcels($MPID);
		echo json_encode($results);
	}

	public function CreateParcel()
	{
		$MPID = $_POST['MPID'];
		$ParcelTitle = $_POST['ParcelTitle'];
		$this->oAdminMP->CreateParcel($MPID, $ParcelTitle);

		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetParcelTitle()
	{
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetParcelTitle($PID);
		echo json_encode($results);
	}

	public function UpdateParcelTitle()
	{
		$PID = $_POST['PID'];
		$PTitle = $_POST['ParcelTitle'];
		$this->oAdminMP->UpdateParcelTitle($PID,$PTitle);
		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetParcelDescriptions()
	{
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetParcelDescriptions($PID);
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

	public function UpdateInsertParcelDesc()
	{
		$PID = $_POST['PID'];
		$PDesc= $_POST['PDesc'];
		$results = $this->oAdminMP->GetParcelDescriptions($PID);
		if($results == 0)
		{
			//Insert New Desc
			$this->oAdminMP->InsertParcelDesc($PID,$PDesc);
		}
		else
		{
			//Update Desc
			$this->oAdminMP->UpdateParcelDesc($PID,$PDesc);
		}
		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetParcelFirstImage()
	{
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetParcelFirstImage($PID);
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

	public function GetParcelImages()
	{
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetParcelImages($PID);
		echo json_encode($results);
	}

	public function UpdateImageOrder()
	{
		foreach($_POST["value"] as $key => $value)
		{
			$data["Order"] = $key + 1;
			$data["Order"] = filter_var($data["Order"],FILTER_SANITIZE_STRING);
			$this->oAdminMP->UpdateImageOrder($data,$value);
		}
	}

	public function UpdateParcelImages($PID)
	{
		$img_ext = strtolower(end(explode(".", $_FILES['file']['name'])));
		if ($img_ext == 'jpg' || $img_ext == 'webp' || $img_ext == 'png')
		{
			$img_name = $PID . rand() . "." . $img_ext;
			$img_path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/" . $img_name;

			$image_name = $_FILES['mainImage']['tmp_name'];
			list($width, $height, $type, $attr) = getimagesize( $image_name );
			$new_width = 700;
			$new_height = 525;
			$src = imagecreatefromstring( file_get_contents( $image_name ) );
			$dst = imagecreatetruecolor( $new_width, $new_height );
			imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
			imagedestroy( $src );
			if($img_ext == "png")
			{
				imagepng( $dst, $image_name );
			}
			else
			{
				imagejpeg( $dst, $image_name );
			}
			imagedestroy( $dst );

			if (move_uploaded_file($_FILES['file']['tmp_name'], $img_path))
			{
				$this->oAdminMP->InsertImage($PID,$img_name);
			}
			else
			{
				$this->oShared->insertError('Failed');
				die();
			}

		}
	}

	public function DeleteImage()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$ImageID = $_POST['ImageID'];

		$this->oAdminMP->DeleteParcelImage($ImageID,$PID);

		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetStartingBid()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetStartingBid($PID);
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

	public function UpdateInsertStartingBid()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$StartingBid = $_POST['StartingBid'];
		$results = $this->oAdminMP->GetStartingBid($PID);
		if($results == 0)
		{
			$this->oAdminMP->InsertStartingBid($PID,$StartingBid);
		}
		else
		{
			$this->oAdminMP->UpdateStartingBid($PID,$StartingBid);
		}
		$results = ['results' => 'Done'];
		echo json_encode($results);

	}

	public function GetParcelAuctionType()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetParcelAuctionType($PID);
		if($results == "NotFound")
		{
			$results = ['results' => 'None'];
			echo json_encode($results);
		}
		else
		{
			echo json_encode($results);
		}
	}

	public function InsertUpdateAuctionType()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$ParcelAuctionType = $_POST['ParcelAuctionType'];
		$results = $this->oAdminMP->GetParcelAuctionType($PID);
		if($results == 0)
		{
			$this->oAdminMP->InsertAuctionType($PID,$ParcelAuctionType);
		}
		else
		{
			$this->oAdminMP->UpdateAuctionType($PID,$ParcelAuctionType);
		}
		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetParcelIncrement()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetParcelIncrement($PID);
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

	public function SetParcelInc()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetParcelAuctionType($PID);
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

	public function UpdateInsertInc()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$PIncr = $_POST['PIncr'];
		$results = $this->oAdminMP->GetParcelIncrement($PID);
		if($results == 0)
		{
			$this->oAdminMP->InsertParcelInc($PID,$PIncr);
		}
		else
		{
			$this->oAdminMP->UpdateParcelInc($PID,$PIncr);
		}

		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function GetParcelAcres()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->GetParcelAcres($PID);
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

	public function UpdateInsertParcelAcres()
    {
	    if(!isset($_SESSION['admin_id']))
	    {
		    flash('register_success', 'Log into your admin account!', 'alert alert-danger');
		    redirect('admin/adminlogin');
	    }
        $PID = $_POST['PID'];
        $Acres = $_POST['Acres'];
        $results = $this->oAdminMP->GetParcelAcres($PID);
        if($results == 0)
        {
            $this->oAdminMP->InsertParcelAcre($PID,$Acres);
        }
        else
        {
            $this->oAdminMP->UpdateParcelAcre($PID,$Acres);
        }

        $results = ['results' => 'Done'];
        echo json_encode($results);
    }

	public function GetParcelInfoFromPID()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$MPID = $this->oAdminMP->GetMPID($PID);
		$results = $this->oAdminMP->GetParcelBaseInfo($MPID->mp_id);
		echo json_encode($results);
	}

	public function GetParcelBaseInfo()
    {
	    if(!isset($_SESSION['admin_id']))
	    {
		    flash('register_success', 'Log into your admin account!', 'alert alert-danger');
		    redirect('admin/adminlogin');
	    }
        $MPID = $_POST['MPID'];
        $results = $this->oAdminMP->GetParcelBaseInfo($MPID);
        echo json_encode($results);
    }

	public function bidInfo()
	{
		if(!isset($_SESSION['admin_id']))
		{
			flash('register_success', 'Log into your admin account!', 'alert alert-danger');
			redirect('admin/adminlogin');
		}
		$PID = $_POST['PID'];
		$results = $this->oAdminMP->getBiddingHistory($PID);
		echo json_encode($results);
	}

	public function MPVisibility()
	{
		$MPID = $_POST['MPID'];
		$VisStat = $_POST['VisStat'];
		$this->oAdminMP->MPVisibility($MPID,$VisStat);

		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

	public function MPActiveStatus()
	{
		$MPID = $_POST['MPID'];
		$ComStat = $_POST['ComStat'];
		$this->oAdminMP->MPActiveStatus($MPID,$ComStat);

		$results = ['results' => 'Done'];
		echo json_encode($results);
	}

}