<?php
/**
 * This file loads all RVR resources and initiate the actions and hooks.
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/assets
 */

/**
 * The class responsible for orchestrating booking widget and related stuff
 */
require_once plugin_dir_path( __FILE__ ) . "rvr-booking-widget.php";

/**
 * The class responsible for orchestrating owner widget and related stuff
 */
require_once plugin_dir_path( __FILE__ ) . 'rvr-owner-widget.php';

if ( ! function_exists( 'rvr_booking_admin_styles' ) ) {
	function rvr_booking_admin_styles( $hook ) {

		wp_enqueue_style( 'rvr_booking_admin', plugins_url( 'css/rvr-booking-admin.css', __FILE__ ) );
		wp_enqueue_script( 'rvr_booking_admin', plugins_url( 'js/rvr-booking-admin.js', __FILE__ ) );
	}

	add_action( 'admin_enqueue_scripts', 'rvr_booking_admin_styles' );
}

if ( ! function_exists( 'rvr_booking_public_styles' ) ) {
	/**
	 * Enqueue front-end scripts
	 */
	function rvr_booking_public_styles() {

		// Enqueued for some help in the datepicker stuff.
		wp_enqueue_script( 'jquery-ui-datepicker' );

		// DateRangePicker calendar styles and scripts.
		wp_enqueue_style( 'rvr_booking_daterangepicker', plugins_url( 'css/daterangepicker.css', __FILE__ ) );
		wp_enqueue_script( 'moment', plugins_url( 'js/daterangepicker/moment.min.js', __FILE__ ), array( 'jquery' ), RVR_VERSION, true );
		wp_enqueue_script( 'rvr_booking_daterangepicker', plugins_url( 'js/daterangepicker/daterangepicker.min.js', __FILE__ ), array( 'jquery' ), RVR_VERSION, true );

		// Plugin styles and scripts.
		wp_enqueue_style( 'rvr_booking_public', plugins_url( 'css/rvr-booking-public.css', __FILE__ ) );

		if ( defined( 'INSPIRY_DESIGN_VARIATION' ) ) {
			wp_enqueue_style( 'realhomes_vacation_rentals', plugins_url( 'css/' . INSPIRY_DESIGN_VARIATION . '/realhomes-vacation-rentals.css', __FILE__ ) );
		}

		wp_register_script( 'rvr_booking_public', plugins_url( 'js/rvr-booking-public.js', __FILE__ ), array( 'jquery' ), RVR_VERSION, true );

		wp_localize_script(
			'rvr_booking_public',
			'availability_calendar_data',
			array(
				'day_name'   => array(
					esc_html_x( 'su', 'Sunday', 'realhomes-vacation-rentals' ),
					esc_html_x( 'mo', 'Monday', 'realhomes-vacation-rentals' ),
					esc_html_x( 'tu', 'Tuesday', 'realhomes-vacation-rentals' ),
					esc_html_x( 'we', 'Wednesday', 'realhomes-vacation-rentals' ),
					esc_html_x( 'th', 'Thursday', 'realhomes-vacation-rentals' ),
					esc_html_x( 'fr', 'Friday', 'realhomes-vacation-rentals' ),
					esc_html_x( 'sa', 'Saturday', 'realhomes-vacation-rentals' ),
				),
				'month_name' => array(
					esc_html__( 'january', 'realhomes-vacation-rentals' ),
					esc_html__( 'february', 'realhomes-vacation-rentals' ),
					esc_html__( 'march', 'realhomes-vacation-rentals' ),
					esc_html__( 'april', 'realhomes-vacation-rentals' ),
					esc_html__( 'may', 'realhomes-vacation-rentals' ),
					esc_html__( 'june', 'realhomes-vacation-rentals' ),
					esc_html__( 'july', 'realhomes-vacation-rentals' ),
					esc_html__( 'august', 'realhomes-vacation-rentals' ),
					esc_html__( 'september', 'realhomes-vacation-rentals' ),
					esc_html__( 'october', 'realhomes-vacation-rentals' ),
					esc_html__( 'november', 'realhomes-vacation-rentals' ),
					esc_html__( 'december', 'realhomes-vacation-rentals' ),
				),
			)
		);

		wp_enqueue_script( 'rvr_booking_public' );
	}

	add_action( 'wp_enqueue_scripts', 'rvr_booking_public_styles' );
}

if ( ! function_exists( 'rvr_is_enabled' ) ) {
	/**
	 * Check if RVR is enabled from its settings.
	 *
	 * @return bool
	 */
	function rvr_is_enabled() {
		$options = get_option( 'rvr_settings' );

		if ( $options['rvr_activation'] ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'rvr_body_classes' ) ) {
	/**
	 * RVR body classes.
	 */
	function rvr_body_classes( $classes ) {

		$classes[] = 'rvr-is-enabled';

		return $classes;
	}
	add_filter( 'body_class', 'rvr_body_classes' );
}

