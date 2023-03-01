<footer id="footer">
			<div class="container-flex">
				<div class="row text-center">
					<div class="col-md-12">
						<p id="copyrightTxt">&copy; Copyright <?php echo date("Y"); ?> Land Marketers Realty - Auction & Real Estate Listings in Nebraska, Iowa, and South Dakota (All Rights Reserved)</a> </p>
					</div>
				</div>
			</div>
		</footer>

    <!-- MODALS -->
    
    <!-- Log In -->
    <div class="modal fade" id="UserLoginModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-active text-white">
                    <h5 class="modal-title">Log In</h5>
                    <button id="closeUserLoginModal" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="UserLoginModal">
                        <div class="form-group">
                            <label for="title">Email Address <sup>*</sup></label>
                            <input id="userName" type="text" name="userName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="title">Password <sup>*</sup></label>
                            <input type="password" id="userPassword" type="text" name="userPassword" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" id="UserLogInSubmit" class="btn btn-success" >Log In</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="<?php echo URLROOT; ?>/Forgotpassword/forgotpassword" class="btn btn-light btn-block"> Forgot My Password</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    </div>

    <!-- Register -->

    <div class="modal fade" id="UserRegisterModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-active text-white">
                    <h5 class="modal-title">Register</h5>
                    <button id="closeUserRegisterModal" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="UserRegisterModal">
                        <div class="form-group">
                            <label for="name">First Name: <sup>*</sup></label>
                            <input type="text" name="reg_first_name" id="reg_first_name" class="form-control form-control-lg"
                        </div>
                        <div class="form-group">
                            <label for="name">Last Name: <sup>*</sup></label>
                            <input type="text" name="reg_last_name" id="reg_last_name" class="form-control form-control-lg"
                        </div>
                        <div class="form-group">
                            <label for="name">Email: This will be used to log in. <sup>*</sup></label>
                            <input type="email" name="reg_email" id="reg_email" class="form-control form-control-lg"
                        </div>
                        <div class="form-group">
                            <label for="streetaddress">Address: <sup>*</sup></label>
                            <input type="text" name="streetaddress" id="streetaddress" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="city">City: <sup>*</sup></label>
                            <input type="text" name="city" id="city" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="state">State: <sup>*</sup></label>
                            <input type="text" name="state" id="state" class="form-control form-control-lg" placeholder="Example NE">
                        </div>
                        <div class="form-group">
                            <label for="zip">Zip: <sup>*</sup></label>
                            <input type="text" name="zip" id="zip" class="form-control form-control-lg" placeholder="Example 68701">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone: <sup>*</sup></label>
                            <div class="row">
                                <div class="col-sm-2">
                                    <input type="tel" name="areacode" id="areacode" maxlength="3" class="form-control form-control-sm" placeholder="555">
                                </div>
                                <div class="col-sm-2">
                                    <input type="tel" name="prefix" id="prefix" maxlength="3" class="form-control form-control-sm" placeholder="555">
                                </div>
                                <div class="col-sm-2">
                                    <input type="tel" name="phonenumber" id="phonenumber" maxlength="4" class="form-control form-control-sm" placeholder="5555">
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="fourss">Last 4 of SS#: <sup>*</sup></label>
                            <input type="text" name="fourss" id="fourss" class="form-control form-control-lg">
                        </div>
                        <div class="form-group">
                            <label for="password">Password: <sup>*</sup></label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg"
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg"
                        </div>
                        <div class="form-group">
                            <label for="TermsandConditons"><a href="#" data-toggle="modal" class="openTandC" data-target="#TermsandConditionsModal">I have read and agree to the terms and conditions.</a></label>
                            <input type="checkbox" id="readTerms" name="readTerms" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="UserRegisterSubmit" class="btn btn-success" >Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
    <!--IMAGE GALLERY-->
<div class="modal fade" id="listingGallery">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><?php echo $data['listing_info']->listing_title; ?></h5>
                <button id="closeListing" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    </div>
                </div>
        </div>
    </div>
 </div>
