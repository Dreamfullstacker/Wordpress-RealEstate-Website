<?php
if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
	$form_design = 'rh_login_modal_classic';
} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
	$form_design = 'rh_login_modal_modern';
}
$inspiry_login_quote_side_display = get_option( 'inspiry_login_quote_side_display', 'true' );

$users_can_register = get_option('users_can_register');


?>
<div class="rh_login_modal_wrapper <?php echo esc_attr( $form_design ); ?>">
    <div class="rh_login_modal_box <?php if (! ('true' == $inspiry_login_quote_side_display )) {echo esc_attr('rh_login_no_quote');} ?>">
        <span class="rh_login_close"><i class="fas fa-times"></i></span>
		<?php

		if ( 'true' == $inspiry_login_quote_side_display ) {
			?>
            <div class="rh_login_sides rh_login_quote_side"
				<?php if ( ! empty( get_option( 'theme_login_modal_background' ) ) ) {
					?>
                    style="background-image: url('<?php echo esc_url( get_option( 'theme_login_modal_background' ) ); ?>')"
					<?php
				} ?>>
                <div class="rh_bg_layer"></div>
                <div class="rh_wapper_quote_contents">
                    <div class="rh_login_quote_box">
						<?php $inspiry_login_quote_text = get_option( 'inspiry_login_quote_text', 'Owning a home is a keystone of wealth… both financial affluence and emotional security.' );

						if ( ! empty( $inspiry_login_quote_text ) ) {
							?>
                            <span class="rh_login_quote_mark">
                                <?php include( get_template_directory() . '/common/images/login-quote.svg' ); ?>
                            </span>
                            <p class="rh_login_quote">
								<?php echo esc_html( $inspiry_login_quote_text ); ?>
                            </p>
							<?php
							$inspiry_login_quote_author = get_option( 'inspiry_login_quote_author', 'Suze Orman' );
							if ( ! empty( $inspiry_login_quote_author ) ) {
								?>
                                <span class="rh_login_quote_author"><?php echo esc_html( $inspiry_login_quote_author ) ?></span>
								<?php
							}
						}
						?>
                    </div>
					<?php
					$inspiry_login_date_day_display = get_option( 'inspiry_login_date_day_display', 'true' );

					if ( 'true' == $inspiry_login_date_day_display ) {
						?>
                        <div class="rh_login_date_box">
                            <span class="rh_login_date"><?php echo wp_date( 'jS F Y' ); ?></span>
                            <span class="rh_login_day"><?php echo wp_date( 'l' ); ?>!</span>
                        </div>
						<?php
					}
					?>

                </div>
            </div>
			<?php
		}
		?>
        <div class="rh_login_sides rh_login_form_side">
			<?php
			$inspiry_login_bloginfo_display = get_option( 'inspiry_login_bloginfo_display', 'site-title' );

			if ( 'site-logo' == $inspiry_login_bloginfo_display ) {
				?>
                <div class="rh_login_logo">
					<?php get_template_part( 'assets/modern/partials/header/site-logo' ); ?>
                </div>
				<?php
			} elseif ( 'site-title' == $inspiry_login_bloginfo_display ) {
				?>
                <div class="rh_login_blog_name">
					<?php bloginfo( 'name' ); ?>
                </div>
				<?php
			}
			?>

            <ul class="rh_login_tabs">
				<?php
				$inspiry_login_text = get_option( 'inspiry_login_text' );
				if ( ! empty( $inspiry_login_text ) ) {
					?>
                    <li class="rh_login_tab rh_login_target rh_active"><?php echo esc_html( $inspiry_login_text ) ?></li>
					<?php
				} else {
					?>
                    <li class="rh_login_tab rh_login_target rh_active"><?php esc_html_e( 'Login', 'framework' ) ?></li>
					<?php
				}

				if ( $users_can_register ) {
					$inspiry_login_register_text = get_option( 'inspiry_login_register_text' );
					if ( ! empty( $inspiry_login_register_text ) ) {
						?>
                        <li class="rh_login_tab rh_register_target "><?php echo esc_html( $inspiry_login_register_text ) ?></li>
						<?php
					} else {
						?>
                        <li class="rh_login_tab rh_register_target "><?php esc_html_e( 'Register', 'framework' ) ?></li>
						<?php
					}
				}
				?>
            </ul>

            <div class="rh_wrapper_login_forms">
                <div class="rh_form_modal rh_login_form rh_login_modal_show">

					<?php

					$inspiry_login_user_name_label       = get_option( 'inspiry_login_user_name_label' );
					$inspiry_login_user_name_placeholder = get_option( 'inspiry_login_user_name_placeholder' );

					if ( ! empty( $inspiry_login_user_name_label ) ) {
						$label_user_name = $inspiry_login_user_name_label;
					} else {
						$label_user_name = esc_html__( 'Username', 'framework' );
					}

					if ( ! empty( $inspiry_login_user_name_placeholder ) ) {
						$placeholder_user_name = $inspiry_login_user_name_placeholder;
					} else {
						$placeholder_user_name = esc_html__( 'Username', 'framework' );
					}

					$inspiry_login_password_label       = get_option( 'inspiry_login_password_label' );
					$inspiry_login_password_placeholder = get_option( 'inspiry_login_password_placeholder' );

					if ( ! empty( $inspiry_login_password_label ) ) {
						$label_password = $inspiry_login_password_label;
					} else {
						$label_password = esc_html__( 'Password', 'framework' );
					}

					if ( ! empty( $inspiry_login_password_placeholder ) ) {
						$placeholder_password = $inspiry_login_password_placeholder;
					} else {
						$placeholder_password = esc_html__( 'Password', 'framework' );
					}

					$inspiry_register_email_label       = get_option( 'inspiry_register_email_label' );
					$inspiry_register_email_placeholder = get_option( 'inspiry_register_email_placeholder' );

					if ( ! empty( $inspiry_register_email_label ) ) {
						$label_email = $inspiry_register_email_label;
					} else {
						$label_email = esc_html__( 'Email', 'framework' );
					}

					if ( ! empty( $inspiry_register_email_placeholder ) ) {
						$placeholder_email = $inspiry_register_email_placeholder;
					} else {
						$placeholder_email = esc_html__( 'Email', 'framework' );
					}

					$inspiry_login_forget_text = get_option( 'inspiry_login_forget_text' );
					if ( ! empty( $inspiry_login_forget_text ) ) {
						$tab_forget = $inspiry_login_forget_text;
					} else {
						$tab_forget = esc_html__( 'Forget Password?', 'framework' );
					}

					$inspiry_restore_password_placeholder = get_option( 'inspiry_restore_password_placeholder' );
					if ( ! empty( $inspiry_restore_password_placeholder ) ) {
						$placeholder_restore = $inspiry_restore_password_placeholder;
					} else {
						$placeholder_restore = esc_html__( 'Username or Email', 'framework' );
					}


					?>


                    <form id="rh_modal__login_form" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
                          method="POST" enctype="multipart/form-data">
                        <label class="rh_modal_labels"
                               for="username"><?php echo esc_html( $label_user_name ) ?></label>
                        <input name="log" class="rh_modal_field focus-class" autocomplete="username" id="username"
                               type="text"
                               placeholder="<?php echo esc_attr( $placeholder_user_name ); ?>"
                               title="<?php echo esc_attr( $placeholder_user_name ); ?>" required autofocus/>
                        <div class="rh_wrapper_inline_labels">
                            <label class="rh_modal_labels rh_modal_label_password"
                                   for="password"><?php echo esc_html( $label_password ) ?></label>
                            <span class="rh_forget_password_trigger"><?php echo esc_html( $tab_forget ); ?></span>
                        </div>
                        <input name="pwd" class="rh_modal_field" autocomplete="current-password" id="password"
                               type="password"
                               placeholder="<?php echo esc_attr( $placeholder_password ); ?>"
                               title="<?php echo esc_attr( $placeholder_password ); ?>" required/>
						<?php

						if ( class_exists( 'Easy_Real_Estate' ) ) {
							if ( ere_is_reCAPTCHA_configured() ) {
								$recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
								if ( ! is_page_template( 'templates/contact.php' ) && empty( get_option( 'inspiry_contact_form_shortcode' ) )
								) {
									?>
                                    <div class="rh_modal__recaptcha">
                                        <div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                            <div class="inspiry-google-recaptcha"></div>
                                        </div>
                                    </div>
									<?php
								}
							}
						}
						?>
                        <input type="hidden" name="action" value="inspiry_ajax_login"/>
						<?php
						wp_nonce_field( 'inspiry-ajax-login-nonce', 'inspiry-secure-login' );
						?>
                        <input type="hidden" name="redirect_to"
                               value="<?php echo esc_url( inspiry_get_login_redirect_Url() ); ?>"/>
						<?php
						$inspiry_login_button_text = get_option( 'inspiry_login_button_text' );
						if ( ! empty( $inspiry_login_button_text ) ) {
							?>
                            <button id="login-button"
                                    type="submit"><?php echo esc_html( $inspiry_login_button_text ); ?></button>
							<?php
						} else {
							?>
                            <button id="login-button"
                                    type="submit"><?php esc_html_e( 'Login', 'framework' ); ?></button>
							<?php
						}
						?>
                    </form>

                </div>


                <?php
                if ( $users_can_register ) {
                ?>
                <div class="rh_form_modal rh_register_form">
                    <form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" id="rh_modal__register_form"
                          method="post" enctype="multipart/form-data">
                        <label class="rh_modal_labels"
                               for="register_username"><?php echo esc_html( $label_user_name ); ?></label>
                        <input class="rh_modal_field" id="register_username" name="register_username" type="text"
                               placeholder="<?php echo esc_attr( $inspiry_login_user_name_placeholder ); ?>"
                               title="<?php echo esc_attr( $inspiry_login_user_name_placeholder ); ?>" required/>
                        <label class="rh_modal_labels"
                               for="register_email"><?php echo esc_html( $label_email ) ?></label>
                        <input class="rh_modal_field" id="register_email" name="register_email" type="text"
                               placeholder="<?php echo esc_attr( $placeholder_email ); ?>"
                               title="<?php echo esc_attr( $placeholder_email ); ?>" required/>
						<?php

						/**
						 * Render custom user registration fields
						 */
						$user_fields = apply_filters( 'inspiry_additional_user_fields', array() );
						if ( is_array( $user_fields ) && ! empty( $user_fields ) ) {
							foreach ( $user_fields as $field ) {

								// Check if field is enabled for the Register Form
								if ( empty( $field['show'] ) || ! is_array( $field['show'] ) || ! in_array( 'register_form', $field['show'] ) ) {
									continue;
								}

								// Validate field data and render it
								if ( ! empty( $field['id'] ) && ! empty( $field['name'] ) ) {

									$required = false;
									if ( ! empty( $field['required'] ) && $field['required'] === true ) {
										$required = true;
									}

									if ( ! empty( $field['type'] ) && $field['type'] == 'select' && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
										?>
                                        <label class="rh_modal_labels"
                                               for="<?php echo esc_attr( $field['id'] ); ?>"><?php echo esc_html( $field['name'] ) ?></label>
                                        <div class="rh_modal_role_select">

                                            <select name="<?php echo esc_attr( $field['id'] ); ?>"
                                                    class="rh_custom_login_modal_select inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick dropup"
                                                    id="<?php echo esc_attr( $field['id'] ); ?>"
                                                    data-dropup-auto="false"
												<?php
												echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
												echo ( true === $required ) ? 'class="required" required' : '';
												?>>
												<?php
												foreach ( $field['options'] as $key => $value ) {
													echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
												}
												?>
                                            </select>
                                        </div>
										<?php
									} else {
										?>
                                        <label class="rh_modal_labels"
                                               for="<?php echo esc_attr( $field['id'] ); ?>"><?php echo esc_html( $field['name'] ) ?></label>
                                        <input
                                                class="rh_modal_field"
                                                type="text"
                                                id="<?php echo esc_attr( $field['id'] ); ?>"
                                                name="<?php echo esc_attr( $field['id'] ); ?>"
											<?php
											echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
											echo ( ! empty( $field['name'] ) ) ? 'placeholder="' . esc_attr( $field['name'] ) . '"' : '';
											echo ( true === $required ) ? 'class="required" required' : '';
											?>
                                        />
										<?php
									}
								}
							}
						}

						$user_sync = inspiry_is_user_sync_enabled();
						if ( 'true' == $user_sync ) {
							$user_roles = inspiry_user_sync_roles();
							if ( ! empty( $user_roles ) && is_array( $user_roles ) ) {

								$inspiry_register_user_role_label       = get_option( 'inspiry_register_user_role_label' );
								$inspiry_register_user_role_placeholder = get_option( 'inspiry_register_user_role_placeholder' );

								if(!empty($inspiry_register_user_role_label)){
								    $user_role_label = $inspiry_register_user_role_label;
                                }else{
									$user_role_label = esc_html__('User Role','framework');
                                }

								if(!empty($inspiry_register_user_role_placeholder)){
								    $user_role_placeholder = $inspiry_register_user_role_placeholder;
                                }else{
									$user_role_placeholder = esc_html__('User Role','framework');
                                }

								?>
                                <label class="rh_modal_labels"
                                       for="register_username"><?php echo esc_html( $user_role_label ); ?></label>
                                <div class="rh_user_role rh_modal_role_select">
                                    <select name="user_role" id="user-role" class="inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick dropup"
                                            data-dropup-auto="false">
                                        <option value=""><?php echo esc_html( $user_role_placeholder ); ?></option>
										<?php
										foreach ( $user_roles as $key => $value ) {
											echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
										}
										?>
                                    </select>
                                </div>
								<?php
							}
						}

						if ( class_exists( 'Easy_Real_Estate' ) ) {
							if ( ere_is_reCAPTCHA_configured() && ! is_page_template( 'templates/contact.php' )
							) {
								?>
                                <div class="rh_modal__recaptcha">
                                    <div class="inspiry-recaptcha-wrapper tt clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                        <div class="inspiry-google-recaptcha"></div>
                                    </div>
                                </div>
								<?php
							} elseif ( ere_is_reCAPTCHA_configured() && empty( get_option( 'inspiry_contact_form_shortcode' ) ) ) {
								?>
                                <div class="rh_modal__recaptcha">
                                    <div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                        <div class="inspiry-google-recaptcha"
                                             style=""></div>
                                    </div>
                                </div>
								<?php
							}
						}
						?>
                        <input type="hidden" name="user-cookie" value="1"/>
                        <input type="hidden" name="action" value="inspiry_ajax_register"/>
						<?php
						// Nonce for security.
						wp_nonce_field( 'inspiry-ajax-register-nonce', 'inspiry-secure-register' );

						if ( is_page() || is_single() ) {
							?>
                            <input type="hidden" name="redirect_to" value="
							<?php
							wp_reset_postdata();
							global $post;
							the_permalink( get_the_ID() );
							?>
							"/>
							<?php

						} else {
							?>
                            <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/' ) ); ?>"/>
							<?php
						}

						$inspiry_register_button_text = get_option( 'inspiry_register_button_text' );
						if ( ! empty( $inspiry_register_button_text ) ) {
							?>
                            <button type="submit" id="register-button"
                                    name="user-submit"><?php echo esc_html( $inspiry_register_button_text ); ?></button>
							<?php
						} else {
							?>
                            <button type="submit" id="register-button"
                                    name="user-submit"><?php esc_html_e( 'Register', 'framework' ); ?></button>
							<?php
						}
						?>

                    </form>
                </div>
                <?php } ?>
                <div class="rh_form_modal rh_password_reset_form">
                    <form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" id="rh_modal__forgot_form"
                          method="post" enctype="multipart/form-data">
                        <input id="reset_username_or_email" name="reset_username_or_email" type="text"
                               placeholder="<?php echo esc_attr( $placeholder_restore ); ?>"
                               class="rh_modal_field required"
                               title="<?php echo esc_attr( $placeholder_restore ); ?>" required/>
						<?php
						if ( class_exists( 'Easy_Real_Estate' ) ) {
							if ( ere_is_reCAPTCHA_configured() && ! is_page_template( 'templates/contact.php' ) ) {
								?>
                                <div class="rh_modal__recaptcha">
                                    <div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                        <div class="inspiry-google-recaptcha"></div>
                                    </div>
                                </div>
								<?php
							} elseif ( ere_is_reCAPTCHA_configured() && empty( get_option( 'inspiry_contact_form_shortcode' ) ) ) {
								?>
                                <div class="rh_modal__recaptcha">
                                    <div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                        <div class="inspiry-google-recaptcha"></div>
                                    </div>
                                </div>
								<?php
							}
						}
						?>
                        <input type="hidden" name="action" value="inspiry_ajax_forgot"/>
                        <input type="hidden" name="user-cookie" value="1"/>
						<?php wp_nonce_field( 'inspiry-ajax-forgot-nonce', 'inspiry-secure-reset' ); ?>

						<?php
						$inspiry_restore_button_text = get_option( 'inspiry_restore_button_text' );
						if ( ! empty( $inspiry_restore_button_text ) ) {
							?>
                            <button id="forgot-button"
                                    name="user-submit"><?php echo esc_html( $inspiry_restore_button_text ); ?></button>
							<?php
						} else {
							?>
                            <button id="forgot-button"
                                    name="user-submit"><?php esc_html_e( 'Reset Password', 'framework' ); ?></button>
							<?php
						}
						?>


                    </form>

                </div>
            </div>

            <div class="inspiry_social_login">
				<?php
				/*
				 * For social login
				 */
				do_action( 'wordpress_social_login' );

				/**
				 * RealHomes Social Login.
				 */
				do_action( 'realhomes_social_login' );
				?>
            </div>

            <div class="rh_modal_login_loader rh_modal_login_loader_hide rh_modal_login_<?php echo esc_attr(INSPIRY_DESIGN_VARIATION);?>">
	            <?php inspiry_safe_include_svg( '/images/loader.svg' ); ?>
            </div>

            <div class="rh_login_modal_messages rh_login_message_show">
                <span class="rh_login_close_message"><i class="fas fa-times"></i></span>
                <p id="forgot-error" class="rh_modal__msg"></p>
                <p id="forgot-message" class="rh_modal__msg"></p>

                <p id="register-message" class="rh_modal__msg"></p>
                <p id="register-error" class="rh_modal__msg"></p>

                <p id="login-message" class="rh_modal__msg"></p>
                <p id="login-error" class="rh_modal__msg"></p>
            </div>

        </div>
    </div>
</div>
