<?php
/**
 * Inspiry Stripe Payments Settings.
 *
 * This class is used to initialize the settings page of this plugin.
 *
 * @since      1.1.0
 * @package    inspiry-stripe-payments
 * @subpackage inspiry-stripe-payments/admin
 */

if ( ! class_exists( 'Inspiry_Stripe_Payments_Settings' ) ) {
	/**
	 * Inspiry_Stripe_Payments_Settings
	 *
	 * Class for Inspiry Stripe Payments Settings. It is
	 * responsible for handling the settings page of the
	 * plugin.
	 *
	 * @since 1.1.0
	 */
	class Inspiry_Stripe_Payments_Settings {

		/**
		 * Add plugin settings page menu to the dashboard settings menu.
		 *
		 * @since  1.1.0
		 */
		public function settings_page_menu() {

			add_submenu_page(
				'easy-real-estate',
				esc_html__( 'Stripe Settings', 'inspiry-stripe-payments' ),
				esc_html__( 'Stripe Settings', 'inspiry-stripe-payments' ),
				'manage_options',
				'inspiry-stripe-payments-settings',
				array( $this, 'render_settings_page' )
			);

		}

		/**
		 * Render settings on the settings page.
		 *
		 * @since  1.1.0
		 */
		public function render_settings_page() {

			$isp_settings = get_option( 'isp_settings' );
			?>
			<div class="wrap">
			<h2><?php esc_html_e( 'RealHomes Stripe Payments Settings', 'inspiry-stripe-payments' ); ?></h2>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">

				<?php settings_fields( 'isp_settings_group' ); ?>

				<table class="form-table">
					<tbody>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Stripe Payments', 'inspiry-stripe-payments' ); ?>
						</th>
						<td>
							<?php
								$enable_stripe = ! empty( $isp_settings['enable_stripe'] ) ? $isp_settings['enable_stripe'] : '';
							?>
							<input id="isp_settings[enable_stripe]" name="isp_settings[enable_stripe]" type="checkbox" value="1" <?php checked( 1, $enable_stripe ); ?> />
							<label for="isp_settings[enable_stripe]"><?php esc_html_e( 'Enable Stripe Payments for Submitted Property.', 'inspiry-stripe-payments' ); ?></label>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Publishable Key*', 'inspiry-stripe-payments' ); ?>
						</th>
						<td>
							<?php $publishable_key = ! empty( $isp_settings['publishable_key'] ) ? $isp_settings['publishable_key'] : ''; ?>
							<input id="isp_settings[publishable_key]" name="isp_settings[publishable_key]" type="text" class="regular-text" value="<?php echo esc_attr( $publishable_key ); ?>"/>
							<p class="description"><label for="isp_settings[publishable_key]"><?php esc_html_e( 'Paste your account publishable key here.', 'inspiry-stripe-payments' ); ?></label></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Secret Key*', 'inspiry-stripe-payments' ); ?>
						</th>
						<td>
							<?php $secret_key = ! empty( $isp_settings['secret_key'] ) ? $isp_settings['secret_key'] : ''; ?>
							<input id="isp_settings[secret_key]" name="isp_settings[secret_key]" type="text" class="regular-text" value="<?php echo esc_attr( $secret_key ); ?>"/>
							<p class="description"><label for="isp_settings[secret_key]"><?php esc_html_e( 'Paste your account secret key here.', 'inspiry-stripe-payments' ); ?></label></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Currency Code*', 'inspiry-stripe-payments' ); ?>
						</th>
						<td>
							<?php $currency_code = ! empty( $isp_settings['currency_code'] ) ? $isp_settings['currency_code'] : ''; ?>
							<input id="isp_settings[currency_code]" name="isp_settings[currency_code]" class="regular-text" type="text" value="<?php echo esc_attr( $currency_code ); ?>"/>
							<p class="description"><label for="isp_settings[currency_code]"><?php esc_html_e( 'Provide currency code that you want to use. Example: USD', 'inspiry-stripe-payments' ); ?></label></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Payment Amount Per Property*', 'inspiry-stripe-payments' ); ?>
						</th>
						<td>
							<?php $amount = ! empty( $isp_settings['amount'] ) ? $isp_settings['amount'] : ''; ?>
							<input id="isp_settings[amount]" name="isp_settings[amount]" class="regular-text" type="text" value="<?php echo esc_attr( $amount ); ?>"/>
							<p class="description"><label for="isp_settings[amount]"><?php esc_html_e( 'Provide the amount that you want to charge for one property. Example: 20.00', 'inspiry-stripe-payments' ); ?></label></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Payment Button Label', 'inspiry-stripe-payments' ); ?>
						</th>
						<td>
							<?php $button_label = ! empty( $isp_settings['button_label'] ) ? $isp_settings['button_label'] : ''; ?>
							<input id="isp_settings[button_label]" name="isp_settings[button_label]" class="regular-text" type="text" value="<?php echo esc_attr( $button_label ); ?>" placeholder="<?php esc_attr_e( 'Pay with Card', 'inspiry-stripe-payments' ); ?>"/>
							<p class="description"><label for="isp_settings[button_label]"><?php esc_html_e( 'Default: Pay with Card', 'inspiry-stripe-payments' ); ?></label></p>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row" valign="top">
							<?php esc_html_e( 'Publish Submitted Property after Payment', 'inspiry-stripe-payments' ); ?>
						</th>
						<td>
							<?php $publish_property = isset( $isp_settings['publish_property'] ) ? $isp_settings['publish_property'] : '0'; ?>
							<input id="isp_settings[publish_property]" name="isp_settings[publish_property]" type="radio" value="1" <?php checked( 1, $publish_property, true ); ?> />
							<label class="description" for="isp_settings[publish_property]"><?php esc_html_e( 'Yes', 'inspiry-stripe-payments' ); ?></label>
							<input id="isp_settings[publish_property]" name="isp_settings[publish_property]" type="radio" value="0" <?php checked( 0, $publish_property, true ); ?> />
							<label class="description" for="isp_settings[publish_property]"><?php esc_html_e( 'No', 'inspiry-stripe-payments' ); ?></label>
						</td>
					</tr>
					</tbody>
				</table>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Options', 'inspiry-stripe-payments' ); ?>"/>
				</p>

			</form>
			<?php
		}

		/**
		 * Register settings for the plugin.
		 *
		 * @since  1.1.0
		 */
		public function register_settings() {
			register_setting( 'isp_settings_group', 'isp_settings' );
		}

	}

}
