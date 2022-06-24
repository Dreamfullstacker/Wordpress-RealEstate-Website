<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_Properties_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_classic_properties_to_translate'
		] );

	}

	public function inspiry_classic_properties_to_translate( $widgets ) {

		$widgets['rhea-classic-properties-widget'] = [
			'conditions' => [ 'widgetType' => 'rhea-classic-properties-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_property_more_detail_label',
					'type'        => esc_html__( 'Classic Properties: More Details', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_bedrooms_label',
					'type'        => esc_html__( 'Classic Properties: Bedrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_bathroom_label',
					'type'        => esc_html__( 'Classic Properties: Bathrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_garage_label',
					'type'        => esc_html__( 'Classic Properties: Garages', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],
		];

		return $widgets;

	}
}

new RHEA_Classic_Properties_WPML_Translate();