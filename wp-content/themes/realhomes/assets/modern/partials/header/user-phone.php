<?php

$header_phone = get_option( 'theme_header_phone' );
if ( ! empty( $header_phone ) ) {
	$header_phone_icon = get_option( 'theme_header_phone_icon', 'phone' );
	?>
    <div class="rh_menu__user_phone">
		<?php inspiry_safe_include_svg( '/images/icons/icon-' . $header_phone_icon . '.svg' ); ?>

		<?php if ( 'phone' == $header_phone_icon ) {
			$phone_click = "tel://" . esc_attr( $header_phone );
		} else {
			$phone_click = "https://api.whatsapp.com/send?phone=" . esc_html( $header_phone );
		}
		?>
        <a target="_blank" href="<?php echo esc_url( $phone_click ); ?>"
           class="contact-number"><?php echo esc_html( $header_phone ); ?></a>

    </div>                        <!-- /.rh_menu__user_phone -->
	<?php
}
?>

