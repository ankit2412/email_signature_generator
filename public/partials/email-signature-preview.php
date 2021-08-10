<?php
/*
 * Template Name: Email Signature Preview
 */

get_header();
?>
<script>
    jQuery(window).load(function () {
        var sindata = JSON.parse(sessionStorage.getItem('sindata'));
        if (sindata !== null && sindata.preview == true) {
            $(".final-signature-wrapper").show();
            $(".info-wrapper").hide();

            $("#signature_source_code, .final-signature-preview").html(sindata.signature_source_code);
        } else {
            $("#signature-source-code, .final-signature-preview").text("");
            $(".final-signature-wrapper").hide();
            $(".info-wrapper").show();
        }
    });
</script>
<div class="final-signature-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="final-signature-code-wrapper">
                    <h1>Source code:</h1> 
                    <p>Here is your html code</p>
                    <div class="form-group">
                        <textarea rows="5" id="signature_source_code" class="form-control" readonly="readonly"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="final-email-wrapper">
                    <div class="email-header">Signature Preview</div>
                    <p>To: John Doe</p>
                    <hr>
                    <p>Subject: Your email signature will be look like!</p>
                    <hr>
                    <p>Hey John, </p>
                    <p>Hope you will be like below email signature generated through Email Signature Generator!</p>
                    <p>Regards,</p>
                    <div id="final_signature_preview" class="final-signature-preview"></div>
                </div>
                <div class="final-signature-action-wrapper">
                    <button id="copy_signature" class="btn btn-default" onclick="CopyElementToClipboard(document.getElementById('final_signature_preview'));">Copy Signature</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="info-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Opps! Something went wrong!</h1>
                <h3>You're not allowed to directly access this page.</h3>
                <p>Kindly visit our <a href="<?php echo site_url('email-signature-generator'); ?>">Email Signature Generator</a> page to create beautiful email signature!.</p>
                <h4>Thank you!</h4>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
