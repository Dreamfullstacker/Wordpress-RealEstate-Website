<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Section_Title_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_section_title_to_translate'
		] );

	}
	public function inspiry_section_title_to_translate( $widgets ) {

		$widgets['ere-section-title-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-section-title-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_top_title',
					'type'        => esc_html__( 'Section Title: Top Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_main_title',
					'type'        => esc_html__( 'Section Title: Main Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_description',
					'type'        => esc_html__( 'Section Title: Description', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],

			],
		];

		return $widgets;

	}
}

new RHEA_Section_Title_WPML_Translate();