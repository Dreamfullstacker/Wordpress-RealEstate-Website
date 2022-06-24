<?php
/**
 * Load all required social login files and libraries.
 *
 * @since      0.5.3
 * @package    easy-real-estate
 * @subpackage easy-real-estate/includes/social-login
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once ERE_PLUGIN_DIR . 'includes/social-login/helper-functions.php';

if ( ere_is_social_login_enabled( 'facebook' ) || ere_is_social_login_enabled( 'google' ) || ere_is_social_login_enabled( 'twitter' ) ) {
	require_once ERE_PLUGIN_DIR . 'includes/social-login/ajax-handler.php';
	require_once ERE_PLUGIN_DIR . 'includes/social-login/callbacks.php';
}
