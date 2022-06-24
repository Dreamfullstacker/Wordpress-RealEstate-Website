<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://inspirythemes.com/
 * @since      1.0.0
 *
 * @package    realhomes-currency-switcher
 * @subpackage realhomes-currency-switcher/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class Realhomes_Currency_Switcher_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Currencies Rates URL.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $currencies_rates_url    Currencies rates fetch URL.
	 */
	protected $currencies_rates_url;

	/**
	 * Currencies List URL.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $currencies_list_url    Currencies list fetch URL.
	 */
	protected $currencies_list_url;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->currencies_list_url  = 'http://openexchangerates.org/api/currencies.json';
		$this->currencies_rates_url = 'http://openexchangerates.org/api/latest.json?app_id=';

		$currencies_last_update = get_option( 'realhomes_currencies_last_update' );
		// Force update currencies rates if related option is checked.
		if ( isset( $_POST['rcs_settings']['update_currencies_rates'] ) || empty( $currencies_last_update ) ) { // phpcs:ignore
			$this->update_currencies_rates();
		}

		/*
		 * Setting up a cron job to update currencies' rates and data autometically
		 * according to the given interval.
		 */
		if ( ! wp_next_scheduled( 'realhomes_update_currencies' ) ) {
			$rcs_settings    = get_option( 'rcs_settings' );
			$update_interval = empty( $rcs_settings['update_interval'] ) ? 'daily' : $rcs_settings['update_interval'];
			wp_schedule_event( time(), $update_interval, 'realhomes_update_currencies' );
		}
	}

	/**
	 * Update currencies rates into the database for a currencies exchange rates API.
	 *
	 * @since  1.0.0
	 * @return array|null
	 */
	public function update_currencies_rates() {

		$rcs_settings = get_option( 'rcs_settings' );

		// If an API key is not set return null.
		if ( ! isset( $rcs_settings['app_id'] ) ) {
			return null;
		}

		// Get the currencies rates (default base currency is US dollars).
		$response = wp_remote_get( $this->currencies_rates_url . $rcs_settings['app_id'] );

		// Check if request response is safe.
		if ( ! is_wp_error( $response ) ) {
			$json      = isset( $response['body'] ) ? json_decode( $response['body'] ) : $response;
			$new_rates = isset( $json->rates ) ? (array) $json->rates : $json;

			if ( is_array( $new_rates ) ) {

				update_option( 'realhomes_currencies_rates', $new_rates );

				$currencies_data = $this->build_currencies_data();

				if ( ! empty( $currencies_data ) && is_array( $currencies_data ) ) {
					update_option( 'realhomes_currencies_data', $currencies_data );
				}

				update_option( 'realhomes_currencies_last_update', gmdate( 'l jS F Y h:i A' ) );
			}

			return (array) apply_filters( 'realhomes_currencies_rates', $new_rates );
		}

		return null;
	}

	/**
	 * Build currencies data to be used in currencies formating.
	 *
	 * @since  1.0.0
	 * @return array|null
	 */
	public function build_currencies_data() {

		$currencies = array();

		$currency_data = wp_remote_get( $this->currencies_list_url );

		// Check if request response is safe.
		if ( ! is_wp_error( $currency_data ) ) {

			$currency_data = isset( $currency_data['body'] ) ? (array) json_decode( $currency_data['body'] ) : $currency_data;

			// Expecting an array with over 100 currencies.
			if ( is_array( $currency_data ) && count( $currency_data ) > 100 ) {

				foreach ( $currency_data as $currency_code => $currency_name ) {

					if ( ! is_string( $currency_code ) || ! is_string( $currency_name ) ) {
						continue;
					}

					$currency_code = strtoupper( substr( sanitize_key( $currency_code ), 0, 3 ) );

					// Defaults.
					$currencies[ $currency_code ] = array(
						'name'          => sanitize_text_field( $currency_name ),
						'symbol'        => $currency_code,
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);
				}
			}

			// Format meta for each currency.
			$currency_data = realhomes_format_currency_data( $currencies );

			return (array) apply_filters( 'realhomes_currencies_data', $currency_data );
		}

		return null;
	}

	/**
	 * Switch current currency to the currencyuser selected from
	 * frontend side.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function switch_current_currency() {

		if ( isset( $_POST['switch_to_currency'] ) && isset( $_POST['nonce'] ) ) {

			// Nonce verification.
			$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			if ( ! wp_verify_nonce( $nonce, 'switch_currency_nonce' ) ) {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Unverified Nonce!', 'realhomes-currency-switcher' ),
					)
				);
				die;
			}

			$switch_to_currency = sanitize_text_field( wp_unslash( $_POST['switch_to_currency'] ) );

			// expiry time.
			$rcs_settings  = get_option( 'rcs_settings' );
			$expiry_period = intval( $rcs_settings['switched_currency_expiry'] );
			if ( ! $expiry_period ) {
				$expiry_period = 60 * 60;   // one hour.
			}
			$expiry = time() + $expiry_period;

			// save cookie.
			if ( realhomes_currency_exists( $switch_to_currency ) && setcookie( 'realhomes_current_currency', $switch_to_currency, $expiry, COOKIEPATH, COOKIE_DOMAIN ) ) {
				echo wp_json_encode(
					array(
						'success' => true,
					)
				);
			} else {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Failed to update cookie!', 'realhomes-currency-swticher' ),
					)
				);
			}
		} else {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Invalid Request!', 'realhomes-currency-switcher' ),
					)
				);
		}

		die;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Realhomes_Currency_Switcher_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Realhomes_Currency_Switcher_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/realhomes-currency-switcher-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Realhomes_Currency_Switcher_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Realhomes_Currency_Switcher_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/realhomes-currency-switcher-admin.js', array( 'jquery' ), $this->version, false );

	}

}
