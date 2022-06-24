<?php

// Remove order notes title.
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );

if ( ! function_exists( 'rhwpa_set_checkout_fields_values' ) ) {
	/**
	 * Pre-fill the checkout fields values from the related booking information.
	 * @param $input
	 * @param $key
	 *
	 * @return string
	 */
	function rhwpa_set_checkout_fields_values( $input, $key ) {

		$first_name = isset( $_GET['fname'] ) ? sanitize_text_field( $_GET['fname'] ) : '';
		$last_name  = isset( $_GET['lname'] ) ? sanitize_text_field( $_GET['lname'] ) : '';
		$number     = isset( $_GET['num'] ) ? sanitize_text_field( $_GET['num'] ) : '';
		$email      = isset( $_GET['email'] ) ? sanitize_text_field( $_GET['email'] ) : '';

		switch ( $key ) :
			case 'billing_first_name':
			case 'shipping_first_name':
				return $first_name;
				break;

			case 'billing_last_name':
			case 'shipping_last_name':
				return $last_name;
				break;

			case 'billing_email':
				return $email;
				break;

			case 'billing_phone':
				return $number;
				break;

		endswitch;

	}

	add_filter( 'woocommerce_checkout_get_value', 'rhwpa_set_checkout_fields_values', 10, 2 );
}

if ( ! function_exists( 'rhwpa_remove_checkout_fields' ) ) {
	/**
	 * Remove unncessary checkout fields.
	 *
	 * @param  array $fields Default woocommerce checkout fields.
	 * @return array $fields Filtered woocommerce checkout fields.
	 */
	function rhwpa_remove_checkout_fields( $fields ) {

		unset( $fields['billing']['billing_company'] );
		unset( $fields['billing']['billing_address_1'] );
		unset( $fields['billing']['billing_address_2'] );
		unset( $fields['billing']['billing_city'] );
		unset( $fields['billing']['billing_postcode'] );
		unset( $fields['billing']['billing_country'] );
		unset( $fields['billing']['billing_state'] );
		unset( $fields['order']['order_comments'] );
		unset( $fields['account']['account_username'] );
		unset( $fields['account']['account_password'] );
		unset( $fields['account']['account_password-2'] );

		return $fields;
	}
	add_filter( 'woocommerce_checkout_fields', 'rhwpa_remove_checkout_fields' );
}

if ( ! function_exists( 'rhwpa_update_billing_titles' ) ) {
	/**
	 * Update billing titles to payment addon relevant.
	 */
	function rhwpa_update_billing_titles( $translated_text, $text, $domain ) {

		switch ( $translated_text ) {
			case 'Billing details':
				$translated_text = esc_html__( 'Contact information', 'realhomes-wc-payments-addon' );
				break;
			case 'Billing address':
				$translated_text = esc_html__( 'Contact information', 'realhomes-wc-payments-addon' );
				break;
		}

		return $translated_text;
	}
	add_filter( 'gettext', 'rhwpa_update_billing_titles', 20, 3 );
}

if ( ! function_exists( 'rhwpa_redirect_after_checkout' ) ) {
	/**
	 * Redirect user to the "My Membership" page after checkout.
	 */
	function rhwpa_redirect_after_checkout() {
		global $wp;

		if ( is_checkout() && ! empty( $wp->query_vars['order-received'] ) ) {

			$order_id     = absint( $wp->query_vars['order-received'] ); // Get current order ID.
			$order        = wc_get_order( $order_id ); // Get the current order.
			$products     = $order->get_items(); // Get current order items.
			$redirect_url = '';

			foreach ( $products as $product ) {

				$product_id = $product['product_id'];

				$is_rh_product = intval( get_post_meta( $product_id, 'realhomes_product', true ) );
				$payment_type  = get_post_meta( $product_id, 'realhomes_payment_type', true );

				if ( $is_rh_product ) {
					if ( 'package' === $payment_type ) {
						$membership_url = realhomes_get_dashboard_page_url( 'membership' );
						$redirect_url   = add_query_arg( 'membership-requested', $order_id, $membership_url );
					} elseif ( 'property' === $payment_type ) {
						$properties_url = realhomes_get_dashboard_page_url( 'properties' );
						$redirect_url   = add_query_arg( 'publish-requested', $order_id, $properties_url );
					} elseif ( 'booking' === $payment_type ) {
						$booking_id   = get_post_meta( $product_id, 'realhomes_booking_id', true );
						$property_url = get_post_meta( $booking_id, 'rvr_property_url', true );
						$redirect_url = add_query_arg( 'booking-requested', $order_id, $property_url );
					}
				}
			}

			if ( ! empty( $redirect_url ) ) {
				// If payment method is not bank transfer then delete the product.
				if ( 'bacs' !== $order->get_payment_method() ) {
					wp_delete_post( $product_id );
				}
				wp_safe_redirect( $redirect_url ); // Redirect to appropriate page.
			}
		}
	}
	add_action( 'template_redirect', 'rhwpa_redirect_after_checkout' );
}
