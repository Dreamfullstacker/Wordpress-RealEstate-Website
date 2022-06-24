<?php
/**
 * Functions related to Contact or Message Forms Handling
 */
if ( ! function_exists( 'ere_mail_from_name' ) ) {
	/**
	 * Override 'WordPress' as from name in emails sent by wp_mail function
	 * @return string
	 */
	function ere_mail_from_name() {
		// The blogname option is escaped with esc_html on the way into the database in sanitize_option
		// we want to reverse this for the plain text arena of emails.
		return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	add_filter( 'wp_mail_from_name', 'ere_mail_from_name' );
}

if ( ! function_exists( 'ere_forms_safe_webhook_post' ) ) {
	/**
	 * Sends a safe Webhook request using the POST method.
	 *
	 * @since 0.6.0
	 *
	 * @param array $form_data
	 * @param string $form_id
	 */
	function ere_forms_safe_webhook_post( array $form_data, $form_id = 'contact_form' ) {

		$exclude_fields = apply_filters( 'ere_forms_webhook_exclude_fields',
			array( 'action', 'nonce', 'target', 'submit', 'the_id', 'agent_id', 'property_id', 'ere_cf_widget_target_email' ),
			$form_id
		);

		$form_data = array_merge( $form_data, array( 'form_id' => $form_id ) );

		if ( ! empty( $form_data ) && is_array( $form_data ) ) {
			if ( ! empty( $exclude_fields ) && is_array( $exclude_fields ) ) {
				foreach ( $exclude_fields as $field ) {
					if ( isset( $form_data[ $field ] ) ) {
						unset( $form_data[ $field ] );
					}
				}
			}
		}

		$webhook_url = get_option( 'ere_forms_webhook_url' );
		if ( ! empty( $webhook_url ) && ! empty( $form_data ) ) {
			$args = apply_filters( 'ere_forms_webhook_post_args', array(
				'body'    => wp_json_encode( $form_data ),
				'headers' => array(
					'Content-Type' => 'application/json; charset=UTF-8',
				),
			) );

			wp_safe_remote_post( $webhook_url, $args );
		}
	}
}

if ( ! function_exists( 'ere_send_contact_message' ) ) {
	/**
	 * Handler for Contact form on contact page template
	 */
	function ere_send_contact_message() {

		if ( isset( $_POST[ 'email' ] ) ):

			/*
			 * Verify Nonce
			 */
			if ( ! isset( $_POST[ 'nonce' ] ) || ! wp_verify_nonce( $_POST[ 'nonce' ], 'send_message_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Unverified Nonce!', 'easy-real-estate' )
				) );
				die;
			}

			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();

			/*
			 * Sanitize and Validate Target email address that will be configured from theme options
			 */
			if ( isset( $_POST['the_id'] ) ) {
				$to_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_email', true ) );
			} elseif ( isset( $_POST['ere_cf_widget_target_email'] ) ) {
				$to_email = sanitize_email( $_POST['ere_cf_widget_target_email'] );
			} else {
				$to_email = sanitize_email( get_option( 'theme_contact_email' ) );
			}

			$to_email = is_email( $to_email );

			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Target Email address is not properly configured!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Sanitize and Validate contact form input data
			 */
			$from_name = sanitize_text_field( $_POST[ 'name' ] );
			$phone_number = sanitize_text_field( $_POST[ 'number' ] );
			$message = stripslashes( $_POST[ 'message' ] );

			$from_email = sanitize_email( $_POST[ 'email' ] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Provided Email address is invalid!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Email Subject
			 */
			$email_subject = esc_html__( 'New message sent by', 'easy-real-estate' ) . ' ' . $from_name . ' ' . esc_html__( 'using contact form at', 'easy-real-estate' ) . ' ' . get_bloginfo( 'name' );

			/*
			 * Email Body
			 */
			$email_body = array();

			if ( isset( $_POST[ 'property_title' ] ) ) {
				$property_title = sanitize_text_field( $_POST[ 'property_title' ] );
				if ( ! empty( $property_title ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'Property Title', 'easy-real-estate' ),
						'value' => $property_title,
					);
				}
			}

			if ( isset( $_POST[ 'property_permalink' ] ) ) {
				$property_permalink = esc_url( $_POST[ 'property_permalink' ] );
				if ( ! empty( $property_permalink ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'Property URL', 'easy-real-estate' ),
						'value' => $property_permalink,
					);
				}
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Name', 'easy-real-estate' ),
				'value' => $from_name,
			);

			if ( ! empty( $phone_number ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Phone Number', 'easy-real-estate' ),
					'value' => $phone_number,
				);
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Email', 'easy-real-estate' ),
				'value' => $from_email,
			);

			$email_body[] = array(
				'name'  => esc_html__( 'Message', 'easy-real-estate' ),
				'value' => $message,
			);

			if ( '1' == get_option( 'inspiry_gdpr_in_email', '0' ) && isset( $_POST['gdpr'] ) ) {
				$GDPR_agreement = $_POST['gdpr'];
				if ( ! empty( $GDPR_agreement ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'GDPR Agreement', 'easy-real-estate' ),
						'value' => $GDPR_agreement,
					);
				}
			}

			$email_body = ere_email_template( $email_body );

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();

			/* Send CC of contact form message if configured */
			if ( isset( $_POST['the_id'] ) ) {
				$cc_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_cc_email', true ) );
			} else {
				$cc_email = sanitize_email( get_option( 'theme_contact_cc_email' ) );
			}

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
			if ( isset( $_POST['the_id'] ) ) {
				$bcc_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_bcc_email', true ) );
			} else {
				$bcc_email = sanitize_email( get_option( 'theme_contact_bcc_email' ) );
			}

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
			$headers = apply_filters( "inspiry_contact_mail_header", $headers );    // just in case if you want to modify the header in child theme

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {

				if ( '1' === get_option( 'ere_contact_form_webhook_integration', '0' ) ) {
					ere_forms_safe_webhook_post( $_POST );
				}

				echo json_encode( array(
					'success' => true,
					'message' => esc_html__( 'Message Sent Successfully!', 'easy-real-estate' )
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => esc_html__( 'Server Error: WordPress mail function failed!', 'easy-real-estate' )
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Invalid Request !', 'easy-real-estate' )
				)
			);
		endif;

		do_action('inspiry_after_contact_form_submit');

		die;

	}

	add_action( 'wp_ajax_nopriv_send_message', 'ere_send_contact_message' );
	add_action( 'wp_ajax_send_message', 'ere_send_contact_message' );
}

