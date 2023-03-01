<?php require APPROOT . '/views/admin/inc/header.php'?>

<div class="container m-5">
    <div id="pageAuctionID" style="display: none;">
        <?php echo $data['auctionid']->auction_id; ?>
    </div>
    <h1>Bidding History</h1>
            <div id="bidData"></div>

</div>
<?php require APPROOT . '/views/admin/inc/footer.php'?>

<script>
    $(document).ready(function()
    {
    let intTime = 1000;
    setInterval(function()
    {
        RefreshBidPage();
    }, intTime);


        function RefreshBidPage()
        {
            const AuctionID = document.getElementById('pageAuctionID').innerHTML;
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/admin/bidInfo",
                    method: "POST",
                    data: {AuctionID:AuctionID},
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



