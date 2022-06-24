<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Login_Modal_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_login_modal_to_translate'
		] );

	}

	public function inspiry_login_modal_to_translate( $widgets ) {

		$widgets['rhea-login-modal-modern'] = [
			'conditions'        => [ 'widgetType' => 'rhea-login-modal-modern' ],
			'fields'            => [
				[
					'field'       => 'rhea_login_modal_avatar_text',
					'type'        => esc_html__( 'Login Modal: Login/Register', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_login_welcome_label',
					'type'        => esc_html__( 'Login Modal: Welcome', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_login_profile_label',
					'type'        => esc_html__( 'Login Modal: Profile', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_login_my_properties_label',
					'type'        => esc_html__( 'Login Modal: My Properties', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_login_favorites_label',
					'type'        => esc_html__( 'Login Modal: Favorites', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_login_compare_label',
					'type'        => esc_html__( 'Login Modal: Compare', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_login_membership_label',
					'type'        => esc_html__( 'Login Modal: Membership', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_log_out_label',
					'type'        => esc_html__( 'Login Modal: Log Out', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
			'integration-class' => 'RHEA_Login_Modal_Repeater_WPML_Translate',
		];

		return $widgets;

	}
}


class RHEA_Login_Modal_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'rhea_login_add_more_repeater';
	}

	public function get_fields() {
		return array( 'rhea_link_text', 'rhea_page_url' => array( 'url' ) );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_link_text':
				return esc_html__( 'Login Modal: Link Text', 'realhomes-elementor-addon' );

			case 'url':
				return esc_html__( 'Login Modal: Link', 'realhomes-elementor-addon' );


			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'rhea_link_text':
				return 'LINE';

			case 'url':
				return 'LINK';

			default:
				return '';
		}
	}

}

new RHEA_Login_Modal_WPML_Translate();
