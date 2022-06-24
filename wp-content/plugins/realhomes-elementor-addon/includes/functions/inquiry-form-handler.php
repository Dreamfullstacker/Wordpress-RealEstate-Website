<?php
if ( ! function_exists( 'custom_fields_to_email_body' ) ) {
	/**
	 * Add Inquiry Form custom fields values into Email body
	 */
	function custom_fields_to_email_body( $email_body ) {
		$rhea_custom_label = array();
		if ( isset( $_POST['rhea_custom_label'] ) ) {
			$rhea_custom_label = ( $_POST['rhea_custom_label'] );
		}
		$rhea_custom_field = array();
		if ( isset( $_POST['rhea_custom_field'] ) ) {
			$rhea_custom_field = ( $_POST['rhea_custom_field'] );
		}
		$additional_details = array_combine( $rhea_custom_label, $rhea_custom_field );
		?>

		<?php


		if ( $additional_details && ! empty( $additional_details ) ) {
			$custom = array();
			foreach ( $additional_details as $key => $value ) {
				if ( is_array( $value ) && ( $value ) ) {
					$string   = implode( ", ", $value );
					$custom[] = array(
						'name'  => $key,
						'value' => $string,
					);
				} elseif ( ! empty( $value ) ) {
					$custom[] = array(
						'name'  => $key,
						'value' => $value,
					);
				}
			}

			return array_merge( $email_body, $custom );
		}

		return $email_body;
	}
}

