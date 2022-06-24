<?php
/**
 * RealHomes PayPal Payments Settings.
 *
 * This class is used to initialize the settings page of this plugin.
 *
 * @since    1.0.0
 * @package  realhomes-paypal-payments
 */

if ( ! class_exists( 'Realhomes_Paypal_Payments_Settings' ) ) {
	/**
	 * Realhomes_Paypal_Payments_Settings
	 *
	 * Class for RealHomes PayPal Payments Settings. It is
	 * responsible for handling the settings page of the
	 * plugin.
	 *
	 * @since 1.0.0
	 */
	class Realhomes_Paypal_Payments_Settings {

		/**
		 * Add plugin settings page menu to the dashboard settings menu.
		 *
		 * @since  1.0.0
		 */
		public function settings_page_menu() {

			add_submenu_page(
				'easy-real-estate',
				esc_html__( 'PayPal Settings', 'realhomes-paypal-payments' ),
				esc_html__( 'PayPal Settings', 'realhomes-paypal-payments' ),
				'manage_options',
				'realhomes-paypal-settings',
				array( $this, 'render_settings_page' )
			);

		}

		/**
		 * Render settings on the settings page.
		 *
		 * @since  1.0.0
		 */
		public function render_settings_page() {

			$rpp_settings = get_option( 'rpp_settings' );

			?>
			<div class="wrap">
				<h2><?php esc_html_e( 'RealHomes PayPal Payments Settings', 'realhomes-paypal-payments' ); ?></h2>
				<form method="post" action="options.php">

					<?php settings_fields( 'rpp_settings_group' ); ?>
					<table class="form-table">
						<tbody>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'PayPal Payments', 'realhomes-paypal-payments' ); ?>
								</th>
								<td>
									<?php
										$enable_paypal = ! empty( $rpp_settings['enable_paypal'] ) ? $rpp_settings['enable_paypal'] : '';
									?>
									<input id="rpp_settings[enable_paypal]" name="rpp_settings[enable_paypal]" type="checkbox" value="1" <?php checked( 1, $enable_paypal ); ?> />
									<label class="description" for="rpp_settings[enable_paypal]"><?php esc_html_e( 'Enable PayPal Payments for Submitted Property.', 'realhomes-paypal-payments' ); ?></label>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Client ID*', 'realhomes-paypal-payments' ); ?>
								</th>
								<td>
									<?php $client_id = ! empty( $rpp_settings['client_id'] ) ? $rpp_settings['client_id'] : ''; ?>
									<input id="rpp_settings[client_id]" name="rpp_settings[client_id]" type="text" class="regular-text" value="<?php echo esc_attr( $client_id ); ?>"/>
									<p class="description"><label for="rpp_settings[client_id]"><?php esc_html_e( 'Paste your application Client ID here.', 'realhomes-paypal-payments' ); ?></label></p>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Client Secret*', 'realhomes-paypal-payments' ); ?>
								</th>
								<td>
									<?php $secret_id = ! empty( $rpp_settings['secret_id'] ) ? $rpp_settings['secret_id'] : ''; ?>
									<input id="rpp_settings[secret_id]" name="rpp_settings[secret_id]" type="text" class="regular-text" value="<?php echo esc_attr( $secret_id ); ?>"/>
									<p class="description"><label for="rpp_settings[secret_id]"><?php esc_html_e( 'Paste your application Secret ID here.', 'realhomes-paypal-payments' ); ?></label></p>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Payment Button Label', 'realhomes-paypal-payments' ); ?>
								</th>
								<td>
									<?php $button_label = ! empty( $rpp_settings['button_label'] ) ? $rpp_settings['button_label'] : ''; ?>
									<input id="rpp_settings[button_label]" name="rpp_settings[button_label]" class="regular-text" type="text" value="<?php echo esc_attr( $button_label ); ?>" placeholder="<?php esc_html_e( 'Pay with PayPal', 'realhomes-paypal-payments' ); ?>"/>
									<p class="description"><label for="rpp_settings[button_label]"><?php esc_html_e( 'Default: Pay with PayPal', 'realhomes-paypal-payments' ); ?></label></p>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Currency Code*', 'realhomes-paypal-payments' ); ?>
								</th>
								<td>
									<?php $currency_code = ! empty( $rpp_settings['currency_code'] ) ? $rpp_settings['currency_code'] : ''; ?>
									<input id="rpp_settings[currency_code]" name="rpp_settings[currency_code]" class="regular-text" type="text" value="<?php echo esc_attr( $currency_code ); ?>"/>
									<p class="description"><label for="rpp_settings[currency_code]"><?php esc_html_e( 'Provide currency code that you want to use. Example: USD', 'realhomes-paypal-payments' ); ?></label></p>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Payment Amount Per Property*', 'realhomes-paypal-payments' ); ?>
								</th>
								<td>
									<?php $payment_amount = ! empty( $rpp_settings['payment_amount'] ) ? $rpp_settings['payment_amount'] : ''; ?>
									<input id="rpp_settings[payment_amount]" name="rpp_settings[payment_amount]" type="text" class="regular-text" value="<?php echo esc_attr( $payment_amount ); ?>"/>
									<p class="description"><label for="rpp_settings[payment_amount]"><?php esc_html_e( 'Provide the amount that you want to charge for one property. Example: 20.00', 'realhomes-paypal-payments' ); ?></label></p>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Publish Submitted Property after Payment', 'realhomes-paypal-payments' ); ?>
								</th>
								<td>
									<?php $publish_property = ! empty( $rpp_settings['publish_property'] ) ? $rpp_settings['publish_property'] : ''; ?>
									<input id="rpp_settings[publish_property_yes]" name="rpp_settings[publish_property]" type="radio" value="1" <?php checked( 1, $publish_property, true ); ?> />
									<label class="description" for="rpp_settings[publish_property_yes]"><?php esc_html_e( 'Yes', 'realhomes-paypal-payments' ); ?></label>
									<input id="rpp_settings[publish_property_no]" name="rpp_settings[publish_property]" type="radio" value="0" <?php checked( 0, $publish_property, true ); ?> />
									<label for="rpp_settings[publish_property_no]"><?php esc_html_e( 'No', 'realhomes-paypal-payments' ); ?></label>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Redirect Page*', 'realhomes-paypal-payments' ); ?>
								</th>
								<td>
									<?php $redirect_page_url = ! empty( $rpp_settings['redirect_page_url'] ) ? $rpp_settings['redirect_page_url'] : ''; ?>
									<input id="rpp_settings[redirect_page_url]" name="rpp_settings[redirect_page_url]" type="text" class="regular-text" value="<?php echo esc_url( $redirect_page_url ); ?>" placeholder="<?php echo esc_url( get_site_url() ); ?>"/>
									<p class="description"><label for="rpp_settings[redirect_page_url]"><?php esc_html_e( 'Provide the page URL on which you want to redirect the user after successfull payment approval.', 'realhomes-paypal-payments' ); ?></label></p>
									<p class="description"><label for="rpp_settings[redirect_page_url]"><?php esc_html_e( 'Recommended: "My Properties" page URL.', 'realhomes-paypal-payments' ); ?></label></p>
								</td>
							</tr>

						</tbody>
					</table>

					<p class="submit">
						<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Options', 'realhomes-paypal-payments' ); ?>"/>
					</p>

				</form>
			</div>
			<?php
		}

		/**
		 * Register settings for the plugin.
		 *
		 * @since  1.0.0
		 */
		public function register_settings() {
			register_setting( 'rpp_settings_group', 'rpp_settings' );
		}

	}
}
