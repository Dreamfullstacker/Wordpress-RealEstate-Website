<?php
if ( ! function_exists( 'ere_properties_filter_meta_boxes' ) ) :
	/**
	 * Contains properties filter meta boxes declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function ere_properties_filter_meta_boxes( $meta_boxes ) {

		// removed first element and got the whole remaining array with preserved keys as we do not need 'None' in agents list.
		$agents_for_pages = array_slice( ere_get_agents_array(), 1, null, true );

		$meta_boxes[] = array(
			'id'         => 'properties-list-meta-box',
			'title'      => esc_html__( 'Properties Filter Settings', 'easy-real-estate' ),
			'post_types' => array( 'page' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'show'       => array(
				'template' => array(
					'templates/list-layout.php',
					'templates/list-layout-full-width.php',
					'templates/grid-layout.php',
					'templates/grid-layout-full-width.php',
					'templates/half-map-layout.php',
				),
			),
			'fields'     => array(
				array(
					'id'      => 'inspiry_posts_per_page',
					'name'    => esc_html__( 'Number of Properties Per Page', 'easy-real-estate' ),
					'type'    => 'number',
					'step'    => '1',
					'min'     => 1,
					'std'     => 6,
					'columns' => 6,
				),
				array(
					'id'       => 'inspiry_properties_order',
					'name'     => esc_html__( 'Order Properties By', 'easy-real-estate' ),
					'type'     => 'select',
					'options'  => array(
						'default'    => esc_html__( 'Global Default', 'easy-real-estate' ),
						'date-desc'  => esc_html__( 'Date New to Old', 'easy-real-estate' ),
						'date-asc'   => esc_html__( 'Date Old to New', 'easy-real-estate' ),
						'price-asc'  => esc_html__( 'Price Low to High', 'easy-real-estate' ),
						'price-desc' => esc_html__( 'Price High to Low', 'easy-real-estate' ),
					),
					'multiple' => false,
					'std'      => 'default',
					'columns'  => 6,
				),
				array(
					'id'              => 'inspiry_properties_locations',
					'name'            => esc_html__( 'Locations', 'easy-real-estate' ),
					'type'            => 'select',
					'options'         => ERE_Data::get_locations_slug_name( true ),
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'              => 'inspiry_properties_statuses',
					'name'            => esc_html__( 'Statuses', 'easy-real-estate' ),
					'type'            => 'select',
					'options'         => ERE_Data::get_statuses_slug_name(),
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'              => 'inspiry_properties_types',
					'name'            => esc_html__( 'Types', 'easy-real-estate' ),
					'type'            => 'select',
					'options'         => ERE_Data::get_types_slug_name(),
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'              => 'inspiry_properties_features',
					'name'            => esc_html__( 'Features', 'easy-real-estate' ),
					'type'            => 'select',
					'options'         => ERE_Data::get_features_slug_name(),
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'      => 'inspiry_properties_min_beds',
					'name'    => esc_html__( 'Minimum Beds', 'easy-real-estate' ),
					'type'    => 'number',
					'step'    => 'any',
					'min'     => 0,
					'std'     => 0,
					'columns' => 6,
				),
				array(
					'id'      => 'inspiry_properties_min_baths',
					'name'    => esc_html__( 'Minimum Baths', 'easy-real-estate' ),
					'type'    => 'number',
					'step'    => 'any',
					'min'     => 0,
					'std'     => 0,
					'columns' => 6,
				),
				array(
					'id'      => 'inspiry_properties_min_price',
					'name'    => esc_html__( 'Minimum Price', 'easy-real-estate' ),
					'type'    => 'number',
					'step'    => 'any',
					'min'     => 0,
					'std'     => 0,
					'columns' => 6,
				),
				array(
					'id'      => 'inspiry_properties_max_price',
					'name'    => esc_html__( 'Maximum Price', 'easy-real-estate' ),
					'type'    => 'number',
					'step'    => 'any',
					'min'     => 0,
					'std'     => 0,
					'columns' => 6,
				),
				array(
					'name'            => esc_html__( 'Properties by Agents', 'easy-real-estate' ),
					'id'              => 'inspiry_properties_by_agents',
					'type'            => 'select',
					'options'         => $agents_for_pages,
					'multiple'        => true,
					'select_all_none' => true,
					'columns'         => 6,
				),
				array(
					'id'        => 'inspiry_featured_properties_only',
					'name'      => esc_html__( 'Display Only Featured Properties', 'easy-real-estate' ),
					'type'      => 'switch',
					'style'     => 'square',
					'on_label'  => esc_html__( 'Yes', 'easy-real-estate' ),
					'off_label' => esc_html__( 'No', 'easy-real-estate' ),
					'std'       => 0,
					'columns'   => 6,
				),
			),
		);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'ere_properties_filter_meta_boxes' );

endif;


if ( ! function_exists( 'ere_gallery_properties_filter_meta_boxes' ) ) :
	/**
	 * Contains partner's meta box declaration
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function ere_gallery_properties_filter_meta_boxes( $meta_boxes ) {

		$meta_boxes[] = array(
			'id'         => 'properties-gallery-meta-box',
			'title'      => esc_html__( 'Properties Gallery Filter Settings', 'easy-real-estate' ),
			'post_types' => array( 'page' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'show'       => array(
				'template' => array(
					'templates/2-columns-gallery.php',
					'templates/3-columns-gallery.php',
					'templates/4-columns-gallery.php',
				),
			),
			'fields'     => array(
				array(
					'id'   => 'inspiry_gallery_posts_per_page',
					'name' => esc_html__( 'Number of Properties Per Page', 'easy-real-estate' ),
					'type' => 'number',
					'step' => '1',
					'min'  => 1,
					'std'  => 6,
					'columns' => 12,
				),
				array(
					'id'              => 'inspiry_gallery_properties_locations',
					'name'            => esc_html__( 'Locations', 'easy-real-estate' ),
					'type'            => 'select',
					'options'         => ERE_Data::get_locations_slug_name( true ),
					'multiple'        => true,
					'select_all_none' => true,
					'columns' => 6,
				),
				array(
					'id'              => 'inspiry_gallery_properties_statuses',
					'name'            => esc_html__( 'Statuses', 'easy-real-estate' ),
					'type'            => 'select',
					'options'         => ERE_Data::get_statuses_slug_name(),
					'multiple'        => true,
					'select_all_none' => true,
					'columns' => 6,
				),
				array(
					'id'              => 'inspiry_gallery_properties_types',
					'name'            => esc_html__( 'Types', 'easy-real-estate' ),
					'type'            => 'select',
					'options'         => ERE_Data::get_types_slug_name(),
					'multiple'        => true,
					'select_all_none' => true,
					'columns' => 6,
				),
				array(
					'id'              => 'inspiry_gallery_properties_features',
					'name'            => esc_html__( 'Features', 'easy-real-estate' ),
					'type'            => 'select',
					'options'         => ERE_Data::get_features_slug_name(),
					'multiple'        => true,
					'select_all_none' => true,
					'columns' => 6,
				),
			),
		);

		return $meta_boxes;

	}

	add_filter( 'rwmb_meta_boxes', 'ere_gallery_properties_filter_meta_boxes' );

endif;