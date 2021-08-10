<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://riopromo.com/
 * @since      1.0.0
 *
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="email-singature-options-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Email Signature Generator Options</h1>
                <?php settings_errors(); ?>
                <div class="form-wrapper">
                    <form method="post" enctype='multipart/form-data' action="options.php">
                        <?php
                        settings_fields('email-signature-generator-options');
                        do_settings_sections('email-signature-generator-options');
                        ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">General Options</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="email_aurthor_image">Email Signature Image</label>
                                            <?php if (get_option('email_aurthor_image') != '') { ?>
                                            <img class="email-aurthor-image" src="<?php echo get_option('email_aurthor_image'); ?>" width="150"/>
                                            <?php } ?>
                                            <input id="email_aurthor_image" type="file" name="email_aurthor_image"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="email_website">Website</label>
                                            <br />
                                            <input id="email_website" type="url" name="email_website" value="<?php echo get_option('email_website'); ?>" class="form-control" placeholder="https://www.abc.com/"  />
                                        </div>
                                        <div class="form-group">
                                            <label for="email_font_color">Font color</label>
                                            <br />
                                            <input id="email_font_color" type="text" name="email_font_color" value="<?php echo (get_option('email_font_color') != "") ? get_option('email_font_color') : "#000000" ; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="email_social_link_facebook">Facebook Link</label>
                                            <input id="email_social_link_facebook" type="url" name="email_social_link_facebook" value="<?php echo get_option('email_social_link_facebook'); ?>" class="form-control" placeholder="https://www.facebook.com/id" />
                                        </div>
                                        <div class="form-group">
                                            <label for="email_social_link_twitter">Twitter Link</label>
                                            <input id="email_social_link_twitter" type="url" name="email_social_link_twitter" value="<?php echo get_option('email_social_link_twitter'); ?>" class="form-control" placeholder="https://www.twitter.com/id" />
                                        </div>
                                        <div class="form-group">
                                            <label for="email_social_link_linkedin">LinkedIn Link</label>
                                            <input id="email_social_link_linkedin" type="url" name="email_social_link_linkedin" value="<?php echo get_option('email_social_link_linkedin'); ?>" class="form-control" placeholder="https://www.linkedin.com/company/id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php submit_button(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>