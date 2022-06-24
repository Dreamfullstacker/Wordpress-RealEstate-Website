<?php
/**
 * Property WooCommerce Payments Settings.
 *
 * This class is used to initialize the settings page of individual properties payments.
 *
 * @since      1.0.0
 * @package    realhomes-wc-payments-addon
 */

if ( ! class_exists( 'Realhomes_Property_WC_Payment_Settings' ) ) {
	/**
	 * Realhomes_Property_WC_Payment_Settings
	 *
	 * Class for WooCommerce Payments Settings. It is responsible
	 * for handling the settings page of individual properites payments.
	 *
	 * @since 1.0.0
	 */
	class Realhomes_Property_WC_Payment_Settings {

		/**
		 * Add plugin settings page menu to the dashboard settings menu.
		 *
		 * @since  1.0.0
		 */
		public function settings_page_menu() {

			add_submenu_page(
				'easy-real-estate',
				esc_html__( 'Woo Payments Settings', 'realhomes-wc-payments-addon' ),
				esc_html__( 'Woo Payments Settings', 'realhomes-wc-payments-addon' ),
				'manage_options',
				'realhomes-property-wc-payment-settings',
				array( $this, 'render_settings_page' )
			);

		}

		/**
		 * Render property payment settings on its settings page.
		 *
		 * @since  1.0.0
		 */
		public function render_settings_page() {

			$rhwpa_settings = get_option( 'rhwpa_property_payment_settings' );
			?>
			<div class="wrap">
			<h2><?php esc_html_e( 'Property WooCommerce Payments Settings', 'realhomes-wc-payments-addon' ); ?></h2>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">

				<?php 
					settings_fields( 'rhwpa_property_payment_settings_group' );
					do_settings_sections( 'rhwpa_property_payment_settings_group' );
				?>

				<table class="form-table">
					<tbody>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'WooCommerce Payments', 'realhomes-wc-payments-addon' ); ?>
						</th>
						<td>
							<?php
								$enable_wc_payments = ! empty( $rhwpa_settings['enable_wc_payments'] ) ? $rhwpa_settings['enable_wc_payments'] : '';
							?>
							<input id="rhwpa_property_payment_settings[enable_wc_payments]" name="rhwpa_property_payment_settings[enable_wc_payments]" type="checkbox" value="1" <?php checked( 1, $enable_wc_payments ); ?> />
							<label for="rhwpa_property_payment_settings[enable_wc_payments]"><?php esc_html_e( 'Enable WooCommerce Payments for Submitted Property.', 'realhomes-wc-payments-addon' ); ?></label>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Currency Code*', 'realhomes-wc-payments-addon' ); ?>
						</th>
						<td>
							<?php $currency_code = get_woocommerce_currency(); ?>
							<input id="rhwpa_property_payment_settings[currency_code]" name="rhwpa_property_payment_settings[currency_code]" class="regular-text" type="text" value="<?php echo esc_attr( $currency_code ); ?>" disabled />
							<p class="description"><label for="rhwpa_property_payment_settings[currency_code]"><?php echo sprintf( esc_html__( 'Currency code is set from WooCommerce Currency Settings under General Settings tab. To configure WooCommerce Currency Settings please follow %1$sthis guide%2$s.', 'realhomes-wc-payments-addon' ), '<a href="https://docs.woocommerce.com/document/shop-currency/" target="_blank">', '<a>' ); ?></label></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Payment Amount Per Property*', 'realhomes-wc-payments-addon' ); ?>
						</th>
						<td>
							<?php $amount = ! empty( $rhwpa_settings['amount'] ) ? $rhwpa_settings['amount'] : ''; ?>
							<input id="rhwpa_property_payment_settings[amount]" name="rhwpa_property_payment_settings[amount]" class="regular-text" type="text" value="<?php echo esc_attr( $amount ); ?>"/>
							<p class="description"><label for="rhwpa_property_payment_settings[amount]"><?php esc_html_e( 'Provide the amount that you want to charge for one property. Example: 20.00', 'realhomes-wc-payments-addon' ); ?></label></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Payment Button Label', 'realhomes-wc-payments-addon' ); ?>
						</th>
						<td>
							<?php $button_label = ! empty( $rhwpa_settings['button_label'] ) ? $rhwpa_settings['button_label'] : ''; ?>
							<input id="rhwpa_property_payment_settings[button_label]" name="rhwpa_property_payment_settings[button_label]" class="regular-text" type="text" value="<?php echo esc_attr( $button_label ); ?>" placeholder="<?php esc_attr_e( 'Pay Now', 'realhomes-wc-payments-addon' ); ?>"/>
							<p class="description"><label for="rhwpa_property_payment_settings[button_label]"><?php esc_html_e( 'Default: Pay Now', 'realhomes-wc-payments-addon' ); ?></label></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Publish Submitted Property after Payment', 'realhomes-wc-payments-addon' ); ?>
						</th>
						<td>
							<?php $publish_property = isset( $rhwpa_settings['publish_property'] ) ? $rhwpa_settings['publish_property'] : '0'; ?>
							<input id="rhwpa_property_payment_settings[publish_property]" name="rhwpa_property_payment_settings[publish_property]" type="radio" value="1" <?php checked( 1, $publish_property, true ); ?> />
							<label class="description" for="rhwpa_property_payment_settings[publish_property]"><?php esc_html_e( 'Yes', 'realhomes-wc-payments-addon' ); ?></label>
							<input id="rhwpa_property_payment_settings[publish_property]" name="rhwpa_property_payment_settings[publish_property]" type="radio" value="0" <?php checked( 0, $publish_property, true ); ?> />
							<label class="description" for="rhwpa_property_payment_settings[publish_property]"><?php esc_html_e( 'No', 'realhomes-wc-payments-addon' ); ?></label>
						</td>
					</tr>
					</tbody>
				</table>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Options', 'realhomes-wc-payments-addon' ); ?>"/>
				</p>

			</form>
			<?php
		}

		/**
		 * Register property payment settings.
		 *
		 * @since  1.0.0
		 */
		public function register_settings() {
			register_setting( 'rhwpa_property_payment_settings_group', 'rhwpa_property_payment_settings' );
		}

	}

}
