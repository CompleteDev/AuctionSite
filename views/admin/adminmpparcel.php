<?php require APPROOT . '/views/admin/inc/header.php'?>
<div id="PID" style="display: none"><?php echo $data['PID']; ?></div>
<div class="container-fluid">
	<div class="row mt-5">
		<div class="col-md-12 text-center">
			<div id="ParcelTitle"></div><span> <button class="btn btn-primary editParcelTitle">Edit Title</button> </span>
		</div>
	</div>
	<hr>
	<div class="row mt-2">
		<div class="col-md-6">
			<div class="card">
				<div class="row m-2">
					<div class="col-md-4 text-center">
						<button class="btn btn-primary btn-block EditParcelImages">Edit Image</button>
					</div>
				</div>
				<hr>
				<div class="row m-1">
					<div class="col-md-12">
						<div id="ParcelImage"></div>
					</div>
				</div>

			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="row m-2">
					<div class="col-md-4 text-center">
						<button class="btn btn-primary btn-block EditParcelDescription" data-toggle="modal" data-target="#InsertUpdateParcelDescription">Edit Description</button>
					</div>
					<hr>
					<div class="row mt-1">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="col-md-12">
										<div style="height:300px;overflow-y: scroll;">
											<div id="ParcelDescriptionID"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row mt-2">
		<div class="col-md-2">
			<button class="btn btn-primary btn-block editParcelStartingPrice">Edit Starting Price</button>
		</div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-block editParcelAcres">Edit Acres</button>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-block editMPType">Edit Auction Type</button>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-block editParcelIncrement">Edit Increment</button>
        </div>
	</div>
	<div class="row mt-2">
		<div class="col-md-2">
			<h5>Starting Price</h5>
		</div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <h5>Parcel Acres</h5>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <h5>Auction Type</h5>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <h5>Bidding Increment</h5>
        </div>
	</div>
	<div class="row mt-2">
		<div class="col-md-2">
			<div class="form-group">
				<input id="Parcel_Start_Bid" readonly name="Parcel_Start_Bid" class="form-control">
			</div>
		</div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <div class="form-group">
                <input id="Parcel_Acres" readonly name="Parcel_Acres" class="form-control">
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <input id="mp_Type" readonly name="mp_Type" class="form-control">
            </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <input id="mp_Increment" readonly name="mp_Increment" class="form-control">
        </div>
        </div>
	</div>
	<br>
	<div class="row mb-5">
	</div>
