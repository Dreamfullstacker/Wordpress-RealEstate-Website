<?php
/**
 * Receipt Methods Class
 *
 * Class file for receipt methods used during
 * operations of the plugin.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'IMS_Receipt_Method' ) ) {
	/**
	 * IMS_Receipt_Method.
	 *
	 * Class for receipt methods used during the
	 * operations of the plugin.
	 *
	 * @since 1.0.0
	 */
	class IMS_Receipt_Method {

		/**
		 * Generate receipt for the membership subscription.
		 *
		 * @param int    $user_id       - id of the user.
		 * @param int    $membership_id - id of the membership.
		 * @param string $vendor        - purchasing vendor for membership.
		 * @param string $payment_id    - id of the payment.
		 * @param bool   $recurring     - check to detect the type of receipt.
		 * @param bool   $blank         - check to indicate a blank receipt.
		 *
		 * @since 1.0.0
		 */
		public function generate_receipt( $user_id = 0, $membership_id = 0, $vendor = '', $payment_id = 0, $recurring = false, $blank = false ) {

			// Bail if user or membership id is empty.
			if ( empty( $user_id ) || empty( $membership_id ) || empty( $vendor ) ) {
				return false;
			}

			$receipt_args = array(
				'post_author' => $user_id,
				'post_title'  => esc_html__( 'Receipt', 'inspiry-memberships' ),
				'post_status' => 'publish',
				'post_type'   => 'ims_receipt',
			);

			$receipt_id = wp_insert_post( $receipt_args );

			if ( $receipt_id > 0 ) {
				$receipt_args = array();
				$receipt_args = array(
					'ID'         => $receipt_id,
					'post_type'  => 'ims_receipt',
					'post_title' => esc_html__( 'Receipt ', 'inspiry-memberships' ) . $receipt_id,
				);

				$receipt_id = wp_update_post( $receipt_args );

				if ( $receipt_id > 0 ) {

					$receipt        = get_post( $receipt_id );
					$prefix         = apply_filters( 'ims_receipt_meta_prefix', 'ims_receipt_' );
					$membership_obj = ims_get_membership_object( $membership_id );
					$receipt_type   = esc_html__( 'Normal Membership', 'inspiry-memberships' );
					$receipt_type   = ( ! empty( $recurring ) ) ? esc_html__( 'Recurring Membership', 'inspiry-memberships' ) : $receipt_type;
					$price          = $membership_obj->get_price();

					if ( $blank ) {
						$price = 0;
					}

					update_post_meta( $receipt_id, "{$prefix}receipt_id", $receipt_id );
					update_post_meta( $receipt_id, "{$prefix}receipt_for", $receipt_type );
					update_post_meta( $receipt_id, "{$prefix}membership_id", $membership_id );
					update_post_meta( $receipt_id, "{$prefix}price", $price );
					update_post_meta( $receipt_id, "{$prefix}purchase_date", $receipt->post_date );
					update_post_meta( $receipt_id, "{$prefix}user_id", $user_id );
					update_post_meta( $receipt_id, "{$prefix}payment_id", $payment_id );
					update_post_meta( $receipt_id, "{$prefix}status", true );

					// Update status and related membership due date to the receipt.
					$membership_methods  = new IMS_Membership_Method();
					$time_due            = $membership_methods->get_membership_due_date( $membership_id, current_time( 'timestamp' ) );
					$membership_due_date = date( 'Y-m-d H:i', $time_due );
					update_post_meta( $receipt_id, 'ims_receipt_membership_due_date', $membership_due_date );

					// Set vendor.
					if ( ! empty( $vendor ) ) {
						update_post_meta( $receipt_id, "{$prefix}vendor", $vendor );
					}

					// Updating user receipts.
					$user_receipts = get_user_meta( $user_id, 'ims_receipts', true );
					if ( is_string( $user_receipts ) && empty( $user_receipts ) ) {
						$user_receipts   = array();
						$user_receipts[] = $receipt_id;
					} elseif ( ! empty( $user_receipts ) && is_array( $user_receipts ) ) {
						$user_receipts[] = $receipt_id;
					} else {
						$user_receipts   = explode( ',', $user_receipts );
						$user_receipts   = array();
						$user_receipts[] = $receipt_id;
					}
					update_user_meta( $user_id, 'ims_receipts', $user_receipts );

					// Receipt generated action hook.
					do_action( 'ims_receipt_generated', $receipt_id );

					return $receipt_id;
				}
			}

			return false;

		}

		/**
		 * Method: Generate receipt for recurring membership purchase via PayPal.
		 *
		 * @since 1.0.0
		 */
		public function generate_recurring_paypal_receipt( $user_id = 0, $membership_id = 0, $payment_id = 0 ) {

			// Bail if paramters are empty.
			if ( empty( $user_id ) || empty( $membership_id ) ) {
				return false;
			}

			if ( empty( $payment_id ) ) {
				$receipt_id = $this->generate_receipt( $user_id, $membership_id, 'paypal', '', true, true );
			} else {
				$receipt_id = $this->generate_receipt( $user_id, $membership_id, 'paypal', $payment_id, true, false );
			}
			return $receipt_id;

		}

		/**
		 * Method: Generate receipt for membership purchase via Wire Transfer.
		 *
		 * @since 1.0.0
		 */
		public function generate_wire_transfer_receipt( $user_id = 0, $membership_id = 0, $payment_id = 0 ) {

			// Bail if paramters are empty.
			if ( empty( $user_id ) || empty( $membership_id ) ) {
				return false;
			}

			if ( empty( $payment_id ) ) {
				$receipt_id = $this->generate_receipt( $user_id, $membership_id, 'wire', '', false, false );
			} else {
				$receipt_id = $this->generate_receipt( $user_id, $membership_id, 'wire', $payment_id, false, false );
			}

			$prefix = apply_filters( 'ims_receipt_meta_prefix', 'ims_receipt_' );
			update_post_meta( $receipt_id, "{$prefix}status", false );
			return $receipt_id;

		}

	}

}
