<?php
/**
 * Plugin Name:       RealHomes Currency Switcher
 * Plugin URI:        https://themeforest.net/item/real-homes-wordpress-real-estate-theme/5373914
 * Description:       Provides multiple currencies support and currency switching for RealHomes theme.
 * Version:           1.0.4
 * Author:            InspiryThemes
 * Author URI:        https://inspirythemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       realhomes-currency-switcher
 * Domain Path:       /languages
 *
 * @since   1.0.0
 * @package realhomes-currency-switcher
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Currently plugin version.
define( 'REALHOMES_CURRENCY_SWITCHER_VERSION', '1.0.4' );

// Plugin unique identifire.
define( 'REALHOMES_CURRENCY_SWITCHER_NAME', 'realhomes-currency-switcher' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-realhomes-currency-switcher-activator.php
 */
function activate_realhomes_currency_switcher() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-realhomes-currency-switcher-activator.php';
	Realhomes_Currency_Switcher_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-realhomes-currency-switcher-deactivator.php
 */
function deactivate_realhomes_currency_switcher() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-realhomes-currency-switcher-deactivator.php';
	Realhomes_Currency_Switcher_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_realhomes_currency_switcher' );
register_deactivation_hook( __FILE__, 'deactivate_realhomes_currency_switcher' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-realhomes-currency-switcher.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_realhomes_currency_switcher() {

	$plugin = new Realhomes_Currency_Switcher();
	$plugin->run();

}
run_realhomes_currency_switcher();
