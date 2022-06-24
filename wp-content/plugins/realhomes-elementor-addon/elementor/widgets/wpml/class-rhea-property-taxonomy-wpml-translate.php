<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Property_Taxonomy_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_property_taxonomy_widget_to_translate'
		] );
	}

	public function inspiry_property_taxonomy_widget_to_translate( $widgets ) {

		$widgets['rhea-property-taxonomy-widget'] = [
			'conditions'        => [ 'widgetType' => 'rhea-property-taxonomy-widget' ],
			'fields'            => [
				[
					'field'       => 'term_custom_name',
					'type'        => esc_html__( 'Property Taxonomy Widget: Term Custom Name', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_singular_label',
					'type'        => esc_html__( 'Property Taxonomy Widget: Property Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'property_plural_label',
					'type'        => esc_html__( 'Property Taxonomy Widget: Properties Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'description',
					'type'        => esc_html__( 'Property Taxonomy Widget: Term Custom Description', 'realhomes-elementor-addon' ),
					'editor_type' => 'AREA'
				],
			],
		];

		return $widgets;
	}
}

new RHEA_Property_Taxonomy_WPML_Translate();