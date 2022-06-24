<?php
// Header email.
$header_email = get_option( 'theme_header_email' );
if ( ! empty( $header_email ) ) {
	?>
    <div id="contact-email">
		<?php inspiry_safe_include_svg( '/images/icon-mail.svg' );

		$email_label = get_option( 'inspiry_header_email_label', esc_html__( 'Email us at', 'framework' ) );
		echo esc_html( $email_label );

		?> :
        <a href="mailto:<?php echo antispambot( sanitize_email( $header_email ) ); ?>"><?php echo antispambot( sanitize_email( $header_email ) ); ?></a>
    </div>
	<?php
}
?>