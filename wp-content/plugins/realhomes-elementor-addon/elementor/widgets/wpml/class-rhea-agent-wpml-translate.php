<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agent_Widget_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'rhea_agent_widget_to_translate'
		] );
	}

	public function rhea_agent_widget_to_translate( $widgets ) {

		$widgets['rhea-agent-widget'] = [
			'conditions'        => [ 'widgetType' => 'rhea-agent-widget' ],
			'fields'            => [
				[
					'field'       => 'agent_title',
					'type'        => esc_html__( 'Agent Widget: Agent Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'agent_url',
					'type'        => esc_html__( 'Agent Widget: Agent Link', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'agent_designation',
					'type'        => esc_html__( 'Agent Widget: Agent Designation', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'agent_excerpt',
					'type'        => esc_html__( 'Agent Widget: Agent Description', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
			],
		];

		return $widgets;
	}
}

new RHEA_Agent_Widget_WPML_Translate();