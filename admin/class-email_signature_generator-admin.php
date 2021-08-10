<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://riopromo.com/
 * @since      1.0.0
 *
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/admin
 * @author     Rio Promo <info@riopromo.com>
 */
class Email_signature_generator_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        if($_REQUEST['page'] == 'email-signature-generator-page'){
            wp_enqueue_style($this->plugin_name . '-bootstrap-style', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-spectrum-style', plugin_dir_url(__FILE__) . 'css/spectrum.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/email_signature_generator-admin.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        if($_REQUEST['page'] == 'email-signature-generator-page'){
            wp_enqueue_script($this->plugin_name . '-bootstrap-script', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name.'-spectrum', plugin_dir_url(__FILE__) . 'js/spectrum.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/email_signature_generator-admin.js', array('jquery'), $this->version, false);
        }
    }

    public function email_signature_admin_menu() {
        add_menu_page(
                __('Email Signature Generator', $this->plugin_name), __('Email Signature Generator', $this->plugin_name), 'manage_options', 'email-signature-generator-page', array($this, 'email_signature_page_contents'), 'dashicons-id', 85
        );
    }

    public function register_email_signature_settings() {
        //register our settings
        register_setting('email-signature-generator-options', 'email_aurthor_image', array('sanitize_callback' => array($this, 'handle_file_upload')));
        register_setting('email-signature-generator-options', 'email_website');
        register_setting('email-signature-generator-options', 'email_font_color');
        register_setting('email-signature-generator-options', 'email_social_link_facebook');
        register_setting('email-signature-generator-options', 'email_social_link_twitter');
        register_setting('email-signature-generator-options', 'email_social_link_linkedin');
    }

    public function email_signature_page_contents() {
        $file_path = plugin_dir_path(__FILE__) . 'partials/email_signature_generator-admin-display.php';
        include($file_path);
    }

    public function handle_file_upload() {

        if (!empty($_FILES["email_aurthor_image"]["tmp_name"])) {
            $avtar = $_FILES['email_aurthor_image'];
            $path_parts = pathinfo($avtar["name"]);
            $extension = $path_parts['extension'];
            $upload_dir = wp_upload_dir();

            if (!file_exists($upload_dir['basedir'] . '/email_generator_avtar')) {
                mkdir($upload_dir['basedir'] . '/email_generator_avtar', 0777, true);
            }
            $new_name = 'avtar-' . time() . '.' . $extension;
            $path = $upload_dir['basedir'] . '/email_generator_avtar/' . $new_name;
            if (move_uploaded_file($avtar['tmp_name'], $path)) {
                $full_image_path = $upload_dir['baseurl'] . '/email_generator_avtar/' . $new_name;
                $option = $full_image_path;
            }
        } else {
            $option = get_option('email_aurthor_image');
        }
        
        return $option;
    }

}
