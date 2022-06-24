<?php
/**
 * Price related functions.
 *
 * @link     https://realhomes.io/
 * @since    1.0.0
 *
 * @package    easy-real-estate
 * @subpackage easy-real-estate/includes
 */
if ( ! function_exists( 'ere_format_amount' ) ) {
	/**
	 * Return given amount in a configured format.
	 *
	 * @since  1.0.0
	 * @param  string $amount An amount that has to be formatted.
	 * @return string
	 */
	function ere_format_amount( $amount ) {

		// Return if amount is empty or not a number.
		if ( empty( $amount ) || is_nan( $amount ) ) {
			return '';
		}

		// If RealHomes Currency Switcher plugin is installed and current currency cookie is set.
		if ( function_exists( 'realhomes_currency_switcher_enabled' ) && realhomes_currency_switcher_enabled() ) {
			$formatted_converted_price = realhomes_switch_currency( $amount );
			return apply_filters( 'inspiry_property_converted_price', $formatted_converted_price, $amount );
		} else {
			$currency_sign       = ere_get_currency_sign();
			$decimals            = intval( get_option( 'theme_decimals', '0' ) );
			$decimal_point       = get_option( 'theme_dec_point', '.' );
			$thousands_separator = get_option( 'theme_thousands_sep', ',' );
			$currency_position   = get_option( 'theme_currency_position', 'before' );
			$formatted_price     = number_format( $amount, $decimals, $decimal_point, $thousands_separator );
			$formatted_price     = apply_filters( 'inspiry_property_price', $formatted_price, $amount );
			return ( 'after' == $currency_position ) ? $formatted_price . $currency_sign : $currency_sign . $formatted_price ;
		}
	}
}

if ( ! function_exists( 'ere_get_currency_sign' ) ) {
	/**
	 * Get Currency
	 *
	 * @return string
	 */
	function ere_get_currency_sign() {
		return apply_filters( 'inspiry_currency_sign', get_option( 'theme_currency_sign', esc_html__( '$', 'easy-real-estate' ) ) );
	}
}

if ( ! function_exists( 'ere_no_price_text' ) ) {
	/**
	 * Returns text to display in case of empty price
	 *
	 * @return string
	 */
	function ere_no_price_text() {
		return apply_filters( 'inspiry_no_price_text', get_option( 'theme_no_price_text', esc_html__( 'Price On Call', 'easy-real-estate' ) ) );
	}
}

if ( ! function_exists( 'ere_property_sale_price' ) ) {
	/**
	 * Returns property current and old price if not empty otherwise current price.
	 *
	 * @since  0.6.0
	 *
	 * @param  string $current_price current price.
	 * @param  string $old_price Old price.
	 *
	 * @return string
	 */
	function ere_property_sale_price( $current_price, $old_price ) {

		if ( ! empty( $current_price ) && ! empty( $old_price ) ) {
			return sprintf( '<span class="property-price-wrapper"><ins class="property-current-price">%s</ins> <del class="property-old-price">%s</del></span>', $current_price, $old_price );
		}

		return $current_price;
	}
}

if ( ! function_exists( 'ere_get_property_old_price' ) ) {
	/**
	 * Returns property old price in configured format.
	 *
	 * @since  0.6.0
	 *
	 * @param int $property_id Property ID to get old price for.
	 *
	 * @return string
	 */
	function ere_get_property_old_price( $property_id = 0 ) {

		// Set property ID if it's not given.
		if ( empty( $property_id ) ) {
			$property_id = get_the_ID();
		}

		// Get property old price.
		$amount = floatval( get_post_meta( $property_id, 'REAL_HOMES_property_old_price', true ) );

		return ere_format_amount( $amount );
	}
}

