<?php require APPROOT . '/views/admin/inc/header.php'?>
<?php require APPROOT . '/views/admin/inc/actionbar.php'?>
    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </section>

<!-- POSTS -->
<section id="posts">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0 mb-1">
                        <div class="container">
                            <a href="#" class="navbar-brand"><h4>Listings</h4></a>
                            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarCollapse">
                                <ul class="navbar-nav">
                                    <li class="nav-item px-2">
                                        <a href="<?php echo URLROOT; ?>/admin" class="nav-link active">Dashboard</a>
                                    </li>
                                </ul>
                        </div>

                    </nav>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#Listings" data-toggle="tab">Listings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#olaucitons" data-toggle="tab">Online Auctions</a>
                        </li>
                        <li>
                            <a class="nav-link" href="#mpaucitons" data-toggle="tab">Multi-Parcel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#hidden" data-toggle="tab">Hidden</a>
                        </li>
                        <li>
                            <a class="nav-link" href="#sold" data-toggle="tab">Sold</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="Listings">
                            <table class="table table-striped" id="stufffooter">
                            <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Images</th>
                                <th>PDF</th>
                                <th>Hide</th>
                                <th>Sold</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data['listings'] as $listing) : ?>
                                <tr>
                                    <td><?php echo $listing->listing_title; ?></td>
                                    <td><?php echo $listing->listing_type; ?></td>
                                    <td><?php echo $listing->listing_city; ?></td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/pages/listing/<?php echo $listing->listing_id; ?>" target="_blank"<i class="far fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $listing->listing_id; ?>" class="edit_listing" data-toggle="modal" data-target="#editListingModal"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $listing->listing_id; ?>" class="edit_images" data-toggle="modal" data-target="#editListingImagesModal"><i class="far fa-images"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $listing->listing_id; ?>" class="edit_PDF" data-toggle="modal" data-target="#editListingPDFModal"><i class="far fa-file-pdf"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $listing->listing_id; ?>" class="hide_listing"  data-toggle="modal" data-target="#HideListingModal"><i class="fas fa-lock"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $listing->listing_id; ?>" class="sold_listing"  data-toggle="modal" data-target="#SoldListingModal"><i class="far fa-money-bill-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="olaucitons">
                            <table class="table table-striped id="stufffooter"">
                            <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>History</th>
                                <th>Images</th>
                                <th>PDF</th>
                                <th>Hide/Show</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data['auctioninfo'] as $auctioninfo) : ?>
                                <tr>
                                    <td><?php echo $auctioninfo->listing_title; ?></td>
                                    <td><?php echo $auctioninfo->start_date . ' ' . $auctioninfo->start_time; ?></td>
                                    <td><?php echo $auctioninfo->end_date . ' ' . $auctioninfo->end_time; ?></td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/pages/auctionListing/<?php echo $auctioninfo->online_aucton_id; ?>" target="_blank"<i class="far fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $auctioninfo->online_aucton_id; ?>" class="edit_auction" data-toggle="modal" data-target="#editOnlineAuction"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/admin/auctioninfo/<?php echo $auctioninfo->online_aucton_id; ?>" target="_blank"><i class="fas fa-clipboard"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $auctioninfo->online_aucton_id; ?>" class="edit_Auction_images" data-toggle="modal" data-target="#editAuctionImagesModal"><i class="far fa-images"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $auctioninfo->online_aucton_id; ?>" class="edit_Auction_PDF" data-toggle="modal" data-target="#editAuctionPDFModal"><i class="far fa-file-pdf"></i></a>
                                    </td>
                                    <td>
                                        <?php if($auctioninfo->active == 1) : ?>
                                            <a href="#" id="<?php echo $auctioninfo->online_aucton_id; ?>" class="hide_auction"  data-toggle="modal" data-target="#HideAuctionModal"><i class="fas fa-lock"></i></a>
                                        <?php else : ?>
                                            <a href="#" id="<?php echo $auctioninfo->online_aucton_id; ?>" class="show_auction"  data-toggle="modal" data-target="#ShowAuctionModal"><i class="fas fa-unlock-alt"></i></a>
                                        <?php endif ; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="mpaucitons">
                        <div id="MPAuctionGridDiv"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="hidden">
                            <table class="table table-striped id="stufffooter"">
                            <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Images</th>
                                <th>PDF</th>
                                <th>Show</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data['hiddenlistings'] as $hidden) : ?>
                                <tr>
                                    <td><?php echo $hidden->listing_title; ?></td>
                                    <td><?php echo $hidden->listing_type; ?></td>
                                    <td><?php echo $hidden->listing_city; ?></td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/pages/listing/<?php echo $hidden->listing_id; ?>" target="_blank"<i class="far fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $hidden->listing_id; ?>" class="edit_listing" data-toggle="modal" data-target="#editListingModal"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $hidden->listing_id; ?>" class="edit_images" data-toggle="modal" data-target="#editListingImagesModal"><i class="far fa-images"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $hidden->listing_id; ?>" class="edit_PDF" data-toggle="modal" data-target="#editListingPDFModal"><i class="far fa-file-pdf"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $hidden->listing_id; ?>" class="show_listing"  data-toggle="modal" data-target="#ShowListingModal"><i class="fas fa-unlock-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="sold">
                            <table class="table table-striped id="stufffooter"">
                            <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Images</th>
                                <th>PDF</th>
                                <th>Hide</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data['soldListings'] as $soldListings) : ?>
                                <tr>
                                    <td><?php echo $soldListings->listing_title; ?></td>
                                    <td><?php echo $soldListings->listing_type; ?></td>
                                    <td><?php echo $soldListings->listing_city; ?></td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/pages/listing/<?php echo $soldListings->listing_id; ?>" target="_blank"<i class="far fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $soldListings->listing_id; ?>" class="edit_listing" data-toggle="modal" data-target="#editListingModal"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $soldListings->listing_id; ?>" class="edit_images" data-toggle="modal" data-target="#editListingImagesModal"><i class="far fa-images"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $soldListings->listing_id; ?>" class="edit_PDF" data-toggle="modal" data-target="#editListingPDFModal"><i class="far fa-file-pdf"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" id="<?php echo $soldListings->listing_id; ?>" class="hide_listing"  data-toggle="modal" data-target="#HideListingModal"><i class="fas fa-lock"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
            <?php require APPROOT . '/views/admin/inc/rightbar.php'?>
        </div>
    </div>