</div>

    <!--VIDEO PLAYER-->

    <div class="modal fade" id="videoPlayer">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><?php echo $data['listing_info']->listing_title; ?></h5>
                    <button id="closeListing" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe class="d-block w-100"
                            src="https://www.youtube.com/watch?v=eYfX4m0ZUMI?controls=0">
                    </iframe>
                </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Users -->
    <div class="modal fade" id="EditUserModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit User Info</h5>
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
                            <label for="title">Alternate Phone</label>
                            <input id="userAlternatePhone" type="text" name="userAlternatePhone" class="form-control">
                        </div>
                        <input type="hidden" name="userID" id="userID" />
                        <div class="modal-footer">
                            <button type="submit" id="EditUserModalSubmit" class="btn btn-primary" >Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Watching Modal -->
    <div class="modal fade" id="WatchListingForm">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Watch Listing</h5>
                    <button id="closeWatchListing" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Watch listing?</p>
                    <p><?php echo $data['listing_info']->listing_title; ?></p>
                </div>

                <input type="hidden" name="ListingID" id="ListingID" value="<?php echo $data['listing_info']->listing_id; ?>" />
                <input type="hidden" name="UserID" id="UserID" value="<?php echo $_SESSION['user_id'];?>" />
                <div class="modal-footer">
                    <button type="submit" id="WatchListingBTN" class="btn btn-primary">Watch</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--PDF-->
<div class="modal fade" id="PDFViewer">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><?php echo $data['listing_info']->listing_title; ?></h5>
                <button id="closeListing" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <embed src="<?php echo URLROOT;?>/public/brochures/<?php echo $data['listing_info']->brochure_name; ?>" frameborder="0" width="100%" height="800px">
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="AuctionPDFViewer">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><?php echo $data['auctionListingInfo']->listing_title; ?></h5>
                <button id="closePDFAuction" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <embed src="<?php echo URLROOT;?>/public/brochures/<?php echo $data['auctionPDF']->brochure; ?>" frameborder="0" width="100%" height="800px">
            </div>
        </div>
    </div>
</div>

    <!--Bid Modal -->
    <div class="modal fade" id="BidForm">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title">Asking Price</h5>
                    <button id="closeBidForm" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group text-center">
                        <h3>Asking Price</h3>
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <h3 id="newMinBid"></h3>
                            </div>
                            <div class="col-md-6 text-left">
                                <h3 id="priceperacre"></h3>
                            </div>
                        </div>


                    </div>
                </div>
                <input type="hidden" name="AuctionID" id="AuctionID" value="<?php echo $data['auctionListingInfo']->online_aucton_id; ?>" />
                <input type="hidden" name="UserID" id="UserID" value="<?php echo $_SESSION['user_id'];?>" />
                <input type="hidden" name="minBid" id="minBidFooter" />
                <input type="hidden" name="pricePerAcre" id="pricePerAcre"/>
                <div class="modal-footer">
                    <button type="submit" id="BidBTN" class="btn btn-primary btn-block">Bid</button>
                </div>
            </div>
        </div>
    </div>

