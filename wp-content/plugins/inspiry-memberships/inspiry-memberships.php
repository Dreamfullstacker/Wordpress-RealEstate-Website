<?php
/**
 * Plugin Name:     Inspiry Memberships for RealHomes
 * Plugin URI:      https://github.com/InspiryThemes/inspiry-memberships
 * Description:     Provides functionality to create membership packages for real estate themes by Inspiry Themes
 * Version:         2.3.0
 * Author:          Inspiry Themes
 * Author URI:      https://inspirythemes.com
 * Contributors:    inspirythemes, saqibsarwar, fahidjavid
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     inspiry-memberships
 * Domain Path:     /languages/
 *
 * GitHub Plugin URI: https://github.com/InspiryThemes/inspiry-memberships
 *
 * @since            1.0.0
 * @package          IMS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Inspiry_Memberships' ) ) :

	/**
	 * Inspiry_Memberships.
	 *
	 * Plugin Core Class.
	 *
	 * @since 1.0.0
	 */
	class Inspiry_Memberships {

		/**
		 * Version.
		 *
		 * @var    string
		 * @since    1.0.0
		 */
		public $version = '2.3.0';

		/**
		 * Inspiry Memberships Instance.
		 *
		 * @var    Inspiry_Memberships
		 * @since    1.0.0
		 */
		protected static $_instance;

		/**
		 * Method: Creates an instance of the class.
		 *
		 * @since 1.0.0
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;

		}

		/**
		 * Method: Contructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Get started here.
			$this->define_constants();
			$this->include_files();
			$this->init_hooks();

			// Plugin is loaded.
			do_action( 'ims_loaded' );

		}

		/**
		 * Load plugin textdomain.
		 *
		 * @since 1.0.3
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'inspiry-memberships', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Method: Define constants.
		 *
		 * @since 1.0.0
		 */
		public function define_constants() {

			// Plugin version.
			if ( ! defined( 'IMS_VERSION' ) ) {
				define( 'IMS_VERSION', $this->version );
			}

			// Plugin Name.
			if ( ! defined( 'IMS_BASE_NAME' ) ) {
				define( 'IMS_BASE_NAME', plugin_basename( __FILE__ ) );
			}

			// Plugin Directory URL.
			if ( ! defined( 'IMS_BASE_URL' ) ) {
				define( 'IMS_BASE_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Directory Path.
			if ( ! defined( 'IMS_BASE_DIR' ) ) {
				define( 'IMS_BASE_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Docs URL.
			if ( ! defined( 'IMS_DOCS_URL' ) ) {
				define( 'IMS_DOCS_URL', 'https://inspirythemes.com/realhomes-memberships-setup/' );
			}

			// Plugin Issue Reporting URL.
			if ( ! defined( 'IMS_ISSUE_URL' ) ) {
				define( 'IMS_ISSUE_URL', 'https://inspirythemes.com/feedback/' );
			}

		}

		/**
		 * Method: Include files.
		 *
		 * @since 1.0.0
		 */
		public function include_files() {

			/**
			 * IMS-init.php.
			 *
			 * @since 1.0.0
			 */
			if ( file_exists( IMS_BASE_DIR . '/resources/load-resources.php' ) ) {
				include_once IMS_BASE_DIR . '/resources/load-resources.php';
			}

		}

		/**
		 * Method: Initialization hooks.
		 *
		 * @since 1.0.0
		 */
		public function init_hooks() {
			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
			add_filter( 'plugin_action_links_' . IMS_BASE_NAME, array( $this, 'settings_action_link' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_public_scripts' ) ); // Load public area scripts.
			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) ); // Load admin area scripts.
		}

		/**
		 * Add plugin settings link
		 *
		 * @param string $links - links related to plugin.
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function settings_action_link( $links ) {
			$links[] = '<a href="' . get_admin_url( null, 'admin.php?page=ims_settings' ) . '">' . esc_html__( 'Settings', 'inspiry-memberships' ) . '</a>';

			return $links;
		}

		/**
		 * Load public area scripts.
		 *
		 * @since 2.0.0
		 */
		public function load_public_scripts() {

			if ( ! is_admin() ) {

				// JS functions file.
				wp_register_script(
					'ims-public-js',
					IMS_BASE_URL . 'resources/js/ims-public.js',
					array( 'jquery' ),
					IMS_VERSION,
					true
				);

				// data to print in JavaScript format above edit profile script tag in HTML.
				$ims_js_data = array(
					'ajaxURL' => admin_url( 'admin-ajax.php' ),
				);

				wp_localize_script( 'ims-public-js', 'jsData', $ims_js_data );
				wp_enqueue_script( 'ims-public-js' );

				$stripe_settings = get_option( 'ims_stripe_settings' );
				if ( ! empty( $stripe_settings['ims_stripe_enable'] ) && 'on' === $stripe_settings['ims_stripe_enable'] ) {
					if ( ! empty( $_GET['module'] ) && ! empty( $_GET['submodule'] ) && 'membership' === $_GET['module'] && 'checkout' === $_GET['submodule'] ) {						
						wp_enqueue_script(
							'stripe-library-v3',
							'https://js.stripe.com/v3/',
							array( 'jquery' ),
							$this->version,
							false
						);
					}
				}

			}

		}

		/**
		 * Load admin area scripts.
		 */
		public function load_admin_scripts( $hook ) {

			if ( is_admin() && 'memberships_page_ims_settings' === $hook ) {

				// JS functions file.
				wp_register_script(
					'ims-admin-js',
					IMS_BASE_URL . 'resources/js/ims-admin.js',
					array( 'jquery' ),
					IMS_VERSION,
					true
				);
				wp_enqueue_script( 'ims-admin-js' );

			}

		}
	}

endif;


/**
 * Returns the main instance of Inspiry_Memberships.
 *
 * @since 1.0.0
 */
function ims() {
	return Inspiry_Memberships::instance();
}

ims();