if ( ! function_exists( 'ere_send_contact_message_cfos' ) ) {
	/**
	 * Handler for Contact form on contact page template
	 */
	function ere_send_contact_message_cfos() {

		if ( isset( $_POST[ 'email' ] ) ):

			/*
			 * Verify Nonce
			 */
			if ( ! isset( $_POST[ 'nonce' ] ) || ! wp_verify_nonce( $_POST[ 'nonce' ], 'send_cfos_message_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Unverified Nonce!', 'easy-real-estate' )
				) );
				die;
			}

			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();

			/*
			 * Sanitize and Validate Target email address that will be configured from theme options
			 */
			if ( isset( $_POST['the_id'] ) ) {
				$to_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_form_email_cfos', true ) );
			} else {
				$to_email = '';
			}

			$to_email = is_email( $to_email );
			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Target Email address is not properly configured!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Sanitize and Validate contact form input data
			 */
			$from_name = sanitize_text_field( $_POST[ 'name' ] );
			$phone_number = sanitize_text_field( $_POST[ 'number' ] );
			$message = stripslashes( $_POST[ 'message' ] );

			$from_email = sanitize_email( $_POST[ 'email' ] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Provided Email address is invalid!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Email Subject
			 */
			$email_subject = esc_html__( 'New message sent by', 'easy-real-estate' ) . ' ' . $from_name . ' ' . esc_html__( 'using home contact form at', 'easy-real-estate' ) . ' ' . get_bloginfo( 'name' );

			/*
			 * Email Body
			 */
			$email_body = array();

			$email_body[] = array(
				'name'  => esc_html__( 'Name', 'easy-real-estate' ),
				'value' => $from_name,
			);

			if ( ! empty( $phone_number ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Phone Number', 'easy-real-estate' ),
					'value' => $phone_number,
				);
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Email', 'easy-real-estate' ),
				'value' => $from_email,
			);

			$email_body[] = array(
				'name'  => esc_html__( 'Message', 'easy-real-estate' ),
				'value' => $message,
			);

			if ( '1' == get_option( 'inspiry_gdpr_in_email', '0' ) && isset( $_POST['gdpr'] ) ) {
				$GDPR_agreement = $_POST['gdpr'];
				if ( ! empty( $GDPR_agreement ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'GDPR Agreement', 'easy-real-estate' ),
						'value' => $GDPR_agreement,
					);
				}
			}

			$email_body = ere_email_template( $email_body, 'contact_form_over_slider' );

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();

			/* Send CC of contact form message if configured */
			if ( isset( $_POST['the_id'] ) ) {
				$cc_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_form_email_cc_cfos', true ) );
			} else {
				$cc_email = '';
			}

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
			if ( isset( $_POST['the_id'] ) ) {
				$bcc_email = sanitize_email( get_post_meta( $_POST['the_id'], 'theme_contact_form_email_bcc_cfos', true ) );
			} else {
				$bcc_email = '';
			}

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
			$headers = apply_filters( "inspiry_contact_mail_header", $headers );    // just in case if you want to modify the header in child theme

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {

				if ( '1' === get_option( 'ere_contact_form_webhook_integration', '0' ) ) {
					ere_forms_safe_webhook_post( $_POST, 'contact_form_over_slider' );
				}

				echo json_encode( array(
					'success' => true,
					'message' => esc_html__( 'Message Sent Successfully!', 'easy-real-estate' )
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => esc_html__( 'Server Error: WordPress mail function failed!', 'easy-real-estate' )
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Invalid Request !', 'easy-real-estate' )
				)
			);
		endif;

		do_action('inspiry_after_contact_form_submit');

		die;
	}

	add_action( 'wp_ajax_nopriv_send_message_cfos', 'ere_send_contact_message_cfos' );
	add_action( 'wp_ajax_send_message_cfos', 'ere_send_contact_message_cfos' );
}