<!-- Max Bid Modal -->
    <div class="modal fade" id="maxBidForm">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title">Set Max Bid</h5>
                    <button id="closemaxBidForm" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group text-center">
                        <h3>Set Max Bid</h3>
                        <div id="maxBidInput"></div>

                    </div>
                </div>
                <input type="hidden" name="AuctionID" id="AuctionID" value="<?php echo $data['auctionListingInfo']->online_aucton_id; ?>" />
                <input type="hidden" name="maxUserID" id="maxUserID" value="<?php echo $_SESSION['user_id'];?>" />
                <input type="hidden" name="minBid" id="minBidFooter" />
                <div class="modal-footer">
                    <button type="submit" id="maxBidBTN" class="btn btn-primary btn-block">Set Max Bid</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="modal fade" id="TermsandConditionsModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Terms and Conditions</h5>
                    <button id="closeTermsandConditionsModal" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="TermsAndConditionsForm">
                        <div class="text-center">
                            <h1>Terms and Conditions</h1>
                        </div>
                        <br>
                        <div class="text-justify">
                            <p>Thank you for your interest in using our online auction services.</p><p>In this agreement, the terms Land Marketers Realty, We, Our, LMR, and LandMarketers.com, all refer to LandMarketers.com.  The terms I, You, Buyer, Bidder Account Holder, Registered Buyer/Bidder, refer to you as a user of LandMarketers.com.  All users must first Agree to the Terms and Conditions in order to register.</p>
                            <br>
                            <br>
                            <p>Unless otherwise specified on an individual transaction, Land Marketers Realty is representing the Seller as a Sellers Agent throughout the entire Sale Process.</p>
                            <br>
                            <p>Land Marketers Realty has received all Land and applicable Equipment information from sources deemed reliable. LMR does not guarantee or warranty the accuracy of any information contained in any advertising or marketing material.</p>
                            <br>
                            <p>Land Marketers Realty assumes no responsibility for omissions, corrections, or withdrawals.  Prospective buyers are urged to fully inspect both the physical condition of all property as well as title condition and rely on their own conclusions. Any Aerial mapping displayed on LandMarketers.com is for visual aid only and is not intended to show fence line locations or take the place of a legal survey. Any documents, maps, pictures or other information are for informational purposes only, and may not represent the current condition of the property.  LMR recommends to all potential buyers that it is in the best interest of the Buyer to always seek legal advice as part of the buyers complete due diligence process in every transaction.   Bidders acknowledge that each individual online auction conducted on LandMarketers.com will have its own set of Terms & Conditions for the buyer to acknowledge.   All sales are considered cash sales and are not contingent on buyer financing.  Buyers agree to make all financial arrangements prior to bidding. The purchase agreement that is executed for each individual transaction shall supersede any and all other terms, whether those terms are written, expressed or implied.  The purchase agreement will be the governing document for every separate transaction. To protect the integrity of the Auction process on LandMarketers.com, all registered bidders agree to refrain from bidding on their own property and agree to refrain from bidding on behalf of any sellers. According to Universal Commercial Code 2-328, "In the event shill bidding is detected on a property, the Buyer has the right to either (1) Avoid the Sale or (2) take the property at the price of the last good faith bid."</p>
                            <br>
                            <p>We invite you to bring to our attention any information on our web-site that you believe to be inaccurate.  Please send any such emails to Office@LandMarketers.com, or call our office directly at (402) 336-4444.</p>
                            <br>
                            <p>All bidders must be a legal citizen of the United States and be 18 years of age or older to register. Land Marketers Reserves the right to remove any bidder at any time, for non-compliance of any terms and conditions on the web-site. The successful bidder of each auction shall immediately sign all proper disclosures and enter into, and fully execute, a Real Estate Purchase Agreement and send the required non-refundable Earnest Deposit to be deposited into the Land Marketers Realty Trust Account. Buyer may send the non-refundable Earnest Deposit by wire transfer or by sending a check by U.S. Mail to Land Marketers Realty P.O. Box 857, O'Neill, NE 68763.  Buyers acknowledge that their non-refundable Earnest Deposit may be transferred to the closing agent that is handling the closing of each transaction.</p>
                            <br>
                            <p>In no way does Land Marketers Realty guarantee the un-interrupted Access to LandMarketers.com.  Land Marketers Realty makes no representations or guarantees that online services offered are compatible with any equipment being used by the registered bidders.  Land Marketers Realty is not responsible or liable for any loss of internet service, interruptions or corruptions of any internet connection, of any kind. Furthermore, Land Marketers Realty is not responsible for any loss or damage of any kind incurred as a result of our website usage for any Registered individual, LLC, or corporation. Registered Bidders/Buyers agree to hold Land Marketers Realty harmless for any of the above-mentioned interruptions or bidder's inability to use the online auction platform on LandMarketers.com</p>
                            <br>
                            <p>If you would like to participate in any marketing event on LandMarketers.com, you will have to register and create an account. It will be the responsibility of each  Account Holder to provide accurate information and keep all information updated. It is the Account Holder's responsibility to maintain the security of all information. Furthermore, the Account Holder agrees to notify Land Marketers Realty of any un-authorized use of Bidders Information. By using the services offered on LandMarketers.com, you expressly consent to the collection, storage, use, and disclosure of your personal information</p>
                            <br>
                            <p>By registering to be a bidder you are hereby consenting to the Land Marketers Realty team contacting you about your interest in services offered by Land Marketers Realty or any properties being marketed. Contact may be made by email, phone, mailing address or any other means in which you provide.  All users agree to comply with any applicable copyright laws. You may display and print the materials from our website for your personal non-commercial use, but you may not reproduce any material on LandMarketers.com without prior written consent from Land Marketers Realty.   You, as a registered bidder agree to assume total responsibility and risk for your use of any interactive parts of LandMarketers.com.</p>
                            <br>
                            <p>In the event of any power failure, internet loss, network error or any other disruption to LandMarketers.com during the term of any online auction, Land Marketers Realty shall have the right to withdraw any property that is being offered on the Internet and negotiate with any registered bidders.</p>
                            <br>
                            <p>These Terms & Conditions are applicable to all applications or any other services offered on LandMarketers.com. If you do not agree to the Terms & Conditions, you may not create an account on LandMarketers.com</p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="AgreedSubmit" class="btn btn-primary" >I Agree</button>
                </div>
            </div>
        </div>
    </div>