</div>
<?php require APPROOT . '/views/admin/inc/footer.php'?>
<script>

    Dropzone.autoDiscover = false;
    $(document).ready(function ()
    {
        const PID = document.getElementById('PID').innerHTML;
        ShowParcelTitle();
        GetParcelImage();
        GetParcelDescription();
        GetStartingBid();
        GetParcelType();
        GetParcelIncrement();
        GetTotalAcres();

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

        function GetParcelImage()
        {
            const fd = new FormData()
            let ImageDiv = '';
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelFirstImage",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            ImageDiv = ImageDiv + '<img class="img-fluid portfolioImage" src="https://www.landmarketers.com/public/img/placeholder.jpg" alt="Listing Image">';
                        }
                        else
                        {
                            ImageDiv = ImageDiv + '<img class="img-fluid portfolioImage" src="https://www.landmarketers.com/public/img/' + data.parcel_img_name + '" alt="Listing Image">';
                        }
                        document.getElementById('ParcelImage').innerHTML = ImageDiv;
                    }
                }
            )
        }

        $(document).on('click', '.EditParcelImages', function ()
        {
            document.getElementById('TheModalTitle').innerHTML = "Parcel Images";

            let ModalBody = '<div class="row">\n' +
                '        <div class="col-md-12">\n' +
                '<div class="dropzone dz-square" id="dropzone-example"></div>' +
                '           </form>' +
                '        </div>' +
                '    </div>' +
                '<hr>' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<button type="submit" id="newCLInsert" class="btn btn-warning btn-block closeParcelImages" >Close</button>' +
                '</div>' +
                '</div><br>';
            ModalBody = ModalBody + '<div class="card">' +
                '<div class="card-body">' +
                '<h5 class="card-title">Current Images</h5>' +
                '<div class="row">' +
                '<div class="col-md-12 mb-1">' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<div id="CurrentImagesTable"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<br>';
            document.getElementById('TheModalFormBody').innerHTML = ModalBody;
            $('#TheModal').modal('show');
            LoadTheImages();
            Dropzone.autoDiscover = false;
            const myDropzone = new Dropzone("div#dropzone-example", { url: "https://www.landmarketers.com/AdminMP/UpdateParcelImages/" + PID});
            myDropzone.on("complete", function ()
            {
                LoadTheImages();
            });

        });

        $(document).on('click', '.closeParcelImages', function ()
        {
            $('#TheModal').modal('hide');
            LoadTheImages();
        });

        function LoadTheImages()
        {
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelImages",
                    method: "POST",
                    data: {PID:PID},
                    dataType: 'json',
                    success: function (data)
                    {
                        let ImgTable = '<table class="table table-bordered table-responsive striped" id="ImageTable"> <thead class="thead-dark"> <tr> <th>Image ID</th><th>Image</th> <th>Order</th><th>Remove</th> </tr> </thead> <tbody>';
                        for(let i = 0; i < data.length; i++)
                        {
                            ImgTable = ImgTable + '<tr id="' + data[i].parcel_img_id  + '">' + '<td>' + data[i].parcel_img_id + '</td>' + '<td>' + '<img src="https://www.landmarketers.com/public/img/' + data[i].parcel_img_name + '" class="img-fluid img-thumbnail rounded float-left mw-5 w-25">' + '</td>' + '<td>' + data[i].parcel_img_order +  '</td>';
                            ImgTable = ImgTable + '<td>' + '<a href="#" id="' + data[i].parcel_img_id + '" class="deleteImage" data-toggle="modal" data-target="#deleteImage"</a><i class="fas fa-trash-alt"></i></td>';
                            ImgTable = ImgTable + '</tr>';
                        }
                        ImgTable = ImgTable + '</tbody> </table>';
                        document.getElementById('CurrentImagesTable').innerHTML = ImgTable;

                        //ImageDnD();
                    }
                });
        }

        $(document).on('click','.deleteImage', function ()
        {
            const fd = new FormData()
            const ImageID = $(this).attr("id");
            fd.append('PID', PID);
            fd.append('ImageID', ImageID);
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/DeleteImage",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'Done')
                        {
                            LoadTheImages();
                        }
                    }
                }
            )

        });

        function ImageDnD()
        {
            let $sortable = $( "#ImageTable > tbody");
            $sortable.sortable({
                stop: function ( event, ui) {
                    let parameters = $sortable.sortable("toArray");
                    $.post("https://www.landmarketers.com/AdminMP/UpdateImageOrder",{value:parameters},function (results)
                    {
                        if(data.results === 'Done')
                        {
                            LoadTheImages();
                        }

                    });
                }
            });
        }

        $(document).on('click', '.closeDropZoneBox', function ()
        {
            window.location.reload();
        });

        function GetParcelDescription()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelDescriptions",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById('ParcelDescriptionID').innerHTML = 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.';
                        }
                        else
                        {
                            document.getElementById('ParcelDescriptionID').innerHTML = data.parcel_desc;
                        }
                    }
                }
            )
        }

        $(document).on('click', '.EditParcelDescription', function ()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelDescriptions",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            $('.summernote').eq(10).summernote('code', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.');
                        }
                        else
                        {
                            $('.summernote').eq(10).summernote('code', data.parcel_desc);
                        }
                    }
                }
            )
        });

        $(document).on('click', '.UpdateParcelDesc', function (e)
        {
            e.preventDefault();
            const fd = new FormData();
            let FormValid = true;
            const PDesc = $('.summernote').eq(10).summernote('code');
            if(PDesc == '')
            {
                FormValid = false;
                alert("Please enter a description");
            }
            if(FormValid == true)
            {
                fd.append('PDesc', PDesc);
                fd.append('PID', PID)
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/UpdateInsertParcelDesc",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            if(data.results === 'Done')
                            {
                                $('#closeInsertUpdatePDescription').click();
                                window.location.reload();
                            }
                        }

                    }
                )
            }
        });

        $(document).on('click', '.editParcelTitle', function ()
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
                        document.getElementById('TheModalTitle').innerHTML = "Edit Title";
                        let ModalBody =
                            '<div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label for="body">Title</label>' +
                            '<input type="text" name="ParcelUpdateTitle" id="ParcelUpdateTitle" class="form-control form-control-sm" value="' + data.parcel_title + '">'+
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<button class="btn-success btn-block UpdateParcelTitle">Update</button>' +
                            '</div>' +
                            '</div>';
                        document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                        $('#TheModal').modal('show');
                    }
                }
            )
        });

        $(document).on('click', '.UpdateParcelTitle', function ()
        {
            let FormValid = true;
            const fd = new FormData();
            fd.append('PID', PID)
            const ParcelTitle = document.getElementById('ParcelUpdateTitle').value;
            if(ParcelTitle == '')
            {
                FormValid = false;
                alert("Enter a Title");
            }
            if(FormValid == true)
            {
                fd.append('ParcelTitle', ParcelTitle)
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/UpdateParcelTitle",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            if(data.results === 'Done')
                            {
                                window.location.reload();
                            }
                        }

                    }
                )
            }
        });

        function GetStartingBid()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetStartingBid",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById('Parcel_Start_Bid').value = 'Add Starting Bid';
                        }
                        else
                        {
                            document.getElementById('Parcel_Start_Bid').value = data.parcel_starting_bid;
                        }
                    }
                }
            )
        }

        $(document).on('click', '.editParcelStartingPrice', function ()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetStartingBid",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        document.getElementById('TheModalTitle').innerHTML = "Edit Starting Bid";
                        let ModalBody =
                            '<div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label for="body">Title</label>';
                        if(data.results === 'None')
                        {
                            ModalBody = ModalBody + '<input type="text" name="ParcelStartingBid" id="ParcelStartingBid" class="form-control form-control-sm" value="0.00">';
                        }
                        else
                        {
                            ModalBody = ModalBody + '<input type="text" name="ParcelStartingBid" id="ParcelStartingBid" class="form-control form-control-sm" value="' + data.parcel_starting_bid + '">';
                        }
                           ModalBody = ModalBody +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<button class="btn-success btn-block UpdateInsertStartingBid">Update</button>' +
                            '</div>' +
                            '</div>';
                        document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                        $('#TheModal').modal('show');
                    }
                    }
            )
        });

        $(document).on('click', '.UpdateInsertStartingBid', function (e)
        {
            e.preventDefault();
            const fd = new FormData();
            let FormValid = true;
            const StartingBid = document.getElementById('ParcelStartingBid').value;
            if(StartingBid == '' || StartingBid == '0.00' || isNaN(StartingBid))
            {
                FormValid = false;
                alert("Please enter a Valid Starting Bid");
            }
            if(FormValid == true)
            {
                fd.append('StartingBid', StartingBid);
                fd.append('PID', PID)
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/UpdateInsertStartingBid",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            if(data.results === 'Done')
                            {
                                window.location.reload();
                            }
                        }

                    }
                )
            }
        })

        function GetParcelType()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelAuctionType",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById('mp_Type').value = 'Add Starting Type';
                        }
                        else
                        {
                            if(data.parcel_type == 0)
                            {
                                document.getElementById('mp_Type').value = "By Price";
                            }
                            else
                            {
                                document.getElementById('mp_Type').value = "By Acre";
                            }
                        }
                    }
                }
            )
        }

        $(document).on('click', '.editMPType', function ()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelAuctionType",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        document.getElementById('TheModalTitle').innerHTML = "Edit Auction Type";
                        let ModalBody =
                            '<div class="col-md-12">' +
                            '<div class="form-group">' +
                             '<label for="byAcre">Auction Type</label>' +
                                '<select id="editAuctionType" type="text" name="editAuctionType" class="form-control">' +
                             '<option value="1">By Acre</option>' +
                             '<option value="0">By Price</option>' +
                             '</select>' +
                            '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<button class="btn-success btn-block UpdateAuctionType">Update</button>' +
                            '</div>' +
                            '</div>';
                        document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                        $('#TheModal').modal('show');
                    }
                }
            )
        });

        $(document).on('click', '.UpdateAuctionType', function (e)
        {

            e.preventDefault();
            const fd = new FormData();
            let FormValid = true;
            const ParcelAuctionType = document.getElementById('editAuctionType').value;
            if(FormValid == true)
            {
                fd.append('ParcelAuctionType', ParcelAuctionType);
                fd.append('PID', PID)
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/InsertUpdateAuctionType",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            if(data.results === 'Done')
                            {
                                window.location.reload();
                            }
                        }

                    }
                )
            }
        });

        function GetParcelIncrement()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelIncrement",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById('mp_Increment').value = 'Add Increment';
                        }
                        else
                        {
                            document.getElementById('mp_Increment').value = data.parcel_increment;
                        }
                    }
                }
            )
        }

        $(document).on('click', '.editParcelIncrement', function ()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/SetParcelInc",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            alert("You must set an auction type before you can set the increment");
                        }
                        else
                        {
                            document.getElementById('TheModalTitle').innerHTML = "Edit Auction Type";
                            let ModalBody =
                                '<div class="col-md-12">' +
                                '<div class="form-group">' +
                                '<label for="byAcre">Bid Increment</label>' +
                                '<select id="editAuctionIncrement" type="text" name="editAuctionIncrement" class="form-control">';
                            if(data.parcel_type == 1)
                            {
                                ModalBody = ModalBody + '<option value="25">25</option>' +
                                                        '<option value="50">50</option>' +
                                                        '<option value="75">75</option>' +
                                                        '<option value="100">100</option>';
                            }
                            else
                            {
                                ModalBody = ModalBody + '<option value="1000">1000</option>' +
                                                        '<option value="5000">5000</option>' +
                                                        '<option value="7500">7500</option>' +
                                                        '<option value="10000">10000</option>';
                            }
                                ModalBody = ModalBody + '</select>' +
                                '</div>' +
                                '</div>' +
                                '<div class="row">' +
                                '<div class="col-md-12">' +
                                '<button class="btn-success btn-block UpdateAuctionIncrement">Update</button>' +
                                '</div>' +
                                '</div>';
                            document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                            $('#TheModal').modal('show');
                            GetIncrement();
                        }
                    }
                }
            )
        });

        function GetIncrement()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelIncrement",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        document.getElementById('editAuctionIncrement').value = parseInt(data.parcel_increment);
                    }
                }
            )
        }

        $(document).on('click','.UpdateAuctionIncrement',function ()
        {
            const fd = new FormData()
            const PIncr = document.getElementById('editAuctionIncrement').value;
            fd.append('PID', PID)
            fd.append('PIncr', PIncr);
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/UpdateInsertInc",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'Done')
                        {
                            $('#TheModal').modal('hide');
                            GetIncrement();
                        }
                    }
                }
            )
        });

        function GetTotalAcres()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelAcres",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById('Parcel_Acres').value = 'Add Acres';
                        }
                        else
                        {
                            document.getElementById('Parcel_Acres').value = data.parcel_acres;
                        }
                    }
                }
            )
        }

        $(document).on('click','.editParcelAcres', function ()
        {
            const fd = new FormData()
            fd.append('PID', PID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcelAcres",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        document.getElementById('TheModalTitle').innerHTML = "Edit Acres";
                        let ModalBody =
                            '<div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label for="body">Title</label>';
                        if(data.results === 'None')
                        {
                            ModalBody = ModalBody + '<input type="text" name="ParcelAcres" id="ParcelAcres" class="form-control form-control-sm" value="0.00">';
                        }
                        else
                        {
                            ModalBody = ModalBody + '<input type="text" name="ParcelAcres" id="ParcelAcres" class="form-control form-control-sm" value="' + data.parcel_acres + '">';
                        }
                        ModalBody = ModalBody +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<button class="btn-success btn-block UpdateInsertParcelAcres">Update</button>' +
                            '</div>' +
                            '</div>';
                        document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                        $('#TheModal').modal('show');
                    }
                }
            )
        });

        $(document).on('click','.UpdateInsertParcelAcres', function (e)
        {
            e.preventDefault();
            let FormValid = true;
            const fd = new FormData()
            const Acres = document.getElementById('ParcelAcres').value;
            if(Acres == '' || isNaN(Acres))
            {
                FormValid = false;
                alert("Enter a valid number for Acres");
            }
            if(FormValid == true)
            {
                fd.append('PID', PID)
                fd.append('Acres', Acres);
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/UpdateInsertParcelAcres",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            if(data.results === 'Done')
                            {
                                $('#TheModal').modal('hide');
                                GetTotalAcres();
                            }
                        }
                    }
                )
            }

        })

});
</script>

