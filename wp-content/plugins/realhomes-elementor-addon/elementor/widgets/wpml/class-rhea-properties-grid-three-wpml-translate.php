<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Properties_Grid_Three_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_properties_grid_three_to_translate'
		] );

	}
	public function inspiry_properties_grid_three_to_translate( $widgets ) {

		$widgets['rhea-properties-widget-3'] = [
			'conditions' => [ 'widgetType' => 'rhea-properties-widget-3' ],
			'fields'     => [

				[
					'field'       => 'ere_property_added_label',
					'type'        => esc_html__( 'Properties Grid Three: Date Pre-fix', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_added_ago_label',
					'type'        => esc_html__( 'Properties Grid Three: Date Post-fix', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_featured_label',
					'type'        => esc_html__( 'Properties Grid Three: Featured', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_fav_label',
					'type'        => esc_html__( 'Properties Grid Three: Add To Favourite', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_fav_added_label',
					'type'        => esc_html__( 'Properties Grid Three: Added To Favourite', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_compare_label',
					'type'        => esc_html__( 'Properties Grid Three: Add To Compare', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_compare_added_label',
					'type'        => esc_html__( 'Properties Grid Three: Added To Compare', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],
			'integration-class' => 'RHEA_Properties_Three_Repeater_WPML_Translate',
		];

		return $widgets;

	}
}

class RHEA_Properties_Three_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {
	public function get_items_field() {
		return 'rhea_add_meta_select';
	}

	public function get_fields() {
		return array( 'rhea_meta_repeater_label' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_meta_repeater_label':
				return esc_html__( 'Properties Grid Three: Meta Label', 'realhomes-elementor-addon' );
			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'rhea_meta_repeater_label':
				return 'LINE';
			default:
				return '';
		}
	}
}

new RHEA_Properties_Grid_Three_WPML_Translate();