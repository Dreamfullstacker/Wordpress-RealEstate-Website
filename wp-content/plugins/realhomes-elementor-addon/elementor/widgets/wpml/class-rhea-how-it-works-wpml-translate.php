<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_How_It_Works_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_how_it_works_to_translate'
		] );
	}

	public function inspiry_how_it_works_to_translate( $widgets ) {

		$widgets['rhea-how-it-works-widget'] = [
			'conditions'        => [ 'widgetType' => 'rhea-how-it-works-widget' ],
			'fields'            => array(),
			'integration-class' => 'RHEA_How_It_Works_Repeater_WPML_Translate',
		];

		return $widgets;
	}
}

class RHEA_How_It_Works_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'rhea_hiw_section';
	}

	public function get_fields() {
		return array( 'section_title', 'section_description' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'section_title':
				return esc_html__( 'How it Works Widget Item: Title', 'realhomes-elementor-addon' );

			case 'section_description':
				return esc_html__( 'How it Works Widget Item: Description', 'realhomes-elementor-addon' );


			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'section_title':
				return 'LINE';

			case 'section_description':
				return 'AREA';

			default:
				return '';
		}
	}

}

new RHEA_How_It_Works_WPML_Translate();
