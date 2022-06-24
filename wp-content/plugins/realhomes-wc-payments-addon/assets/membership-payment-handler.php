<?php

if ( ! function_exists( 'rhwpa_package_woo_checkout' ) ) {
	/**
	 * Membership package payment via WooCommerce Payments.
	 */
	function rhwpa_package_woo_checkout() {

		$package_id        = intval( $_POST['package_id'] );  // Get the package id from the request.
		$result['success'] = false;

		WC()->cart->empty_cart();  // Empty the cart before using it.

		$product_id = rhwpa_add_package_product( $package_id ); // Create a new WC product from the package informaiton.
		$cart_id    = WC()->cart->add_to_cart( $product_id, 1 ); // Add newly created product to the cart.

		if ( ! empty( $cart_id ) ) { // If process went successfull, then send the information in ajax response.
			$result['success']      = true;
			$result['cart_id']      = $cart_id;
			$result['checkout_url'] = wc_get_checkout_url();
		}
		echo wp_json_encode( $result );
		die();
	}
	add_action( 'wp_ajax_rhwpa_package_woo_checkout', 'rhwpa_package_woo_checkout' );
	add_action( 'wp_ajax_nopriv_rhwpa_package_woo_checkout', 'rhwpa_package_woo_checkout' );
}

if ( ! function_exists( 'rhwpa_add_package_product' ) ) {
	/**
	 * Add woocommerce product based on the given package id information.
	 *
	 * @param int $package_id Package id that will be used to retrieve package information.
	 */
	function rhwpa_add_package_product( $package_id ) {

		// Prepare current user information and package price.
		$current_user  = wp_get_current_user();
		$user_id       = get_current_user_id();
		$user_email    = $current_user->user_email;
		$package_price = get_post_meta( $package_id, 'ims_membership_price', true );

		// Set price to 0 if it's not set to support free package.
		if ( empty( $package_price ) ) {
			$package_price = 0;
		}

		// Add a woocommerce product.
		$product_title = sprintf( esc_html__( 'Payment for the \'%s\' package', 'realhomes-wc-payments-addon' ), get_the_title( $package_id ) );
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
		update_post_meta( $product_id, '_invoice_id', $package_id );
		update_post_meta( $product_id, '_backorders', 'no' );
		update_post_meta( $product_id, '_price', $package_price );
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

		// Add product meta information related to package and current user.
		update_post_meta( $product_id, 'realhomes_product', true );
		update_post_meta( $product_id, 'realhomes_payment_type', 'package' );
		update_post_meta( $product_id, 'realhomes_package_id', $package_id );
		update_post_meta( $product_id, 'realhomes_user_id', $user_id );
		update_post_meta( $product_id, 'realhomes_user_email', $user_email );

		return $product_id;
	}
}

if ( ! function_exists( 'rhwpa_package_woo_payment_completed' ) ) {
	/**
	 * When payment is completed by the woocommerce checkout,
	 * activate the package membership and delete the woocommerce product.
	 *
	 * @param int $order_id Order id that has been paid.
	 */
	function rhwpa_package_woo_payment_completed( $order_id ) {

		$order    = wc_get_order( $order_id );
		$products = $order->get_items();

		foreach ( $products as $product ) {

			$product_id = $product['product_id'];

			$is_rh_product = intval( get_post_meta( $product_id, 'realhomes_product', true ) );
			$payment_type  = get_post_meta( $product_id, 'realhomes_payment_type', true );

			if ( $is_rh_product && 'package' === $payment_type ) {

				$user_id    = get_post_meta( $product_id, 'realhomes_user_id', true );
				$package_id = get_post_meta( $product_id, 'realhomes_package_id', true );

				// Activate the package membership if payment completion hook is being fired for the first time.
				$current_membership = get_user_meta( get_current_user_id(), 'ims_current_membership', true );
				if ( $package_id !== $current_membership ) { // Note: payment completion hook fires two times by WC, that's why this check is added.
					rhwpa_activate_package_membership( $user_id, $package_id, $order );
				}

				$order->update_status( 'completed' );
				// If payment method is bank transfer then delete the product.
				if ( 'bacs' === $order->get_payment_method() ) {
					wp_delete_post( $product_id );
				}
			}
		}
	}

	add_action( 'woocommerce_order_status_completed', 'rhwpa_package_woo_payment_completed' );
	add_action( 'woocommerce_order_status_processing', 'rhwpa_package_woo_payment_completed' );
}

if ( ! function_exists( 'rhwpa_activate_package_membership' ) ) {
	/**
	 * Activate package membership for the subscriber.
	 *
	 * @param int    $user_id    Subscriber user id.
	 * @param int    $package_id Package id of which membership needs to be activated.
	 * @param object $order WooCommerce order that's completed after payment.
	 */
	function rhwpa_activate_package_membership( $user_id, $package_id, $order ) {

		$membership_methods = new IMS_Membership_Method(); // Instance oof membership methods.
		$receipt_methods    = new IMS_Receipt_Method();    // Instance of receipt methods.
		$transaction_id     = $order->get_transaction_id();

		// Generate receipt.
		$receipt_id = $receipt_methods->generate_receipt( $user_id, $package_id, 'woocommerce' );

		// Add user membership.
		$membership_methods->add_user_membership( $user_id, $package_id, 'woocommerce' );

		// Update status and related membershp due date to the receipt.
		$time_due            = $membership_methods->get_membership_due_date( $package_id, current_time( 'timestamp' ) );
		$membership_due_date = date( 'Y-m-d H:i', $time_due );

		update_post_meta( $receipt_id, 'ims_receipt_status', 'active' );
		update_post_meta( $receipt_id, 'ims_receipt_membership_due_date', $membership_due_date );

		// Update payment ID.
		if ( ! empty( $transaction_id ) ) {
			update_post_meta( $receipt_id, 'ims_receipt_payment_id', $transaction_id );
		}

		// Notify the admin and subscriber via email.
		if ( ! empty( $receipt_id ) ) {

			IMS_Email::mail_user( $user_id, $package_id, 'woocommerce' );
			IMS_Email::mail_admin( $package_id, $receipt_id, 'woocommerce' );
		}
	}
}

if ( ! function_exists( 'rhwpa_membership_subscription_confirmed_notice' ) ) {
	/**
	 * Display membership subscription confirmation notice.
	 */
	function rhwpa_membership_subscription_confirmed_notice() {

		if ( ! empty( $_GET['membership-requested'] ) && function_exists( 'wc_get_order' ) && 'object' === gettype( wc_get_order( $_GET['membership-requested'] ) ) ) {
			$received_order = wc_get_order( $_GET['membership-requested'] );
			if ( $received_order->is_paid() ) {
				?>
				<div class="dashboard-notice success">
					<h5><?php esc_html_e( 'Success', 'realhomes-wc-payments-addon' ); ?></h5>
					<p><?php esc_html_e( 'Membership package is subscribed successfully!', 'realhomes-wc-payments-addon' ); ?></p>
				</div>
				<?php
			} else {
				?>
				<div class="dashboard-notice warning">
					<h5><?php esc_html_e( 'Important', 'realhomes-wc-payments-addon' ); ?></h5>
					<p><?php esc_html_e( 'Subscription will be activated as soon as you pay the membership package payment!', 'realhomes-wc-payments-addon' ); ?></p>
				</div>
				<?php
			}
		}
	}
	add_action( 'inspiry_before_membership_page_render', 'rhwpa_membership_subscription_confirmed_notice' );
}
