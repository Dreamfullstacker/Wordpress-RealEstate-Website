<?php
/**
 * Functions related to agencies
 */


if ( ! function_exists( 'ere_get_agency_properties_count' ) ) {
	/**
	 * Function: Returns the number of listed properties by an agency.
	 *
	 * @param int $agency_id - Agency ID for properties.
	 * @param string $post_status - Status of properties.
	 *
	 * @return integer|boolean
	 *
	 */
	function ere_get_agency_properties_count( $agency_id, $post_status = '' ) {

		// Return if agency id is empty.
		if ( empty( $agency_id ) ) {
			return false;
		}

		$agents_query = array(
			'post_type'      => 'agent',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'REAL_HOMES_agency',
					'value'   => $agency_id,
					'compare' => '=',
				),
			),
		);

		$agent_listing_query = new WP_Query( $agents_query );

		$agent_ids = array();

		if ( $agent_listing_query->have_posts() ) {
			$agent_ids = wp_list_pluck( $agent_listing_query->posts, 'ID' );
		}

		if ( ! empty( $agent_ids ) ) {

			// Prepare query arguments.
			$properties_args = array(
				'post_type'      => 'property',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'     => 'REAL_HOMES_agents',
						'value'   => $agent_ids,
						'type'    => 'NUMERIC',
						'compare' => 'IN',
					),
				),
			);

			// If post status is not empty then add it to the query args.
			if ( ! empty( $post_status ) ) {
				$properties_args['post_status'] = $post_status;
			}

			$properties = new WP_Query( $properties_args );
			if ( $properties->have_posts() ) {
				return $properties->found_posts;
			}
		}

		return false;

	}
}