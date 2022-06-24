<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.1.0
 * @package    inspiry-stripe-payments
 * @subpackage inspiry-stripe-payments/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and public-facing stylesheet and JavaScript.
 *
 * @since 1.1.0
 */
class Inspiry_Stripe_Payments_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.1.0
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
	 * @since    1.1.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/inspiry-stripe-payments-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/inspiry-stripe-payments-public.js', array( 'jquery' ), $this->version, false );


		$stripe_settings = get_option( 'isp_settings' );
		if ( ! empty( $stripe_settings['enable_stripe'] ) && '1' === $stripe_settings['enable_stripe'] ) {
			if ( ! empty( $_GET['module'] ) && 'properties' === $_GET['module'] ) {
				wp_enqueue_script(
					'stripe-library-v3',
					'https://js.stripe.com/v3/',
					array( 'jquery' ),
					$this->version,
					false
				);
			}
		}
	}

}

if ( ! function_exists( 'isp_stripe_button' ) && isp_is_enabled() ) {
	/**
	 * Stripe payment button.
	 *
	 * @param int $property_id Property ID.
	 */
	function isp_stripe_button( $property_id ) {

		$isp_settings    = get_option( 'isp_settings' );
		$publishable_key = $isp_settings['publishable_key'];
		$button_label    = empty( $isp_settings['button_label'] ) ? esc_html__( 'Pay with Card', 'inspiry-stripe-payments' ) : $isp_settings['button_label'];

		?>
		<button
			class="stripe-checkout-btn btn btn-primary"
			data-desc="<?php echo esc_attr( get_the_title( $property_id ) ); ?>"
			data-property_id="<?php echo esc_attr( $property_id ); ?>"
			data-nonce="<?php echo wp_create_nonce( 'isp-nonce' ); ?>"
			data-key="<?php echo esc_attr( $publishable_key ); ?>"
		><?php echo esc_attr( $button_label ); ?></button>
		<?php
	}
}
