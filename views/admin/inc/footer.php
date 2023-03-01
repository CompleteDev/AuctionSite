<!-- FOOTER -->
<footer id="main-footer" class="bg-dark text-white mt-3 p-3">
    <div class="row">
        <div class="col">
            <p class="lead">
                Copyright &copy;
                <span id="year"></span>
                <a href="#">Super Groovy CMS</a>
                <a class="float-right" href="https://powerpgs.com/"><img src="<?php echo URLROOT;?>/public/img/ppgslogo.png"/></a>
            </p>
        </div>
    </div>
</footer>
<!-- MODALS -->

<!-- ADD Listing MODAL -->
<div class="modal fade" id="addListingModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Listing</h5>
                <button id="closeListing" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newListingForm">
                    <div class="form-check">
                        <input type="checkbox" id="liveAuctionCheckBox" name="liveAuctionCheckBox" class="form-check-input"><label for="liveAuctionCheckBox">Live Auction</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="commercialCheckBox" name="commercialCheckBox" class="form-check-input"><label for="commercialCheckBox">Commercial</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="cropCheckBox" name="cropCheckBox" class="form-check-input"><label for="cropCheckBox">Crop</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="hayCheckBox" name="hayCheckBox" class="form-check-input"><label for="hayCheckBox">Hay</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="rangeCheckBox" name="rangeCheckBox" class="form-check-input"><label for="rangeCheckBox">Range</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="recreationalCheckBox" name="recreationalCheckBox" class="form-check-input"><label for="Recreational">Recreational</label>
                    </div>
                    <div class="form-group">
                        <label for="Startdate">Start Date <sup>*</sup></label>
                        <input id="startdate" type="date" name="startdate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Enddate">End Date</label>
                        <input id="enddate" type="date" name="enddate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="City">City <sup>*</sup></label>
                        <input id="city" type="text" name="city" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="state">State <sup>*</sup></label>
                        <select id="state" type="text" name="state" class="form-control">
                            <?php foreach($data['states'] as $state_list) : ?>
                                <option value="<?php echo $state_list->state_id; ?>"><?php echo $state_list->state; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Zip">Zip Code <sup>*</sup></label>
                        <input id="zip" type="text" name="zip" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Title <sup>*</sup></label>
                        <input id="title" type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Acres <sup>*</sup></label>
                        <input id="acres" type="text" name="acres" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="info">Tag Line</label>
                        <textarea id="addinfo" name="tagline" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price <sup>*</sup></label>
                        <input id="price" type="text" name="price" class="form-control">
                    </div>
                    <div class="form-group">

                      <label for="image">Primary Image <sup>*</sup></label>
                        <div class="custom-file">
                            <input type='file' accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name='MainImage' id='mainImage' class='form-control'>
                            <!--<input type="file" name="files" class="custom-file-input" id="image" multiple>
                            <label for="image" class="custom-file-label">Choose File</label>-->
                        </div>
                    </div>
                    <div id="preview"></div>
                    <div class="form-group ">
                        <label for="body">Description <sup>*</sup></label>
                        <textarea id="editor1" name="editor1" class="form-control summernote"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="directions">Directions <sup>*</sup></label>
                        <textarea id="directions" name="editor2" class="form-control summernote"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="IsFeatured">Is Featured?</label>
                        <input type="checkbox" id="isFeatured" name="isFeatured">
                    </div>
                    <div class="form-group">
                        <label for="Addimages">Additional Images</label>
                        <div class="custom-file">
                            <input type="file" accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name="Additional_Images[]" id="add_imgs" multiple="multiple" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Addimages">Brochure</label>
                        <div class="custom-file">
                            <input type="file" accept=".pdf, .PDF" name="brochure" id="add_brochure" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Zip">YouTube URL <sup>*</sup></label>
                        <input id="yturl" type="text" name="yturl" class="form-control">
                    </div>
                    <input type="hidden" name="updateListingID" id="updateListingID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="ListingSubmit" class="btn btn-primary" >Add Listing</button>
            </div>
        </div>
    </div>
</div>

