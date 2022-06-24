<?php
/**
 * Header Modal
 *
 * Header modal for login in the header.
 *
 * @package realhomes_elementor_addon
 */

global $settings;
$current_user = wp_get_current_user();

?>

<div class="rhea_modal">
	<?php
	if ( is_user_logged_in() ) { ?>
        <div class="rhea_modal__corner"></div>
        <!-- /.rh_modal__corner -->

        <div class="rhea_modal__wrap">

			<?php
			if ( 'yes' == $settings['show_login_modal_avatar'] ||
			     'yes' == $settings['show_login_modal_user_name'] ) {
				?>
                <div class="rhea_user">
					<?php
					if ( 'yes' == $settings['show_login_modal_avatar'] ) {
						?>
                        <div class="rhea_user__avatar">
							<?php
							$current_user_meta = get_user_meta( $current_user->ID );

							if ( isset( $current_user_meta['profile_image_id'][0] ) ) {
								echo wp_get_attachment_image( $current_user_meta['profile_image_id'][0], array(
									'40',
									'40'
								), "", array( "class" => "rh_modal_profile_img" ) );
							} else {
								echo get_avatar(
									$current_user->user_email,
									'150',
									'gravatar_default',
									$current_user->display_name,
									array(
										'class' => 'user-icon',
									)
								);
							}
							?>

                        </div>
						<?php
					}
					if ( 'yes' == $settings['show_login_modal_user_name'] ) {
						?>
                        <!-- /.rh_user__avatar -->
                        <div class="rhea_user__details">
                            <p class="rhea_user__msg">
								<?php
								if ( ! empty( $settings['rhea_login_welcome_label'] ) ) {
									echo esc_html( $settings['rhea_login_welcome_label'] );
								} else {
									esc_html_e( 'Welcome', 'realhomes-elementor-addon' );
								}
								?>
                            </p>
                            <!-- /.rh_user__msg -->
                            <h3 class="rhea_user__name">
								<?php echo esc_html( $current_user->display_name ); ?>
                            </h3>
                        </div>
						<?php
					}
					?>
                    <!-- /.rh_user__details -->
                </div>
				<?php
			}
			?>
            <!-- /.rh_user -->

            <div class="rhea_modal__dashboard">

				<?php
				if ( 'yes' == $settings['show_login_modal_profile'] ) {
					$profile_url = inspiry_get_edit_profile_url();
					if ( ! empty( $profile_url ) ) {
						?>
                        <a href="<?php echo esc_url( $profile_url ); ?>" class="rhea_modal__dash_link">
							<?php
							include RHEA_ASSETS_DIR . '/icons/icon-dash-profile.svg';
							?>
                            <span class="rhea_login_profile_text">
                                <?php
                                if ( ! empty( $settings['rhea_login_profile_label'] ) ) {
	                                echo esc_html( $settings['rhea_login_profile_label'] );
                                } else {
	                                esc_html_e( 'Profile', 'realhomes-elementor-addon' );
                                }
                                ?>
                            </span>
                        </a>
						<?php
					}
				}
				if ( 'yes' == $settings['show_login_modal_properties'] ) {
					$my_properties_url = inspiry_get_my_properties_url();
					if ( ! empty( $my_properties_url ) ) {
						?>
                        <a href="<?php echo esc_url( $my_properties_url ); ?>" class="rhea_modal__dash_link">
							<?php
							include RHEA_ASSETS_DIR . '/icons/icon-dash-my-properties.svg';
							?>
                            <span class="rhea_my_properties_text">
                                <?php
                                if ( ! empty( $settings['rhea_login_my_properties_label'] ) ) {
	                                echo esc_html( $settings['rhea_login_my_properties_label'] );
                                } else {
	                                esc_html_e( 'My Properties', 'realhomes-elementor-addon' );
                                }
                                ?>
                            </span>
                        </a>
						<?php
					}
				}
				if ( 'yes' == $settings['show_login_modal_favorites'] ) {
					$favorites_url = inspiry_get_favorites_url(); // Favorites page.
					if ( ! empty( $favorites_url ) ) {
						?>
                        <a href="<?php echo esc_url( $favorites_url ); ?>" class="rhea_modal__dash_link">
							<?php
							include RHEA_ASSETS_DIR . '/icons/icon-dash-favorite.svg';
							?>
                            <span class="rhea_login_favorites_text">
                                <?php
                                if ( ! empty( $settings['rhea_login_favorites_label'] ) ) {
	                                echo esc_html( $settings['rhea_login_favorites_label'] );
                                } else {
	                                esc_html_e( 'Favorites', 'realhomes-elementor-addon' );
                                }
                                ?>
                            </span>
                        </a>
						<?php
					}
				}
				if ( 'yes' == $settings['show_login_modal_compare'] ) {
					$compare_properties_module = get_option( 'theme_compare_properties_module' );
					$compare_url               = inspiry_get_compare_url(); // Compare page.
					if ( ( 'enable' === $compare_properties_module ) && ! empty( $compare_url ) ) {
						?>
                        <a href="<?php echo esc_url( $compare_url ); ?>" class="rhea_modal__dash_link">
							<?php
							include RHEA_ASSETS_DIR . '/icons/icon-compare.svg';
							?>
                            <span class="rhea_login_compare_text">
                                <?php
                                if ( ! empty( $settings['rhea_login_compare_label'] ) ) {
	                                echo esc_html( $settings['rhea_login_compare_label'] );
                                } else {
	                                esc_html_e( 'Compare', 'realhomes-elementor-addon' );
                                }
                                ?>
                            </span>
                        </a>
						<?php
					}
				}

				if ( function_exists( 'IMS_Helper_Functions' ) ) {
					$ims_helper_functions  = IMS_Helper_Functions();
					$is_memberships_enable = $ims_helper_functions::is_memberships();
				}
				$membership_url = inspiry_get_membership_url(); // Memberships page.
				if ( ( ! empty( $is_memberships_enable ) ) && ! empty( $membership_url ) ) {
					?>
                    <a href="<?php echo esc_url( $membership_url ); ?>" class="rhea_modal__dash_link">
						<?php
						include RHEA_ASSETS_DIR . '/icons/icon-membership.svg';
						?>
                        <span class="rhea_login_membership_text">
                            <?php
                            if ( ! empty( $settings['rhea_login_membership_label'] ) ) {
	                            echo esc_html( $settings['rhea_login_membership_label'] );
                            } else {
	                            esc_html_e( 'Membership', 'realhomes-elementor-addon' );
                            }
                            ?>
                        </span>
                    </a>
					<?php
				}


				if ( $settings['rhea_login_add_more_repeater'] ) {
					foreach ( $settings['rhea_login_add_more_repeater'] as $item ) {
						?>
                        <a href="<?php echo esc_url( $item['rhea_page_url'] ); ?>"
                           class="rhea_modal__dash_link rhea_login_extended_link <?php echo esc_attr( 'elementor-repeater-item-' . $item['_id'] ); ?>">

							<?php if ( ! empty( $item['rhea_link_icon'] ) ) {
								\Elementor\Icons_Manager::render_icon( $item['rhea_link_icon'], [ 'aria-hidden' => 'true' ] );
							} ?>
                            <span class="rhea_login_extended">
                                <?php
                                if ( ! empty( $item['rhea_link_text'] ) ) {
	                                echo esc_html( $item['rhea_link_text'] );
                                }
                                ?>
                            </span>
                        </a>
						<?php
					}
				}
				?>

                <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="rhea_modal__dash_link">
					<?php
					include RHEA_ASSETS_DIR . '/icons/icon-dash-logout.svg';
					?>
                    <span class="rhea_logout_text">
                        <?php
                        if ( ! empty( $settings['rhea_log_out_label'] ) ) {
	                        echo esc_html( $settings['rhea_log_out_label'] );
                        } else {
	                        esc_html_e( 'Log Out', 'realhomes-elementor-addon' );
                        }
                        ?>
                    </span>
                </a>

            </div>
            <!-- /.rh_modal__dashboard -->
        </div>
        <!-- /.rh_modal__wrap -->
	<?php } ?>
</div>
<!-- /.rh_menu__modal -->




