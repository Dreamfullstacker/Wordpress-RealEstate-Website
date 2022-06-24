<?php
/**
 * Output Google reCAPTCHA Divs
 *
 * @since 1.0.0
 * @package realhomes/common
 */

if ( class_exists( 'Easy_Real_Estate' ) ) {
	if ( ere_is_reCAPTCHA_configured() ) {
	    $recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
		?>
		<div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
			<div class="inspiry-google-recaptcha"></div>
		</div>
		<?php
	}
}