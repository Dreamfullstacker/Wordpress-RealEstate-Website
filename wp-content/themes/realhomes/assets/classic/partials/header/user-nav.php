<?php
/**
 * User Navigation
 */
$enable_user_nav = get_option( 'theme_enable_user_nav', 'true' );
if ( 'true' == $enable_user_nav ) {
	?>
    <div class="user-nav clearfix">
		<?php
		// Favorite properties page
		$favorites_url = inspiry_get_favorites_url();
		if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_favorites_module_display' ) ) {
			$favorites_url = realhomes_get_dashboard_page_url( 'favorites' );
		}

		if ( ! empty( $favorites_url ) ) {
			$require_login = get_option( 'inspiry_login_on_fav', 'no' );
			if ( ( is_user_logged_in() && 'yes' == $require_login ) || ( 'yes' != $require_login ) ) {
				?>
                <a href="<?php echo esc_url( $favorites_url ); ?>"><i
                            class="fas fa-star"></i><?php esc_html_e( 'Favorites', 'framework' ); ?></a>
				<?php
			} else {
				?>
                <a class="rh_menu__user_profile" href="#"><i
                            class="fas fa-star"></i><?php esc_html_e( 'Favorites', 'framework' ); ?></a>
				<?php
			}
		}

		// Property Submit Page
		$show_submit_button = get_option( 'inspiry_show_submit_on_login', 'true' );
		$submit_url         = inspiry_get_submit_property_url();

		if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_submit_property_module_display' ) ) {
			$submit_url = realhomes_get_dashboard_page_url( 'properties&submodule=submit-property' );
		}

		if ( ! empty( $submit_url ) && ( 'hide' !== $show_submit_button ) ) {

			if ( inspiry_no_membership_disable_stuff() ) {

				$theme_submit_button_text = get_option( 'theme_submit_button_text' );
				if ( empty( $theme_submit_button_text ) ) {
					$theme_submit_button_text = esc_html__( 'Submit', 'framework' );
				}

				if ( is_user_logged_in() || inspiry_guest_submission_enabled() ) {
					$login_required = '';
				} else {
					$login_required = ' inspiry_submit_login_required ';
				}

				$submit_link_format = '<a class="%s" href="%s"><i class="fas fa-plus-circle"></i>%s</a>';
				if ( 'true' === $show_submit_button ) {
					if ( is_user_logged_in() || inspiry_guest_submission_enabled() ) {
						printf( $submit_link_format, esc_attr( $login_required ), esc_url( $submit_url ), esc_html( $theme_submit_button_text ) );
					}
				} else {
					printf( $submit_link_format, esc_attr( $login_required ), esc_url( $submit_url ), esc_html( $theme_submit_button_text ) );
				}
			}
		}

		if ( is_user_logged_in() ) {

			// Saved Searches Page.
			if ( is_user_logged_in() && inspiry_is_save_search_enabled() ) {
				$saved_searches       = realhomes_get_dashboard_page_url( 'saved-searches' );
				$saved_searches_label = get_option( 'realhomes_saved_searches_label', esc_html__( 'Saved Searches', 'framework' ) );
				if ( ! empty( $saved_searches_label ) ) {
					?>
					<a href="<?php echo esc_url( $saved_searches ); ?>">
						<i class="fas fa-bell"></i><?php echo esc_html( $saved_searches_label ); ?>
					</a>
					<?php
				}
			}

			// My Properties Page
			$my_properties_url = inspiry_get_my_properties_url();
			if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_properties_module_display' ) ) {
				$my_properties_url = realhomes_get_dashboard_page_url( 'properties' );
			}

			if ( ! empty( $my_properties_url ) && inspiry_no_membership_disable_stuff() ) {
				?><a href="<?php echo esc_url( $my_properties_url ); ?>">
                <i class="fas fa-th-list"></i><?php esc_html_e( 'My Properties', 'framework' ); ?></a><?php
			}

			// Edit Profile Page
			$profile_url = inspiry_get_edit_profile_url();
			if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_profile_module_display' ) ) {
				$profile_url = realhomes_get_dashboard_page_url( 'profile' );
			}

			if ( ! empty( $profile_url ) ) {
				?><a href="<?php echo esc_url( $profile_url ); ?>">
                <i class="fas fa-user"></i><?php esc_html_e( 'Profile', 'framework' ); ?></a><?php
			} else {
				?><a href="<?php echo network_admin_url( 'profile.php' ); ?>">
                <i class="fas fa-user"></i><?php esc_html_e( 'Profile', 'framework' ); ?></a><?php
			}

			// Logout
			?>
            <a class="last" href="<?php echo wp_logout_url( home_url() ); ?>"><i class="fas fa-sign-out-alt"></i><?php esc_html_e( 'Logout', 'framework' ); ?></a>
			<?php
		} else {

			// Login and Register
			$theme_login_url = inspiry_get_login_register_url();
			if ( ! empty( $theme_login_url ) ) {
				?><a class="last" href="<?php echo esc_url( $theme_login_url ); ?>">
                <i class="fas fa-sign-in-alt"></i>
				<?php
				if ( get_option( 'users_can_register' ) ) {
					esc_html_e( 'Login / Register', 'framework' );
				} else {
					esc_html_e( 'Login', 'framework' );
				}
				?>
                </a><?php
			} else {
				?><a class="last rh_menu__user_profile" href="#">
                <i class="fas fa-sign-in-alt"></i>
				<?php
				if ( get_option( 'users_can_register' ) ) {
					esc_html_e( 'Login / Register', 'framework' );
				} else {
					esc_html_e( 'Login', 'framework' );
				}
				?>
                </a><?php
			}
		} ?>
    </div>
	<?php
}