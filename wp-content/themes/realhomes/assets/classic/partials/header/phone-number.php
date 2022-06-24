<?php
/**
 * Header Partial: Phone Number
 *
 * @since 2.6.2
 */
$header_phone = get_option( 'theme_header_phone' );
if ( ! empty( $header_phone ) ) {
	$header_phone_icon = get_option( 'theme_header_phone_icon', 'phone' );
	?>
    <h2 class="contact-number"><i class=" <?php
        if ( 'phone' == $header_phone_icon ) {
            echo 'fas fa-phone';
        }else{
            echo "fab fa-whatsapp";
        }
        ?>"></i>

		<?php if ( 'phone' == $header_phone_icon ) {
			$phone_click = "tel://" . esc_attr( $header_phone );
		} else {
			$phone_click = "https://api.whatsapp.com/send?phone=" . esc_attr( $header_phone );
		}
		?>
        <a class="rh_make_a_call" target="_blank" href="<?php echo esc_url( $phone_click ); ?>"
           title="<?php esc_attr_e( 'Make a Call', 'framework' ); ?>"><?php echo esc_html( $header_phone ); ?></a>
        <span class="outer-strip"></span>
    </h2>
	<?php
}
?>