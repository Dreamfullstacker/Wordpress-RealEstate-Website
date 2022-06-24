<?php
/**
 * This file is responsible to handle all booking requests and notification emails.
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */

if ( ! function_exists( 'rvr_booking_request' ) ) {
	/**
	 * Booking form handler.
	 *
	 * @since   1.0.0
	 */
	function rvr_booking_request() {

		if ( isset( $_POST['email'] ) ):

			$nonce = $_POST['nonce'];

			if ( ! wp_verify_nonce( $nonce, 'rvr_booking_request' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Unverified Nonce!', 'realhomes-vacation-rentals' )
				) );
				die;
			}

			$from_email = sanitize_email( $_POST['email'] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Provided Email address is invalid!', 'realhomes-vacation-rentals' )
				) );
				die;
			}

			if ( function_exists( 'ere_is_reCAPTCHA_configured' ) && ere_is_reCAPTCHA_configured() ) {
				// Verify Google reCAPTCHA
				ere_verify_google_recaptcha();
			}

			$property_id    = sanitize_text_field( $_POST['property_id'] );
			$staying_nights = intval( $_POST['staying_nights'] );

			if ( ! empty( $property_id ) && ! empty( $staying_nights ) ) {

				$min_stay_nights = intval( get_post_meta( $property_id, 'rvr_min_stay', true ) );

				if ( ! empty( $min_stay_nights ) && $min_stay_nights > $staying_nights ) {
					echo json_encode(
						array(
							'success' => false,
							'message' => esc_html__( 'You must book at least', 'realhomes-vacation-rentals' ) . " {$min_stay_nights} " . esc_html__( 'nights.', 'realhomes-vacation-rentals' ),
						)
					);
					die;
				}

				// Check if number of booking guests are not exceeding the guests capacity.
				$extra_guests_allowed = get_post_meta( $property_id, 'rvr_guests_capacity_extend', true );
				$guests_capacity      = intval( $_POST['guests_capacity'] );

				// Check if child needs to be booked as an adult.
				if ( 'adult' === $_POST['book_child_as'] ) {
					$booking_guests = intval( $_POST['adult'] ) + intval( $_POST['child'] );
				} else {
					$booking_guests = intval( $_POST['adult'] );
				}

				if ( ( empty( $extra_guests_allowed ) || 'not_allowed' === $extra_guests_allowed ) && ! empty( $guests_capacity ) && $booking_guests > $guests_capacity ) {
					echo json_encode(
						array(
							'success' => false,
							'message' => esc_html__( 'You can select ', 'realhomes-vacation-rentals' ) . " {$guests_capacity} " . esc_html__( 'maximum number of guests.', 'realhomes-vacation-rentals' ),
						)
					);
					die;
				}

				$booking_id = rvr_generate_booking_request( $property_id, $_POST );

			} else {

				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Incorrect information supplied!', 'realhomes-vacation-rentals' )
				) );
				die;
			}

			if ( ! $booking_id ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'Something went wrong, please try again later!', 'realhomes-vacation-rentals' )
				) );
				die;
			}

			if ( rvr_notify_booking_owner( $booking_id ) ) {

				// if globally turned on or it's activated for the current property.

				if ( rvr_is_wc_payment_enabled() && rvr_is_instant_booking( $property_id ) ) {
					WC()->cart->empty_cart();  // Empty the cart before using it.
					$product_id = rhwpa_add_booking_product( $booking_id );
					$cart_id    = WC()->cart->add_to_cart( $product_id, 1 ); // Add newly created product to the cart.

					if ( ! empty( $cart_id ) ) { // If process went successfull, then send the information in ajax response.
						$result['success']      = true;
						$result['cart_id']      = $cart_id;
						$result['checkout_url'] = wc_get_checkout_url();

						// Setting the user information to pre-fill on checkout page.
						$renter_info          = array();
						$renter_name          = explode( ' ', get_post_meta( $booking_id, 'rvr_renter_name', true ) );
						$renter_info['email'] = get_post_meta( $booking_id, 'rvr_renter_email', true );
						$renter_info['num']   = get_post_meta( $booking_id, 'rvr_renter_phone', true );
						if ( isset( $renter_name[0] ) && ! empty( $renter_name[0] ) ) {
							$renter_info['fname'] = sanitize_text_field( $renter_name[0] );
						}
						if ( isset( $renter_name[1] ) && ! empty( $renter_name[1] ) ) {
							$renter_info['lname'] = sanitize_text_field( $renter_name[1] );
						}
						$result['checkout_url'] = add_query_arg( $renter_info, $result['checkout_url'] );

						echo wp_json_encode( $result );
						die;
					}
				} else {
					echo json_encode(
						array(
							'success' => true,
							'message' => esc_html__( "Booking Request Sent Successfully!", 'realhomes-vacation-rentals' )
						)
					);
				}
			} else {
				echo json_encode(
					array(
						'success' => false,
						'message' => esc_html__( "Server Error: WordPress mail function failed!", 'realhomes-vacation-rentals' )
					)
				);
			}
		else:
			echo json_encode( array(
				'success' => false,
				'message' => esc_html__( "Invalid Request!", 'realhomes-vacation-rentals' )
			) );
		endif;
		die;
	}

	add_action( 'wp_ajax_nopriv_rvr_booking_request', 'rvr_booking_request' );
	add_action( 'wp_ajax_rvr_booking_request', 'rvr_booking_request' );
}

