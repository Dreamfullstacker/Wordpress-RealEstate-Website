<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Icon_List_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_icon_list_widget_to_translate'
		] );
	}

	public function inspiry_icon_list_widget_to_translate( $widgets ) {

		$widgets['inspiry-icon-list-widget'] = [
			'conditions'        => [ 'widgetType' => 'inspiry-icon-list-widget' ],
			'fields'            => [],
			'integration-class' => 'RHEA_Icon_List_Repeater_WPML_Translate',
		];

		return $widgets;
	}
}

class RHEA_Icon_List_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'icon_list';
	}

	public function get_fields() {
		return array( 'text', 'text_right', 'selected_icon', 'link' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'text':
				return esc_html__( 'Icon List Widget Item: First Field Text', 'realhomes-elementor-addon' );

			case 'text_right':
				return esc_html__( 'Icon List Widget Item: Second Field Text', 'realhomes-elementor-addon' );

			case 'link':
				return esc_html__( 'Icon List Widget Item: Link', 'realhomes-elementor-addon' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'text':
			case 'text_right':
				return 'LINE';
			case 'link':
				return 'LINK';
			default:
				return '';
		}
	}

}

new RHEA_Icon_List_WPML_Translate();