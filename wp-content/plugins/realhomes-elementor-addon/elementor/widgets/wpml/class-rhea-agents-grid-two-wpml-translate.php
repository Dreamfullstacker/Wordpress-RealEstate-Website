<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agents_Grid_Two_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_agents_grid_two_to_translate'
		] );
	}

	public function inspiry_agents_grid_two_to_translate( $widgets ) {

		$widgets['ere-agents-widget-2'] = [
			'conditions'        => [ 'widgetType' => 'ere-agents-widget-2' ],
			'fields'            => [

			],
			'integration-class' => 'RHEA_Agents_Two_Repeater_WPML_Translate',

		];

		return $widgets;

	}
}

class RHEA_Agents_Two_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'rhea_agent';
	}

	public function get_fields() {
		return array( 'rhea_agent_title', 'rhea_agent_url', 'rhea_agent_sub_title','rhea_agent_excerpt' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_agent_title':
				return esc_html__( 'Agent Grid Two: Agent Title', 'realhomes-elementor-addon' );

			case 'rhea_agent_url':
				return esc_html__( 'Agent Grid Two: URL For Agent Image And Title', 'realhomes-elementor-addon' );

			case 'rhea_agent_sub_title':
				return esc_html__( 'Agent Grid Two: Agent Subtitle', 'realhomes-elementor-addon' );

			case 'rhea_agent_excerpt':
				return esc_html__( 'Agent Grid Two: Excerpt', 'realhomes-elementor-addon' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'rhea_testimonial_author':
				return 'LINE';
				case 'rhea_agent_url':
				return 'LINK';
			case 'rhea_testimonial_author_designation':
				return 'LINE';
			case 'rhea_testimonial_text':
				return 'AREA';

			default:
				return '';
		}
	}

}

new RHEA_Agents_Grid_Two_WPML_Translate();