<?php
/**
 * The Stripe payments handler functionality of the plugin.
 *
 * @since      1.0.0
 * @package    inspiry-stripe-payments
 * @subpackage realhomes-paypal-payments/includes
 */

// Exit if accessed directly.
if ( ! defined( 'WPINC' ) ) {
	exit;
}

if ( ! class_exists( 'Inspiry_Stripe_Payments_Handler' ) ) {
	/**
	 * The Inspiry_Stripe_Payments_Handler class.
	 *
	 * Defines stripe payments method and flow. Also updates
	 * property information against the transaction.
	 *
	 * @since 1.1.0
	 */
	class Inspiry_Stripe_Payments_Handler {

		/**
		 * $secret_key.
		 *
		 * @var    string
		 * @since  1.0.0
		 */
		private $secret_key;

		/**
		 * $currency_code.
		 *
		 * @var    string
		 * @since  1.0.0
		 */
		public $currency_code;

		/**
		 * $customer_details.
		 *
		 * @var    mixed
		 * @since  1.0.0
		 */
		protected $customer_details;

		/**
		 * $publish_property.
		 *
		 * @var    mixed
		 * @since  1.1.0
		 */
		public $publish_property;

		/**
		 * Payment amount that will be charged.
		 *
		 * @var    mixed
		 * @since  1.1.0
		 */
		public $amount;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			$isp_options = get_option( 'isp_settings' );

			$this->publishable_key  = $isp_options['publishable_key'];
			$this->secret_key       = $isp_options['secret_key'];
			$this->currency_code    = $isp_options['currency_code'];
			$this->amount           = $isp_options['amount'];
			$this->publish_property = $isp_options['publish_property'];
			$this->customer_details = array();

			/**
			 * A stripe php software development kit to fulfil all
			 * stripe payment actions side of the site.
			 */
			if ( ! class_exists( '\Stripe\Stripe' ) ) {
				require_once ISP_PLUGIN_DIR_PATH . 'admin/stripe-php/init.php';
			}

		}

		/**
		 * Handles the stripe payment process that's triggered
		 * by the stripe payment button on my properties page.
		 *
		 * @since  1.0.0
		 */
		public function process_property_payment() {

			if ( empty( $_POST['property_id'] ) || ! isset( $_POST['isp_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['isp_nonce'] ) ), 'isp-nonce' )  ) {
				return;
			}

			\Stripe\Stripe::setApiKey( $this->secret_key );

			header( 'Content-Type: application/json' );

			$property_id = intval( $_POST['property_id'] );
			$amount      = $this->amount * 100;
			$currency    = $this->currency_code;

			$product_title     = get_the_title( $property_id );
			$product_image_url = get_the_post_thumbnail_url( $property_id, 'large' );

			$properties_url = realhomes_get_dashboard_page_url( 'properties' );
			$properties_url = add_query_arg( array( 'pid' => $property_id ), $properties_url );
			$success_url    = add_query_arg( array( 'property_payment' => 'success' ), $properties_url );
			$cancel_url     = add_query_arg( array( 'property_payment' => 'cancel' ), $properties_url );

			$product_data = array( 'name' => esc_html( $product_title ) );
			if ( ! empty( $product_image_url ) ) {
				$product_data['images'] = array( esc_url( $product_image_url ) );
			}

			$checkout_session = \Stripe\Checkout\Session::create(
				array(
					'payment_method_types' => array( 'card' ),
					'line_items' => array(
						array(
							'price_data' => array(
								'currency'     => $currency,
								'unit_amount'  => $amount,
								'product_data' => $product_data,
							),
							'quantity'   => 1,
						),
					),
					'mode'        => 'payment',
					'success_url' => $success_url,
					'cancel_url'  => $cancel_url,
				)
			);

			update_post_meta( $property_id, 'realhomes_stripe_session_id', $checkout_session->id ); // Set Stripe Session ID to the property meta temporarily.
			echo wp_json_encode( array( 'id' => $checkout_session->id ) );
			die();
		}

		/**
		 * Update property based on the given property id and its detail.
		 *
		 * @since 1.1.0
		 */
		public function update_property() {

			if ( empty( $_GET['property_payment'] ) || 'success' !== $_GET['property_payment'] || empty( $_GET['pid'] ) ) {
				return;
			}

			$property_id = intval( $_GET['pid'] );
			$session_id  = get_post_meta( $property_id, 'realhomes_stripe_session_id', true );

			if ( empty( $session_id ) ) {
				return;
			}

			$stripe = new \Stripe\StripeClient(
				$this->secret_key
			);

			$session = $stripe->checkout->sessions->retrieve(
				$session_id,
				array(),
			);

			delete_post_meta( $property_id, 'realhomes_stripe_session_id' );

			$session = $this->object_to_array_recursive( $session );

			$session_data = $session['originalvalues'];

			$transaction    = ! empty( $session_data['paymentintent'] ) ? $session_data['paymentintent'] : '';
			$payment_status = ! empty( $session_data['paymentstatus'] ) ? esc_html__( 'Completed', 'inspiry-stripe-payments' ) : '';
			$payment_amount = ! empty( $session_data['amounttotal'] ) ? $session_data['amounttotal'] : '';
			$payer_email    = ! empty( $session_data['customerdetails']['email'] ) ? $session_data['customerdetails']['email'] : '';
			$currency_code  = ! empty( $session_data['currency'] ) ? $session_data['currency'] : '';

			update_post_meta( $property_id, 'isp_transaction', $session_data ); // Just for reference or later use in case we would need.
			update_post_meta( $property_id, 'txn_id', $transaction );
			update_post_meta( $property_id, 'payment_date', gmdate( 'D, j M Y h:i:s a', time() ) );
			update_post_meta( $property_id, 'payment_status', $payment_status );
			update_post_meta( $property_id, 'payment_gross', intVal( $payment_amount ) / 100 );
			update_post_meta( $property_id, 'payer_email', $payer_email );
			update_post_meta( $property_id, 'mc_currency', strtoupper( $currency_code ) );

			if ( $this->publish_property ) {
				// Publish property.
				$property_args = array(
					'ID'          => $property_id,
					'post_status' => 'publish',
				);

				// Update the post into the database.
				wp_update_post( $property_args );
			}

			$this->customer_details['email'] = $payer_email;
			$this->notify_user( $property_id );
			$this->notify_admin( $property_id );
		}

		/**
		 * Convert an object to an array recursively.
		 *
		 * @since  1.0.0
		 * @param  object $data An object to convert into an array.
		 * @return array
		 */
		public function object_to_array_recursive( $data ) {

			$result = array();

			if ( is_array( $data ) || is_object( $data ) ) {

				$data  = (array) $data; // Convert to an array if it's an object.
				$count = 0;

				foreach ( $data as $key => $value ) {
					$key            = trim( strtolower( str_replace( array( '*', '_' ), '', $key ) ), "\" \t\n\r\0\x0B" );
					$result[ $key ] = $this->object_to_array_recursive( $value );
					$count++;
				}

				return $result;
			}

			return $data;
		}

		/**
		 * Notify the user about prperty payment information.
		 *
		 * @since 1.0.0
		 * @param int $property_id The Property ID.
		 */
		public function notify_user( $property_id ) {

			// Get property information.
			$property_name = get_the_title( $property_id );
			$property_url  = get_the_permalink( $property_id );

			// Email header.
			$headers   = array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';

			// Email subject.
			$subject = esc_html__( 'Property payment processed via Stripe.', 'inspiry-stripe-payments' );

			// Email message.
			// translators: Property name.
			$message  = sprintf( __( 'Payment for property [%s] has been processed successfully.', 'inspiry-stripe-payments' ), esc_html( $property_name ) ) . '<br/><br/>';
			$message .= esc_html__( 'You can view the property here:', 'inspiry-stripe-payments' );
			$message .= '<a target="_blank" href="' . esc_url( $property_url ) . '">&nbsp;' . esc_html( $property_name ) . '</a>';
			$message .= '<br/><br/>';

			wp_mail( $this->customer_details['email'], $subject, $message, $headers );

		}


		/**
		 * Notify the administrator about property payment information.
		 *
		 * @since 1.0.0
		 * @param int $property_id The Property ID.
		 */
		public function notify_admin( $property_id ) {

			// Get property information.
			$property_name = get_the_title( $property_id );
			$property_url  = get_the_permalink( $property_id );

			// Admin email addresss.
			$admin_email = get_bloginfo( 'admin_email' );

			// User information.
			$user_email = $this->customer_details['email'];

			// Property information.

			// Email header.
			$headers   = array();
			$headers[] = 'Content-Type: text/html; charset=UTF-8';

			// Email subject.
			$subject = esc_html__( 'Property payment received via Stripe.', 'inspiry-stripe-payments' );

			// Email message.
			// translators: Property name.
			$message  = sprintf( __( 'Payment for property [%1$s] has been received.', 'inspiry-stripe-payments' ), esc_html( $property_name ) ) . '<br/><br/>';
			$message .= esc_html__( 'You can view the property here:', 'inspiry-stripe-payments' );
			$message .= '<a target="_blank" href="' . esc_url( $property_url ) . '">&nbsp;' . esc_html( $property_name ) . '</a><br/><br/>';
			// translators: User name who submitted the payment.
			$message .= sprintf( __( 'You can contact the customer at %s.', 'inspiry-stripe-payments' ), $user_email ) . '<br/><br/>';
			$message .= '<br/><br/>';

			wp_mail( $admin_email, $subject, $message, $headers );

		}

	}

}

if ( ! function_exists( 'inspiry_stripe_payment_notice' ) ) {
	/**
	 * Display stripe payment confirmation notice.
	 */
	function inspiry_stripe_payment_notice() {

		if ( ! empty( $_GET['property_payment'] ) && ! empty( $_GET['pid'] ) ) {

			if ( 'success' === $_GET['property_payment'] ) {
				?>
				<div class="dashboard-notice success is-dismissible">
					<h5><?php esc_html_e( 'Success!' ); ?></h5>
					<p><?php esc_html_e( 'Your property has been published!' ); ?></p>
				</div>
				<?php
			} else {
				?>
				<div class="dashboard-notice error is-dismissible">
					<h5><?php esc_html_e( 'Alert!' ); ?></h5>
					<p><?php esc_html_e( 'Property payment has failed!' ); ?></p>
				</div>
				<?php
			}
		}
	}
	add_action( 'inspiry_before_my_properties_page_render', 'inspiry_stripe_payment_notice' );
}
