<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 * @package    realhomes-paypal-payments
 * @subpackage realhomes-paypal-payments/includes
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
 */
class Realhomes_Paypal_Payments {

	/**
	 * The paypal handler that's responsible for handling all paypal payments related tasks in
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Realhomes_Paypal_Payments_Handler $paypal Handls all paypal payments related tasks.
	 */
	protected $paypal;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Realhomes_Paypal_Payments_Loader $loader Maintains and registers all hooks for the plugin.
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
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Setting the plugin current version.
		if ( defined( 'REALHOMES_PAYPAL_PAYMENTS_VERSION' ) ) {
			$this->version = REALHOMES_PAYPAL_PAYMENTS_VERSION;
		} else {
			$this->version = '1.0.1';
		}

		// Setting the plugin unique identifire.
		if ( defined( 'REALHOMES_PAYPAL_PAYMENTS_NAME' ) ) {
			$this->plugin_name = REALHOMES_PAYPAL_PAYMENTS_NAME;
		} else {
			$this->plugin_name = 'realhomes-paypal-payments';
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
	 * - Realhomes_Paypal_Payments_Loader. Orchestrates the hooks of the plugin.
	 * - Realhomes_Paypal_Payments_i18n. Defines internationalization functionality.
	 * - Realhomes_Paypal_Payments_Admin. Defines all hooks for the admin area.
	 * - Realhomes_Paypal_Payments_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-realhomes-paypal-payments-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-realhomes-paypal-payments-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-realhomes-paypal-payments-admin.php';

		/**
		 * The class responsible for realhomes paypal payments settings.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-realhomes-paypal-payments-settings.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-realhomes-paypal-payments-public.php';

		/**
		 * A paypal php software development kit to fulfil all paypal payment actions side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/paypal-php-sdk/autoload.php';

		/**
		 * The class responsible for defining all actions that occur in the paypal payment
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-realhomes-paypal-payments-handler.php';

		$this->loader = new Realhomes_Paypal_Payments_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Realhomes_Paypal_Payments_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Realhomes_Paypal_Payments_i18n();

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

		$plugin_settings = new Realhomes_Paypal_Payments_settings();
		$this->loader->add_action( 'admin_init', $plugin_settings, 'register_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_settings, 'settings_page_menu' );

		$plugin_admin = new Realhomes_Paypal_Payments_Admin( $this->get_plugin_name(), $this->get_version() );
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

		if ( rpp_is_enabled() ) {
			$paypal_handler = new Realhomes_Paypal_Payments_Handler();
			$this->loader->add_action( 'init', $paypal_handler, 'init' );
		}

		$plugin_public = new Realhomes_Paypal_Payments_Public( $this->get_plugin_name(), $this->get_version() );
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
	 * @return    Simple_Paypal_Payments_Loader    Orchestrates the hooks of the plugin.
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

if ( ! function_exists( 'rpp_is_enabled' ) ) {
	/**
	 * Check if RealHomes PayPal Payments functionality is enabled.
	 */
	function rpp_is_enabled() {

		$rpp_settings = get_option( 'rpp_settings' );
		if ( ! empty( $rpp_settings['enable_paypal'] ) &&
			! empty( $rpp_settings['client_id'] ) &&
			! empty( $rpp_settings['secret_id'] ) &&
			! empty( $rpp_settings['payment_amount'] ) &&
			! empty( $rpp_settings['currency_code'] ) &&
			! empty( $rpp_settings['redirect_page_url'] ) ) {
				return true;
		}

		return false;
	}
}