<!--Edit Home Page Modal -->
<div class="modal fade" id="editHomePage">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Home Page</h5>
                <button id="closeHomeUpdate" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editHomePage">
                    <div class="form-group">
                        <label for="title">Call to Action<sup>*</sup></label>
                        <input id="calltoaction" type="text" name="calltoaction" value="<?php echo $data['mainPageInfo']->call_to_action; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Phone Number<sup>*</sup></label>
                        <input id="phonenumber" type="text" name="phonenumber" value="<?php echo $data['mainPageInfo']->phone; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Email Address<sup>*</sup></label>
                        <input id="emailaddress" type="text" name="emailaddress" value="<?php echo $data['mainPageInfo']->email_us; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="image">Brand Image<sup>*</sup></label>
                        <div class="custom-file">
                            <img alt="" src="<?php echo URLROOT;?>/public/img/<?php echo $data['mainPageInfo']->brand_img; ?>">
                            <input type='file' name='updateMainImage' id='updateMainImage' class='form-control'>
                            <!--<input type="file" name="files" class="custom-file-input" id="image" multiple>
                            <label for="image" class="custom-file-label">Choose File</label>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Add Carousel Image<sup>*</sup></label>
                        <div class="custom-file">
                            <input type='file' name='CarouselImage' id='carouselImage' class='form-control'>
                            <!--<input type="file" name="files" class="custom-file-input" id="image" multiple>
                            <label for="image" class="custom-file-label">Choose File</label>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="carouselImages">Current Carousel Images</label>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>Image</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="title">Header<sup>*</sup></label>
                        <input id="mainInfoheader" type="text" name="mainInfoheader" value="<?php echo $data['mainPageInfo']->header; ?>" class="form-control">
                    </div>
                    <div class="form-group ">
                        <label for="body">Main Left <sup>*</sup></label>
                        <textarea id="editor3" name="editor3" class="form-control summernote"><?php echo $data['mainPageInfo']->main_info; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="directions">Main Right <sup>*</sup></label>
                        <textarea id="editor4" name="editor4" class="form-control summernote"><?php echo $data['mainPageInfo']->right_info; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title">Footer<sup>*</sup></label>
                        <input id="mainInfoFooter" type="text" name="mainInfoFooter" value="<?php echo $data['mainPageInfo']->footer_info; ?>" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="editHomePagebtn" class="btn btn-primary" >Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Services Page Modal -->
<div class="modal fade" id="editServicesPage">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Services</h5>
                <button id="closeEditServices" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editServicesPage">
                    <div class="form-group">
                        <label for="title">Service Header <sup>*</sup></label>
                        <textarea id="ServiceHeader" name="ServiceHeader" class="form-control"></textarea>
                    </div>
                    <div class="form-group ">
                        <label for="body">Services Bullet Points <sup>*</sup></label>
                        <textarea id="editor5" name="editor5" class="form-control summernote"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title">Land Management <sup>*</sup></label>
                        <input id="LMServiceHeader" type="text" name="LMServiceHeader" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Land Management Text <sup>*</sup></label>
                        <textarea id="LMtext" name="LMtext"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title">Land Health <sup>*</sup></label>
                        <input id="LHServiceHeader" type="text" name="LMServiceHeader" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Land Health Text <sup>*</sup></label>
                        <textarea id="LHtext" name="LHtext"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title">Financial Health <sup>*</sup></label>
                        <input id="FHServiceHeader" type="text" name="FHServiceHeader" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Financial Health Text <sup>*</sup></label>
                        <textarea id="FHtext" name="FHtext"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title">Relationships <sup>*</sup></label>
                        <input id="RELServiceHeader" type="text" name="RELServiceHeader" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Relationships Text <sup>*</sup></label>
                        <textarea id="RELtext" name="RELtext"  class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="UpdateServicesSubmit" class="btn btn-primary" >Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Associate Modal-->
<div class="modal fade" id="AddAssociateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Associate</h5>
                <button id="closeAssociateModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="AssociatesModal">
                    <div class="form-group">
                        <label for="title">Full Name <sup>*</sup></label>
                        <input id="associateFullName" type="text" name="associateFullName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Title <sup>*</sup></label>
                        <input id="associateTitle" type="text" name="associateTitle" class="form-control">
                    </div>
                    <div class="form-group">

                        <label for="image">Image <sup>*</sup></label>
                        <div class="custom-file">
                            <input type='file' name='associateImage' id='associateImage' class='form-control'>
                            <!--<input type="file" name="files" class="custom-file-input" id="image" multiple>
                            <label for="image" class="custom-file-label">Choose File</label>-->
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="body">About <sup>*</sup></label>
                        <textarea id="editor6" name="editor6" class="form-control summernote"></textarea>
                    </div>
                    <input type="hidden" name="associateID" id="associateID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="AddAssociateSubmit" class="btn btn-primary" >Insert</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Associate Modal-->