</section>


<?php require APPROOT . '/views/admin/inc/footer.php'?>

<script>
    $(document).ready(function ()
    {
        LoadMPAuctions();

        function LoadMPAuctions()
        {
            let MPGrid = '<div class="row m-2">';
            MPGrid = MPGrid + '<div class="col-md-3">';
            MPGrid = MPGrid + '<button class="btn btn-primary btn-block addMultiParcelAuction"><i class="fas fa-plus"></i> Add Multi-Parcel</button>';
            MPGrid = MPGrid + '</div>';
            MPGrid = MPGrid + '</div><hr>';
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetMPAuctionsList",
                    method: "POST",
                    dataType: 'json',
                    success: function (data)
                    {
                        MPGrid = MPGrid + '<table class="table table-striped id="MPAuctionTable"><thead class="thead-dark">';
                        MPGrid = MPGrid + '<tr><th>Name</th><th>Visible</th><th>Edit</th><th>View</th><th>Active</th></tr>'
                        MPGrid = MPGrid + '</thead><tbody>';
                        for(let i = 0; i < data.length; i++)
                        {
                            MPGrid = MPGrid + '<tr>';
                            MPGrid = MPGrid + '<td>' + data[i].mp_title  + '</td>';
                            if(data[i].mp_active == 0)
                            {
                                MPGrid = MPGrid + '<td><button class="btn MakeVisible" id="' + data[i].mp_id + '"><i class="fas fa-eye-slash" style="color:red"></i></button></td>';
                            }
                            else
                            {
                                MPGrid = MPGrid + '<td><button class="btn MakeInvisible" id="' + data[i].mp_id + '"><i class="fas fa-eye" style="color:limegreen"></i></button></td>';
                            }

                            MPGrid = MPGrid + '<td><button class="btn EditThisMPAuction" id="' + data[i].mp_id + '"><i class="fas fa-edit"></i></button></td>';
                            MPGrid = MPGrid + '<td><button class="btn ViewThisMPAuction" id="' + data[i].mp_id + '"><i class="fas fa-eye"></i></button></td>';
                            if(data[i].mp_completed == 0)
                            {
                                MPGrid = MPGrid + '<td><button class="btn MarkComplete" id="' + data[i].mp_id + '"><i class="fas fa-lock-open" style="color:limegreen"></i></button></td>';
                            }
                            else
                            {
                                MPGrid = MPGrid + '<td><button class="btn MarkIncomplete" id="' + data[i].mp_id + '"><i class="fas fa-lock" style="color:red"></i></button></td>';
                            }
                            MPGrid = MPGrid + '</tr>';
                        }
                        MPGrid = MPGrid + '</tbody></table>';
                        document.getElementById('MPAuctionGridDiv').innerHTML = MPGrid;
                    }
                }
            )
        }

        $(document).on('click', '.MarkComplete', function ()
        {
            const fd = new FormData();
            const MPID = $(this).attr("id");
            const ComStat = '1';
            fd.append('MPID', MPID);
            fd.append('ComStat', ComStat);
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/MPActiveStatus",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'Done')
                        {
                            LoadMPAuctions();
                        }
                    }
                }
            )
        });

        $(document).on('click', '.MarkIncomplete', function ()
        {
            const fd = new FormData();
            const MPID = $(this).attr("id");
            const ComStat = '0';
            fd.append('MPID', MPID);
            fd.append('ComStat', ComStat);
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/MPActiveStatus",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'Done')
                        {
                            LoadMPAuctions();
                        }
                    }
                }
            )
        });

        $(document).on('click', '.MakeVisible', function ()
        {
            const fd = new FormData();
            const MPID = $(this).attr("id");
            const VisStat = '1';
            fd.append('MPID', MPID);
            fd.append('VisStat', VisStat);
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/MPVisibility",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'Done')
                        {
                            LoadMPAuctions();
                        }
                    }
                }
            )
        });

        $(document).on('click', '.MakeInvisible', function ()
        {
            const fd = new FormData();
            const MPID = $(this).attr("id");
            const VisStat = '0';
            fd.append('MPID', MPID);
            fd.append('VisStat', VisStat);
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/MPVisibility",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'Done')
                        {
                            LoadMPAuctions();
                        }
                    }
                }
            )
        })

        $(document).on('click','.ViewThisMPAuction', function ()
        {
            const MPID = $(this).attr("id");
            window.open("https://www.landmarketers.com/Pages/mpmainview/" + MPID);
        });

        $(document).on('click', '.EditThisMPAuction', function ()
        {
            const MPID = $(this).attr("id");
            window.open("https://www.landmarketers.com/admin/adminmp/" + MPID);
        });

        $(document).on('click', '.addMultiParcelAuction',function ()
        {
            document.getElementById('TheModalTitle').innerHTML = "Add Multi-Parcel";
            let ModalBody =
                '<div class="col-md-12">' +
                '<div class="form-group">' +
                '<label for="body">Title</label>' +
                '<input type="text" name="MPTitle" id="MPTitle" class="form-control form-control-sm">'+
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<button class="btn-success btn-block CreateMPAuction">Create</button>' +
                '</div>' +
                '</div>';
            document.getElementById('TheModalFormBody').innerHTML = ModalBody;
            $('#TheModal').modal('show');
        })

        $(document).on('click', '.CreateMPAuction', function ()
        {
            let FormValid = true;
            const fd = new FormData();
            const MPTitle = document.getElementById('MPTitle').value;
            if(MPTitle == '')
            {
                FormValid = false;
                alert("Enter a Title");
            }
            if(FormValid == true)
            {
                fd.append('MPTitle', MPTitle)
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/CreateMaster",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            window.location.href = "https://www.landmarketers.com/admin/adminmp/" + data.mp_id;
                        }
                    }
                )
            }
        });
    });
</script>
