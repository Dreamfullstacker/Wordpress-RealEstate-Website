<?php

$header_email = get_option( 'theme_header_email' );
if ( ! empty( $header_email ) ) {
	?>
	<div class="rh_menu__user_email">
		<?php inspiry_safe_include_svg( '/images/icons/icon-mail.svg' ); ?>
		<a href="mailto:<?php echo antispambot(sanitize_email( $header_email )); ?>" class="contact-email"><?php echo antispambot(sanitize_email( $header_email )); ?></a>
	</div><!-- /.rh_menu__user_email -->
	<?php
}
?>

