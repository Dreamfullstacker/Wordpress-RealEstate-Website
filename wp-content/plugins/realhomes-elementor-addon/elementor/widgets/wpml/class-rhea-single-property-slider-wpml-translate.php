<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Single_Property_Slider_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_single_property_slider_widget_to_translate'
		] );
	}

	public function inspiry_single_property_slider_widget_to_translate( $widgets ) {

		$widgets['rhea-single-property-slider-widget'] = [
			'conditions'        => [ 'widgetType' => 'rhea-single-property-slider-widget' ],
			'fields'            => [
				[
					'field'       => 'property_video_sub_heading',
					'type'        => esc_html__( 'Single Property Slider Widget: Sub Heading', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_video_heading',
					'type'        => esc_html__( 'Single Property Slider Widget: Heading', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_video_url',
					'type'        => esc_html__( 'Single Property Slider Widget: Video URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_title',
					'type'        => esc_html__( 'Single Property Slider Widget: Property Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_description',
					'type'        => esc_html__( 'Single Property Slider Widget: Property Description', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'property_price',
					'type'        => esc_html__( 'Single Property Slider Widget: Property Price', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_status_custom_text',
					'type'        => esc_html__( 'Single Property Slider Widget: Status Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_address',
					'type'        => esc_html__( 'Single Property Slider Widget: Property Address', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'cta_button_text',
					'type'        => esc_html__( 'Single Property Slider Widget: Call To Action Button Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'cta_url',
					'type'        => esc_html__( 'Single Property Slider Widget: Call To Action Button URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINK'
				],
				[
					'field'       => 'bedrooms_label',
					'type'        => esc_html__( 'Single Property Slider Widget: Label for Bedrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'bedrooms',
					'type'        => esc_html__( 'Single Property Slider Widget: Number of Bedrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'bathrooms_label',
					'type'        => esc_html__( 'Single Property Slider Widget: Label for Bathrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'bathrooms',
					'type'        => esc_html__( 'Single Property Slider Widget: Label for Bathrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'area_label',
					'type'        => esc_html__( 'Single Property Slider Widget: Label for Area', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'area',
					'type'        => esc_html__( 'Single Property Slider Widget: Property Area', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'area_unit',
					'type'        => esc_html__( 'Single Property Slider Widget: Area Unit', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
		];

		return $widgets;
	}
}

new RHEA_Single_Property_Slider_WPML_Translate();