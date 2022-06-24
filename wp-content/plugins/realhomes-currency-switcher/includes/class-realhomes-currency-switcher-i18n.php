<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://inspirythemes.com/
 * @since      1.0.0
 *
 * @package    Realhomes_Currency_Switcher
 * @subpackage Realhomes_Currency_Switcher/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Realhomes_Currency_Switcher
 * @subpackage Realhomes_Currency_Switcher/includes
 * @author     Fahid Javid <fahidjavid@gmail.com>
 */
class Realhomes_Currency_Switcher_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'realhomes-currency-switcher',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
