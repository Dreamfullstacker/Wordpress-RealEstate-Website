<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Search_form_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_search_form_to_translate'
		] );

	}

	public function inspiry_search_form_to_translate( $widgets ) {

		$widgets['rhea-search-form-widget'] = [
			'conditions' => [ 'widgetType' => 'rhea-search-form-widget' ],
			'fields'     => [
				[
					'field'       => 'search_button_label',
					'type'        => esc_html__( 'Search Form: Search Button', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'advance_features_text',
					'type'        => esc_html__( 'Search Form: Advance Features Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_location_title_1',
					'type'        => esc_html__( 'Search Form: Main Location', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_location_ph_1',
					'type'        => esc_html__( 'Search Form: Main Location Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'location_count_placeholder',
					'type'        => esc_html__( 'Search Form: Location Count Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_location_title_2',
					'type'        => esc_html__( 'Search Form: Child Location ', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_location_ph_2',
					'type'        => esc_html__( 'Search Form: Main Child Placeholder ', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_location_title_3',
					'type'        => esc_html__( 'Search Form: Grand Child Location ', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_location_ph_3',
					'type'        => esc_html__( 'Search Form: Grand Child Placeholder ', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_location_title_4',
					'type'        => esc_html__( 'Search Form: Great Grand Child Location', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_location_ph_4',
					'type'        => esc_html__( 'Search Form: Great Grand Child Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_status_label',
					'type'        => esc_html__( 'Search Form: Property Status Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_status_placeholder',
					'type'        => esc_html__( 'Search Form: Property Status Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'status_count_placeholder',
					'type'        => esc_html__( 'Search Form: Property Status Count Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_types_label',
					'type'        => esc_html__( 'Search Form: Property Types Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_types_placeholder',
					'type'        => esc_html__( 'Search Form: Property Types Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'types_count_placeholder',
					'type'        => esc_html__( 'Search Form: Property Types Count Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'min_bed_label',
					'type'        => esc_html__( 'Search Form: Property Min Beds Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'min_bed_placeholder',
					'type'        => esc_html__( 'Search Form: Property Min Beds Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'min_bath_label',
					'type'        => esc_html__( 'Search Form: Property Min Baths Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'min_bath_placeholder',
					'type'        => esc_html__( 'Search Form: Property Min Baths Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'slider_range_label',
					'type'        => esc_html__( 'Search Form: Property Price Slider Range Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'slider_range_from',
					'type'        => esc_html__( 'Search Form: Property Price Slider Range From Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'slider_range_to',
					'type'        => esc_html__( 'Search Form: Property Price Slider Range To Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'min_price_label',
					'type'        => esc_html__( 'Search Form: Property Min Price Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'min_price_placeholder',
					'type'        => esc_html__( 'Search Form: Property Min Price Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'max_price_label',
					'type'        => esc_html__( 'Search Form: Property Max Price Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'max_price_placeholder',
					'type'        => esc_html__( 'Search Form: Property Max Price Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'garages_label',
					'type'        => esc_html__( 'Search Form: Property Garages Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'garages_placeholder',
					'type'        => esc_html__( 'Search Form: Property Garages Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'agent_label',
					'type'        => esc_html__( 'Search Form: Property Agents Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'agent_placeholder',
					'type'        => esc_html__( 'Search Form: Property Agents Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'agent_count_placeholder',
					'type'        => esc_html__( 'Search Form: Property Agents Count Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'min_area_label',
					'type'        => esc_html__( 'Search Form: Property Min Area Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'min_area_placeholder',
					'type'        => esc_html__( 'Search Form: Property Min Area Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'max_area_label',
					'type'        => esc_html__( 'Search Form: Property Max Area Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'max_area_placeholder',
					'type'        => esc_html__( 'Search Form: Property Max Area Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'area_units_placeholder',
					'type'        => esc_html__( 'Search Form: Property Area Units Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'area_units_title_attr',
					'type'        => esc_html__( 'Search Form: Property Area Units Title Attribute', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'keyword_label',
					'type'        => esc_html__( 'Search Form: Property Keyword Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'keyword_placeholder',
					'type'        => esc_html__( 'Search Form: Property Keyword Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_id_label',
					'type'        => esc_html__( 'Search Form: Property ID Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_id_placeholder',
					'type'        => esc_html__( 'Search Form: Property ID Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],


			],
		];

		return $widgets;

	}
}

new RHEA_Search_form_WPML_Translate();