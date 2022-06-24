<?php
/**
 * This file is responsible for the property meta-boxes related to RVR plugin.
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */

if ( ! function_exists( 'rvr_add_metabox_tabs' ) ) {
	/**
	 * Adds RVR related metabox tabs to property metaboxes
	 *
	 * @param $property_metabox_tabs
	 *
	 * @return array
	 */
	function rvr_add_metabox_tabs( $property_metabox_tabs ) {

		if ( is_array( $property_metabox_tabs ) ) {

			$property_metabox_tabs['rvr'] = array(
				'label' => esc_html__( 'Vacation Rentals', 'realhomes-vacation-rentals' ),
				'icon'  => 'dashicons-palmtree',
			);

		}

		return $property_metabox_tabs;
	}

	add_filter( 'ere_property_metabox_tabs', 'rvr_add_metabox_tabs', 10 );
}

if ( ! function_exists( 'rvr_add_metabox_fields' ) ) {
	/**
	 * Adds RVR related metabox fields to property metaboxes
	 *
	 * @param $property_metabox_fields
	 *
	 * @return array
	 */
	function rvr_add_metabox_fields( $property_metabox_fields ) {


		$property_id = false;
		if ( isset( $_GET['post'] ) ) {
			$property_id = intval( $_GET['post'] );
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$property_id = intval( $_POST['post_ID'] );
		}

		// Owners.
		// todo: make it dynamic to search and load required owner
		$owners_array = get_posts( array(
			'post_type'        => 'owner',
			'posts_per_page'   => 500,
			'suppress_filters' => 0,
		) );

		$owners_posts = array( 0 => esc_html__( 'None', 'realhomes-vacation-rentals' ) );
		if ( count( $owners_array ) > 0 ) {
			foreach ( $owners_array as $owner_post ) {
				$owners_posts[ $owner_post->ID ] = $owner_post->post_title;
			}
		}

		// Get RVR settings to use meta tabs label information
		$rvr_settings = get_option( 'rvr_settings' );

		// Instant booking option data.
		if ( rvr_is_wc_payment_enabled() && ! empty( $rvr_settings['rvr_wc_payments_scope'] ) && 'property' === $rvr_settings['rvr_wc_payments_scope'] ) {
			$ib_option_label = esc_html__( 'Instant Booking', 'realhomes-vacation-rentals' );
			$ib_option_desc  = esc_html__( 'Instant booking will allow guest to confirm property booking instantly after paying the property booking payment.', 'realhomes-vacation-rentals' );
			$ib_option_type  = 'radio';
		} else {
			$ib_option_label = '';
			$ib_option_desc  = '';
			$ib_option_type  = 'hidden';
		}

		// RVR - meta fields information
		$rvr_metabox_fields = array(
			array(
				'name'              => esc_html__( 'Bulk Prices', 'realhomes-vacation-rentals' ),
				'label_description' => esc_html__( 'To provide discount on longer stays.', 'realhomes-vacation-rentals' ),
				'id'                => 'rvr_bulk_pricing',
				'type'              => 'group',
				'clone'             => true,
				'sort_clone'        => true,
				'tab'               => 'rvr',
				'columns'           => 12,
				'add_button'        => esc_html__( 'Add more', 'realhomes-vacation-rentals' ),
				'fields'            => array(
					array(
						'name'    => esc_html__( 'Number of Nights', 'realhomes-vacation-rentals' ),
						'id'      => 'number_of_nights',
						'type'    => 'number',
						'columns' => 6,
					),
					array(
						'name'    => esc_html__( 'Price Per Night', 'realhomes-vacation-rentals' ),
						'id'      => 'price_per_night',
						'type'    => 'number',
						'columns' => 6,
					),
				),
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'name'              => esc_html__( 'Seasonal Prices', 'realhomes-vacation-rentals' ),
				'label_description' => esc_html__( 'To charge guests as per season.', 'realhomes-vacation-rentals' ),
				'id'                => 'rvr_seasonal_pricing',
				'type'              => 'group',
				'clone'             => true,
				'sort_clone'        => true,
				'tab'               => 'rvr',
				'columns'           => 12,
				'add_button'        => esc_html__( 'Add more', 'realhomes-vacation-rentals' ),
				'fields'            => array(
					array(
						'name'    => esc_html__( 'Start Date', 'realhomes-vacation-rentals' ),
						'id'      => 'rvr_price_start_date',
						'type'    => 'date',
						'columns' => 4,
					),
					array(
						'name'    => esc_html__( 'End Date', 'realhomes-vacation-rentals' ),
						'id'      => 'rvr_price_end_date',
						'type'    => 'date',
						'columns' => 4,
					),
					array(
						'name'    => esc_html__( 'Price', 'realhomes-vacation-rentals' ),
						'id'      => 'rvr_price_amount',
						'type'    => 'number',
						'columns' => 4,
					),
				),
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'name'              => esc_html__( 'Additional Fees', 'realhomes-vacation-rentals' ),
				'label_description' => esc_html__( 'To charge additional fees. Such fees can be conditional.', 'realhomes-vacation-rentals' ),
				'id'                => 'rvr_additional_fees',
				'type'              => 'group',
				'clone'             => true,
				'sort_clone'        => true,
				'tab'               => 'rvr',
				'columns'           => 12,
				'add_button'        => esc_html__( 'Add more', 'realhomes-vacation-rentals' ),
				'fields'            => array(
					array(
						'name'    => esc_html__( 'Fee Label', 'realhomes-vacation-rentals' ),
						'id'      => 'rvr_fee_label',
						'type'    => 'text',
						'columns' => 3,
					),
					array(
						'name'    => esc_html__( 'Fee Amount', 'realhomes-vacation-rentals' ),
						'id'      => 'rvr_fee_amount',
						'type'    => 'number',
						'columns' => 3,
					),
					array(
						'name'    => esc_html__( 'Fee Type', 'realhomes-vacation-rentals' ),
						'id'      => 'rvr_fee_type',
						'type'    => 'select',
						'default' => 'flat',
						'options' => array(
							'fixed'      => 'Fixed',
							'percentage' => 'Percentage',
						),
						'columns' => 3,
					),
					array(
						'name'    => esc_html__( 'Fee Calculation', 'realhomes-vacation-rentals' ),
						'id'      => 'rvr_fee_calculation',
						'default' => '',
						'type'    => 'select',
						'options' => array(
							'per_stay'        => 'Per Stay',
							'per_night'       => 'Per Night',
							'per_guest'       => 'Per Guest',
							'per_night_guest' => 'Per Night Per Guest',
						),
						'columns' => 3,
					),
				),
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'id'      => "rvr_govt_tax",
				'name'    => esc_html__( 'Percentage of Govt Tax', 'realhomes-vacation-rentals' ),
				'desc'    => esc_html__( 'Example: 16', 'realhomes-vacation-rentals' ),
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'id'      => "rvr_service_charges",
				'name'    => esc_html__( 'Percentage of Service Charges', 'realhomes-vacation-rentals' ),
				'desc'    => esc_html__( 'Example: 3', 'realhomes-vacation-rentals' ),
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'id'      => "rvr_guests_capacity",
				'name'    => esc_html__( 'Guests Capacity', 'realhomes-vacation-rentals' ),
				'desc'    => esc_html__( 'Example: 4', 'realhomes-vacation-rentals' ),
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'id'      => 'rvr_book_child_as',
				'name'    => esc_html__( 'Book child as an adult?', 'realhomes-vacation-rentals' ),
				'type'    => 'radio',
				'options' => array(
					'adult' => esc_html__( 'Yes', 'realhomes-vacation-rentals' ),
					'child' => esc_html__( 'No', 'realhomes-vacation-rentals' ),
				),
				'std'     => 'child',
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'id'      => "rvr_min_stay",
				'name'    => esc_html__( 'Minimum Number of Nights to Stay', 'realhomes-vacation-rentals' ),
				'desc'    => esc_html__( 'Example: 1', 'realhomes-vacation-rentals' ),
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'id'      => 'rvr_guests_capacity_extend',
				'name'    => esc_html__( 'Allow Extra Guests?', 'realhomes-vacation-rentals' ),
				'type'    => 'radio',
				'options' => array(
					'allowed'     => esc_html__( 'Yes', 'realhomes-vacation-rentals' ),
					'not_allowed' => esc_html__( 'No', 'realhomes-vacation-rentals' ),
				),
				'std'     => 'not_allowed',
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'id'      => 'rvr_extra_guest_price',
				'name'    => esc_html__( 'Price Per Extra Guest', 'realhomes-vacation-rentals' ),
				'desc'    => esc_html__( 'Example: 50', 'realhomes-vacation-rentals' ),
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'name'              => esc_html__( 'Guests Accommodation', 'realhomes-vacation-rentals' ),
				'label_description' => esc_html__( 'Provide accommodation details for the guests.', 'realhomes-vacation-rentals' ),
				'id'                => 'rvr_accommodation',
				'type'              => 'group',
				'clone'             => true,
				'sort_clone'        => true,
				'tab'               => 'rvr',
				'columns'           => 12,
				'add_button'        => esc_html__( 'Add more', 'realhomes-vacation-rentals' ),
				'fields'            => array(
					array(
						'name'    => esc_html__( 'Room Type', 'realhomes-vacation-rentals' ),
						'desc'    => esc_html__( 'Example: Master Room', 'realhomes-vacation-rentals' ),
						'id'      => 'room_type',
						'type'    => 'text',
						'columns' => 3,
					),
					array(
						'name'    => esc_html__( 'Bed Type', 'realhomes-vacation-rentals' ),
						'desc'    => esc_html__( 'Example: King Bed', 'realhomes-vacation-rentals' ),
						'id'      => 'bed_type',
						'type'    => 'text',
						'columns' => 3,
					),
					array(
						'name'    => esc_html__( 'Number of Beds', 'realhomes-vacation-rentals' ),
						'id'      => 'beds_number',
						'type'    => 'text',
						'columns' => 3,
					),
					array(
						'name'    => esc_html__( 'Number of Guests', 'realhomes-vacation-rentals' ),
						'id'      => 'guests_number',
						'type'    => 'text',
						'columns' => 3,
					),
				),
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'name'    => $ib_option_label,
				'desc'    => $ib_option_desc,
				'id'      => 'rvr_instant_booking',
				'type'    => $ib_option_type,
				'std'     => '0',
				'options' => array(
					'1' => esc_html__( 'Enable', 'realhomes-vacation-rentals' ),
					'0' => esc_html__( 'Disable', 'realhomes-vacation-rentals' ),
				),
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'id'      => "rvr_property_owner",
				'name'    => esc_html__( 'Owner', 'realhomes-vacation-rentals' ),
				'desc'    => sprintf( esc_html__( 'You can add new owner by %s clicking here%s.', 'realhomes-vacation-rentals' ), '<a style="color: #ea723d;" target="_blank" href="' . get_home_url() . '/wp-admin/post-new.php?post_type=owner">', '</a>' ),
				'type'    => 'select',
				'options' => $owners_posts,
				'std'     => '',
				'columns' => 6,
				'tab'     => 'rvr',
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'name'       => esc_html__( 'Outdoor Features', 'realhomes-vacation-rentals' ),
				'id'         => "rvr_outdoor_features",
				'std'        => '',
				'type'       => 'text',
				'size'       => '100',
				'tab'        => 'rvr',
				'clone'      => true,
				'sort_clone' => true,
				'add_button' => esc_html__( '+', 'realhomes-vacation-rentals' ),
				'columns'    => 6,
			),

			array(
				'name'       => esc_html__( 'Property Surroundings', 'realhomes-vacation-rentals' ),
				'id'         => "rvr_surroundings",
				'type'       => 'group',
				'clone'      => true,
				'sort_clone' => true,
				'tab'        => 'rvr',
				'columns'    => 6,
				'add_button' => esc_html__( '+', 'realhomes-vacation-rentals' ),
				'fields'     => array(
					array(
						'name' => esc_html__( 'Point of Interest', 'realhomes-vacation-rentals' ),
						'id'   => 'rvr_surrounding_point',
						'type' => 'text',
					),
					array(
						'name' => esc_html__( 'Distance or How to approach', 'realhomes-vacation-rentals' ),
						'id'   => 'rvr_surrounding_point_distance',
						'type' => 'text',
					),

				),
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'name'       => ! empty( $rvr_settings['rvr_optional_services_inc_label'] ) ? $rvr_settings['rvr_optional_services_inc_label'] : esc_html__( 'What is included', 'realhomes-vacation-rentals' ),
				'id'         => "rvr_included",
				'std'        => '',
				'type'       => 'text',
				'size'       => '100',
				'tab'        => 'rvr',
				'clone'      => true,
				'sort_clone' => true,
				'add_button' => esc_html__( '+', 'realhomes-vacation-rentals' ),
				'columns'    => 6,
			),
			array(
				'name'       => ! empty( $rvr_settings['rvr_optional_services_inc_label'] ) ? $rvr_settings['rvr_optional_services_not_inc_label'] : esc_html__( 'What is not included', 'realhomes-vacation-rentals' ),
				'id'         => "rvr_not_included",
				'std'        => '',
				'type'       => 'text',
				'size'       => '100',
				'tab'        => 'rvr',
				'clone'      => true,
				'sort_clone' => true,
				'add_button' => esc_html__( '+', 'realhomes-vacation-rentals' ),
				'columns'    => 6,
			),
			array(
				'type' => 'divider',
				'tab'  => 'rvr',
			),
			array(
				'name'       => esc_html__( 'Property Policies or Rules', 'realhomes-vacation-rentals' ),
				'desc'       => sprintf( esc_html__( '* Default check icon %s will appear if "Font Awesome Icon" field is empty. You can see the list of Font Awesome Free Icons by %s clicking here%s. %s Add "rvr-slash" class with Font Awesome classes to display it as ban %s %s For example %s rvr-slash fas fa-paw %s for no pets ', 'realhomes-vacation-rentals' ),
					'<i style="color: #ea723d;" class="fas fa-check"></i>',
					'<a style="color: #ea723d;" target="_blank" href="https://fontawesome.com/icons?d=gallery&m=free">',
					'</a>',
					'<br>',
					'<i style="color: #ea723d;" class="fas fa-ban"></i>', '<br>', '<strong>', '</strong>' ),
				'id'         => "rvr_policies",
//			'std'        => '',
				'type'       => 'group',
				'size'       => '100',
				'tab'        => 'rvr',
				'clone'      => true,
				'sort_clone' => true,
				'columns'    => 6,
				'add_button' => esc_html__( '+', 'realhomes-vacation-rentals' ),
				'fields'     => array(
					array(
						'name' => esc_html__( 'Policy Text', 'realhomes-vacation-rentals' ),
						'id'   => 'rvr_policy_detail',
						'type' => 'text',
					),
					array(
						'name' => esc_html__( 'Font Awesome Icon (i.e far fa-star)', 'realhomes-vacation-rentals' ),
						'id'   => 'rvr_policy_icon',
						'type' => 'text',
					),

				),
			),

		);

		// Display property price fields in this "Vacation Rentals" section only if RVR is enabled.
		if ( rvr_is_enabled() ) {
			$property_price_fields = array(
				array(
					'id'      => "REAL_HOMES_property_price",
					'name'    => esc_html__( 'Rent Price ( Only digits )', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example: 1200', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'rvr',
				),
				array(
					'id'      => "REAL_HOMES_property_old_price",
					'name'    => esc_html__( 'Old Price If Any ( Only digits )', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example: 1500', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'rvr',
				),
				array(
					'id'      => 'REAL_HOMES_property_price_prefix',
					'name'    => esc_html__( 'Price Prefix', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example: From', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'rvr',
				),
				array(
					'id'      => "REAL_HOMES_property_price_postfix",
					'name'    => esc_html__( 'Price Postfix', 'easy-real-estate' ),
					'desc'    => esc_html__( 'Example: Monthly or Per Night', 'easy-real-estate' ),
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'rvr',
				),
				array(
					'type'    => 'divider',
					'columns' => 12,
					'id'      => 'price_divider',
					'tab'     => 'rvr',
				),
			);
		} else {
			$property_price_fields = array();
		}

		// iCalendar import & export fields.
		$icalendar_export_url = rvr_get_property_icalendar_export_url( $property_id );

		if ( ! empty( $icalendar_export_url ) ) {
			$icalendar_file_url = rvr_get_property_icalendar_ics_file_url( $property_id );

			$icalendar_data = '<br><h5 style="font-size: 13px;">' . esc_html__( 'iCalendar Export', 'realhomes-vacation-rentals' ) . '</h5>';
			$icalendar_data .= '<strong>' . esc_html__( 'Feed URL', 'realhomes-vacation-rentals' ) . ':</strong> <code>' . esc_url( $icalendar_export_url ) . '</code>';
			$icalendar_data .= '<br><br>';
			$icalendar_data .= '<strong>' . esc_html__( 'File URL', 'realhomes-vacation-rentals' ) . ':</strong> <code>' . esc_url( $icalendar_file_url ) . '</code>';

			$icalendar_fields = array(
				array(
					'id'      => 'rvr_icalendar_data',
					'desc'    => $icalendar_data,
					'type'    => 'heading',
					'tab'     => 'rvr',
					'columns' => 12,
				),
				array(
					'name'       => esc_html__( 'iCalendar Import', 'realhomes-vacation-rentals' ),
					'id'         => 'rvr_import_icalendar_feed_list',
					'type'       => 'group',
					'clone'      => true,
					'sort_clone' => true,
					'tab'        => 'rvr',
					'columns'    => 12,
					'add_button' => esc_html__( 'Add more', 'realhomes-vacation-rentals' ),
					'fields'     => array(
						array(
							'name'    => esc_html__( 'Feed Name', 'realhomes-vacation-rentals' ),
							'id'      => 'feed_name',
							'type'    => 'text',
							'columns' => 6,
						),
						array(
							'name'    => esc_html__( 'Feed URL', 'realhomes-vacation-rentals' ),
							'id'      => 'feed_url',
							'type'    => 'text',
							'columns' => 6,
						),
					),
				),
			);
		} else {
			$icalendar_data   = '<br><h5 style="font-size: 13px;">' . esc_html__( 'iCalendar Sync', 'realhomes-vacation-rentals' ) . '</h5>';
			$icalendar_data   .= '<p>' . sprintf( esc_html__( 'Before syncing booking calendars you need to %1$ssetup the iCalendar Feed page%2$s.', 'realhomes-vacation-rentals' ), '<a style="color: #ea723d;" target="_blank" href="https://realhomes.io/documentation/add-property/#icalendar-synchronization">', '</a>' ) . '</p>';
			$icalendar_fields = array(
				array(
					'type'    => 'heading',
					'tab'     => 'rvr',
					'columns' => 12,
					'desc'    => $icalendar_data,
				),
			);
		}

		$rvr_metabox_fields = array_merge( $property_price_fields, $rvr_metabox_fields );
		$rvr_metabox_fields = array_merge( $rvr_metabox_fields, $icalendar_fields );

		return array_merge( $property_metabox_fields, $rvr_metabox_fields );
	}

	add_filter( 'ere_property_metabox_fields', 'rvr_add_metabox_fields', 11 );
}

/**
 * Added property availability table meta to the REST API.
 */
$property_reservations_in_rest = get_option( 'inspiry_property_reservations_in_rest', 'hide' );
if ( 'show' === $property_reservations_in_rest ) {
	add_action(
		'rest_api_init',
		function () {
			register_rest_field(
				'property',
				'rvr_property_bookings',
				array(
					'get_callback'    => function ( $post_arr ) {
						return get_post_meta( $post_arr['id'], 'rvr_property_availability_table', true );
					},
					'update_callback' => null,
					'schema'          => null,
				)
			);
		}
	);
}
