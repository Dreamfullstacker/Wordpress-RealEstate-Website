<?php
/**
 * Add video metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function ere_video_metabox_tab( $property_metabox_tabs ) {
	if ( is_array( $property_metabox_tabs ) ) {
		$property_metabox_tabs['video'] = array(
			'label' => esc_html__( 'Property Video', 'easy-real-estate' ),
			'icon'  => 'dashicons-format-video',
		);
	}

	return $property_metabox_tabs;
}

add_filter( 'ere_property_metabox_tabs', 'ere_video_metabox_tab', 50 );


/**
 * Add video metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function ere_video_metabox_fields( $property_metabox_fields ) {

	$ere_video_fields = array(
		array(
			'name'    => esc_html__( 'Add Multiple Videos', 'easy-real-estate' ),
			'id'      => 'inspiry_video_group',
			'type'    => 'group',
			'columns' => 12,
			'clone'   => true,
			'tab'     => 'video',
			'desc'    => esc_html__( 'Provide an image of minimum width 818px and minimum height 417px. Bigger size images will be cropped automatically. Property featured image will be shown if no image is selected.', 'easy-real-estate' ),

			'fields' => array(

				array(
					'name'             => esc_html__( 'Image', 'easy-real-estate' ),
					'id'               => 'inspiry_video_group_image',
					'type'             => 'image_advanced',
					'columns'          => 3,
					'max_file_uploads' => 1,
				),

				array(
					'name'    => esc_html__( 'Title', 'easy-real-estate' ),
					'id'      => 'inspiry_video_group_title',
					'desc'    => esc_html__( 'Title of video', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 3,
				),
				array(
					'name'    => esc_html__( 'URL', 'easy-real-estate' ),
					'id'      => 'inspiry_video_group_url',
					'desc'    => esc_html__( 'Provide virtual tour video URL. YouTube, Vimeo, SWF File and MOV File are supported', 'easy-real-estate' ),
					'type'    => 'text',
					'columns' => 6,
				),

			),
		),
		// Virtual Tour.
		array(
			'type'    => 'divider',
			'columns' => 12,
			'id'      => 'virtual_tour_divider',
			'tab'     => 'video',
		),
		array(
			'name'              => esc_html__( '360 Virtual Tour', 'easy-real-estate' ),
			'id'                => "REAL_HOMES_360_virtual_tour",
			'desc'              => wp_kses( __( 'Provide iframe embed code or <a href="https://wordpress.org/plugins/ipanorama-360-virtual-tour-builder-lite/" target="_blank">iPanorama</a> shortcode for the 360 virtual tour. For more details please consult <a href="https://realhomes.io/documentation/add-property/#add-video-tour-and-virtual-tour" target="_blank">Add Property</a> in documentation.', 'easy-real-estate' ), array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			) ),
			'sanitize_callback' => 'none',
			'type'              => 'textarea',
			'columns'           => 12,
			'tab'               => 'video',
		),
		array(
			'type' => 'divider',
			'tab'  => 'video',
			'id'   => "REAL_HOMES_tour_video_url_divider",
		),
		array(
			'id'      => "REAL_HOMES_tour_video_url",
			'name'    => sprintf( __( 'Virtual Tour Video URL %s * %s', 'easy-real-estate' ), '<span>', '</span>' ),
			'desc'    => sprintf( __( 'Provide virtual tour video URL. YouTube, Vimeo, SWF File and MOV File are supported. %1$s %2$s *This field is deprecated in favour of %4$s Add Multiple Videos %5$s field above , So stop using it %3$s', 'easy-real-estate' ), '<br>', '<span>', '</span>', '<strong>', '</strong>' ),
			'type'    => 'text',
			'columns' => 12,
			'tab'     => 'video',
		),
		array(
			'name'             => sprintf( __( 'Virtual Tour Video Image %s * %s', 'easy-real-estate' ), '<span>', '</span>' ),
			'desc'             => sprintf( __( 'Provide an image of minimum width 818px and minimum height 417px. Bigger size images will be cropped automatically. Property featured image will be shown if no image is selected.
								%1$s %2$s *This field is deprecated in favour of %4$s Add Multiple Videos %5$s field above , So stop using it %3$s', 'easy-real-estate' ), '<br>', '<span>', '</span>', '<strong>', '</strong>' ),
			'id'               => "REAL_HOMES_tour_video_image",
			'type'             => 'image_advanced',
			'max_file_uploads' => 1,
			'columns'          => 12,
			'tab'              => 'video',
		),
	);

	return array_merge( $property_metabox_fields, $ere_video_fields );

}

add_filter( 'ere_property_metabox_fields', 'ere_video_metabox_fields', 50 );
