<?php
/**
 * The paypal-payments functionality of the plugin.
 *
 * @since      1.0.0
 * @package    realhomes-paypal-payments
 * @subpackage realhomes-paypal-payments/includes
 */

use \PayPal\Rest\ApiContext;
use \PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

/**
 * The paypal-payments functionality of the plugin.
 *
 * Defines paypal payments method and flow. Also updates
 * property information against the transaction.
 *
 * @since 1.0.0
 */
class Realhomes_Paypal_Payments_Handler {

	/**
	 * PayPal API connection of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $api_context The API connection.
	 */
	protected $api_context;

	/**
	 * Client ID.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $client_id PayPal application client id.
	 */
	protected $client_id;

	/**
	 * Client Secret.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $client_secret PayPal application client secret.
	 */
	protected $client_secret;

	/**
	 * Price per property by the site owner to publish it.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $price_per_property    Price per property.
	 */
	public $price_per_property;

	/**
	 * Currency in which transaction has to be made.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $currency    Price currency.
	 */
	public $currency;

	/**
	 * My properties page url where user needs to be
	 * reidrected after successfull payment approval.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string $my_properties_page My Properties page url.
	 */
	public $my_properties_page;

	/**
	 * Defines puplish property after payment or not.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string $publish_property Publish property after payment.
	 */
	public $publish_property;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$rpp_settings = get_option( 'rpp_settings' );

		$this->client_id          = esc_html( $rpp_settings['client_id'] );
		$this->client_secret      = esc_html( $rpp_settings['secret_id'] );
		$this->price_per_property = esc_html( $rpp_settings['payment_amount'] );
		$this->currency           = esc_html( $rpp_settings['currency_code'] );
		$this->my_properties_page = esc_url( $rpp_settings['redirect_page_url'] );
		$this->publish_property   = esc_html( $rpp_settings['publish_property'] );

