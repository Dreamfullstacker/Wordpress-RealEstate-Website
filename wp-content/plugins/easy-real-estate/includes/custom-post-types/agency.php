<?php
/**
 * Agency Custom Post Type
 */

if ( ! function_exists( 'ere_register_agency_post_type' ) ) {
	/**
	 * Register Custom Post Type : Agency
	 */
	function ere_register_agency_post_type() {

		$labels = array(
			'name'                  => esc_html_x( 'Agencies', 'Post Type General Name', 'easy-real-estate' ),
			'singular_name'         => esc_html_x( 'Agency', 'Post Type Singular Name', 'easy-real-estate' ),
			'menu_name'             => esc_html__( 'Agencies', 'easy-real-estate' ),
			'name_admin_bar'        => esc_html__( 'Agency', 'easy-real-estate' ),
			'archives'              => esc_html__( 'Agency Archives', 'easy-real-estate' ),
			'attributes'            => esc_html__( 'Agency Attributes', 'easy-real-estate' ),
			'parent_item_colon'     => esc_html__( 'Parent Agency:', 'easy-real-estate' ),
			'all_items'             => esc_html__( 'All Agencies', 'easy-real-estate' ),
			'add_new_item'          => esc_html__( 'Add New Agency', 'easy-real-estate' ),
			'add_new'               => esc_html__( 'Add New', 'easy-real-estate' ),
			'new_item'              => esc_html__( 'New Agency', 'easy-real-estate' ),
			'edit_item'             => esc_html__( 'Edit Agency', 'easy-real-estate' ),
			'update_item'           => esc_html__( 'Update Agency', 'easy-real-estate' ),
			'view_item'             => esc_html__( 'View Agency', 'easy-real-estate' ),
			'view_items'            => esc_html__( 'View Agencies', 'easy-real-estate' ),
			'search_items'          => esc_html__( 'Search Agency', 'easy-real-estate' ),
			'not_found'             => esc_html__( 'Not found', 'easy-real-estate' ),
			'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'easy-real-estate' ),
			'featured_image'        => esc_html__( 'Agency Logo Image', 'easy-real-estate' ),
			'set_featured_image'    => esc_html__( 'Set agency logo image', 'easy-real-estate' ),
			'remove_featured_image' => esc_html__( 'Remove agency logo image', 'easy-real-estate' ),
			'use_featured_image'    => esc_html__( 'Use as agency logo image', 'easy-real-estate' ),
			'insert_into_item'      => esc_html__( 'Insert into agency', 'easy-real-estate' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this agency', 'easy-real-estate' ),
			'items_list'            => esc_html__( 'Agencies list', 'easy-real-estate' ),
			'items_list_navigation' => esc_html__( 'Agencies list navigation', 'easy-real-estate' ),
			'filter_items_list'     => esc_html__( 'Filter agencies list', 'easy-real-estate' ),
		);
		$args   = array(
			'label'               => esc_html__( 'Agency', 'easy-real-estate' ),
			'description'         => esc_html__( 'An agency is a company of realtors.', 'easy-real-estate' ),
			'labels'              => $labels,
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			'rewrite'             => array(
				'slug' => apply_filters( 'inspiry_agency_slug', esc_html__( 'agency', 'easy-real-estate' ) ),
			),
			'show_in_rest'        => true,
			'rest_base'           => apply_filters( 'inspiry_agency_rest_base', esc_html__( 'agencies', 'easy-real-estate' ) )
		);

		// Filter the arguments to register agency post type.
		$args = apply_filters( 'inspiry_agency_post_type_args', $args );
		register_post_type( 'agency', $args );

	}

	add_action( 'init', 'ere_register_agency_post_type', 0 );

}


if ( ! function_exists( 'ere_set_agency_slug' ) ) {
	/**
	 * This function set agency's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing slug.
	 *
	 * @return string
	 */
	function ere_set_agency_slug( $existing_slug ) {
		$new_slug = get_option( 'inspiry_agency_slug' );
		if ( ! empty( $new_slug ) ) {
			return $new_slug;
		}

		return $existing_slug;
	}

	add_filter( 'inspiry_agency_slug', 'ere_set_agency_slug' );
}


if ( ! function_exists( 'ere_agency_edit_columns' ) ) {
	/**
	 * Custom columns for agencies.
	 *
	 * @param array $columns - Columns array.
	 *
	 * @return array
	 */
	function ere_agency_edit_columns( $columns ) {

		$columns = array(
			'cb'               => '<input type="checkbox" />',
			'title'            => esc_html__( 'Agency', 'easy-real-estate' ),
			'agency-thumbnail' => esc_html__( 'Thumbnail', 'easy-real-estate' ),
			'total_properties' => esc_html__( 'Total Properties', 'easy-real-estate' ),
			'published'        => esc_html__( 'Published Properties', 'easy-real-estate' ),
			'others'           => esc_html__( 'Other Properties', 'easy-real-estate' ),
			'date'             => esc_html__( 'Created', 'easy-real-estate' ),
		);

		/**
		 * WPML Support
		 */
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			global $sitepress;
			$wpml_columns = new WPML_Custom_Columns( $sitepress );
			$columns      = $wpml_columns->add_posts_management_column( $columns );
		}

		/**
		 * Reverse the array for RTL
		 */
		if ( is_rtl() ) {
			$columns = array_reverse( $columns );
		}

		return $columns;
	}

	add_filter( 'manage_edit-agency_columns', 'ere_agency_edit_columns' );
}


if ( ! function_exists( 'ere_agency_custom_columns' ) ) {

	/**
	 * Custom column values for agency post type.
	 *
	 * @param string $column - Name of the column.
	 * @param int $agency_id - ID of the current agency.
	 *
	 */
	function ere_agency_custom_columns( $column, $agency_id ) {

		// Switch cases against column names.
		switch ( $column ) {
			case 'agency-thumbnail':
				if ( has_post_thumbnail( $agency_id ) ) {
					?>
					<a href="<?php the_permalink(); ?>" target="_blank">
						<?php the_post_thumbnail( array( 130, 130 ) ); ?>
					</a>
					<?php
				} else {
					esc_html_e( 'No Thumbnail', 'easy-real-estate' );
				}
				break;
			// Total properties.
			case 'total_properties':
				$listed_properties = ere_get_agency_properties_count( $agency_id );
				echo ( ! empty( $listed_properties ) ) ? esc_html( $listed_properties ) : 0;
				break;
			// Total published properties.
			case 'published':
				$published_properties = ere_get_agency_properties_count( $agency_id, 'publish' );
				echo ( ! empty( $published_properties ) ) ? esc_html( $published_properties ) : 0;
				break;
			// Other properties.
			case 'others':
				$property_status   = array( 'pending', 'draft', 'private', 'future' );
				$others_properties = ere_get_agency_properties_count( $agency_id, $property_status );
				echo ( ! empty( $others_properties ) ) ? esc_html( $others_properties ) : 0;
				break;
			default:
				break;
		}
	}

	add_action( 'manage_agency_posts_custom_column', 'ere_agency_custom_columns', 10, 2 );
}