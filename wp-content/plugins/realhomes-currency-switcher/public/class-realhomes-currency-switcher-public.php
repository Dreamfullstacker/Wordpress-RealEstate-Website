<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://inspirythemes.com/
 * @since      1.0.0
 *
 * @package    realhomes-currency-switcher
 * @subpackage realhomes-currency-switcher/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the public-facing stylesheet and JavaScript.
 */
class Realhomes_Currency_Switcher_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/realhomes-currency-switcher-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/realhomes-currency-switcher-public.js', array( 'jquery' ), $this->version, false );

	}

}

if ( ! function_exists( 'realhomes_currency_switcher_button' ) ) {
	/**
	 * Currency switcher button markup for the frontend side.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function realhomes_currency_switcher_button() {

		$rcs_settings    = get_option( 'rcs_settings' ); // currencies settings.
		$currencies_data = get_option( 'realhomes_currencies_data' ); // currencies data that was saved in the database.

		if ( realhomes_currency_switcher_enabled() && ! empty( $rcs_settings['app_id'] ) && ! empty( $currencies_data ) && is_array( $currencies_data ) ) {

			$supported_currencies = realhomes_get_supported_currencies();
			$current_currency     = realhomes_get_current_currency();

			$open_class = '';
			if ( 'full' === get_theme_mod( 'inspiry_default_floating_button', 'half' ) ) {
				$open_class = 'rh_currency_open_full';
			}

			if ( 0 < count( $supported_currencies ) ) {

				echo '<div class="rh_wrapper_currency_switcher ' . esc_attr( $open_class ) . '">';
				echo '<form id="currency-switcher-form" method="post" action="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '" >';
				echo '<div id="currency-switcher">';
				echo '<div id="selected-currency"><i class="currency-flag currency-flag-' . esc_attr( strtolower( $current_currency ) ) . '"></i><span class="currency_text">' . esc_html( $current_currency ) . '</span></div>';
				echo '<ul id="currency-switcher-list">';

				foreach ( $supported_currencies as $currency_code ) {
					$selected_currency = ( $currency_code === $current_currency ) ? 'selected-currency' : '';
					echo '<li data-currency-code="' . esc_attr( $currency_code ) . '" class="' . esc_attr( $selected_currency ) . '"><i class="currency-flag currency-flag-' . esc_attr( strtolower( $currency_code ) ) . '"></i><span class="currency_text">' . esc_html( $currency_code ) . '</span></li>';
				}

				echo '</ul>';
				echo '</div>';
				echo '<input type="hidden" id="switch-to-currency" name="switch_to_currency" value="' . esc_attr( $current_currency ) . '" />';
				echo '<input type="hidden" name="action" value="switch_currency" />';
				echo '<input type="hidden" name="nonce" value="' . esc_attr( wp_create_nonce( 'switch_currency_nonce' ) ) . '"/>';
				echo '</form>';
				echo '</div>';

			}
		}
	}
}

if ( ! function_exists( 'realhomes_get_supported_currencies' ) ) {
	/**
	 * Return an array of currencies codes that are set
	 * from plugin settings.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	function realhomes_get_supported_currencies() {

		$rcs_settings             = get_option( 'rcs_settings' );
		$supported_currencies_str = $rcs_settings['supported_currencies'];

		if ( ! empty( $supported_currencies_str ) ) {
			$supported_currencies_array = explode( ',', $supported_currencies_str );
		} else {
			$supported_currencies_array = array(
				'USD',
				'EUR',
				'GBP',
			);
		}

		if( isset( $rcs_settings['auto_active_currency_value'] ) && $rcs_settings['auto_active_currency_value'] ) {
			$supported_currencies_array[] = $rcs_settings['auto_active_currency_value'];
		}

		return array_slice( $supported_currencies_array, 0, 5 );
	}
}

if ( ! function_exists( 'realhomes_get_current_currency' ) ) {
	/**
	 * Return current currency if set, otherwise base currency.
	 *
	 * @return string
	 */
	function realhomes_get_current_currency() {

		$rcs_settings = get_option( 'rcs_settings' );

		if ( isset( $_COOKIE['realhomes_current_currency'] ) && realhomes_currency_exists( $_COOKIE['realhomes_current_currency'] ) ) { // phpcs:ignore
			$current_currency = $_COOKIE['realhomes_current_currency']; // phpcs:ignore
		} elseif( isset( $rcs_settings['auto_active_currency_value'] ) && $rcs_settings['auto_active_currency_value'] ) {
			$current_currency = $rcs_settings['auto_active_currency_value'];
		} else {
			$current_currency = realhomes_get_base_currency();
		}

		return strtoupper( $current_currency );
	}
}

