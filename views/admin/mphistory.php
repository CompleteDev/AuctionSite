<?php require APPROOT . '/views/admin/inc/header.php'?>

<div class="container m-5">
	<div id="PID" style="display: none"><?php echo $data['PID']; ?></div>
	<div class="col-md-12 text-center">
		<div id="ParcelTitle"></div>
	</div>
	<hr>
	<h1>Bidding History</h1>
	<br>
	<div id="bidData"></div>

</div>
<?php require APPROOT . '/views/admin/inc/footer.php'?>

<script>
    $(document).ready(function()
    {
        const PID = document.getElementById('PID').innerHTML;
        ShowParcelTitle();

        let intTime = 1000;
        setInterval(function()
        {
            RefreshBidPage();
        }, intTime);

        function ShowParcelTitle()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelTitle",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        document.getElementById('ParcelTitle').innerHTML = '<h1>' +  data.parcel_title + '</h1>';
                    }
                }
            )
        }
        function RefreshBidPage()
        {
            const PID = document.getElementById('PID').innerHTML;
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/bidInfo",
                    method: "POST",
                    data: {PID:PID},
                    dataType:"json",
                    success: function (data)
                    {
                        let bidgrid = '<table class="table table-striped"> <thead class="thead-dark"> <tr> <th>Amount</th> <th>Date</th> <th>Name</th> <th>Number</th> <th>Bid Type</th> </tr> </thead> <tbody>';
                        for(let i = 0; i < data.length; i++)
                        {
                            bidgrid = bidgrid + '<tr>' + '<td>' + data[i].bid_amount + '</td>' + '<td>' + data[i].bid_date + '</td>' + '<td>' + data[i].first_name + ' ' +  data[i].last_name + '</td>' + '<td>' + data[i].bid_number + '</td>' +  '<td>' + data[i].bid_type + '</td>' + '</tr>';
                        }
                        bidgrid = bidgrid + '</tbody> </table>';
                        document.getElementById('bidData').innerHTML = bidgrid;

                    }
                }
            );
        }

        //End Ready
    });
</script>



