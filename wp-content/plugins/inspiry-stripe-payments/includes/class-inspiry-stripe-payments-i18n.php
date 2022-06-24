<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.1.0
 * @package    inspiry-stripe-payments
 * @subpackage inspiry-stripe-payments/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since 1.1.0
 */
class Inspiry_Stripe_Payments_i18n { // phpcs:ignore

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.1.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'inspiry-stripe-payments',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
