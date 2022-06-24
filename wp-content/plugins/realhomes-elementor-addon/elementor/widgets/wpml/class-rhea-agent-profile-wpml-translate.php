<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agent_Profile_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_agent_profile_to_translate'
		] );
	}

	public function inspiry_agent_profile_to_translate( $widgets ) {

		$widgets['rhea-agent-profile-widget'] = [
			'conditions' => [ 'widgetType' => 'rhea-agent-profile-widget' ],
			'fields'     => [
				[
					'field'       => 'rhea_sa_pre_title',
					'type'        => esc_html__( 'Agent Profile: Pre Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
					[
					'field'       => 'rhea_sa_title',
					'type'        => esc_html__( 'Agent Profile: Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_sa_sub_title',
					'type'        => esc_html__( 'Agent Profile: Sub Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_sa_detail',
					'type'        => esc_html__( 'Agent Profile: Details', 'realhomes-elementor-addon' ),
					'editor_type' => 'VISUAL'
				],
				[
					'field'       => 'rhea_sa_phone_label',
					'type'        => esc_html__( 'Agent Profile: Phone Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_sa_email_label',
					'type'        => esc_html__( 'Agent Profile: Email Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_sa_button_text',
					'type'        => esc_html__( 'Agent Profile: Button Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_sa_button_url',
					'type'        => esc_html__( 'Agent Profile: Button URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINK'
				],

			],
		];

		return $widgets;

	}
}

new RHEA_Agent_Profile_WPML_Translate();