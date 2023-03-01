<nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0">
    <div class="container">
        <a href="<?php echo URLROOT; ?>" class="navbar-brand"><?php echo SITENAME; ?></a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item px-2">
                    <a href="<?php echo URLROOT; ?>/admin" class="nav-link active">Dashboard</a>
                </li>
                <li class="nav-item px-2">
                    <a href="<?php echo URLROOT; ?>/admin/adminpages" class="nav-link active">Pages</a>
                </li>
                <li class="nav-item px-2">
                    <a href="<?php echo URLROOT; ?>/admin/adminstates" class="nav-link active">States</a>
                </li>
                <li class="nav-item px-2">
                    <a href="<?php echo URLROOT; ?>/admin/adminlistingtypes" class="nav-link active">Listing Types</a>
                </li>
                <li class="nav-item px-2">
                    <a href="<?php echo URLROOT; ?>/admin/adminusers" class="nav-link active">Users</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION['admin_id'])) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user"></i>Welcome, <?php echo $_SESSION['admin_name'];?>
                        </a>
                    </li>
                <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/admin/adminLogOut" class="nav-link">
                        <i class="fas fa-user-times"></i>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<header id="main-header" class="py-2 bg-primary text-white mb-2">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>
                    <i class="fas fa-cog"></i> Dashboard</h1>
            </div>
        </div>
    </div>
</header>