<?php
/**
 * Plugin Name: RealHomes Vacation Rentals
 * Plugin URI: https://inspirythemes.com/
 * Description: Add vacation rentals functionality to RealHomes theme.
 * Author: InspiryThemes
 * Author URI: https://inspirythemes.com/
 * Text Domain: realhomes-vacation-rentals
 * Version: 1.3.3
 * License: GPL v2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( ! class_exists( 'Realhomes_Vacation_Rentals' ) ) {
	/**
	 * Class Easy_Real_Estate
	 *
	 * Plugin's main class.
	 *
	 * @since 1.0.0
	 */
	final class Realhomes_Vacation_Rentals {

		/**
		 * Realhomes Vacation Rentals Version
		 *
		 * @var string
		 */
		public $version = '1.3.3';

		/**
		 * Single instance of Class.
		 *
		 * @var Realhomes_Vacation_Rentals
		 * @since 1.0.0
		 */
		protected static $_instance;

		/**
		 * Provides singleton instance.
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
		 * Realhomes_Vacation_Rentals constructor.
		 * @since 1.0.0
		 */
		public function __construct() {

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			// Realhomes Vacations Rentals plugin loaded action hook
			do_action( 'rvr_loaded' );

		}

		/**
		 * Define constants.
		 *
		 * @since 1.0.0
		 */
		protected function define_constants() {

			if ( ! defined( 'RVR_VERSION' ) ) {
				define( 'RVR_VERSION', $this->version );
			}

			// Full path and filename
			if ( ! defined( 'RVR_PLUGIN_FILE' ) ) {
				define( 'RVR_PLUGIN_FILE', __FILE__ );
			}

			// Plugin directory path
			if ( ! defined( 'RVR_PLUGIN_DIR' ) ) {
				define( 'RVR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin directory URL
			if ( ! defined( 'RVR_PLUGIN_URL' ) ) {
				define( 'RVR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin file path relative to plugins directory
			if ( ! defined( 'RVR_PLUGIN_BASENAME' ) ) {
				define( 'RVR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			}

		}

		/**
		 * Includes files required on admin and on frontend.
		 *
		 * @since 1.0.0
		 */
		public function includes() {

			require_once RVR_PLUGIN_DIR . 'assets/realhomes-vacatin-rentals-include.php';

			require_once RVR_PLUGIN_DIR . 'admin/realhomes-vacation-rentals-admin.php';

			new Realhomes_Vacation_Rentals_Admin();

			if ( class_exists( 'ERE_Subscription_API' ) && ERE_Subscription_API::status() ) {
				require_once RVR_PLUGIN_DIR . 'admin/plugin-update.php';   // plugin update functions.
			}

		}


		/**
		 * Initialize hooks.
		 *
		 * @since 1.0.0
		 */
		public function init_hooks() {
			add_action( 'init', array( $this, 'init' ) );
		}

		/**
		 * Initialize plugin.
		 *
		 * @since 1.0.0
		 */
		public function init() {
			// before init action
			do_action( 'before_rvr_init' );

			// load text domain for translation.
			$this->load_plugin_textdomain();

			// done with init
			do_action( 'rvr_init' );
		}

		/**
		 * Load text domain for translation.
		 * @since 1.0.0
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'realhomes-vacation-rentals', false, dirname( RVR_PLUGIN_BASENAME ) . '/languages/' );
		}
	}
}

if ( ! function_exists( 'rvr_is_wc_payment_enabled' ) ) {
	/**
	 * Check if woocommerce payments method enabled.
	 */
	function rvr_is_wc_payment_enabled() {

		$rvr_settings   = get_option( 'rvr_settings' );
		$payment_method = '';

		if ( ! empty( $rvr_settings['rvr_wc_payments'] ) ) {
			$payment_method = $rvr_settings['rvr_wc_payments'];
		}

		if ( rvr_is_enabled() && class_exists( 'WooCommerce' ) && class_exists( 'Realhomes_WC_Payments_Addon' ) && $payment_method ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'rvr_is_instant_booking' ) ) {
	/**
	 * Check if instant booking is enabled globally or
	 * it is enabled for the current property.
	 */
	function rvr_is_instant_booking( $property_id = '' ) {
		$rvr_settings = get_option( 'rvr_settings' );

		if ( ! empty( $rvr_settings['rvr_wc_payments_scope'] ) ) {
			if ( 'global' === $rvr_settings['rvr_wc_payments_scope'] ) {
				return true;
			}

			if ( 'property' === $rvr_settings['rvr_wc_payments_scope'] ) {
				$property_instant_booking = get_post_meta( $property_id, 'rvr_instant_booking', true );
				if ( $property_instant_booking ) {
					return true;
				}
			}
		}

		return false;
	}
}

/**
 * Main instance of Realhomes_Vacation_Rentals.
 *
 * Returns the main instance of Realhomes_Vacation_Rentals to prevent the need to use globals.
 *
 * @return Realhomes_Vacation_Rentals
 * @since  1.0.0
 */
function RVR() {
	return Realhomes_Vacation_Rentals::instance();
}

/**
 * Get RVR Running - Only if ERE plugin is activated.
 */
if ( class_exists( 'Easy_Real_Estate' ) ) {
	RVR();
}