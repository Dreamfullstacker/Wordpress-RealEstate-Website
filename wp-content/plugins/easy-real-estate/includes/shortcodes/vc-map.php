<?php
/**
 * @package easy_real_estate
 * @subpackage shortcodes
 * This file contains code related to properties shortcode integration with visual composer.
 */


/**
 * Integrates properties shortcode with Visual Composer
 */
if ( ! function_exists( 'ere_shortcodes_integration' ) ) {

	function ere_shortcodes_integration() {
		/*
		 * Locations
		 */
		$locations_nam_slug_array = array();
		$all_locations       = ERE_Data::get_hierarchical_locations();
		if ( ! empty( $all_locations ) ) {
			foreach ( $all_locations as $top_level_locations ) {
				$locations_nam_slug_array[ $top_level_locations['name'] ] = $top_level_locations['slug'];
			}
		}

		/*
		 * Statuses
		 */
		$property_statuses_name_slug_array = array();
		$all_statuses       = ERE_Data::get_hierarchical_property_statuses();
		if ( ! empty( $all_statuses ) ) {
			foreach ( $all_statuses as $property_status ) {
				$property_statuses_name_slug_array[ $property_status['name'] ] = $property_status['slug'];
			}
		}

		/*
		 * Types
		 */
		$property_types_name_slug_array = array();
		$all_types       = ERE_Data::get_hierarchical_property_types();
		if ( ! empty( $all_types ) ) {
			foreach ( $all_types as $top_level_type ) {
				$property_types_name_slug_array[ $top_level_type['name'] ] = $top_level_type['slug'];
			}
		}

		/*
		 * Features
		 */
		$features_name_slug_array = array();
		$all_features             = ERE_Data::get_hierarchical_property_features();
		if ( ! empty( $all_features ) ) {
			foreach ( $all_features as $feature ) {
				$features_name_slug_array[ $feature['name'] ] = $feature['slug'];
			}
		}

		/*
		 * Agents
		 */
		$agents_array = array();
		$agents_posts = get_posts(
			array(
				'post_type'        => 'agent',
				'posts_per_page'   => - 1,
				'suppress_filters' => 0,
			)
		);
		if ( count( $agents_posts ) > 0 ) {
			foreach ( $agents_posts as $agent_post ) {
				$agents_array[ $agent_post->post_title ] = $agent_post->ID;
			}
		}

		vc_map( array(
			'name'        => esc_html__( 'Properties', 'easy-real-estate' ),
			'description' => esc_html__( 'List of Properties', 'easy-real-estate' ),
			'base'        => 'properties',
			'category'    => esc_html__( 'RealHomes Theme', 'easy-real-estate' ),
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Layout', 'easy-real-estate' ),
					'param_name'  => 'layout',
					'value'       => array(
						'Grid' => 'grid',
						'List' => 'list',
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Number of Properties', 'easy-real-estate' ),
					'param_name'  => 'count',
					'value'       => array(
						__( 'All', 'easy-real-estate' ) => - 1,
						'1'                      => 1,
						'2'                      => 2,
						'3'                      => 3,
						'4'                      => 4,
						'5'                      => 5,
						'6'                      => 6,
						'7'                      => 7,
						'8'                      => 8,
						'9'                      => 9,
						'10'                     => 10,
						'11'                     => 11,
						'12'                     => 12,
						'13'                     => 13,
						'14'                     => 14,
						'15'                     => 15,
						'16'                     => 16,
					),
					'admin_label' => true,
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Order By', 'easy-real-estate' ),
					'param_name' => 'orderby',
					'value'      => array(
						__( 'Date', 'easy-real-estate' )  => 'date',
						__( 'Price', 'easy-real-estate' ) => 'price',
					),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Order', 'easy-real-estate' ),
					'param_name' => 'order',
					'value'      => array(
						__( 'Descending', 'easy-real-estate' ) => 'DESC',
						__( 'Ascending', 'easy-real-estate' )  => 'ASC',
					),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Agent', 'easy-real-estate' ),
					'param_name'  => 'agent',
					'value'       => $agents_array,
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Locations', 'easy-real-estate' ),
					'param_name'  => 'locations',
					'value'       => $locations_nam_slug_array,
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Statuses', 'easy-real-estate' ),
					'param_name'  => 'statuses',
					'value'       => $property_statuses_name_slug_array,
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Types', 'easy-real-estate' ),
					'param_name'  => 'types',
					'value'       => $property_types_name_slug_array,
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Minimum Bedrooms', 'easy-real-estate' ),
					'param_name'  => 'min_beds',
					'value'       => array(
						ere_any_text() => null,
						'1'                => 1,
						'2'                => 2,
						'3'                => 3,
						'4'                => 4,
						'5'                => 5,
						'6'                => 6,
						'7'                => 7,
						'8'                => 8,
						'9'                => 9,
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Maximum Bedrooms', 'easy-real-estate' ),
					'param_name'  => 'max_beds',
					'value'       => array(
						ere_any_text() => null,
						'1'                => 1,
						'2'                => 2,
						'3'                => 3,
						'4'                => 4,
						'5'                => 5,
						'6'                => 6,
						'7'                => 7,
						'8'                => 8,
						'9'                => 9,
						'10'               => 10,
						'11'               => 11,
						'12'               => 12,
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Minimum Bathrooms', 'easy-real-estate' ),
					'param_name'  => 'min_baths',
					'value'       => array(
						ere_any_text() => null,
						'1'                => 1,
						'2'                => 2,
						'3'                => 3,
						'4'                => 4,
						'5'                => 5,
						'6'                => 6,
						'7'                => 7,
						'8'                => 8,
						'9'                => 9,
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Maximum Bathrooms', 'easy-real-estate' ),
					'param_name'  => 'max_baths',
					'value'       => array(
						ere_any_text() => null,
						'1'                => 1,
						'2'                => 2,
						'3'                => 3,
						'4'                => 4,
						'5'                => 5,
						'6'                => 6,
						'7'                => 7,
						'8'                => 8,
						'9'                => 9,
						'10'               => 10,
						'11'               => 11,
						'12'               => 12,
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Minimum Price', 'easy-real-estate' ),
					'description' => esc_html__( 'Only provide digits', 'easy-real-estate' ),
					'param_name'  => 'min_price',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Maximum Price', 'easy-real-estate' ),
					'description' => esc_html__( 'Only provide digits', 'easy-real-estate' ),
					'param_name'  => 'max_price',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Minimum Area', 'easy-real-estate' ),
					'description' => esc_html__( 'Only provide digits', 'easy-real-estate' ),
					'param_name'  => 'min_area',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Maximum Area', 'easy-real-estate' ),
					'description' => esc_html__( 'Only provide digits', 'easy-real-estate' ),
					'param_name'  => 'max_area',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Display Only Featured Properties', 'easy-real-estate' ),
					'param_name'  => 'featured',
					'value'       => array(
						__( 'No', 'easy-real-estate' )  => 'no',
						__( 'Yes', 'easy-real-estate' ) => 'yes',
					),
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Features', 'easy-real-estate' ),
					'param_name'  => 'features',
					'value'       => $features_name_slug_array,
					'admin_label' => true,
				),
			),
		) );
	}

	add_action( 'vc_before_init', 'ere_shortcodes_integration' );

}