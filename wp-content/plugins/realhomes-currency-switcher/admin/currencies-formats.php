<?php
/**
 * Currecies formats list to set based on currenices' codes.
 *
 * @link     https://inspirythemes.com/
 * @since    1.0.0
 *
 * @package    realhomes-currency-switcher
 * @subpackage realhomes-currency-switcher/admin
 */

if ( ! function_exists( 'realhomes_format_currency_data' ) ) {
	/**
	 * Return formated currenices data based on currenices' codes.
	 *
	 * @since  1.0.0
	 * @param  string $currencies Currenices with default formats.
	 * @return array
	 */
	function realhomes_format_currency_data( $currencies ) {

		$data = $currencies;

		if ( $currencies && is_array( $currencies ) && count( $currencies ) > 100 ) :

			foreach ( $currencies as $currency_code => $currency_data ) :

				if ( ! $currency_data['symbol'] || ! isset( $currency_data['name'] ) ) {
					continue;
				}

				if ( 'AUD' === $currency_code ) {

					// Australian Dollar.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'A&#36;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'BRL' === $currency_code ) {

					// Brazilian Real.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'R&#36;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => '&nbsp;',
						'decimals_sep'  => '.',
					);

				} elseif ( 'BND' === $currency_code ) {

					// Brunei Dollar.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'B&#36;',
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'BTC' === $currency_code || 'XBT' === $currency_code ) {

					// Bitcoin.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => $currency_data['symbol'],
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'CAD' === $currency_code ) {

					// Canadian Dollar.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'C&#36;',
						'position'      => 'after',
						'decimals'      => 3,
						'thousands_sep' => '&nbsp;',
						'decimals_sep'  => ',',
					);

				} elseif ( 'CHF' === $currency_code ) {

					// Swiss Franc.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'SFr.',
						'position'      => 'after',
						'decimals'      => 3,
						'thousands_sep' => '&nbsp;',
						'decimals_sep'  => ',',
					);

				} elseif ( 'CNY' === $currency_code ) {

					// Chinese Renmimbi (Yuan).
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#165',
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'DKK' === $currency_code ) {

					// Danish Crown.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'kr.',
						'position'      => 'after',
						'decimals'      => 3,
						'thousands_sep' => '&nbsp;',
						'decimals_sep'  => ',',
					);

				} elseif ( 'EUR' === $currency_code ) {

					// Euro.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#8364;',
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'GBP' === $currency_code ) {

					// British Pound.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#163;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'JPY' === $currency_code ) {

					// Japanese Yen.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#165;',
						'position'      => 'after',
						'decimals'      => 0,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'LAK' === $currency_code ) {

					// Laos Kip.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#8365;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'HKD' === $currency_code ) {

					// Hong Kong Dollar.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'HK&#36;',
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'IDR' === $currency_code ) {

					// Indonesian Rupee.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#8377;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'MMK' === $currency_code ) {

					// Burmese Kyat.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'Ks',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'MYR' === $currency_code ) {

					// Malaysian Ringgit.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'RM',
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'MXN' === $currency_code ) {

					// Mexican Peso.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'Mex#36;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => '&nbsp;',
						'decimals_sep'  => ',',
					);

				} elseif ( 'NZD' === $currency_code ) {

					// New Zealand Dollar.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'NZ&#36;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'NOK' === $currency_code ) {

					// Norwegian Crown.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'kr',
						'position'      => 'after',
						'decimals'      => 3,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'PLN' === $currency_code ) {

					// Polish złoty.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'z&#322;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'PHP' === $currency_code ) {

					// Philippines Peso.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#8369;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'RON' === $currency_code ) {

					// Romanian Leu.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'Lei',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'RUB' === $currency_code ) {

					// Russian Ruble.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#8381;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'SAR' === $currency_code ) {

					// Saudi Ryal.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'SR',
						'position'      => 'after',
						'decimals'      => 3,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'SGD' === $currency_code ) {

					// Singapore Dollar.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'S&#36;',
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'SEK' === $currency_code ) {

					// Swedish Crown.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'kr',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => '.',
						'decimals_sep'  => ',',
					);

				} elseif ( 'THB' === $currency_code ) {

					// Thai Baht.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#3647;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'TRY' === $currency_code ) {

					// Turkish Lira.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#8378;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'TWD' === $currency_code ) {

					// Taiwan New Dollar.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'NT&#36;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'USD' === $currency_code ) {

					// US Dollar.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#36;',
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'VND' === $currency_code ) {

					// Vietnamese Dong.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#8363;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'WON' === $currency_code ) {

					// Korean Won.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => '&#8361;',
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} elseif ( 'PKR' === $currency_code ) {

					// Pakistani Rupees.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => 'Rs.',
						'position'      => 'before',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				} else {

					// All others.
					$data[ $currency_code ] = array(
						'name'          => $currency_data['name'],
						'symbol'        => $currency_data['symbol'],
						'position'      => 'after',
						'decimals'      => 2,
						'thousands_sep' => ',',
						'decimals_sep'  => '.',
					);

				}

			endforeach;

		endif;

		return (array) $data;
	}
}