<div class="modal fade" id="DeleteAssociateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Delete Associate</h5>
                <button id="closeDeleteAssociateModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="AssociatesModal">
                    <div class="form-group">
                        <label for="title">Permanently Delete?</label>
                        <input id="deleteAssociateFullName" type="text" name="associateFullName" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="deleteAssociateID" id="deleteAssociateID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="DeleteAssociateSubmit" class="btn btn-danger" >Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Associate Modal-->
<div class="modal fade" id="DeleteUserModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Delete user</h5>
                <button id="closeDeleteUserModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="UserModal">
                    <div class="form-group">
                        <label for="title">Permanently Delete?</label>
                        <input id="deleteUserFullName" type="text" name="UserFullName" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="deleteUserID" id="deleteUserID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="DeleteUserSubmit" class="btn btn-danger" >Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Hide Listing Modal-->
<div class="modal fade" id="HideListingModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Hide Listing</h5>
                <button id="closeDeleteListingModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="HideListingModal">
                    <div class="form-group">
                        <label for="title">Hide Listing?</label>
                        <input id="hideListing" type="text" name="hideListing" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="hideListingID" id="hideListingID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="HideListingSubmit" class="btn btn-danger" >Hide</button>
            </div>
        </div>
    </div>
</div>

<!-- Show Listing Modal-->
<div class="modal fade" id="ShowListingModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Show Listing</h5>
                <button id="closeShowListingModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="HideListingModal">
                    <div class="form-group">
                        <label for="title">Show Listing?</label>
                        <input id="ShowListing" type="text" name="ShowListing" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="ShowListingID" id="ShowListingID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="ShowListingSubmit" class="btn btn-success">Show</button>
            </div>
        </div>
    </div>
</div>

<!-- Show Auction Modal -->
<div class="modal fade" id="ShowAuctionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Show Auction</h5>
                <button id="closeShowAuctionModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="HideListingModal">
                    <div class="form-group">
                        <label for="title">Show Auction?</label>
                        <input id="ShowAuction" type="text" name="ShowAuction" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="ShowAuctionID" id="ShowAuctionID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="ShowAuctionSubmit" class="btn btn-success">Show</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="HideAuctionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Hide Auction</h5>
                <button id="closeHideAuctionModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="HideListingModal">
                    <div class="form-group">
                        <label for="title">Hide Auction?</label>
                        <input id="HideAuction" type="text" name="HideAuction" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="HideAuctionID" id="HideAuctionID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="HideAuctionSubmit" class="btn btn-danger">Hide</button>
            </div>
        </div>
    </div>
</div>

<!-- Sold Listing Modal-->
<div class="modal fade" id="SoldListingModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Sold Listing</h5>
                <button id="closeSoldListingModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="HideListingModal">
                    <div class="form-group">
                        <label for="title">Sold Listing?</label>
                        <input id="SoldListing" type="text" name="SoldListing" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="SoldListingID" id="SoldListingID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="SoldListingSubmit" class="btn btn-success">Show</button>
            </div>
        </div>
    </div>
</div>

<!-- Add State Modal-->
<div class="modal fade" id="AddStateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add State</h5>
                <button id="closeAddStateModalModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="AssociatesModal">
                    <div class="form-group">
                        <label for="title">State</label>
                        <input id="AddState" type="text" name="AddState" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Abbreviation</label>
                        <input id="StateAbbreviation" type="text" name="StateAbbreviation" class="form-control">
                    </div>
                    <input type="hidden" name="stateID" id="stateID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="AddStateSubmit" class="btn btn-primary" >Add State</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete State Modal-->
<div class="modal fade" id="DeleteStateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Delete State</h5>
                <button id="closeDeleteStateModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="AssociatesModal">
                    <div class="form-group">
                        <label for="title">Permanently Delete?</label>
                        <input id="DeleteAddState" type="text" name="DeleteAddState" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="DeletestateID" id="DeletestateID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="DeletStateSubmit" class="btn btn-danger" >Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Users -->
