<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Featured_Properties_Three_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_featured_properties_three_to_translate'
		] );

	}
	public function inspiry_featured_properties_three_to_translate( $widgets ) {

		$widgets['ere-featured-properties-two-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-featured-properties-three-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_property_features_label',
					'type'        => esc_html__( 'Featured Properties Three: Featured', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_fav_label',
					'type'        => esc_html__( 'Featured Properties Three: Add To Favourite', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_fav_added_label',
					'type'        => esc_html__( 'Featured Properties Three: Added To Favourite', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_compare_label',
					'type'        => esc_html__( 'Featured Properties Three: Add To Compare', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_compare_added_label',
					'type'        => esc_html__( 'Featured Properties Three: Added To Compare', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
			'integration-class' => 'RHEA_Featured_Properties_Three_Repeater_WPML_Translate',
		];

		return $widgets;

	}
}
class RHEA_Featured_Properties_Three_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {
	public function get_items_field() {
		return 'rhea_add_meta_select';
	}

	public function get_fields() {
		return array( 'rhea_meta_repeater_label' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_meta_repeater_label':
				return esc_html__( 'Featured Properties Three: Meta Label', 'realhomes-elementor-addon' );
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

new RHEA_Featured_Properties_Three_WPML_Translate();