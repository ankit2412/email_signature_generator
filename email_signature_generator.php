<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://riopromo.com/
 * @since             1.0.0
 * @package           Email_signature_generator
 *
 * @wordpress-plugin
 * Plugin Name:       Email Signature Generator
 * Plugin URI:        https://riopromo.com/
 * Description:       This plugin is used to create a real time email signature.
 * Version:           1.0.0
 * Author:            Rio Promo
 * Author URI:        https://riopromo.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       email_signature_generator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EMAIL_SIGNATURE_GENERATOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-email_signature_generator-activator.php
 */
function activate_email_signature_generator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-email_signature_generator-activator.php';
	Email_signature_generator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-email_signature_generator-deactivator.php
 */
function deactivate_email_signature_generator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-email_signature_generator-deactivator.php';
	Email_signature_generator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_email_signature_generator' );
register_deactivation_hook( __FILE__, 'deactivate_email_signature_generator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-email_signature_generator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_email_signature_generator() {

	$plugin = new Email_signature_generator();
	$plugin->run();

}
run_email_signature_generator();
