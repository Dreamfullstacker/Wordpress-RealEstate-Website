<?php
/**
 * Wire Transfer Functions Class
 *
 * Class file for wire transfer payment functions.
 *
 * @since    1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'IMS_Wire_Transfer_Handler' ) ) :
	/**
	 * IMS_Wire_Transfer_Handler.
	 *
	 * Class for wire transfer payment functions.
	 *
	 * @since 1.0.0
	 */
	class IMS_Wire_Transfer_Handler {

		/**
		 * Method: Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			/**
			 * Action to run event on
			 * Doesn't need to be an existing WordPress action
			 *
			 * @param string - ims_wire_membership_schedule_end
			 * @param string - wire_membership_schedule_end
			 */
			add_action( 'ims_wire_membership_schedule_end', array( $this, 'wire_membership_schedule_end' ), 10, 2 );

		}

		/**
		 * Method: Ajax callback to send receipt to user.
		 *
		 * @since 1.0.0
		 */
		public function send_wire_receipt() {

			if ( isset( $_POST['action'] ) && 'ims_send_wire_receipt' === $_POST['action'] && isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'membership-wire-nonce' ) ) {

				// Get membership id.
				$membership_id = ( isset( $_POST['membership_id'] ) ) ? intval( $_POST['membership_id'] ) : false;

				// Get current user.
				$user         = wp_get_current_user();
				$user_id      = $user->ID;
				$user_email   = $user->user_email;
				$admin_email  = get_bloginfo( 'admin_email' ); // Get admin email.
				$header_phone = get_option( 'theme_header_phone' ); // Get header phone number.

				if ( empty( $membership_id ) || empty( $user_id ) ) {
					echo wp_json_encode(
						array(
							'success' => false,
							'message' => esc_html__( 'Please select a membership to continue.', 'inspiry-memberships' ),
						)
					);
					die();
				}

				$membership_title = get_the_title( $membership_id );
				$membership_obj   = ims_get_membership_object( $membership_id ); // Membership object.
				$price            = $membership_obj->get_price(); // Membership price (unformatted).
				$formatted_price  = IMS_Helper_Functions::get_formatted_price( $price ); // Membership price (formatted).

				$receipt_methods = new IMS_Receipt_Method();
				$receipt_id      = $receipt_methods->generate_wire_transfer_receipt( $user_id, $membership_id, false );

				// Membership Receipt Mail to the Subscriber.
				$subject = esc_html__( 'Membership Receipt Information', 'inspiry-memberships' ) . ' - ' . get_bloginfo( 'name' );
				/* translators: %s: membership title */
				$message = sprintf( esc_html__( 'You have successfully applied for the %s membership package on our site.', 'inspiry-memberships' ), '<strong>' . $membership_title . '</strong>' ) . '<br/><br/>';
				$message .= sprintf( esc_html__( 'You chose to pay via Wire Transfer. Please send a payment of %s to the following account.', 'inspiry-memberships' ), $formatted_price ) . '<br/><br/>';

				$wire_settings = get_option( 'ims_wire_settings' );
				if ( ! empty( $wire_settings['ims_wire_account_name'] ) && ! empty( $wire_settings['ims_wire_account_number'] ) ) {
					$message .= sprintf( esc_html__( 'Account Name: %s', 'inspiry-memberships' ), esc_html( $wire_settings['ims_wire_account_name'] ) ) . '<br/>';
					$message .= sprintf( esc_html__( 'Account Number: %s', 'inspiry-memberships' ), esc_html( $wire_settings['ims_wire_account_number'] ) ) . '<br/><br/>';
				}

				$message .= sprintf( esc_html__( 'After sending the payment, notify us at %1$s and include your receipt %2$s number.', 'inspiry-memberships' ), $admin_email, '<strong>' . $receipt_id . '</strong>' ) . '<br/><br/>';
				$message .= esc_html__( 'We will activate your membership as soon as we get your payment confirmation.', 'inspiry-memberships' ) . '<br/><br/>';

				if ( is_email( $admin_email ) ) {
					$message .= esc_html__( 'For any further assistance, email us at', 'inspiry-memberships' ) . ' ' . $admin_email;

					if ( ! empty( $header_phone ) ) {
						$message .= esc_html__( ' OR call us at ', 'inspiry-memberships' ) . ' ' . $header_phone;
					}

					$message .= '<br/><br/>';
				}

				$message .= esc_html__( 'Regards', 'inspiry-memberships' );

				$message = apply_filters( 'ims_membership_receipt_email_message', $message, $user_id, $membership_id, $receipt_id );

				if ( is_email( $user_email ) ) {
					$email = IMS_Email::send_email( $user_email, $subject, $message );

					// Membership Receipt Mail to the Admin.
					if ( is_email( $admin_email ) ) {
						$subject = esc_html__( 'New Membership Receipt Received', 'inspiry-memberships' ) . ' - ' . get_bloginfo( 'name' );
						/* translators: %1$s: membership title, %2$s: reciept formatted price */
						$message  = sprintf( esc_html__( 'You have received a %1$s membership receipt for the payment of %2$s from User ID #%3$s having email address %4$s', 'inspiry-memberships' ), '<strong>' . $membership_title . '</strong>', '<strong>' . $formatted_price . '</strong>', '<strong>' . $user_id . '</strong>', $user_email ) . '<br/><br/>';
						$message .= sprintf( esc_html__( 'User chose to pay via Wire Transfer. Make sure to activate the membership receipt number %1$s as soon as you get the payment confirmation via email at %2$s', 'inspiry-memberships' ), '<strong>' . $receipt_id . '</strong>', $admin_email ) . '<br/><br/>';
						$message  = apply_filters( 'ims_membership_receipt_email_message_admin', $message, $user_id, $membership_id, $receipt_id );

						IMS_Email::send_email( $admin_email, $subject, $message );
					}
				} else {
					echo wp_json_encode(
						array(
							'success' => false,
							'message' => esc_html__( 'Your email address is not valid.', 'inspiry-memberships' ),
						)
					);
					die();
				}

				$response = array();

				if ( $email ) {
					$response = array(
						'success'  => true,
						'order_id' => $receipt_id,
						'message'  => esc_html__( 'Email sent successfully.', 'inspiry-memberships' ),
					);
				} else {
					$response = array(
						'success'  => false,
						'order_id' => '',
						'message'  => esc_html__( 'Error occurred while sending email.', 'inspiry-memberships' ),
					);
				}

				if ( isset( $_POST['checkout_form'] ) ) {
					if ( ! empty( $receipt_id ) ) {
						$response = array(
							'success'  => true,
							'order_id' => $receipt_id,
							'message'  => esc_html__( 'Order Completed Successfully!', 'inspiry-memberships' ),
						);
					} else {
						$response = array(
							'success'  => false,
							'order_id' => '',
							'message'  => esc_html__( 'Error occurred while processing order.', 'inspiry-memberships' ),
						);
					}
				}

				echo wp_json_encode( $response );

				die();
			}
		}

		/**
		 * Method: Activate membership via Wire Transfer.
		 *
		 * @param int    $post_id - Receipt ID from where membership is activated.
		 * @param object $post - Receipt Post Object.
		 *
		 * @since 1.0.0
		 */
		public function activate_membership_via_wire( $post_id, $post ) {

			// Verify the nonce before proceeding.
			if ( ! isset( $_POST['receipt_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['receipt_meta_box_nonce'], 'receipt-meta-box-nonce' ) ) {
				return false;
			}

			// Get the post type object.
			$post_type = get_post_type_object( $post->post_type );

			// Check if the post type is receipt.
			if ( 'ims_receipt' !== $post->post_type ) {
				return false;
			}

			// Check if the current user has permission to edit the post.
			if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
				return false;
			}

			/*
			 * Cancel Wire Transfer Membership If Related Checkbox is Checked.
			 */
			$cancel_membership = ( ! empty( $_POST['cancel_membership'] ) && ( 'on' === $_POST['cancel_membership'] ) ) ? true : false;
			$user_id           = $_POST['user_id'];
			if ( $cancel_membership && $user_id ) {
				$membership_id          = get_user_meta( $user_id, 'ims_current_membership', true ); // Get current membership.
				$ims_membership_methods = new IMS_Membership_Method();
				$ims_membership_methods->cancel_user_membership( $user_id, $membership_id ); // Cancel it.
			}

			// Get receipt object.
			$receipt_obj = ims_get_receipt_object( $post_id );
			if ( empty( $receipt_obj ) ) {
				return false;
			}

			// Check if user has membership already.
			$user_id            = intval( $receipt_obj->get_user_id() );
			$membership_methods = new IMS_Membership_Method();

			// Get receipt id, memberhsip id, status and vendor.
			$receipt_id    = $post_id;
			$membership_id = intval( $receipt_obj->get_membership_id() );
			$status        = ( ! empty( $_POST['status'] ) && ( 'on' === $_POST['status'] ) ) ? true : false;
			$vendor        = $receipt_obj->get_vendor();

			if ( ! empty( $membership_id ) && ! empty( $user_id ) && ! empty( $status ) && ! empty( $vendor ) && 'wire' === $vendor ) {

				// Add membership to user.
				$membership_methods->add_user_membership( $user_id, $membership_id, $vendor );

				// Schedule membership cancelation.
				$this->schedule_membership_end( $user_id, $membership_id );

				// Send email to user.
				IMS_Email::mail_user( $user_id, $membership_id, 'wire' );

				// Sent email to admin.
				IMS_Email::mail_admin( $membership_id, $receipt_id, 'wire' );

				// Update status and related membership due date to the receipt.
				$time_due            = $membership_methods->get_membership_due_date( $membership_id, current_time( 'timestamp' ) );
				$membership_due_date = date( 'Y-m-d H:i', $time_due );

				update_post_meta( $receipt_id, 'ims_receipt_status', 'active' );
				update_post_meta( $receipt_id, 'ims_receipt_membership_due_date', $membership_due_date );

				// Update payment ID.
				$payment_id = ( isset( $_POST['payment_id'] ) && ! empty( $_POST['payment_id'] ) ) ? sanitize_text_field( $_POST['payment_id'] ) : false;
				if ( ! empty( $payment_id ) ) {
					update_post_meta( $receipt_id, 'ims_receipt_payment_id', $payment_id );
				}

				// Add action hook after wire payment is done.
				do_action( 'ims_wire_payment_success', $user_id, $membership_id, $receipt_id );

				return true;
			}

			return false;

		}

		/**
		 * Method: Schedule Wire membership end.
		 *
		 * @param int $user_id - User ID who purchased membership.
		 * @param int $membership_id - ID of the membership purchased.
		 *
		 * @since 1.0.0
		 */
		public function schedule_membership_end( $user_id, $membership_id ) {

			// Bail if user or membership id is empty.
			if ( empty( $user_id ) || empty( $membership_id ) ) {
				return;
			}

			$membership_obj = ims_get_membership_object( $membership_id );
			$time_duration  = $membership_obj->get_duration();
			$time_unit      = $membership_obj->get_duration_unit();

			if ( 'days' === $time_unit ) {
				$seconds = 24 * 60 * 60;
			} elseif ( 'weeks' === $time_unit ) {
				$seconds = 7 * 24 * 60 * 60;
			} elseif ( 'months' === $time_unit ) {
				$seconds = 30 * 24 * 60 * 60;
			} elseif ( 'years' === $time_unit ) {
				$seconds = 365 * 24 * 60 * 60;
			}

			$time_duration = $time_duration * $seconds;

			$schedule_args = array( $user_id, $membership_id );

			/**
			 * Schedule the event
			 *
			 * @param int - unix timestamp of when to run the event
			 * @param string - ims_paypal_membership_schedule_end
			 */
			wp_schedule_single_event( time() + $time_duration, 'ims_wire_membership_schedule_end', $schedule_args );

			// Membership schedulled action hook.
			do_action( 'ims_wire_membership_schedulled', $user_id, $membership_id );

		}

		/**
		 * Method: Function to be called when ims_wire_membership_schedule_end
		 * event is fired.
		 *
		 * @param int $user_id - User ID who purchased membership.
		 * @param int $membership_id - ID of the membership purchased.
		 *
		 * @since 1.0.0
		 */
		public function wire_membership_schedule_end( $user_id, $membership_id ) {

			// Bail if user or membership id is empty.
			if ( empty( $user_id ) || empty( $membership_id ) ) {
				return;
			}

			$ims_membership_methods = new IMS_Membership_Method();
			$ims_membership_methods->cancel_user_membership( $user_id, $membership_id );

		}

		/**
		 * Method: Cancel membership when vendor is wire.
		 *
		 * @param int    $user_id - ID of the current user.
		 * @param string $redirect_url - URL to redirect after membership cancellation.
		 *
		 * @since 1.0.0
		 */
		public static function cancel_wire_membership( $user_id, $redirect_url = '' ) {

			// Bail if user id is empty.
			if ( empty( $user_id ) ) {
				return;
			}

			// Get current membership.
			$membership_id = get_user_meta( $user_id, 'ims_current_membership', true );

			// Cancel it.
			$ims_membership_methods = new IMS_Membership_Method();
			$ims_membership_methods->cancel_user_membership( $user_id, $membership_id );

			// Redirect on success.
			if ( empty( $redirect_url ) ) {
				$redirect_url = esc_url( home_url() );
			}

			wp_safe_redirect( $redirect_url );
			exit;

		}

	}

endif;
