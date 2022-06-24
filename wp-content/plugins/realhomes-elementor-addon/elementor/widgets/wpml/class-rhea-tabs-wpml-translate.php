<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Tabs_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_tabs_widget_to_translate'
		] );
	}

	public function inspiry_tabs_widget_to_translate( $widgets ) {

		$widgets['inspiry-tabs-widget'] = [
			'conditions'        => [ 'widgetType' => 'inspiry-tabs-widget' ],
			'fields'            => [
				[
					'field'       => 'section_title',
					'type'        => esc_html__( 'Tabs Widget: Section Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
			'integration-class' => 'RHEA_Tabs_Repeater_WPML_Translate',
		];

		return $widgets;
	}
}

class RHEA_Tabs_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'tabs';
	}

	public function get_fields() {
		return array( 'tab_title', 'tab_content' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'tab_title':
				return esc_html__( 'Tabs Widget Item: Title', 'realhomes-elementor-addon' );

			case 'tab_content':
				return esc_html__( 'Tabs Widget Item: Content', 'realhomes-elementor-addon' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'tab_title':
				return 'LINE';
			case 'tab_content':
				return 'AREA';

			default:
				return '';
		}
	}

}

new RHEA_Tabs_WPML_Translate();