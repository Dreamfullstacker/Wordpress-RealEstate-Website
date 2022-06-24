<?php
/**
 * This class is responsible for the Owner post type and related stuff.
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */

if ( ! class_exists( 'RVR_Owner' ) ) {
	/**
	 * Class RVR_Owner
	 *
	 * Responsible for all stuff related to Owner Post Type.
	 *
	 * @package    realhomes_vacation_rentals
	 * @subpackage realhomes_vacation_rentals/admin
	 */
	class RVR_Owner {

		/**
		 * Register owner sub menu under Vacation Rentals dashboard menu
		 *
		 * @param $sub_menus
		 *
		 * @return array
		 */
		public function rvr_sub_menus( $sub_menus ) {

			$new_menu_item = array(
				'owners'        => array(
					'rvr',
					esc_html__( 'All Owners', 'realhomes-vacation-rentals' ),
					esc_html__( 'All Owners', 'realhomes-vacation-rentals' ),
					'edit_posts',
					'edit.php?post_type=owner',
				),
				'add_new_owner' => array(
					'rvr',
					esc_html__( 'Add New Owner', 'realhomes-vacation-rentals' ),
					esc_html__( 'New Owner', 'realhomes-vacation-rentals' ),
					'edit_posts',
					'post-new.php?post_type=owner',
				),
			);

			$key   = 'bookings';
			$keys  = array_keys( $sub_menus );
			$index = array_search( $key, $keys );
			$pos   = false === $index ? count( $sub_menus ) : $index + 1;

			return array_merge( array_slice( $sub_menus, 0, $pos ), $new_menu_item, array_slice( $sub_menus, $pos ) );
		}

		/**
		 * Register owner custom post type
		 */
		public function rvr_owner_post_type() {

			$labels = array(
				'name'                  => esc_html_x( 'Owners', 'Post Type General Name', 'realhomes-vacation-rentals' ),
				'singular_name'         => esc_html_x( 'Owner', 'Post Type Singular Name', 'realhomes-vacation-rentals' ),
				'menu_name'             => esc_html__( 'Owners', 'realhomes-vacation-rentals' ),
				'name_admin_bar'        => esc_html__( 'Owner', 'realhomes-vacation-rentals' ),
				'archives'              => esc_html__( 'Owner Archives', 'realhomes-vacation-rentals' ),
				'attributes'            => esc_html__( 'Owner Attributes', 'realhomes-vacation-rentals' ),
				'parent_item_colon'     => esc_html__( 'Parent Owner:', 'realhomes-vacation-rentals' ),
				'all_items'             => esc_html__( 'All Owners', 'realhomes-vacation-rentals' ),
				'add_new_item'          => esc_html__( 'Add New Owner', 'realhomes-vacation-rentals' ),
				'add_new'               => esc_html__( 'Add New', 'realhomes-vacation-rentals' ),
				'new_item'              => esc_html__( 'New Owner', 'realhomes-vacation-rentals' ),
				'edit_item'             => esc_html__( 'Edit Owner', 'realhomes-vacation-rentals' ),
				'update_item'           => esc_html__( 'Update Owner', 'realhomes-vacation-rentals' ),
				'view_item'             => esc_html__( 'View Owner', 'realhomes-vacation-rentals' ),
				'view_items'            => esc_html__( 'View Owners', 'realhomes-vacation-rentals' ),
				'search_items'          => esc_html__( 'Search Owner', 'realhomes-vacation-rentals' ),
				'not_found'             => esc_html__( 'Not found', 'realhomes-vacation-rentals' ),
				'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'realhomes-vacation-rentals' ),
				'featured_image'        => esc_html__( 'Featured Image', 'realhomes-vacation-rentals' ),
				'set_featured_image'    => esc_html__( 'Set featured image', 'realhomes-vacation-rentals' ),
				'remove_featured_image' => esc_html__( 'Remove featured image', 'realhomes-vacation-rentals' ),
				'use_featured_image'    => esc_html__( 'Use as featured image', 'realhomes-vacation-rentals' ),
				'insert_into_item'      => esc_html__( 'Insert into owner', 'realhomes-vacation-rentals' ),
				'uploaded_to_this_item' => esc_html__( 'Uploaded to this owner', 'realhomes-vacation-rentals' ),
				'items_list'            => esc_html__( 'Owners list', 'realhomes-vacation-rentals' ),
				'items_list_navigation' => esc_html__( 'Owners list navigation', 'realhomes-vacation-rentals' ),
				'filter_items_list'     => esc_html__( 'Filter owners list', 'realhomes-vacation-rentals' ),
			);
			$args   = array(
				'label'               => esc_html__( 'Owner', 'realhomes-vacation-rentals' ),
				'description'         => esc_html__( 'Owner custom post type for the properties to choose as contact and information provider.', 'realhomes-vacation-rentals' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'capability_type'     => 'post',
				// Disabled REST API Support for Owners
				//'show_in_rest'        => true,
				//'rest_base'           => apply_filters( 'rvr_owner_rest_base', esc_html__( 'owners', 'realhomes-vacation-rentals' ) )
			);
			register_post_type( 'owner', $args );

		}

		/**
		 * Register owner post type metaboxes
		 *
		 * @param $meta_boxes
		 *
		 * @return array|mixed|void
		 */
		public function rvr_owner_meta_boxes( $meta_boxes ) {

			$prefix = 'rvr_';

			$meta_boxes[] = array(
				'id'     => 'owner-meta-box',
				'title'  => esc_html__( 'Owner Details', 'realhomes-vacation-rentals' ),
				'pages'  => array( 'owner' ),
				'fields' => array(
					array(
						'id'      => "{$prefix}owner_email",
						'name'    => esc_html__( 'Email', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_mobile",
						'name'    => esc_html__( 'Mobile', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_office_phone",
						'name'    => esc_html__( 'Office Phone', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_fax",
						'name'    => esc_html__( 'Fax', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_whatsapp",
						'name'    => esc_html__( 'Whatsapp', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_address",
						'name'    => esc_html__( 'Address', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_twitter",
						'name'    => esc_html__( 'Twitter Link', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_facebook",
						'name'    => esc_html__( 'Facebook Link', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_instagram",
						'name'    => esc_html__( 'Instagram Link', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_linkedin",
						'name'    => esc_html__( 'Linkedin Link', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_pinterest",
						'name'    => esc_html__( 'Pinterest Link', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
					array(
						'id'      => "{$prefix}owner_youtube",
						'name'    => esc_html__( 'Youtube Link', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 6,
					),
				)
			);

			// apply a filter before returning meta boxes
			$meta_boxes = apply_filters( 'rvr_owner_meta_boxes', $meta_boxes );

			return $meta_boxes;

		}

		/**
		 * Custom columns for owners
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		function owner_edit_columns( $columns ) {

			$columns = array(
				'cb'            => '<input type="checkbox" />',
				'title'         => esc_html__( 'Name', 'realhomes-vacation-rentals' ),
				'owner_photo'   => esc_html__( 'Photo', 'realhomes-vacation-rentals' ),
				'owner_info'    => esc_html__( 'Owner Info', 'realhomes-vacation-rentals' ),
				'owner_address' => esc_html__( 'Address', 'realhomes-vacation-rentals' ),
				'date'          => esc_html__( 'Publish Time', 'realhomes-vacation-rentals' ),
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

		/**
		 * Setting owner columns values
		 *
		 * @param $column_name
		 */
		public function owner_columns_values( $column_name ) {

			global $post;

			$meta_data = get_post_custom( $post->ID );

			switch ( $column_name ) {

				case 'owner_photo':
					if ( has_post_thumbnail( $post->ID ) ) {
						echo get_the_post_thumbnail( $post->ID, array( 64, 64 ) );
					} elseif ( isset( $meta_data['rvr_owner_email'][0] ) ) {
						echo get_avatar( $meta_data['rvr_owner_email'][0], 64 );
					} else {
						echo get_avatar( '', 64 );
					}
					break;
				case 'owner_info':
					$not_available = true;

					if ( ! empty( $meta_data['rvr_owner_email'] ) ) {
						echo sprintf( '<strong>%s</strong> ', esc_html__( 'Email:', 'realhomes-vacation-rentals' ) ) . $meta_data['rvr_owner_email'][0] . '<br>';
						$not_available = false;
					}
					if ( ! empty( $meta_data['rvr_owner_mobile'] ) ) {
						echo sprintf( '<strong>%s</strong> ', esc_html__( 'Mobile: ', 'realhomes-vacation-rentals' ) ) . $meta_data['rvr_owner_mobile'][0] . '<br>';
						$not_available = false;
					}
					if ( ! empty( $meta_data['rvr_owner_whatsapp'] ) ) {
						echo sprintf( '<strong>%s</strong> ', esc_html__( 'Whatsapp: ', 'realhomes-vacation-rentals' ) ) . $meta_data['rvr_owner_whatsapp'][0];
						$not_available = false;
					}
					if ( $not_available ) {
						esc_html_e( 'NA', 'realhomes-vacation-rentals' );
					}
					break;
				case 'owner_address':
					echo ( ! empty( $meta_data['rvr_owner_address'] ) ) ? $meta_data['rvr_owner_address'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
					break;
				default:
					break;
			}
		}

		/**
		 * Replace "Enter Title Here" placeholder text
		 *
		 * @param $title
		 *
		 * @return string
		 */
		public function rvr_change_title_text( $title ) {
			$screen = get_current_screen();

			if ( 'owner' == $screen->post_type ) {
				$title = esc_html__( 'Enter owner name here', 'realhomes-vacation-rentals' );
			}

			return $title;
		}
	}
}