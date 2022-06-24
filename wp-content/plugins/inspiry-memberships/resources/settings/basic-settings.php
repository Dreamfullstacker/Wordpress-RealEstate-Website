<?php
/**
 * Basic Settings File
 *
 * File for adding basic settings.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $ims_settings;

$ims_basic_settings_arr = apply_filters(
	'ims_basic_settings',
	array(
		array(
			'id'   => 'ims_memberships_enable',
			'type' => 'checkbox',
			'name' => esc_html__( 'Enable Memberships', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Check this to enable memberships on your website.', 'inspiry-memberships' ),
		),
		array(
			'id'      => 'ims_payment_method',
			'type'    => 'select',
			'name'    => esc_html__( 'Payments Gateway Type', 'inspiry-membership' ),
			'desc'    => sprintf( esc_html__( 'If you choose "Custom" method, then you can use any individual direct payment methods such as Stripe, PayPal and WireTransfer. Choosing WooCommerce will allow you to use any WooCommerce supported payment method. For more details please check its documentation %1$sPayments Settings%2$s section.', 'inspiry-membership' ), '<a href="https://docs.woocommerce.com/document/configuring-woocommerce-settings/" target="_blank">', '</a>' ),
			'default' => 'custom',
			'options' => array(
				'custom'      => 'Custom',
				'woocommerce' => 'WooCommerce',
			),
		),
		array(
			'id'   => 'ims_recurring_memberships_enable',
			'type' => 'checkbox',
			'name' => esc_html__( 'Enable Recurring Memberships', 'inspiry-memberships' ),
			'desc' => esc_html__( 'Check this to enable recurring memberships on your website. It is available only for "Custom" Payment Method because WooCommerce does not support recurring payments.', 'inspiry-memberships' ),
		),
		array(
			'id'      => 'ims_currency_code',
			'type'    => 'text',
			'name'    => esc_html__( 'Currency Code', 'inspiry-memberships' ),
			'desc'    => esc_html__( 'Provide currency code that you want to use. Example: USD', 'inspiry-memberships' ),
			'default' => 'USD',
		),
		array(
			'id'      => 'ims_currency_symbol',
			'type'    => 'text',
			'name'    => esc_html__( 'Currency Symbol', 'inspiry-memberships' ),
			'desc'    => esc_html__( 'Provide currency symbol that you want to use. Example: $', 'inspiry-memberships' ),
			'default' => '$',
		),
		array(
			'id'      => 'ims_currency_position',
			'type'    => 'select',
			'name'    => esc_html__( 'Currency Symbol Position', 'inspiry-membership' ),
			'desc'    => esc_html__( 'Default: Before', 'inspiry-membership' ),
			'default' => 'before',
			'options' => array(
				'before' => 'Before (E.g. $10)',
				'after'  => 'After (E.g. 10$)',
			),
		),
	)
);

if ( ! empty( $ims_basic_settings_arr ) && is_array( $ims_basic_settings_arr ) ) {
	foreach ( $ims_basic_settings_arr as $ims_basic_setting ) {
		$ims_settings->add_field( 'ims_basic_settings', $ims_basic_setting );
	}
}