<div class="modal fade" id="EditUserModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit User</h5>
                <button id="closeEditUserModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="EditUserModal">
                    <div class="form-group">
                        <label for="title">First Name <sup>*</sup></label>
                        <input id="userFirstName" type="text" name="userFirstName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Last Name <sup>*</sup></label>
                        <input id="userLastName" type="text" name="userLastName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Email Addresss <sup>*</sup></label>
                        <input id="userEmail" type="text" name="userEmail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Address <sup>*</sup></label>
                        <input id="userAddress" type="text" name="userAddress" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">City <sup>*</sup></label>
                        <input id="userCity" type="text" name="userCity" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">State <sup>*</sup></label>
                        <input id="userState" type="text" name="userState" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Zip <sup>*</sup></label>
                        <input id="userZip" type="text" name="userZip" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Primary Phone <sup>*</sup></label>
                        <input id="userPrimaryPhone" type="text" name="userPrimaryPhone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Bidder Number</label>
                        <input id="userBidderNumber" type="text" name="userBidderNumber" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="IsFeatured">Admin </label>
                        <input type="checkbox" id="isAdmin" name="isAdmin">
                    </div>
                    <input type="hidden" name="userID" id="userID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="EditUserModalSubmit" class="btn btn-primary" >Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Activate User -->
<div class="modal fade" id="ActivateUserModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Activate User</h5>
                <button id="closeActivateUserModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="AssociatesModal">
                    <div class="form-group">
                        <label for="title">Activate User</label>
                        <input id="ActivateUserName" type="text" name="ActivateUserName" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="ActivateUserID" id="ActivateUserID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="ActivateUserubmit" class="btn btn-success" >Activate</button>
            </div>
        </div>
    </div>
</div>

<!-- Override User -->
<div class="modal fade" id="OverrideActivationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Activate User</h5>
                <button id="closeOverrideActivationModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="OverrideModal">
                    <div class="form-group">
                        <label for="title">Override User</label>
                        <input id="OverrideUserName" type="text" name="OverrideUserName" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="OverRideUserID" id="OverRideUserID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="OverrideUserSubmit" class="btn btn-success" >Activate</button>
            </div>
        </div>
    </div>
</div>

<!-- Lock User -->
<div class="modal fade" id="LockUserModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Lock User</h5>
                <button id="closeLockUserModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="AssociatesModal">
                    <div class="form-group">
                        <label for="title">Lock User</label>
                        <input id="LockUserName" type="text" name="LockUserName" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="LockUserID" id="LockUserID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="LockUserubmit" class="btn btn-danger" >Lock</button>
            </div>
        </div>
    </div>
</div>

<!-- Send Message -->
<div class="modal fade" id="SendMessagelModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Send Messagel</h5>
                <button id="closeMessageModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="MessageModal">
                    <div class="form-group">
                        <label for="title">Message</label>
                        <input id="MessageTitle" type="text" name="MessageTitle" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Phone Number</label>
                        <input id="PhoneNumber" type="text" name="PhoneNumber" class="form-control">
                    </div>
                    <input type="hidden" name="TestimonialID" id="TestimonialID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="AddTestimonialSubmit" class="btn btn-primary" >Send Message</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Testimonial -->
<div class="modal fade" id="AddTestimonialModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="testTitle"></h5>
                <button id="closeAddTestimonialModalModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="TestimonialModal">
                    <div class="form-group ">
                        <label for="body">Testimonial <sup>*</sup></label>
                        <textarea id="editor7" name="editor7" class="form-control summernote"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title">Customer</label>
                        <input id="TestimonialCustomer" type="text" name="TestimonialCustomer" class="form-control">
                    </div>
                    <input type="hidden" name="TestimonialID" id="TestimonialID"/>
                </form>
            </div>
            <div class="modal-footer">
                <div id="testButton">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Testimonial -->
<div class="modal fade" id="deletetestimonialModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Delete Testimonial</h5>
                <button id="closeDeletetestimonialModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="deleteTestimonal">
                    <div class="form-group">
                        <label for="title">Permanently Delete?</label>
                        <input id="DeleteTestimonial" type="text" name="DeleteTestimonial" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="DeleteTestimonialID" id="DeleteTestimonialID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="DeletTestimonialSubmit" class="btn btn-danger" >Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Online Auction -->
