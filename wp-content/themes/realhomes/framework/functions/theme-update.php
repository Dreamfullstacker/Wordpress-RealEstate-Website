<?Php
/**
 * Theme Auto Update
 */

/*
// TEMP: Enable update check on every request. Normally we don't need this! This is for testing only!
*/
//set_site_transient( 'update_themes', null );

if ( ! function_exists( 'inspiry_check_for_update' ) ) {
	/**
	 * Check for the theme update if available
	 *
	 * @param $checked_data
	 *
	 * @return mixed
	 */
	function inspiry_check_for_update( $checked_data ) {

		global $wp_version;
		$api_url = 'http://update.inspirythemes.com/themes/realhomes/';

		$request = array(
			'slug'    => 'realhomes',
			'version' => INSPIRY_THEME_VERSION
		);

		// Start checking for an update
		$send_for_check = array(
			'body'       => array(
				'action'  => 'theme_update',
				'request' => serialize( $request ),
				'api-key' => md5( home_url() )
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
		);

		$raw_response = wp_remote_post( $api_url, $send_for_check );

		if ( ! is_wp_error( $raw_response ) && ( $raw_response['response']['code'] ) == 200 ) {
			$response = unserialize( $raw_response['body'] );

			// Feed the update data into WP updater
			if ( ! empty( $response ) ) {
				$checked_data->response['realhomes'] = $response;
			}
		}

		return $checked_data;
	}

	add_filter( 'pre_set_site_transient_update_themes', 'inspiry_check_for_update' );
}