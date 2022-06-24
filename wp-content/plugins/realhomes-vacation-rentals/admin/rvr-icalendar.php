<?php
/**
 * Functions file related to the iCalendar and its synchronization.
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */

/**
 * iCalendar export feature functions.
 */
if ( ! function_exists( 'rvr_get_property_icalendar_export_url' ) ) {
	/**
	 * Get property iCalendar ID.
	 *
	 * @param $property_id int Property ID.
	 *
	 * @return mixed|string
	 */
	function rvr_get_property_icalendar_export_url( $property_id ) {

		$property_icalendar_id = get_post_meta( $property_id, 'rvr_icalendar_id', true );

		// Create and set iCalendar ID to the property if it's not available.
		if ( '' === $property_icalendar_id ) {
			$property_icalendar_id = md5( uniqid( mt_rand(), true ) );
			update_post_meta( $property_id, 'rvr_icalendar_id', $property_icalendar_id );
		}

		// Get iCalendar feed URL created by the user using iCalendar template.
		$feed_page_url = rvr_get_icalendar_feed_page_url();

		// Set iCalendar ID query parameter and return the full iCalendar export URL if feed page URL exists.
		if ( ! empty( $feed_page_url ) ) {
			$feed_page_url = esc_url_raw( add_query_arg( 'icalendar_id', $property_icalendar_id, $feed_page_url ) );

			return $feed_page_url;
		}

		return '';
	}
}

if ( ! function_exists( 'rvr_get_icalendar_feed_page_url' ) ) {
	/**
	 * Return icalendar feed page url.
	 *
	 * @param bool $only_page_id If there is no need of URL and only page ID is required.
	 *
	 * @return bool|int|string
	 */
	function rvr_get_icalendar_feed_page_url( $only_page_id = false ) {

		// Retrieve the page with iCalendar template.
		$feed_page = get_pages(
			array(
				'meta_key'     => '_wp_page_template',
				'meta_value'   => 'templates/icalendar.php',
				'hierarchical' => 0,
			)
		);

		// Return the feed page URL/ID as per function parameter.
		if ( isset( $feed_page[0]->ID ) ) {
			$feed_page_id = $feed_page[0]->ID;
			if ( $only_page_id ) {
				return $feed_page_id;
			} else {
				return get_page_link( $feed_page_id );
			}
		}

		return false;
	}
}

if ( ! function_exists( 'rvr_get_reserved_dates_events' ) ) {
	/**
	 * Prepare and return property booked/reserved dates events with iCalendar standards.
	 *
	 * @param $property_id int ID of the property of which reservations events need to be returned.
	 *
	 * @return string
	 */
	function rvr_get_reserved_dates_events( $property_id ) {

		if ( ! empty( $property_id ) ) {
			$reserved_dates_events = '';
			$availability_table    = get_post_meta( $property_id, 'rvr_property_availability_table', true );

			if ( ! empty( $availability_table ) && is_array( $availability_table ) ) {

				// Prepare iCalendar event for the each booking entry.
				foreach ( $availability_table as $booking_id => $dates ) {

					// Prepare check-in and check-out dates objects.
					$start_date = new DateTime( $dates[0] );
					$end_date   = new DateTime( $dates[1] );

					// Get iCalendar event against a booking dates period.
					$reserved_dates_events .= rvr_get_reserved_date_event( $start_date->getTimestamp(), $end_date->getTimestamp(), $booking_id );
				}
			}

			// Return collection of events, build from the bookings of current property.
			return $reserved_dates_events;
		}

		return false;
	}
}

if ( ! function_exists( 'rvr_get_reserved_date_event' ) ) {
	/**
	 * Prepare and return property single reservation event with iCalendar standards.
	 *
	 * @param $start_timestamp string iCalendar event starting time.
	 * @param $end_timestamp string iCalendar event ending time.
	 * @param $booking_id int Booking ID of reservation event.
	 *
	 * @return string
	 */
	function rvr_get_reserved_date_event( $start_timestamp, $end_timestamp, $booking_id ) {

		// Preparing an event with given information in the iCalendar event format.
		$event_title = get_post_meta( str_replace( 'rvr-ics-', '', $booking_id ), 'rvr_property_title', true ) . esc_html__( ' property booking.', 'realhomes-vacation-rentals' );
		$res_event   = "BEGIN:VEVENT\r\n";
		$res_event   .= 'UID:' . $booking_id . "\r\n";
		$res_event   .= 'DTSTAMP:' . date( 'Ymd\THis\Z', time() ) . "\r\n";
		$res_event   .= 'DTSTART:' . date( 'Ymd\THis\Z', $start_timestamp ) . "\r\n";
		$res_event   .= 'DTEND:' . date( 'Ymd\THis\Z', $end_timestamp ) . "\r\n";
		$res_event   .= 'SUMMARY:' . esc_html( $event_title ) . "\r\n";
		$res_event   .= 'END:VEVENT' . "\r\n";

		return $res_event;
	}
}

