<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Image_Gallery_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_image_gallery_widget_to_translate'
		] );
	}

	public function inspiry_image_gallery_widget_to_translate( $widgets ) {

		$widgets['inspiry-image-gallery-widget'] = [
			'conditions'        => [ 'widgetType' => 'inspiry-image-gallery-widget' ],
			'fields'            => [],
			'integration-class' => 'RHEA_Image_Gallery_Repeater_WPML_Translate',
		];

		return $widgets;
	}
}

class RHEA_Image_Gallery_Repeater_WPML_Translate extends WPML_Elementor_Module_With_Items {

	public function get_items_field() {
		return 'multiple_galleries';
	}

	public function get_fields() {
		return array( 'gallery_title' );
	}

	protected function get_title( $field ) {
		switch ( $field ) {
			case 'gallery_title':
				return esc_html__( 'Image Gallery Widget Item: Title', 'realhomes-elementor-addon' );

			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch ( $field ) {
			case 'gallery_title':
				return 'LINE';

			default:
				return '';
		}
	}

}

new RHEA_Image_Gallery_WPML_Translate();