		$this->api_context = new ApiContext(
			new OAuthTokenCredential(
				$this->client_id,      // ClientID.
				$this->client_secret   // ClientSecret.
			)
		);

	}

	/**
	 * Initialize the paypal payment creation and its execution.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		if ( $this->is_create_payment() ) {

			$property_id = sanitize_text_field( wp_unslash( $_POST['property_id'] ) ); // phpcs:ignore
			$prop_info   = $this->property_information( $property_id );
			try {
				$this->create_payment( $prop_info );
			} catch ( Exception $err ) {
				echo 'Caught exception: ',  esc_html( $err->getMessage() ), "\n";
			}
		} elseif ( $this->is_execute_payment() ) {

			$property_id = sanitize_text_field( wp_unslash( $_GET['property_id'] ) ); // phpcs:ignore
			$payer_id    = sanitize_text_field( wp_unslash( $_GET['PayerID'] ) );     // phpcs:ignore
			$payment_id  = sanitize_text_field( wp_unslash( $_GET['paymentId'] ) );   // phpcs:ignore
			try {
				$this->execute_payment( $property_id, $payer_id, $payment_id );
			} catch ( Exception $err ) {
				echo 'Caught exception: ',  esc_html( $err->getMessage() ), "\n";
			}
		}
	}

	/**
	 * Check if it's a payment creation request.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	public function is_create_payment() {
		$nonce       = ! empty( $_POST['paypal_payment_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['paypal_payment_nonce'] ) ) : '';
		$property_id = ! empty( $_POST['property_id'] ) ? sanitize_text_field( wp_unslash( $_POST['property_id'] ) ) : 0;

		if ( wp_verify_nonce( $nonce, "paypal_payment_{$property_id}" ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Check if it's a payment execute request.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	public function is_execute_payment() {

		$success     = ( ! empty( $_GET['success'] ) && 'true' === $_GET['success'] ) ? true : false;
		$property_id = ! empty( $_GET['property_id'] ) ? true : false;
		$payer_id    = ! empty( $_GET['PayerID'] ) ? true : false;
		$payment_id  = ! empty( $_GET['paymentId'] ) ? true : false;

		if ( $success && $property_id && $payer_id && $payment_id ) {
			return true;
		}
		return false;
	}

	/**
	 * Create paypal payment for the given property information.
	 *
	 * @since 1.0.0
	 * @param array $prop_info Property information.
	 */
	public function create_payment( $prop_info ) {

		$payer = new Payer();
		$payer->setPaymentMethod( 'paypal' );

		// Building property item for the transaction.
		$item1 = new Item();
		$item1->setName( $prop_info['title'] )
		->setCurrency( $this->currency )
		->setQuantity( 1 )
		->setSku( $prop_info['id'] )
		->setPrice( $this->price_per_property );

		$item_list = new ItemList();
		$item_list->setItems( array( $item1 ) ); // 1 or more items can be added here.

		// Setting property amount.
		$amount = new Amount();
		$amount->setCurrency( $this->currency )
		->setTotal( $this->price_per_property );

		// Building transaction.
		$transaction = new Transaction();
		$trans_desc  = 'Property ID: ' . $prop_info['id'] . ' ';
		$trans_desc .= 'Property Title: ' . $prop_info['title'] . ' ';
		$trans_desc .= 'Property Address: ' . $prop_info['address'] . ' ';

		$transaction->setAmount( $amount )
		->setItemList( $item_list )
		->setDescription( $trans_desc )
		->setInvoiceNumber( uniqid() );

		// Buidling redirect urls.
		$base_url      = add_query_arg( 'property_id', $prop_info['id'], $this->my_properties_page );
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl( "$base_url&success=true" )
		->setCancelUrl( "$base_url&success=false" );

		// Setting payment payer, direct urls and transaction.
		$payment = new Payment();
		$payment->setIntent( 'sale' )
		->setPayer( $payer )
		->setRedirectUrls( $redirect_urls )
		->setTransactions( array( $transaction ) );

		// Creating payment and redirecting to the payment approval url.
		$payment->create( $this->api_context );
		$approval_url = $payment->getApprovalLink();
		wp_redirect( $approval_url );
		die();
	}

	/**
	 * Executing paypal payment after sucessfull payment approval.
	 *
	 * @since 1.0.0
	 */
	public function execute_payment( $property_id, $payer_id, $payment_id ) {

		$amount      = new Amount();
		$transaction = new Transaction();
		$execution   = new PaymentExecution();

		$amount->setCurrency( $this->currency );
		$amount->setTotal( $this->price_per_property );
		$transaction->setAmount( $amount );
		$execution->setPayerId( $payer_id );
		$execution->addTransaction( $transaction );

		$payment    = Payment::get( $payment_id, $this->api_context );
		$result_obj = $payment->execute( $execution, $this->api_context );
		$result_arr = $this->object_to_array_recursive( $result_obj );

		$payment_detail = $this->payment_details( $result_arr );
		$this->update_property( $property_id, $payment_detail );
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
				$key            = strtolower( str_replace( '\\', '_', $key ) );
				$key            = ( strlen( $key ) > 30 ) ? 'paypal' : $key;
				$result[ $key ] = $this->object_to_array_recursive( $value );
				$count++;
			}

			return $result;
		}

		return $data;
	}

	/**
	 * Build easy to use payment detail array from given
	 * paypal respnoeded complex array of payment information.
	 *
	 * @since  1.0.0
	 * @param  array $response Complex paypal responded array of payment information.
	 * @return array|boolean
	 */
	public function payment_details( $response ) {

		$detail = array();

		if ( ! empty( $response['paypal']['payer']['paypal']['payer_info']['paypal'] ) && ! empty( $response['paypal']['transactions'][0]['paypal']['related_resources'][0]['paypal']['sale']['paypal'] ) ) {
			$payer_info     = $response['paypal']['payer']['paypal']['payer_info']['paypal'];
			$sale_info      = $response['paypal']['transactions'][0]['paypal']['related_resources'][0]['paypal']['sale']['paypal'];
			$wp_date_format = get_option( 'date_format' );
			$wp_time_format = get_option( 'time_format' );

			// Transaction Details.
			$detail['payment_id']       = $sale_info['id']; // transaction id.
			$detail['payment_state']    = ucfirst( $sale_info['state'] ); // transaction state.
			$detail['payment_amount']   = $sale_info['amount']['paypal']['total']; // total paid amount.
			$detail['payment_currency'] = $sale_info['amount']['paypal']['currency']; // amount currency.
			$detail['payment_time']     = esc_html( gmdate( $wp_date_format . ' ' . $wp_time_format, strtotime( $sale_info['create_time'] ) ) ); // transaction time.

			// Payer Details.
			$detail['payer_email']      = $payer_info['email']; // payer email address.
			$detail['payer_first_name'] = ucfirst( $payer_info['first_name'] ); // payer first name.
			$detail['payer_last_name']  = ucfirst( $payer_info['last_name'] ); // payer last name.

			return $detail;
		}

		return false;
	}

	/**
	 * Return property information based on given property id.
	 *
	 * @since  1.0.0
	 * @param  int $prop_id Property ID.
	 * @return array        Property infomration.
	 */
	public function property_information( $prop_id ) {

		$prop_info = array();

		$prop_info['id']      = intval( $prop_id );
		$prop_info['title']   = esc_html( get_the_title( $prop_id ) );
		$prop_info['address'] = esc_html( get_post_meta( $prop_id, 'REAL_HOMES_property_address', true ) );

		return $prop_info;
	}

	/**
	 * Update property based on the given property id and its detail.
	 *
	 * @since 1.0.0
	 * @param int   $property_id    Property ID.
	 * @param array $payment_detail Payment detail.
	 */
	public function update_property( $property_id, $payment_detail ) {

		update_post_meta( $property_id, 'payment_status', $payment_detail['payment_state'] );
		update_post_meta( $property_id, 'payment_gross', $payment_detail['payment_amount'] );
		update_post_meta( $property_id, 'payment_date', $payment_detail['payment_time'] );
		update_post_meta( $property_id, 'payer_email', $payment_detail['payer_email'] );
		update_post_meta( $property_id, 'mc_currency', $payment_detail['payment_currency'] );
		update_post_meta( $property_id, 'first_name', $payment_detail['payer_first_name'] );
		update_post_meta( $property_id, 'last_name', $payment_detail['payer_last_name'] );
		update_post_meta( $property_id, 'txn_id', $payment_detail['payment_id'] );

		if ( $this->publish_property ) {
			// Publish property.
			$property_args = array(
				'ID'          => $property_id,
				'post_status' => 'publish',
			);

			// Update the post into the database.
			wp_update_post( $property_args );
		}
	}
}
