<?php
/**
 * The file that defines the core plugin class.
 *
 * A class definition that includes includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 * @package    inspiry-stripe-payments
 * @subpackage inspiry-stripe-payments/includes
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
 * @since 1.0.0
 */
class Inspiry_Stripe_Payments {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.1.0
	 * @access protected
	 * @var    Inspiry_Stripe_Payments_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name The string used to uniquely identify this plugin.
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
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Setting the plugin current version.
		if ( defined( 'INSPIRY_STRIPE_PAYMENTS_VERSION' ) ) {
			$this->version = INSPIRY_STRIPE_PAYMENTS_VERSION;
		} else {
			$this->version = '1.0.1';
		}

		// Setting the plugin unique identifire.
		if ( defined( 'INSPIRY_STRIPE_PAYMENTS_NAME' ) ) {
			$this->plugin_name = INSPIRY_STRIPE_PAYMENTS_NAME;
		} else {
			$this->plugin_name = 'inspiry-stripe-payments';
		}

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
	 * - Inspiry_Stripe_Payments_Loader. Orchestrates the hooks of the plugin.
	 * - Inspiry_Stripe_Payments_i18n. Defines internationalization functionality.
	 * - Inspiry_Stripe_Payments_Admin. Defines all hooks for the admin area.
	 * - Inspiry_Stripe_Payments_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once ISP_PLUGIN_DIR_PATH . 'includes/class-inspiry-stripe-payments-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once ISP_PLUGIN_DIR_PATH . 'includes/class-inspiry-stripe-payments-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once ISP_PLUGIN_DIR_PATH . 'admin/class-inspiry-stripe-payments-admin.php';

		/**
		 * Initialize settings
		 */
		require_once ISP_PLUGIN_DIR_PATH . 'admin/class-inspiry-stripe-payments-settings.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once ISP_PLUGIN_DIR_PATH . 'public/class-inspiry-stripe-payments-public.php';

		/**
		 * The class responsible for defining all actions and filters of the stripe payment.
		 */
		require_once ISP_PLUGIN_DIR_PATH . 'public/class-inspiry-stripe-payments-handler.php';

		$this->loader = new Inspiry_Stripe_Payments_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Inspiry_Stripe_Payments_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Inspiry_Stripe_Payments_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		// Register inspiry stripe payments plugin settings.
		$plugin_settings = new Inspiry_Stripe_Payments_settings();
		$this->loader->add_action( 'admin_init', $plugin_settings, 'register_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_settings, 'settings_page_menu' );

		// Enqueuing admin specfic scripts.
		$plugin_admin = new Inspiry_Stripe_Payments_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		if ( isp_is_enabled() ) {

			// Initialize the stripe payments handler.
			$payment_handler = new Inspiry_Stripe_Payments_Handler();
			$this->loader->add_action( 'init', $payment_handler, 'update_property' );
			$this->loader->add_action( 'wp_ajax_inspiry_stripe_payment', $payment_handler, 'process_property_payment' );

			// Enqueue public-facing related scripts.
			$plugin_public = new Inspiry_Stripe_Payments_Public( $this->get_plugin_name(), $this->get_version() );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.1.0
	 * @return    Inspiry_Stripe_Payments_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}

if ( ! function_exists( 'isp_is_enabled' ) ) {
	/**
	 * Check if Inspiry Stripe Payments functionality is enabled.
	 */
	function isp_is_enabled() {

		$isp_settings = get_option( 'isp_settings' );
		if ( ! empty( $isp_settings['enable_stripe'] ) &&
			! empty( $isp_settings['publishable_key'] ) &&
			! empty( $isp_settings['secret_key'] ) &&
			! empty( $isp_settings['amount'] ) &&
			! empty( $isp_settings['currency_code'] ) ) {
				return true;
		}

		return false;
	}
}
