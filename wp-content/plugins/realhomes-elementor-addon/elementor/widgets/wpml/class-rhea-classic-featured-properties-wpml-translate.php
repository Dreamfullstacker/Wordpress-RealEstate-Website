<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_Featured_Properties_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_classic_featured_properties_to_translate'
		] );

	}

	public function inspiry_classic_featured_properties_to_translate( $widgets ) {

		$widgets['ere-classic-featured-properties-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-classic-featured-properties-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_featured_more_detail_label',
					'type'        => esc_html__( 'Classic Featured Properties: More Details', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_featured_photos_label',
					'type'        => esc_html__( 'Classic Featured Properties: Photos', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_featured_photo_singular_label',
					'type'        => esc_html__( 'Classic Featured Properties: Photo Singular', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_featured_area_postfix_label',
					'type'        => esc_html__( 'Classic Featured Properties: Area Postfix', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_featured_bedrooms_label',
					'type'        => esc_html__( 'Classic Featured Properties: Bedrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_featured_bedroom_singular_label',
					'type'        => esc_html__( 'Classic Featured Properties: Bedroom Singular', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_featured_bathrooms_label',
					'type'        => esc_html__( 'Classic Featured Properties: Bathrooms', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_featured_bathroom_singular_label',
					'type'        => esc_html__( 'Classic Featured Properties: Bathroom Singular', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],
		];

		return $widgets;

	}
}

new RHEA_Classic_Featured_Properties_WPML_Translate();