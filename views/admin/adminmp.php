<?php require APPROOT . '/views/admin/inc/header.php'?>
<div id="MPID" style="display: none"><?php echo $data['MPID']; ?></div>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <div id="MPTitle"></div><span> <button class="btn btn-primary editMPTitle">Edit Title</button> </span>
        </div>
    </div>
    <hr>
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card">
            <div class="row m-2">
                <div class="col-md-4 text-center">
                    <button class="btn btn-primary btn-block EditPrimaryImage">Edit Image</button>
                </div>
            </div>
            <hr>
                <div class="row m-1">
                    <div class="col-md-12">
                        <div id="MPAuctionMainMainImage"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
            <div class="row m-2">
                <div class="col-md-4 text-center">
                    <button class="btn btn-primary btn-block EditPrimaryDescription" data-toggle="modal" data-target="#InsertUpdateMPDescription">Edit Description</button>
                </div>
            <hr>
                <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12">
                                <div style="height:300px;overflow-y: scroll;">
                                    <div id="MPAuctionPrimaryDescriptionID"></div>
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
            <button class="btn btn-primary btn-block editMPDates">Edit Dates</button>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-block InsertUpdateMPPDF">Add PDF</button>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-block InsertUpdateMPVideoLink">Add YouTube Link</button>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-2">
            <h5>Auction Start</h5>
        </div>
        <div class="col-md-2">
            <h5>Auction End</h5>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <h5>PDF</h5>
        </div>
        <div class="col-md-2">
            <h5>YouTube Link</h5>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-2">
            <div class="form-group">
                <input id="mp_Start" readonly name="mp_Start" class="form-control">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input id="mp_End" readonly name="mp_End" class="form-control">
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <div class="form-group">
                <input id="mp_PDF" readonly name="mp_PDF" class="form-control">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input id="mp_Video" readonly name="mp_Video" class="form-control">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-2">
            <h5>Terms and Conditions</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="TCDiv"></div>
        </div>
    </div>
    <hr>
    <div class="row mt-2">
        <div class="col-md-4">
            <button class="btn btn-primary btn-block addParcel">Add Parcel</button>
        </div>
    </div>
    <br>
    <div class="row mb-5">
        <div class="col-md-12">
            <div id="ParcelGrid"></div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/admin/inc/footer.php'?>