if ( ! function_exists( 'rvr_get_property_icalendar_ics_file_url' ) ) {
	/**
	 * Put property iCalendar file with its data and return its URL.
	 *
	 * @param $property_id int Property ID.
	 *
	 * @return string|void
	 */
	function rvr_get_property_icalendar_ics_file_url( $property_id ) {

		// Do nothing if property ID is empty.
		if ( empty( $property_id ) ) {
			return;
		}

		// Get iCalendar events data against the property's booked dates.
		$property_events = rvr_get_reserved_dates_events( $property_id );

		// Setting the iCalendar events information into the iCalendar body format.
		if ( ! empty( $property_events ) ) {
			$icalendar_events = "BEGIN:VCALENDAR\r\n";
			$icalendar_events .= "VERSION:2.0\r\n";
			$icalendar_events .= "PRODID:-//Property Availability Calendar v1.0//EN\r\n";
			$icalendar_events .= $property_events;
			$icalendar_events .= "END:VCALENDAR";
		} else {
			$icalendar_events = '';
		}

		// Create required directory if it doesn't exist to insert the current property's iCalendar export file..
		$upload_dir_path = WP_CONTENT_DIR . '/uploads/properties-icalendars/';
		if ( ! file_exists( $upload_dir_path ) ) {
			mkdir( $upload_dir_path, 0777, true );
		}

		// Put iCalendar export file to the related directory.
		$ical_file_name = 'icalendar-' . $property_id . '.ics';
		file_put_contents( $upload_dir_path . $ical_file_name, $icalendar_events );

		// Return iCalendar export file URL.
		return WP_CONTENT_URL . "/uploads/properties-icalendars/{$ical_file_name}";

	}
}


/**
 * iCalendar import feature functions.
 */
if ( ! function_exists( 'rvr_import_icalendar_feed' ) ) {
	/**
	 * iCalendar feed import to the property availability calendar.
	 *
	 * @param $property_id int ID of the Property
	 * @param null $feed_list In case of custom feed list when function is called from metadata added/updated/deleted hooks.
	 */
	function rvr_import_icalendar_feed( $property_id, $feed_list = null ) {

		// Get import feed list from property meta if not set via function parameter.
		if ( null === $feed_list ) {
			$feed_list = get_post_meta( $property_id, 'rvr_import_icalendar_feed_list', true );
		}

		if ( ! empty( $feed_list ) && is_array( $feed_list ) ) {
			$events_data = array();
			foreach ( $feed_list as $feed_item ) {
				if ( ! empty( $feed_item['feed_url'] ) ) {

					// Parse the iCalendar feed url using ICal library.
					$icalendar = new ICal( $feed_item['feed_url'] );
					$events    = $icalendar->events();

					// Prepare the data for the property availability calendar from parsed events.
					if ( ! empty( $events ) && is_array( $events ) ) {

						foreach ( $events as $event ) {

							// Ensure all required data is available to create an event.
							if ( ! isset( $event['UID'] ) || ! isset( $event['DTSTART'] ) || ! isset( $event['DTEND'] ) ) {
								continue;
							}

							// Don't import an event if it's imported from another source to exporter property.
							if ( strpos( sanitize_text_field( $event['UID'] ), 'rvr-ics-' ) !== false ) {
								continue;
							}

							$event_end_time = gmdate( 'Y-m-d', $icalendar->iCalDateToUnixTimestamp( $event['DTEND'] ) );

							// Import only current or future booking dates events.
							$date_now = date( 'Y-m-d' );
							if ( $date_now >= $event_end_time ) {
								continue;
							}

							$event_id         = 'rvr-ics-' . sanitize_text_field( $event['UID'] ); // Setting custom prefix to flag the imported bookings in availability calendar table.
							$event_start_time = gmdate( 'Y-m-d', $icalendar->iCalDateToUnixTimestamp( $event['DTSTART'] ) );

							if ( ! empty( $event_id ) && ! empty( $event_start_time ) && ! empty( $event_end_time ) ) {
								$events_data[ $event_id ] = array( $event_start_time, $event_end_time );
							}
						}

						// Add imported events data to the property availability calendar.
						$availability_table = get_post_meta( $property_id, 'rvr_property_availability_table', true );
						$icalendar_table    = get_post_meta( $property_id, 'rvr_property_icalendar_table', true ); // Imported bookings record table.

						// Prepare iCalendar table data.
						if ( ! empty( $icalendar_table ) && is_array( $icalendar_table ) ) {
							$icalendar_table += $events_data;
						} else {
							$icalendar_table = $events_data;
						}

						// Prepare availability table data.
						if ( ! empty( $availability_table ) && is_array( $availability_table ) ) {
							$availability_table += $events_data;
						} else {
							$availability_table = $events_data;
						}

						// Update property availability calendar and icalendar imported dates record tables.
						update_post_meta( $property_id, 'rvr_property_availability_table', $availability_table );
						update_post_meta( $property_id, 'rvr_property_icalendar_table', $icalendar_table );
					}
				}
			}
		}
	}
}

