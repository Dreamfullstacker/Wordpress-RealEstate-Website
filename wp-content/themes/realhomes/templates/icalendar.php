<?php
/**
 * Template Name: iCalendar Feed
 *
 * @package realhomes
 */

// Ensure RVR plugin is activated and iCalendar ID is available.
if ( ! inspiry_is_rvr_enabled() ) {
	wp_die( esc_html__( 'Error: Before you access this page, please activate the RealHomes Vacation Rentals plugin!', 'framework' ) );
} else if ( ! isset( $_GET['icalendar_id'] ) ) {
	wp_die( esc_html__( 'Error: This page called incorrectly!', 'framework' ) );
}

// Get the property by given iCalendar ID.
$icalendar_id       = sanitize_text_field( $_GET['icalendar_id'] );
$icalendar_property = get_posts(
	array(
		'post_type'  => 'property',
		'meta_key'   => 'rvr_icalendar_id',
		'meta_value' => $icalendar_id,
		'compare'    => '='
	)
);

// Prepare the iCalendar events and export.
if ( ! empty( $icalendar_property ) && isset( $icalendar_property[0]->ID ) ) {
	$property_id     = $icalendar_property[0]->ID;
	$property_events = rvr_get_reserved_dates_events( $property_id ); // Get iCalendar events of a property against its ID.

	// Export iCalendar if any events are available.
	if ( ! empty( $property_events ) ) {
		$icalendar_events = "BEGIN:VCALENDAR\r\n";
		$icalendar_events .= "VERSION:2.0\r\n";
		$icalendar_events .= "PRODID:-//Property Bookings v1.0//EN\r\n";
		$icalendar_events .= $property_events;
		$icalendar_events .= "END:VCALENDAR";

		// Set header information of iCalendar export.
		header( 'Content-Type: text/calendar; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=icalendar.ics' );

		echo $icalendar_events;
	}
}

die();
