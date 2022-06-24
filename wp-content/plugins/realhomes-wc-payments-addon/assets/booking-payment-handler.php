<?php

if ( ! function_exists( 'rhwpa_booking_woo_payment_completed' ) ) {
	/**
	 * When payment is completed by the woocommerce checkout,
	 * confirm the booking, update booking payment info and delete the woocommerce product.
	 *
	 * @param int $order_id Order id that has been paid.
	 */
	function rhwpa_booking_woo_payment_completed( $order_id ) {

		$order    = wc_get_order( $order_id );
		$products = $order->get_items();

		foreach ( $products as $product ) {

			$product_id = $product['product_id'];

			$is_rh_product = intval( get_post_meta( $product_id, 'realhomes_product', true ) );
			$payment_type  = get_post_meta( $product_id, 'realhomes_payment_type', true );

			if ( $is_rh_product && 'booking' === $payment_type ) {

				// If it's only processing then complete the order and return.
				if ( $order->has_status( 'processing' ) ) {
					$order->update_status( 'completed' );
					return;
				}

				$transaction_id   = $order->get_transaction_id();
				$payment_date     = $order->get_date_created()->date( 'F j, Y, g:i a' );
				$first_name       = $order->get_billing_first_name();
				$last_name        = $order->get_billing_last_name();
				$payer_email      = $order->get_billing_email();
				$payment_amount   = $order->get_total();
				$payment_currency = $order->get_currency();
				$payment_method   = $order->get_payment_method();
				$payment_status   = $order->is_paid() ? 'Completed' : 'Pending';

				// Confirm property booking if related option is enabled.
				$booking_id = get_post_meta( $product_id, 'realhomes_booking_id', true );
				update_post_meta( $booking_id, 'rvr_payment_status', 'paid' );
				update_post_meta( $booking_id, 'rvr_booking_status', 'confirmed' );
				rvr_update_property_availability_table( $booking_id, 'confirmed' );

				// Generate invoice for the current booking.
				$invoice_args = array(
					'post_title'  => $booking_id,
					'post_type'   => 'invoice',
					'post_status' => 'publish',
				);

				$invoice_id = wp_insert_post( $invoice_args );

				$invoice_update = array(
					'ID'         => $invoice_id,
					'post_title' => esc_html__( 'Invoice:', 'realhomes-wc-payments-addon' ) . $invoice_id . '-' . $booking_id,
				);

				wp_update_post( $invoice_update );

				update_post_meta( $booking_id, 'rvr_invoice_id', $invoice_id );
				update_post_meta( $invoice_id, 'booking_id', $booking_id );
				update_post_meta( $invoice_id, 'transaction_id', $transaction_id );
				update_post_meta( $invoice_id, 'payment_date', $payment_date );
				update_post_meta( $invoice_id, 'payer_email', $payer_email );
				update_post_meta( $invoice_id, 'first_name', $first_name );
				update_post_meta( $invoice_id, 'last_name', $last_name );
				update_post_meta( $invoice_id, 'amount_currency', $payment_currency );
				update_post_meta( $invoice_id, 'payment_amount', $payment_amount );
				update_post_meta( $invoice_id, 'payment_status', $payment_status );
				update_post_meta( $invoice_id, 'payment_method', $payment_method );

				// If payment method is bank transfer then delete the product.
				if ( 'bacs' === $order->get_payment_method() ) {
					wp_delete_post( $product_id );
				}
			}
		}
	}

	add_action( 'woocommerce_order_status_completed', 'rhwpa_booking_woo_payment_completed' );
	add_action( 'woocommerce_order_status_processing', 'rhwpa_booking_woo_payment_completed' );
}

