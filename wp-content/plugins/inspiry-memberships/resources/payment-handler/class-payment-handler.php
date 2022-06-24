<?php
/**
 * General Payment Class
 *
 * Class file for general payment related functions.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * IMS_Payment_Handler.
 *
 * Class file for general payment related functions.
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'IMS_Payment_Handler' ) ) :
	/**
	 * This class handle payments related actions gobally.
	 */
	class IMS_Payment_Handler {

		/**
		 * Method: Cancel user membership manually.
		 *
		 * @since 1.0.0
		 */
		public function cancel_user_membership_request() {

			if ( isset( $_POST['action'] )
					&& 'ims_cancel_user_membership' === $_POST['action']
					&& isset( $_POST['ims_cancel_membership_nonce'] )
					&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ims_cancel_membership_nonce'] ) ), 'ims-cancel-membership-nonce' ) ) {

				// Bail if user id is empty.
				if ( ! isset( $_POST['user_id'] ) || empty( $_POST['user_id'] ) ) {
					return;
				}

				$user_id = intval( $_POST['user_id'] );

				// Get current vendor.
				$vendor       = get_user_meta( $user_id, 'ims_current_vendor', true );
				$redirect_url = esc_url( realhomes_get_dashboard_page_url( 'membership&submodule=packages' ) );

				if ( 'stripe' === $vendor ) {
					IMS_Stripe_Payment_Handler::cancel_stripe_membership( $user_id );
				} elseif ( 'paypal' === $vendor ) {
					$ims_paypal_payment_handler = new IMS_PayPal_Payment_Handler();
					$ims_paypal_payment_handler->cancel_paypal_membership( $user_id, $redirect_url );
				} elseif ( 'wire' === $vendor ) {
					IMS_Wire_Transfer_Handler::cancel_wire_membership( $user_id, $redirect_url );
				} else {
					IMS_Wire_Transfer_Handler::cancel_wire_membership( $user_id, $redirect_url );
				}
			}
		}

		/**
		 * Method: Handle free membership request.
		 *
		 * @since 1.0.0
		 */
		public function subscribe_free_membership() {

			if ( isset( $_POST['action'] )
					&& 'ims_subscribe_membership' === $_POST['action']
					&& isset( $_POST['nonce'] )
					&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'membership-select-nonce' ) ) {

				// Bail if membership id is empty.
				if ( ! isset( $_POST['membership_id'] ) || empty( $_POST['membership_id'] ) ) {
					return;
				}

				$membership_id = intval( $_POST['membership_id'] );

				// Get current user.
				$user    = wp_get_current_user();
				$user_id = $user->ID;

				$membership_methods = new IMS_Membership_Method();
				$receipt_methods    = new IMS_Receipt_Method();

				// Add membership.
				$membership_methods->add_user_membership( $user_id, $membership_id, 'wire' );

				// Generate receipt.
				$receipt_id = $receipt_methods->generate_wire_transfer_receipt( $user_id, $membership_id, false );

				if ( ! empty( $receipt_id ) ) {

					// Mail the users.
					IMS_Email::mail_user( $user_id, $membership_id, 'wire' );
					IMS_Email::mail_admin( $membership_id, $receipt_id, 'wire' );

					// Update receipt meta.
					$prefix = apply_filters( 'ims_receipt_meta_prefix', 'ims_receipt_' );

					update_post_meta( $receipt_id, "{$prefix}status", true );
				}

				if ( isset( $_POST['checkout_form'] ) ) {

					$response = array();

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

					echo wp_json_encode( $response );

					die();

				} else {

					$redirect_url = add_query_arg(
						array(
							'membership' => 'purchased',
							'order_id'   => $receipt_id,
						),
						esc_url( get_bloginfo( 'url' ) )
					);
					$redirect_url = apply_filters( 'ims_membership_success_redirect', $redirect_url );

					wp_safe_redirect( $redirect_url );

					die();
				}
			}
		}
	}
endif;
