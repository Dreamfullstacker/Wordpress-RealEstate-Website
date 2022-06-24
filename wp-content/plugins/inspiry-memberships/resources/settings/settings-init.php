<?php
/**
 * Plugin Settings Initializer
 *
 * Initializer file for plugin settings.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Membership settings page.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/settings/class-wp-osa.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/settings/class-wp-osa.php';
}

if ( class_exists( 'WP_OSA' ) ) {

	// New Settings Menu.
	global $ims_settings;
	$ims_settings = new WP_OSA();

	// Before adding settings hook.
	do_action( 'ims_before_settings_loaded', $ims_settings );

	/**
	 * Adding sections for the settings page.
	 *
	 * @since 1.0.0
	 */
	$ims_sections_arr = apply_filters(
		'ims_settings_sections',
		array(
			array(
				'id'    => 'ims_basic_settings',
				'title' => esc_html__( 'Basic Settings', 'inspiry-memberships' ),
			),
			array(
				'id'    => 'ims_stripe_settings',
				'title' => esc_html__( 'Stripe Settings', 'inspiry-memberships' ),
			),
			array(
				'id'    => 'ims_paypal_settings',
				'title' => esc_html__( 'PayPal Settings', 'inspiry-memberships' ),
			),
			array(
				'id'    => 'ims_wire_settings',
				'title' => esc_html__( 'Wire Transfer Settings', 'inspiry-memberships' ),
			),
		)
	);

	if ( ! empty( $ims_sections_arr ) && is_array( $ims_sections_arr ) ) {
		foreach ( $ims_sections_arr as $ims_section ) {
			$ims_settings->add_section( $ims_section );
		}
	}

	/**
	 * Basic settings file.
	 *
	 * @since 1.0.0
	 */
	if ( file_exists( IMS_BASE_DIR . 'resources/settings/basic-settings.php' ) ) {
		include_once IMS_BASE_DIR . 'resources/settings/basic-settings.php';
	}

	/**
	 * Stripe settings file.
	 *
	 * @since 1.0.0
	 */
	if ( file_exists( IMS_BASE_DIR . 'resources/settings/stripe-settings.php' ) ) {
		include_once IMS_BASE_DIR . 'resources/settings/stripe-settings.php';
	}

	/**
	 * PayPal settings file.
	 *
	 * @since 1.0.0
	 */
	if ( file_exists( IMS_BASE_DIR . 'resources/settings/paypal-settings.php' ) ) {
		include_once IMS_BASE_DIR . 'resources/settings/paypal-settings.php';
	}

	/**
	 * Wire settings file.
	 *
	 * @since 1.0.0
	 */
	if ( file_exists( IMS_BASE_DIR . 'resources/settings/wire-settings.php' ) ) {
		include_once IMS_BASE_DIR . 'resources/settings/wire-settings.php';
	}

	// After adding settings hook.
	do_action( 'ims_after_settings_loaded', $ims_settings );

}
