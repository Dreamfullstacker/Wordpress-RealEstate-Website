<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class inspiry_featured_properties_to_translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_featured_properties_to_translate'
		] );

	}

	public function inspiry_featured_properties_to_translate( $widgets ) {

		$widgets['ere-featured-properties-widget'] = [
			'conditions'        => [ 'widgetType' => 'ere-featured-properties-widget' ],
			'fields'            => [
				[
					'field'       => 'ere_property_featured_label',
					'type'        => esc_html__( 'Featured Properties: Featured', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
			],
			'integration-class' => 'RHEA_Featured_Properties_One_Repeater_WPML_Translate',
		];

		return $widgets;

	}
}

class RHEA_Featured_Properties_One_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {
	public function get_items_field() {
		return 'rhea_add_meta_select';
	}

	public function get_fields() {
		return array( 'rhea_meta_repeater_label' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_meta_repeater_label':
				return esc_html__( 'Featured Properties: Meta Label', 'realhomes-elementor-addon' );
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

new inspiry_featured_properties_to_translate();