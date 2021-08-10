<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://riopromo.com/
 * @since      1.0.0
 *
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/includes
 * @author     Rio Promo <info@riopromo.com>
 */
class Email_signature_generator {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Email_signature_generator_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if (defined('EMAIL_SIGNATURE_GENERATOR_VERSION')) {
            $this->version = EMAIL_SIGNATURE_GENERATOR_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'email_signature_generator';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Email_signature_generator_Loader. Orchestrates the hooks of the plugin.
     * - Email_signature_generator_i18n. Defines internationalization functionality.
     * - Email_signature_generator_Admin. Defines all hooks for the admin area.
     * - Email_signature_generator_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-email_signature_generator-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-email_signature_generator-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-email_signature_generator-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-email_signature_generator-public.php';

        $this->loader = new Email_signature_generator_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Email_signature_generator_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Email_signature_generator_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Email_signature_generator_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        
        //add setting page
        $this->loader->add_action('admin_menu', $plugin_admin, 'email_signature_admin_menu');
        
        //call register settings function
	$this->loader->add_action( 'admin_init', $plugin_admin, 'register_email_signature_settings' );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Email_signature_generator_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 99);
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 99);
        
        // create a email generator page
        $this->loader->add_action('wp_loaded', $plugin_public, 'create_generator_page');
        $this->loader->add_filter( 'page_template', $plugin_public, 'load_page_template' );
        $this->loader->add_filter( 'theme_page_templates', $plugin_public, 'assign_page_template', 10, 4 );
        $this->loader->add_filter( 'template_include', $plugin_public, 'email_gen_page_template', 99 );
        
        //create html
        $this->loader->add_action('wp_ajax_create_email_signature', $plugin_public, 'create_email_signature');
        $this->loader->add_action('wp_ajax_nopriv_create_email_signature', $plugin_public, 'create_email_signature');
        
        //preview html
        $this->loader->add_action('wp_ajax_preview_email_signature', $plugin_public, 'preview_email_signature');
        $this->loader->add_action('wp_ajax_nopriv_preview_email_signature', $plugin_public, 'preview_email_signature');
        
        //upload avtar
        $this->loader->add_action('wp_ajax_upload_avtar', $plugin_public, 'upload_avtar');
        $this->loader->add_action('wp_ajax_nopriv_upload_avtar', $plugin_public, 'upload_avtar');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Email_signature_generator_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
