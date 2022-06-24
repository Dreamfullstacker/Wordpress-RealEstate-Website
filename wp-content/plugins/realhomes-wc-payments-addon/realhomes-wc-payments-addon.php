<?php
/**
 * Plugin Name: RealHomes WooCommerce Payments Addon
 * Plugin URI: https://inspirythemes.com/
 * Description: Adds WooCommerce Payments support to RealHomes theme.
 * Author: InspiryThemes
 * Author URI: https://inspirythemes.com/
 * Text Domain: realhomes-wc-payments-addon
 * Version: 1.0.1
 * License: GPL v2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Realhomes_WC_Payments_Addon' ) ) {
	/**
	 * Class Realhomes_WC_Payments_Addon
	 *
	 * Plugin's main class.
	 *
	 * @since 1.0.0
	 */
	final class Realhomes_WC_Payments_Addon {

		/**
		 * RealHomes WooCommerce Payments Addon plugin version.
		 *
		 * @var version
		 */
		public $version = '1.0.1';

		/**
		 * Single instance of Class.
		 *
		 * @var Realhomes_WC_Payments_Addon
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Provides singleton instance.
		 *
		 * @since 1.0.0
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Realhomes_WC_Payments_Addon constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			// RealHome WooCommerce Payments Addon plugin loaded action hook.
			do_action( 'rhwpa_loaded' );

		}

		/**
		 * Define plugin constants.
		 *
		 * @since 1.0.0
		 */
		protected function define_constants() {

			// Plugin version.
			if ( ! defined( 'RHWPA_VERSION' ) ) {
				define( 'RHWPA_VERSION', $this->version );
			}

			// Plugin directory path.
			if ( ! defined( 'RHWPA_PLUGIN_DIR' ) ) {
				define( 'RHWPA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin directory URL.
			if ( ! defined( 'RHWPA_PLUGIN_URL' ) ) {
				define( 'RHWPA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin file path relative to plugins directory.
			if ( ! defined( 'RHWPA_PLUGIN_BASENAME' ) ) {
				define( 'RHWPA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			}

		}

		/**
		 * Includes files required on admin and frontend side.
		 *
		 * @since 1.0.0
		 */
		public function includes() {

			require_once RHWPA_PLUGIN_DIR . 'assets/wc-payments-addon-functions.php'; // Membership payment and subscription handler.
			require_once RHWPA_PLUGIN_DIR . 'assets/membership-payment-handler.php'; // Membership payment and subscription handler.
			require_once RHWPA_PLUGIN_DIR . 'assets/property-payment-handler.php'; // Individual property payment handler.
			require_once RHWPA_PLUGIN_DIR . 'assets/booking-payment-handler.php'; // Property booking payment handler.
			require_once RHWPA_PLUGIN_DIR . 'assets/property-payment-settings.php'; // Settings page for the individual properties payments.

			if ( class_exists( 'ERE_Subscription_API' ) && ERE_Subscription_API::status() ) {
				require_once RHWPA_PLUGIN_DIR . 'assets/plugin-update.php';   // Plugin update functions.
			}
		}

		/**
		 * Initialize the plugin hooks.
		 *
		 * @since 1.0.0
		 */
		public function init_hooks() {
			// Initiate the plugin.
			add_action( 'init', array( $this, 'init' ) );

			// Load plugin scripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			if ( ! class_exists( 'Inspiry_Memberships' ) ) { // Only if inspiry memberships plugin is not active.
				// Register property woocommerce payments settings.
				$property_woo_payments_settings = new Realhomes_Property_WC_Payment_Settings();
				add_action( 'admin_init', array( $property_woo_payments_settings, 'register_settings' ) );
				add_action( 'admin_menu', array( $property_woo_payments_settings, 'settings_page_menu' ) );
			}
		}

		/**
		 * Initialize plugin and load text domain.
		 *
		 * @since 1.0.0
		 */
		public function init() {
			// Action before init.
			do_action( 'rhwpa_before_init' );

			// Load text domain for translation.
			$this->load_plugin_textdomain();

			// Action after init.
			do_action( 'rhwpa_after_init' );
		}

		/**
		 * Load text domain for translation.
		 *
		 * @since 1.0.0
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'realhomes-wc-payments-addon', false, dirname( RHWPA_PLUGIN_BASENAME ) . '/languages/' );
		}

		/**
		 * Enqueue the front-end side scripts.
		 *
		 * @since 1.0.0
		 */
		public function enqueue_scripts() {

			wp_enqueue_script(
				'rhwpa_public_js',
				RHWPA_PLUGIN_URL . 'assets/js/realhomes-wc-payments-addon.js',
				array( 'jquery' ),
				RHWPA_VERSION,
				true
			);
		}
	}
}

if ( ! function_exists( 'rhwpa_admin_notices' ) ) {
	/**
	 * WordPress admin noticies by this plugin.
	 */
	function rhwpa_admin_notices() {

		if ( ! class_exists( 'Easy_Real_Estate' ) ) {
			/*
			 * Display a notice if Easy Real Estate plugin is not activated.
			 * translators: 1. URL link.
			 */
			echo '<div class="error"><p><strong>' . esc_html__( 'RealHomes WooCommerce Payments Addon requires "Easy Real Estate" plugin to be installed and active.', 'realhomes-wp-payments-addon' ) . '</strong></p></div>';
		}

		if ( ! class_exists( 'WooCommerce' ) ) {
			/*
			 * Display a notice if WooCommerce plugin is not activated.
			 * translators: 1. URL link.
			 */
			echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'RealHomes WooCommerce Payments Addon requires "WooCommerce" plugin to be installed and active. You can download %s here.', 'realhomes-wp-payments-addon' ), '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
		}

		if ( class_exists( 'Inspiry_Stripe_Payments' ) ) {
			/*
			 * Display a notice if "Inspiry Stripe Payments for RealHomes" plugin is activated.
			 * translators: 1. URL link.
			 */
			echo '<div class="error"><p><strong>' . esc_html__( 'Please deactivate "Inspiry Stripe Payments for RealHomes" plugin as it will not work while using "RealHomes WooCommerce Payments Addon" plugin.', 'realhomes-wp-payments-addon' ) . '</strong></p></div>';
		}

		if ( class_exists( 'Realhomes_Paypal_Payments' ) ) {
			/*
			 * Display a notice if "RealHomes PayPal Payments" plugin is activated.
			 * translators: 1. URL link.
			 */
			echo '<div class="error"><p><strong>' . esc_html__( 'Please deactivate "RealHomes PayPal Payments" plugin as it will not work while using "RealHomes WooCommerce Payments Addon" plugin.', 'realhomes-wp-payments-addon' ) . '</strong></p></div>';
		}
	}
}

/**
 * Main instance of Realhomes_WC_Payments_Addon.
 *
 * Returns the main instance of Realhomes_WC_Payments_Addon to prevent the need to use globals.
 *
 * @return Realhomes_WC_Payments_Addon
 * @since  1.0.0
 */
function realhomes_wp_payments_addon_init() {

	// Display necessary admin notices.
	add_action( 'admin_notices', 'rhwpa_admin_notices' );

	if ( ! class_exists( 'WooCommerce' ) || ! class_exists( 'Easy_Real_Estate' ) ) {
		return;
	}

	return Realhomes_WC_Payments_Addon::instance();
}

/**
 * Get RHWPA Running - Only if Easy Real Estate and WooCommerce plugins are activated.
 */
add_action( 'plugins_loaded', 'realhomes_wp_payments_addon_init' );
