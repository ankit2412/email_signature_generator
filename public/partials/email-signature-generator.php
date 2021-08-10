<?php
/*
 * Template Name: Email Signature Generator
 */

get_header();
?>
<div class="email-signature-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Images</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">Social</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="design-tab" data-toggle="tab" href="#design" role="tab" aria-controls="design" aria-selected="false">Design</a>
                    </li>
                </ul>
                <div class="tab-content" id="SignatureContent">
                    <div class="tab-pane fade in active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="form-group">
                            <label for="InputName">Name</label>
                            <input type="text" class="form-control" name="InputName" placeholder="Enter name" maxlength="70">
                        </div>
                        <div class="form-group">
                            <label for="InputCompany">Company</label>
                            <input type="text" class="form-control" name="InputCompany" placeholder="Enter company name" maxlength="70">
                        </div>
                        <div class="form-group">
                            <label for="InputPosition">Position</label>
                            <input type="text" class="form-control" name="InputPosition" placeholder="Enter position" maxlength="70">
                        </div>
                        <div class="form-group">
                            <label for="InputDepartment">Department</label>
                            <input type="text" class="form-control" name="InputDepartment" placeholder="Enter department" maxlength="70">
                        </div>
                        <div class="form-group">
                            <label for="InputPhone">Phone</label>
                            <input type="text" class="form-control" name="InputPhone" placeholder="Enter phone number" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="InputMobile">Mobile</label>
                            <input type="text" class="form-control" name="InputMobile" placeholder="Enter mobile number" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="InputWebsite">Website</label>
                            <input type="text" class="form-control" name="InputWebsite" placeholder="Enter website" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="InputEmail">Email</label>
                            <input type="text" class="form-control" name="InputEmail" placeholder="Enter email" maxlength="70">
                        </div>
                        <div class="form-group">
                            <label for="InputAddress">Address</label>
                            <input type="text" class="form-control" name="InputAddress" placeholder="Enter address" maxlength="200">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                        <div class="tab-name">
                            Upload Logo / Photo
                        </div>
                        <div class="form-group">
                            <div class="uploaded-avtar-wrapper">
                                <img class="rounded" id="avatar" src="" alt="avatar">
                                <a class="remove-img" href="#">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="avtar-options">
                                <div class="avtar-option">
                                    <label for="AvtarImageWidth">Image width</label>
                                    <input class="slider" type="range" id="AvtarImageWidth" name="AvtarImageWidth" min="0" max="200" value="100"/>
                                    <span class="slider-current-value">100</span>
                                </div>
                                <div class="avtar-option">
                                    <label for="AvtarImageShape">Image Shape</label>
                                    <input class="slider" type="range" id="AvtarImageShape" name="AvtarImageShape" min="0" max="50" value="10"/>
                                    <span class="slider-current-value">10</span>
                                </div>
                            </div>
                            <label class="upload-label">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                <span>Choose File</span>
                                <input type="file" id="Input_image" name="InputImage" />
                            </label>
                        </div>
                        <div class="alert" role="alert"></div>
                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="img-container">
                                            <img id="dummy_image" src="">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                        <div class="caption-wrapper">
                            <div class="form-group">
                                <label for="socialCaption">Caption</label>
                                <input type="text" class="form-control" id="socialCaption" name="socialCaption" placeholder="Follow me" maxlength="50">
                            </div>
                        </div>
                        <div class="active-social-icons-wrapper">
                            <div class="form-group">
                                <ul class="active-social-icons">
                                    <li id="facebook" data-order="1">
                                        <span class="ui-icon ui-icon-grip-solid-horizontal"></span>
                                        <div class="social-icon">
                                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                        </div>
                                        <input type="text" maxlength="255" placeholder="https://www.facebook.com/id" class="link form-control">
                                        <i class="fa fa-times close-icon" aria-hidden="true"></i>
                                    </li>
                                    <li id="twitter" data-order="2">
                                        <span class="ui-icon ui-icon-grip-solid-horizontal"></span>
                                        <div class="social-icon">
                                            <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                        </div>
                                        <input type="text" maxlength="255" placeholder="https://www.twitter.com/id" class="link form-control">
                                        <i class="fa fa-times close-icon" aria-hidden="true"></i>
                                    </li>
                                    <li id="linkedin" data-order="3">
                                        <span class="ui-icon ui-icon-grip-solid-horizontal"></span>
                                        <div class="social-icon">
                                            <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                        </div>
                                        <input type="text" maxlength="255" placeholder="https://www.linkedin.com/company/id" class="link form-control">
                                        <i class="fa fa-times close-icon" aria-hidden="true"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="all-social-icons-wrapper">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">
                        <div class="tab-name">Layout</div>
                        <div class="form-group">
                            <div class="design-options">
                                <div class="design-option">
                                    <label for="DesignFontSize">Font Size</label>
                                    <input class="slider" type="range" id="DesignFontSize" name="DesignFontSize" min="60" max="110" value="90"/>
                                    <span class="slider-current-value">90</span>
                                </div>
                                <div class="design-option">
                                    <label for="DesignFontColor">Font Color</label>
                                    <input type="text" id="DesignFontColor" name="DesignFontColor" value="<?php echo (get_option('email_font_color') != "") ? get_option('email_font_color') : '#000000'; ?>"/>
                                </div>
                                <div class="design-option">
                                    <label for="DesignFontFamily">Font Family</label>
                                    <select id="DesignFontFamily" name="DesignFontFamily" >
                                        <optgroup label="Sans-Serif">
                                            <option value="Arial, Helvetica, sans-serif">Arial</option>
                                            <option value="'Arial Black', Gadget, sans-serif">Arial Black</option>
                                            <option value="'Comic Sans MS', cursive, sans-serif">Comic Sans MS</option>
                                            <option value="Impact, Charcoal, sans-serif">Impact</option>
                                            <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Lucida Sans Unicode</option>
                                            <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                                            <option value="'Trebuchet MS', Helvetica, sans-serif">Trebuchet MS</option>
                                            <option value="Verdana, Geneva, sans-serif" selected="">Verdana</option>
                                        </optgroup>
                                        <optgroup label="Monospace">
                                            <option value="'Courier New', Courier, monospace">Courier New</option>
                                            <option value="'Lucida Console', Monaco, monospace">Lucida Console</option>
                                        </optgroup>
                                        <optgroup label="Serif">
                                            <option value="Georgia, serif">Georgia</option>
                                            <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino Linotype</option>
                                            <option value="'Times New Roman', Times, serif">Times New Roman</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="email-wrapper">
                    <div class="email-header">New Email</div>
                    <p>To: </p>
                    <hr>
                    <p>Subject: </p>
                    <hr>
                    <div class="email-signature-preview">

                    </div>
                </div>
                <div class="email-signature-action-wrapper">
                    <button id="generate_email_signature" class="btn btn-default">Generate Singature</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
