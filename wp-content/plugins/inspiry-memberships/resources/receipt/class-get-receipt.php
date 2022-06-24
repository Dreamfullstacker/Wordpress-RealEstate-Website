<?php
/**
 * Get receipt class object
 *
 * Class to return common methods to interact with `receipt` post type.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'IMS_Get_Receipt' ) ) {
	/**
	 * IMS_Get_Receipt.
	 *
	 * Class to return common methods to interact with `receipt` post type.
	 *
	 * @since 1.0.0
	 */
	class IMS_Get_Receipt {

		/**
		 * The Receipt ID.
		 *
		 * @var   int
		 * @since 1.0.0
		 */
		public $the_receipt_id;

		/**
		 * Receipt Meta Data.
		 *
		 * @var   array
		 * @since 1.0.0
		 */
		public $the_meta_data;

		/**
		 * Membership Meta Keys.
		 *
		 * @var   array
		 * @since 1.0.0
		 */
		public $meta_keys;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 * @param int $the_receipt_id ID of the receipt.
		 */
		public function __construct( $the_receipt_id = '' ) {

			$this->set_meta_keys();

			// Check if $the_receipt_id is not empty.
			if ( ! empty( $the_receipt_id ) ) {
				$the_receipt_id = intval( $the_receipt_id );
			} else {
				$the_receipt_id = get_the_id();
			}

			if ( $the_receipt_id > 0 ) {
				$this->the_receipt_id = $the_receipt_id;
				$this->the_meta_data  = get_post_custom( $the_receipt_id );
			}

		}

		/**
		 * Method: Set meta keys.
		 *
		 * @since 1.0.0
		 */
		public function set_meta_keys() {

			// Meta data prefix.
			$prefix = apply_filters( 'ims_receipt_meta_prefix', 'ims_receipt_' );

			$this->meta_keys = array(
				'receipt_id'    => "{$prefix}receipt_id",
				'receipt_for'   => "{$prefix}receipt_for",
				'membership_id' => "{$prefix}membership_id",
				'price'         => "{$prefix}price",
				'purchase_date' => "{$prefix}purchase_date",
				'user_id'       => "{$prefix}user_id",
				'vendor'        => "{$prefix}vendor",
				'payment_id'    => "{$prefix}payment_id",
				'status'        => "{$prefix}status",
			);

		}

		/**
		 * Get Receipt: Meta.
		 *
		 * Gets the receipt meta_value if passed
		 * a meta_key through argument.
		 *
		 * @since 1.0.0
		 * @param string $meta_key Meta key to get value for.
		 */
		public function get_meta( $meta_key ) {
			// Solves undefined index problem.
			$the_meta = isset( $this->the_meta_data[ $meta_key ] ) ? $this->the_meta_data[ $meta_key ] : false;

			if ( is_array( $the_meta ) ) {
				// Check 0th element of array
				// If meta is set then return value else return false.
				if ( isset( $the_meta[0] ) ) {
					// Returns the value of meta.
					return $the_meta[0];
				} else {
					return false;
				}
			} else {
				// If meta is set then return value else return false.
				if ( isset( $the_meta ) ) {
					// Returns the value of meta.
					return $the_meta[0];
				} else {
					return false;
				}
			}
		}

		/**
		 * Get Receipt: ID.
		 *
		 * @since 1.0.0
		 */
		public function get_ID() {
			return $this->the_receipt_id;
		}

		/**
		 * Get Receipt: For.
		 *
		 * @since 1.0.0
		 */
		public function get_receipt_for() {
			// Returns false if ID is not present.
			if ( ! $this->the_receipt_id ) {
				return false;
			}
			return $this->get_meta( $this->meta_keys['receipt_for'] );
		}

		/**
		 * Get Receipt: Membership ID.
		 *
		 * @since 1.0.0
		 */
		public function get_membership_id() {
			// Returns false if ID is not present.
			if ( ! $this->the_receipt_id ) {
				return false;
			}
			return $this->get_meta( $this->meta_keys['membership_id'] );
		}

		/**
		 * Get Receipt: Price.
		 *
		 * @since 1.0.0
		 */
		public function get_price() {
			// Returns false if ID is not present.
			if ( ! $this->the_receipt_id ) {
				return false;
			}
			return $this->get_meta( $this->meta_keys['price'] );
		}

		/**
		 * Get Receipt: Purchase Date.
		 *
		 * @since 1.0.0
		 */
		public function get_purchase_date() {
			// Returns false if ID is not present.
			if ( ! $this->the_receipt_id ) {
				return false;
			}
			return $this->get_meta( $this->meta_keys['purchase_date'] );
		}

		/**
		 * Get Receipt: User ID.
		 *
		 * @since 1.0.0
		 */
		public function get_user_id() {
			// Returns false if ID is not present.
			if ( ! $this->the_receipt_id ) {
				return false;
			}
			return $this->get_meta( $this->meta_keys['user_id'] );
		}

		/**
		 * Get Receipt: Vendor.
		 *
		 * @since 1.0.0
		 */
		public function get_vendor() {
			// Returns false if ID is not present.
			if ( ! $this->the_receipt_id ) {
				return false;
			}
			return $this->get_meta( $this->meta_keys['vendor'] );
		}

		/**
		 * Get Receipt: Payment ID.
		 *
		 * @since 1.0.0
		 */
		public function get_payment_id() {
			// Returns false if ID is not present.
			if ( ! $this->the_receipt_id ) {
				return false;
			}
			return $this->get_meta( $this->meta_keys['payment_id'] );
		}

		/**
		 * Get Receipt: Status.
		 *
		 * @since 1.0.0
		 */
		public function get_status() {
			// Returns false if ID is not present.
			if ( ! $this->the_receipt_id ) {
				return false;
			}
			return $this->get_meta( $this->meta_keys['status'] );
		}

	}
}

if ( ! function_exists( 'ims_get_receipt_object' ) ) {
	/**
	 * Get receipt instance against the $receipt_id.
	 *
	 * @param string $receipt_id Receipt ID.
	 */
	function ims_get_receipt_object( $receipt_id ) {
		if ( ! empty( $receipt_id ) ) {
			return new IMS_Get_Receipt( $receipt_id );
		}
		return false;
	}
}
