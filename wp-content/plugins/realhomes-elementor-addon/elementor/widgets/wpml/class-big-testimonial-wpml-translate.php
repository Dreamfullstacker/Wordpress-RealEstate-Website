<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Big_Testimonial_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_big_testimonial_to_translate'
		] );
	}

	public function inspiry_big_testimonial_to_translate( $widgets ) {

		$widgets['ere-big-testimonial-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-big-testimonial-widget' ],
			'fields'     => [
				[
					'field'       => 'testimonial_text',
					'type'        => esc_html__( 'Big Testimonial: Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'testimonial_name',
					'type'        => esc_html__( 'Big Testimonial: Name', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				'testimonial_url' => array(
					'field'       => 'url',
					'type'        => esc_html__( 'Big Testimonial: Name URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINK'
				),
			],
		];

		return $widgets;

	}
}

new RHEA_Big_Testimonial_WPML_Translate();