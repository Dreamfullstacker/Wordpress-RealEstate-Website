<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class RHEA_CTA2_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_rhea_cta2_widget_to_translate'
		], 999999 );

	}


	public function inspiry_rhea_cta2_widget_to_translate( $widgets ) {
		$widgets['ere-cta-two-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-cta-two-widget' ],
			'fields'     => [
				[
					'field'       => 'cta_top_title',
					'type'        => esc_html__( 'CTA-Two Top Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'cta_main_title',
					'type'        => esc_html__( 'CTA-Two Main Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'cta_first_btn_title',
					'type'        => esc_html__( 'CTA-Two First Button Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

				'cta_first_btn_url' => array(
					'field'       => 'url',
					'type'        => esc_html__( 'CTA-Two First Button URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINK'
				),
				[
					'field'       => 'cta_second_btn_title',
					'type'        => esc_html__( 'CTA-Two Second Button Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

				'cta_second_btn_url' => array(
					'field'       => 'url',
					'type'        => esc_html__( 'CTA-Two Second Button URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINK'
				),
			],
		];

		return $widgets;

	}

}

new RHEA_CTA2_WPML_Translate();
