<?php
if ( ! function_exists( 'rh_post_meta_boxes' ) ) :
	/**
	 * Contains posts related meta box declarations
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function rh_post_meta_boxes( $meta_boxes ) {

		// Video embed code meta box for video post format.
		$meta_boxes[] = array(
			'id'         => 'video-meta-box',
			'title'      => esc_html__( 'Video Embed Code', 'framework' ),
			'post_types' => array( 'post' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'show'       => array(
				'post_format' => array( 'Video' ), // List of post formats. Array. Case insensitive. Optional.
			),
			'fields'     => array(
				array(
					'name' => esc_html__( 'Video Embed Code', 'framework' ),
					'desc' => esc_html__( 'If you are not using self hosted videos then please provide the video embed code and remove the width and height attributes.', 'framework' ),
					'id'   => "REAL_HOMES_embed_code",
					'type' => 'textarea',
					'cols' => '20',
					'rows' => '3',
					'sanitize_callback' => 'none',
				),
			),
		);

		// Gallery Meta Box.
		$meta_boxes[] = array(
			'id'         => 'gallery-meta-box',
			'title'      => esc_html__( 'Gallery Images', 'framework' ),
			'post_types' => array( 'post' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'show'       => array(
				'post_format' => array( 'Gallery' ), // List of post formats. Array. Case insensitive. Optional.
			),
			'fields'     => array(
				array(
					'name'             => esc_html__( 'Upload Gallery Images', 'framework' ),
					'id'               => "REAL_HOMES_gallery",
					'desc'             => esc_html__( 'Images should have minimum width of 1240px and minimum height of 720px, Bigger size images will be cropped automatically.', 'framework' ),
					'type'             => 'image_advanced',
					'max_file_uploads' => 48,
				),
			),
		);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'rh_post_meta_boxes' );

endif;