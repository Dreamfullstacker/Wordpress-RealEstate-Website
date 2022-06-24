<?php
if ( ! function_exists( 'rh_page_title_meta_boxes' ) ) :
	/**
	 * page title's meta box declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function rh_page_title_meta_boxes( $meta_boxes ) {

			$meta_boxes[] = array(
				'id'         => 'page-title-meta-box',
				'title'      => esc_html__( 'Page Title', 'framework' ),
				'post_types' => array( 'page' ),
				'context'    => 'normal',
				'priority'   => 'low',
				'hide'       => array(
					'template' => array( 'templates/home.php', 'templates/dashboard.php' )
				),
				'fields'     => array(
					array(
						'name'    => esc_html__( 'Page Title Display Status', 'framework' ),
						'id'      => "REAL_HOMES_page_title_display",
						'type'    => 'radio',
						'std'     => 'show',
						'options' => array(
							'show' => esc_html__( 'Show', 'framework' ),
							'hide' => esc_html__( 'Hide', 'framework' ),
						),
					),
				)
			);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'rh_page_title_meta_boxes' );

endif;