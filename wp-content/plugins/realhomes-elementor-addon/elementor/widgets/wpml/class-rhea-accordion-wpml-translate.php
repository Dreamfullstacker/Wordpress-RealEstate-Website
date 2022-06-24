<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Accordion_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_accordion_widget_to_translate'
		] );
	}

	public function inspiry_accordion_widget_to_translate( $widgets ) {

		$widgets['inspiry-accordion-widget'] = [
			'conditions'        => [ 'widgetType' => 'inspiry-accordion-widget' ],
			'fields'            => [

			],
			'integration-class' => 'RHEA_Accordion_Repeater_WPML_Translate',

		];

		return $widgets;

	}
}

class RHEA_Accordion_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'tabs';
	}

	public function get_fields() {
		return array( 'tab_title', 'tab_content' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'tab_title':
				return esc_html__( 'Accordion Widget Item: Title', 'realhomes-elementor-addon' );

			case 'tab_content':
				return esc_html__( 'Accordion Widget Item: Content', 'realhomes-elementor-addon' );

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

new RHEA_Accordion_WPML_Translate();