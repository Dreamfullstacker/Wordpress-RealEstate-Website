<?php
if ( ! function_exists( 'ere_partner_meta_boxes' ) ) :
	/**
	 * Contains partner's meta box declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function ere_partner_meta_boxes( $meta_boxes ) {

		$meta_boxes[] = array(
			'id'         => 'partners-meta-box',
			'title'      => esc_html__( 'Partner Information', 'easy-real-estate' ),
			'post_types' => array( 'partners' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields'     => array(
				array(
					'name' => esc_html__( 'Website URL', 'easy-real-estate' ),
					'id'   => "REAL_HOMES_partner_url",
					'desc' => esc_html__( 'Provide Website URL', 'easy-real-estate' ),
					'type' => 'text',
				),
			),
		);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'ere_partner_meta_boxes' );

endif;