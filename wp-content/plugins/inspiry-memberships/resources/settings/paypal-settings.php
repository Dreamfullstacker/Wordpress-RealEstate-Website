<?php
/**
 * PayPal Settings File
 *
 * File for adding paypal settings.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $ims_settings;

$ims_paypal_settings_arr = apply_filters(
	'ims_paypal_settings',
	array(
		array(
			'id'   => 'ims_paypal_enable',
			'type' => 'checkbox',
			'name' => esc_html__( 'Enable PayPal', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Check this to enable PayPal payments.', 'inspiry-memberships' ),
		),
		array(
			'id'   => 'ims_paypal_test_mode',
			'type' => 'checkbox',
			'name' => esc_html__( 'Sandbox Mode', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Check this option to use PayPal sandbox.', 'inspiry-memberships' ),
		),
		array(
			'id'   => 'ims_paypal_client_id',
			'type' => 'text',
			'name' => esc_html__( 'Client ID', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Paste your client ID here.', 'inspiry-memberships' ),
		),
		array(
			'id'   => 'ims_paypal_client_secret',
			'type' => 'text',
			'name' => esc_html__( 'Client Secret', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Paste your client secret here.', 'inspiry-memberships' ),
		),
		array(
			'id'   => 'ims_paypal_api_username',
			'type' => 'text',
			'name' => esc_html__( 'API Username', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Paste your API username here.', 'inspiry-memberships' ),
		),
		array(
			'id'   => 'ims_paypal_api_password',
			'type' => 'text',
			'name' => esc_html__( 'API Password', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Paste your API password here.', 'inspiry-memberships' ),
		),
		array(
			'id'   => 'ims_paypal_api_signature',
			'type' => 'text',
			'name' => esc_html__( 'API Signature', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Paste your API signature here.', 'inspiry-memberships' ),
		),
		array(
			'id'      => 'ims_paypal_ipn_url',
			'type'    => 'text',
			'name'    => esc_html__( 'PayPal IPN URL', 'inspiry-memberships' ),
			'desc'    => esc_url( add_query_arg( array( 'ims_paypal' => 'notification' ), home_url( '/' ) ) ),
			'default' => esc_url( add_query_arg( array( 'ims_paypal' => 'notification' ), home_url( '/' ) ) ),
		),
	)
);

if ( ! empty( $ims_paypal_settings_arr ) && is_array( $ims_paypal_settings_arr ) ) {
	foreach ( $ims_paypal_settings_arr as $ims_paypal_setting ) {
		$ims_settings->add_field( 'ims_paypal_settings', $ims_paypal_setting );
	}
}
