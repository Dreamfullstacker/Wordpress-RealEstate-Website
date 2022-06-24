<?php
/**
 * This file contains Property_Analytics class and initializing function.
 *
 * @since 3.10
 * @package easy_real_estate
 */

/**
 * Provide methods to get information about Operating System and Browser.
 */
require_once ERE_PLUGIN_DIR . 'includes/property-analytics/class-operating-system-browser.php';

/**
 * Property_Analytics class is responsible to collect properties' views data.
 */
class Property_Analytics {

	/**
	 * ID of the property to which a view data has to set.
	 *
	 * @var $property_id
	 */
	protected $property_id = null;

	/**
	 * Constructor - for the initial setup of property analytics.
	 *
	 * @param int $property_id Property ID to which view data has to set.
	 */
	public function __construct( $property_id = null ) {

		if ( null !== $property_id ) {
			$this->property_id = intval( $property_id );
			$this->insert_property_view();
		}
	}

	/**
	 * Insert property view to the database.
	 */
	public function insert_property_view() {

		global $wpdb;
		$os_br = new Operating_System_Browser();

		$property_id = $this->property_id;
		$time_stamp  = gmdate( 'Y-m-d H:i:s' );
		$user_ip     = $this->get_the_user_ip();
		$browser     = $os_br->show_info( 'browser' );
		$os          = $os_br->show_info( 'os' );

		if ( empty( $property_id ) || empty( $time_stamp ) || empty( $user_ip ) ) {
			return;
		} else {
			$country = empty( $this->get_the_country_by_ip( $user_ip ) ) ? '' : $this->get_the_country_by_ip( $user_ip );
			if ( empty( $country ) ) {
				$country = 'Unknown';
			}
		}

		$wpdb->insert(
			"{$wpdb->prefix}inspiry_property_analytics",
			array(
				'PID'       => $property_id,
				'TimeStamp' => $time_stamp,
				'IP'        => $user_ip,
				'Browser'   => $browser,
				'OS'        => $os,
				'Country'   => $country,
			),
			array(
				'%d',    // PID value type.
				'%s',    // TimeStamp value type.
				'%s',    // IP value type.
				'%s',    // Browser value type.
				'%s',    // OS value type.
				'%s',    // Country vaule type.
			)
		); // db call ok.
	}

	/**
	 * Returns current user's IP address
	 */
	public function get_the_user_ip() {

		$user_ip = '';

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			// check ip from share internet.
			$user_ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ) );
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			// to check ip is pass from proxy.
			$user_ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
		} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$user_ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}

		if ( ! empty( $user_ip ) ) {
			$user_ip = explode( ',', $user_ip );
			$ip      = $user_ip[0];
		}

		return $ip;
	}

	/**
	 * Returns the Country againts given IP address.
	 *
	 * @param string $user_ip User ip address.
	 * @return string
	 */
	public function get_the_country_by_ip( $user_ip ) {
		$country_info = unserialize( file_get_contents( 'http://www.geoplugin.net/php.gp?ip=' . sanitize_text_field( $user_ip ) ) );

		if ( ! empty( $country_info['geoplugin_countryName'] ) ) {
			return $country_info['geoplugin_countryName']; // return country name from available country information.
		}

		return '';
	}
}

/**
 * Initialize Property Analytics Function
 */
function ere_initialize_property_analytics() {
	new Property_Analytics();
}
add_action( 'wp', 'ere_initialize_property_analytics' );


if ( ! function_exists( 'ere_create_property_analytics_table' ) ) {
	/**
	 * Create required database table.
	 */
	function ere_create_property_analytics_table() {

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		// sql query to create database table.
		$sql_query = "CREATE TABLE {$wpdb->prefix}inspiry_property_analytics (
							RID INT(20) NOT NULL AUTO_INCREMENT,
							PID INT(20) NOT NULL,
							TimeStamp VARCHAR(25) NOT NULL,
							IP VARCHAR(20),
							Browser VARCHAR(20),
							OS VARCHAR(20),
							Country VARCHAR(60),
							UNIQUE KEY id (RID)
						) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_query );
	}

	add_action( 'admin_head', 'ere_create_property_analytics_table' );
}
