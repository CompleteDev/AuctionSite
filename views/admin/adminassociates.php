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
                            <a href="#" class="navbar-brand"><h4>Associates</h4></a>
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
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($data['associates'] as $associates) : ?>
                            <tr>
                                <td>
                                    <?php echo $associates->name; ?>
                                </td>
                                <td><a href="#" id="<?php echo $associates->associates_id; ?>" class="btn btn-primary edit_associate" data-toggle="modal" data-target="#AddAssociateModal"</a><i class="fas fa-edit"> Edit</td>
                                <td><a href="#" id="<?php echo $associates->associates_id; ?>" class="btn btn-danger delete_associate" data-toggle="modal" data-target="#DeleteAssociateModal" </a><i class="fas fa-trash-alt"></i> Delete</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php require APPROOT . '/views/admin/inc/rightbar.php'?>
        </div>
    </div>
</section>


<?php require APPROOT . '/views/admin/inc/footer.php'?>
