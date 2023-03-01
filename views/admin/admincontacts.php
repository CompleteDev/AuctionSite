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
                            <a href="#" class="navbar-brand"><h4>Contacts</h4></a>
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
                    <div id="ContactGrid"></div>
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
        LoadContactGrid();
        function LoadContactGrid()
        {
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/Admin/GetContactList",
                    method: "POST",
                    dataType: 'json',
                    success: function (data)
                    {
                        let ContactTable = '<table class="table table-responsive table-striped"> <thead class="thead-dark"> <tr><th>Email</th></tr></thead > <tbody>';
                        for(let i = 0; i < data.length; i++)
                        {
                            ContactTable = ContactTable + '<tr><td>' + data[i].contact_email + '</td>';

                            ContactTable = ContactTable + '</tr>';
                        }
                        ContactTable = ContactTable + '</tbody> </table>';
                        document.getElementById('ContactGrid').innerHTML = ContactTable;

                    }
                }
            )
        }

    });
</script>
