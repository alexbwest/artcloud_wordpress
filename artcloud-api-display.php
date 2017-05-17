<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://artcld.com
 * @since             1.0.0
 * @package           Artcloud_Api_Display
 *
 * @wordpress-plugin
 * Plugin Name:       artcloud
 * Plugin URI:        http://webarts.io
 * Description:       Connect your artcloud inventory, artists, and exhibitions to your wordpress website.
 * Version:           1.0.0
 * Author:            artcloud
 * Author URI:        https://artcld.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       artcloud-api-display
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( !defined( 'ART_SETTINGS' ) ) {
    define( 'ART_SETTINGS', 'art-settings' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-artcloud-api-display-activator.php
 */
function activate_artcloud_api_display() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-artcloud-api-display-activator.php';
	Artcloud_Api_Display_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-artcloud-api-display-deactivator.php
 */
function deactivate_artcloud_api_display() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-artcloud-api-display-deactivator.php';
	Artcloud_Api_Display_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_artcloud_api_display' );
register_deactivation_hook( __FILE__, 'deactivate_artcloud_api_display' );



/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-artcloud-api-display.php';
require plugin_dir_path( __FILE__ ) . 'includes/mce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_artcloud_api_display() {

	$plugin = new Artcloud_Api_Display();
	$plugin->run();

}
run_artcloud_api_display();
