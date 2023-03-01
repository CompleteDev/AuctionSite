<?php require APPROOT . '/views/admin/inc/header.php'?>;
<section id="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo URLROOT; ?>/admin">Dashboard</a></li>
            <li class="active">Listing</li>
        </ol>
    </div>
</section>
    <section id="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $data['ListingPage']->listing_title; ?></h1>
                </div>
            </div>
            <div class="container">
                <p><?php echo $data['ListingPage']->listing_info_text; ?></p>
            </div>
        </div>
    </section>
<?php require APPROOT . '/views/admin/inc/footer.php'?>;