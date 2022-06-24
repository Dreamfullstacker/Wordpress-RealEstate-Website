<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_Features_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_classic_features_to_translate'
		] );

	}

	public function inspiry_classic_features_to_translate( $widgets ) {

		$widgets['ere-classic-features-section-widget'] = [
			'conditions'        => [ 'widgetType' => 'ere-classic-features-section-widget' ],
			'fields'            => [
				[
					'field'       => 'main_title',
					'type'        => esc_html__( 'Classic Features: Main Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'main_description',
					'type'        => esc_html__( 'Classic Features: Main Description', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],
			'integration-class' => 'RHEA_Classic_Features_Repeater_WPML_Translate',
		];

		return $widgets;

	}
}


class RHEA_Classic_Features_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'ere_section_feature';
	}

	public function get_fields() {
		return array( 'section_title', 'section_description' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'section_title':
				return esc_html__( 'Slides: heading', 'realhomes-elementor-addon' );

			case 'section_description':
				return esc_html__( 'Slides: description', 'realhomes-elementor-addon' );


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

new RHEA_Classic_Features_WPML_Translate();