<script>

    Dropzone.autoDiscover = false;
    $(document).ready(function ()
    {
        const MPID = document.getElementById('MPID').innerHTML;
        ShowMPTitle();
        GetPrimaryImage();
        GetPrimaryDescription();
        LoadPDF();
        LoadVideo();
        LoadParcels();
        LoadMPDates();
        GetTCItems();

        function GetTCItems()
        {
            let TCGrid = '';
            TCGrid = TCGrid + '<table class="table table-striped id="MPTearms"><thead class="thead-dark">';
            TCGrid = TCGrid + '<tr><th>Name</th><th>Edit</th></tr>'
            TCGrid = TCGrid + '</thead><tbody>';
            TCGrid = TCGrid + '<tr><td>Legal Description</td><td><button class="btn editTermsCond" id="EditLegalDescription"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Title</td><td><button class="btn editTermsCond" id="EditTitle"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Minerals etc</td><td><button class="btn editTermsCond" id="EditMinerals"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Leases</td><td><button class="btn editTermsCond" id="EditLeases"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Farm Service Agency</td><td><button class="btn editTermsCond" id="EditFSA"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Property Condition</td><td><button class="btn editTermsCond" id="EditCondition"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Purchase Agreement</td><td><button class="btn editTermsCond" id="EditPurchaseAgreement"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Closing Expenses</td><td><button class="btn editTermsCond" id="EditClosingExpenses"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Closing Date</td><td><button class="btn editTermsCond" id="EditClosingDate"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Sale Procedure</td><td><button class="btn editTermsCond" id="EditSaleProcedure"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Default Remedies</td><td><button class="btn editTermsCond" id="EditRemedies"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Additional Disclosures</td><td><button class="btn editTermsCond" id="EditAdditionalDisclosures"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '<tr><td>Closing</td><td><button class="btn editTermsCond" id="EditClosing"><i class="fas fa-edit"></i></button></td></tr>';
            TCGrid = TCGrid + '</tbody></table>';
            document.getElementById('TCDiv').innerHTML = TCGrid;
        }

        $(document).on('click','.editTermsCond', function ()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            const TCTypeID = $(this).attr("id");
            let TCType = '';
            let TCName = '';
            let TCColumn = '';
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetTerms",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        switch (TCTypeID)
                        {
                            case 'EditLegalDescription':
                                TCType = data.legal_description;
                                TCName = "Legal Description";
                                TCColumn = 'legal_description';
                                break;
                            case 'EditTitle':
                                TCType = data.title;
                                TCName = "Title";
                                TCColumn = 'title';
                                break;
                            case 'EditMinerals':
                                TCType = data.mineral_etc;
                                TCName = "Minerals etc";
                                TCColumn = 'mineral_etc';
                                break;
                            case 'EditLeases':
                                TCType = data.leases;
                                TCName = 'Leases';
                                TCColumn = 'leases';
                                break;
                            case 'EditFSA':
                                TCType = data.farm_service_agency_info;
                                TCName = 'Farm Service Agency Info';
                                TCColumn = 'farm_service_agency_info';
                                break;
                            case 'EditCondition':
                                TCType = data.property_condition;
                                TCName = 'Condition';
                                TCColumn = 'property_condition';
                                break;
                            case 'EditPurchaseAgreement':
                                TCType = data.purchase_agreement
                                TCName = 'Purchase Agreement';
                                TCColumn = 'purchase_agreement';
                                break;
                            case 'EditClosingExpenses':
                                TCType = data.closing_expenses;
                                TCName = 'Closing Expenses';
                                TCColumn = 'closing_expenses';
                                break;
                            case 'EditClosingDate':
                                TCType = data.closing_date;
                                TCName = 'Closing Date';
                                TCColumn = 'closing_date';
                                break;
                            case 'EditSaleProcedure':
                                TCType = data.sale_procedure;
                                TCName = 'Sale Procedure';
                                TCColumn = 'sale_procedure';
                                break;
                            case 'EditRemedies':
                                TCType = data.default_remedies;
                                TCName = 'Remedies';
                                TCColumn = 'default_remedies';
                                break;
                            case 'EditAdditionalDisclosures':
                                TCType = data.additional_disclosures;
                                TCName = 'Additional Disclosures';
                                TCColumn = 'additional_disclosures';
                                break;
                            case 'EditClosing':
                                TCType = data.closing;
                                TCName = 'Closing';
                                TCColumn = 'closing';
                                break;
                        }
                        document.getElementById('TheModalTitle').innerHTML = "Edit " + TCName;
                        let ModalBody =
                            '<div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label for="body">' + TCName + '</label>' +
                            '<textarea name="MPUpdateTC" id="MPUpdateTC" class="form-control form-control-sm" rows="20">' + TCType + '</textarea>'+
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<button class="btn-success btn-block UpdateTheTerms" id="' + TCColumn + '">Update</button>' +
                            '</div>' +
                            '</div>';
                        document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                        $('#TheModal').modal('show');
                    }
                }
            )
        })

        $(document).on('click','.UpdateTheTerms', function (e)
        {
            e.preventDefault();
            let FormValid = true;
            const fd = new FormData()
            const TCTypeID = $(this).attr("id");
            const TCInfo = document.getElementById('MPUpdateTC').value;
            if(TCInfo == '')
            {
                FormValid = false;
                alert("Please enter proper information");
            }
            if(FormValid == true)
            {
                fd.append('MPID', MPID);
                fd.append('TCTypeID', TCTypeID);
                fd.append('TCInfo', TCInfo);
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/UpdateTerms",
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
                                GetTCItems();
                            }
                        }
                    }
                )

            }

        });

        function ShowMPTitle()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetMPAuctionTitle",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        document.getElementById('MPTitle').innerHTML = '<h1>' +  data.mp_title + '</h1>';
                    }
                }
            )
        }

        function GetPrimaryImage()
        {
            const fd = new FormData()
            let ImageDiv = '';
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetPrimaryImage",
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
                            ImageDiv = ImageDiv + '<img class="img-fluid portfolioImage" src="https://www.landmarketers.com/public/img/' + data.image_name + '" alt="Listing Image">';
                        }
                        document.getElementById('MPAuctionMainMainImage').innerHTML = ImageDiv;
                    }
                }
            )
        }

        $(document).on('click', '.EditPrimaryImage', function ()
        {
            document.getElementById('TheModalTitle').innerHTML = "Update Images";

            let ModalBody = '<div class="row">\n' +
                '        <div class="col-md-12">\n' +
                '<div class="dropzone dz-square" id="dropzone-example"></div>' +
                '           </form>' +
                '        </div>' +
                '    </div>';
            document.getElementById('TheModalFormBody').innerHTML = ModalBody;
            $('#TheModal').modal('show');
            Dropzone.autoDiscover = false;
            const myDropzone = new Dropzone("div#dropzone-example", {maxFiles: 1, url: "https://www.landmarketers.com/AdminMP/UpdateMPPrimaryImage/" + MPID,addRemoveLinks: true});

            myDropzone.on("complete", function ()
            {
                GetPrimaryImage();
                $('#TheModal').modal('hide');
            });
        });

        function GetPrimaryDescription()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetPrimaryDescriptions",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById('MPAuctionPrimaryDescriptionID').innerHTML = 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.';
                        }
                        else
                        {
                            document.getElementById('MPAuctionPrimaryDescriptionID').innerHTML = data.primary_desc;
                        }
                    }
                }
            )
        }

        $(document).on('click', '.EditPrimaryDescription', function ()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetPrimaryDescriptions",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            $('.summernote').eq(9).summernote('code', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.');
                        }
                        else
                        {
                            $('.summernote').eq(9).summernote('code', data.primary_desc);
                        }
                    }
                }
            )
        });

        $(document).on('click', '.UpdatePrimaryDesc', function (e)
        {
            e.preventDefault();
            const fd = new FormData();
            let FormValid = true;
            const MPDesc = $('.summernote').eq(9).summernote('code');
            if(MPDesc == '')
            {
                FormValid = false;
                alert("Please enter a description");
            }
            if(FormValid == true)
            {
                fd.append('MPDesc', MPDesc);
                fd.append('MPID', MPID)
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/UpdatePrimaryDescription",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            if(data.results === 'Done')
                            {
                                $('#closeInsertUpdateMPDescription').click();
                                window.location.reload();
                            }
                        }

                    }
                )
            }
        });

        $(document).on('click', '.editMPTitle', function ()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetMPAuctionTitle",
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
                            '<input type="text" name="MPUpdateTitle" id="MPUpdateTitle" class="form-control form-control-sm" value="' + data.mp_title + '">'+
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<button class="btn-success btn-block UpdateMPTitle">Update</button>' +
                            '</div>' +
                            '</div>';
                        document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                        $('#TheModal').modal('show');
                    }
                }
            )
        });

        $(document).on('click', '.UpdateMPTitle', function ()
        {
            let FormValid = true;
            const fd = new FormData();
            fd.append('MPID', MPID)
            const MPTitle = document.getElementById('MPUpdateTitle').value;
            if(MPTitle == '')
            {
                FormValid = false;
                alert("Enter a Title");
            }
            if(FormValid == true)
            {
                fd.append('MPTitle', MPTitle)
                fd.append('MPID', MPID);
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/UpdateMPTitle",
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

        function LoadMPDates()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetMPDates",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById("mp_Start").value = "Set Start Time";
                            document.getElementById("mp_End").value = "Set End Time";
                        }
                        else
                        {
                            document.getElementById("mp_Start").value = data.start_date + ' ' + data.start_time;
                            document.getElementById("mp_End").value = data.end_date + ' ' + data.end_time;
                        }
                    }
                }
            )
        }

        $(document).on('click', '.editMPDates', function ()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            let StartValue = '';
            let EndValue = '';
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetMPDates",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results != 'None')
                        {
                            StartValue = data.start_date + 'T' + data.start_time;
                            EndValue = data.end_date + 'T' + data.end_time
                        }
                        document.getElementById('TheModalTitle').innerHTML = "Edit Start/End";
                        let ModalBody = '<div class="form-group ">' +
                                        '<label for="Startdate">Start Date <sup>*</sup></label>';
                        ModalBody = ModalBody +  '<input type="datetime-local" id="StartTimeDate" value="' + StartValue + '">';
                        ModalBody = ModalBody + '</div>';
                        ModalBody = ModalBody + '<div class="form-group ">' +
                                         '<label for="Enddate">End Date <sup>*</sup></label>';
                        ModalBody = ModalBody +  '<input type="datetime-local" id="EndTimeDate" value="' + EndValue + '">';
                        ModalBody = ModalBody + '</div>';
                        ModalBody = ModalBody + '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<button class="btn-success btn-block setStartTime">Update</button>' +
                        '</div>';
                        document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                        $('#TheModal').modal('show');

                    }
                }
            )
        });

        $(document).on('click', '.setStartTime', function (e)
        {
            e.preventDefault();
            let FormValid = true;
            const fd = new FormData();
            const StartInput = document.getElementById('StartTimeDate').value;
            const StartDate = new Date(StartInput);
            const day = StartDate.getDate().toString().padStart(2, "0");
            const month = (1 + StartDate.getMonth()).toString().padStart(2, "0");
            const hour = StartDate.getHours().toString().padStart(2, "0");
            const minute = StartDate.getMinutes().toString().padStart(2, "0");
            const sec = StartDate.getSeconds().toString().padStart(2, "0");
            const ms = StartDate.getMilliseconds().toString().padStart(3, "0");
            const inputStartDate = StartDate.getFullYear() + "-" + (month) + "-" + (day) + "T" + (hour) + ":" + (minute) + ":" + (sec) + "." + (ms);

            const EndInput = document.getElementById('EndTimeDate').value;
            const EndDate = new Date(EndInput);
            const Endday = EndDate.getDate().toString().padStart(2, "0");
            const Endmonth = (1 + EndDate.getMonth()).toString().padStart(2, "0");
            const Endhour = EndDate.getHours().toString().padStart(2, "0");
            const Endminute = EndDate.getMinutes().toString().padStart(2, "0");
            const Endsec = EndDate.getSeconds().toString().padStart(2, "0");
            const Endms = EndDate.getMilliseconds().toString().padStart(3, "0");
            const inputEndDate = EndDate.getFullYear() + "-" + (Endmonth) + "-" + (Endday) + "T" + (Endhour) + ":" + (Endminute) + ":" + (Endsec) + "." + (Endms);
            if(StartInput == '')
            {
                FormValid = false;
                alert('Please Enter a start date, can be changed later on');
            }
            if(EndInput == '')
            {
                FormValid = false;
                alert('Please Enter an end date, can be changed later on');
            }
            if(FormValid == true)
            {
                const TheStartDate = StartDate.getFullYear() + "-" + (month) + "-" + (day);
                const TheEndDate = EndDate.getFullYear() + "-" + (Endmonth) + "-" + (Endday);
                const StartTime = (hour) + ":" + (minute) + ":" + (sec);
                const EndTime = (Endhour) + ":" + (Endminute) + ":" + (Endsec);
                fd.append('MPID', MPID);
                fd.append('TheStartDate', TheStartDate);
                fd.append('TheEndDate', TheEndDate);
                fd.append('StartTime', StartTime);
                fd.append('EndTime', EndTime);

                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/UpdateStartEnd",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            $('#TheModal').modal('hide');
                            LoadMPDates();
                        }
                    }
                )
            }
        });

        function LoadPDF()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetMPPDF",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById("mp_PDF").value = "Add PDF"
                        }
                        else
                        {
                            document.getElementById("mp_PDF").value = data.mp_pdf;
                        }
                    }
                }
            )
        }

        $(document).on('click','.InsertUpdateMPPDF', function ()
        {
            document.getElementById('TheModalTitle').innerHTML = "Update PDF";

            let ModalBody = '<div class="row">\n' +
                '        <div class="col-md-12">\n' +
                '<div class="dropzone dz-square" id="dropzone-example"></div>' +
                '           </form>' +
                '        </div>' +
                '    </div>';
            document.getElementById('TheModalFormBody').innerHTML = ModalBody;
            $('#TheModal').modal('show');
            Dropzone.autoDiscover = false;
            const myDropzone = new Dropzone("div#dropzone-example", {maxFiles: 1, url: "https://www.landmarketers.com/AdminMP/InsertUpdatePDF/" + MPID});

            myDropzone.on("complete", function ()
            {
                LoadPDF();
                $('#TheModal').modal('hide');
            });
        });

        $(document).on('click','.UpdateMPPDF',function ()
        {
            let FormValid = true;
            const fd = new FormData();
            fd.append('MPID', MPID)
            const MPPDF = document.getElementById('MPUpdatePDF').value;
            if(MPPDF == '')
            {
                FormValid = false;
                alert("Enter a PDF");
            }
            if(FormValid == true)
            {
                fd.append('MPPDF', MPPDF)
                fd.append('MPID', MPID);
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/InsertUpdatePDF",
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

        function LoadVideo()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetMPVideo",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        if(data.results === 'None')
                        {
                            document.getElementById("mp_Video").value = "Add Video Link"
                        }
                        else
                        {
                            document.getElementById("mp_Video").value = data.mp_video;
                        }
                    }
                }
            )
        }

        $(document).on('click','.InsertUpdateMPVideoLink',function ()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetMPVideo",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        document.getElementById('TheModalTitle').innerHTML = "Edit Video";
                        let ModalBody =
                            '<div class="col-md-12">' +
                            '<div class="form-group">' +
                            '<label for="body">Video</label>';
                        if(data.results === 'None')
                        {
                            ModalBody = ModalBody + '<input type="text" name="MPUpdateVideo" id="MPUpdateVideo" class="form-control form-control-sm" value="Add Video">';
                        }
                        else
                        {
                            ModalBody = ModalBody + '<input type="text" name="MPUpdateVideo" id="MPUpdateVideo" class="form-control form-control-sm" value="' + data.mp_video + '">';
                        }
                        ModalBody = ModalBody + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-12">' +
                            '<button class="btn-success btn-block UpdateMPVideo">Update</button>' +
                            '</div>' +
                            '</div>';
                        document.getElementById('TheModalFormBody').innerHTML = ModalBody;
                        $('#TheModal').modal('show');
                    }
                }
            )
        });

        $(document).on('click','.UpdateMPVideo', function (e)
        {
            e.preventDefault();
            let FormValid = true;
            const fd = new FormData();
            fd.append('MPID', MPID)
            const MPVideo = document.getElementById('MPUpdateVideo').value;
            if(MPVideo == '')
            {
                FormValid = false;
                alert("Enter a Video");
            }
            if(FormValid == true)
            {
                fd.append('MPVideo', MPVideo)
                fd.append('MPID', MPID);
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/InsertUpdateMPVideo",
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

        function LoadParcels()
        {
            const fd = new FormData()
            fd.append('MPID', MPID)
            let Parcels = '';
            $.ajax
            (
                {
                    url: "https://www.landmarketers.com/AdminMP/GetParcels",
                    method: "POST",
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        Parcels = Parcels + '<table class="table table-striped id="MPParcelTable"><thead class="thead-dark">';
                        Parcels = Parcels + '<tr><th>Name</th><th>Edit</th><th>View</th><th>History</th></tr>'
                        Parcels = Parcels + '</thead><tbody>';
                        for(let i = 0; i < data.length; i++)
                        {
                            Parcels = Parcels + '<tr>';
                            Parcels = Parcels + '<td>' + data[i].parcel_title  + '</td>';
                            Parcels = Parcels + '<td><button class="btn EditThisParcel" id="' + data[i].parcel_id + '"><i class="fas fa-edit"></i></button></td>';
                            Parcels = Parcels + '<td><button class="btn ViewThisParcel" id="' + data[i].parcel_id + '"><i class="fas fa-eye fa-2x"></i></button></td>';
                            Parcels = Parcels + '<td><button class="btn ViewHistory" id="' + data[i].parcel_id + '"><i class="fas fa-clipboard"></i></button></td>';
                            Parcels = Parcels + '</tr>';
                        }
                        Parcels = Parcels + '</tbody></table>';
                        document.getElementById('ParcelGrid').innerHTML = Parcels;
                    }
                }
            )
        }

        $(document).on('click', '.ViewHistory', function ()
        {
            const PID = $(this).attr("id");
            window.open("https://www.landmarketers.com/admin/MPBidInfo/" + PID);
        })

        $(document).on('click', '.ViewThisParcel', function ()
        {
            const PID = $(this).attr("id");
            window.open("https://www.landmarketers.com/Pages/mpacutionpage/" + PID);
        })

        $(document).on('click', '.EditThisParcel', function ()
        {
            const PID = $(this).attr("id");
            window.open("https://www.landmarketers.com/admin/adminmpparcel/" + PID);
        });

        $(document).on('click', '.addParcel', function ()
        {
            document.getElementById('TheModalTitle').innerHTML = "Add Parcel";
            let ModalBody =
                '<div class="col-md-12">' +
                '<div class="form-group">' +
                '<label for="body">Title</label>' +
                '<input type="text" name="ParcelTitle" id="ParcelTitle" class="form-control form-control-sm">'+
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-12">' +
                '<button class="btn-success btn-block CreateParcel">Create</button>' +
                '</div>' +
                '</div>';
            document.getElementById('TheModalFormBody').innerHTML = ModalBody;
            $('#TheModal').modal('show');
        });

        $(document).on('click', '.CreateParcel', function (e)
        {
            e.preventDefault();
            let FormValid = true;
            const fd = new FormData();
            const ParcelTitle = document.getElementById('ParcelTitle').value;
            if(ParcelTitle == '')
            {
                FormValid = false;
                alert("Please enter a Parcel Title");
            }
            if(FormValid == true)
            {
                fd.append('ParcelTitle', ParcelTitle);
                fd.append('MPID', MPID);
                $.ajax
                (
                    {
                        url: "https://www.landmarketers.com/AdminMP/CreateParcel",
                        method: "POST",
                        data: fd,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (data)
                        {
                            if(data.results == "Done")
                            {
                                $('#TheModal').modal('hide');
                                LoadParcels();
                            }
                        }
                    }
                )
            }
        });

    });
</script>