if ( ! function_exists( 'rvr_sweep_icalendar_feed' ) ) {
	/**
	 * iCalendar feed data removal from the property availability calendar.
	 *
	 * @param $property_id int ID of the property.
	 */
	function rvr_sweep_icalendar_feed( $property_id ) {

		$availability_table = get_post_meta( $property_id, 'rvr_property_availability_table', true );
		$icalendar_table    = get_post_meta( $property_id, 'rvr_property_icalendar_table', true );

		if ( ! empty( $icalendar_table ) && ! empty( $availability_table ) ) {

			// Clean imported events data from property availability calendar table with the help of iCalendar record table.
			foreach ( $icalendar_table as $event_id => $event_dates ) {
				unset( $availability_table[ $event_id ] );
			}

			// Update property availability calendar and icalendar imported dates record tables.
			update_post_meta( $property_id, 'rvr_property_availability_table', $availability_table );
			update_post_meta( $property_id, 'rvr_property_icalendar_table', array() );
		}
	}
}

if ( ! function_exists( 'rvr_update_icalendar_feed' ) ) {
	/**
	 * Update property availability calendar with iCalendar data on property feed list add/update and delete action.
	 *
	 * @param $meta_id
	 * @param $property_id
	 * @param $meta_key
	 * @param $new_meta_value
	 *
	 * @throws Exception
	 */
	function rvr_update_icalendar_feed( $meta_id, $property_id, $meta_key, $new_meta_value ) {

		if ( 'rvr_import_icalendar_feed_list' === $meta_key ) {

			// Clean old imported iCalendar events data from property availability calendar.
			rvr_sweep_icalendar_feed( $property_id );

			// Import iCalendar events fresh data to the property availability calendar.
			rvr_import_icalendar_feed( $property_id, $new_meta_value );
		}
	}

	add_action( 'added_post_meta', 'rvr_update_icalendar_feed', 10, 4 );
	add_action( 'updated_post_meta', 'rvr_update_icalendar_feed', 10, 4 );
	add_action( 'deleted_post_meta', 'rvr_update_icalendar_feed', 10, 4 );
}

if ( ! function_exists( 'rvr_icalendar_feed_call' ) ) {
	/**
	 * Update properties availability calendars with icalendar feed data on cron job call.
	 */
	function rvr_icalendar_feed_call() {

		// Get properties having icalendar feed metadata.
		$properties = get_posts(
			array(
				'post_type'      => 'property',
				'posts_per_page' => - 1,
				'meta_key'       => 'rvr_import_icalendar_feed_list',
				'compare'        => 'EXISTS'
			)
		);

		if ( ! empty( $properties ) && is_array( $properties ) ) {
			foreach ( $properties as $property ) {

				// Clean old imported iCalendar events data from property availability calendar.
				rvr_sweep_icalendar_feed( $property->ID );

				// Import iCalendar events fresh data to the property availability calendar.
				rvr_import_icalendar_feed( $property->ID );
			}
		}
	}

	// Setting up the cron job for the above iCalendar import function if iCalendar feed page is available.
	// Otherwise clear the scheduled hook.
	if ( ! empty( rvr_get_icalendar_feed_page_url( true ) ) ) {
		if ( ! wp_next_scheduled( 'rvr_icalendar_feed_call' ) ) {
			wp_schedule_event( time(), 'hourly', 'rvr_icalendar_feed_call' );
		}
	} else {
		wp_clear_scheduled_hook( 'rvr_icalendar_feed_call' );
	}

	add_action( 'rvr_icalendar_feed_call', 'rvr_icalendar_feed_call' );
}