if ( ! function_exists( 'rhwpa_add_booking_product' ) ) {
	/**
	 * Add woocommerce product based on the given booking id information.
	 *
	 * @param int $booking_id Booking id that will be used to retrieve booking information.
	 */
	function rhwpa_add_booking_product( $booking_id ) {

		// Prepare current user information and property price.
		$current_user  = wp_get_current_user();
		$user_id       = get_current_user_id();
		$user_email    = $current_user->user_email;
		$booking_price = get_post_meta( $booking_id, 'rvr_total_price', true );
		$property_name = get_post_meta( $booking_id, 'rvr_property_title', true );
		$check_in      = get_post_meta( $booking_id, 'rvr_check_in', true );
		$check_out     = get_post_meta( $booking_id, 'rvr_check_out', true );

		// Add a woocommerce product.
		$product_title = sprintf( esc_html__( 'Payment for the \'%1$s\' property booking. Period: %2$s', 'realhomes-wc-payments-addon' ), esc_html( $property_name ), esc_html( $check_in ) . ' to ' . esc_html( $check_out ) );
		$product_args  = array(
			'post_content'   => '',
			'post_status'    => 'publish',
			'post_title'     => $product_title,
			'post_parent'    => '',
			'post_type'      => 'product',
			'comment_status' => 'closed',
		);

		$product_id = wp_insert_post( $product_args );

		// Update added product meta information.
		update_post_meta( $product_id, '_virtual', 'yes' );
		update_post_meta( $product_id, '_sold_individually', 'yes' );
		update_post_meta( $product_id, '_manage_stock', 'no' );
		update_post_meta( $product_id, '_featured', 'no' );
		update_post_meta( $product_id, '_stock_status', 'instock' );
		update_post_meta( $product_id, '_visibility', 'visible' );
		update_post_meta( $product_id, '_downloadable', 'no' );
		update_post_meta( $product_id, '_backorders', 'no' );
		update_post_meta( $product_id, '_price', $booking_price );
		update_post_meta( $product_id, '_product_version', '1.0.0' );
		update_post_meta( $product_id, '_wc_min_qty_product', 1 );
		update_post_meta( $product_id, '_wc_max_qty_product', 1 );

		$product_id_attributes = array(
			'types' => array(
				'name'         => 'types',
				'value'        => 'service',
				'position'     => 0,
				'is_visible'   => 1,
				'is_variation' => 1,
				'is_taxonomy'  => 1,
			),
		);
		update_post_meta( $product_id, '_product_attributes', $product_id_attributes );

		// Add product meta information related to property and current user.
		update_post_meta( $product_id, 'realhomes_product', true );
		update_post_meta( $product_id, 'realhomes_payment_type', 'booking' );
		update_post_meta( $product_id, 'realhomes_booking_id', $booking_id );
		update_post_meta( $product_id, 'realhomes_user_id', $user_id );
		update_post_meta( $product_id, 'realhomes_user_email', $user_email );

		return $product_id;
	}
}

if ( ! function_exists( 'rhwpa_booking_confirmed_notice' ) ) {
	/**
	 * Display booking confirmed notice.
	 */
	function rhwpa_booking_confirmed_notice() {
		if ( is_singular( 'property' ) && ! empty( $_GET['booking-requested'] ) && function_exists( 'wc_get_order' ) && 'object' === gettype( wc_get_order( $_GET['booking-requested'] ) ) ) {
			$received_order = wc_get_order( $_GET['booking-requested'] );
			if ( $received_order->is_paid() ) {
				?>
				<div class="success booking-notice">
					<strong><?php esc_html_e( 'Success:', 'realhomes-wc-payments-addon' ); ?></strong> <?php esc_html_e( 'Your booking has been confirmed!', 'realhomes-wc-payments-addon' ); ?>
				</div>
				<?php
			} else {
				?>
				<div class="success booking-notice">
					<strong><?php esc_html_e( 'Important:', 'realhomes-wc-payments-addon' ); ?></strong> <?php esc_html_e( 'Your booking will be confirmed as soon as we receive the booking payment!', 'realhomes-wc-payments-addon' ); ?>
				</div>
				<?php
			}
		}
	}
	add_action( 'inspiry_before_page_contents', 'rhwpa_booking_confirmed_notice' );
}
