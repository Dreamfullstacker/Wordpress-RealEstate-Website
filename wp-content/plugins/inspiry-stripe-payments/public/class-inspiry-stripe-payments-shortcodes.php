<?php
/**
 * Stripe Payment Button Shortcodes.
 *
 * @since      1.0.0
 * @package    inspiry-stripe-payments
 * @subpackage inspiry-stripe-payments/public
 */

// Exit if accessed directly.
if ( ! defined( 'WPINC' ) ) {
	exit;
}

if ( ! class_exists( 'Inspiry_Stripe_Payments_Shortcodes' ) ) {
	/**
	 * Stripe Payment Button Class.
	 *
	 * The class defines stripe payment button shortcodes.
	 *
	 * @since 1.0.0
	 */
	class Inspiry_Stripe_Payments_Shortcodes {

		/**
		 * Initilization function that adds required shortcode.
		 *
		 * @since 1.0.0
		 */
		public function init() {

			add_shortcode( 'isp_button', array( $this, 'stripe_payment_button' ) );

		}

		/**
		 * Stripe payment button.
		 *
		 * @since 1.1.0
		 * @param array $atts Stripe payment button attributes.
		 */
		public function stripe_payment_button( $atts ) {

			if ( ! function_exists( 'isp_is_enabled' ) && ! isp_is_enabled() ) {
				echo '<p class="error">' . esc_html__( 'Inspiry Stripe Payments plugin is not enabled yet.', 'inspiry-stripe-payments' ) . '</p>';
				return;
			}

			$args = shortcode_atts(
				array(
					'alipay'        => '',
					'amount'        => '',
					'billing'       => '',
					'bitcoin'       => '',
					'currency'      => '',
					'desc'          => '',
					'email'         => '',
					'label'         => '',
					'remember_user' => '',
					'shipping'      => '',
				),
				$atts
			);

			$isp_settings = get_option( 'isp_settings' );

			// Set stripe publishable key.
			$publishable_key = $isp_settings['publishable_key'];

			// Set currency code.
			if ( ! empty( $args['currency'] ) ) {
				$currency_code = $args['currency'];
			} else {
				$currency_code = $isp_settings['currency_code'];
			}

			// Set amount being charged.
			if ( ! empty( $args['amount'] ) ) {
				$amount = intval( $args['amount'] ) * 100;
			} else {
				$amount = intval( $isp_settings['amount'] ) * 100;
			}

			// Set button label.
			if ( ! empty( $args['label'] ) ) {
				$button_label = $args['label'];
			} else {
				$button_label = empty( $isp_settings['button_label'] ) ? esc_html__( 'Pay with Card', 'inspiry-stripe-payments' ) : $isp_settings['button_label'];
			}

			// Transaction description.
			$desc = $args['desc'];

			// Customer email ID.
			$email = $args['email'];

			if ( isset( $_GET['payment'] ) && 'paid' === $_GET['payment'] ) {
				echo '<p class="success">' . esc_html__( 'Thank you for your payment.', 'inspiry-stripe-payments' ) . '</p>';
			} elseif ( isset( $_GET['payment'] ) && 'failed' === $_GET['payment'] ) {
				echo '<p class="error">' . esc_html__( 'Error: Payment was not charged.', 'inspiry-stripe-payments' ) . '</p>';
			} else {
				?>
				<form action="" method="POST" class="stripe-button">
				<script
						src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						data-key="<?php echo esc_attr( $publishable_key ); ?>"
						data-amount="<?php echo esc_attr( $amount ); ?>"
						data-name="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>"
						data-currency="<?php echo esc_attr( $currency_code ); ?>"
					<?php echo ( ! empty( $email ) ) ? 'data-email="' . esc_attr( $email ) . '"' : ''; ?>
						data-locale="auto"
						data-billing-address="<?php echo ( isset( $args['billing'] ) && ( 'true' === $args['billing'] ) ) ? 'true' : 'false'; ?>"
						data-shipping-address="<?php echo ( isset( $args['shipping'] ) && ( 'true' === $args['shipping'] ) ) ? 'true' : 'false'; ?>"
						data-label="<?php esc_html( $button_label ); ?>"
						data-bitcoin="<?php echo ( isset( $args['bitcoin'] ) && ( 'true' === $args['bitcoin'] ) ) ? 'true' : 'false'; ?>"
						data-alipay="<?php echo ( isset( $args['alipay'] ) && ( 'true' === $args['alipay'] ) ) ? 'true' : 'false'; ?>"
						data-allow-remember-me="<?php echo ( isset( $args['remember_user'] ) && ( 'true' === $args['remember_user'] ) ) ? 'true' : 'false'; ?>">
				</script>
				<input type="hidden" name="action" value="isp_shortcode_payment"/>
				<input type="hidden" name="amount" value="<?php echo esc_attr( $amount ); ?>"/>
				<input type="hidden" name="description" value="<?php echo esc_attr( $desc ); ?>"/>
				<input type="hidden" name="currency_code" value="<?php echo esc_attr( $currency_code ); ?>"/>
				<input type="hidden" name="isp_nonce" value="<?php echo wp_create_nonce( 'isp-nonce' ); ?>"/>
				</form>
				<?php

			}

		}

	}

}