if ( ! function_exists( 'rvr_generate_booking_request' ) ) {
	/**
	 * Add booking to the booking post type
	 *
	 * @param null $property_id
	 * @param array $booking_details
	 *
	 * @return bool
	 */
	function rvr_generate_booking_request( $property_id = null, $booking_details = array() ) {

		if ( $property_id ) {

			$property_id    = intval( $property_id );
			$property_title = get_the_title( $property_id );
			$property_url   = get_the_permalink( $property_id );

			// Create booking post object.
			$booking_args = array(
				'post_title'  => $property_id,
				'post_type'   => 'booking',
				'post_status' => 'publish',
			);

			// Insert the booking post into the database.
			$booking_id = wp_insert_post( $booking_args );

			$booking_update = array(
				'ID'         => $booking_id,
				'post_title' => esc_html__( 'Booking:', 'realhomes-vacation-rentals' ) . $booking_id . '-' . $property_id,
			);

			wp_update_post( $booking_update );

			if ( empty( $booking_id ) ) {
				return false;
			} else {

				$booking_date_time = get_the_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $booking_id );
				add_post_meta( $booking_id, 'rvr_request_timestamp', $booking_date_time );
				add_post_meta( $booking_id, 'rvr_property_id', $property_id );

				if ( ! empty( $property_url ) ) {
					add_post_meta( $booking_id, 'rvr_property_url', $property_url );
				}

				$property_custom_id = get_post_meta( $property_id, 'REAL_HOMES_property_id', true );
				if ( ! empty( $property_custom_id ) ) {
					add_post_meta( $booking_id, 'rvr_property_custom_id', $property_custom_id );
				}

				if ( ! empty( $property_title ) ) {
					add_post_meta( $booking_id, 'rvr_property_title', $property_title );
				}

				if ( isset( $booking_details['user_name'] ) && ! empty( $booking_details['user_name'] ) ) {
					add_post_meta( $booking_id, 'rvr_renter_name', $booking_details['user_name'] );
				}

				if ( isset( $booking_details['email'] ) && ! empty( $booking_details['email'] ) ) {
					add_post_meta( $booking_id, 'rvr_renter_email', $booking_details['email'] );
				}

				if ( isset( $booking_details['check_in'] ) && ! empty( $booking_details['check_in'] ) ) {
					add_post_meta( $booking_id, 'rvr_check_in', $booking_details['check_in'] );
				}

				if ( isset( $booking_details['check_out'] ) && ! empty( $booking_details['check_out'] ) ) {
					add_post_meta( $booking_id, 'rvr_check_out', $booking_details['check_out'] );
				}

				if ( isset( $booking_details['adult'] ) && ! empty( $booking_details['adult'] ) ) {
					add_post_meta( $booking_id, 'rvr_adult', $booking_details['adult'] );
				}

				if ( isset( $booking_details['child'] ) && ! empty( $booking_details['child'] ) ) {
					add_post_meta( $booking_id, 'rvr_child', $booking_details['child'] );
				}

				if ( isset( $booking_details['phone'] ) && ! empty( $booking_details['phone'] ) ) {
					add_post_meta( $booking_id, 'rvr_renter_phone', $booking_details['phone'] );
				}

				if ( isset( $booking_details['staying_nights'] ) && ! empty( $booking_details['staying_nights'] ) ) {
					add_post_meta( $booking_id, 'rvr_staying_nights', $booking_details['staying_nights'] );
				}

				if ( isset( $booking_details['avg_price_per_night'] ) && ! empty( $booking_details['avg_price_per_night'] ) ) {
					add_post_meta( $booking_id, 'rvr_price_per_night', $booking_details['avg_price_per_night'] );
				}

				if ( isset( $booking_details['price_staying_nights'] ) && ! empty( $booking_details['price_staying_nights'] ) ) {
					add_post_meta( $booking_id, 'rvr_price_staying_nights', $booking_details['price_staying_nights'] );
				}

				if ( isset( $booking_details['extra_guests'] ) && ! empty( $booking_details['extra_guests'] ) ) {
					add_post_meta( $booking_id, 'rvr_extra_guests', $booking_details['extra_guests'] );
				}

				if ( isset( $booking_details['extra_guests_cost'] ) && ! empty( $booking_details['extra_guests_cost'] ) ) {
					add_post_meta( $booking_id, 'rvr_extra_guests_cost', $booking_details['extra_guests_cost'] );
				}

				if ( isset( $booking_details['services_charges'] ) && ! empty( $booking_details['services_charges'] ) ) {
					add_post_meta( $booking_id, 'rvr_services_charges', $booking_details['services_charges'] );
				}

				if ( isset( $booking_details['subtotal'] ) && ! empty( $booking_details['subtotal'] ) ) {
					add_post_meta( $booking_id, 'rvr_subtotal_price', $booking_details['subtotal'] );
				}

				if ( isset( $booking_details['govt_tax'] ) && ! empty( $booking_details['govt_tax'] ) ) {
					add_post_meta( $booking_id, 'rvr_govt_tax', $booking_details['govt_tax'] );
				}

				if ( isset( $booking_details['total_price'] ) && ! empty( $booking_details['total_price'] ) ) {
					add_post_meta( $booking_id, 'rvr_total_price', $booking_details['total_price'] );
				}

				// Add additional fees to booking meta.
				$additional_fees_data = get_post_meta( $property_id, 'rvr_additional_fees', true );
				if ( ! empty( $additional_fees_data ) && is_array( $additional_fees_data ) ) {
					$fee_labels      = array_column( $additional_fees_data, 'rvr_fee_label' );
					$additional_fees = array();
					foreach ( $fee_labels as $fee_label ) {
						$fee_key                       = sanitize_key( $fee_label );
						$additional_fees[ $fee_label ] = ere_format_amount( $booking_details[ $fee_key ] );
					}

					add_post_meta( $booking_id, 'rvr_additional_fees_paid', $additional_fees );
				}

				add_post_meta( $booking_id, 'rvr_booking_status', 'pending' );
				add_post_meta( $booking_id, 'rvr_booking_status_alt', 'pending' );
				add_post_meta( $booking_id, 'rvr_booking_dates_alt', $booking_details['check_in'] . ' | ' . $booking_details['check_out'] );

				// update guest about booking received.
				rvr_notify_booking_guest( $booking_id, $booking_details['email'], $booking_details['user_name'] );
			}
		}

		return $booking_id;

	}
}

