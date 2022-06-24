<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Hero_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_hero_widget_to_translate'
		] );
	}

	public function inspiry_hero_widget_to_translate( $widgets ) {

		$widgets['inspiry-hero-widget'] = [
			'conditions'        => [ 'widgetType' => 'inspiry-hero-widget' ],
			'fields'            => [
				[
					'field'       => 'section_title',
					'type'        => esc_html__( 'Hero Widget: Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'section_description',
					'type'        => esc_html__( 'Hero Widget: Description', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'form_title',
					'type'        => esc_html__( 'Hero Widget: Form Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'location_field_label',
					'type'        => esc_html__( 'Hero Widget: Location Field Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'location_field_placeholder',
					'type'        => esc_html__( 'Hero Widget: Location Field Placeholder Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'type_field_label',
					'type'        => esc_html__( 'Hero Widget: Type Field label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'type_field_placeholder',
					'type'        => esc_html__( 'Hero Widget: Type Field Placeholder Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'guest_field_label',
					'type'        => esc_html__( 'Hero Widget: Guest Field Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'guest_field_placeholder',
					'type'        => esc_html__( 'Hero Widget: Guest Field Placeholder Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'submit_button_text',
					'type'        => esc_html__( 'Hero Widget: Submit Button Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'testimonial_name',
					'type'        => esc_html__( 'Hero Widget: Author Name', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'testimonial_content',
					'type'        => esc_html__( 'Hero Widget: Testimonial Content', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
			],
		];

		return $widgets;
	}
}

new RHEA_Hero_WPML_Translate();