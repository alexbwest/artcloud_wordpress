<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://webarts.io
 * @since      1.0.0
 *
 * @package    Artcloud_Api_Display
 * @subpackage Artcloud_Api_Display/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Artcloud_Api_Display
 * @subpackage Artcloud_Api_Display/includes
 * @author     Webarts.io <ceo@webarts.io>
 */
class Artcloud_Api_Display_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'artcloud-api-display',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
