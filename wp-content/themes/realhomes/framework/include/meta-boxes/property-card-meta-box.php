<?php
if ( ! function_exists( 'rh_property_card_meta_boxes' ) ) :
	/**
	 * Property card's meta box declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function rh_property_card_meta_boxes( $meta_boxes ) {

		$meta_boxes[] = array(
			'id'         => 'property-card-meta-box',
			'title'      => esc_html__( 'Grid Layout', 'framework' ),
			'post_types' => array( 'page' ),
			'context'    => 'normal',
			'priority'   => 'low',
			'show'       => array(
				'template' => array( 'templates/grid-layout.php', 'templates/grid-layout-full-width.php' )
			),
			'fields'     => array(
				array(
					'name'    => esc_html__( 'Property Card Design', 'framework' ),
					'desc'    => esc_html__( 'Default is the selected design from Templates & Archives customizer setting', 'framework' ),
					'id'      => "inspiry-property-card-meta-box",
					'type'    => 'select',
					'std'     => 'default',
					'options' => array(
						'default' => esc_html__( 'Default', 'framework' ),
						'1'       => esc_html__( 'One', 'framework' ),
						'2'       => esc_html__( 'Two', 'framework' ),
						'3'       => esc_html__( 'Three', 'framework' ),
					),
				),
			)
		);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'rh_property_card_meta_boxes' );

endif;