<?php
/**
 * Plugin Name:  Inspiry Stripe Payments for RealHomes
 * Plugin URI:   https://themeforest.net/item/real-homes-wordpress-real-estate-theme/5373914
 * Description:  Provides Stripe functionality for individual property payments.
 * Version:      2.0.0
 * Author:       InspiryThemes
 * Author URI:   https://inspirythemes.com
 * Contributors: inspirythemes, saqibsarwar, fahidjavid
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:  inspiry-stripe-payments
 * Domain Path:  /languages/
 *
 * @link        https://github.com/InspiryThemes/inspiry-stripe-payments
 * @since       1.0.0
 * @package     inspiry-stripe-payments
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Currently plugin versioon.
define( 'INSPIRY_STRIPE_PAYMENTS_VERSION', '2.0.0' );

// Plugin unique identifire.
define( 'INSPIRY_STRIPE_PAYMENTS_NAME', 'inspiry-stripe-payments' );

// Base URL.
define( 'ISP_BASE_URL', plugin_dir_url( __FILE__ ) );

// Base Directory.
define( 'ISP_BASE_DIR', dirname( __FILE__ ) );

// Plugin directory path.
define( 'ISP_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and publisc-facing site hooks.
 */
require_once ISP_PLUGIN_DIR_PATH . 'includes/class-inspiry-stripe-payments.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_inspiry_stripe_payments() {
	$plugin = new Inspiry_Stripe_Payments();
	$plugin->run();
}
run_inspiry_stripe_payments();

