<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Properties_Slider_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_properties_slider_widget_to_translate'
		] );
	}

	public function inspiry_properties_slider_widget_to_translate( $widgets ) {

		$widgets['rhea-properties-slider-widget'] = [
			'conditions'        => [ 'widgetType' => 'rhea-properties-slider-widget' ],
			'fields'            => [
				[
					'field'       => 'button_text',
					'type'        => esc_html__( 'Properties Slider Widget: Button Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'bedrooms_label',
					'type'        => esc_html__( 'Properties Slider Widget: Label for Bedrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'bathrooms_label',
					'type'        => esc_html__( 'Properties Slider Widget: Label for Bathrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'area_label',
					'type'        => esc_html__( 'Properties Slider Widget: Label for Area', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
		];

		return $widgets;
	}
}

new RHEA_Properties_Slider_WPML_Translate();