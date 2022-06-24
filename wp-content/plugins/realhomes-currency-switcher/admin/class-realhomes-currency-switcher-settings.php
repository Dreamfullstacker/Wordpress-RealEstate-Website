<?php
/**
 * RealHomes Currency Switcher Settings.
 *
 * This class is used to initialize the settings page of this plugin.
 *
 * @since      1.0.0
 * @package    realhomes-currency-switcher
 * @subpackage realhomes-currency-switcher/admin
 */

if ( ! class_exists( 'Realhomes_Currency_Switcher_Settings' ) ) {
	/**
	 * Realhomes_Currency_Switcher_Settings
	 *
	 * Class for RealHomes Currency Switcher Settings. It is
	 * responsible for handling the settings page of the
	 * plugin.
	 *
	 * @since 1.0.0
	 */
	class Realhomes_Currency_Switcher_Settings {

		/**
		 * Add plugin settings page menu to the dashboard settings menu.
		 *
		 * @since  1.0.0
		 */
		public function settings_page_menu() {

			add_submenu_page(
				'easy-real-estate',
				esc_html__( 'Currencies Settings', 'realhomes-currency-switcher' ),
				esc_html__( 'Currencies Settings', 'realhomes-currency-switcher' ),
				'manage_options',
				'realhomes-currencies-settings',
				array( $this, 'render_settings_page' ),
				11
			);

		}

		/**
		 * Render settings on the settings page.
		 *
		 * @since  1.0.0
		 */
		public function render_settings_page() {

			$rcs_settings = get_option( 'rcs_settings' );

			?>
			<div class="wrap">
				<h2><?php esc_html_e( 'RealHomes Currency Switcher Settings', 'realhomes-currency-switcher' ); ?></h2>
				<form method="post" action="options.php">

					<?php settings_fields( 'rcs_settings_group' ); ?>
					<table class="form-table">
						<tbody>
							<!-- Currency switcher enable disable -->
							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Currency Switcher', 'realhomes-currency-switcher' ); ?>
								</th>
								<td>
									<?php
										$enable_currency_switcher = ! empty( $rcs_settings['enable_currency_switcher'] ) ? $rcs_settings['enable_currency_switcher'] : '';
									?>
									<input id="rcs_settings[enable_currency_switcher]" name="rcs_settings[enable_currency_switcher]" type="checkbox" value="1" <?php checked( 1, $enable_currency_switcher ); ?> />
									<label class="description" for="rcs_settings[enable_currency_switcher]"><?php esc_html_e( 'Enable Currency Swithcer on frontend side.', 'realhomes-currency-switcher' ); ?></label>
								</td>
							</tr>

							<!-- App ID -->
							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'App ID*', 'realhomes-currency-switcher' ); ?>
								</th>
								<td>
									<?php
										$app_id = ! empty( $rcs_settings['app_id'] ) ? $rcs_settings['app_id'] : '';
									?>
									<input id="rcs_settings[app_id]" name="rcs_settings[app_id]" type="text" class="regular-text" value="<?php echo esc_attr( $app_id ); ?>"/>
									<p class="description"><label for="rcs_settings[app_id]"><?php echo sprintf( esc_html__( 'You can get your Open Exchange Rate App ID from %s.', 'realhomes-currency-switcher' ), '<a href="https://support.openexchangerates.org/article/121-your-app-id" target="_blank">here</a>' ); ?></label></p>
								</td>
							</tr>

							<!-- Update frequency -->
							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Update Interval', 'realhomes-currency-switcher' ); ?>
								</th>
								<td>
									<?php
										$update_frequency = isset( $rcs_settings['update_interval'] ) ? esc_attr( $rcs_settings['update_interval'] ) : 'daily';
									?>
									<select name="rcs_settings[update_interval]" id="update_interval" class="regular-text">
										<option value="hourly" <?php selected( $update_frequency, 'hourly', true ); ?>><?php esc_html_e( 'Hourly', 'realhomes-currency-switcher' ); ?></option>
										<option value="daily" <?php selected( $update_frequency, 'daily', true ); ?>><?php esc_html_e( 'Daily', 'realhomes-currency-switcher' ); ?></option>
										<option value="weekly" <?php selected( $update_frequency, 'weekly', true ); ?>><?php esc_html_e( 'Weekly', 'realhomes-currency-switcher' ); ?></option>
									</select>
									<p class="description"><label for="rcs_settings[update_interval]"><?php esc_html_e( 'Set how frequent you want to update the currency exchange rates.', 'realhomes-currency-switcher' ); ?></label></p>
								</td>
							</tr>

							<!-- Auto Active Currency -->
							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Auto Select Active Currency', 'realhomes-currency-switcher' ); ?>
								</th>
								<td>
									<?php
									$auto_active_currency = isset( $rcs_settings['auto_active_currency'] ) ? esc_attr( $rcs_settings['auto_active_currency'] ) : 'false';
									?>
									<label for="rcs-aac-true">Enable</label>
									<input type="radio" id="rcs-aac-true" <?php checked( $auto_active_currency, 'true', true ); ?> name="rcs_settings[auto_active_currency]" value="true">
									<label for="rcs-aac-false">Disable</label>
									<input type="radio" id="rcs-aac-false" <?php checked( $auto_active_currency, 'false', true ); ?> name="rcs_settings[auto_active_currency]" value="false">
									<p class="description">
										<label for="rcs_settings[auto_active_currency]"><?php esc_html_e( 'The selected base currency in the next option will not be effective if this option is enabled. Currency will be switched to the visitor native currency automatically unless visitor change it to any other currency using currency switcher.', 'realhomes-currency-switcher' ); ?></label>
									</p>
								</td>
							</tr>

							<!-- Base Currency -->
							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Base Currency', 'realhomes-currency-switcher' ); ?>
								</th>
								<td>
									<select name="rcs_settings[base_currency]" id="base_currency" class="regular-text">
										<?php
										$base_crrency = isset( $rcs_settings['base_currency'] ) ? esc_attr( $rcs_settings['base_currency'] ) : 'usd';
										$currencies   = get_option( 'realhomes_currencies_data' );
										if ( ! empty( $currencies ) && is_array( $currencies ) ) {
											$currencies = get_option( 'realhomes_currencies_data' );
											if ( ! empty( $currencies ) && is_array( $currencies ) ) {
												foreach ( $currencies as $code => $info ) {
													echo '<option value="' . esc_attr( $code ) . '" ' . selected( $base_crrency, $code, true ) . '>' . esc_html( $info['name'] ) . '</option>';
												}
											}
										} else {
											echo '<option value="USD">' . esc_html__( 'United States Dollar', 'realhomes-currency-switcher' ) . '</option>';
										}
										?>
									</select>
									<p class="description"><label for="rcs_settings[base_currency]"><?php esc_html_e( 'Price format settings of easy real estate plugin, will be overwritten by base currency’s default format.', 'realhomes-currency-switcher' ); ?></label></p>
								</td>
							</tr>

							<!-- Supported currencies by the current site -->
							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Allowed Currencies', 'realhomes-currency-switcher' ); ?>
								</th>
								<td>
									<?php
										$supported_currencies = empty( $rcs_settings['supported_currencies'] ) ? 'USD,EUR,GBP' : $rcs_settings['supported_currencies'];
									?>
									<textarea id="rcs_settings[supported_currencies]" name="rcs_settings[supported_currencies]" type="text" class="regular-text"><?php echo esc_attr( $supported_currencies ); ?></textarea>
									<p class="description"><label for="rcs_settings[supported_currencies]"><?php esc_html_e( 'Provide comma separated list of currency codes in capital letters. Maximum 5 codes allowed.', 'realhomes-currency-switcher' ); ?></label></p>
									<p class="description"><label for="rcs_settings[supported_currencies]">
									<?php
										// Translators: OpenExchangeRates Currencies List.
										echo sprintf( esc_html__( 'You can find full list of supported currencies by %s.', 'realhomes-currency-switcher' ), '<a href="https://openexchangerates.org/currencies" target="_blank">clicking here</a>' );
									?>
									</label></p>
								</td>
							</tr>

							<!-- Expiry period for switched currency -->
							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Expiry Period of Switched Currency', 'realhomes-currency-switcher' ); ?>
								</th>
								<td>
									<?php
										$switched_currency_expiry = isset( $rcs_settings['switched_currency_expiry'] ) ? esc_attr( $rcs_settings['switched_currency_expiry'] ) : 'day';
									?>
									<select name="rcs_settings[switched_currency_expiry]" id="update_interval" class="regular-text">
										<option value="3600" <?php selected( $switched_currency_expiry, '3600', true ); ?>><?php esc_html_e( 'One Hour', 'realhomes-currency-switcher' ); ?></option>
										<option value="86400" <?php selected( $switched_currency_expiry, '86400', true ); ?>><?php esc_html_e( 'One Day', 'realhomes-currency-switcher' ); ?></option>
										<option value="604800" <?php selected( $switched_currency_expiry, '604800', true ); ?>><?php esc_html_e( 'One Week', 'realhomes-currency-switcher' ); ?></option>
										<option value="2592000" <?php selected( $switched_currency_expiry, '2592000', true ); ?>><?php esc_html_e( 'One Month', 'realhomes-currency-switcher' ); ?></option>
									</select>
									<p class="description"><label for="rcs_settings[switched_currency_expiry]"><?php esc_html_e( 'This is for website visitor.', 'realhomes-currency-switcher' ); ?></label></p>
								</td>
							</tr>

							<!-- Force update currencies rates -->
							<tr valign="top">
								<th scope="row" valign="top">
									<?php esc_html_e( 'Update Currencies Rates', 'realhomes-currency-switcher' ); ?>
									<?php
									$last_update = get_option( 'realhomes_currencies_last_update' );
									if ( ! empty( $last_update ) ) {
										?>
											<span class="currencies-last-update"><?php echo '<em>Last updated on:</em>' . esc_html( $last_update ); ?></span>
										<?php
									}
									?>
								</th>
								<td>
									<input id="rcs_settings[update_currencies_rates]" name="rcs_settings[update_currencies_rates]" type="checkbox" value="1" />
									<label class="description" for="rcs_settings[update_currencies_rates]"><?php esc_html_e( 'Checking this box will immediately fetch latest currencies exchange rates on Save Options.', 'realhomes-currency-switcher' ); ?></label>
								</td>
							</tr>

						</tbody>
					</table>

					<p class="submit">
						<input type="submit" class="button-primary" value="<?php esc_html_e( 'Save Options', 'realhomes-currency-switcher' ); ?>"/>
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
			register_setting( 'rcs_settings_group', 'rcs_settings' );
		}

	}
}
