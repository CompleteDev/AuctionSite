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
                            <a href="#" class="navbar-brand"><h4>Listings Types</h4></a>
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
                    <table class="table table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- <?php /*foreach($data['listings'] as $listing) : */?>
                            <tr>
                                <td><?php /*echo $listing->listing_title; */?></td>
                                <td><?php /*echo $listing->listing_type; */?></td>
                                <td><?php /*echo $listing->listing_city; */?></td>
                                <td>
                                    <a href="<?php /*echo URLROOT; */?>/admin/adminlisting/<?php /*echo $listing->listing_id; */?>" class="btn btn-secondary">
                                        <i class="fas fa-angle-double-right"></i> Details
                                    </a>
                                </td>
                            </tr>
                        --><?php /*endforeach; */?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php require APPROOT . '/views/admin/inc/rightbar.php'?>
        </div>
    </div>
</section>


<?php require APPROOT . '/views/admin/inc/footer.php'?>
