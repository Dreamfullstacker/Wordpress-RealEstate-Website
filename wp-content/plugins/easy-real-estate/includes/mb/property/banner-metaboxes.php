<?php
/**
 * Add banner metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function ere_banner_metabox_tab( $property_metabox_tabs ) {
	if ( is_array( $property_metabox_tabs ) ) {
		$property_metabox_tabs['banner'] = array(
			'label' => esc_html__( 'Top Banner', 'easy-real-estate' ),
			'icon'  => 'dashicons-format-image',
		);
	}

	return $property_metabox_tabs;
}

add_filter( 'ere_property_metabox_tabs', 'ere_banner_metabox_tab', 100 );


/**
 * Add banner metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function ere_banner_metabox_fields( $property_metabox_fields ) {

	$ere_banner_fields = array(
		array(
			'name'             => esc_html__( 'Top Banner Image', 'easy-real-estate' ),
			'id'               => "REAL_HOMES_page_banner_image",
			'desc'             => esc_html__( 'You can upload banner image specific for this property to override default one. Recommended minimum image size is 2000px by 230px.', 'easy-real-estate' ),
			'type'             => 'image_advanced',
			'max_file_uploads' => 1,
			'columns'          => 12,
			'tab'              => 'banner',
		),
	);

	if ( 'modern' == INSPIRY_DESIGN_VARIATION ) {
		$ere_banner_fields[] =
			array(
				'name'      => esc_html__( 'Hide Search Form in Header ?', 'easy-real-estate' ),
				'id'        => "REAL_HOMES_hide_property_advance_search",
				'type'      => 'switch',
				'style'     => 'square',
				'on_label'  => esc_html__( 'Yes', 'easy-real-estate' ),
				'off_label' => esc_html__( 'No', 'easy-real-estate' ),
				'std'       => 0,
				'columns'   => 8,
				'class'     => 'inspiry_switch_inline',
				'tab'       => 'banner',
			);
	}

	return array_merge( $property_metabox_fields, $ere_banner_fields );

}

add_filter( 'ere_property_metabox_fields', 'ere_banner_metabox_fields', 100 );
