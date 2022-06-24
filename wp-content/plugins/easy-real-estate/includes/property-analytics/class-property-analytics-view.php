<?php
/**
 * This file contains Property_Analytics_View class and 'inspiry_get_property_views' Ajax handler
 * to display property analytics data.
 *
 * @since 3.10
 * @package easy_real_estate
 */

/**
 * Property_Analytics_View class is responsible to display properties' views data.
 */
class Property_Analytics_View {

	/**
	 * ID of the property that will be used as 'key' to reterive property views data.
	 *
	 * @var int $property_id
	 */
	private $property_id;

	/**
	 * Constructor function that set the class data variable on instantiating.
	 *
	 * @param int $property_id ID of the property that will be used as 'key' to reterive property views data.
	 *
	 * @return void
	 */
	public function __construct( $property_id = 0 ) {
		if ( ! empty( $property_id ) ) {
			$this->property_id = $property_id;
		} else {
			global $wp_query;
			if ( is_object( $wp_query->post ) ) {
				$this->property_id = $wp_query->post;
			}
		}
	}

	/**
	 * Return views based on given Type and Date.
	 *
	 * @param string $type Property views type that's required. By default all views will be returned.
	 * @param string $date The date for which property views are required. By default views will be returned for all dates.
	 *
	 * @return string Count of property views.
	 */
	public function get_views( $type = 'all', $date = '' ) {

		global $wpdb;

		switch ( $type ) {
			case 'property_unique_views':
				// Property unique views.
				$sql_query = "SELECT COUNT(DISTINCT IP) FROM {$wpdb->prefix}inspiry_property_analytics WHERE PID = {$this->property_id} ";

				if ( ! empty( $date ) ) {
					$sql_query .= "AND TimeStamp LIKE CONCAT('$date','%')";
				}

				$result = $wpdb->get_var( $sql_query ); // phpcs:ignore
				break;
			case 'property_today_views':
				// Property today views.
				if ( empty( $date ) ) {
					$date = gmdate( 'Y-m-d' );
				}

				$sql_query = "SELECT COUNT(PID) FROM {$wpdb->prefix}inspiry_property_analytics WHERE PID = {$this->property_id} AND TimeStamp LIKE CONCAT('$date','%')";
				$result    = $wpdb->get_var( $sql_query ); // phpcs:ignore
				break;
			case 'property_total_views':
				// Property total views.
				$sql_query = "SELECT COUNT(PID) FROM {$wpdb->prefix}inspiry_property_analytics WHERE PID = {$this->property_id}";
				$result    = $wpdb->get_var( $sql_query ); // phpcs:ignore
				break;
			case 'property_views_history':
				// Property total views.
				$sql_query = "SELECT * FROM {$wpdb->prefix}inspiry_property_analytics WHERE PID = {$this->property_id}";
				$result    = $wpdb->get_results( $sql_query ); // phpcs:ignore
				break;
			default:
				// Properties total views.
				$sql_query = "SELECT COUNT(PID) FROM {$wpdb->prefix}inspiry_property_analytics";
				$result    = $wpdb->get_var( $sql_query ); // phpcs:ignore
		}

		return $result;
	}
}

if ( ! function_exists( 'inspiry_get_property_views' ) ) {
	/**
	 * Ajax request handler to fulfil requested property
	 * views result based on given property ID.
	 */
	function inspiry_get_property_views() {

		if ( empty( $_REQUEST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ), 'ere-property-analytics' ) ) {
			exit( 'No naughty business please!' );
		}

		if ( isset( $_POST['property_id'] ) && ! empty( $_POST['property_id'] ) ) {

			$property_id = sanitize_text_field( wp_unslash( $_POST['property_id'] ) );

			// Add a view to the property of given ID.
			new Property_Analytics( $property_id );

			$property_views = new Property_Analytics_View( $property_id );
			$views          = (array) $property_views->get_views( 'property_views_history' );
			$time_stamps    = array();

			foreach ( $views as $view ) {
				$view              = (array) $view;
				$view['TimeStamp'] = explode( ' ', $view['TimeStamp'] );
				$time_stamps[]     = $view['TimeStamp'][0];
			}

			$time_stamps = array_values( array_unique( $time_stamps ) );

			$total_views = array();
			$num_of_days = get_option( 'inspiry_property_analytics_time_period', 14 );
			$time_stamps = array_slice( $time_stamps, -( intval( $num_of_days ) ) );
			foreach ( $time_stamps as $time_stamp ) {
				$total_views[] = $property_views->get_views( 'property_today_views', $time_stamp );
			}

			echo wp_json_encode(
				array(
					'dates' => $time_stamps,
					'views' => $total_views,
				)
			);
		}

		wp_die();
	}

	add_action( 'wp_ajax_inspiry_property_views', 'inspiry_get_property_views' );
	add_action( 'wp_ajax_nopriv_inspiry_property_views', 'inspiry_get_property_views' );
}

if ( ! function_exists( 'inspiry_get_property_summed_views' ) ) {
	/**
	 * Return property summed up views for the configured timestamp.
	 */
	function inspiry_get_property_summed_views( $property_id ) {

		$property_views = new Property_Analytics_View( $property_id );
		$views          = (array) $property_views->get_views( 'property_views_history' );
		$time_stamps    = array();

		foreach ( $views as $view ) {
			$view              = (array) $view;
			$view['TimeStamp'] = explode( ' ', $view['TimeStamp'] );
			$time_stamps[]     = $view['TimeStamp'][0];
		}

		$time_stamps = array_values( array_unique( $time_stamps ) );

		$total_views = 0;
		$num_of_days = get_option( 'inspiry_property_analytics_time_period', 14 );
		$time_stamps = array_slice( $time_stamps, - ( intval( $num_of_days ) ) );
		foreach ( $time_stamps as $time_stamp ) {
			$total_views += intval( $property_views->get_views( 'property_today_views', $time_stamp ) );
		}

		return intval( $total_views );
	}
}