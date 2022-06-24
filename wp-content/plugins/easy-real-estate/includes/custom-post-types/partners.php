<?php
/**
 * Partners Custom Post Type
 */

if ( ! function_exists( 'ere_register_partners_post_type' ) ) {

	function ere_register_partners_post_type() {

		$partner_post_type_labels = array(
			'name'               => esc_html__( 'Partners', 'easy-real-estate' ),
			'singular_name'      => esc_html__( 'Partner', 'easy-real-estate' ),
			'add_new'            => esc_html__( 'Add New', 'easy-real-estate' ),
			'add_new_item'       => esc_html__( 'Add New Partner', 'easy-real-estate' ),
			'edit_item'          => esc_html__( 'Edit Partner', 'easy-real-estate' ),
			'new_item'           => esc_html__( 'New Partner', 'easy-real-estate' ),
			'view_item'          => esc_html__( 'View Partner', 'easy-real-estate' ),
			'search_items'       => esc_html__( 'Search Partner', 'easy-real-estate' ),
			'not_found'          => esc_html__( 'No Partner found', 'easy-real-estate' ),
			'not_found_in_trash' => esc_html__( 'No Partner found in Trash', 'easy-real-estate' ),
			'parent_item_colon'  => '',
		);

		$partner_post_type_args = array(
			'labels'              => apply_filters( 'inspiry_partner_post_type_labels', $partner_post_type_labels ),
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'query_var'           => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-groups',
			'menu_position'       => 5,
			'exclude_from_search' => true,
			'supports'            => array( 'title', 'thumbnail' ),
			'rewrite'             => array(
				'slug' => __( 'partners', 'easy-real-estate' ),
			),
			'show_in_rest'        => true,
			'rest_base'           => apply_filters( 'inspiry_partner_rest_base', esc_html__( 'partners', 'easy-real-estate' ) )
		);

		// Filter the arguments to register partners post type.
		$partner_post_type_args = apply_filters( 'inspiry_partner_post_type_args', $partner_post_type_args );
		register_post_type( 'partners', $partner_post_type_args );
	}

	add_action( 'init', 'ere_register_partners_post_type' );
}


if ( ! function_exists( 'ere_partners_edit_columns' ) ) {

	/**
	 * Add Custom Columns.
	 *
	 * @param  array $columns - Array of columns.
	 *
	 * @return array
	 */
	function ere_partners_edit_columns( $columns ) {
		$columns = array(
			'cb'            => '<input type="checkbox" />',
			'title'         => esc_html__( 'Partner', 'easy-real-estate' ),
			'partner-thumb' => esc_html__( 'Logo', 'easy-real-estate' ),
			'date'          => esc_html__( 'Publish Time', 'easy-real-estate' ),
		);

		return $columns;
	}

	add_filter( 'manage_edit-partners_columns', 'ere_partners_edit_columns' );
}


if ( ! function_exists( 'ere_partners_custom_columns' ) ) {

	/**
	 * Content for Custom Columns.
	 *
	 * @param  array $column - Content of columns.
	 */
	function ere_partners_custom_columns( $column ) {
		global $post;
		switch ( $column ) {
			case 'partner-thumb':
				if ( has_post_thumbnail( $post->ID ) ) {
					the_post_thumbnail( 'partners-logo' );
				} else {
					esc_html_e( 'No logo provided', 'easy-real-estate' );
				}
				break;
		}
	}
	add_action( 'manage_posts_custom_column', 'ere_partners_custom_columns' );
}