<div class="modal fade" id="addOnlineAuction">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Online Auction</h5>
                <button id="closeAddOnlineAuction" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group ">
                    <div class="form-group">
                        <label for="Startdate">Start Date <sup>*</sup></label>
                        <input id="auction_startdate" type="date" name="auction_startdate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="starTime">Start Time Hour<sup>*</sup></label>
                        <select id="auction_start_time" type="text" name="auction_start_time" class="form-control">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="starTimeMin">Start Time Min<sup>*</sup></label>
                        <select id="auction_start_time_min" type="text" name="auction_start_time_min" class="form-control">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Enddate">End Date</label>
                        <input id="auction_enddate" type="date" name="auction_enddate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="endTime">End Time Hour<sup>*</sup></label>
                        <select id="auction_end_time" type="text" name="auction_end_time" class="form-control">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="endTimeMin">End Time Min<sup>*</sup></label>
                        <select id="auction_end_time_min" type="text" name="auction_end_time_min" class="form-control">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="byAcre">Auction Type</label>
                        <select id="auctionType" type="text" name="auctionType" class="form-control">
                            <option value="1">By Acre</option>
                            <option value="0">By Price</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="byAcre">Bidding Increment</label>
                        <select id="incrementAmount" type="text" name="incrementAmount" class="form-control">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="totalAcres">Starting Price Per Acre</label>
                        <input id="StartingPricePer" name="StartingPricePer" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="totalAcres">Total Acres</label>
                        <input id="totalAcresText" name="totalAcresText" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Starting Bid <sup>*</sup></label>
                        <input id="auctionStartBid" name="auctionStartBid"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Auction Title <sup>*</sup></label>
                        <textarea id="auctionTitle" name="auctionTitle"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Short Description <sup>*</sup></label>
                        <textarea id="auctionShortDesc" name="auctionShortDesc"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Primary Image <sup>*</sup></label>
                        <div class="custom-file">
                            <input type='file' accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name='Auction_MainImage' id='Auction_MainImage' class='form-control'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Addimages">Additional Images</label>
                        <div class="custom-file">
                            <input type="file" accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name="Auction_Additional_Images[]" id="Auction_Additional_Images" multiple class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="body">YouTube Link <sup>*</sup></label>
                        <input id="Auction_YouTubeLink" name="Auction_YouTubeLink"  class="form-control">
                    </div>
                    <div class="form-group">
                    <label for="body">Legal Description <sup>*</sup></label>
                    <textarea id="auctionLegalDescription" name="auctionLegalDescription"  class="form-control"><?php echo $data['auctiontc']->legal_description; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Title <sup>*</sup></label>
                    <textarea id="auctionLegalTitle" name="auctionLegalTitle"  class="form-control"><?php echo $data['auctiontc']->title; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Mineral, Wind or Water Rights <sup>*</sup></label>
                    <textarea id="auctionMineralETC" name="auctionMineralETC"  class="form-control"><?php echo $data['auctiontc']->	mineral_etc; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Leases <sup>*</sup></label>
                    <textarea id="auctionLeases" name="auctionLeases"  class="form-control"><?php echo $data['auctiontc']->leases; ?></textarea>
                </div>
                <div class="form-group ">
                    <label for="body">Farm Service Agency Information <sup>*</sup></label>
                    <textarea id="auctionFarmServiceAgency" name="auctionFarmServiceAgency"  class="form-control"><?php echo $data['auctiontc']->farm_service_agency_info; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Property Condition <sup>*</sup></label>
                    <textarea id="auctionPropertyCondition" name="auctionPropertyCondition"  class="form-control"><?php echo $data['auctiontc']->	property_condition; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Purchase Agreement <sup>*</sup></label>
                    <textarea id="auctionPurchaseAgreement" name="auctionPurchaseAgreement"  class="form-control"><?php echo $data['auctiontc']->purchase_agreement; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Closing Expenses <sup>*</sup></label>
                    <textarea id="auctionClosingExpenses" name="auctionClosingExpenses"  class="form-control"><?php echo $data['auctiontc']->closing_expenses; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Closing Date and Possession <sup>*</sup></label>
                    <textarea id="auctionClosingDate" name="auctionClosingDate"  class="form-control"><?php echo $data['auctiontc']->closing_date; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Sale Procedure <sup>*</sup></label>
                    <textarea id="auctionSaleProcedure" name="auctionSaleProcedure"  class="form-control"><?php echo $data['auctiontc']->sale_procedure; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Default and Remedies <sup>*</sup></label>
                    <textarea id="auctionDefaultRemedies" name="auctionDefaultRemedies"  class="form-control"><?php echo $data['auctiontc']->default_remedies; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Additional Disclosures <sup>*</sup></label>
                    <textarea id="auctionAdditionalDisclosures" name="auctionAdditionalDisclosures"  class="form-control"><?php echo $data['auctiontc']->additional_disclosures; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="body">Contact Info <sup>*</sup></label>
                    <textarea id="auctionContactInfo" name="auctionContactInfo"  class="form-control"><?php echo $data['auctiontc']->closing; ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submitNewAuction" class="btn btn-primary">Insert</button>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Auction History/info -->