if ( ! function_exists( 'ere_send_message_to_agent' ) ) {
	/**
	 * Handler for agent's contact form
	 */
	function ere_send_message_to_agent() {
		if ( isset( $_POST[ 'email' ] ) ):
			/*
			 *  Verify Nonce
			 */
			$nonce = $_POST[ 'nonce' ];
			if ( ! wp_verify_nonce( $nonce, 'agent_message_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Unverified Nonce!', 'easy-real-estate' )
				) );
				die;
			}

			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();

			/* Sanitize and Validate Target email address that is coming from agent form */
			$to_email = sanitize_email( $_POST[ 'target' ] );
			$to_email = is_email( $to_email );
			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Target Email address is not properly configured!', 'easy-real-estate' )
				) );
				die;
			}

			/* Sanitize and Validate contact form input data */
			$from_name = sanitize_text_field( $_POST[ 'name' ] );
			$from_phone = sanitize_text_field( $_POST[ 'phone' ] );
			$message = stripslashes( $_POST[ 'message' ] );

			/*
			 * From email
			 */
			$from_email = sanitize_email( $_POST[ 'email' ] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Provided Email address is invalid!', 'easy-real-estate' )
				) );
				die;
			}

			/*
			 * Email Subject
			 */
			$is_agency_form = ( isset( $_POST['form_of'] ) && 'agency' == $_POST['form_of'] );
			$form_of = $is_agency_form ? esc_html__( 'using agency contact form at', 'easy-real-estate' ) : esc_html__( 'using agent contact form at', 'easy-real-estate' );
			$email_subject = esc_html__( 'New message sent by', 'easy-real-estate' ) . ' ' . $from_name . ' ' . $form_of . ' ' . get_bloginfo( 'name' );

			/*
			 * Email body
			 */
			$email_body = array();

			if ( isset( $_POST[ 'property_title' ] ) ) {
				$property_title = sanitize_text_field( $_POST[ 'property_title' ] );
				if ( ! empty( $property_title ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'Property Title', 'easy-real-estate' ),
						'value' => $property_title,
					);
				}
			}

			if ( isset( $_POST[ 'property_permalink' ] ) ) {
				$property_permalink = esc_url( $_POST[ 'property_permalink' ] );
				if ( ! empty( $property_permalink ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'Property URL', 'easy-real-estate' ),
						'value' => $property_permalink,
					);
				}
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Name', 'easy-real-estate' ),
				'value' => $from_name,
			);

			$email_body[] = array(
				'name'  => esc_html__( 'Email', 'easy-real-estate' ),
				'value' => $from_email,
			);

			if ( ! empty( $from_phone ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Contact Number', 'easy-real-estate' ),
					'value' => $from_phone,
				);
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Message', 'easy-real-estate' ),
				'value' => $message,
			);

			if ( '1' == get_option( 'inspiry_gdpr_in_email', '0' ) && isset( $_POST['gdpr'] ) ) {
				$GDPR_agreement = $_POST['gdpr'];
				if ( ! empty( $GDPR_agreement ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'GDPR Agreement', 'easy-real-estate' ),
						'value' => $GDPR_agreement,
					);
				}
			}

			$email_body = ere_email_template( $email_body, 'agent_contact_form' );

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers = array();
			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers = apply_filters( "inspiry_agent_mail_header", $headers );    // just in case if you want to modify the header in child theme

			/* Send copy of message to admin if configured */
			$theme_send_message_copy = get_option( 'theme_send_message_copy' );
			if ( $theme_send_message_copy == 'true' ) {
				$cc_email = get_option( 'theme_message_copy_email' );
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
			}

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {

				if ( '1' === get_option( 'ere_agency_form_webhook_integration', '0' ) && $is_agency_form ) {
					ere_forms_safe_webhook_post( $_POST, 'agency_contact_form' );
				} elseif ( '1' === get_option( 'ere_agent_form_webhook_integration', '0' ) ) {
					ere_forms_safe_webhook_post( $_POST, 'agent_contact_form' );
				}

				echo json_encode( array(
					'success' => true,
					'message' => esc_html__( 'Message Sent Successfully!', 'easy-real-estate' )
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => esc_html__( 'Server Error: WordPress mail function failed!', 'easy-real-estate' )
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Invalid Request !', 'easy-real-estate' )
				)
			);
		endif;

		do_action('inspiry_after_agent_form_submit');

		die;
	}

	add_action( 'wp_ajax_nopriv_send_message_to_agent', 'ere_send_message_to_agent' );
	add_action( 'wp_ajax_send_message_to_agent', 'ere_send_message_to_agent' );
}

