<?php
/**
 * `Membership` Post Type
 *
 * Class to create `membership` post type.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * IMS_CPT_Membership.
 *
 * Class to create `membership` post type.
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'IMS_CPT_Membership' ) ) :

	class IMS_CPT_Membership {

		/**
		 * Register membership post type.
		 */
		public function register_post_type() {

			if ( post_type_exists( 'ims_membership' ) ) {
				return;
			}

			$labels = array(
				'name'               => esc_html__( 'Memberships', 'inspiry-memberships' ),
				'singular_name'      => esc_html__( 'Membership', 'inspiry-memberships' ),
				'add_new'            => esc_html_x( 'Add New Membership', 'inspiry-memberships', 'inspiry-memberships' ),
				'add_new_item'       => esc_html__( 'Add New Membership', 'inspiry-memberships' ),
				'edit_item'          => esc_html__( 'Edit Membership', 'inspiry-memberships' ),
				'new_item'           => esc_html__( 'New Membership', 'inspiry-memberships' ),
				'view_item'          => esc_html__( 'View Membership', 'inspiry-memberships' ),
				'search_items'       => esc_html__( 'Search Memberships', 'inspiry-memberships' ),
				'not_found'          => esc_html__( 'No Memberships found', 'inspiry-memberships' ),
				'not_found_in_trash' => esc_html__( 'No Memberships found in Trash', 'inspiry-memberships' ),
				'parent_item_colon'  => esc_html__( 'Parent Membership:', 'inspiry-memberships' ),
				'menu_name'          => esc_html__( 'Memberships', 'inspiry-memberships' ),
			);

			$rewrite = array(
				'slug'       => apply_filters( 'ims_membership_post_type_slug', esc_html__( 'membership', 'inspiry-memberships' ) ),
				'with_front' => true,
				'pages'      => true,
				'feeds'      => true,
			);

			$args = array(
				'labels'              => apply_filters( 'ims_membership_post_type_labels', $labels ),
				'hierarchical'        => false,
				'description'         => esc_html__( 'Represents a membership package.', 'inspiry-memberships' ),
				'public'              => false,
				'exclude_from_search' => true,
				'show_ui'             => true,
				'show_in_menu'        => 'inspiry_memberships',
				'show_in_admin_bar'   => true,
				'menu_position'       => 10,
				'menu_icon'           => 'dashicons-smiley',
				'show_in_nav_menus'   => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => false,
				'has_archive'         => true,
				'query_var'           => true,
				'can_export'          => true,
				'rewrite'             => apply_filters( 'ims_membership_post_type_rewrite', $rewrite ),
				'capability_type'     => 'post',
				'supports'            => apply_filters( 'ims_membership_post_type_supports', array( 'title', 'excerpt', 'thumbnail' ) ),
			);

			register_post_type( 'ims_membership', apply_filters( 'ims_membership_post_type_args', $args ) );

			// Membership post type registered action hook.
			do_action( 'ims_membership_post_type_registered' );

		}

		/**
		 * Method: Create custom schedules for memberships.
		 *
		 * @since 2.0.0
		 * @param array $schedules Existing schedules.
		 */
		public function create_schedules( $schedules ) {

			$schedules['weekly'] = array(
				'interval' => 7 * 24 * 60 * 60, // 7 days * 24 hours * 60 minutes * 60 seconds
				'display'  => esc_html__( 'Once Weekly', 'inspiry-memberships' ),
			);

			$schedules['monthly'] = array(
				'interval' => 30 * 24 * 60 * 60, // 30 days * 24 hours * 60 minutes * 60 seconds
				'display'  => esc_html__( 'Once Monthly', 'inspiry-memberships' ),
			);

			$schedules['yearly'] = array(
				'interval' => 365 * 24 * 60 * 60, // 365 days * 24 hours * 60 minutes * 60 seconds
				'display'  => esc_html__( 'Once Yearly', 'inspiry-memberships' ),
			);

			return apply_filters( 'ims_create_crons_scedules', $schedules );

		}
	}

endif;
