<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class RHEA_CTA3_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_rhea_cta3_widget_to_translate'
		], 999999 );

	}


	public function inspiry_rhea_cta3_widget_to_translate( $widgets ) {
		$widgets['ere-cta-three-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-cta-three-widget' ],
			'fields'     => [
				[
					'field'       => 'cta_top_title',
					'type'        => esc_html__( 'CTA-Three Top Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'cta_main_description',
					'type'        => esc_html__( 'CTA-Three Main Description', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'cta__btn_title',
					'type'        => esc_html__( 'CTA-Three Button Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

				'cta_btn_url' => array(
					'field'       => 'url',
					'type'        => esc_html__( 'CTA-Three Button URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINK'
				),
			],
		];

		return $widgets;

	}

}

new RHEA_CTA3_WPML_Translate();
