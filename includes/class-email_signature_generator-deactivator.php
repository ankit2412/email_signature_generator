<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://riopromo.com/
 * @since      1.0.0
 *
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/includes
 * @author     Rio Promo <info@riopromo.com>
 */
class Email_signature_generator_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
            $page = get_page_by_path( 'email-signature-generator' );
            if(!empty($page))
                wp_delete_post( $page->ID, true );
            
            $preview_page = get_page_by_path( 'email-signature-preview' );
            if(!empty($preview_page))
                wp_delete_post( $preview_page->ID, true );
            
            delete_option( 'email_aurthor_image' );
            delete_option( 'email_font_color' );
            delete_option( 'email_social_link_facebook' );
            delete_option( 'email_social_link_twitter' );
            delete_option( 'email_social_link_linkedin' );
	}

}