<div class="modal fade" id="viewOLAuctionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Auction History/Info</h5>
                <button id="closeAuctioneModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="viewOLAuctionModal">
                    <div class="form-group">
                        <label for="title">History</label>
                        <input id="DeleteAddState" type="text" name="DeleteAddState" class="form-control" readonly>
                    </div>
                    <input type="hidden" name="AuctionID" id="AuctionID" />
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT Listing -->
<div class="modal fade" id="editListingModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Listing</h5>
                <button id="closeeditListingModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="EditListingForm">
                    <div class="form-group">
                        <label for="Listingtype">Listing Type <sup>*</sup></label>
                        <select id="update_listingtype" type="text" name="update_listingtype" class="form-control">
                            <?php foreach($data['listing_types'] as $list_type) : ?>
                                <option value="<?php echo $list_type->listing_type_id; ?>"><?php echo $list_type->listing_type; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Startdate">Start Date <sup>*</sup></label>
                        <input id="update_startdate" type="date" name="update_startdate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="City">City <sup>*</sup></label>
                        <input id="update_city" type="text" name="update_city" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="state">State <sup>*</sup></label>
                        <select id="update_state" type="text" name="update_state" class="form-control">
                            <?php foreach($data['states'] as $state_list) : ?>
                                <option value="<?php echo $state_list->state_id; ?>"><?php echo $state_list->state; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Zip">Zip Code <sup>*</sup></label>
                        <input id="update_zip" type="text" name="zip" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Title <sup>*</sup></label>
                        <input id="update_title" type="text" name="update_title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="title">Acres <sup>*</sup></label>
                        <input id="update_acres" type="text" name="update_acres" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="price">Price <sup>*</sup></label>
                        <input id="update_price" type="text" name="update_price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="info">Tag Line</label>
                        <textarea id="update_tagline" name="update_tagline" class="form-control"></textarea>
                    </div>
                    <div class="form-group">

                        <label for="image">Change Primary Image <sup>*</sup></label>
                        <div class="custom-file">
                            <input type='file' accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name='update_mainImage' id='update_mainImage' class='form-control'>
                            <!--<input type="file" name="files" class="custom-file-input" id="image" multiple>
                            <label for="image" class="custom-file-label">Choose File</label>-->
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="body">Description <sup>*</sup></label>
                        <textarea id="editor8" name="editor8" class="form-control summernote"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="directions">Directions <sup>*</sup></label>
                        <textarea id="editor9" name="editor9" class="form-control summernote"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Zip">YouTube URL <sup>*</sup></label>
                        <input id="edit_yturl" type="text" name="edit_yturl" class="form-control">
                    </div>
                    <input type="hidden" name="updateListingID" id="updateListingID" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="editListingModalSubmit" class="btn btn-primary" >Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Listing Images -->
