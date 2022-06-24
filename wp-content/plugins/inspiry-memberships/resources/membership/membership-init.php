<?php
/**
 * Membership initialization file
 *
 * This file initializes all the related functionality of memberships.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Membership Custom Post Type.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/membership/class-ims-cpt-membership.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/membership/class-ims-cpt-membership.php';
}

/**
 * Membership Meta boxes.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/membership/class-membership-metaboxes.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/membership/class-membership-metaboxes.php';
}

/**
 * Membership Custom Columns.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/membership/class-membership-custom-columns.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/membership/class-membership-custom-columns.php';
}

/**
 * Get Membership Class.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/membership/class-get-membership.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/membership/class-get-membership.php';
}

/**
 * Membership methods class file.
 *
 * @since 1.0.0
 */
if ( file_exists( IMS_BASE_DIR . '/resources/membership/class-membership-methods.php' ) ) {
	include_once IMS_BASE_DIR . '/resources/membership/class-membership-methods.php';
}

if ( class_exists( 'IMS_CPT_Membership' ) ) {

	$ims_cpt_membership = new IMS_CPT_Membership();

	add_action( 'init', array( $ims_cpt_membership, 'register_post_type' ), 5 ); // Creating membership post type.
	add_filter( 'cron_schedules', array( $ims_cpt_membership, 'create_schedules' ) ); // Adding custom time schedules.

}

if ( class_exists( 'IMS_Membership_Meta_Boxes' ) ) {

	$ims_membership_meta_boxes_init = new IMS_Membership_Meta_Boxes();
	add_action( 'add_meta_boxes', array( $ims_membership_meta_boxes_init, 'add_membership_meta_box' ) );
	add_action( 'save_post', array( $ims_membership_meta_boxes_init, 'save_meta_box' ), 10, 2 );
	add_action( 'admin_print_styles-post.php', array( $ims_membership_meta_boxes_init, 'add_styles' ) );
	add_action( 'admin_print_styles-post-new.php', array( $ims_membership_meta_boxes_init, 'add_styles' ) );

	// A cron job scheduling to cancel the users' packages that are expired.
	if ( ! wp_next_scheduled( 'ims_cancel_expired_users_packages' ) ) {
		wp_schedule_event( time(), 'daily', 'ims_cancel_expired_users_packages' );
	}

}

if ( ! function_exists( 'ims_cancel_expired_users_packages' ) ) {
	/**
	 * Cancel the users' membership packages that are expired.
	 */
	function ims_cancel_expired_users_packages() {

		$users = get_users( array(
			'meta_key'     => 'ims_current_membership',
			'meta_compare' => 'EXISTS',
		) );

		if ( ! empty( $users ) ) {
			$current_date = new DateTime( date( get_option( 'date_format' ) ) );

			foreach ( $users as $user ) {
				$user    = json_decode( json_encode( $user ), true );
				$user_id = intval( $user['data']['ID'] );

				$current_membership  = get_user_meta( $user_id, 'ims_current_membership', true );
				$membership_end_date = new DateTime( date_i18n( get_option( 'date_format' ), strtotime( get_user_meta( $user_id, 'ims_membership_due_date', true ) ) ) );

				if ( $current_membership && $membership_end_date ) {

					if ( $membership_end_date < $current_date ) {
						$membership_methods = new IMS_Membership_Method();
						$membership_methods->cancel_user_membership( $user_id, $current_membership );
					}
				}
			}
		}
	}

	add_action( 'ims_cancel_expired_users_packages', 'ims_cancel_expired_users_packages' );
}

if ( class_exists( 'IMS_Membership_Custom_Columns' ) ) {

	if ( is_admin() ) {

		global $pagenow;

		if ( 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'ims_membership' === esc_attr( $_GET['post_type'] ) ) {

			// Object: IMS_Membership_Custom_Columns class.
			$ims_membership_custom_columns = new IMS_Membership_Custom_Columns();

			// Add custom columns.
			add_filter( 'manage_edit-ims_membership_columns', array(
				$ims_membership_custom_columns,
				'register_columns'
			) );

			// Display custom columns values.
			add_action( 'manage_ims_membership_posts_custom_column', array(
				$ims_membership_custom_columns,
				'display_column_values'
			) );

		}
	}
}
