<?php
/**
 * Plugin Name: RealHomes Elementor Addon
 * Plugin URI: http://themeforest.net/item/real-homes-wordpress-real-estate-theme/5373914
 * Description: Provides RealHomes based Elementor widgets.
 * Version: 0.9.6
 * Author: Inspiry Themes
 * Author URI: https://inspirythemes.com
 * Text Domain: realhomes-elementor-addon
 * Domain Path: /languages
 * Elementor tested up to: 3.5.5
 * Elementor Pro tested up to: 3.0.8
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'RealHomes_Elementor_Addon' ) ) {

	final class RealHomes_Elementor_Addon {
		/**
		 * Plugin's current version
		 *
		 * @var string
		 */
		public $version;

		/**
		 * Plugin Name
		 *
		 * @var string
		 */
		public $plugin_name;

		/**
		 * Plugin's singleton instance.
		 *
		 * @var RealHomes_Elementor_Addon
		 */
		protected static $_instance;

		public function __construct() {

			$this->plugin_name = 'realhomes-elementor-addon';
			$this->version     = '0.9.6';

			// RealHomes Elementor Addon Depends on Easy Real Estate plugin
			if ( class_exists( 'Easy_Real_Estate' ) ) {
				$this->define_constants();
				$this->includes();
				$this->init_hooks();
				do_action( 'realhomes_elementor_addon_loaded' );
			}

			register_activation_hook( __FILE__, array( $this, 'disable_global_schemes' ) );
		}

		public function disable_global_schemes() {
			/**
			 * Disable global schemes on plugin activation.
			 */
			update_option( 'elementor_disable_typography_schemes', 'yes' );
			update_option( 'elementor_disable_color_schemes', 'yes' );
			$get_elementor_container_width = get_option( 'elementor_container_width' );
			if ( empty( $get_elementor_container_width ) ) {
				update_option( 'elementor_container_width', 1240 );
			}
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		protected function define_constants() {

			if ( ! defined( 'RHEA_VERSION' ) ) {
				define( 'RHEA_VERSION', $this->version );
			}

			// Full path and filename
			if ( ! defined( 'RHEA_PLUGIN_FILE' ) ) {
				define( 'RHEA_PLUGIN_FILE', __FILE__ );
			}

			// Plugin directory path
			if ( ! defined( 'RHEA_PLUGIN_DIR' ) ) {
				define( 'RHEA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin directory URL
			if ( ! defined( 'RHEA_PLUGIN_URL' ) ) {
				define( 'RHEA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin file path relative to plugins directory
			if ( ! defined( 'RHEA_PLUGIN_BASENAME' ) ) {
				define( 'RHEA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			}

			// Plugin Assets Director
			if ( ! defined( 'RHEA_ASSETS_DIR' ) ) {
				define( 'RHEA_ASSETS_DIR', RHEA_PLUGIN_DIR . 'assets/' );
			}

		}

		public function includes() {
			$this->include_functions();
		}

		/**
		 * Functions
		 */
		public function include_functions() {
			include_once( RHEA_PLUGIN_DIR . 'includes/functions/basic.php' );
			include_once( RHEA_PLUGIN_DIR . 'includes/functions/rhea-search.php' );
			include_once( RHEA_PLUGIN_DIR . 'includes/functions/inquiry-form-handler.php' );


			if ( class_exists( 'ERE_Subscription_API' ) && ERE_Subscription_API::status() ) {
				include_once( RHEA_PLUGIN_DIR . 'includes/functions/plugin-update.php' );   // plugin update functions
			}
		}



		/**
		 * Initialize hooks.
		 */
		public function init_hooks() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'plugins_loaded', [ $this, 'initialize_elementor_stuff' ] );    // initialize elementor widgets
		}

		/**
		 * Initialize plugin.
		 */
		public function init() {
			do_action( 'before_rhea_init' );    // before init action

			$this->load_plugin_textdomain();    // load text domain for translation.

			do_action( 'rhea_init' );   // done with init
		}

		/**
		 * Load text domain for translation.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'realhomes-elementor-addon', false, dirname( RHEA_PLUGIN_BASENAME ) . '/languages' );
		}

		/**
		 * Initialize elementor stuff
		 */
		public function initialize_elementor_stuff() {
			include_once( RHEA_PLUGIN_DIR . 'elementor/class-rhea-elementor-extension.php' );
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden!', 'realhomes-elementor-addon' ), RHEA_VERSION );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing is forbidden!', 'realhomes-elementor-addon' ), RHEA_VERSION );
		}

	}
}

/**
 * Returns the main instance of RealHomes_Elementor_Addon to prevent the need to use globals.
 *
 * @return RealHomes_Elementor_Addon
 */
function init_realhomes_elementor_addon() {
	return RealHomes_Elementor_Addon::instance();
}

// Get RealHomes Elementor Addon Running.
init_realhomes_elementor_addon();