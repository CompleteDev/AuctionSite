<?php require APPROOT . '/views/admin/inc/header.php'?>
<!-- LOGIN -->
<section id="login">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>Account Login</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo URLROOT;?>/admin/adminlogin" method="post">
                            <?php flash('register_success');?>
                            <div class="form-group">
                                <label for="name">Email: <sup>*</sup></label>
                                <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                                       value="<?php echo $data['email']; ?>">
                                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password: <sup>*</sup></label>
                                <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                                       value="<?php echo $data['password']; ?>">
                                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                            </div>
                            <input type="submit" value="Login" class="btn btn-primary btn-block">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/views/admin/inc/footer.php'?>
