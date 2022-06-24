<?php
$isp_settings = get_option( 'isp_settings' ); // Stripe settings.
$rpp_settings = get_option( 'rpp_settings' ); // PayPal settings.

// Check if PayPal or Stripe payment is enabled.
if ( ! empty( $isp_settings['enable_stripe'] ) || ! empty( $rpp_settings['enable_paypal'] ) ) {
	$price_column = esc_html__( 'Payment & Actions', 'framework' );
} else {
	$price_column = esc_html__( 'Price & Actions', 'framework' );
}
?>
<div class="dashboard-posts-list-head">
    <div class="large-column-wrap">
        <div class="column column-thumbnail"><span><?php esc_html_e( 'Photo', 'framework' ); ?></span></div>
        <div class="column column-info"><span><?php esc_html_e( 'Property Info', 'framework' ); ?></span></div>
    </div>
    <div class="small-column-wrap">
        <div class="column column-date"><span><?php esc_html_e( 'Added On', 'framework' ); ?></span></div>
        <div class="column column-property-status"><span><?php esc_html_e( 'Property Status', 'framework' ); ?></span></div>
        <div class="column column-status"><span><?php esc_html_e( 'Status', 'framework' ); ?></span></div>
        <div class="column column-price"><span><?php echo esc_html( $price_column ); ?></span></div>
    </div>
</div>