if ( ! function_exists( 'rvr_notify_booking_owner' ) ) {
	/**
	 * Notify booked property owner with booking details.
	 */
	function rvr_notify_booking_owner( $booking_id ) {
		/**
		 * Booking request email notifications
		 */
		$maybe_notification = false;
		$recipients         = array();
		$options            = get_option( 'rvr_settings' );
		$property_id        = get_post_meta( $booking_id, 'rvr_property_id', true );

		// Admin email.
		if ( is_email( $options['rvr_notification_email'] ) ) {
			$recipients[]       = $options['rvr_notification_email'];
			$maybe_notification = true;
		}

		// Property Owner email.
		$owner_id    = get_post_meta( $property_id, 'rvr_property_owner', true );
		$owner_email = get_post_meta( $owner_id, 'rvr_owner_email', true );

		if ( is_email( $owner_email ) && $options['rvr_owner_notification'] ) {
			$recipients[]       = $owner_email;
			$maybe_notification = true;
		}

		if ( ! $maybe_notification ) {
			echo json_encode( array(
				'success' => true,
				'message' => esc_html__( "Booking Request Sent Successfully!", 'realhomes-vacation-rentals' )
			) );
			die;
		}

		// Property Booking Details.
		$booking_details                         = array();
		$booking_details['user_name']            = sanitize_text_field( $_POST['user_name'] );
		$booking_details['user_phone']           = sanitize_text_field( $_POST['phone'] );
		$booking_details['property_title']       = get_the_title( $property_id );
		$booking_details['property_custom_id']   = get_post_meta( $property_id, 'REAL_HOMES_property_id', true );
		$booking_details['check_in']             = sanitize_text_field( $_POST['check_in'] );
		$booking_details['check_out']            = sanitize_text_field( $_POST['check_out'] );
		$booking_details['adult']                = intval( $_POST['adult'] );
		$booking_details['child']                = intval( $_POST['child'] );
		$booking_details['staying_nights']       = intval( $_POST['staying_nights'] );
		$booking_details['price_per_night']      = ere_format_amount( $_POST['avg_price_per_night'] );
		$booking_details['price_staying_nights'] = ere_format_amount( $_POST['price_staying_nights'] );
		$booking_details['govt_tax']             = ere_format_amount( $_POST['govt_tax'] );
		$booking_details['services_charges']     = ere_format_amount( $_POST['services_charges'] );
		$booking_details['extra_guests']         = sanitize_text_field( $_POST['extra_guests'] );
		$booking_details['extra_guests_cost']    = isset( $_POST['extra_guests_cost'] ) ? ere_format_amount( $_POST['extra_guests_cost'] ) : '';
		$booking_details['subtotal']             = ere_format_amount( $_POST['subtotal'] );
		$booking_details['total_price']          = ere_format_amount( $_POST['total_price'] );
		$booking_details['booking_title']        = esc_html( get_the_title( $booking_id ) );

		$email_subject = esc_html__( 'New booking request sent by', 'realhomes-vacation-rentals' ) . ' ' . esc_html( $booking_details['user_name'] ) . ' ' . esc_html__( 'using booking form at', 'realhomes-vacation-rentals' ) . ' ' . esc_html( get_bloginfo( 'name' ) );
		$email_body    = esc_html__( "You have received a booking request from: ", 'realhomes-vacation-rentals' ) . esc_html( $booking_details['user_name'] ) . " <br/><br/>";
		$email_body    .= esc_html__( "Here are the booking details: ", 'realhomes-vacation-rentals' ) . " <br/><br/>";

		if ( ! empty( $booking_details['booking_title'] ) ) {
			$email_body .= sprintf( esc_html__( '%sBooking ID:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . "<a href='" . get_edit_post_link( $booking_id ) . "'>" . $booking_details['booking_title'] . "</a> <br/>";
		}

		if ( ! empty( $booking_details['property_title'] ) ) {
			$email_body .= sprintf( esc_html__( '%sProperty:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . "<a href='" . get_the_permalink( $property_id ) . "'>" . $booking_details['property_title'] . "</a> <br/>";
		}

		if ( ! empty( $booking_details['property_custom_id'] ) ) {
			$email_body .= sprintf( esc_html__( '%sProperty ID:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['property_custom_id'] . " <br/>";
		}

		if ( ! empty( $booking_details['user_phone'] ) ) {
			$email_body .= sprintf( esc_html__( '%sPhone Number:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['user_phone'] . " <br/>";
		}

		if ( ! empty( $booking_details['check_in'] ) ) {
			$email_body .= sprintf( esc_html__( '%sCheck In Date:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['check_in'] . " <br/>";
		}

		if ( ! empty( $booking_details['check_out'] ) ) {
			$email_body .= sprintf( esc_html__( '%sCheck Out Date:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['check_out'] . " <br/>";
		}

		if ( ! empty( $booking_details['adult'] ) ) {
			$email_body .= sprintf( esc_html__( '%sNumber of Adults:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['adult'] . " <br/>";
		}

		if ( ! empty( $booking_details['child'] ) ) {
			$email_body .= sprintf( esc_html__( '%sNumber of Children:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['child'] . " <br/>";
		}

		if ( ! empty( $booking_details['staying_nights'] ) ) {
			$email_body .= sprintf( esc_html__( '%sStaying Nights:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['staying_nights'] . " <br/>";
		}

		if ( ! empty( $booking_details['price_per_night'] ) ) {
			$email_body .= sprintf( esc_html__( '%sPer Night Price:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['price_per_night'] . " <br/>";
		}

		if ( ! empty( $booking_details['price_staying_nights'] ) ) {
			$email_body .= sprintf( esc_html__( '%sPrice for Staying Nights:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['price_staying_nights'] . " <br/>";
		}

		if ( ! empty( $booking_details['extra_guests'] ) && ! empty( $booking_details['extra_guests_cost'] ) ) {
			$email_body .= sprintf( esc_html__( '%sExtra Guests (%s):%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', $booking_details['extra_guests'], '</strong>' ) . $booking_details['extra_guests_cost'] . " <br/>";
		}

		// Add additional fees detail.
		$additional_fees = get_post_meta( $booking_id, 'rvr_additional_fees_paid', true );
		if ( ! empty( $additional_fees ) && is_array( $additional_fees ) ) {
			foreach ( $additional_fees as $fee_name => $fee_amount ) {
				$email_body .= sprintf( "%s{$fee_name}:%s ", '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $fee_amount . " <br/>";
			}
		}

		if ( ! empty( $booking_details['services_charges'] ) ) {
			$email_body .= sprintf( esc_html__( '%sServices Charges:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['services_charges'] . " <br/>";
		}

		if ( ! empty( $booking_details['subtotal'] ) ) {
			$email_body .= '<hr style="width: 300px; display: inline-block; color: #f7f7f7;" /><br/>';
			$email_body .= sprintf( esc_html__( '%sSubtotal:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['subtotal'] . " <br/>";
		}

		if ( ! empty( $booking_details['govt_tax'] ) ) {
			$email_body .= sprintf( esc_html__( '%sGovernment Tax:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['govt_tax'] . " <br/>";
		}

		if ( ! empty( $booking_details['total_price'] ) ) {
			$email_body .= '<hr style="width: 300px; display: inline-block; color: #f7f7f7;" /><br/>';
			$email_body .= sprintf( esc_html__( '%sTotal Price:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['total_price'] . " <br/>";
		}

		$from_email = sanitize_email( $_POST['email'] );
		$email_body .= wpautop( sprintf( esc_html__( 'You can contact %1$s via email: %2$s', 'realhomes-vacation-rentals' ), $booking_details['user_name'], $from_email ) );
		/*
			* Email Headers ( Reply To and Content Type )
			*/
		$headers   = array();
		$headers[] = 'Reply-To: ' . esc_html( $booking_details['user_name'] ) . " <{$from_email}>";
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers   = apply_filters( 'rvr_contact_mail_header', $headers );    // just in case if you want to modify the header in child theme.

		if ( wp_mail( $recipients, $email_subject, $email_body, $headers ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'rvr_notify_booking_guest' ) ) {
	/**
	 * Notify booking guest about booking received
	 *
	 * @param $guest_email
	 * @param $guest_name
	 */
	function rvr_notify_booking_guest( $booking_id, $guest_email, $guest_name ) {

		$headers   = array();
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		$subject = html_entity_decode( esc_html__( 'Your booking request has been received!', 'realhomes-vacation-rentals' ) );
		$body    = esc_html__( 'Hi ', 'realhomes-vacation-rentals' ) . esc_html( $guest_name ) . ',<br><br>';
		$body    .= esc_html__( 'Your booking request has been received.', 'realhomes-vacation-rentals' );

		$booking_title = get_the_title( $booking_id );
		if ( ! empty( $booking_title ) ) {
			$body .= esc_html__( 'Your booking ID is', 'realhomes-vacation-rentals' ) . '<strong> ' . esc_html( $booking_title ) . '</strong>.';
		}
		$property_id = get_post_meta( $booking_id, 'rvr_property_id', true );
		if ( rvr_is_wc_payment_enabled() && rvr_is_instant_booking( $property_id ) ) {
			$body .= esc_html__( ' We will confirm your booking as soon as you pay the booking payment.', 'realhomes-vacation-rentals' ) . '<br><br>';
		} else {
			$body .= esc_html__( ' We will confirm your booking as soon as possible and update you.', 'realhomes-vacation-rentals' ) . '<br><br>';
		}

		$body .= esc_html__( 'Thank you.', 'realhomes-vacation-rentals' );

		wp_mail( $guest_email, $subject, $body, $headers );
	}
}

if ( ! function_exists( 'rvr_notify_booking_status_change' ) ) {
	/**
	 * Notify booking author about booking status change
	 *
	 * @param $meta_id
	 * @param $booking_id
	 * @param $meta_key
	 * @param $new_meta_value
	 */
	function rvr_notify_booking_status_change( $meta_id, $booking_id, $meta_key, $new_meta_value ) {

		$email_notification = false; // Email notification flag of booking information update.

		if ( 'rvr_check_in' === $meta_key || 'rvr_check_out' === $meta_key ) {
			// update property availability table for the property availability calendar.
			$booking_status = get_post_meta( $booking_id, 'rvr_booking_status', true );
			rvr_update_property_availability_table( $booking_id, $booking_status );

			// update alternative booking dates meta after dates distinguished.
			$check_in_date     = get_post_meta( $booking_id, 'rvr_check_in', true );
			$check_out_date    = get_post_meta( $booking_id, 'rvr_check_out', true );
			$booking_new_dates = $check_in_date . ' | ' . $check_out_date;
			$booking_old_dates = get_post_meta( $booking_id, 'rvr_booking_dates_alt', true );
			update_post_meta( $booking_id, 'rvr_booking_dates_alt', $booking_new_dates );

			// Set the email notification flag true.
			$email_notification = true;
		} elseif ( 'rvr_booking_status' === $meta_key ) {
			// update property availability table for the property availability calendar.
			rvr_update_property_availability_table( $booking_id, $new_meta_value );

			// update alternative booking status meta after status distinguished.
			$booking_old_status = get_post_meta( $booking_id, 'rvr_booking_status_alt', true );
			update_post_meta( $booking_id, 'rvr_booking_status_alt', $new_meta_value );

			// Set the email notification flag true.
			$email_notification = true;
		}

		if ( $email_notification ) {
			// email booking author about booking status change.
			$booking_author_email = get_post_meta( $booking_id, 'rvr_renter_email', true );

			if ( is_email( $booking_author_email ) ) {

				$booking_author_name = get_post_meta( $booking_id, 'rvr_renter_name', true );
				$administrator_email = get_option( 'rvr_settings' )['rvr_notification_email'];
				$administrator_phone = get_option( 'rvr_settings' )['rvr_contact_phone'];
				$property_id         = get_post_meta( $booking_id, 'rvr_property_id', true );
				$property_url        = get_the_permalink( $property_id );
				$property_title      = get_the_title( $property_id );

				$headers   = array();
				$headers[] = "Content-Type: text/html; charset=UTF-8";

				$subject = html_entity_decode( esc_html__( 'Your [', 'realhomes-vacation-rentals' ) . get_the_title( $booking_id ) . esc_html__( '] request is Updated!', 'realhomes-vacation-rentals' ) );
				$body    = esc_html__( 'Hi ', 'realhomes-vacation-rentals' ) . esc_html( $booking_author_name ) . ',<br><br>';

				if ( 'rvr_booking_status' === $meta_key ) {
					$body .= esc_html__( 'Your [', 'realhomes-vacation-rentals' ) . get_the_title( $booking_id ) . esc_html__( '] request status is changed from ', 'realhomes-vacation-rentals' ) . '<strong>' . ucfirst( $booking_old_status ) . '</strong>' . ' to ' . '<strong>' . ucfirst( $new_meta_value ) . '</strong>';
				} else {
					$body .= esc_html__( 'Your [', 'realhomes-vacation-rentals' ) . get_the_title( $booking_id ) . esc_html__( '] request reservation dates are changed from ', 'realhomes-vacation-rentals' ) . '<strong>(' . esc_html( $booking_old_dates ) . ')</strong>' . ' to ' . '<strong>(' . esc_html( $booking_new_dates ) . ')</strong>';
				}

				if ( ! empty( $property_url ) && ! empty( $property_title ) ) {
					$body .= esc_html__( ' for the ', 'realhomes-vacation-rentals' ) . '<a href="' . esc_url( $property_url ) . '" target="_blank">' . esc_html( $property_title ) . '</a>' . esc_html__( ' property.', 'realhomes-vacation-rentals' ) . '<br><br>';
				} else {
					$body .= '.<br><br>';
				}

				// Property Booking Details.
				$booking_details                         = array();
				$booking_details['property_title']       = get_the_title( $property_id );
				$booking_details['check_in']             = get_post_meta( $booking_id, 'rvr_check_in', true );
				$booking_details['check_out']            = get_post_meta( $booking_id, 'rvr_check_out', true );
				$booking_details['adult']                = get_post_meta( $booking_id, 'rvr_adult', true );
				$booking_details['child']                = get_post_meta( $booking_id, 'rvr_child', true );
				$booking_details['staying_nights']       = get_post_meta( $booking_id, 'rvr_staying_nights', true );
				$booking_details['extra_guests']         = get_post_meta( $booking_id, 'rvr_extra_guests', true );
				$booking_details['price_per_night']      = ere_format_amount( get_post_meta( $booking_id, 'rvr_price_per_night', true ) );
				$booking_details['price_staying_nights'] = ere_format_amount( get_post_meta( $booking_id, 'rvr_price_staying_nights', true ) );
				$booking_details['services_charges']     = ere_format_amount( get_post_meta( $booking_id, 'rvr_services_charges', true ) );
				$booking_details['extra_guests_cost']    = ere_format_amount( get_post_meta( $booking_id, 'rvr_extra_guests_cost', true ) );
				$booking_details['subtotal']             = ere_format_amount( get_post_meta( $booking_id, 'rvr_subtotal_price', true ) );
				$booking_details['govt_tax']             = ere_format_amount( get_post_meta( $booking_id, 'rvr_govt_tax', true ) );
				$booking_details['total_price']          = ere_format_amount( get_post_meta( $booking_id, 'rvr_total_price', true ) );
				$booking_details['payment_status']       = get_post_meta( $booking_id, 'rvr_payment_status', true );

				$body .= esc_html__( 'Here are the booking details: ', 'realhomes-vacation-rentals' ) . ' <br/><br/>';

				if ( ! empty( $booking_details['user_phone'] ) ) {
					$body .= sprintf( esc_html__( '%sPhone Number:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['user_phone'] . " <br/>";
				}

				if ( ! empty( $booking_details['property_title'] ) ) {
					$body .= sprintf( esc_html__( '%sProperty:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . "<a href='" . get_the_permalink( $property_id ) . "'>" . $booking_details['property_title'] . "</a> <br/>";
				}

				if ( ! empty( $booking_details['property_custom_id'] ) ) {
					$body .= sprintf( esc_html__( '%sProperty ID:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['property_custom_id'] . " <br/>";
				}

				if ( ! empty( $booking_details['check_in'] ) ) {
					$body .= sprintf( esc_html__( '%sCheck In Date:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['check_in'] . " <br/>";
				}

				if ( ! empty( $booking_details['check_out'] ) ) {
					$body .= sprintf( esc_html__( '%sCheck Out Date:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['check_out'] . " <br/>";
				}

				if ( ! empty( $booking_details['adult'] ) ) {
					$body .= sprintf( esc_html__( '%sNumber of Adults:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['adult'] . " <br/>";
				}

				if ( ! empty( $booking_details['child'] ) ) {
					$body .= sprintf( esc_html__( '%sNumber of Children:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['child'] . " <br/>";
				}

				if ( ! empty( $booking_details['staying_nights'] ) ) {
					$body .= sprintf( esc_html__( '%sStaying Nights:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['staying_nights'] . " <br/>";
				}

				if ( ! empty( $booking_details['price_per_night'] ) ) {
					$body .= sprintf( esc_html__( '%sPer Night Price:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['price_per_night'] . " <br/>";
				}

				if ( ! empty( $booking_details['price_staying_nights'] ) ) {
					$body .= sprintf( esc_html__( '%sPrice for Staying Nights:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['price_staying_nights'] . " <br/>";
				}


				if ( ! empty( $booking_details['extra_guests'] ) && ! empty( $booking_details['extra_guests_cost'] ) ) {
					$body .= sprintf( esc_html__( '%sExtra Guests (%s):%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', $booking_details['extra_guests'], '</strong>' ) . $booking_details['extra_guests_cost'] . " <br/>";
				}

				if ( ! empty( $booking_details['services_charges'] ) ) {
					$body .= sprintf( esc_html__( '%sServices Charges:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['services_charges'] . " <br/>";
				}

				// Add additional fees detail.
				$additional_fees = get_post_meta( $booking_id, 'rvr_additional_fees_paid', true );
				if ( ! empty( $additional_fees ) && is_array( $additional_fees ) ) {
					foreach ( $additional_fees as $fee_name => $fee_amount ) {
						$body .= sprintf( "%s{$fee_name}:%s ", '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $fee_amount . " <br/>";
					}
				}

				if ( ! empty( $booking_details['subtotal'] ) ) {
					$body .= '<hr style="width: 300px; display: inline-block; color: #f7f7f7;" /><br/>';
					$body .= sprintf( esc_html__( '%sSubtotal:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['subtotal'] . " <br/>";
				}

				if ( ! empty( $booking_details['govt_tax'] ) ) {
					$body .= sprintf( esc_html__( '%sGovernment Tax:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['govt_tax'] . " <br/>";
				}

				if ( ! empty( $booking_details['total_price'] ) ) {
					$body .= '<hr style="width: 300px; display: inline-block; color: #f7f7f7;" /><br/>';
					$body .= sprintf( esc_html__( '%sTotal Price:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . $booking_details['total_price'] . " <br/>";
				}

				if ( ! empty( $booking_details['payment_status'] ) ) {
					$body .= sprintf( esc_html__( '%sPayment Status:%s ', 'realhomes-vacation-rentals' ), '<strong style="min-width: 150px; display: inline-block; margin-bottom: 5px;">', '</strong>' ) . ucfirst( $booking_details['payment_status'] ) . " <br/>";
				}

				$body .= '<br/>' . sprintf( esc_html__( 'You can call administrator on this number %s or contact via email at %s', 'realhomes-vacation-rentals' ), '<strong>' . $administrator_phone . '</strong>', '<strong>' . $administrator_email . '</strong>' );

				wp_mail( $booking_author_email, $subject, $body, $headers );
			}
		}
	}

	add_action( 'updated_post_meta', 'rvr_notify_booking_status_change', 10, 4 );
}

if ( ! function_exists( 'rvr_update_property_seasonal_prices_table' ) ) {
	/**
	 * Update property seasonal prices table.
	 *
	 * @param $meta_id
	 * @param $property_id
	 * @param $meta_key
	 * @param $new_meta_value
	 */
	function rvr_update_property_seasonal_prices_table( $meta_id, $property_id, $meta_key, $new_meta_value ) {

		if ( 'rvr_seasonal_pricing' === $meta_key ) {

			$seasonal_prices = $new_meta_value;

			if ( ! empty( $seasonal_prices ) && is_array( $seasonal_prices ) ) {
				$seasonal_prices_list = array();
				foreach ( $seasonal_prices as $seasonal_price ) {

					if ( empty( $seasonal_price['rvr_price_start_date'] ) || empty( $seasonal_price['rvr_price_end_date'] ) || empty( $seasonal_price['rvr_price_amount'] ) ) {
						continue;
					}

					$begin = new DateTime( $seasonal_price['rvr_price_start_date'] );
					$end   = new DateTime( $seasonal_price['rvr_price_end_date'] );
					$end   = $end->modify( '+1 day' );

					$interval   = new DateInterval( 'P1D' );
					$date_range = new DatePeriod( $begin, $interval, $end );

					foreach ( $date_range as $date ) {
						$seasonal_prices_list[ $date->format( 'Y-m-d' ) ] = $seasonal_price['rvr_price_amount'];
					}
				}

				update_post_meta( $property_id, 'rvr_seasonal_prices_table', $seasonal_prices_list );

				$property_ids = rvr_get_translation_ids( $property_id ); // Property translation ids if any.

				if ( is_array( $property_ids ) && count( $property_ids ) > 1 ) {
					// Update current property and its all translation properties' seasonal pricing table.
					foreach ( $property_ids as $property_id ) {
						update_post_meta( $property_id, 'rvr_seasonal_prices_table', $seasonal_prices_list );
					}
				} else {
					// Update current property seasonal prices table.
					update_post_meta( $property_id, 'rvr_seasonal_prices_table', $seasonal_prices_list );
				}
			} else {
				$property_ids = rvr_get_translation_ids( $property_id ); // Property translation ids if any.

				if ( is_array( $property_ids ) && count( $property_ids ) > 1 ) {
					foreach ( $property_ids as $property_id ) {
						delete_post_meta( $property_id, 'rvr_seasonal_prices_table' );
					}
				} else {
					delete_post_meta( $property_id, 'rvr_seasonal_prices_table' );
				}

			}
		}
	}

	add_action( 'added_post_meta', 'rvr_update_property_seasonal_prices_table', 10, 4 );
	add_action( 'updated_post_meta', 'rvr_update_property_seasonal_prices_table', 10, 4 );
	add_action( 'deleted_post_meta', 'rvr_update_property_seasonal_prices_table', 10, 4 );
}

if ( ! function_exists( 'rvr_fetch_staying_nights_cost' ) ) {
	/**
	 * Prepare and return staying nights cost as per property pricing table.
	 */
	function rvr_fetch_staying_nights_cost() {

		if ( ! empty( $_POST['property_id'] ) && ! empty( $_POST['check_in'] ) && ! empty( $_POST['check_out'] ) && ! empty( $_POST['default_price'] ) ) {

			$property_id     = intval( $_POST['property_id'] );
			$default_price   = intval( $_POST['default_price'] );
			$check_in_date   = esc_html( $_POST['check_in'] );
			$check_out_date  = esc_html( $_POST['check_out'] );
			$total_amount    = 0;
			$seasonal_prices = get_post_meta( $property_id, 'rvr_seasonal_prices_table', true );

			if ( ! empty( $seasonal_prices ) && is_array( $seasonal_prices ) ) {
				$start_date = new DateTime( $check_in_date );
				$end_date   = new DateTime( $check_out_date );
				$interval   = new DateInterval( 'P1D' );
				$date_range = new DatePeriod( $start_date, $interval, $end_date );

				foreach ( $date_range as $date ) {
					$booking_dates[] = $date->format( 'Y-m-d' );
				}

				if ( empty( $booking_dates ) && ( $check_in_date === $check_out_date ) ) {
					$booking_dates[] = $check_in_date;
				}
				foreach ( $booking_dates as $booking_date ) {
					if ( ! empty( $seasonal_prices[ $booking_date ] ) ) {
						$total_amount += intval( $seasonal_prices[ $booking_date ] );
					} else {
						$total_amount += $default_price;
					}
				}

				echo wp_json_encode( $total_amount );
			}
		} else {
			echo esc_html__( 'Invalid Request!', 'realhomes-vacation-rentals' );
		}

		die;
	}

	add_action( 'wp_ajax_fetch_staying_nights_cost', 'rvr_fetch_staying_nights_cost' );
	add_action( 'wp_ajax_nopriv_fetch_staying_nights_cost', 'rvr_fetch_staying_nights_cost' );
}

if ( ! function_exists( 'rvr_update_property_availability_table' ) ) {
	/**
	 * Maintain property availability table
	 *
	 * @param $booking_id
	 * @param $new_meta_value
	 */
	function rvr_update_property_availability_table( $booking_id, $new_meta_value ) {

		$property_id           = get_post_meta( $booking_id, 'rvr_property_id', true );
		$property_availability = get_post_meta( $property_id, 'rvr_property_availability_table', true );

		if ( empty( $property_availability ) || ! is_array( $property_availability ) ) {
			$property_availability = array();
		}

		if ( 'confirmed' === $new_meta_value ) {
			$check_in                             = get_post_meta( $booking_id, 'rvr_check_in', true );
			$check_out                            = get_post_meta( $booking_id, 'rvr_check_out', true );
			$property_availability[ $booking_id ] = array( $check_in, $check_out );
		} else {
			unset( $property_availability[ $booking_id ] );
		}

		$property_ids = rvr_get_translation_ids( $property_id ); // Property translation ids if any.

		if ( is_array( $property_ids ) && count( $property_ids ) > 1 ) {
			// Update current property and its all translation properties' availablity table.
			foreach ( $property_ids as $property_id ) {
				update_post_meta( $property_id, 'rvr_property_availability_table', $property_availability );
			}
		} else {
			// Update current property availability table.
			update_post_meta( $property_id, 'rvr_property_availability_table', $property_availability );
		}
	}
}

if ( ! function_exists( 'rvr_format_prices' ) ) {
	/**
	 * Format the calculated prices for the booking request
	 */
	function rvr_format_prices() {

		$formatted_prices = array();

		foreach ( $_POST['prices'] as $field_name => $field_value ) {
			$formatted_prices[ $field_name ] = ere_format_amount( $field_value );
		}

		echo json_encode( array(
			'success'          => true,
			'formatted_prices' => $formatted_prices
		) );
		die;
	}

	add_action( 'wp_ajax_nopriv_rvr_format_prices', 'rvr_format_prices' );
	add_action( 'wp_ajax_rvr_format_prices', 'rvr_format_prices' );
}

if ( ! function_exists( 'inspiry_generateRandomString' ) ) {
	/**
	 * Return a random alphanumeric string
	 *
	 * @param int $length
	 *
	 * @return string
	 */
	function inspiry_generateRandomString( $length = 10 ) {
		$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen( $characters );
		$randomString     = '';
		for ( $i = 0; $i < $length; $i ++ ) {
			$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
		}

		return $randomString;
	}
}

if ( ! function_exists( 'rvr_get_translation_ids' ) ) {
	/**
	 * Get all translation ids of a property by the given property id.
	 *
	 * @param int $property_id - Property ID.
	 */
	function rvr_get_translation_ids( $property_id ) {

		$langauges = apply_filters( 'wpml_active_languages', null );

		if ( is_array( $langauges ) ) {
			$lang_codes = array();
			$prop_ids   = array();

			foreach ( $langauges as $langauge_code => $lang_data ) {
				$lang_codes[] = $langauge_code;
			}

			foreach ( $lang_codes as $lang_code ) {
				$prop_ids[] = apply_filters( 'wpml_object_id', $property_id, 'post', true, $lang_code );
			}

			return $prop_ids;
		}
	}
}
