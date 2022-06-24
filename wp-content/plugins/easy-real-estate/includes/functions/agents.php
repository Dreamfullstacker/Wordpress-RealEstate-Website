<?php
/**
 * Functions related to agents
 */

if ( ! function_exists( 'ere_get_agent_properties_count' ) ) {
	/**
	 * Function: Returns the number of listed properties by an agent.
	 *
	 * @param int $agent_id - Agent ID for properties.
	 * @param string $post_status - Status of properties.
	 *
	 * @return mixed|integer|boolean
	 */
	function ere_get_agent_properties_count( $agent_id, $post_status = '' ) {

		// Return if agent id is empty.
		if ( empty( $agent_id ) ) {
			return false;
		}

		// Prepare query arguments.
		$properties_args = array(
			'post_type'      => 'property',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'REAL_HOMES_agents',
					'value'   => $agent_id,
					'compare' => '=',
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

		return false;

	}
}