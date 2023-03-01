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
                            <a href="#" class="navbar-brand"><h4>Users</h4></a>
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
                            <a class="nav-link active" href="#active" data-toggle="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#inactive" data-toggle="tab">Inactive</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="active">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Lock</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($data['users'] as $users) : ?>
                                <tr>
                                    <td>
                                        <?php echo $users->first_name . ' ' . $users->last_name; ?>
                                    </td>
                                    <td><a href="#" id="<?php echo $users->user_id; ?>" class="btn btn-primary edit_user" data-toggle="modal" data-target="#EditUserModal"</a><i class="fas fa-edit"> Edit</td>
                                    <td><a href="#" id="<?php echo $users->user_id; ?>" class="btn btn-danger lock_user" data-toggle="modal" data-target="#LockUserModal" </a><i class="fas fa-trash-alt"></i> Lock</td>
                                </tr>
                                </tbody>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in active" id="inactive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Activate</th>
                                    <th>Override</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($data['ia_users'] as $ia_users) : ?>
                                <tr>
                                    <td>
                                        <?php echo $ia_users->first_name . ' ' . $ia_users->last_name; ?>
                                    </td>
                                    <td><a href="#" id="<?php echo $ia_users->user_id; ?>" class="btn btn-primary edit_user" data-toggle="modal" data-target="#EditUserModal"</a><i class="fas fa-edit"> Edit</td>
                                    <?php if($ia_users->verified == 1) : ?>
                                        <td><a href="#" id="<?php echo $ia_users->user_id; ?>" class="btn btn-success ia_activate_user" data-toggle="modal" data-target="#ActivateUserModal" </a><i class="fas fa-thumbs-up"></i> Activate</td>
                                        <td><a href="#" id="<?php echo $ia_users->user_id; ?>" class="btn btn-success disabled ia_override_user" data-toggle="modal" data-target="#OverrideActivationModal"</a><i class="fas fa-jedi"></i> Override</td>
                                    <?php else:?>
                                        <td><a href="#" id="<?php echo $ia_users->user_id; ?>" class="btn btn-success disabled ia_activate_user" data-toggle="modal" data-target="#ActivateUserModal"</a><i class="fas fa-thumbs-up"></i> Activate</td>
                                        <td><a href="#" id="<?php echo $ia_users->user_id; ?>" class="btn btn-success ia_override_user" data-toggle="modal" data-target="#OverrideActivationModal"</a><i class="fas fa-jedi"></i> Override</td>
                                    <?php endif;?>    
                                        
                                        <td><a href="#" id="<?php echo $ia_users->user_id; ?>" class="btn btn-danger delete_user" data-toggle="modal" data-target="#DeleteUserModal"</a><i class="fas fa-jedi"></i> Delete</td>
                                    
                                </tr>
                                </tbody>
                                <?php endforeach; ?>
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
