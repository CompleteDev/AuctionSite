<?php


    class Listing extends Controller
    {
        public function __construct()
        {
            $this->listingsModel = $this->model('Listings');
            $this->listingPageModel = $this->model('ListingPage');
            $this->oShared = $this->model('SharedMDL');

        }

        public function newListing()
        {
            //init data
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //instantiates HTML Purifier to clean up summer note WYSWYG boxes
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);
                //check for post
                //Sanitize post data
                $listingID = $_POST['listing_id'];
                $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
                $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
                $zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);
                $listingtype = filter_var($_POST['listingtype'], FILTER_SANITIZE_STRING);
                $commercialProperty = $_POST['commercialProperty'];
                $cropProperty = $_POST['cropProperty'];
                $hayProperty = $_POST['hayProperty'];
                $rangedProperty = $_POST['rangedProperty'];
                $recreationalProperty = $_POST['recreationalProperty'];
                $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $addinfo = filter_var($_POST['addinfo'], FILTER_SANITIZE_STRING);
                $acres = filter_var($_POST['acres'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $liveauction = $_POST['liveauction'];
                $yturl = $_POST['yturl'];
                if ($listingID == '')
                {
                    $extension = strtolower(end(explode(".", $_FILES['mainImage']['name'])));

                    $allowed_type = array("jpg", "jpeg", "png");
                    if (in_array($extension, $allowed_type)) {
                        $new_name = rand() . "." . $extension;
                        //Real Path for Live!!!!
                        $path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/listingimgs/" . $new_name;

                        //Remove this path when going live!!!!
                        //$path = "C:\\xampp\\htdocs\\SGFrameWork\\public\\img\\listingimgs\\" . $new_name;

                        $image_name = $_FILES['mainImage']['tmp_name'];
                        list($width, $height, $type, $attr) = getimagesize( $image_name );
                        $new_width = 700;
                        $new_height = 525;
                        $src = imagecreatefromstring( file_get_contents( $image_name ) );
                        $dst = imagecreatetruecolor( $new_width, $new_height );
                        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                        imagedestroy( $src );
                        if($extension == "png")
                        {
                            imagepng( $dst, $image_name );
                        }
                        else
                        {
                            imagejpeg( $dst, $image_name );
                        }
                        imagedestroy( $dst );

                        if (move_uploaded_file($_FILES['mainImage']['tmp_name'], $path)) {

                        } else {
                            $this->listingsModel->insertError('Failed to upload main image!!!');
                            die();
                        }
                    }
                }

                $data = [
                    'city' => trim($city),
                    'state' => trim($state),
                    'zip' => trim($zip),
                    'description' => $purifier->purify(trim($_POST['description'])),
                    'listingtype' => trim($listingtype),
                    'startdate' => '12/08/2018',
                    'primaryimg' => $new_name,
                    'title' => trim($title),
                    'acres' => trim($acres),
                    'price' => trim($price),
                    'directions' => $purifier->purify(trim($_POST['directions'])),
                    'addinfo' => $addinfo,
                    'listingid' => $listingID,
                    'yturl' => $yturl,


                ];


                if ($listingID == '')
                {
                    $lastid = $this->listingsModel->insertMainListingInfo($data);
                    if($liveauction == 'true')
                    {
                        $this->listingsModel->insertListiongTypes($lastid, live);
                    }
                    if($commercialProperty == 'true')
                    {
                        $this->listingsModel->insertListingTypes($lastid, commercial);
                    }
                    if($cropProperty == 'true')
                    {
                        $this->listingsModel->insertListingTypes($lastid, crop);
                    }
                    if($hayProperty == 'true')
                    {
                        $this->listingsModel->insertListingTypes($lastid, hay);
                    }
                    if($rangedProperty == 'true')
                    {
                        $this->listingsModel->insertListingTypes($lastid, Range);
                    }
                    if($recreationalProperty == 'true')
                    {
                        $this->listingsModel->insertListingTypes($lastid, recreational);
                    }

                    if ($_POST['Featured'] == 'true') {
                        $this->listingsModel->setAsFeatured($lastid, $listingtype);
                    }

                    //Insert Add_imgs
                    //$img_array = 0;
                    $order_by = 1;
                    $count = count($_FILES['add_imgs']['name']);

                    if(isset($_FILES['add_imgs']))
                    {
                        for($img_array = 0; $img_array < $count; $img_array++)
                        {
                            $extension = strtolower(end(explode(".", $_FILES['add_imgs']['name'][$img_array])));
                            $allowed_type = array("jpg", "jpeg", "png");

                            if (in_array($extension, $allowed_type))
                            {
                                $new_name = $lastid . "_" . rand() . "." . $extension;
                                //Real Path for Live!!!!
                                $path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/listingimgs/" . $new_name;

                                $image_array = $_FILES['add_imgs']['tmp_name'];
                                foreach($image_array as $image_name)
                                {
                                    list($width, $height, $type, $attr) = getimagesize( $image_name );
                                    $ratio = $width / $height;
                                    if ($ratio > 1)
                                    {
                                        $new_width = 700;
                                        $new_height = 525;
                                    }
                                    else
                                    {
                                        $new_width = 635;
                                        $new_height = 820;
                                    }
                                    $src = imagecreatefromstring( file_get_contents( $image_name ) );
                                    $dst = imagecreatetruecolor( $new_width, $new_height );
                                    imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                                    imagedestroy( $src );
                                    if($extension == "png")
                                    {
                                        imagepng( $dst, $image_name );
                                    }
                                    else
                                    {
                                        imagejpeg( $dst, $image_name );
                                    }
                                    imagedestroy( $dst );
                                }

                                if (move_uploaded_file($_FILES['add_imgs']['tmp_name'][$img_array], $path))
                                {
                                    $this->listingsModel->insertAddImages($lastid, $new_name, $order_by);
                                } else {
                                    $this->listingsModel->insertError('Failed!!!');
                                    die();
                                }
                            }
                            $order_by++;
                        }
                    }


                    $brochure_ext = strtolower(end(explode(".", $_FILES['brochure']['name'])));
                    if ($brochure_ext == 'pdf') {
                        $brochure_name = $lastid . "_" . rand() . "." . $brochure_ext;
                        //Real path
                        $brochure_path = $_SERVER['DOCUMENT_ROOT'] . "/public/brochures/" . $brochure_name;

                        //Remove this path when going live!!!!
                        //$brochure_path = "C:\\xampp\htdocs\\SGFrameWork\\public\\brochures\\" . $brochure_name;
                        if (move_uploaded_file($_FILES['brochure']['tmp_name'], $brochure_path)) {
                            $this->listingsModel->insertBrochure($brochure_name, $lastid);
                        }

                    }
                }

                else
                    {
                    if ($_POST['Featured'] == 'true') {
                        $this->listingsModel->setAsFeatured($listingID, $listingtype);
                    }
                    $this->listingsModel->updateListing($data);
                }

            } else {
                //init data

            }

        }

        public function UpdateListingMainImage()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $LisitingID = $_POST['LisitingID'];
                $extension = strtolower(end(explode(".", $_FILES['mainImage']['name'])));
                $allowed_type = array("jpg", "jpeg", "png");
                $this->listingsModel->insertError($extension);
                if (in_array($extension, $allowed_type))
                {
                    $new_name = rand() . "." . $extension;
                    //Real Path for Live!!!!
                    $path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/listingimgs/" . $new_name;

                    $image_name = $_FILES['mainImage']['tmp_name'];
                    list($width, $height, $type, $attr) = getimagesize( $image_name );
                    $new_width = 700;
                    $new_height = 525;
                    $src = imagecreatefromstring( file_get_contents( $image_name ) );
                    $dst = imagecreatetruecolor( $new_width, $new_height );
                    imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                    imagedestroy( $src );
                    if($extension == "png")
                    {
                        imagepng( $dst, $image_name );
                    }
                    else
                    {
                        imagejpeg( $dst, $image_name );
                    }
                    imagedestroy( $dst );

                    if (move_uploaded_file($_FILES['mainImage']['tmp_name'], $path))
                    {

                        $this->listingsModel->UpdateListingMainImage($new_name, $LisitingID);
                    }
                    else
                        {
                        $this->listingsModel->insertError('Failed to upload main image!!!');
                        die();
                    }
                }
            }
        }

        public function updateListing()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);
                $listingid = $_POST['listing_id'];
                $city = filter_var($_POST['update_city'], FILTER_SANITIZE_STRING);
                $state = filter_var($_POST['update_state'], FILTER_SANITIZE_STRING);
                $zip = filter_var($_POST['update_zip'], FILTER_SANITIZE_STRING);
                $listingtype = filter_var($_POST['update_listingtype'], FILTER_SANITIZE_STRING);
                $title = filter_var($_POST['update_title'], FILTER_SANITIZE_STRING);
                $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $addinfo = filter_var($_POST['update_tagline'], FILTER_SANITIZE_STRING);
                $acres = filter_var($_POST['update_acres'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $startdate = $_POST['update_startdate'];
                $edit_yturl = $_POST['edit_yturl'];

                if($_FILES['update_mainImage']['tmp_name'] != '')
                {
                    $extension = strtolower(end(explode(".", $_FILES['update_mainImage']['name'])));

                    $allowed_type = array("jpg", "jpeg", "png");
                    if (in_array($extension, $allowed_type)) {
                        $update_new_name = rand() . "." . $extension;
                        //Real Path for Live!!!!
                        $path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/listingimgs/" . $update_new_name;

                        //Remove this path when going live!!!!
                        //$path = "C:\\xampp\\htdocs\\SGFrameWork\\public\\img\\listingimgs\\" . $new_name;

                        $image_name = $_FILES['update_mainImage']['tmp_name'];
                        list($width, $height, $type, $attr) = getimagesize( $image_name );
                        $new_width = 700;
                        $new_height = 525;
                        $src = imagecreatefromstring( file_get_contents( $image_name ) );
                        $dst = imagecreatetruecolor( $new_width, $new_height );
                        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                        imagedestroy( $src );
                        if($extension == "png")
                        {
                            imagepng( $dst, $image_name );
                        }
                        else
                        {
                            imagejpeg( $dst, $image_name );
                        }
                        imagedestroy( $dst );

                        if (move_uploaded_file($_FILES['update_mainImage']['tmp_name'], $path))
                        {
                            $this->listingsModel->insertError($update_new_name . ' ' . $listingid);
                            //Update New Image
                            $this->listingsModel->UpdateMainImage($update_new_name, $listingid);

                        } else {
                            $this->listingsModel->insertError('Failed to upload main image!!!');
                            die();
                        }
                    }
                }

                $data =
                    [
                        'city' => trim($city),
                        'state' => trim($state),
                        'zip' => trim($zip),
                        'description' => $purifier->purify(trim($_POST['listing_info_text'])),
                        'listingtype' => trim($listingtype),
                        'startdate' => $startdate,
                        'title' => trim($title),
                        'acres' => trim($acres),
                        'price' => trim($price),
                        'directions' => $purifier->purify(trim($_POST['listing_directions'])),
                        'addinfo' => $addinfo,
                        'listingid' => $listingid,
                        'edit_yturl' => $edit_yturl,
                    ];

                $this->listingsModel->updateListing($data);
            }
        }

        public function getListingImages()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $LisitingID = $_POST['LisitingID'];
                $listingimgs =  $this->listingPageModel->getImages($LisitingID);
                echo json_encode($listingimgs);
            }
        }

        public function getAuctionImages()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $AuctionID = $_POST['AuctionID'];
                $Auctionimgs =  $this->listingPageModel->getAuctionImages($AuctionID);
                echo json_encode($Auctionimgs);
            }
        }

        public function GetAuctionMainImage()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $AuctionID = $_POST['AuctionID'];
                $AuctionMainimg =  $this->listingPageModel->GetAuctionMainImage($AuctionID);
                echo json_encode($AuctionMainimg);
            }
        }

        public function GetListingMainImage()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $LisitingID = $_POST['LisitingID'];
                $ListingMainimg =  $this->listingPageModel->GetListingMainImage($LisitingID);
                echo json_encode($ListingMainimg);
            }
        }

        public function getListingPDF()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $LisitingID = $_POST['LisitingID'];
                $listingimgs =  $this->listingPageModel->getPDF($LisitingID);
                echo json_encode($listingimgs);
            }
        }

        public function getAuctionPDF()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $AuctionID = $_POST['AuctionID'];
                $AuctionPDF =  $this->listingPageModel->getAuctionPDF($AuctionID);
                echo json_encode($AuctionPDF);
            }
        }

        public function deleteThisListingImage()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $imageID = $_POST['imageID'];
                $ListingID = $_POST['ListingID'];
                $this->listingPageModel->deleteListingImage($imageID, $ListingID);
            }
        }

        public function deleteThisAuctionImage()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $imageID = $_POST['imageID'];
                $AuctionID = $_POST['AuctionID'];
                $this->listingPageModel->deleteAuctionImage($imageID, $AuctionID);
            }
        }

        public function deleteThisListingPDF()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $pdfID = $_POST['pdfID'];
                $ListingID = $_POST['ListingID'];
                $this->listingPageModel->deleteListingPDF($pdfID, $ListingID);
            }
        }

        public function deleteThisAuctionPDF()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $pdfID = $_POST['pdfID'];
                $AuctionID= $_POST['AuctionID'];
                $this->listingPageModel->deleteAuctionPDF($pdfID, $AuctionID);
            }
        }



        public function addListingImg()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $LisitingID = $_POST['LisitingID'];
                //Insert Add_imgs
                //$img_array = 0;
                $order_by = $this->listingsModel->getLastImgOrder($LisitingID) + 1;
                $count = count($_FILES['add_more_imgs']['name']);

                if(isset($_FILES['add_more_imgs']))
                {
                    for($img_array = 0; $img_array < $count; $img_array++)
                        {
                            $extension = strtolower(end(explode(".", $_FILES['add_more_imgs']['name'][$img_array])));
                            $allowed_type = array("jpg", "jpeg", "png");

                            if (in_array($extension, $allowed_type))
                            {
                                $new_name = $LisitingID . "_" . rand() . "." . $extension;
                                //Real Path for Live!!!!
                                $path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/listingimgs/" . $new_name;

                                $image_array = $_FILES['add_more_imgs']['tmp_name'];
                                foreach($image_array as $image_name)
                                {
                                    list($width, $height, $type, $attr) = getimagesize( $image_name );
                                    $ratio = $width / $height;
                                    if ($ratio > 1)
                                    {
                                        $new_width = 700;
                                        $new_height = 525;
                                    }
                                    else
                                    {
                                        $new_width = 635;
                                        $new_height = 820;
                                    }
                                    $src = imagecreatefromstring( file_get_contents( $image_name ) );
                                    $dst = imagecreatetruecolor( $new_width, $new_height );
                                    imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                                    imagedestroy( $src );
                                    if($extension == "png")
                                    {
                                        imagepng( $dst, $image_name );
                                    }
                                    else
                                    {
                                        imagejpeg( $dst, $image_name );
                                    }
                                    imagedestroy( $dst );
                                }

                                if (move_uploaded_file($_FILES['add_more_imgs']['tmp_name'][$img_array], $path))
                                {
                                    $this->listingsModel->insertAddImages($LisitingID, $new_name, $order_by);
                                } else {
                                    $this->listingsModel->insertError('Failed!!!');
                                    die();
                                }
                            }
                            $order_by++;
                        }
                }



            }
        }

        public function moveImage()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $LisitingID = $_POST['ListingID'];
                $imageID = $_POST['imageID'];
                $positionto = $_POST['positionto'];

                $this->listingsModel->MoveImage($LisitingID, $imageID, $positionto);
            }
        }

        public function moveAuctionImage()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $imageID = $_POST['imageID'];
                $AuctionID = $_POST['AuctionID'];
                $positionto = $_POST['positionto'];

                $this->listingsModel->MoveAuctionImage($AuctionID, $imageID, $positionto);
            }
        }

        public function addAuctionImg()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $AuctionID = $_POST['AuctionID'];
                //Insert Add_imgs
                //$img_array = 0;
                $order_by = $this->listingsModel->getLastAuctionImgOrder($AuctionID) + 1;
                $count = count($_FILES['add_more_auction_imgs']['name']);

                if(isset($_FILES['add_more_auction_imgs']))
                {
                    for($img_array = 0; $img_array < $count; $img_array++)
                    {
                        $extension = strtolower(end(explode(".", $_FILES['add_more_auction_imgs']['name'][$img_array])));
                        $allowed_type = array("jpg", "jpeg", "png");

                        if (in_array($extension, $allowed_type))
                        {
                            $new_name = $AuctionID . "_" . rand() . "." . $extension;
                            //Real Path for Live!!!!
                            $path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/listingimgs/" . $new_name;

                            $image_array = $_FILES['add_more_auction_imgs']['tmp_name'];
                            foreach($image_array as $image_name)
                            {
                                list($width, $height, $type, $attr) = getimagesize( $image_name );
                                $ratio = $width / $height;
                                if ($ratio > 1)
                                {
                                    $new_width = 700;
                                    $new_height = 525;
                                }
                                else
                                {
                                    $new_width = 635;
                                    $new_height = 820;
                                }
                                $src = imagecreatefromstring( file_get_contents( $image_name ) );
                                $dst = imagecreatetruecolor( $new_width, $new_height );
                                imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                                imagedestroy( $src );
                                if($extension == "png")
                                {
                                    imagepng( $dst, $image_name );
                                }
                                else
                                {
                                    imagejpeg( $dst, $image_name );
                                }
                                imagedestroy( $dst );
                            }

                            if (move_uploaded_file($_FILES['add_more_auction_imgs']['tmp_name'][$img_array], $path))
                            {
                                $this->listingsModel->insertAddAuctionImages($AuctionID, $new_name, $order_by);
                            } else {
                                $this->listingsModel->insertError('Failed!!!');
                                die();
                            }
                        }
                        $order_by++;
                    }
                }



            }
        }


        public  function AddNewPDF()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $LisitingID = $_POST['ListingID'];
                $NewPDF = $_POST['Update_brochure'];

                $data =
                    [
                        'LisitingID' => $LisitingID,
                        'NewPDF' => $NewPDF,

                    ];
                $brochure_ext = strtolower(end(explode(".", $_FILES['Update_brochure']['name'])));
                if ($brochure_ext == 'pdf')
                {
                    $brochure_name = $LisitingID . "_" . rand() . "." . $brochure_ext;
                    //Real path
                    $brochure_path = $_SERVER['DOCUMENT_ROOT'] . "/public/brochures/" . $brochure_name;

                    if (move_uploaded_file($_FILES['Update_brochure']['tmp_name'], $brochure_path))
                    {
                        $this->listingsModel->insertBrochure($brochure_name, $LisitingID);
                        $data['NewPDF'] = $brochure_name;
                    }
                    else
                    {
                        die();
                    }
                }

                $this->listingsModel->UpdateListingPDF($data);

            }
        }

        public  function AddNewAuctionPDF()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $AuctionID = $_POST['AuctionID'];
                $NewPDF = $_POST['Update_Auction_brochure'];

                $data =
                    [
                        'AuctionID' => $AuctionID,
                        'NewPDF' => $NewPDF,

                    ];
                $brochure_ext = strtolower(end(explode(".", $_FILES['Update_Auction_brochure']['name'])));
                if ($brochure_ext == 'pdf')
                {
                    $brochure_name = $AuctionID . "_" . rand() . "." . $brochure_ext;
                    //Real path
                    $brochure_path = $_SERVER['DOCUMENT_ROOT'] . "/public/brochures/" . $brochure_name;

                    if (move_uploaded_file($_FILES['Update_Auction_brochure']['tmp_name'], $brochure_path))
                    {
                        $data['NewPDF'] = $brochure_name;
                        $this->listingsModel->UpdateAuctionPDF($data);
                    }
                    else
                    {
                        die();
                    }
                }

            }
        }

        public  function HideListing()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $listingid = $_POST['hideListingID'];
                $this->listingsModel->HideThisListing($listingid);
            }
        }

        public function ShowListing()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $listingid = $_POST['ShowListingID'];
                $this->listingsModel->showListing($listingid);
            }
        }

        public function ShowAuction()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $ShowAuctionID = $_POST['ShowAuctionID'];
                $this->listingsModel->showAuction($ShowAuctionID);
            }
        }
        public function HideAuction()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $HideAuctionID = $_POST['HideAuctionID'];
                $this->listingsModel->hideAuction($HideAuctionID);
            }
        }

        public function SoldListing()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $listingid = $_POST['SoldListingID'];
                $this->listingsModel->MarkSold($listingid);
            }
        }

        public  function deleteListing()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                //$listingid = $_POST['deleteListingID'];
                //$this->listingsModel->deleteListing($listingid);
            }
        }

        public  function fetchListingInfo()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $listingid = $_POST['LisitingID'];
                $results =  $this->listingsModel->getListingInfo($listingid);
                echo json_encode($results);
            }
        }

        public function fetchAuctionInfo()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $AuctionID = $_POST['LisitingID'];
                $results =  $this->listingPageModel->getAuctionInfo($AuctionID);
                echo json_encode($results);
            }
        }

        public function uploadImage($img)
        {
            $extension = end(explode(".", $_FILES[$img]['name']));
            $this->listingsModel->insertError($extension);
            $allowed_type = array("jpg", "jpeg", "png");
            if(in_array($extension, $allowed_type))
            {
                $new_name = rand() . "." . $extension;
                $path = URLROOT .  "/public/img/listingimgs/" . $new_name;
                if (move_uploaded_file($_FILES['file']['tmp_name'], $path))
                {
                    $this->listingsModel->insertError($new_name);
                    return $new_name;
                }
                else
                {
                    $this->listingsModel->insertError('Failed!!!');
                }
            }
            }

            public function addOnlineAuction()
            {
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $start_date = filter_var($_POST['start_date'],FILTER_SANITIZE_STRING);
                    $start_time = filter_var($_POST['start_time'],FILTER_SANITIZE_STRING);
                    $start_min = filter_var($_POST['start_min'],FILTER_SANITIZE_STRING);
                    $end_date = filter_var($_POST['end_date'],FILTER_SANITIZE_STRING);
                    $end_time = filter_var($_POST['end_time'],FILTER_SANITIZE_STRING);
                    $end_min = filter_var($_POST['end_min'],FILTER_SANITIZE_STRING);
                    $starting_bid = filter_var($_POST['starting_bid'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $auction_title = filter_var($_POST['auction_title'],FILTER_SANITIZE_STRING);
                    $short_desc = filter_var($_POST['short_desc'],FILTER_SANITIZE_STRING);
                    $auctionType = $_POST['auctionType'];
                    $BidIncrement = $_POST['BidIncrement'];
                    $StartingPerAcre = $_POST['StartingPerAcre'];
                    $totalAcres = filter_var($_POST['totalAcres'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $Video_URL = $_POST['Video_URL'];
                    //$imgName = $this->oShared->uploadSingleImage($_FILES,'mainImage', 'C:\\xampp\htdocs\\SGFrameWork\\public\\img\\listingimgs\\');

                    $extension = strtolower(end(explode(".", $_FILES['mainImage']['name'])));

                    $allowed_type = array("jpg", "jpeg", "png");
                    if(in_array($extension, $allowed_type))
                    {
                        $new_name = rand() . "." . $extension;
                        //Real Path for Live!!!!
                        $path = $_SERVER['DOCUMENT_ROOT'] .  "/public/img/listingimgs/" . $new_name;
                        
                        $image_name = $_FILES['mainImage']['tmp_name'];
                        list($width, $height, $type, $attr) = getimagesize( $image_name );
                        $new_width = 700;
                        $new_height = 525;
                        $src = imagecreatefromstring( file_get_contents( $image_name ) );
                        $dst = imagecreatetruecolor( $new_width, $new_height );
                        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                        imagedestroy( $src );
                        if($extension == "png")
                        {
                            imagepng( $dst, $image_name );
                        }
                        else
                        {
                            imagejpeg( $dst, $image_name );
                        }
                        imagedestroy( $dst );

                        if (move_uploaded_file($_FILES['mainImage']['tmp_name'], $path))
                        {

                        }
                        else
                        {
                            $this->listingsModel->insertError('Failed!!!');
                            die();
                        }
                    }

                    $legal_description = filter_var($_POST['legal_description'],FILTER_SANITIZE_STRING);
                    $legal_title = filter_var($_POST['legal_title'],FILTER_SANITIZE_STRING);
                    $auction_Mineral = filter_var($_POST['auction_Mineral'],FILTER_SANITIZE_STRING);
                    $auction_Leases = filter_var($_POST['auction_Leases'],FILTER_SANITIZE_STRING);
                    $auctionFarmServiceAgency = filter_var($_POST['auctionFarmServiceAgency'],FILTER_SANITIZE_STRING);
                    $auctionPropertyCondition = filter_var($_POST['auctionPropertyCondition'],FILTER_SANITIZE_STRING);
                    $auctionPurchaseAgreement = filter_var($_POST['auctionPurchaseAgreement'],FILTER_SANITIZE_STRING);
                    $auctionClosingExpenses = filter_var($_POST['auctionClosingExpenses'],FILTER_SANITIZE_STRING);
                    $auctionClosingDate = filter_var($_POST['auctionClosingDate'],FILTER_SANITIZE_STRING);
                    $auctionSaleProcedure = filter_var($_POST['auctionSaleProcedure'],FILTER_SANITIZE_STRING);
                    $auctionDefaultRemedies = filter_var($_POST['auctionDefaultRemedies'],FILTER_SANITIZE_STRING);
                    $auctionAdditionalDisclosures = filter_var($_POST['auctionAdditionalDisclosures'],FILTER_SANITIZE_STRING);
                    $auctionContactInfo = filter_var($_POST['auctionContactInfo'],FILTER_SANITIZE_STRING);
                    $data =
                        [
                            'start_date' => $start_date,
                            'start_time' => $start_time,
                            'start_min' => $start_min,
                            'end_date' => $end_date,
                            'end_time' => $end_time,
                            'end_min' => $end_min,
                            'starting_bid' => $starting_bid,
                            'auction_title' => $auction_title,
                            'short_desc' => $short_desc,
                            'legal_description' => $legal_description,
                            'legal_title' => $legal_title,
                            'auction_Mineral' => $auction_Mineral,
                            'auction_Leases' => $auction_Leases,
                            'auctionFarmServiceAgency' => $auctionFarmServiceAgency,
                            'auctionPropertyCondition' => $auctionPropertyCondition,
                            'auctionPurchaseAgreement' => $auctionPurchaseAgreement,
                            'auctionClosingExpenses' => $auctionClosingExpenses,
                            'auctionClosingDate' => $auctionClosingDate,
                            'auctionSaleProcedure' => $auctionSaleProcedure,
                            'auctionDefaultRemedies' => $auctionDefaultRemedies,
                            'auctionAdditionalDisclosures' => $auctionAdditionalDisclosures,
                            'auctionContactInfo' => $auctionContactInfo,
                            'auctionType' => $auctionType,
                            'totalAcres' => $totalAcres,
                            'imgName' => $new_name,
                            'BidIncrement' => $BidIncrement,
                            'StartingPerAcre'=> $StartingPerAcre,
                            'Video_URL' => $Video_URL,
                        ];
                    $lastid = $this->listingsModel->createNewOnlineAuction($data);

                    //Insert Add_imgs
                    //$img_array = 0;
                    $order_by = 1;
                    $count = count($_FILES['Auction_Additional_Images']['name']);

                    if(isset($_FILES['Auction_Additional_Images']))
                    {
                        for($img_array = 0; $img_array < $count; $img_array++)
                        {
                            $extension = strtolower(end(explode(".", $_FILES['Auction_Additional_Images']['name'][$img_array])));
                            $allowed_type = array("jpg", "jpeg", "png");

                            if (in_array($extension, $allowed_type))
                            {
                                $new_name = $lastid . "_" . rand() . "." . $extension;
                                //Real Path for Live!!!!
                                $path = $_SERVER['DOCUMENT_ROOT'] . "/public/img/listingimgs/" . $new_name;

                                $image_array = $_FILES['Auction_Additional_Images']['tmp_name'];
                                
                                /* Will need to uncomment when new additional image uploader is created as this only takes one image at a time and uncommenting will allow it to handle arrays.
                                foreach($image_array as $image_name)
                                {
                                */
                                    list($width, $height, $type, $attr) = getimagesize( $image_name );
                                    $ratio = $width / $height;
                                    if ($ratio > 1)
                                    {
                                        $new_width = 700;
                                        $new_height = 525;
                                    }
                                    else
                                    {
                                        $new_width = 635;
                                        $new_height = 820;
                                    }
                                    $src = imagecreatefromstring( file_get_contents( $image_name ) );
                                    $dst = imagecreatetruecolor( $new_width, $new_height );
                                    imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                                    imagedestroy( $src );
                                    if($extension == "png")
                                    {
                                        imagepng( $dst, $image_name );
                                    }
                                    else
                                    {
                                        imagejpeg( $dst, $image_name );
                                    }
                                    imagedestroy( $dst );
                                //}

                                if (move_uploaded_file($_FILES['Auction_Additional_Images']['tmp_name'][$img_array], $path))
                                {
                                    $this->listingsModel->insertAuctionImages($lastid,$new_name,$order_by);
                                } else {
                                    $this->listingsModel->insertError('Failed!!!');
                                    die();
                                }
                            }
                            $order_by++;
                        }
                    }


                }
            }

            public function UpdateAuctionMainImage()
            {
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $AuctionID = $_POST['AuctionID'];
                    $extension = strtolower(end(explode(".", $_FILES['mainImage']['name'])));
                    $allowed_type = array("jpg", "jpeg", "png");
                    if(in_array($extension, $allowed_type))
                    {
                        $new_name = rand() . "." . $extension;
                        //Real Path for Live!!!!
                        $path = $_SERVER['DOCUMENT_ROOT'] .  "/public/img/listingimgs/" . $new_name;

                        $image_name = $_FILES['mainImage']['tmp_name'];
                        list($width, $height, $type, $attr) = getimagesize( $image_name );
                        $new_width = 700;
                        $new_height = 525;
                        $src = imagecreatefromstring( file_get_contents( $image_name ) );
                        $dst = imagecreatetruecolor( $new_width, $new_height );
                        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                        imagedestroy( $src );
                        if($extension == "png")
                        {
                            imagepng( $dst, $image_name );
                        }
                        else
                        {
                            imagejpeg( $dst, $image_name );
                        }
                        imagedestroy( $dst );
                        if (move_uploaded_file($_FILES['mainImage']['tmp_name'], $path))
                        {
                            $this->listingsModel->UpdateAuctonMainImage($new_name, $AuctionID);
                        }
                        else
                        {
                            $this->listingsModel->insertError('Failed!!!');
                            die();
                        }
                    }
                }

            }

            public function updateOnlineAuction()
            {
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $AuctionID = $_POST['AuctionID'];
                    $start_date = filter_var($_POST['start_date'],FILTER_SANITIZE_STRING);
                    $start_time = filter_var($_POST['start_time'],FILTER_SANITIZE_STRING);
                    $start_min = filter_var($_POST['start_min'],FILTER_SANITIZE_STRING);
                    $end_date = filter_var($_POST['end_date'],FILTER_SANITIZE_STRING);
                    $end_time = filter_var($_POST['end_time'],FILTER_SANITIZE_STRING);
                    $end_min = filter_var($_POST['end_min'],FILTER_SANITIZE_STRING);
                    $starting_bid = filter_var($_POST['starting_bid'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $auction_title = filter_var($_POST['auction_title'],FILTER_SANITIZE_STRING);
                    //$short_desc = filter_var($_POST['short_desc'],FILTER_SANITIZE_STRING);
                    $short_desc = $_POST['short_desc'];
                    $auctionType = $_POST['auctionType'];
                    $totalAcres = filter_var($_POST['totalAcres'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $legal_description = filter_var($_POST['legal_description'],FILTER_SANITIZE_STRING);
                    $legal_title = filter_var($_POST['legal_title'],FILTER_SANITIZE_STRING);
                    $auction_Mineral = filter_var($_POST['auction_Mineral'],FILTER_SANITIZE_STRING);
                    $auction_Leases = filter_var($_POST['auction_Leases'],FILTER_SANITIZE_STRING);
                    $auctionFarmServiceAgency = filter_var($_POST['auctionFarmServiceAgency'],FILTER_SANITIZE_STRING);
                    $auctionPropertyCondition = filter_var($_POST['auctionPropertyCondition'],FILTER_SANITIZE_STRING);
                    $auctionPurchaseAgreement = filter_var($_POST['auctionPurchaseAgreement'],FILTER_SANITIZE_STRING);
                    $auctionClosingExpenses = filter_var($_POST['auctionClosingExpenses'],FILTER_SANITIZE_STRING);
                    $auctionClosingDate = filter_var($_POST['auctionClosingDate'],FILTER_SANITIZE_STRING);
                    $auctionSaleProcedure = filter_var($_POST['auctionSaleProcedure'],FILTER_SANITIZE_STRING);
                    $auctionDefaultRemedies = filter_var($_POST['auctionDefaultRemedies'],FILTER_SANITIZE_STRING);
                    $auctionAdditionalDisclosures = filter_var($_POST['auctionAdditionalDisclosures'],FILTER_SANITIZE_STRING);
                    $auctionContactInfo = filter_var($_POST['auctionContactInfo'],FILTER_SANITIZE_STRING);
                    $BidIncrement = $_POST['BidIncrement'];
                    $StartingBidPerAcre = $_POST['StartingBidPerAcre'];
                    $Video_URL = $_POST['Video_URL'];
                    $data =
                        [
                            'AuctionID' => $AuctionID,
                            'start_date' => $start_date,
                            'start_time' => $start_time,
                            'start_min' => $start_min,
                            'end_date' => $end_date,
                            'end_time' => $end_time,
                            'end_min' => $end_min,
                            'starting_bid' => $starting_bid,
                            'auction_title' => $auction_title,
                            'short_desc' => $short_desc,
                            'legal_description' => $legal_description,
                            'legal_title' => $legal_title,
                            'auction_Mineral' => $auction_Mineral,
                            'auction_Leases' => $auction_Leases,
                            'auctionFarmServiceAgency' => $auctionFarmServiceAgency,
                            'auctionPropertyCondition' => $auctionPropertyCondition,
                            'auctionPurchaseAgreement' => $auctionPurchaseAgreement,
                            'auctionClosingExpenses' => $auctionClosingExpenses,
                            'auctionClosingDate' => $auctionClosingDate,
                            'auctionSaleProcedure' => $auctionSaleProcedure,
                            'auctionDefaultRemedies' => $auctionDefaultRemedies,
                            'auctionAdditionalDisclosures' => $auctionAdditionalDisclosures,
                            'auctionContactInfo' => $auctionContactInfo,
                            'auctionType' => $auctionType,
                            'totalAcres' => $totalAcres,
                            'BidIncrement' => $BidIncrement,
                            'StartingBidPerAcre' => $StartingBidPerAcre,
                            'Video_URL' => $Video_URL,
                        ];

                    $this->listingsModel->updateOnlineAuction($data);
                }
            }

            public function getBiddingHistory()
            {

            }
    }