<div class="modal fade" id="editListingImagesModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Images</h5>
                <button id="closeeditImgListingModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="Addimages">Edit Main Image</label>
                    <div class="custom-file">
                        <input type='file' accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name='Listing_EditMainImage' id='Listing_EditMainImage' class='form-control'>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editListingModalMainImgsSubmit" class="btn btn-primary" >Edit Image</button>
                </div>
                <div class="form-group">
                    <div id="currentListingMainImage">

                    </div>
                </div>
                <form id="newListingForm">
                    <div class="form-group">
                        <label for="Addimages">Add Images</label>
                        <div class="custom-file">
                            <input type="file" accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name="Add_Additional_Images[]" id="add_more_imgs" multiple="multiple" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="editListingModalImgsSubmit" class="btn btn-primary" >Add Images</button>
                    </div>
                    <div class="form-group">
                        <div id="currentImages">

                        </div>
                    </div>
                    <input type="hidden" name="updateListingImgsID" id="updateListingImgsID" />
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit Auction Images -->
<div class="modal fade" id="editAuctionImagesModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Images</h5>
                <button id="closeeditImgAuctionModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newListingForm">
                    <div class="form-group">
                        <label for="Addimages">Edit Main Image</label>
                        <div class="custom-file">
                            <input type='file' accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name='Auction_EditMainImage' id='Auction_EditMainImage' class='form-control'>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="editAuctionModalMainImgsSubmit" class="btn btn-primary" >Edit Image</button>
                    </div>
                    <div class="form-group">
                        <div id="currentAuctionMainImage">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Addimages">Add Images</label>
                        <div class="custom-file">
                            <input type="file" accept=".png, .jpg, .jpeg, .PNG, .JPG, .JPEG" name="Add_Additional_Images[]" id="add_more_auction_imgs" multiple="multiple" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="editAuctionModalImgsSubmit" class="btn btn-primary" >Add Images</button>
                    </div>
                    <div class="form-group">
                        <div id="currentAuctionImages">

                        </div>
                    </div>
                    <input type="hidden" name="updateAuctionImgsID" id="updateAuctionImgsID" />
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Upload/Update PDF -->
<div class="modal fade" id="editListingPDFModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add PDF</h5>
                <button id="closeeditPDFListingModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editListingPDFModal">
                    <div class="form-group">
                        <label for="Addimages">Brochure</label>
                        <div class="custom-file">
                            <input type="file" accept=".pdf, .PDF" name="Update_brochure" id="Update_brochure" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="editListingModalPDFSubmit" class="btn btn-primary" >ADD PDF</button>
                    </div>
                    <div class="form-group">
                        <div id="listingPDF">

                        </div>
                    </div>
                    <input type="hidden" name="updateListingPDFID" id="updateListingPDFID" />
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Update/Upload Auction PDF -->
<div class="modal fade" id="editAuctionPDFModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add PDF</h5>
                <button id="closeeditPDFAuctionModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAuctionPDFModal">
                    <div class="form-group">
                        <label for="AddPDF">Brochure</label>
                        <div class="custom-file">
                            <input type="file" accept=".pdf, .PDF" name="Update_Auction_brochure" id="Update_Auction_brochure" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="editAuctionModalPDFSubmit" class="btn btn-primary" >ADD PDF</button>
                    </div>
                    <div class="form-group">
                        <div id="AuctionPDF">

                        </div>
                    </div>
                    <input type="hidden" name="updateAuctionPDFID" id="updateAuctionPDFID" />
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit Online Auction -->
<div class="modal fade" id="editOnlineAuction">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Online Auction</h5>
                <button id="closeEditOnlineAuction" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group ">
                    <div class="form-group">
                        <label for="Startdate">Start Date <sup>*</sup></label>
                        <input id="edit_auction_startdate" type="date" name="edit_auction_startdate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="starTime">Start Time Hour<sup>*</sup></label>
                        <select id="edit_auction_start_time" type="text" name="edit_auction_start_time" class="form-control">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="starTimeMin">Start Time Min<sup>*</sup></label>
                        <select id="edit_auction_start_time_min" type="text" name="edit_auction_start_time_min" class="form-control">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Enddate">End Date</label>
                        <input id="edit_auction_enddate" type="date" name="edit_auction_enddate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="endTime">End Time Hour<sup>*</sup></label>
                        <select id="edit_auction_end_time" type="text" name="edit_auction_end_time" class="form-control">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="endTimeMin">End Time Min<sup>*</sup></label>
                        <select id="edit_auction_end_time_min" type="text" name="edit_auction_end_time_min" class="form-control">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="byAcre">Auction Type</label>
                        <select id="edit_auctionType" type="text" name="edit_auctionType" class="form-control">
                            <option value="1">By Acre</option>
                            <option value="0">By Price</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="totalAcres">Total Acres</label>
                        <input id="edit_totalAcresText" name="edit_totalAcresText" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="EditbyAcre">Bidding Increment</label>
                        <select id="EditincrementAmount" type="text" name="EditincrementAmount" class="form-control">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="totalAcres">Starting Price Per Acre</label>
                        <input id="EditStartingPricePer" name="EditStartingPricePer" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Starting Bid <sup>*</sup></label>
                        <input id="edit_auctionStartBid" name="edit_auctionStartBid"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Auction Title <sup>*</sup></label>
                        <textarea id="edit_auctionTitle" name="edit_auctionTitle"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Short Description <sup>*</sup></label>
                        <textarea id="edit_auctionShortDesc" name="edit_auctionShortDesc"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Legal Description <sup>*</sup></label>
                        <textarea id="edit_auctionLegalDescription" name="edit_auctionLegalDescription"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Title <sup>*</sup></label>
                        <textarea id="edit_auctionLegalTitle" name="edit_auctionLegalTitle"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Mineral, Wind or Water Rights <sup>*</sup></label>
                        <textarea id="edit_auctionMineralETC" name="edit_auctionMineralETC"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Leases <sup>*</sup></label>
                        <textarea id="edit_auctionLeases" name="edit_auctionLeases"  class="form-control"></textarea>
                    </div>
                    <div class="form-group ">
                        <label for="body">Farm Service Agency Information <sup>*</sup></label>
                        <textarea id="edit_auctionFarmServiceAgency" name="edit_auctionFarmServiceAgency"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Property Condition <sup>*</sup></label>
                        <textarea id="edit_auctionPropertyCondition" name="edit_auctionPropertyCondition"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Purchase Agreement <sup>*</sup></label>
                        <textarea id="edit_auctionPurchaseAgreement" name="edit_auctionPurchaseAgreement"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Closing Expenses <sup>*</sup></label>
                        <textarea id="edit_auctionClosingExpenses" name="edit_auctionClosingExpenses"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Closing Date and Possession <sup>*</sup></label>
                        <textarea id="edit_auctionClosingDate" name="edit_auctionClosingDate"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Sale Procedure <sup>*</sup></label>
                        <textarea id="edit_auctionSaleProcedure" name="edit_auctionSaleProcedure"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Default and Remedies <sup>*</sup></label>
                        <textarea id="edit_auctionDefaultRemedies" name="edit_auctionDefaultRemedies"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Additional Disclosures <sup>*</sup></label>
                        <textarea id="edit_auctionAdditionalDisclosures" name="edit_auctionAdditionalDisclosures"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Contact Info <sup>*</sup></label>
                        <textarea id="edit_auctionContactInfo" name="edit_auctionContactInfo"  class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="body">Video URL <sup>*</sup></label>
                        <textarea id="edit_video_url" name="edit_video_url"  class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="edit_submitAuction" class="btn btn-primary">Update</button>
                </div>
                <input type="hidden" name="updateAuctionInfoID" id="updateAuctionInfoID"/>
            </div>
        </div>
    </div>
