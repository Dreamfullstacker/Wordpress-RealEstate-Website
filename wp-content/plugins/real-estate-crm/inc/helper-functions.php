<?php
/**
 * Helper Functions
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'recrm_feedback_request_message' ) ) :
	function recrm_feedback_request_message() {

		return wp_kses( '<p class="recrm_feedback_note">Please <a href=\'https://inspirythemes.com/feedback/\' target=\'_blank\'>share your feedback</a> to get this plugin improved.</p>', array(
			'a' => array(
				'href'   => array(),
				'target' => array(),
			),
			'p' =>array(
				'class' => array(),
			)
		) );
	}
endif;