<header class="rh-header-slim">
    <div class="rh-header-slim-left">
        <div class="rh-logo">
            <h2 class="rh-site-title"><a
                        href="<?php echo esc_url( realhomes_get_dashboard_page_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
            </h2>
        </div><!-- .rh-logo -->
        <div id="rh-sidebar-menu-toggle" class="rh-sidebar-menu-toggle rh-menu-toggle"
             title="<?php esc_html_e( 'Open Sidebar Menu', 'framework' ); ?>">
            <div class="stacked-lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="cross">
                <span></span>
                <span></span>
            </div>
        </div><!-- .rh-sidebar-menu-toggle -->
    </div>
    <div class="rh-header-slim-right">
        <nav id="rh-main-menus" class="rh-main-menus">
            <div id="rh-responsive-menu-toggle" class="rh-responsive-menu-toggle rh-menu-toggle">
                <div class="stacked-lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="cross">
                    <span></span>
                    <span></span>
                </div>
            </div><!-- .rh-responsive-menu-toggle -->
			<?php
			if ( has_nav_menu( 'responsive-menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'responsive-menu',
					'walker'         => new RH_Walker_Nav_Menu(),
					'menu_class'     => 'rh-menu-responsive clearfix',
					'fallback_cb'    => false // Do not fall back to wp_page_menu()
				) );
			}

			if ( has_nav_menu( 'main-menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'main-menu',
					'walker'         => new RH_Walker_Nav_Menu(),
					'menu_class'     => 'rh-menu-main clearfix',
					'fallback_cb'    => false // Do not fall back to wp_page_menu()
				) );
			}
			?>
        </nav><!-- .rh-main-menus -->
		<?php
		$current_user      = wp_get_current_user();
		$current_user_meta = get_user_meta( $current_user->ID );
		?>
        <ul class="rh-user-account">
			<?php if ( is_user_logged_in() ) :
				$greeting_text = get_option( 'inspiry_user_greeting_text', esc_html__( 'Hello', 'framework' ) );
				?>
                <li class="rh-user-account-username">
					<?php
					if ( ! empty( $greeting_text ) ) : ?>
                        <strong><?php echo esc_html( $greeting_text ); ?>,</strong>
					<?php endif; ?>
                    <span class="display-name"><?php echo esc_html( $current_user->display_name ); ?></span>
                </li>
			<?php endif; ?>
            <li class="rh-user-account-profile-image">
				<?php
				if ( is_user_logged_in() ) {
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
							inspiry_safe_include_svg( 'images/icon-profile.svg', '/common/' );
						}
					}
					?>
                    <i class="fas fa-angle-down"></i>
                    <div class="rh-user-links-dropdown">
						<?php realhomes_dashboard_header_menu(); ?>
                    </div>
					<?php
				} else {
					inspiry_safe_include_svg( 'images/icon-profile.svg', '/common/' );
				}
				?>
            </li>
	        <?php
	        $show_submit_button = get_option( 'inspiry_show_submit_on_login', 'false' );
	        $submit_url         = inspiry_get_submit_property_url();

	        if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_submit_property_module_display' ) ) {
		        $submit_url = realhomes_get_dashboard_page_url( 'properties&submodule=submit-property' );
	        }

	        if ( ! empty( $submit_url ) && ( 'hide' !== $show_submit_button ) ) :
		        if ( inspiry_no_membership_disable_stuff() ) :
			        ?>
                    <li class="rh-user-account-add-property-btn">
				        <?php
				        $theme_submit_button_text = get_option( 'theme_submit_button_text' );
				        if ( empty( $theme_submit_button_text ) ) {
					        $theme_submit_button_text = esc_html__( 'Submit', 'framework' );
				        }

				        $submit_link_format = '<a class="btn btn-primary" href="%s">%s</a>';
				        if ( 'true' === $show_submit_button ) {
					        if ( is_user_logged_in() || inspiry_guest_submission_enabled() ) {
						        printf( $submit_link_format, esc_url( $submit_url ), esc_html( $theme_submit_button_text ) );
					        }
				        } else {
					        if ( ! is_user_logged_in() && ! inspiry_guest_submission_enabled() ) {
						        $submit_link_format = '<a class="btn btn-primary ask-for-login" href="%s">%s</a>';
					        }

					        printf( $submit_link_format, esc_url( $submit_url ), esc_html( $theme_submit_button_text ) );
				        }
				        ?>
                    </li>
		        <?php
		        endif;
	        endif;
	        ?>
        </ul><!-- .rh-user-account -->
    </div>
</header><!-- .rh-header-slim -->