if ( ! function_exists( 'ere_get_property_price' ) ) {
	/**
	 * Returns property price in configured format.
	 *
	 * @param int $property_id Property ID to get price for.
	 * @param bool $show_old_price
	 * @param bool $markup Property price with html
	 *
	 * @return string
	 */
	function ere_get_property_price($property_id = 0, $show_old_price = false, $markup = false){

		// Set property ID if it's not given.
		if ( empty( $property_id ) ) {
			$property_id = get_the_ID();
		}

		// Get property price.
		$amount = floatval( get_post_meta( $property_id, 'REAL_HOMES_property_price', true ) );

		// Return no price text if price is empty.
		if ( empty( $amount ) || is_nan( $amount ) ) {
			return ere_no_price_text();
		}

		$price = ere_format_amount( $amount );

		/**
		 * Filter condition to show property current and old price for all or specific properties.
		 *
		 * @since 0.6.0
		 *
		 * @param bool $show_old_price Current boolean. False by default.
		 * @param int $property_id Current property id.
		 */
		if ( true === apply_filters( 'ere_show_properties_old_price', $show_old_price, $property_id ) ) {
			$price = ere_property_sale_price( $price, ere_get_property_old_price() );
		}

		// Get price prefix & postfix.
		$price_prefix  = get_post_meta( $property_id, 'REAL_HOMES_property_price_prefix', true );
		$price_postfix = get_post_meta( $property_id, 'REAL_HOMES_property_price_postfix', true );

        if (true == $markup) {
            $price_markup = '';
            if (!empty($price_prefix)) {
                $price_markup .= '<span class="ere-price-prefix">' . $price_prefix . '</span> ';
            }
            $price_markup .= '<span class="ere-price-display">' . $price . '</span>';
            if (!empty($price_postfix)) {
                $price_markup .= ' <span class="ere-price-slash">/</span> <span class="ere-price-postfix">' . $price_postfix . '</span>';
            }
            return $price_markup;
        }


		return $price_prefix . ' ' . $price . ' ' . $price_postfix;
	}
}

if ( ! function_exists( 'ere_get_property_price_plain' ) ) {
	/**
	 * Returns property price in configured format without prefix and postfix.
	 *
	 * @param int $property_id Property ID to get price for.
	 * @param bool $show_old_price
	 *
	 * @return string
	 */
	function ere_get_property_price_plain( $property_id = 0, $show_old_price = false ) {

		// Set property ID if it's not given.
		if ( empty( $property_id ) ) {
			$property_id = get_the_ID();
		}

		// Get property price.
		$amount = floatval( get_post_meta( $property_id, 'REAL_HOMES_property_price', true ) );

		// Return no price text if price is empty.
		if ( empty( $amount ) || is_nan( $amount ) ) {
			return ere_no_price_text();
		}

		$price = ere_format_amount( $amount );

		/**
		 * Filter condition to show property current and old price for all or specific properties.
		 *
		 * @since 0.6.0
		 *
		 * @param bool $show_old_price Current boolean. False by default.
		 * @param int $property_id Current property id.
		 */
		if ( true === apply_filters( 'ere_show_properties_old_price', $show_old_price, $property_id ) ) {
			$price = ere_property_sale_price( $price, ere_get_property_old_price() );
		}

		return $price;
	}
}

if ( ! function_exists( 'ere_property_price' ) ) {
	/**
	 * Output property price.
	 *
	 * @param int $property_id
	 * @param bool $show_old_price
	 */
	function ere_property_price( $property_id = 0, $show_old_price = false , $markup = false ) {
		echo ere_get_property_price( $property_id, $show_old_price, $markup );
	}
}

if ( ! function_exists( 'ere_get_property_floor_price' ) ) {
	/**
	 * Returns floor price in configured format
	 *
	 * @param  array $floor_plan An array of floor plan information.
	 * @return string
	 */
	function ere_get_property_floor_price( $floor_plan ) {

		// Find floor plan price.
		$amount = doubleval( $floor_plan['inspiry_floor_plan_price'] );

		// Return no price text if price is empty.
		if ( empty( $amount ) || is_nan( $amount ) ) {
			return ere_no_price_text();
		}

		$price = ere_format_amount( $amount );

		// Retrieve floor plan price postfix.
		$price_postfix = isset( $floor_plan['inspiry_floor_plan_price_postfix'] ) ? esc_html( $floor_plan['inspiry_floor_plan_price_postfix'] ) : '';
		$price_markup  = '<span class="floor-price-value">' . $price . '</span> ' . $price_postfix;

		return $price_markup;
	}
}

if ( ! function_exists( 'ere_property_floor_price' ) ) {
	/**
	 * Display floor plan price.
	 *
	 * @param  array $floor_plan An array of floor plan information.
	 * @return void
	 */
	function ere_property_floor_price( $floor_plan ) {
		echo ere_get_property_floor_price( $floor_plan );
	}
}