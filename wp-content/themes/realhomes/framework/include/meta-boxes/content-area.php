<?php


if ( ! function_exists( 'rh_content_area_meta_boxes' ) ) {

	function rh_content_area_meta_boxes($meta_boxes){


		$show_for_content = array(
			'template'        => array(
				'templates/2-columns-gallery.php' ,
				'templates/3-columns-gallery.php' ,
				'templates/4-columns-gallery.php' ,
				'templates/agencies-list.php' ,
				'templates/agents-list.php' ,
				'templates/compare-properties.php' ,
				'templates/contact.php' ,
				'templates/favorites.php' ,
				'templates/grid-layout.php' ,
				'templates/grid-layout-full-width.php' ,
				'templates/half-map-layout.php' ,
				'templates/list-layout.php' ,
				'templates/list-layout-full-width.php' ,
				'templates/properties-search.php' ,
				'templates/properties-search-half-map.php' ,
				'templates/properties-search-left-sidebar.php' ,
				'templates/properties-search-right-sidebar.php' ,
				'templates/submit-property.php' ,
			),
		);

		if(INSPIRY_DESIGN_VARIATION == 'modern') {
			$show_for_spacing = array(
				'template' => array(
					'',
					'templates/2-columns-gallery.php',
					'templates/3-columns-gallery.php',
					'templates/4-columns-gallery.php',
					'templates/agencies-list.php',
					'templates/agents-list.php',
					'templates/compare-properties.php',
					'templates/contact.php',
					'templates/favorites.php',
					'templates/grid-layout.php',
					'templates/grid-layout-full-width.php',
					'templates/half-map-layout.php',
					'templates/list-layout.php',
					'templates/list-layout-full-width.php',
					'templates/properties-search.php',
					'templates/properties-search-half-map.php',
					'templates/properties-search-left-sidebar.php',
					'templates/properties-search-right-sidebar.php',
					'templates/submit-property.php',
					'templates/full-width.php',
					'templates/fluid-width.php',
				),
			);
		} else {
			$show_for_spacing = array(
				'template' => array(
					'',
					'templates/full-width.php',
					'templates/fluid-width.php',
				),
			);
		}

		$meta_boxes[] = array(
			'id'         => 'content-position-meta-box',
			'title'      => esc_html__( 'Content Area', 'framework' ),
			'post_types' => array( 'page' ),
			'show' =>   $show_for_content,
			'context'    => 'normal',
			'priority'   => 'low',
			'fields'     => array(
				array(
					'name' => esc_html__( 'Display Content Above Footer?', 'framework' ),
					'id'   => 'REAL_HOMES_content_area_above_footer',
					'type'      => 'switch',
					'style'     => 'square',
					'on_label'  => esc_html__( 'Yes', 'framework' ),
					'off_label' => esc_html__( 'No', 'framework' ),
					'std'       => 0,
					'columns'   => 8,
					'class'     => 'inspiry_switch_inline'
				),
			),
		);

		if(INSPIRY_DESIGN_VARIATION == 'modern') {

			$meta_boxes[] = array(
				'id'         => 'page-spacing-meta-box',
				'title'      => esc_html__( 'Spacing', 'framework' ),
				'post_types' => array( 'page' ),
				'show'       => $show_for_spacing,
				'context'    => 'normal',
				'priority'   => 'low',
				'fields'     => array(
					array(
						'name' => esc_html__( 'Remove page’s top and bottom spacing', 'framework' ),
						'id'   => 'REAL_HOMES_page_top_bottom_padding_nil',
						'type'      => 'switch',
						'style'     => 'square',
						'on_label'  => esc_html__( 'Yes', 'framework' ),
						'off_label' => esc_html__( 'No', 'framework' ),
						'std'       => 0,
						'columns'   => 8,
						'class'     => 'inspiry_switch_inline'
					),
					array(
						'name' => esc_html__( 'Remove Content Area Padding?', 'framework' ),
						'id'   => 'REAL_HOMES_content_area_padding_nil',
						'type'      => 'switch',
						'style'     => 'square',
						'on_label'  => esc_html__( 'Yes', 'framework' ),
						'off_label' => esc_html__( 'No', 'framework' ),
						'std'       => 0,
						'columns'   => 8,
						'class'     => 'inspiry_switch_inline'
					),
				),
			);

		}

		if(INSPIRY_DESIGN_VARIATION == 'classic') {
			$meta_boxes[] = array(
				'id'         => 'page-spacing-meta-box',
				'title'      => esc_html__( 'Spacing', 'framework' ),
				'post_types' => array( 'page' ),
				'show'       => $show_for_spacing,
				'context'    => 'normal',
				'priority'   => 'low',
				'fields'     => array(
					array(
						'name' => esc_html__( 'Remove Content Area Padding?', 'framework' ),
						'desc' => esc_html__( 'Yes', 'framework' ),
						'id'   => 'REAL_HOMES_content_area_padding_nil',
						'type' => 'checkbox',
						'std'  => 0,
					),
				),
			);
		}

		return $meta_boxes;
	}

	add_filter( 'rwmb_meta_boxes', 'rh_content_area_meta_boxes' );

}