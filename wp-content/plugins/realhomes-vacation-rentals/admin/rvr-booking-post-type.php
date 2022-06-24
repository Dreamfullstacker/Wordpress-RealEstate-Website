<?php
/**
 * This class is responsible for the Booking post type and related stuff
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */

if ( ! class_exists( 'RVR_Booking' ) ) {
	/**
	 * Class RVR_Booking
	 *
	 * Responsible for all stuff related to Booking Post Type.
	 *
	 * @package    realhomes_vacation_rentals
	 * @subpackage realhomes_vacation_rentals/admin
	 */
	class RVR_Booking {

		/**
		 * Register booking custom post type
		 */
		public function rvr_booking_post_type() {

			$labels = array(
				'name'                  => esc_html_x( 'Bookings', 'Post Type General Name', 'realhomes-vacation-rentals' ),
				'singular_name'         => esc_html_x( 'Booking', 'Post Type Singular Name', 'realhomes-vacation-rentals' ),
				'menu_name'             => esc_html__( 'Bookings', 'realhomes-vacation-rentals' ),
				'name_admin_bar'        => esc_html__( 'Booking', 'realhomes-vacation-rentals' ),
				'archives'              => esc_html__( 'Booking Archives', 'realhomes-vacation-rentals' ),
				'attributes'            => esc_html__( 'Booking Attributes', 'realhomes-vacation-rentals' ),
				'parent_item_colon'     => esc_html__( 'Parent Booking:', 'realhomes-vacation-rentals' ),
				'all_items'             => esc_html__( 'All Bookings', 'realhomes-vacation-rentals' ),
				'add_new_item'          => esc_html__( 'Add New Booking', 'realhomes-vacation-rentals' ),
				'add_new'               => esc_html__( 'Add New', 'realhomes-vacation-rentals' ),
				'new_item'              => esc_html__( 'New Booking', 'realhomes-vacation-rentals' ),
				'edit_item'             => esc_html__( 'Edit Booking', 'realhomes-vacation-rentals' ),
				'update_item'           => esc_html__( 'Update Booking', 'realhomes-vacation-rentals' ),
				'view_item'             => esc_html__( 'View Booking', 'realhomes-vacation-rentals' ),
				'view_items'            => esc_html__( 'View Bookings', 'realhomes-vacation-rentals' ),
				'search_items'          => esc_html__( 'Search Booking', 'realhomes-vacation-rentals' ),
				'not_found'             => esc_html__( 'Not found', 'realhomes-vacation-rentals' ),
				'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'realhomes-vacation-rentals' ),
				'featured_image'        => esc_html__( 'Featured Image', 'realhomes-vacation-rentals' ),
				'set_featured_image'    => esc_html__( 'Set featured image', 'realhomes-vacation-rentals' ),
				'remove_featured_image' => esc_html__( 'Remove featured image', 'realhomes-vacation-rentals' ),
				'use_featured_image'    => esc_html__( 'Use as featured image', 'realhomes-vacation-rentals' ),
				'insert_into_item'      => esc_html__( 'Insert into booking', 'realhomes-vacation-rentals' ),
				'uploaded_to_this_item' => esc_html__( 'Uploaded to this booking', 'realhomes-vacation-rentals' ),
				'items_list'            => esc_html__( 'Bookings list', 'realhomes-vacation-rentals' ),
				'items_list_navigation' => esc_html__( 'Bookings list navigation', 'realhomes-vacation-rentals' ),
				'filter_items_list'     => esc_html__( 'Filter bookings list', 'realhomes-vacation-rentals' ),
			);
			$args   = array(
				'label'               => esc_html__( 'Booking', 'realhomes-vacation-rentals' ),
				'description'         => esc_html__( 'Bookings request for the rental properties.', 'realhomes-vacation-rentals' ),
				'labels'              => $labels,
				'supports'            => array( 'title' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => 'rvr',
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-calendar',
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'can_export'          => false,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'capabilities'        => array(
					'create_posts' => 'do_not_allow',
				),
				'map_meta_cap'        => true,

				// Disabled REST API Support for Bookings
				//'show_in_rest'        => true,
				//'rest_base'           => apply_filters( 'rvr_booking_rest_base', esc_html__( 'bookings', 'realhomes-vacation-rentals' ) )
			);
			register_post_type( 'booking', $args );

		}

		/**
		 * Replace "Enter Title Here" placeholder text.
		 *
		 * @param string $title Default title text.
		 *
		 * @return string
		 */
		public function booking_title_text( $title ) {
			$screen = get_current_screen();

			if ( 'booking' === $screen->post_type ) {
				$title = esc_html__( 'Enter booking ID here', 'realhomes-vacation-rentals' );
			}

			return $title;
		}

		/**
		 * Register booking post type metaboxes
		 *
		 * @param $meta_boxes
		 *
		 * @return array|mixed|void
		 */
		public function rvr_booking_meta_boxes( $meta_boxes ) {

			$prefix = 'rvr_';

			$booking_id = false;
			if ( isset( $_GET['post'] ) ) {
				$booking_id = intval( $_GET['post'] );
			} elseif ( isset( $_POST['post_ID'] ) ) {
				$booking_id = intval( $_POST['post_ID'] );
			}

			// Prepare invoice detail.
			$invoice_id = get_post_meta( $booking_id, 'rvr_invoice_id', true );

			if ( $invoice_id ) {
				$invoice_info = 'Booking Invoice ID: <a href="' . get_edit_post_link( $invoice_id ) . '">' . get_the_title( $invoice_id ) . '</a>';
			} else {
				$invoice_info = esc_html__( 'Invoice is not available for this booking.', 'realhomes-vacation-rentals' );
			}


			// Prepare additional fees detail.
			$additional_fees      = get_post_meta( $booking_id, 'rvr_additional_fees_paid', true );
			$additional_fees_info = esc_html__( 'No additional fees are added to this booking.', 'realhomes-vacation-rentals' );

			if ( ! empty( $additional_fees ) && is_array( $additional_fees ) ) {
				$additional_fees_info = '<div class="rvr-additional-fees-info"><h3>Additional Fees Details</h3><table>';

				foreach ( $additional_fees as $fee_name => $fee_amount ) {
					$additional_fees_info .= "<tr><td><strong>{$fee_name} </strong></td><td>{$fee_amount}</td>";
				}

				$additional_fees_info .= '</table></div>';
			}

			$meta_boxes[] = array(
				'id'     => 'booking-meta-box',
				'title'  => esc_html__( 'Booking', 'realhomes-vacation-rentals' ),
				'pages'  => array( 'booking' ),
				'fields' => array(
					array(
						'id'      => "{$prefix}booking_status",
						'name'    => esc_html__( 'Booking Status', 'realhomes-vacation-rentals' ),
						'type'    => 'select',
						'options' => array(
							'pending'   => esc_html__( 'Pending', 'realhomes-vacation-rentals' ),
							'rejected'  => esc_html__( 'Rejected', 'realhomes-vacation-rentals' ),
							'cancelled' => esc_html__( 'Cancelled', 'realhomes-vacation-rentals' ),
							'confirmed' => esc_html__( 'Confirmed', 'realhomes-vacation-rentals' ),
						),
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}check_in",
						'name'    => esc_html__( 'Check In Date', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}check_out",
						'name'    => esc_html__( 'Check Out Date', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}adult",
						'name'    => esc_html__( 'Adults', 'realhomes-vacation-rentals' ),
						'type'    => 'number',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}child",
						'name'    => esc_html__( 'Children', 'realhomes-vacation-rentals' ),
						'type'    => 'number',
						'columns' => 4,
					),
					array(
						'id'         => "{$prefix}request_timestamp",
						'name'       => esc_html__( 'Request Date & Time', 'realhomes-vacation-rentals' ),
						'type'       => 'text',
						'columns'    => 4,
						'attributes' => array(
							'readonly' => true,
						),
					),

					array(
						'type' => 'heading',
						'desc' => esc_html__( 'Customer', 'realhomes-vacation-rentals' ),
					),
					array(
						'id'      => "{$prefix}renter_name",
						'name'    => esc_html__( 'Name', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}renter_email",
						'name'    => esc_html__( 'Email', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}renter_phone",
						'name'    => esc_html__( 'Phone', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),


					array(
						'type' => 'heading',
						'desc' => esc_html__( 'Pricing', 'realhomes-vacation-rentals' ),
					),
					array(
						'id'      => "{$prefix}staying_nights",
						'name'    => esc_html__( 'Staying Nights', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}price_per_night",
						'name'    => esc_html__( 'Price Per Night', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}price_staying_nights",
						'name'    => esc_html__( 'Staying Nights Price', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}extra_guests_cost",
						'name'    => esc_html__( 'Extra Guests Charges', 'realhomes-vacation-rentals' ) . ' <small>(' . esc_html( get_post_meta( $booking_id, 'rvr_extra_guests', true ) ) . ')</small> ',
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}services_charges",
						'name'    => esc_html__( 'Services Charges', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}subtotal_price",
						'name'    => esc_html__( 'Subtotal', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}govt_tax",
						'name'    => esc_html__( 'Government Tax', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'id'      => "{$prefix}total_price",
						'name'    => esc_html__( 'Total Price', 'realhomes-vacation-rentals' ),
						'type'    => 'text',
						'columns' => 4,
					),
					array(
						'type' => 'heading',
						'desc' => esc_html__( 'Property Information', 'realhomes-vacation-rentals' ),
					),
					array(
						'id'         => "{$prefix}property_custom_id",
						'name'       => esc_html__( 'Property ID', 'realhomes-vacation-rentals' ),
						'type'       => 'text',
						'columns'    => 4,
						'attributes' => array(
							'readonly' => true,
						)
					),
					array(
						'id'         => "{$prefix}property_title",
						'name'       => esc_html__( 'Property Title', 'realhomes-vacation-rentals' ),
						'type'       => 'text',
						'columns'    => 8,
						'attributes' => array(
							'readonly' => true,
						)
					),
					array(
						'id'         => "{$prefix}property_url",
						'name'       => esc_html__( 'Property URL', 'realhomes-vacation-rentals' ),
						'type'       => 'url',
						'columns'    => 12,
						'attributes' => array(
							'readonly' => true,
						),
					),
					array(
						'id'   => "{$prefix}additional_fees_info",
						'type' => 'heading',
						'desc' => $additional_fees_info,
					),
					array(
						'id'   => "{$prefix}invoice_info",
						'type' => 'heading',
						'desc' => $invoice_info,
					),
				)
			);

			// apply a filter before returning meta boxes
			$meta_boxes = apply_filters( 'rvr_booking_meta_boxes', $meta_boxes );

			return $meta_boxes;

		}

		/**
		 * Custom columns for bookings
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		public function booking_edit_columns( $columns ) {

			$columns = array(

				'cb'             => '<input type="checkbox" />',
				'title'          => esc_html__( 'Booking ID', 'realhomes-vacation-rentals' ),
				'renter'         => esc_html__( 'Renter', 'realhomes-vacation-rentals' ),
				'renter_info'    => esc_html__( 'Renter Info', 'realhomes-vacation-rentals' ),
				'check_in'       => esc_html__( 'Check In', 'realhomes-vacation-rentals' ),
				'check_out'      => esc_html__( 'Check Out', 'realhomes-vacation-rentals' ),
				'property_title' => esc_html__( 'Property Title', 'realhomes-vacation-rentals' ),
				'total_price'    => esc_html__( 'Total', 'realhomes-vacation-rentals' ),
				'status'         => esc_html__( 'Status', 'realhomes-vacation-rentals' ),
				'booking_date'   => esc_html__( 'Received Time', 'realhomes-vacation-rentals' ),
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
		 * Setting booking columns values
		 *
		 * @param $column_name
		 */
		public function booking_columns_values( $column_name ) {

			global $post, $post_type, $pagenow;;

			if ( $pagenow == 'edit.php' && $post_type == 'booking' ) {

				$meta_data     = get_post_custom( $post->ID );
				$property_id   = ! empty( $meta_data['rvr_property_id'][0] ) ? $meta_data['rvr_property_id'][0] : '';
				$property_link = '';

				if ( ! empty( $property_id ) ) {

					$property_title = get_the_title( $property_id );

					if ( ! empty( $property_title ) ) {
						$property_link = '<a href="' . get_the_permalink( $property_id ) . '" target="_blank">' . $property_title . '</a>';
					}
				}

				switch ( $column_name ) {

					case 'renter':
						echo ( ! empty( $meta_data['rvr_renter_email'][0] ) ) ? get_avatar( $meta_data['rvr_renter_email'][0], 64 ) . '<br>' : '';
						echo ( ! empty( $meta_data['rvr_renter_name'] ) ) ? esc_html( $meta_data['rvr_renter_name'][0] ) : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'renter_info':
						$not_available = true;

						if ( ! empty( $meta_data['rvr_renter_email'][0] ) ) {
							echo $meta_data['rvr_renter_email'][0];
							$not_available = false;
						}

						if ( ! empty( $meta_data['rvr_renter_phone'][0] ) ) {
							echo "<br><br>";
							echo $meta_data['rvr_renter_phone'][0];
							$not_available = false;
						}
						echo ( $not_available ) ? esc_html__( 'NA', 'realhomes-vacation-rentals' ) : '';
						break;
					case 'phone':
						echo ( ! empty( $meta_data['rvr_renter_phone'] ) ) ? $meta_data['rvr_renter_phone'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'check_in':
						echo ( ! empty( $meta_data['rvr_check_in'] ) ) ? $meta_data['rvr_check_in'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'check_out':
						echo ( ! empty( $meta_data['rvr_check_out'] ) ) ? $meta_data['rvr_check_out'][0] : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'property_title':
						echo ( ! empty( $property_link ) ) ? $property_link : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'total_price':
						echo ( ! empty( $meta_data['rvr_total_price'] ) ) ? ere_format_amount( $meta_data['rvr_total_price'][0] ) : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'status':
						echo ( ! empty( $meta_data['rvr_booking_status'] ) ) ? ucfirst( $meta_data['rvr_booking_status'][0] ) : esc_html__( 'NA', 'realhomes-vacation-rentals' );
						break;
					case 'booking_date':
						the_date( 'Y/m/d' );
						echo '<br>';
						the_time( 'g:i a' );
						break;

					default:
						break;
				}
			}
		}

		/**
		 * Make booking `Status` & `Received` columns sortable
		 *
		 * @param $columns
		 *
		 * @return mixed
		 */
		public function booking_sortable_columns( $columns ) {
			$columns['status']       = 'status';
			$columns['booking_date'] = 'booking_date';

			return $columns;
		}

		/**
		 * Add booking `Status` column sorting key
		 *
		 * @param $query
		 */
		public function booking_status_orderby( $query ) {
			if ( ! is_admin() ) {
				return;
			}

			$orderby = $query->get( 'orderby' );

			if ( 'status' == $orderby ) {
				$query->set( 'meta_key', 'rvr_booking_status' );
				$query->set( 'orderby', 'meta_value' );
			}
		}
	}
}
