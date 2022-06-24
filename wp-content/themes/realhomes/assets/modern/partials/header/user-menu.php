<?php
$enable_user_nav = get_option( 'theme_enable_user_nav' );

if ( ! empty( $enable_user_nav ) && 'true' === $enable_user_nav ) {

	$theme_login_url   = inspiry_get_login_register_url(); // login and register page URL
	$prop_detail_login = inspiry_prop_detail_login();
	$skip_prop_single  = ( 'yes' == $prop_detail_login && ! is_user_logged_in() && is_singular( 'property' ) );

	if ( is_user_logged_in() ) {
		?>
        <div class="rh_menu__user_profile">
			<?php
			// Get user information.
			$current_user      = wp_get_current_user();
			$current_user_meta = get_user_meta( $current_user->ID );

			if ( isset( $current_user_meta['profile_image_id'] ) && ! empty( $current_user_meta['profile_image_id'][0] ) ) {
				$profile_image = wp_get_attachment_image( $current_user_meta['profile_image_id'][0], array( '48', '48' ), "", array( "class" => "rh-user-account-profile-img" ) );
				if ( ! empty( $profile_image ) ) {
					echo wp_kses( $profile_image, array(
						'img' => array(
							'src'    => array(),
							'srcset' => array(),
							'class'  => array(),
							'width'  => array(),
							'height' => array(),
							'alt'    => array()
						)
					) );
				} else {
					inspiry_safe_include_svg( 'images/icon-profile.svg', '/common/' );
				}
			} else {
				$gravtar = get_avatar( $current_user->user_email, '150', 'gravatar_default', $current_user->display_name, array( 'class' => 'user-icon' ) );
				if ( ! empty( $gravtar ) ) {
					echo wp_kses( $gravtar, array(
						'img' => array(
							'src'    => array(),
							'srcset' => array(),
							'class'  => array(),
							'width'  => array(),
							'height' => array(),
							'alt'    => array()
						)
					) );
				} else {
					inspiry_safe_include_svg( '/images/icons/icon-profile.svg' );
				}
			}

			// modal login.
			get_template_part( 'assets/modern/partials/header/modal' );
			?>
        </div><!-- /.rh_menu__user_profile -->
		<?php
	} elseif (
		empty( $theme_login_url ) &&
		( ! is_page_template( 'templates/login-register.php' ) ) &&
		( ! is_user_logged_in() ) &&
		! $skip_prop_single ) {
		?>
        <div class="rh_menu__user_profile">
			<?php
			inspiry_safe_include_svg( '/images/icons/icon-profile.svg' );
			// modal login.
			get_template_part( 'assets/modern/partials/header/modal' );
			?>
        </div><!-- /.rh_menu__user_profile -->
		<?php
	} elseif ( ! empty( $theme_login_url ) && ( ! is_user_logged_in() ) ) {
		?>
        <a class="rh_menu__user_profile" href="<?php echo esc_url( $theme_login_url ); ?>">
			<?php inspiry_safe_include_svg( '/images/icons/icon-profile.svg' ); ?>
        </a><!-- /.rh_menu__user_profile -->
		<?php
	}

}
