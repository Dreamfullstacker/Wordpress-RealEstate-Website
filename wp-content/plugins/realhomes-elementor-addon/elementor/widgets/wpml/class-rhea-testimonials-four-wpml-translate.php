<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Testimonials_Four_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_testimonials_four_to_translate'
		] );
	}

	public function inspiry_testimonials_four_to_translate( $widgets ) {

		$widgets['inspiry-testimonial-four-widget'] = [
			'conditions'        => [ 'widgetType' => 'inspiry-testimonial-four-widget' ],
			'fields'            => [

			],
			'integration-class' => 'RHEA_Testimonials_Four_Repeater_WPML_Translate',

		];

		return $widgets;

	}
}

class RHEA_Testimonials_Four_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'rhea_testimonials';
	}

	public function get_fields() {
		return array( 'rhea_testimonial_author', 'rhea_testimonial_author_designation', 'rhea_testimonial_text' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_testimonial_author':
				return esc_html__( 'Testimonials Four Widget: Author Name', 'realhomes-elementor-addon' );

			case 'rhea_testimonial_author_designation':
				return esc_html__( 'Testimonials Four Widget: Author Designation', 'realhomes-elementor-addon' );

			case 'rhea_testimonial_text':
				return esc_html__( 'Testimonials Four Widget: Testimonial Text', 'realhomes-elementor-addon' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'rhea_testimonial_author':
			case 'rhea_testimonial_author_designation':
				return 'LINE';
			case 'rhea_testimonial_text':
				return 'AREA';

			default:
				return '';
		}
	}

}

new RHEA_Testimonials_Four_WPML_Translate();