</div>

<!-- Insert/Update Multi Parcel Main Description -->
<div class="modal fade" id="InsertUpdateMPDescription">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Description</h5>
                <button id="closeInsertUpdateMPDescription" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="InsertUpdateMPDescriptionModal">
                    <div class="form-group">
                        <label for="body">Description <sup>*</sup></label>
                        <textarea id="editor14" name="editor14" class="form-control summernote"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="UpdatePrimaryDesc" class="btn btn-primary UpdatePrimaryDesc" >Update</button>
                    </div>
                    <input type="hidden" name="MPID" id="MPID" />
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Insert/Update Multi Parcel Main Description -->
<div class="modal fade" id="InsertUpdateParcelDescription">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Description</h5>
                <button id="closeInsertUpdatePDescription" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="InsertUpdateMPDescriptionModal">
                    <div class="form-group">
                        <label for="body">Description <sup>*</sup></label>
                        <textarea id="editor15" name="editor15" class="form-control summernote"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="UpdateParcelDesc" class="btn btn-primary UpdateParcelDesc" >Update</button>
                    </div>
                    <input type="hidden" name="PID" id="PID" />
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="InsertUpdateMPTimeDate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">UpdateTime</h5>
                <button id="closeInsertUpdateMPDescription" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="InsertUpdateMPDescriptionModal">
                    <div class="form-group">
                        <label for="body">Description <sup>*</sup></label>
                        <input id="edit_auction_startdate" type="datetime-local" name="edit_auction_startdate" class="form-control edit_auction_startdate">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="setStartTime" class="btn btn-primary setStartTime" >Update</button>
                    </div>
                    <input type="hidden" name="MPID" id="MPID" />
                </form>
            </div>

        </div>
    </div>
</div>


<!-- One Modal to rule them all!! -->
<div class="modal fade" id="TheModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="TheModalTitle"></h5>
                <button id="closeTheModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="TheModalForm">
                    <div id="TheModalFormBody"></div>
                </form>
            </div>
            <div class="modal-footer">
                <div id="TheModalButton"></div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo URLROOT; ?>/public/js/dropzone.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<script src="<?php echo URLROOT;?>/public/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo URLROOT;?>/public/js/datatables/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
<script src="<?php echo URLROOT;?>/public/js/Admin.js"></script>






</body>
</html>
