<?php
/**
 * PayPal Payments Handling Class
 *
 * Class for handling PayPal payments.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * IMS_PayPal_Payment_Handler.
 *
 * Class for handling PayPal payments.
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'IMS_PayPal_Payment_Handler' ) ) :
	/**
	 * This class handle PayPal payments.
	 */
	class IMS_PayPal_Payment_Handler {

		/**
		 * PayPal Client ID.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $client_ID;

		/**
		 * PayPal Client Secret.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $client_secret;

		/**
		 * PayPal Sandbox URI.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		public $uri_sandbox;

		/**
		 * PayPal Live URI.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		public $uri_live;

		/**
		 * PayPal Access Token.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $access_token;

		/**
		 * PayPal Token Type.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $token_type;

		/**
		 * PayPal API Username.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $api_username;

		/**
		 * PayPal API Password.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $api_password;

		/**
		 * PayPal API Signature.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $api_signature;

		/**
		 * PayPal API EndPoint.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $api_endpoint;

		/**
		 * PayPal Express Checkout URL.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		private $express_checkout_url;

		/**
		 * Currency Code.
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		public $currency_code = 'USD';

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Get PayPal settings.
			$paypal_settings = get_option( 'ims_paypal_settings' );

			// Set the variables.
			if ( isset( $paypal_settings['ims_paypal_client_id'] ) && ! empty( $paypal_settings['ims_paypal_client_id'] ) ) {
				$this->client_ID = $paypal_settings['ims_paypal_client_id'];
			}

			if ( isset( $paypal_settings['ims_paypal_client_secret'] ) && ! empty( $paypal_settings['ims_paypal_client_secret'] ) ) {
				$this->client_secret = $paypal_settings['ims_paypal_client_secret'];
			}

			$this->uri_live    = 'https://api.paypal.com/v1/';
			$this->uri_sandbox = 'https://api.sandbox.paypal.com/v1/';

			if ( isset( $paypal_settings['ims_paypal_api_username'] ) && ! empty( $paypal_settings['ims_paypal_api_username'] ) ) {
				$this->api_username = $paypal_settings['ims_paypal_api_username'];
			}

			if ( isset( $paypal_settings['ims_paypal_api_password'] ) && ! empty( $paypal_settings['ims_paypal_api_password'] ) ) {
				$this->api_password = $paypal_settings['ims_paypal_api_password'];
			}

			if ( isset( $paypal_settings['ims_paypal_api_signature'] ) && ! empty( $paypal_settings['ims_paypal_api_signature'] ) ) {
				$this->api_signature = $paypal_settings['ims_paypal_api_signature'];
			}

			/**
			 * Action to run event on
			 * Doesn't need to be an existing WordPress action
			 *
			 * @param string - ims_paypal_membership_schedule_end
			 * @param string - paypal_membership_schedule_end
			 */
			add_action( 'ims_paypal_membership_schedule_end', array( $this, 'paypal_membership_schedule_end' ), 10, 3 );
		}

		/**
		 * Method: Set PayPal setting variables.
		 *
		 * @since 1.0.0
		 */
		private function paypal_routine_check() {

			// Get basic settings.
			$ims_basic_settings = get_option( 'ims_basic_settings' );
			$currency_code      = ( isset( $ims_basic_settings['ims_currency_code'] ) ) ? $ims_basic_settings['ims_currency_code'] : false;
			if ( ! empty( $currency_code ) ) {
				$this->currency_code = $currency_code;
			}

			// Get PayPal settings.
			$paypal_settings = get_option( 'ims_paypal_settings' );

			// Set the variables.
			if ( isset( $paypal_settings['ims_paypal_client_id'] ) && ! empty( $paypal_settings['ims_paypal_client_id'] ) ) {
				$this->client_ID = $paypal_settings['ims_paypal_client_id'];
			}

			if ( isset( $paypal_settings['ims_paypal_client_secret'] ) && ! empty( $paypal_settings['ims_paypal_client_secret'] ) ) {
				$this->client_secret = $paypal_settings['ims_paypal_client_secret'];
			}

			$this->uri_live		= 'https://api.paypal.com/v1/';
			$this->uri_sandbox	= 'https://api.sandbox.paypal.com/v1/';

			if ( isset( $paypal_settings['ims_paypal_api_username'] ) && ! empty( $paypal_settings['ims_paypal_api_username'] ) ) {
				$this->api_username = $paypal_settings['ims_paypal_api_username'];
			}

			if ( isset( $paypal_settings['ims_paypal_api_password'] ) && ! empty( $paypal_settings['ims_paypal_api_password'] ) ) {
				$this->api_password = $paypal_settings['ims_paypal_api_password'];
			}

			if ( isset( $paypal_settings['ims_paypal_api_signature'] ) && ! empty( $paypal_settings['ims_paypal_api_signature'] ) ) {
				$this->api_signature = $paypal_settings['ims_paypal_api_signature'];
			}
		}

		/**
		 * Method: Start processing simple PayPal payment.
		 *
		 * @since 1.0.0
		 */
		public function process_simple_paypal_payment() {

			if ( ! isset( $_POST['nonce'] )
				|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'membership-paypal-nonce' ) ) {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Nonce verification failed.', 'inspiry-memberships' ),
					)
				);
				die();
			}

			if ( ! isset( $_POST['membership_id'] ) ) {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Please select a membership to continue.', 'inspiry-memberships' ),
					)
				);
				die();
			}

			// Get membership id.
			$membership_id = intval( $_POST['membership_id'] );

			// Get current user.
			$user    = wp_get_current_user();
			$user_id = $user->ID;

			if ( ! empty( $membership_id ) && ! empty( $user_id ) ) {

				$this->paypal_routine_check();

				// Get membership object.
				$membership = ims_get_membership_object( $membership_id );
				$price      = $membership->get_price();

				// Get PayPal Settings.
				$paypal_settings = get_option( 'ims_paypal_settings' );
				$sandbox_mode    = $paypal_settings['ims_paypal_test_mode'];

				if ( ! empty( $sandbox_mode ) && ( 'on' === $sandbox_mode ) ) {
					$paypal_url = $this->uri_sandbox;
				} else {
					$paypal_url = $this->uri_live;
				}

				$postVal    = 'grant_type=client_credentials';
				$paypal_uri = $paypal_url . 'oauth2/token';

				// Call to PayPal API to generate access token.
				$auth_response = $this->generate_token( $paypal_uri, $postVal );

				if ( ! empty( $auth_response ) ) {

					$this->access_token = $auth_response->access_token;
					$this->token_type   = $auth_response->token_type;
					$paypal_payment_uri = $paypal_url . 'payments/payment';

					$return_url        = esc_url( add_query_arg( array( 'paypal_payment' => 'success' ), home_url() ) );
					$cancel_url        = esc_url( add_query_arg( array( 'paypal_payment' => 'failed' ), home_url() ) );
					$memberships_title = esc_html( get_the_title( $membership_id ) );

					$payment_args = apply_filters(
						'ims_paypal_simple_payment_args',
						array(
							'intent'        => 'sale',
							'redirect_urls' => array(
								'return_url' => $return_url,
								'cancel_url' => $cancel_url,
							),
							'payer' => array(
								'payment_method' => 'paypal',
							),
							'transactions' => array(
								array(
									'amount' => array(
										'total'    => $price,
										'currency' => $this->currency_code,
										'details'  => array(
											'subtotal'  => $price,
											'tax'       => '0.00',
											'shipping'  => '0.00',
											'insurance' => '0.00',
										),
									),
									'description' => esc_html__( 'Payment for ', 'inspiry-memberships' ) . $memberships_title,
									'item_list'   => array(
										'items'   => array(
											array(
												'name'        => $memberships_title,
												'description' => esc_html__( 'Payment for ', 'inspiry-memberships' ) . $memberships_title,
												'quantity'    => '1',
												'price'       => $price,
												'tax'         => '0.00',
												'sku'         => $memberships_title,
												'currency'    => $this->currency_code,
											),
										),
									),
								),
							),
						)
					);

					$payment_json_args = wp_json_encode( $payment_args );
					$payment_response  = $this->make_payment_call( $paypal_payment_uri, $payment_json_args, $this->access_token );

					if ( ! empty( $payment_response ) ) {

						foreach ( $payment_response['links'] as $response_link ) {

							if ( isset( $response_link['rel'] ) && 'approval_url' === $response_link['rel'] ) {
								$payment_return_url = ( ! empty( $response_link['href'] ) ) ? $response_link['href'] : false; // Approved payment URL to redirect member.
							} elseif ( isset( $response_link['rel'] ) && 'execute' === $response_link['rel'] ) {
								$payment_execute_url = ( ! empty( $response_link['href'] ) ) ? $response_link['href'] : false; // Use this URL to execute payment in future.
							}
						}

						$user_paypal_payment = array(
							'execute_url'   => $payment_execute_url,
							'access_token'  => $this->access_token,
							'membership_id' => $membership_id,
						);

						$user_payment_details = array(
							$user_id => $user_paypal_payment,
						);
						update_option( 'ims_paypal_payment_details', $user_payment_details );

						echo wp_json_encode(
							array(
								'success' => true,
								'url'     => $payment_return_url,
							)
						);

					} else {
						echo wp_json_encode(
							array(
								'success' => false,
								'message' => esc_html__( 'We were unable to authorize payment from PayPal. Please try again.', 'inspiry-memberships' ),
							)
						);
					}
				} else {
					echo wp_json_encode(
						array(
							'success' => false,
							'message' => esc_html__( 'We were not able to connect to PayPal. Please try again.', 'inspiry-memberships' ),
						)
					);
				}
			} else {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Please select a membership to continue.', 'inspiry-memberships' ),
					)
				);
			}
			die();
		}

		/**
		 * Method: Generate customer token.
		 *
		 * @param string $url - URL to send request.
		 * @param string $postVals value of posted value.
		 * @since 1.0.0
		 */
		public function generate_token( $url, $postVals ) {

			// Bail if any of the variables are empty.
			if ( empty( $url ) || empty( $postVals ) ) {
				return false;
			}

			$ch = curl_init();

			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_HEADER, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_USERPWD, $this->client_ID . ':' . $this->client_secret );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $postVals );

			$result = curl_exec( $ch );
			curl_close( $ch );

			if ( empty( $result ) ) {
				return false;
			} else {
				$token = json_decode( $result );
				return $token;
			}

		}

		/**
		 * Method: Make Payment POST call.
		 *
		 * @param string $url - URL to send request.
		 * @param string $postVals - JSON array containing payment related details for PayPal.
		 * @param string $token - Token generated by PayPal.
		 * @since 1.0.0
		 */
		public function make_payment_call( $url, $postVals, $token ) {

			// Bail if any of the variables are empty.
			if ( empty( $url ) || empty( $postVals ) || empty( $token ) ) {
				return false;
			}

			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_HEADER, false );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt(
				$ch,
				CURLOPT_HTTPHEADER,
				array(
					'Authorization: Bearer ' . $token,
					'Accept: application/json',
					'Content-Type: application/json'
				)
			);
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $postVals );

			$result = curl_exec( $ch );
			curl_close( $ch );

			if ( empty( $result ) ) {
				return false;
			} else {
				$response = json_decode( $result, true );
				return $response;
			}

		}

		/**
		 * Method: Get PayPal PayerID and execute PayPal Payment.
		 *
		 * @since 1.0.0
		 */
		public function execute_paypal_payment() {

			if ( isset( $_GET['paypal_payment'] ) && ( 'success' === $_GET['paypal_payment'] )
					&& isset( $_GET['PayerID'] ) && isset( $_GET['token'] ) ) {

				$redirect_url = get_bloginfo( 'url' );
				if ( function_exists( 'realhomes_get_dashboard_page_url' ) ) {
					$redirect_url = realhomes_get_dashboard_page_url( 'membership' );
				}

				// Get PayerID sent by PayPal.
				$payerID = wp_kses( $_GET['PayerID'], array() );

				// Get current user.
				$current_user = wp_get_current_user();
				$user_id      = $current_user->ID;

				if ( ! empty( $user_id ) ) {

					// Get payment data.
					$payment_data  = get_option( 'ims_paypal_payment_details' );
					$token         = $payment_data[ $user_id ]['access_token'];
					$execute_url   = $payment_data[ $user_id ]['execute_url'];
					$membership_id = $payment_data[ $user_id ]['membership_id'];

					$payment_args = array(
						'payer_id' => $payerID,
					);

					$payment_json_args = wp_json_encode( $payment_args );
					$payment           = $this->make_payment_call( $execute_url, $payment_json_args, $token );

					if ( isset( $payment[ 'state' ] ) && 'approved' === $payment[ 'state' ] ) {

						// Clear the general option.
						$payment_data = array(
							$user_id = array(),
						);
						update_option( 'ims_paypal_payment_details', $payment_data );

						// Update user meta with the payment id.
						$ims_paypal_payments = get_user_meta( $current_user->ID, 'ims_paypal_payments', true );
						if ( is_string( $ims_paypal_payments ) && empty( $ims_paypal_payments ) ) {
							$ims_paypal_payments   = array();
							$ims_paypal_payments[] = $payment['id'];
						} else {
							$ims_paypal_payments[] = $payment['id'];
						}
						update_user_meta( $current_user->ID, 'ims_paypal_payments', $ims_paypal_payments );

						$membership_methods = new IMS_Membership_Method();
						$receipt_methods    = new IMS_Receipt_Method();

						// Add membership.
						$membership_methods->add_user_membership( $current_user->ID, $membership_id, 'paypal' );
						// Generate receipt.
						$receipt_id = $receipt_methods->generate_receipt( $current_user->ID, $membership_id, 'paypal', $payment['id'] );

						// Mail the users.
						if ( ! empty( $receipt_id ) ) {
							IMS_Email::mail_user( $current_user->ID, $membership_id, 'paypal' );
							IMS_Email::mail_admin( $membership_id, $receipt_id, 'paypal' );
						}

						// Schedule the end of membership.
						$this->paypal_user_membership_end_schedule( $current_user->ID, $membership_id );

						$redirect_url = add_query_arg( array( 'submodule' => 'order', 'membership' => 'successful', 'order_id' => $receipt_id, 'package_id' => $membership_id, 'payment_method' => 'paypal' ), esc_url( $redirect_url ) );
						$redirect_url = apply_filters( 'ims_membership_success_redirect', $redirect_url );

						// Add action hook after paypal payment is done.
						do_action( 'ims_paypal_simple_payment_success', $user_id, $membership_id, $receipt_id );
					} else {

						$redirect_url = add_query_arg( array(  'membership' => 'failed', 'submodule' => 'order' ), esc_url( $redirect_url ) );
						$redirect_url = apply_filters( 'ims_membership_failed_redirect', $redirect_url );

						// Add action hook after paypal payment is failed.
						do_action( 'ims_paypal_simple_payment_failed' );
					}

					wp_redirect( $redirect_url );
					exit();

				}

				$redirect_url = add_query_arg( array(  'membership' => 'failed', 'submodule' => 'order' ), esc_url( $redirect_url ) );
				$redirect_url = apply_filters( 'ims_membership_failed_redirect', $redirect_url );
				wp_redirect( $redirect_url );
				exit();
			}
		}

		/**
		 * Method: Schedule PayPal membership end.
		 *
		 * @param int $user_id - User ID who purchased membership.
		 * @param int $membership_id - ID of the membership purchased.
		 * @since 1.0.0
		 */
		public function paypal_user_membership_end_schedule( $user_id = 0, $membership_id = 0 ) {

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
			wp_schedule_single_event( time() + $time_duration, 'ims_paypal_membership_schedule_end', $schedule_args );

			// Membership schedulled action hook.
			do_action( 'ims_paypal_membership_schedulled', $user_id, $membership_id );
		}

		/**
		 * Method: Function to be called when ims_paypal_membership_schedule_end
		 * event is fired.
		 *
		 * @param int $user_id - User ID who purchased membership.
		 * @param int $membership_id - ID of the membership purchased.
		 * @since 1.0.0
		 */
		public function paypal_membership_schedule_end( $user_id, $membership_id ) {

			// Bail if user or membership id is empty.
			if ( empty( $user_id ) || empty( $membership_id ) ) {
				return;
			}

			$ims_membership_methods = new IMS_Membership_Method();
			$ims_membership_methods->cancel_user_membership( $user_id, $membership_id );
		}

		/**
		 * Method: Start processing recurring PayPal payment.
		 *
		 * @since 1.0.0
		 */
		public function process_recurring_paypal_payment() {

			if ( ! isset( $_POST['nonce'] )
				|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'membership-paypal-nonce' ) ) {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Nonce verification failed.', 'inspiry-memberships' ),
					)
				);
				die();
			}

			if ( ! isset( $_POST['membership_id'] ) ) {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Please select a membership to continue.', 'inspiry-memberships' ),
					)
				);
				die();
			}

			// Get membership id.
			$membership_id = intval( $_POST['membership_id'] );

			// Get current user.
			$user    = wp_get_current_user();
			$user_id = $user->ID;

			if ( ! empty( $membership_id ) && ! empty( $user_id ) ) {

				$this->paypal_routine_check();

				// Get membership object.
				$membership  = ims_get_membership_object( $membership_id );
				$price       = $membership->get_price();
				$title       = get_the_title( $membership_id );
				$description = esc_html__( 'Payment for ', 'inspiry-memberships' ) . $title;

				// Get PayPal Settings.
				$paypal_settings = get_option( 'ims_paypal_settings' );
				$sandbox_mode    = $paypal_settings['ims_paypal_test_mode'];

				$return_url = esc_url( add_query_arg( array( 'paypal_recurring_payment' => 'success' ), home_url() ) );
				$cancel_url = esc_url( add_query_arg( array( 'paypal_recurring_payment' => 'failed' ), home_url() ) );

				$response = $this->callExpressCheckout( $price, $this->currency_code, 'Sale', $return_url, $cancel_url, $description );

				if ( ! empty( $response ) ) {

					// Redirect to PayPal with token.
					$token           = urldecode( $response['TOKEN'] );
					$redirect_paypal = $this->express_checkout_url . $token;

					$user_paypal_payment = array(
						'token'         => $token,
						'membership_id' => $membership_id,
					);
					$user_payment_details = array(
						$user_id => $user_paypal_payment,
					);
					update_option( 'ims_paypal_recurring_payment_details', $user_payment_details );

					echo wp_json_encode(
						array(
							'success' => true,
							'url'     => $redirect_paypal,
						)
					);

				} else {
					echo wp_json_encode(
						array(
							'success' => false,
							'message' => esc_html__( 'Error occurred while connecting to PayPal.', 'inspiry-memberships' ),
						)
					);
				}
			} else {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Please select a membership to continue.', 'inspiry-memberships' ),
					)
				);
			}
			die();
		}

		/**
		 * Method: Get PayPal PayerID and execute recurring payment.
		 *
		 * @since 1.0.0
		 */
		public function execute_recurring_paypal_payment() {

			if ( isset( $_GET['paypal_recurring_payment'] ) && ( 'success' === $_GET['paypal_recurring_payment'] )
					&& isset( $_GET['PayerID'] ) && isset( $_GET['token'] ) ) {

				$redirect_url = home_url();
				if ( function_exists( 'realhomes_get_dashboard_page_url' ) ) {
					$redirect_url = realhomes_get_dashboard_page_url( 'membership' );
				}

				// Get PayerID and token sent by PayPal.
				$payerID = wp_kses( $_GET['PayerID'], array() );
				$token   = wp_kses( $_GET['token'], array() );

				// Get current user.
				$current_user = wp_get_current_user();
				$user_id      = $current_user->ID;

				// Get payment data.
				$payment_data = get_option( 'ims_paypal_recurring_payment_details' );

				if ( isset( $payment_data[ $user_id ]['membership_id'] ) && ! empty( $payment_data[ $user_id ]['membership_id'] ) ) {
					$membership_id = $payment_data[ $user_id ]['membership_id'];
				}

				// Clear the general option.
				$payment_data = array(
					$user_id = array(),
				);
				update_option( 'ims_paypal_recurring_payment_details', $payment_data );

				if ( ! empty( $current_user->ID ) && ! empty( $membership_id ) ) {

					$this->paypal_routine_check();

					$shipping_details = $this->getShippingDetails( $token );
					// $billing_agreement = $this->confirm_payment( $token, $payerID, $membership_id );
					$profile = $this->createRecurringPaymentsProfile( $shipping_details, $membership_id, $current_user->ID );

					if ( ! empty( $profile ) ) {

						$profile_id = ( isset( $profile['PROFILEID'] ) && ! empty( $profile['PROFILEID'] ) ) ? $profile['PROFILEID'] : false;

						// Store the profile id in user meta.
						update_user_meta( $current_user->ID, 'ims_paypal_profile_id', $profile_id );

						$membership_methods = new IMS_Membership_Method();
						$receipt_methods    = new IMS_Receipt_Method();

						$membership_methods->add_user_membership( $current_user->ID, $membership_id, 'paypal' );
						$receipt_id = $receipt_methods->generate_recurring_paypal_receipt( $current_user->ID, $membership_id, '' );

						if ( ! empty( $receipt_id ) ) {
							IMS_Email::mail_user( $current_user->ID, $membership_id, 'paypal' );
							IMS_Email::mail_admin( $membership_id, $receipt_id, 'paypal' );
						}

						$redirect_url = esc_url( add_query_arg( array( 'submodule' => 'order', 'membership' => 'successful', 'order_id' => $receipt_id, 'package_id' => $membership_id, 'payment_method' => 'paypal' ), esc_url( $redirect_url ) ) );
						$redirect_url = apply_filters( 'ims_membership_success_redirect', $redirect_url );

						// Add action hook after paypal payment is done.
						do_action( 'ims_paypal_recurring_payment_success', $current_user->ID, $membership_id, $receipt_id );
					} else {

						$redirect_url = esc_url( add_query_arg( array(  'membership' => 'failed', 'submodule' => 'order' ), esc_url( $redirect_url ) ) );
						$redirect_url = apply_filters( 'ims_membership_failed_redirect', $redirect_url );

						// Add action hook after paypal payment failed.
						do_action( 'ims_paypal_recurring_payment_failed' );
					}

					wp_redirect( $redirect_url );
					exit();

				} else {

					$redirect_url = esc_url( add_query_arg( array(  'membership' => 'failed', 'submodule' => 'order' ), esc_url( $redirect_url ) ) );
					$redirect_url = apply_filters( 'ims_membership_failed_redirect', $redirect_url );
					wp_redirect( $redirect_url );
					exit();
				}
			}
		}

		/**
		 * Method: Call the PayPal API SetExpressCheckout to initiate
		 * the billing agreement.
		 *
		 * @return array The NVP Collection object of the SetExpressCheckout Call Response.
		 * @since 1.0.0
		 */
		private function callExpressCheckout( $amount, $currency_code, $type, $returnURL, $cancelURL, $description ) {

			// Bail if parameters are empty.
			if ( empty( $amount ) ||
					empty( $currency_code ) ||
					empty( $type ) ||
					empty( $returnURL ) ||
					empty( $cancelURL ) ||
					empty( $description ) ) {
				return false;
			}

			/**
			 * Construct the parameter string that describes the SetExpressCheckout API call in the shortcut implementation.
			 */
			$nvpstr = 'PAYMENTREQUEST_0_AMT=' . $amount;
			$nvpstr = $nvpstr . '&RETURNURL=' . $returnURL;
			$nvpstr = $nvpstr . '&CANCELURL=' . $cancelURL;
			$nvpstr = $nvpstr . '&PAYMENTACTION=' . urlencode( $type );
			$nvpstr = $nvpstr . '&CURRENCYCODE=' . $currency_code;
			$nvpstr = $nvpstr . '&L_BILLINGTYPE0=RecurringPayments';
			$nvpstr = $nvpstr . '&L_BILLINGAGREEMENTDESCRIPTION0=' . urlencode( $description );

			/**
			 * Make the API call to PayPal.
			 * If the API call succeded, then redirect the buyer to PayPal to begin to authorize payment.
			 * If an error occured, show the resulting errors.
			 */
			$result          = $this->hash_call( 'SetExpressCheckout', $nvpstr );
			$acknowledgement = strtoupper( $result['ACK'] );
			if ( 'SUCCESS' === $acknowledgement || 'SUCCESSWITHWARNING' === $acknowledgement ) {
				return $result;
			}
			return false;
		}

		/**
		 * Method: Get Shipping Details from PayPal.
		 * Prepares the parameters for the
		 * GetExpressCheckoutDetails API Call.
		 *
		 * @param string $token paypal token to get shipping details.
		 * @return array The NVP Collection object of the GetExpressCheckoutDetails Call Response.
		 * @since 1.0.0
		 */
		private function getShippingDetails( $token ) {

			// Bail if token is empty.
			if ( empty( $token ) ) {
				return false;
			}

			/**
			 * Build a second API request to PayPal, using the token
			 * as the ID to get the details on the payment authorization.
			 */
			$nvpstr   = 'TOKEN=' . $token;
			$resArray = $this->hash_call( 'GetExpressCheckoutDetails', $nvpstr );
			$ack      = strtoupper( $resArray['ACK'] );
			if ( 'SUCCESS' === $ack || 'SUCCESSWITHWARNING' === $ack ) {
				return $resArray;
			}
			return false;
		}

		/**
		 * Method: Prepares the parameters for the GetExpressCheckoutDetails API Call.
		 *
		 * @return array The NVP Collection object of the GetExpressCheckoutDetails Call Response.
		 * @since  1.0.0
		 */
		private function confirm_payment( $token, $payer_id, $membership_id ) {

			// Bail if parameters are empty.
			if ( empty( $token ) || empty( $payer_id) || empty( $membership_id ) ) {
				return false;
			}

			// Get membership object.
			$membership 	= ims_get_membership_object( $membership_id );
			$price	 		= $membership->get_price();

			// Get currency code.
			$ims_basic_settings	= get_option( 'ims_basic_settings' );
			$currency_code		= $ims_basic_settings[ 'ims_currency_code' ];
			if ( empty( $currency_code ) ) {
				$currency_code 	= 'USD';
			}

			$token 			= urlencode( $token );
			$paymentType 	= urlencode( "Sale" );
			$currency_code 	= urlencode( $currency_code );
			$payer_id 		= urlencode( $payer_id );
			$serverName 	= urlencode( $_SERVER[ 'SERVER_NAME' ] );
			$nvpstr = 	'TOKEN=' . $token;
			$nvpstr .= 	'&PAYERID=' . $payer_id;
			$nvpstr .= 	'&PAYMENTACTION=' . $paymentType;
			$nvpstr .= 	'&AMT=' . $price;
			$nvpstr .= 	'&CURRENCYCODE=' . $currency_code . '&IPADDRESS=' . $serverName;

			// Make the call to PayPal to finalize payment.
			$resArray	= $this->hash_call( "DoExpressCheckoutPayment", $nvpstr );
			$ack 		= strtoupper( $resArray[ "ACK" ] );
			if ( "SUCCESS" == $ack || "SUCCESSWITHWARNING" == $ack ) {
				return $resArray;
			}
			return false;

		}

		/**
		 * Method: Creates a profile that charges the customer.
		 *
		 * @since  1.0.0
		 */
		private function createRecurringPaymentsProfile( $shipping_details, $membership_id, $user_id ) {

			// Bail if parameters are empty.
			if ( empty( $shipping_details ) || empty( $membership_id ) || empty( $user_id ) ) {
				return false;
			}

			// Get shipping details obtained from GetShippingDetails API call.
			if ( array_key_exists( 'TOKEN', $shipping_details ) && ! empty( $shipping_details['TOKEN'] ) ) {
				$token = urlencode( $shipping_details['TOKEN'] );
			}
			if ( array_key_exists( 'PAYERID', $shipping_details ) && ! empty( $shipping_details['PAYERID'] ) ) {
				$payer_id = urlencode( $shipping_details['PAYERID'] );
			}
			if ( array_key_exists( 'EMAIL', $shipping_details ) && ! empty( $shipping_details['EMAIL'] ) ) {
				$user_email = urlencode( $shipping_details['EMAIL'] );
			}
			if ( array_key_exists( 'SHIPTONAME', $shipping_details ) && ! empty( $shipping_details['SHIPTONAME'] ) ) {
				$shipToName = urlencode( $shipping_details['SHIPTONAME'] );
			}
			if ( array_key_exists( 'SHIPTOSTREET', $shipping_details ) && ! empty( $shipping_details['SHIPTOSTREET'] ) ) {
				$shipToStreet = urlencode( $shipping_details['SHIPTOSTREET'] );
			}
			if ( array_key_exists( 'SHIPTOCITY', $shipping_details ) && ! empty( $shipping_details['SHIPTOCITY'] ) ) {
				$shipToCity = urlencode( $shipping_details['SHIPTOCITY'] );
			}
			if ( array_key_exists( 'SHIPTOSTATE', $shipping_details ) && ! empty( $shipping_details['SHIPTOSTATE'] ) ) {
				$shipToState = urlencode( $shipping_details['SHIPTOSTATE'] );
			}
			if ( array_key_exists( 'SHIPTOZIP', $shipping_details ) && ! empty( $shipping_details['SHIPTOZIP'] ) ) {
				$shipToZip = urlencode( $shipping_details['SHIPTOZIP'] );
			}
			if ( array_key_exists( 'SHIPTOCOUNTRYCODE', $shipping_details ) && ! empty( $shipping_details['SHIPTOCOUNTRYCODE'] ) ) {
				$shipToCountry = urlencode( $shipping_details['SHIPTOCOUNTRYCODE'] );
			}

			// Get membership object.
			$membership  = ims_get_membership_object( $membership_id );
			$title       = esc_html( get_the_title( $membership_id ) );
			$description = esc_html__( 'Payment for ', 'inspiry-memberships' ) . $title;
			$price       = $membership->get_price();
			$duration    = $membership->get_duration();
			$time_period = $membership->get_duration_unit();

			if ( ! empty( $time_period ) && ( 'days' === $time_period ) ) {
				$period = 'Day';
			} elseif ( ! empty( $time_period ) && ( 'weeks' === $time_period ) ) {
				$period = 'Week';
			} elseif ( ! empty( $time_period ) && ( 'months' === $time_period ) ) {
				$period = 'Month';
			} elseif ( ! empty( $time_period ) && ( 'years' === $time_period ) ) {
				$period = 'Year';
			}

			/**
			 * Build a second API request to PayPal, using the token
			 * as the ID to get the details on the payment authorization.
			 */
			$nvpstr  = 'TOKEN=' . $token;
			$nvpstr .= '&SUBSCRIBERNAME=' . urlencode( get_bloginfo( 'name' ) );
			$nvpstr .= '&PAYERID=' . $payer_id;
			$nvpstr .= '&EMAIL=' . $user_email;
			$nvpstr .= '&SHIPTONAME=' . $shipToName;
			$nvpstr .= '&SHIPTOSTREET=' . $shipToStreet;
			$nvpstr .= '&SHIPTOCITY=' . $shipToCity;
			$nvpstr .= '&SHIPTOSTATE=' . $shipToState;
			$nvpstr .= '&SHIPTOZIP=' . $shipToZip;
			$nvpstr .= '&SHIPTOCOUNTRY=' . $shipToCountry;
			$nvpstr .= '&PROFILESTARTDATE=' . urlencode( date( 'Y-m-d H:i:s', current_time( 'timestamp' ) ) );
			$nvpstr .= '&DESC=' . urlencode( $description );
			$nvpstr .= '&BILLINGPERIOD=' . urlencode( $period );
			$nvpstr .= '&BILLINGFREQUENCY=' . urlencode( $duration );
			$nvpstr .= '&AMT=' . urlencode( $price );
			// $nvpstr .= 	"&INITAMT=" . urlencode( $price );
			$nvpstr .= '&CURRENCYCODE=' . urlencode( $this->currency_code );
			$nvpstr .= '&IPADDRESS=' . $_SERVER['REMOTE_ADDR'];
			$nvpstr .= '&MAXFAILEDPAYMENTS=1';
			$nvpstr .= '&AUTOBILLOUTAMT=AddToNextBilling';

			/**
			 * Make the API call and store the results in an array.
			 * If the call was a success, show the authorization
			 * details, and provide an action to complete the
			 * payment. If failed, then return false.
			 */
			$resArray = $this->hash_call( 'CreateRecurringPaymentsProfile', $nvpstr );
			$ack      = strtoupper( $resArray[ 'ACK' ] );
			if ( 'SUCCESS' === $ack || 'SUCCESSWITHWARNING' === $ack ) {
				return $resArray;
			}
			return false;
		}

		/**
		 * Method: Function to perform the API call to PayPal using API signature.
		 *
		 * @param  string    $methodName 	Name of API method
		 * @param  string    $nvpStr 		nvp string
		 * @return array
		 * @since  1.0.0
		 */
		private function hash_call( $methodName, $nvpStr ) {

			$this->paypal_routine_check();

			// Setting the PayPal setting variables.
			$API_UserName 	= $this->api_username;
			$API_Password 	= $this->api_password;
			$API_Signature 	= $this->api_signature;

			// Get PayPal Settings.
			$paypal_settings = get_option( 'ims_paypal_settings' );
			$sandbox_mode    = $paypal_settings['ims_paypal_test_mode'];

			if ( ! empty( $sandbox_mode ) && ( 'on' === $sandbox_mode ) ) {

				$this->api_endpoint = "https://api-3t.sandbox.paypal.com/nvp";
				$API_Endpoint 		= $this->api_endpoint;
				$this->express_checkout_url = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
				$PAYPAL_URL 		= $this->express_checkout_url;

			} else {

				$this->api_endpoint = "https://api-3t.paypal.com/nvp";
				$API_Endpoint 		= $this->api_endpoint;
				$this->express_checkout_url = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
				$PAYPAL_URL 		= $this->express_checkout_url;

			}

			$version 	= urlencode( '64' );

			// Setting the curl parameters.
			$ch 	= curl_init();
			curl_setopt( $ch, CURLOPT_URL, $API_Endpoint );
			curl_setopt( $ch, CURLOPT_VERBOSE, 1 );

			// Turning off the server and peer verification ( TrustManager Concept ).
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_POST, 1 );

			// NVPRequest for submitting to server.
			$nvpreq = 	"METHOD=" . urlencode( $methodName );
			$nvpreq .= 	"&VERSION=" . urlencode( $version );
			$nvpreq	.=	"&PWD=" . urlencode( $API_Password );
			$nvpreq .= 	"&USER=" . urlencode( $API_UserName );
			$nvpreq .= 	"&SIGNATURE=" . urlencode( $API_Signature );
			$nvpreq .= 	"&" . $nvpStr;

			// Setting the nvpreq as POST FIELD to curl.
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $nvpreq );

			// Getting response from server.
			$result	= curl_exec( $ch );

			// Closing the curl.
			curl_close( $ch );

			if ( empty( $result ) ) {
				return false;
			} else {
			  	// Converting NVPResponse to an Associative Array.
				$nvpResArray = $this->deformatNVP( $result );
			}

			return $nvpResArray;

		}

		/**
		 * This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  	 * It is useful to search for a particular key and displaying arrays.
		 *
		 * @param  string    $nvpstr
		 * @return array
		 * @since  1.0.0
		 */
		private function deformatNVP( $nvpstr ) {

			$intial 	= 0;
		 	$nvpArray 	= array();
			while ( strlen( $nvpstr ) ) {

				// Postion of Key.
				$keypos = strpos( $nvpstr, '=' );

				// Position of value.
				$valuepos	= ( strpos( $nvpstr,'&' ) ) ? strpos( $nvpstr,'&' ) : strlen( $nvpstr );

				// Getting the Key and Value values and storing in a Associative Array.
				$keyval		= substr( $nvpstr, $intial, $keypos );
				$valval		= substr( $nvpstr, $keypos + 1, $valuepos - $keypos - 1 );

				// Decoding the response.
				$nvpArray[ urldecode( $keyval ) ] = urldecode( $valval );
				$nvpstr 	= substr( $nvpstr, $valuepos + 1, strlen( $nvpstr ) );

		    }

			return $nvpArray;

		}

		/**
		 * Method: Cancel PayPal user membership.
		 *
		 * @since 1.0.0
		 */
		public function cancel_paypal_membership( $user_id, $redirect_url = '' ) {

			// Bail if parameters are empty.
			if ( empty( $user_id ) ) {
				return false;
			}

			$profile_id = get_user_meta( $user_id, 'ims_paypal_profile_id', true );

			if ( empty( $profile_id ) ) {

				// Get current membership and cancel it.
				$current_membership = get_user_meta( $user_id, 'ims_current_membership', true );
				$membership_methods	= new IMS_Membership_Method();
				$membership_methods->cancel_user_membership( $user_id, $current_membership );

				// Redirect on success.
				if ( empty( $redirect_url ) ) {
					$redirect_url = esc_url( home_url() );
				}

				wp_safe_redirect( $redirect_url );
				exit;

			}

			/**
		     * Build an API request to PayPal for
		     * ManageRecurringPaymentsProfileStatus.
		     */
			$nvpstr =	"PROFILEID=" . urlencode( $profile_id );
			$nvpstr .=	"&ACTION=" . urlencode( 'Cancel' );
			$nvpstr	.=	"&NOTE=" . urlencode( esc_html__( 'Membership cancelled!' ) );

			$resArray 	= $this->hash_call( "ManageRecurringPaymentsProfileStatus", $nvpstr );
			$ack 		= strtoupper( $resArray[ "ACK" ] );
			if ( "SUCCESS" == $ack || "SUCCESSWITHWARNING" == $ack ) {

				// Redirect on success.
				$redirect = esc_url( add_query_arg( array( 'request' => 'submitted' ), home_url() ) );
				wp_redirect( $redirect );
				exit;

			}

			// Redirect on success.
			$redirect = esc_url( add_query_arg( array( 'request' => 'failed' ), home_url() ) );
			wp_redirect( $redirect );
			exit;

		}

		/**
		 * Method: Handle PayPal IPN event.
		 *
		 * @since 1.0.0
		 */
		public function handle_paypal_ipn_event() {

			// Get PayPal settings.
			$paypal_settings 	= get_option( 'ims_paypal_settings' );

			if ( isset( $paypal_settings[ 'ims_paypal_ipn_url' ] ) && ! empty( $paypal_settings[ 'ims_paypal_ipn_url' ] ) ) {

				// Extract URL parameters.
				$ipn_url 			= $paypal_settings[ 'ims_paypal_ipn_url' ];
				$ipn_url_params		= parse_url( $ipn_url, PHP_URL_QUERY );
				$ipn_url_params 	= explode( '=', $ipn_url_params );

			} else {
				return false;
			}

			if ( isset( $_GET[ $ipn_url_params[0] ] ) && ( $ipn_url_params[1] === $_GET[ $ipn_url_params[0] ] ) ) {

				$this->paypal_routine_check();

				/**
				 *  STEP 1: Read POST data. Reading POSTed data directly
				 *  from $_POST causes serialization issues with array
				 *  data in the POST. Instead, read raw POST data from
				 *  the input stream.
				 */
				$raw_post_data 	= file_get_contents( 'php://input' );
				$raw_post_array	= explode( '&', $raw_post_data );
				$myPost 		= array();

				// Bail if post data array is empty.
				if ( empty( $raw_post_array ) ) {
					return false;
				}

				foreach ( $raw_post_array as $keyval ) {

					$keyval 	= explode ( '=', $keyval );
					if ( 2 == count( $keyval ) ) {
						$myPost[ $keyval[0] ] = urldecode( $keyval[1] );
					}

				}

				// Bail if myPost data array is empty.
				if ( empty( $myPost ) ) {
					return false;
				}

				// Read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
				$req 	= 'cmd=_notify-validate';
				if ( function_exists( 'get_magic_quotes_gpc' ) ) {
					$get_magic_quotes_exists = true;
				}
				foreach ( $myPost as $key => $value ) {
					if ( $get_magic_quotes_exists == true && 1 == get_magic_quotes_gpc() ) {
						$value = urlencode( stripslashes( $value ) );
					} else {
						$value = urlencode( $value );
					}
					$req .= "&$key=$value";
				}

				// Step 2: POST IPN data back to PayPal to validate.
				$sandbox_mode	= $paypal_settings[ 'ims_paypal_test_mode' ];
				if ( ! empty( $sandbox_mode ) && ( 'on' === $sandbox_mode ) ) {
					$paypal_ipn_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
				} else {
					$paypal_ipn_url = 'https://www.paypal.com/cgi-bin/webscr';
				}

				$ch 	= curl_init( $paypal_ipn_url );
				curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
				curl_setopt( $ch, CURLOPT_POST, 1 );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $req );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
				curl_setopt( $ch, CURLOPT_FORBID_REUSE, 1 );
				curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Connection: Close' ) );

				$result	= curl_exec( $ch );
				if ( empty( $result ) ) {
					curl_close( $ch );
					return false;
				} else {
					curl_close( $ch );
				}

				// Inspect IPN validation result and act accordingly.
				if ( 0 === strcmp( $result, "VERIFIED" ) ) {

					// The IPN is verified, process it.
					$item_name        = ( isset( $_POST[ 'item_name' ] ) && ! empty( $_POST[ 'item_name' ] ) ) ? sanitize_text_field( $_POST[ 'item_name' ] ) : false;
					$item_number      = ( isset( $_POST[ 'item_number' ] ) && ! empty( $_POST[ 'item_number' ] ) ) ? sanitize_text_field( $_POST[ 'item_number' ] ) : false;
					$payment_status   = ( isset( $_POST[ 'payment_status' ] ) && ! empty( $_POST[ 'payment_status' ] ) ) ? sanitize_text_field( $_POST[ 'payment_status' ] ) : false;
					$payment_amount   = ( isset( $_POST[ 'mc_gross' ] ) && ! empty( $_POST[ 'mc_gross' ] ) ) ? sanitize_text_field( $_POST[ 'mc_gross' ] ) : false;
					$payment_currency = ( isset( $_POST[ 'mc_currency' ] ) && ! empty( $_POST[ 'mc_currency' ] ) ) ? sanitize_text_field( $_POST[ 'mc_currency' ] ) : false;
					$txn_id           = ( isset( $_POST[ 'txn_id' ] ) && ! empty( $_POST[ 'txn_id' ] ) ) ? sanitize_text_field( $_POST[ 'txn_id' ] ) : false;
					$txn_type         = ( isset( $_POST[ 'txn_type' ] ) && ! empty( $_POST[ 'txn_type' ] ) ) ? sanitize_text_field( $_POST[ 'txn_type' ] ) : false;
					$receiver_email   = ( isset( $_POST[ 'receiver_email' ] ) && ! empty( $_POST[ 'receiver_email' ] ) ) ? sanitize_email( $_POST[ 'receiver_email' ] ) : false;
					$payer_email      = ( isset( $_POST[ 'payer_email' ] ) && ! empty( $_POST[ 'payer_email' ] ) ) ? sanitize_email( $_POST[ 'payer_email' ] ) : false;
					$recurring_id     = ( isset( $_POST[ 'recurring_payment_id' ] ) && ! empty( $_POST[ 'recurring_payment_id' ] ) ) ? sanitize_text_field( $_POST[ 'recurring_payment_id' ] ) : false;
					$profile_status   = ( isset( $_POST[ 'profile_status' ] ) && ! empty( $_POST[ 'profile_status' ] ) ) ? sanitize_text_field( $_POST[ 'profile_status' ] ) : false;

					$membership_methods	= new IMS_Membership_Method();
					$receipt_methods	= new IMS_Receipt_Method();
					$user_id			= $membership_methods->get_user_by_paypal_profile( $recurring_id );

					if ( empty( $user_id ) ) {
						return false;
					}

					if ( 'recurring_payment' === $txn_type && 'Completed' == $payment_status ) {

						// Extend membership.
						$current_membership	= get_user_meta( $user_id, 'ims_current_membership', true );
						$membership_methods->update_membership_due_date( $current_membership, $user_id );
						$membership_methods->update_user_recurring_membership( $user_id, $current_membership );
						$receipt_id 		= $receipt_methods->generate_receipt( $user_id, $current_membership, 'paypal', $txn_id, true );

						if ( ! empty( $receipt_id ) ) {
							IMS_Email::mail_user( $user_id, $current_membership, 'paypal', true );
							IMS_Email::mail_admin( $current_membership, $receipt_id, 'paypal', true );
						}

					} elseif ( 'recurring_payment_profile_created' === $txn_type ) {

						// Membership created.

					} elseif ( 'recurring_payment_failed' === $txn_type || 'recurring_payment_profile_cancel' === $txn_type ) {

						// Cancel user membership.
						$current_membership	= get_user_meta( $user_id, 'ims_current_membership', true );
						$membership_methods->cancel_user_membership( $user_id, $current_membership );

					}

					return true;

				} elseif ( 0 === strcmp( $result, "INVALID" ) ) {
					// IPN invalid, log for manual investigation.
					return false;
				}

			}

		}

	}

endif;
