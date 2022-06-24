<?php
/**
 * `Receipt` Post Type
 *
 * Class to create `receipt` post type.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'IMS_CPT_Receipt' ) ) {
	/**
	 * IMS_CPT_Receipt.
	 *
	 * Class to create `receipt` post type.
	 *
	 * @since 1.0.0
	 */
	class IMS_CPT_Receipt {

		/**
		 * Register Receipt custom post type.
		 */
		public function register() {

			$labels = array(
				'name'               => esc_html__( 'Receipts', 'inspiry-memberships' ),
				'singular_name'      => esc_html__( 'Receipt', 'inspiry-memberships' ),
				'add_new'            => esc_html_x( 'Add New Receipt', 'inspiry-memberships', 'inspiry-memberships' ),
				'add_new_item'       => esc_html__( 'Add New Receipt', 'inspiry-memberships' ),
				'edit_item'          => esc_html__( 'Edit Receipt', 'inspiry-memberships' ),
				'new_item'           => esc_html__( 'New Receipt', 'inspiry-memberships' ),
				'view_item'          => esc_html__( 'View Receipt', 'inspiry-memberships' ),
				'search_items'       => esc_html__( 'Search Receipts', 'inspiry-memberships' ),
				'not_found'          => esc_html__( 'No Receipts found', 'inspiry-memberships' ),
				'not_found_in_trash' => esc_html__( 'No Receipts found in Trash', 'inspiry-memberships' ),
				'parent_item_colon'  => esc_html__( 'Parent Receipt:', 'inspiry-memberships' ),
				'menu_name'          => esc_html__( 'Receipts', 'inspiry-memberships' ),
			);

			$rewrite = array(
				'slug'       => apply_filters( 'ims_receipt_post_type_slug', esc_html__( 'receipt', 'inspiry-memberships' ) ),
				'with_front' => true,
				'pages'      => true,
				'feeds'      => true,
			);

			$args = array(
				'labels'              => apply_filters( 'ims_receipt_post_type_labels', $labels ),
				'hierarchical'        => false,
				'description'         => esc_html__( 'Represents a receipt of membership.', 'inspiry-memberships' ),
				'public'              => true,
				'exclude_from_search' => true,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'menu_position'       => 10,
				'show_in_nav_menus'   => true,
				'publicly_queryable'  => false,
				'has_archive'         => true,
				'query_var'           => true,
				'can_export'          => true,
				'rewrite'             => apply_filters( 'ims_receipt_post_type_rewrite', $rewrite ),
				'capability_type'     => 'post',
				'supports'            => apply_filters( 'ims_receipt_post_type_supports', array( 'title' ) )
			);

			register_post_type( 'ims_receipt', apply_filters( 'ims_receipt_post_type_args', $args ) );

			// Membership post type registered action hook.
			do_action( 'ims_receipt_post_type_registered' );

		}

	}
}
