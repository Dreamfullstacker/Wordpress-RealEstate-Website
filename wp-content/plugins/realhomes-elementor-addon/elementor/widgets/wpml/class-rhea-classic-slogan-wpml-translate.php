<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_Slogan_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_classic_slogan_to_translate'
		] );

	}

	public function inspiry_classic_slogan_to_translate( $widgets ) {

		$widgets['ere-classic-slogan-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-classic-slogan-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_main_title',
					'type'        => esc_html__( 'Classic Slogan: Main Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_description',
					'type'        => esc_html__( 'Classic Slogan: Description', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],
		];

		return $widgets;

	}
}

new RHEA_Classic_Slogan_WPML_Translate();