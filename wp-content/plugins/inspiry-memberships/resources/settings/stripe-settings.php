<?php
/**
 * Stripe Settings File
 *
 * File for adding stripe settings.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $ims_settings;

$ims_stripe_settings_arr = apply_filters(
	'ims_stripe_settings',
	array(
		array(
			'id'   => 'ims_stripe_enable',
			'type' => 'checkbox',
			'name' => esc_html__( 'Enable Stripe', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Check this to enable Stripe payments.', 'inspiry-memberships' ),
		),
		array(
			'id'   => 'ims_stripe_publishable',
			'type' => 'text',
			'name' => esc_html__( 'Publishable Key*', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Paste your stripe account publishable key.', 'inspiry-memberships' ),
		),
		array(
			'id'   => 'ims_stripe_secret',
			'type' => 'text',
			'name' => esc_html__( 'Secret Key*', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Paste your stripe account secret key.', 'inspiry-memberships' ),
		),
		array(
			'id'      => 'ims_stripe_btn_label',
			'type'    => 'text',
			'name'    => esc_html__( 'Stripe Button Label', 'inspiry-memberships' ),
			'desc'    => esc_html__( 'Default: Pay with Card', 'inspiry-memberships' ),
			'default' => 'Pay with Card',
		),
		array(
			'id'      => 'ims_stripe_webhook_url',
			'type'    => 'text',
			'name'    => esc_html__( 'Stripe WebHook URL', 'inspiry-memberships' ),
			'desc'    => esc_url( add_query_arg( array( 'ims_stripe' => 'membership_event' ), home_url( '/' ) ) ),
			'default' => esc_url( add_query_arg( array( 'ims_stripe' => 'membership_event' ), home_url( '/' ) ) ),
		),
	)
);

if ( ! empty( $ims_stripe_settings_arr ) && is_array( $ims_stripe_settings_arr ) ) {
	foreach ( $ims_stripe_settings_arr as $ims_stripe_setting ) {
		$ims_settings->add_field( 'ims_stripe_settings', $ims_stripe_setting );
	}
}
