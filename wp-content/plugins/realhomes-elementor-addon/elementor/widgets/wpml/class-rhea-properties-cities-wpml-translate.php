<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class RHEA_Properties_Cities_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'rhea_properties_cities_to_translate'
		] );

	}

	public function rhea_properties_cities_to_translate( $widgets ) {
		$widgets['rhea-properties-cities-widget'] = [
			'conditions' => [ 'widgetType' => 'rhea-properties-cities-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_property_singular_label',
					'type'        => esc_html__( 'Properties Cities: Singular Property', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_property_plural_label',
					'type'        => esc_html__( 'Properties Cities: More Than One Properties', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],

			'integration-class' => 'RHEA_Properties_Cities_Repeater_WPML_Translate',
		];

		return $widgets;
	}

}

class RHEA_Properties_Cities_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'rhea_add_city_select';
	}

	public function get_fields() {
		return array( 'rhea_city_label' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_city_label':
				return esc_html__( 'Properties Cities: City Label', 'realhomes-elementor-addon' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'rhea_city_label':
				return 'LINE';

			default:
				return '';
		}
	}

}

new RHEA_Properties_Cities_WPML_Translate();