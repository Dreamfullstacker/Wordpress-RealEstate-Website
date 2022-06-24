<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Schedule_Tour_Form_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_schedule_tour_form_widget_to_translate'
		] );
	}

	public function inspiry_schedule_tour_form_widget_to_translate( $widgets ) {

		$widgets['rhea-schedule-tour-form-widget'] = [
			'conditions'        => [ 'widgetType' => 'rhea-schedule-tour-form-widget' ],
			'fields'            => [
				[
					'field'       => 'section_subtitle',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Sub Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'section_title',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Main Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Submit Button Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'agent_name',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Agent Name', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'agent_designation',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Agent Designation', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'contact_number',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Agent Number', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'contact_email_address',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Agent Email', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'contact_address',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Agent Address', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'contact_call_to_action',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Call to Action Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'contact_call_to_action_link_text',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Call to Action Link Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'contact_call_to_action_url',
					'type'        => esc_html__( 'Schedule Tour Form Widget: Call to Action URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINK'
				],
			],
		];

		return $widgets;
	}
}

new RHEA_Schedule_Tour_Form_WPML_Translate();