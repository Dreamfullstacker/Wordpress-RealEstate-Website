<?php

if ( ! function_exists( 'rhwpa_property_payment_button' ) ) {
	/**
	 * Display individual property payment button.
	 *
	 * @param int $property_id Property ID of which payment has to be made.
	 */
	function rhwpa_property_payment_button( $property_id ) {
		$rhwpa_settings = get_option( 'rhwpa_property_payment_settings' );
		if ( empty( $rhwpa_settings['enable_wc_payments'] ) || empty( $property_id ) ) {
			return false;
		}

		if ( ! empty( $rhwpa_settings['button_label'] ) ) {
			$button_label = $rhwpa_settings['button_label'];
		} else {
			$button_label = esc_html__( 'Pay Now', 'realhomes-wc-payments-addon' );
		}
		?>
		<a class="btn btn-primary property-woo-payment" data-property-id="<?php echo esc_html( $property_id ); ?>"><?php echo esc_html( $button_label ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'rhwpa_property_woo_checkout' ) ) {
	/**
	 * Property payment via WooCommerce Payments.
	 */
	function rhwpa_property_woo_checkout() {

		$property_id       = intval( $_POST['property_id'] );  // Get the property id from the request.
		$result['success'] = false;

		WC()->cart->empty_cart();  // Empty the cart before using it.

		$product_id = rhwpa_add_property_product( $property_id ); // Create a new WC product from the property informaiton.
		$cart_id    = WC()->cart->add_to_cart( $product_id, 1 ); // Add newly created product to the cart.

		if ( ! empty( $cart_id ) ) { // If process went successfull, then send the information in ajax response.
			$result['success']      = true;
			$result['cart_id']      = $cart_id;
			$result['checkout_url'] = wc_get_checkout_url();
		}
		echo wp_json_encode( $result );
		die();
	}
	add_action( 'wp_ajax_rhwpa_property_woo_checkout', 'rhwpa_property_woo_checkout' );
	add_action( 'wp_ajax_nopriv_rhwpa_property_woo_checkout', 'rhwpa_property_woo_checkout' );
}

if ( ! function_exists( 'rhwpa_add_property_product' ) ) {
	/**
	 * Add woocommerce product based on the given property id information.
	 *
	 * @param int $property_id Property id that will be used to retrieve property information.
	 */
	function rhwpa_add_property_product( $property_id ) {

		// Prepare current user information and property price.
		$current_user   = wp_get_current_user();
		$user_id        = get_current_user_id();
		$user_email     = $current_user->user_email;
		$rhwpa_settings = get_option( 'rhwpa_property_payment_settings' );

		if ( ! empty( $rhwpa_settings['amount'] ) ) {
			$property_price = $rhwpa_settings['amount'];
		}

		// Add a woocommerce product.
		$product_title = sprintf( esc_html__( 'Payment for the \'%s\' property', 'realhomes-wc-payments-addon' ), get_the_title( $property_id ) );
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
		update_post_meta( $product_id, '_invoice_id', $property_id );
		update_post_meta( $product_id, '_backorders', 'no' );
		update_post_meta( $product_id, '_price', $property_price );
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
		update_post_meta( $product_id, 'realhomes_payment_type', 'property' );
		update_post_meta( $product_id, 'realhomes_property_id', $property_id );
		update_post_meta( $product_id, 'realhomes_user_id', $user_id );
		update_post_meta( $product_id, 'realhomes_user_email', $user_email );

		return $product_id;
	}
}

if ( ! function_exists( 'rhwpa_property_woo_payment_completed' ) ) {
	/**
	 * When payment is completed by the woocommerce checkout,
	 * publish the property, update property payment info and delete the woocommerce product.
	 *
	 * @param int $order_id Order id that has been paid.
	 */
	function rhwpa_property_woo_payment_completed( $order_id ) {

		$order    = wc_get_order( $order_id );
		$products = $order->get_items();

		foreach ( $products as $product ) {

			$product_id = $product['product_id'];

			$is_rh_product = intval( get_post_meta( $product_id, 'realhomes_product', true ) );
			$payment_type  = get_post_meta( $product_id, 'realhomes_payment_type', true );

			if ( $is_rh_product && 'property' === $payment_type ) {

				$transaction_id   = $order->get_transaction_id();
				$payment_date     = $order->get_date_created()->date( 'F j, Y, g:i a' );
				$first_name       = $order->get_billing_first_name();
				$last_name        = $order->get_billing_last_name();
				$payer_email      = $order->get_billing_email();
				$payment_amount   = $order->get_total();
				$payment_currency = $order->get_currency();
				$payment_status   = 'Completed';

				$property_id = get_post_meta( $product_id, 'realhomes_property_id', true );

				// Update property payment information.
				update_post_meta( $property_id, 'txn_id', $transaction_id );
				update_post_meta( $property_id, 'payment_date', $payment_date );
				update_post_meta( $property_id, 'payer_email', $payer_email );
				update_post_meta( $property_id, 'first_name', $first_name );
				update_post_meta( $property_id, 'last_name', $last_name );
				update_post_meta( $property_id, 'mc_currency', $payment_currency );
				update_post_meta( $property_id, 'payment_gross', $payment_amount );
				update_post_meta( $property_id, 'payment_status', $payment_status );

				// Publish property if related option is enabled.
				$rhwpa_settings = get_option( 'rhwpa_property_payment_settings' );
				if ( ! empty( $rhwpa_settings['publish_property'] ) ) {
					$property_args = array(
						'ID'          => $property_id,
						'post_status' => 'publish',
					);
					wp_update_post( $property_args );
				}

				$order->update_status( 'completed' );

				// If payment method is bank transfer then delete the product.
				if ( 'bacs' === $order->get_payment_method() ) {
					wp_delete_post( $product_id );
				}
			}
		}
	}

	add_action( 'woocommerce_order_status_completed', 'rhwpa_property_woo_payment_completed' );
	add_action( 'woocommerce_order_status_processing', 'rhwpa_property_woo_payment_completed' );
}

if ( ! function_exists( 'rhwpa_property_publish_confirmed_notice' ) ) {
	/**
	 * Display property publish confirmation notice.
	 */
	function rhwpa_property_publish_confirmed_notice() {

		if ( ! empty( $_GET['publish-requested'] ) && function_exists( 'wc_get_order' ) && 'object' === gettype( wc_get_order( $_GET['publish-requested'] ) ) ) {
			$received_order = wc_get_order( $_GET['publish-requested'] );
			if ( $received_order->is_paid() ) {
				?>
				<div class="dashboard-notice success">
					<h5><?php esc_html_e( 'Success', 'realhomes-wc-payments-addon' ); ?></h5>
					<p><?php esc_html_e( 'Your property has been published!', 'realhomes-wc-payments-addon' ); ?></p>
				</div>
				<?php
			} else {
				?>
				<div class="dashboard-notice warning">
					<h5><?php esc_html_e( 'Important', 'realhomes-wc-payments-addon' ); ?></h5>
					<p><?php esc_html_e( 'Your property will be published as soon as property payment is received!', 'realhomes-wc-payments-addon' ); ?></p>
				</div>
				<?php
			}
		}
	}
	add_action( 'inspiry_before_my_properties_page_render', 'rhwpa_property_publish_confirmed_notice' );
}
