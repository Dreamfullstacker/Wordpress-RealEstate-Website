<?php
/**
 * Agent Custom Post Type
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'ere_register_agent_post_type' ) ) {

	function ere_register_agent_post_type() {

		if ( post_type_exists( 'agent' ) ) {
			return;
		}

		$agent_post_type_labels = array(
			'name'               => esc_html__( 'Agents', 'easy-real-estate' ),
			'singular_name'      => esc_html__( 'Agent', 'easy-real-estate' ),
			'add_new'            => esc_html__( 'Add New', 'easy-real-estate' ),
			'add_new_item'       => esc_html__( 'Add New Agent', 'easy-real-estate' ),
			'edit_item'          => esc_html__( 'Edit Agent', 'easy-real-estate' ),
			'new_item'           => esc_html__( 'New Agent', 'easy-real-estate' ),
			'view_item'          => esc_html__( 'View Agent', 'easy-real-estate' ),
			'search_items'       => esc_html__( 'Search Agent', 'easy-real-estate' ),
			'not_found'          => esc_html__( 'No Agent found', 'easy-real-estate' ),
			'not_found_in_trash' => esc_html__( 'No Agent found in Trash', 'easy-real-estate' ),
			'parent_item_colon'  => '',
		);

		$agent_post_type_args = array(
			'labels'              => apply_filters( 'inspiry_agent_post_type_labels', $agent_post_type_labels ),
			'public'              => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => true,
			'query_var'           => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-businessman',
			'menu_position'       => 5,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			'rewrite'             => array(
				'slug' => apply_filters( 'inspiry_agent_slug', esc_html__( 'agent', 'easy-real-estate' ) ),
			),
			'show_in_rest'        => true,
			'rest_base'           => apply_filters( 'inspiry_agent_rest_base', esc_html__( 'agents', 'easy-real-estate' ) )
		);

		// Filter the arguments to register agent post type.
		$agent_post_type_args = apply_filters( 'inspiry_agent_post_type_args', $agent_post_type_args );
		register_post_type( 'agent', $agent_post_type_args );
	}

	add_action( 'init', 'ere_register_agent_post_type' );
}


if ( ! function_exists( 'ere_set_agent_slug' ) ) :
	/**
	 * This function set agent's url slug by hooking itself with related filter
	 *
	 * @param string $existing_slug - Existing slug.
	 *
	 * @return string
	 */
	function ere_set_agent_slug( $existing_slug ) {
		$new_slug = get_option( 'inspiry_agent_slug' );
		if ( ! empty( $new_slug ) ) {
			return $new_slug;
		}

		return $existing_slug;
	}

	add_filter( 'inspiry_agent_slug', 'ere_set_agent_slug' );
endif;


if ( ! function_exists( 'ere_agent_edit_columns' ) ) {
	/**
	 * Custom columns for agents.
	 *
	 * @param array $columns - Columns array.
	 *
	 * @return array
	 */
	function ere_agent_edit_columns( $columns ) {

		$columns = array(
			'cb'               => '<input type="checkbox" />',
			'title'            => esc_html__( 'Agent', 'easy-real-estate' ),
			'agent-thumbnail'  => esc_html__( 'Thumbnail', 'easy-real-estate' ),
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

	add_filter( 'manage_edit-agent_columns', 'ere_agent_edit_columns' );
}


if ( ! function_exists( 'ere_agent_custom_columns' ) ) {

	/**
	 * Custom column values for agent post type.
	 *
	 * @param string $column - Name of the column.
	 * @param int $agent_id  - ID of the current agent.
	 *
	 * @since 3.3.0
	 */
	function ere_agent_custom_columns( $column, $agent_id ) {

		// Switch cases against column names.
		switch ( $column ) {
			case 'agent-thumbnail':
				if ( has_post_thumbnail( $agent_id ) ) {
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
				$listed_properties = ere_get_agent_properties_count( $agent_id );
				echo ( ! empty( $listed_properties ) ) ? esc_html( $listed_properties ) : 0;
				break;
			// Total properties.
			case 'published':
				$published_properties = ere_get_agent_properties_count( $agent_id, 'publish' );
				echo ( ! empty( $published_properties ) ) ? esc_html( $published_properties ) : 0;
				break;
			// Published properties.
			case 'others':
				$property_status   = array( 'pending', 'draft', 'private', 'future' );
				$others_properties = ere_get_agent_properties_count( $agent_id, $property_status );
				echo ( ! empty( $others_properties ) ) ? esc_html( $others_properties ) : 0;
				break;
			// Other properties.
			default:
				break;
		}
	}

	add_action( 'manage_agent_posts_custom_column', 'ere_agent_custom_columns', 10, 2 );
}