if ( ! function_exists( 'realhomes_get_base_currency' ) ) {
	/**
	 * Return base currency of the site.
	 *
	 * @return string
	 */
	function realhomes_get_base_currency() {

		$rcs_settings = get_option( 'rcs_settings' );

		if ( ! empty( $rcs_settings['base_currency'] ) ) {
			return strtoupper( $rcs_settings['base_currency'] );
		}

		return 'USD';
	}
}

if ( ! function_exists( 'realhomes_currency_exists' ) ) {
	/**
	 * Check if given currency code exists in the
	 * currenciesrates and currencies data.
	 *
	 * @since  1.0.0
	 * @param  string $currency_code  Code of the currency that has to be check.
	 * @return bool
	 */
	function realhomes_currency_exists( $currency_code ) {

		$currencies_rates = realhomes_get_currencies_rates();
		$currencies_data  = realhomes_get_currencies_data();

		if ( isset( $currencies_rates[ $currency_code ] ) && isset( $currencies_data[ $currency_code ] ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'realhomes_get_currencies_data' ) ) {
	/**
	 * Return currency data from database.
	 *
	 * @since  1.0.0
	 * @return array|null
	 */
	function realhomes_get_currencies_data() {

		$currencies_data = get_option( 'realhomes_currencies_data' );

		if ( ! empty( $currencies_data ) && is_array( $currencies_data ) ) {
			return $currencies_data;
		}

		return null;
	}
}

if ( ! function_exists( 'realhomes_get_currencies_rates' ) ) {
	/**
	 * Return currencies rates from database.
	 *
	 * @since  1.0.0
	 * @return array|null
	 */
	function realhomes_get_currencies_rates() {
		$currencies_rates = get_option( 'realhomes_currencies_rates' );

		if ( ! empty( $currencies_rates ) && is_array( $currencies_rates ) ) {
			return $currencies_rates;
		}

		return null;
	}
}

if ( ! function_exists( 'realhomes_switch_currency' ) ) {
	/**
	 * Convert and format given amount from base currency to current currency.
	 *
	 * @since  1.0.0
	 * @param  string $amount  Amount in digits to change currency for.
	 * @return string
	 */
	function realhomes_switch_currency( $amount ) {

		$base_currency              = realhomes_get_base_currency();
		$current_currency           = realhomes_get_current_currency();
		$converted_amount           = realhomes_convert_currency( $amount, $base_currency, $current_currency );
		$formatted_converted_amount = realhomes_format_currency( $converted_amount, $current_currency );

		return apply_filters( 'realhomes_switch_currency', $formatted_converted_amount );
	}
}

if ( ! function_exists( 'realhomes_currency_switcher_enabled' ) ) {
	/**
	 * Check if currency switcher is enabled or not.
	 *
	 * @since  1.0.0
	 * @return bool
	 */
	function realhomes_currency_switcher_enabled() {

		$rcs_settings = get_option( 'rcs_settings' );
		if ( isset( $rcs_settings['enable_currency_switcher'] ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'realhomes_convert_currency' ) ) {
	/**
	 * Convert amount from one currency to another.
	 *
	 * @since  1.0.0
	 * @param  float  $amount           An amount to change currency for.
	 * @param  string $base_currency    To use as base currency while conversion.
	 * @param  string $current_currency To use as current currency while conversion.
	 * @return int
	 */
	function realhomes_convert_currency( $amount, $base_currency, $current_currency ) {

		$currencies_rates = realhomes_get_currencies_rates();

		if ( ! is_null( $currencies_rates ) ) {
			// Convert amount into USD.
			$usd_rate   = $currencies_rates['USD'] / $currencies_rates[ $base_currency ];
			$usd_amount = $amount * $usd_rate;

			// Convert amount into current currency.
			$converted_amount = $usd_amount * $currencies_rates[ $current_currency ];

			return ceil( $converted_amount );
		}

		return $amount;
	}
}

if ( ! function_exists( 'realhomes_format_currency' ) ) {
	/**
	 * Return formated amount with currency symbol based on given currency code.
	 *
	 * @since  1.0.0
	 * @param  float  $amount          An amount to be formatted.
	 * @param  string $currency_code   Currency, in which amount has to be formatted.
	 * @param  bool   $currency_symbol Allow to show/hide currency symbol.
	 * @return string
	 */
	function realhomes_format_currency( $amount, $currency_code, $currency_symbol = true ) {

		if ( is_nan( $amount ) || ! realhomes_currency_exists( $currency_code ) ) {
			$currency_symbol = get_option( 'theme_currency_sign', '$' );
			return $currency_symbol . $amount;
		}

		$currencies_data = realhomes_get_currencies_data();
		$currency        = $currencies_data[ $currency_code ];

		$formatted_amount = number_format( $amount, 0, $currency['decimals_sep'], $currency['thousands_sep'] );
		if ( false === $currency_symbol ) {
			$result = $formatted_amount;
		} else {
			$result = 'before' === $currency['position'] ? $currency['symbol'] . $formatted_amount : $formatted_amount . $currency['symbol'];
		}

		return html_entity_decode( $result );
	}
}

if( ! function_exists( 'rcs_get_current_visitor_ip' ) ){
	/**
	 * @since 1.0.4
	 * Get current visitor's IP address properly
	 * @return string $ip_address
	 */
	function rcs_get_current_visitor_ip(){
		$ipaddress = '';
		if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}


function set_vur() {
	if( ! isset( $_COOKIE['realhomes_current_currency'] ) ){

		$expiry_period = intval( $rcs_settings[ 'switched_currency_expiry' ] );
		if ( ! $expiry_period ) {
			$expiry_period = 60 * 60;   // one hour.
		}
		$expiry = time() + $expiry_period;

		if ( $currency != null ) {
			setcookie( 'realhomes_current_currency', $currency, $expiry, COOKIEPATH, COOKIE_DOMAIN );
		}
	}
}

if ( ! function_exists( 'rcs_get_visitor_country_currency' ) ) {
	/**
	 * @since 1.0.4
	 * Get current visitor's IP address properly
	 * @return string $ip_address
	 */
	function rcs_get_visitor_country_currency() {

		$rcs_settings = get_option( 'rcs_settings' );

		if (
			isset( $rcs_settings[ 'auto_active_currency' ] )
			&& $rcs_settings[ 'auto_active_currency' ] == 'true'
		) {
			$arrContextOptions = array(
				"ssl" => array(
					"verify_peer"      => false,
					"verify_peer_name" => false,
				),
			);
			$ip = rcs_get_current_visitor_ip();
			$currency = file_get_contents( "https://ipapi.co/" . $ip . "/currency", false, stream_context_create( $arrContextOptions ) );
			if( ! empty( $currency ) && $currency != null && $currency != 'Undefined' ){
				$rcs_settings[ 'auto_active_currency_value' ] = $currency;
			} else {
				$rcs_settings[ 'auto_active_currency_value' ] = false;
			}
		} else {
			$rcs_settings[ 'auto_active_currency_value' ] = false;
		}
		update_option( 'rcs_settings', $rcs_settings );
	}
}

rcs_get_visitor_country_currency();