if ( ! function_exists( 'ere_mail_wrapper' ) ) {
	/**
	 * @param $to_email
	 * @param $email_subject
	 * @param $email_body
	 * @param $headers
	 *
	 * @return bool
	 */
	function ere_mail_wrapper( $to_email, $email_subject, $email_body, $headers ) {
		return wp_mail( $to_email, $email_subject, $email_body, $headers );
	}
}

if ( ! function_exists( 'ere_get_email_templates' ) ) {
	/**
	 * Returns email templates HTML code.
	 *
	 * @return array
	 */
	function ere_get_email_templates() {

		$email_templates = array();
		ob_start();
		include( ERE_PLUGIN_DIR . 'includes/email-template/field-template.php' );
		$email_templates['field'] = ob_get_clean();

		ob_start();
		include( ERE_PLUGIN_DIR . 'includes/email-template/email-template.php' );
		$email_templates['email'] = ob_get_clean();

		return $email_templates;
	}
}

if ( ! function_exists( 'ere_apply_email_template' ) ) {
	/**
	 * Applies the email template.
	 *
	 * @param array $form_fields
	 * @param string $form_id
	 * @param string $field_template
	 * @param string $email_template
	 *
	 * @return string
	 */
	function ere_apply_email_template( $form_fields, $form_id, $field_template, $email_template ) {

		$form_fields = apply_filters( 'ere_email_template_form_fields', $form_fields, $form_id );

		$body = esc_html__( 'No field provided.', 'easy-real-estate' );

		if ( ! empty( $form_fields ) && is_array( $form_fields ) ) {
			$body  = '';
			$index = 1;
			foreach ( $form_fields as $form_field ) {
				$field = $field_template;
				if ( 1 === $index ) {
					$field = str_replace( 'border-top:1px solid #dddddd;', '', $field );
				}

				if ( ! empty( $form_field['value'] ) ) {
					$field = str_replace( '{{name}}', $form_field['name'], $field );
					$field = str_replace( '{{value}}', $form_field['value'], $field );
					$body  .= wpautop( $field );
				}

				$index ++;
			}
		}

		$template = str_replace( '{{body_fields}}', $body, $email_template );
		$template = make_clickable( $template );

		return apply_filters( 'ere_email_template', $template, $form_id );
	}
}

if ( ! function_exists( 'ere_email_template' ) ) {
	/**
	 * Build the email template.
	 *
	 * @param array $form_fields
	 * @param string $form_id
	 *
	 * @return string
	 */
	function ere_email_template( $form_fields, $form_id = 'contact_form' ) {
		$email_templates = ere_get_email_templates();
		return ere_apply_email_template( $form_fields, $form_id, $email_templates['field'], $email_templates['email'] );
	}
}

