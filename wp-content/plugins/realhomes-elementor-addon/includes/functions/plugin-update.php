<?Php
/**
 * Plugin Auto Update
 */

/*
// TEMP: Enable update check on every request. Normally we don't need this! This is for testing only!
*/
//set_site_transient('update_plugins', null);

if ( ! function_exists( 'rhea_check_for_plugin_update' ) ) {

	/**
	 * Take over the update check
	 *
	 * @param $checked_data
	 *
	 * @return mixed
	 */
	function rhea_check_for_plugin_update( $checked_data ) {

		$api_url     = 'http://update.inspirythemes.com/plugins/realhomes-elementor-addon/';
		$plugin_slug = 'realhomes-elementor-addon';

		if ( ! empty( $checked_data->checked ) && isset( $checked_data->checked[ $plugin_slug . '/' . $plugin_slug . '.php' ] ) ) {
			$request_args = array(
				'slug'    => $plugin_slug,
				'version' => $checked_data->checked[ $plugin_slug . '/' . $plugin_slug . '.php' ]
			);

			$request_string = rhea_prepare_request( 'basic_check', $request_args );

			// Start checking for an update
			$raw_response = wp_remote_post( $api_url, $request_string );

			if ( ! is_wp_error( $raw_response ) && ( $raw_response['response']['code'] == 200 ) ) {
				$response = unserialize( $raw_response['body'] );

				// Feed the update data into WP updater
				if ( is_object( $response ) && ! empty( $response ) ) {
					$checked_data->response[ $plugin_slug . '/' . $plugin_slug . '.php' ] = $response;
				}
			}
		}

		return $checked_data;
	}

	add_filter( 'pre_set_site_transient_update_plugins', 'rhea_check_for_plugin_update' );
}

if ( ! function_exists( 'rhea_plugin_api_call' ) ) {
	/**
	 * Take over the Plugin info screen
	 *
	 * @param $res
	 * @param $action
	 * @param $args
	 *
	 * @return bool
	 */
	function rhea_plugin_api_call( $res, $action, $args ) {

		$api_url     = 'http://update.inspirythemes.com/plugins/realhomes-elementor-addon/';
		$plugin_slug = 'realhomes-elementor-addon';

		// do nothing if this is not about getting plugin information
		if ( $action !== 'plugin_information' ) {
			return false;
		}

		if ( $args->slug != $plugin_slug ) {
			return $res;
		}

		$request_string = rhea_prepare_request( $action, $args );
		$request        = wp_remote_post( $api_url, $request_string );

		if ( is_wp_error( $request ) ) {
			$response = new WP_Error( 'plugins_api_failed', esc_html__( 'An Unexpected HTTP Error occurred during the API request. Try again!', 'realhomes-elementor-addon' ), $request->get_error_message() );
		} else {
			$response = unserialize( $request['body'] );

			if ( $response === false ) {
				$response = new WP_Error( 'plugins_api_failed', esc_html__( 'An unknown error occurred', 'realhomes-elementor-addon' ), $request['body'] );
			}
		}

		return $response;
	}

	add_filter( 'plugins_api', 'rhea_plugin_api_call', 10, 3 );
}

if ( ! function_exists( 'rhea_prepare_request' ) ) {
	/**
	 * Prepare request based on given args for the API call.
	 *
	 * @param $action
	 * @param $args
	 *
	 * @return array
	 */
	function rhea_prepare_request( $action, $args ) {
		global $wp_version;

		return array(
			'body'       => array(
				'action'  => $action,
				'request' => serialize( $args ),
				'api-key' => md5( get_bloginfo( 'url' ) )
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )
		);
	}
}