<!-- Thank you for -->

<div class="modal fade" id="ThankYouModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Success</h5>
                <button id="closeThankYousModal" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ThankYouModal">
                    <div class="text-center">
                        <h1>Thank you!</h1>
                        <p>Your registration has been processed and will take up to 24 hours.</p>
                        <p>Until your account is active you MAY NOT bid on any of our online auctions.</p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="RegistrationViewer">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Registration Instructions</h5>
                <button id="closeListing" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="<?php echo URLROOT;?>/public/brochures/regpdf.pdf" frameborder="0" width="100%" height="800px"></iframe>
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


                <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
                crossorigin="anonymous"></script>-->
		<!-- Single Page Nav -->
        <script src="<?php echo URLROOT;?>/public/js/jquery.singlePageNav.min.js"></script>
		<!-- jquery.fancybox.pack -->
        <script src="<?php echo URLROOT;?>/public/js/jquery.fancybox.pack.js"></script>
		<!-- Google Map API -->
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyBeQme0oLAOMBz2uzBqnTpykWCOi7XuQPg"></script>
		<!-- Owl Carousel -->
        <script src="<?php echo URLROOT;?>/public/js/owl.carousel.min.js"></script>
        <script src="<?php echo URLROOT;?>/public/js/mixitup.min.js"></script>
        <!-- jquery easing -->
        <script src="<?php echo URLROOT;?>/public/js/jquery.easing.min.js"></script>
        <!-- Fullscreen slider -->
        <script src="<?php echo URLROOT;?>/public/js/jquery.slitslider.js"></script>
        <script src="<?php echo URLROOT;?>/public/js/jquery.ba-cond.min.js"></script>
		<!-- onscroll animation -->
        <script src="<?php echo URLROOT;?>/public/js/wow.min.js"></script>
		<!-- Custom Functions -->
        <script src="<?php echo URLROOT;?>/public/js/main.js"></script>

        <script src="<?php echo URLROOT;?>/public/js/functions.js"></script>

<!--         <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script> -->

<script type="text/javascript">
    $(document).ready(function(){
    // Get the current year for the copyright
    $('#year').text(new Date().getFullYear());
/*    var counter = 0;
        $(window).scroll(function () {
            var pos = $('#navimg').position();
            if(pos.top == 0)
            {
                $('#navimg').show();
                counter = 1;
            }
            else
            {
               $('#navimg').hide();
                counter = 0;
            }
        });*/
    });
</script>
</body>
</html>