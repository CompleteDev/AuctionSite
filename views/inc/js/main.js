//Watch A listing
document.getElementById('WatchListingBTN').addEventListener('click', watchListing);
//Bid On Auction
document.getElementById('BidBTN').addEventListener('click', bidOnAuction);
//Close Terms Modal
document.getElementById('AgreedSubmit').addEventListener('click', closeTerms);
//Log In
document.getElementById('UserLogInSubmit').addEventListener('click', loginFunction);


function loginFunction(e)
{
    e.preventDefault();
    const fd = new FormData($('UserLoginModal')[0]);
    const UserName = document.getElementById('userName').value;
    const Password = document.getElementById('userPassword').value;
    fd.append('Password', Password);
    fd.append('UserName', UserName);

    $.ajax({

        url: "https://landmarketers.com/Users/ModalLogIn",
        method: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: function (data)
        {
            if(data.Re)
                $('#closeUserLoginModal').click();
            location.reload();
        }
    });

}

    function watchListing(e)
    {

        e.preventDefault();

        const fd = new FormData($('#WatchListingForm')[0]);
        const ListingID = document.getElementById('ListingID').value;
        const UserID = document.getElementById('UserID').value;

        fd.append('ListingID', ListingID);
        fd.append('UserID', UserID);


        $.ajax({

            url: "https://landmarketers.com/Users_Interactions/addToWatchList",
            method: "POST",
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#closeWatchListing').click();
                location.reload();
            }
        });

    }

    function bidOnAuction(e)
    {
        e.preventDefault();
        const fd = new FormData($('#BidForm')[0]);
        const minBid = document.getElementById('minBid').value;
        const ListingID = document.getElementById('AuctionID').value;
        const UserID = document.getElementById('UserID').value;
        const newBid = document.getElementById('newBid').value;

        fd.append('minBid', minBid);
        fd.append('ListingID', ListingID);
        fd.append('UserID', UserID);
        fd.append('newBid', newBid);
        if(isNaN(newBid))
        {
            alert('Enter a valid number');
            document.getElementById('newBid').value = '';
            $('#newBid').focus();
        }
        else
        {
            if(newBid <= minBid)
            {
                alert('Bid must be greater than or equal to minimum bid');
                document.getElementById('newBid').value = '';
                $('#newBid').focus();
            }
            else
            {
                $.ajax({

                    url: "https://landmarketers.com/Users_Interactions/placeBid",
                    method: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#closeBidForm').click();
                        location.reload();
                    }
                });
            }
        }
    }



    //show Terms and conditions


    function closeTerms()
    {
        $('#closeTermsandConditionsModal').click();
    }

$('i').children().css("color","#ffffff");