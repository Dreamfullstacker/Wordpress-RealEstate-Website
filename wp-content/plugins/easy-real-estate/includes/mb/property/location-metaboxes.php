<?php
/**
 * Add Location metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function ere_location_metabox_tab( $property_metabox_tabs ) {
	if ( is_array( $property_metabox_tabs ) ) {
		$property_metabox_tabs['map-location'] = array(
			'label' => esc_html__( 'Location on Map', 'easy-real-estate' ),
			'icon'  => 'dashicons-location',
		);
	}

	return $property_metabox_tabs;
}
add_filter( 'ere_property_metabox_tabs', 'ere_location_metabox_tab', 20 );


/**
 * Add Location metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function ere_location_metabox_fields( $property_metabox_fields ) {

	$ere_location_fields = array(
		array(
			'id'            => "REAL_HOMES_property_location",
			'name'          => esc_html__( 'Property Location on Map', 'easy-real-estate' ),
			'desc'          => esc_html__( 'Drag the map marker to point property location. Address field given above can be used to search location.', 'easy-real-estate' ),
			'type'          => ere_metabox_map_type(),
			'api_key'       => ere_get_google_maps_api_key(),
			'std'           => get_option( 'theme_submit_default_location', '25.7308309,-80.44414899999998' ),
			'zoom'          => 14,
			'style'         => 'width: 95%; height: 400px',
			'address_field' => "REAL_HOMES_property_address",
			'columns'       => 12,
			'tab'           => 'map-location',
		),
		array(
			'id'      => "REAL_HOMES_property_address",
			'name'    => esc_html__( 'Property Address', 'easy-real-estate' ),
			'desc'    => esc_html__( 'Leaving it empty will hide the map on property detail page.', 'easy-real-estate' ),
			'type'    => 'text',
			'std'     => get_option( 'theme_submit_default_address' ),
			'columns' => 12,
			'tab'     => 'map-location',
		),
		array(
			'name'    => esc_html__( 'Hide map on property detail page and listings lightbox?', 'easy-real-estate' ),
			'id'      => "REAL_HOMES_property_map",
			'type'    => 'radio',
			'std'     => '0',
			'options' => array(
				'1' => esc_html__( 'Yes', 'easy-real-estate' ),
				'0' => esc_html__( 'No', 'easy-real-estate' ),
			),
			'columns' => 12,
			'tab'     => 'map-location',
		),
	);

	return array_merge( $property_metabox_fields, $ere_location_fields );

}
add_filter( 'ere_property_metabox_fields', 'ere_location_metabox_fields', 20 );