if ( ! function_exists( 'rhea_send_contact_message' ) ) {
	/**
	 * Handler for Contact form on contact page template
	 */
	function rhea_send_contact_message() {


		if ( isset( $_POST['email'] ) ):

			/*
			 * Verify Nonce
			 */
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'rhea_inquiry_form' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Unverified Nonce!', 'realhomes-elementor-addon' )
				) );
				die;
			}

			/* Verify Google reCAPTCHA */
			if ( function_exists( 'ere_verify_google_recaptcha' ) ) {
				ere_verify_google_recaptcha();
			}

			/*
			 * Sanitize and Validate Target email address that will be configured from theme options
			 */

			$to_email = sanitize_email( $_POST['target-email'] );


			$to_email = is_email( $to_email );

			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Target Email address is not properly configured!', 'realhomes-elementor-addon' )
				) );
				die;
			}

			/*
			 * Sanitize and Validate contact form input data
			 */
			$contact_prefix = '';
			if ( isset( $_POST['prefix'] ) ) {
				$contact_prefix = sanitize_text_field( $_POST['prefix'] );
			}
			if(isset($_POST['name'])){
				$from_name     = sanitize_text_field($contact_prefix). ' ' .sanitize_text_field( $_POST['name'] );
			}
			if(isset($_POST['number'])) {
				$phone_number = sanitize_text_field( $_POST['number'] );
			}
			if(isset($_POST['home'])) {
				$home_number = sanitize_text_field( $_POST['home'] );
			}
			if(isset($_POST['work'])) {
				$office_number = sanitize_text_field( $_POST['work'] );
			}
			if(isset($_POST['country'])) {
				$country = sanitize_text_field( $_POST['country'] );
			}
			if(isset($_POST['address'])) {
				$address = sanitize_text_field( $_POST['address'] );
			}
			if(isset($_POST['city'])) {
			$city          = sanitize_text_field( $_POST['city'] );
			}
			if(isset($_POST['state'])) {
			$state         = sanitize_text_field( $_POST['state'] );
			}
			if(isset($_POST['zip'])) {
			$zip           = sanitize_text_field( $_POST['zip'] );
			}
			if(isset($_POST['source'])) {
			$source        = sanitize_text_field( $_POST['source'] );
			}
			if(isset($_POST['agent'])) {
			$agent         = sanitize_text_field( $_POST['agent'] );
			}
			if(isset($_POST['message'])) {
			$message       = stripslashes( $_POST['message'] );
			}


			$from_email = sanitize_email( $_POST['email'] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Provided Email address is invalid!', 'realhomes-elementor-addon' )
				) );
				die;
			}

			/*
			 * Email Subject
			 */
			$email_subject = esc_html__( 'New message sent by', 'realhomes-elementor-addon' ) . ' ' . $from_name . ' ' . esc_html__( 'using contact form at', 'realhomes-elementor-addon' ) . ' ' . get_bloginfo( 'name' );

			/*
			 * Email Body
			 */
			$email_body = array();

			$email_body[] = array(
				'name'  => esc_html__( 'Name', 'realhomes-elementor-addon' ),
				'value' => $from_name,
			);

			$email_body[] = array(
				'name'  => esc_html__( 'Email', 'realhomes-elementor-addon' ),
				'value' => $from_email,
			);


			if ( ! empty( $phone_number ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Phone Number', 'realhomes-elementor-addon' ),
					'value' => $phone_number,
				);
			}

			if ( ! empty( $home_number ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Home Phone Number', 'realhomes-elementor-addon' ),
					'value' => $home_number,
				);
			}

			if ( ! empty( $office_number ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Office Phone Number', 'realhomes-elementor-addon' ),
					'value' => $office_number,
				);
			}

			if ( ! empty( $address ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Address', 'realhomes-elementor-addon' ),
					'value' => $address,
				);
			}
			if ( ! empty( $city ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'City', 'realhomes-elementor-addon' ),
					'value' => $city,
				);
			}
			if ( ! empty( $state ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Sate', 'realhomes-elementor-addon' ),
					'value' => $state,
				);
			}
			if ( ! empty( $zip ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Zip', 'realhomes-elementor-addon' ),
					'value' => $zip,
				);
			}
			if ( ! empty( $country ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Country', 'realhomes-elementor-addon' ),
					'value' => $country,
				);
			}
			if ( ! empty( $source ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Source', 'realhomes-elementor-addon' ),
					'value' => $source,
				);
			}
			if ( ! empty( $agent ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Agent', 'realhomes-elementor-addon' ),
					'value' => $agent,
				);
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Message', 'realhomes-elementor-addon' ),
				'value' => $message,
			);

			if ( '1' == get_option( 'inspiry_gdpr_in_email', '0' ) && isset( $_POST['gdpr'] ) ) {
				$GDPR_agreement = $_POST['gdpr'];
				if ( ! empty( $GDPR_agreement ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'GDPR Agreement', 'realhomes-elementor-addon' ),
						'value' => $GDPR_agreement,
					);
				}
			}

			$email_body = custom_fields_to_email_body($email_body);

			$email_body = ere_email_template( $email_body );

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();

			/* Send CC of contact form message if configured */
			$cc_email = sanitize_email( $_POST['target-email-cc'] );

			$cc_email = explode( ',', $cc_email );
			if ( ! empty( $cc_email ) ) {
				foreach ( $cc_email as $ind_email ) {
					$ind_email = sanitize_email( $ind_email );
					$ind_email = is_email( $ind_email );
					if ( $ind_email ) {
						$headers[] = "Cc: $ind_email";
					}
				}
			}

			/* Send BCC of contact form message if configured */
			$bcc_email = sanitize_email( $_POST['target-email-bcc'] );

			$bcc_email = explode( ',', $bcc_email );
			if ( ! empty( $bcc_email ) ) {
				foreach ( $bcc_email as $ind_email ) {
					$ind_email = sanitize_email( $ind_email );
					$ind_email = is_email( $ind_email );
					if ( $ind_email ) {
						$headers[] = "Bcc: $ind_email";
					}
				}
			}

			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers   = apply_filters( "inspiry_contact_mail_header", $headers );    // just in case if you want to modify the header in child theme

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {

				if ( '1' === get_option( 'ere_contact_form_webhook_integration', '0' ) ) {
					ere_forms_safe_webhook_post( $_POST );
				}

				echo json_encode( array(
					'success' => true,
					'message' => esc_html__( 'Message Sent Successfully!', 'realhomes-elementor-addon' )
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => esc_html__( 'Server Error: WordPress mail function failed!', 'realhomes-elementor-addon' )
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Invalid Request !', 'realhomes-elementor-addon' )
				)
			);
		endif;

		do_action( 'rhea_after_inquiry_form_submit' );

		die;

	}

	add_action( 'wp_ajax_nopriv_rhea_inquiry_send_message', 'rhea_send_contact_message' );
	add_action( 'wp_ajax_rhea_inquiry_send_message', 'rhea_send_contact_message' );
}
