<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Inquiry_Form_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'rhea_inquiry_form_to_translate'
		] );

	}

	public function rhea_inquiry_form_to_translate( $widgets ) {
		$widgets['rhea-inquiry-form'] = [
			'conditions' => [ 'widgetType' => 'rhea-inquiry-form' ],
			'fields'     => [
				[
					'field'       => 'rhea_submit_text',
					'type'        => esc_html__( 'Inquiry Form: Submit Button', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],

			'integration-class' => 'RHEA_Inquiry_Form_Repeater_WPML_Translate',
		];

		return $widgets;
	}

}

class RHEA_Inquiry_Form_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'rhea_add_field_select';
	}

	public function get_fields() {
		return array( 'rhea_field_label', 'rhea_field_placeholder', 'rhea_error_message' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'rhea_field_label':
				return esc_html__( 'Inquiry Form: Field Label', 'realhomes-elementor-addon' );
			case 'rhea_field_placeholder':
				return esc_html__( 'Inquiry Form: Field Placeholder', 'realhomes-elementor-addon' );
			case 'rhea_error_message':
				return esc_html__( 'Inquiry Form: Error Message', 'realhomes-elementor-addon' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'rhea_field_label':
			case 'rhea_field_placeholder':
			case 'rhea_error_message':
				return 'LINE';

			default:
				return '';
		}
	}

}

new RHEA_Inquiry_Form_WPML_Translate();