<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 * @package    realhomes-paypal-payments
 * @subpackage realhomes-paypal-payments/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and public-facing stylesheet and JavaScript.
 *
 * @since 1.0.0
 */
class Realhomes_Paypal_Payments_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/realhomes-paypal-payments-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/realhomes-paypal-payments-public.js', array( 'jquery' ), $this->version, false );

	}

}

if ( ! function_exists( 'rpp_paypal_button' ) && rpp_is_enabled() ) {
	/**
	 * PayPal payment button.
	 *
	 * @param int $property_id Property ID.
	 */
	function rpp_paypal_button( $property_id ) {

		$rpp_settings = get_option( 'rpp_settings' );
		$button_label = ! empty( $rpp_settings['button_label'] ) ? $rpp_settings['button_label'] : esc_html__( 'Pay with PayPal', 'realhomes-paypal-payments' );

		?>
		<form method="POST" class="paypal-button">
			<input type="hidden" name="property_id" value="<?php echo esc_attr( $property_id ); ?>">
			<input type="hidden" name="paypal_payment_nonce" value="<?php echo esc_attr( wp_create_nonce( 'paypal_payment_' . $property_id ) ); ?>">
			<input type="submit" name="create_payment" class="real-btn btn-mini" value="<?php echo esc_html( $button_label ); ?>">
		</form>
		<?php
	}
}