if ( ! function_exists( 'ere_email_template_customizer' ) ) {
	/**
	 * Email Template Customizer Settings
	 */
	function ere_email_template_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Email Template Section
		 */
		$wp_customize->add_section( 'ere_email_template_section', array(
			'title'    => esc_html__( 'Email Template', 'easy-real-estate' ),
			'priority' => 135,
		) );

		/* Header Content */
		$wp_customize->add_setting( 'ere_email_template_header_content', array(
			'type'              => 'option',
			'default'           => 'image',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'ere_sanitize_radio',
		) );
		$wp_customize->add_control( 'ere_email_template_header_content', array(
			'label'       => esc_html__( 'Header Content', 'easy-real-estate' ),
			'description' => esc_html__( 'Content to include in email template header', 'easy-real-estate' ),
			'type'        => 'radio',
			'section'     => 'ere_email_template_section',
			'choices'     => array(
				'image' => esc_html__( 'Logo or Custom Image', 'easy-real-estate' ),
				'title' => esc_html__( 'Title ( by default: Site Title )', 'easy-real-estate' ),
				'both'  => esc_html__( 'Both', 'easy-real-estate' ),
				'none'  => esc_html__( 'None', 'easy-real-estate' ),
			),
		) );

		/* Header Image */
		$wp_customize->add_setting( 'ere_email_template_header_image', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ere_email_template_header_image', array(
			'label'   => esc_html__( 'Header Image', 'easy-real-estate' ),
			'section' => 'ere_email_template_section',
		) ) );

		/* Header Title */
		$wp_customize->add_setting( 'ere_email_template_header_title', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'ere_email_template_header_title', array(
			'label'   => esc_html__( 'Header Title', 'easy-real-estate' ),
			'type'    => 'text',
			'section' => 'ere_email_template_section',
		) );

		/* Header Title Color */
		$wp_customize->add_setting( 'ere_email_template_header_title_color', array(
			'type'              => 'option',
			'default'           => '#333333',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ere_email_template_header_title_color', array(
			'label'   => esc_html__( 'Header Title Color', 'easy-real-estate' ),
			'section' => 'ere_email_template_section',
			'active_callback' => function(){
				$option = get_option('ere_email_template_header_content', 'image');
				if( 'title' === $option || 'both' === $option ){
					return true;
				}
				return false;
			},
		) ) );

		/* Separator */
		if ( class_exists( 'Inspiry_Separator_Control' ) ) {
			$wp_customize->add_setting( 'ere_email_template_separator', array(
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( new Inspiry_Separator_Control( $wp_customize, 'ere_email_template_separator', array(
				'section' => 'ere_email_template_section',
			) ) );
		}

		/* Background Color */
		$wp_customize->add_setting( 'ere_email_template_background_color', array(
			'type'              => 'option',
			'default'           => '#e9eaec',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ere_email_template_background_color', array(
			'label'   => esc_html__( 'Background Color', 'easy-real-estate' ),
			'section' => 'ere_email_template_section',
		) ) );

		/* Body Links Color */
		$wp_customize->add_setting( 'ere_email_template_body_link_color', array(
			'type'              => 'option',
			'default'           => '#ff7f50',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ere_email_template_body_link_color', array(
			'label'   => esc_html__( 'Body Links Color', 'easy-real-estate' ),
			'section' => 'ere_email_template_section',
		) ) );

		/* Separator */
		if ( class_exists( 'Inspiry_Separator_Control' ) ) {
			$wp_customize->add_setting( 'ere_email_template_separator_2', array(
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( new Inspiry_Separator_Control( $wp_customize, 'ere_email_template_separator_2', array(
				'section' => 'ere_email_template_section',
			) ) );
		}

		/* Footer Text */
		$wp_customize->add_setting( 'ere_email_template_footer_text', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_data',
		) );
		$wp_customize->add_control( 'ere_email_template_footer_text', array(
			'label'   => esc_html__( 'Footer Text', 'easy-real-estate' ),
			'type'    => 'textarea',
			'section' => 'ere_email_template_section',
		) );

		/* Footer Text Color */
		$wp_customize->add_setting( 'ere_email_template_footer_text_color', array(
			'type'              => 'option',
			'default'           => '#aaaaaa',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ere_email_template_footer_text_color', array(
			'label'   => esc_html__( 'Footer Text Color', 'easy-real-estate' ),
			'section' => 'ere_email_template_section',
		) ) );

		/* Footer Link Color */
		$wp_customize->add_setting( 'ere_email_template_footer_link_color', array(
			'type'      => 'option',
			'transport' => 'postMessage',
			'default'   => '#949494',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ere_email_template_footer_link_color', array(
			'label'   => esc_html__( 'Footer Link Color', 'easy-real-estate' ),
			'section' => 'ere_email_template_section',
		) ) );
	}

	add_action( 'customize_register', 'ere_email_template_customizer' );
}

if ( ! function_exists( 'ere_sanitize_radio' ) ) {
	/**
	 *
	 * @param $input
	 * @param $setting
	 *
	 * @return string
	 */
	function ere_sanitize_radio( $input, $setting ) {

		// input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
		$input = sanitize_key( $input );

		// get the list of possible radio box options
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// return input if valid or return default option
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}