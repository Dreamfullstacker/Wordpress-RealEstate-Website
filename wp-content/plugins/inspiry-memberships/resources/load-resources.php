<?php
/**
 * Plugin initialization file.
 *
 * This file initializes the core of the plugin.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Emails handling class.
 *
 * @since 2.1.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/class-ims-email.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/class-ims-email.php';
}

/**
 * Helping functions class.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/class-helper-functions.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/class-helper-functions.php';
}

/**
 * Membership CPT, metaboxes and subscriptions.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/membership/membership-init.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/membership/membership-init.php';
}

/**
 * Memberhips receipts handling.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/receipt/receipt-init.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/receipt/receipt-init.php';
}

/**
 * Admin menu and sub menus.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/settings/admin-menu.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/settings/admin-menu.php';
}

/**
 * Memberships settings initialization.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/settings/settings-init.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/settings/settings-init.php';
}

/**
 * Memberships payments handling.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/payment-handler/payment-handler-init.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/payment-handler/payment-handler-init.php';
}
