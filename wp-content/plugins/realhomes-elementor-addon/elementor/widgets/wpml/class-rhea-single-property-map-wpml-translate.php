<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Single_Property_Map_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_single_property_map_widget_to_translate'
		] );
	}

	public function inspiry_single_property_map_widget_to_translate( $widgets ) {

		$widgets['rhea-single-property-map-widget'] = [
			'conditions'        => [ 'widgetType' => 'rhea-single-property-map-widget' ],
			'fields'            => [
				[
					'field'       => 'location_label',
					'type'        => esc_html__( 'Single Property Map Widget: Section Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'contact_number',
					'type'        => esc_html__( 'Single Property Map Widget: Phone', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'email_address',
					'type'        => esc_html__( 'Single Property Map Widget: Email', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'address',
					'type'        => esc_html__( 'Single Property Map Widget: Address', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
			],
		];

		return $widgets;
	}
}

new RHEA_Single_Property_Map_WPML_Translate();