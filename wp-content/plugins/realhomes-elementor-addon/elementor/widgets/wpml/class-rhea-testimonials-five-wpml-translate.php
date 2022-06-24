<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Testimonials_Five_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_testimonials_five_to_translate'
		] );
	}

	public function inspiry_testimonials_five_to_translate( $widgets ) {

		$widgets['inspiry-testimonial-five-widget'] = [
			'conditions'        => [ 'widgetType' => 'inspiry-testimonial-five-widget' ],
			'fields'            => [
				[
					'field'       => 'rhea_testimonial_section_subtitle',
					'type'        => esc_html__( 'Testimonials Five Widget: Section Sub Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_testimonial_section_title',
					'type'        => esc_html__( 'Testimonials Five Widget: Section Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
			'integration-class' => 'RHEA_Testimonials_Five_Repeater_WPML_Translate',
		];

		return $widgets;
	}
}

class RHEA_Testimonials_Five_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'rhea_testimonials';
	}

	public function get_fields() {
		return array( 'rhea_testimonial_text', 'rhea_testimonial_author' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_testimonial_text':
				return esc_html__( 'Testimonials Five Widget: Testimonial Text', 'realhomes-elementor-addon' );

			case 'rhea_testimonial_author':
				return esc_html__( 'Testimonials Five Widget: Author Name', 'realhomes-elementor-addon' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'rhea_testimonial_author':
				return 'LINE';
			case 'rhea_testimonial_text':
				return 'AREA';

			default:
				return '';
		}
	}

}

new RHEA_Testimonials_Five_WPML_Translate();