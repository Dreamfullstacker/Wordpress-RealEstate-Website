<?php
/**
 * Plugin Name:       RealHomes PayPal Payments
 * Plugin URI:        https://themeforest.net/item/real-homes-wordpress-real-estate-theme/5373914
 * Description:       Provides PayPal functionality for individual property payments.
 * Version:           1.0.2
 * Author:            InspiryThemes
 * Author URI:        https://inspirythemes.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       realhomes-paypal-payments
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Currently plugin version.
define( 'REALHOMES_PAYPAL_PAYMENTS_VERSION', '1.0.2' );

// Plugin unique identifire.
define( 'REALHOMES_PAYPAL_PAYMENTS_NAME', 'realhomes-paypal-payments' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-realhomes-paypal-payments.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_realhomes_paypal_payments() {

	$plugin = new Realhomes_Paypal_Payments();
	$plugin->run();

}
run_realhomes_paypal_payments();
