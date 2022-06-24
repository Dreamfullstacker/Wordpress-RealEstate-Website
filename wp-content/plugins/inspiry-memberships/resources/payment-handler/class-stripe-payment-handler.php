<?php
/**
 * Payment Handling Class for Stripe
 *
 * Class for handling payment functions for stripe.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'IMS_Stripe_Payment_Handler' ) ) :
	/**
	 * IMS_Stripe_Payment_Handler.
	 *
	 * Class for handling payment functions.
	 *
	 * @since 1.0.0
	 */
	class IMS_Stripe_Payment_Handler {

		/**
		 * Single instance of this class.
		 *
		 * @var   object
		 * @since 1.0.0
		 */
		protected static $_instance;

		/**
		 * Stripe Publishable Key.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		protected $publishable_key;

		/**
		 * Stripe Secret Key.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		protected $secret_key;

		/**
		 * $currency_code.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		protected $currency_code;

		/**
		 * Stripe Token.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		protected $stripe_token;

		/**
		 * Customer Details Array.
		 *
		 * @var   array
		 * @since 1.0.0
		 */
		protected $customer_details;

		/**
		 * Method: Returns a single instance of this class.
		 *
		 * @since 1.0.0
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;

		}

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			$this->set_variables();

			// Require Stripe library if it is not already exists.
			// if ( ! class_exists( '\Stripe\Stripe' ) ) {
				include IMS_BASE_DIR . '/resources/stripe-php/init.php';
			// }

			/**
			 * Action to run event on
			 * Doesn't need to be an existing WordPress action
			 *
			 * @param string - ims_stripe_schedule_membership_end
			 * @param string - schedule_normal_membership_end
			 */
			add_action( 'ims_stripe_schedule_membership_end', array( $this, 'schedule_normal_membership_end' ), 10, 3 );

		}

		/**
		 * Method: Set the customer details variable.
		 *
		 * @since 1.0.0
		 */
		public function set_variables() {

			// Set customer details.
			$this->customer_details = array(
				'recurring' => '',
				'user_id'   => '',
				'email'     => '',
				'name'      => '',
				'address'   => '',
				'zip'       => '',
				'city'      => '',
				'state'     => '',
				'country'   => '',
			);

		}

		/**
		 * Method: Perform routine checks to keep the plugin
		 * updated about the latest user settings.
		 *
		 * @since 1.0.0
		 */
		public function stripe_routine_checks() {

			// Get basic settings.
			$basic_settings = get_option( 'ims_basic_settings' );

			// Get stripe settings.
			$stripe_settings = get_option( 'ims_stripe_settings' );

			// Set the stripe API keys.
			if ( isset( $stripe_settings['ims_stripe_publishable'] ) ) {
				$this->publishable_key = $stripe_settings['ims_stripe_publishable'];
			}

			if ( isset( $stripe_settings['ims_stripe_secret'] ) ) {
				$this->secret_key = $stripe_settings['ims_stripe_secret'];
			}

			// Set currency code.
			if ( isset( $basic_settings['ims_currency_code'] ) && ! empty( $basic_settings['ims_currency_code'] ) ) {
				$this->currency_code = $basic_settings['ims_currency_code'];
			} else {
				$this->currency_code = 'USD';
			}
		}

		/**
		 * Method: Display stripe button data through ajax call.
		 *
		 * @since 1.0.0
		 */
		public function ims_display_stripe_button() {

			// Check if the membership variable is set.
			if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'membership-select-nonce' ) && isset( $_POST['membership'] ) ) {

				$this->stripe_routine_checks();

				// Set membership id.
				$membership_id = intval( $_POST['membership'] );

				if ( ! empty( $membership_id ) ) {

					// Get Stripe settings.
					$ims_stripe_settings = get_option( 'ims_stripe_settings' );

					// Strip button label.
					$ims_button_label = esc_html__( 'Pay with Card', 'inspiry-memberships' );
					if ( ! empty( $ims_stripe_settings['ims_stripe_btn_label'] ) ) {
						$ims_button_label = $ims_stripe_settings['ims_stripe_btn_label'];
					}

					// Check if package has recurring option.
					$price_id  = get_post_meta( $membership_id, 'ims_membership_stripe_plan_id', true );
					$recurring = ! empty( $price_id ) ? 'yes' : 'no';

					$stripe_button_arr = apply_filters(
						'ims_stripe_button_args',
						array(
							'success'         => true,
							'membership_id'   => $membership_id,
							'publishable_key' => $this->publishable_key,
							'button_label'    => $ims_button_label,
							'isp_nonce'       => esc_attr( wp_create_nonce( 'isp-nonce' ) ),
							'recurring'       => $recurring,
						)
					);
					echo wp_json_encode( $stripe_button_arr );

				} else {
					echo wp_json_encode(
						array(
							'success' => false,
							'message' => esc_html__( 'Membership ID is empty.', 'inspiry-memberships' ),
						)
					);
				}
			} else {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Membership ID is not valid.', 'inspiry-memberships' ),
					)
				);
			}
			die();
		}

		public function generate_checkout_session(){

			// Return back if require information is not set to the request.
			if ( empty( $_POST['payment_mode'] ) || empty( $_POST['membership_id'] ) || ! isset( $_POST['isp_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['isp_nonce'] ) ), 'isp-nonce' )  ) {
				return;
			}

			$this->stripe_routine_checks(); // Ensure all stripe settings data is available.

			\Stripe\Stripe::setApiKey( $this->secret_key ); // Set secret API key to the Stripe.
			header( 'Content-Type: application/json' );

			$membership_id = intval( $_POST['membership_id'] );
			$amount        = intval( get_post_meta( $membership_id, 'ims_membership_price', true ) ) * 100;
			$currency      = $this->currency_code;

			$product_title     = get_the_title( $membership_id );
			$product_image_url = get_the_post_thumbnail_url( $membership_id, 'large' );
			$product_price_id  = get_post_meta( $membership_id, 'ims_membership_stripe_plan_id', true );

			$membership_url = realhomes_get_dashboard_page_url( 'membership' );
			$membership_url = add_query_arg( array( 'mid' => $membership_id ), $membership_url );
			$success_url    = add_query_arg( array( 'membership_payment' => 'success' ), $membership_url );
			$cancel_url     = add_query_arg( array( 'membership_payment' => 'cancel' ), $membership_url );
			$payment_mode   = sanitize_text_field( wp_unslash( $_POST['payment_mode'] ) );

			if ( 'recurring' === $payment_mode && ! empty( $product_price_id ) ) {
				$checkout_session = \Stripe\Checkout\Session::create(
					array(
						'payment_method_types' => array( 'card' ),
						'line_items' => array(
							array(
								'price'    => $product_price_id,
								'quantity' => 1,
							),
						),
						'mode'        => 'subscription',
						'success_url' => $success_url,
						'cancel_url'  => $cancel_url,
					)
				);
			} else {

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
			}

			update_post_meta( $membership_id, 'realhomes_stripe_session_id', $checkout_session->id ); // Set Stripe Session ID to the membership meta temporarily.
			echo wp_json_encode( array( 'id' => $checkout_session->id ) );
			die();
		}

		public function membership_payment_completed() {

			// Return back if required data is not set before checking with payment complete process.
			if ( empty( $_GET['membership_payment'] ) || 'success' !== $_GET['membership_payment'] || empty( $_GET['mid'] ) ) {
				return;
			}

			$this->stripe_routine_checks(); // Ensure all stripe settings data is available.

			$membership_id = intval( $_GET['mid'] );
			$session_id    = get_post_meta( $membership_id, 'realhomes_stripe_session_id', true );

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

			delete_post_meta( $membership_id, 'realhomes_stripe_session_id' ); // Delete session ID from membership meta.

			$session = $this->object_to_array_recursive( $session );

			$membership_methods = new IMS_Membership_Method();
			$receipt_methods    = new IMS_Receipt_Method();

			$user_id      = get_current_user_id();
			$recurring    = false;
			$session_data = $session['originalvalues'];

			if ( 'subscription' === $session_data['mode'] ) {
				$recurring   = true;
				$transaction = $session_data['subscription'];
				update_user_meta( $user_id, 'ims_stripe_subscription_id', $transaction ); // Add subscription ID to the user meta to use it for the cancellation purpose later on.
			} else {
				$recurring   = false;
				$transaction = $session_data['paymentintent'];
			}

			if ( 'paid' === $session_data['paymentstatus'] ) {

				$membership_methods->add_user_membership( $user_id, $membership_id, 'stripe' ); // Add user membership here.
				$receipt_id = $receipt_methods->generate_receipt( $user_id, $membership_id, 'stripe', $transaction, $recurring ); // Generate membership payment receipt.

				if ( ! empty( $receipt_id ) ) {

					// Schedule membership to be end when duration time is over.
					$this->schedule_end_membership( $user_id, $membership_id, $receipt_id );

					// Notify membership subscriber and admin users.
					IMS_Email::mail_user( $user_id, $membership_id, 'stripe' );
					IMS_Email::mail_admin( $membership_id, $receipt_id, 'stripe' );

				}

				// Add action hook after stripe payment is done.
				do_action( 'ims_stripe_simple_payment_success', $user_id, $membership_id, $receipt_id );
			}

		}

		/**
		 * Convert an object to an array recursively.
		 *
		 * @since  1.0.0
		 * @param  object $data An object to convert into an array.
		 * @return array
		 */ // TODO: update documentation.
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
		 * This function is used to schedule the end of
		 * non-recurring membership.
		 *
		 * @param int $user_id - ID of the user purchasing membership.
		 * @param int $membership_id - ID of the membership being purchased.
		 * @param int $receipt_id - Receipt ID of the purchased membership.
		 *
		 * @since 1.0.0
		 */
		public function schedule_end_membership( $user_id = 0, $membership_id = 0, $receipt_id = 0 ) {

			// Bail if user, membership or receipt id is empty.
			if ( empty( $user_id ) || empty( $membership_id ) || empty( $receipt_id ) ) {
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
			 * Schedule the end of membership
			 *
			 * @param int - unix timestamp of when to run the event
			 * @param string - ims_stripe_schedule_membership_end
			 * @param array $schedule_args - arguments required by scheduling function
			 */
			wp_schedule_single_event( current_time( 'timestamp' ) + $time_duration, 'ims_stripe_schedule_membership_end', $schedule_args );

			// Membership schedulled action hook.
			do_action( 'ims_stripe_membership_schedulled', $user_id, $membership_id );

		}

		/**
		 * Method: Function to be called when ims_stripe_schedule_membership_end
		 * event is fired.
		 *
		 * @param int $user_id - ID of the user purchasing membership.
		 * @param int $membership_id - ID of the membership being purchased.
		 *
		 * @since 1.0.0
		 */
		public function schedule_normal_membership_end( $user_id, $membership_id ) {

			// Bail if user, membership or receipt id is empty.
			if ( empty( $user_id ) || empty( $membership_id ) ) {
				return;
			}

			$membership_methods = new IMS_Membership_Method();
			$membership_methods->cancel_user_membership( $user_id, $membership_id );

		}

		/**
		 * Method: Cancels user subscription.
		 *
		 * @param int    $user_id - User ID of the user making cancel request.
		 * @param string $redirect_url - URL to redirect after membership cancellation.
		 *
		 * @since 1.0.0
		 */
		public static function cancel_stripe_membership( $user_id = 0, $redirect_url = '' ) {

			// Bail if user id is empty.
			if ( empty( $user_id ) ) {
				return;
			}

			// Redirect on success.
			if ( empty( $redirect_url ) ) {
				$redirect_url = esc_url( realhomes_get_dashboard_page_url( 'membership' ) );
			}

			// Get stripe settings.
			$stripe_settings = get_option( 'ims_stripe_settings' );
			$secret_key      = '';

			if ( isset( $stripe_settings['ims_stripe_secret'] ) ) {
				$secret_key = $stripe_settings['ims_stripe_secret'];
			}

			try {

				// Cancelling the stripe recurring plan subscription.
				$stripe_subscription = get_user_meta( $user_id, 'ims_stripe_subscription_id', true );
				if ( ! empty( $stripe_subscription ) ) {

					$stripe = new \Stripe\StripeClient(
						$secret_key
					);
					$stripe->subscriptions->cancel(
						$stripe_subscription,
						array(),
					);
				}

				// De-attaching local subscription package from the user profile.
				$current_membership = get_user_meta( $user_id, 'ims_current_membership', true );
				$membership_methods = new IMS_Membership_Method();
				$membership_methods->cancel_user_membership( $user_id, $current_membership );

			} catch ( Exception $e ) {
				// Redirect on failing request.
				$redirect_url = add_query_arg( 'request', 'failed', $redirect_url );
				wp_safe_redirect( $redirect_url );
				exit;
			}

			wp_safe_redirect( $redirect_url );
			exit;
		}

		/**
		 * Method: To detect and handle stripe membership events.
		 *
		 * @since 1.0.0
		 */
		public function handle_stripe_subscription_event() {

			// Get stripe settings.
			$stripe_settings = get_option( 'ims_stripe_settings' );

			if ( isset( $stripe_settings['ims_stripe_webhook_url'] ) && ! empty( $stripe_settings['ims_stripe_webhook_url'] ) ) {

				// Extract URL parameters.
				$webhook_url        = $stripe_settings['ims_stripe_webhook_url'];
				$webhook_url_params = parse_url( $webhook_url, PHP_URL_QUERY );
				$webhook_url_params = explode( '=', $webhook_url_params );

			} else {
				return false;
			}

			if ( isset( $_GET[ $webhook_url_params[0] ] ) && ( $webhook_url_params[1] === $_GET[ $webhook_url_params[0] ] ) ) {

				$this->stripe_routine_checks();
				\Stripe\Stripe::setApiKey( $this->secret_key );

				$input      = @file_get_contents( 'php://input' );
				$event_json = json_decode( $input );

				$event = \Stripe\Event::retrieve( $event_json->id );

				// Get stripe customer id.
				$stripe_customer_id = $event->data->object->customer;

				if ( 'customer.subscription.deleted' == $event->type ) {

					$customer_args = array(
						'meta_key'     => 'ims_stripe_customer_id',
						'meta_value'   => $stripe_customer_id,
						'meta_compare' => '=',
					);
					$customers     = get_users( $customer_args );

					// Cancel subscription.
					if ( ! empty( $customers ) ) {

						foreach ( $customers as $customer ) {
							$current_membership = get_user_meta( $customer->ID, 'ims_current_membership', true );
							$membership_methods = new IMS_Membership_Method();
							$membership_methods->cancel_user_membership( $customer->ID, $current_membership );
						}
					}
				} elseif ( 'customer.subscription.created' === $event->type ) {

					$user_reminder = 0;

					$customer_args = array(
						'meta_key'     => 'ims_stripe_customer_id',
						'meta_value'   => $stripe_customer_id,
						'meta_compare' => '=',
					);
					$customers     = get_users( $customer_args );

					// Cancel subscription.
					if ( ! empty( $customers ) ) {
						foreach ( $customers as $customer ) {
							update_user_meta( $customer->ID, 'ims_user_reminder_mail', $user_reminder );
						}
					}


				} elseif ( 'invoice.payment_succeeded' === $event->type ) {

					$customer_args = array(
						'meta_key'     => 'ims_stripe_customer_id',
						'meta_value'   => $stripe_customer_id,
						'meta_compare' => '=',
					);
					$customers     = get_users( $customer_args );

					if ( ! empty( $customers ) ) {
						foreach ( $customers as $customer ) {

							// Update subscription end date.
							$subscription_id  = get_user_meta( $customer->ID, 'ims_stripe_subscription_id', true );
							$subscription     = \Stripe\Subscription::retrieve( $subscription_id );
							$subscription_due = $subscription->current_period_end;
							update_user_meta( $customer->ID, 'ims_stripe_subscription_due', $subscription_due );

							$membership_id = get_user_meta( $customer->ID, 'ims_current_membership', true );

							$membership_methods = new IMS_Membership_Method();
							$membership_methods->update_membership_due_date( $membership_id, $customer->ID );
							$membership_methods->update_user_recurring_membership( $customer->ID, $membership_id );

							$receipt_methods = new IMS_Receipt_Method();
							$receipt_id      = $receipt_methods->generate_receipt( $customer->ID, $membership_id, 'stripe', $subscription_id, true );

							if ( ! empty( $receipt_id ) ) {

								IMS_Email::mail_user( $customer->ID, $membership_id, 'stripe' );
								IMS_Email::mail_admin( $membership_id, $receipt_id, 'stripe' );
							}
						}
					}
				} elseif ( 'invoice.created' === $event->type ) {

					$customer_args = array(
						'meta_key'     => 'ims_stripe_customer_id',
						'meta_value'   => $stripe_customer_id,
						'meta_compare' => '=',
					);
					$customers     = get_users( $customer_args );

					if ( ! empty( $customers ) ) {
						foreach ( $customers as $customer ) {
							// Send reminder email.
							$reminder_user = get_user_meta( $customer->ID, 'ims_user_reminder_mail', true );
							$membership_id = get_user_meta( $customer->ID, 'ims_current_membership', true );
							if ( ! empty( $membership_id ) && ! empty( $reminder_user ) ) {
								IMS_Email::membership_reminder_email( $customer->ID, $membership_id );
							}
							update_user_meta( $customer->ID, 'ims_user_reminder_mail', 1 );
						}
					}
				}

				http_response_code( 200 );
				exit();

			}

		}

	}

endif;


/**
 * Returns the main instance of IMS_Stripe_Payment_Handler.
 *
 * @since 1.0.0
 */
function IMS_Stripe_Payment_Handler() {
	return IMS_Stripe_Payment_Handler::instance();
}
