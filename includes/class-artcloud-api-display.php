<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://webarts.io
 * @since      1.0.0
 *
 * @package    Artcloud_Api_Display
 * @subpackage Artcloud_Api_Display/includes
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
 * @package    Artcloud_Api_Display
 * @subpackage Artcloud_Api_Display/includes
 * @author     Webarts.io <ceo@webarts.io>
 */
class Artcloud_Api_Display {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Artcloud_Api_Display_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->plugin_name = 'artcloud';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
		
	//	$this->loader->add_action( 'admin_post_art_save_options', $plugin_admin, 'art_save_options' );
		add_action( 'admin_post_art_save_options', array($this, 'art_save_options') ); //save the options in the wordpress options table.
		add_shortcode('include_ventory',  array($this, 'includeInventory') );
		add_shortcode('filter_inventory_by_artist',  array($this, 'filterInventoryByArtist') );
		add_shortcode('artcloud',  array($this, 'includeArtist') );
		add_shortcode('include_an_exhibition',  array($this, 'includeAnExhibition') );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Artcloud_Api_Display_Loader. Orchestrates the hooks of the plugin.
	 * - Artcloud_Api_Display_i18n. Defines internationalization functionality.
	 * - Artcloud_Api_Display_Admin. Defines all hooks for the admin area.
	 * - Artcloud_Api_Display_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-artcloud-api-display-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-artcloud-api-display-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-artcloud-api-display-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-artcloud-api-display-public.php';

		$this->loader = new Artcloud_Api_Display_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Artcloud_Api_Display_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Artcloud_Api_Display_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Artcloud_Api_Display_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Artcloud_Api_Display_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * @return    Artcloud_Api_Display_Loader    Orchestrates the hooks of the plugin.
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


	public function art_save_options() {
		
		 if (isset($_POST['art_add_nonce_save_settings'], $_POST['art_save_settings']) && wp_verify_nonce($_POST['art_add_nonce_save_settings'], 'art_nonce_save_settings')) {
             include( 'art_save_settings.php' );
         }
          else {
         	  die( 'No script kiddies please!' );
         }   
	}

	/**
	 * Shortcode Include inventory
	 *
	 * @since    1.0.0
	 */
	public function includeInventory() {

		ob_start();
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/include-inventory.php';
		$out = ob_get_clean();

		return $out;
	}

	/**
	 * Shortcode Filter inventory by artist
	 *
	 * @since    1.0.0
	 */
	public function filterInventoryByArtist() {

		ob_start();
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/filter-inventory-by-artist.php';
		$out = ob_get_clean();

		return $out;
	}

	/**
	 * Shortcode Filter inventory by artist
	 *
	 * @since    1.0.0
	 */
	public function includeArtist($atts) {

		ob_start();

		$param = shortcode_atts( array(
			'type'      => 'type',
			'theme'     => 'theme',
			'artist'    => 'artist',
			'min_price' => 'min_price',
			'max_price' => 'max_price',
			'tag'       => 'tag'
	    ), $atts );
		
		if($param['theme'] == 'grid') {			
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/artcloud-shortcode-display-grid.php';
		}
		else {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/artcloud-shortcode-display.php';	
		}
		
		$out = ob_get_clean();

		return $out;
	}
	/**
	 * Shortcode Filter inventory by artist
	 *
	 * @since    1.0.0
	 */
	public function includeAnExhibition() {

		ob_start();
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/include-an-exhibition.php';
		$out = ob_get_clean();

		return $out;
	}

	/**
	 * Get parameter from URL
	 *
	 * @since    1.0.0
	 */
	public function getParamFromUrl($url) {
		
		$rs = explode('?', $url);

		$_rs = explode('=', $rs[1]);

		return $_rs[1];
	}

}
