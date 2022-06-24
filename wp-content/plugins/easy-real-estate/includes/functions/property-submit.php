<?php
/**
 * Property Submit Functions
 */
if ( ! function_exists( 'ere_guest_property_submission' ) ) {
	/**
	 * Returns guest property submission customizer settings value.
	 *
	 * @return bool
	 * @since 0.5.1
	 */
	function ere_guest_property_submission() {

		if ( 'true' === get_option( 'inspiry_guest_submission', 'false' ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'ere_submit_notice' ) ) {
	/**
	 * Property Submit Notice Email
	 *
	 * @param $property_id
	 */
	function ere_submit_notice( $property_id ) {

		/* get and sanitize target email */
		$target_email = sanitize_email( get_option( 'theme_submit_notice_email' ) );
		$target_email = is_email( $target_email );
		if ( $target_email ) {

			/* current user ( submitter ) information */
			$current_user    = wp_get_current_user();
			$submitter_name  = $current_user->display_name;
			$submitter_email = $current_user->user_email;
			$site_name       = get_bloginfo( 'name' );

			/* email subject */
			if ( ere_guest_property_submission() ) {
				$email_subject = sprintf( esc_html__( 'A new property is submitted at %s', 'easy-real-estate' ), $site_name );
			} else {
				$email_subject = sprintf( esc_html__( 'A new property is submitted by %s at %s', 'easy-real-estate' ), $submitter_name, $site_name );
			}

			/* start of email body */
			$email_body = array();

			if ( ere_guest_property_submission() ) {
				$email_body[] = array(
					'name'  => '',
					'value' => esc_html__( 'A new property is submitted', 'easy-real-estate' ),
				);
			} else {
				$email_body[] = array(
					'name'  => '',
					'value' => sprintf( esc_html__( 'A new property is submitted by %s', 'easy-real-estate' ), $submitter_name ),
				);
			}

			/* preview link */
			$preview_link = set_url_scheme( get_permalink( $property_id ) );
			$preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ) ) );
			if ( ! empty( $preview_link ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Property Preview Link', 'easy-real-estate' ),
					'value' => '<a target="_blank" href="' . $preview_link . '">' . sanitize_text_field( $_POST['inspiry_property_title'] ) . '</a>',
				);
			}

			/* message to reviewer */
			if ( isset( $_POST['message_to_reviewer'] ) ) {
				$message_to_reviewer = stripslashes( $_POST['message_to_reviewer'] );
				if ( ! empty( $message_to_reviewer ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'Message to the Reviewer', 'easy-real-estate' ),
						'value' => $message_to_reviewer,
					);
				}
			}

			/* end of message body */
			$email_body[] = array(
				'name'  => esc_html__( 'Submitter Email', 'easy-real-estate' ),
				'value' => $submitter_email,
			);

			$email_body = ere_email_template( $email_body, 'property_submit_form' );

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers   = array();
			$headers[] = "Reply-To: $submitter_name <$submitter_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers   = apply_filters( "inspiry_property_submit_mail_header", $headers );    // just in case if you want to modify the header in child theme

			// Send Email
			if ( ! wp_mail( $target_email, $email_subject, $email_body, $headers ) ) {
				inspiry_log( 'Failed: To send property submit notice' );
			}

		}

	}

	add_action( 'inspiry_after_property_submit', 'ere_submit_notice' );
}

if ( ! function_exists( 'ere_notify_user' ) ) {
	/**
	 * Notify users when their submitted properties are published.
	 *
	 * @param string $new_status New post status.
	 * @param string $old_status Old post status.
	 * @param WP_Post $post Post object.
	 *
	 * @return bool
	 */
	function ere_notify_user( $new_status, $old_status, $post ) {

		// Return false if the user is not admin or post type is not property.
		if ( ! current_user_can( 'manage_options' ) || 'property' !== $post->post_type ) {
			return false;
		}

		// Return false if guest property submission is enabled or property submit dashboard module is not enabled.
		if ( ere_guest_property_submission() || function_exists( 'realhomes_get_dashboard_page_url' ) && ! realhomes_get_dashboard_page_url() && ! realhomes_dashboard_module_enabled( 'inspiry_submit_property_module_display' ) ) {
			return false;
		}

		// Allow only following roles to send notification.
		$author = get_userdata( $post->post_author );
		if ( ! in_array( $author->roles[0], array( 'contributor', 'subscriber' ) ) ) {
			return false;
		}

		if ( 'publish' === $new_status && 'pending' === $old_status ) {

			$user_email = is_email( $author->user_email );
			if ( $user_email ) {

				$post_title = $post->post_title;

				// Email Subject
				$email_subject = sprintf( esc_html__( 'Property Published: %s', 'easy-real-estate' ), esc_html( $post_title ) );

				// Email Body
				$email_body = array();

				$email_body[] = array(
					'name'  => sprintf( esc_html__( 'Hello %s,', 'easy-real-estate' ), esc_html( ucfirst( $author->display_name ) ) ),
					'value' => sprintf( esc_html__( 'We have published your property "%s".', 'easy-real-estate' ), esc_html( $post_title ) )
				);

				$email_body[] = array(
					'name'  => esc_html__( 'You can view it here.', 'easy-real-estate' ),
					'value' => '<a target="_blank" href="' . get_permalink( $post->ID ) . '">' . esc_html( $post_title ) . '</a>',
				);

				$email_body[] = array(
					'name'  => '',
					'value' => esc_html__( 'Thanks for Submitting.', 'easy-real-estate' ),
				);

				// Email Template
				$email_body = ere_email_template( $email_body, 'publish_property_notification_mail' );

				// Email Headers
				$headers   = array();
				$headers[] = "Content-Type: text/html; charset=UTF-8";
				$headers   = apply_filters( "inspiry_publish_property_notification_mail_header", $headers ); // just in case if you want to modify the header in child theme

				// Send Email
				if ( ! wp_mail( $user_email, $email_subject, $email_body, $headers ) ) {
					inspiry_log( 'Failed: To send publish property notification' );
				}
			}
		}
	}

	add_action( 'transition_post_status', 'ere_notify_user', 10, 3 );
}