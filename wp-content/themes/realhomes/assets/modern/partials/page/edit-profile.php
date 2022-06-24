<?php
/**
 * Page: Edit Profile
 *
 * Edit Profile page of the theme.
 *
 * @since    3.0.0
 * @package  realhomes/modern
 */

get_header();

// Page Head.
$header_variation = get_option( 'inspiry_member_pages_header_variation', 'banner' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}
?>
    <section class="rh_section rh_wrap rh_wrap--padding rh_wrap--topPadding">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
		<div class="rh_page">
            <div class="rh_page__head">
				<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
                    <h2 class="rh_page__title">
						<?php
						// Page Title.
						$page_title = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title', true );
						if ( empty( $page_title ) ) {
							$page_title = get_the_title( get_the_ID() );
						}
						echo inspiry_get_exploded_heading( $page_title );
						?>
                    </h2><!-- /.rh_page__title -->
				<?php endif; ?>

                <div class="rh_page__nav">
					<?php
					$profile_url = inspiry_get_edit_profile_url();
					if ( ! empty( $profile_url ) && is_user_logged_in() ) :
						?>
                        <a href="<?php echo esc_url( $profile_url ); ?>" class="rh_page__nav_item active">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-profile.svg' ); ?>
                            <p><?php esc_html_e( 'Profile', 'framework' ); ?></p>
                        </a>
					<?php
					endif;

					$my_properties_url = inspiry_get_my_properties_url();
					if ( ! empty( $my_properties_url ) && is_user_logged_in() ) :
						?>
                        <a href="<?php echo esc_url( $my_properties_url ); ?>" class="rh_page__nav_item">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-my-properties.svg' ); ?>
                            <p><?php esc_html_e( 'My Properties', 'framework' ); ?></p>
                        </a>
					<?php
					endif;

					$favorites_url = inspiry_get_favorites_url(); // Favorites page.
					if ( ! empty( $favorites_url ) ) :
						?>
                        <a href="<?php echo esc_url( $favorites_url ); ?>" class="rh_page__nav_item">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-favorite.svg' ); ?>
                            <p><?php esc_html_e( 'Favorites', 'framework' ); ?></p>
                        </a>
					<?php endif;

					if ( is_user_logged_in() && function_exists( 'IMS_Helper_Functions' ) ) {
						$ims_helper_functions  = IMS_Helper_Functions();
						$is_memberships_enable = $ims_helper_functions::is_memberships();
						$membership_url        = inspiry_get_membership_url(); // Memberships page.

						if ( ( ! empty( $is_memberships_enable ) ) && ! empty( $membership_url ) ) {
							?>
                            <a href="<?php echo esc_url( $membership_url ); ?>" class="rh_page__nav_item">
								<?php inspiry_safe_include_svg( '/images/icons/icon-membership.svg' ); ?>
                                <p><?php esc_html_e( 'Membership', 'framework' ); ?></p>
                            </a>
							<?php
						}
					}
					?>
                </div><!-- /.rh_page__nav -->
            </div><!-- /.rh_page__wrap -->

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<?php if ( get_the_content() ) : ?>
                        <div class="rh_content rh_page__content"><?php the_content(); ?></div><!-- /.rh_content -->
					<?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php
			if ( ! is_user_logged_in() ) {
				$enable_user_nav = get_option( 'theme_enable_user_nav' );
				$theme_login_url = inspiry_get_login_register_url(); // Login and Register.

				if ( ! empty( $enable_user_nav ) && 'true' === $enable_user_nav ) {
					if ( empty( $theme_login_url ) ) {
						alert( esc_html__( 'Login Required:', 'framework' ), esc_html__( 'Please login to edit your profile information!', 'framework' ) );
					} elseif ( ! empty( $theme_login_url ) ) {
						alert( esc_html__( 'Login Required:', 'framework' ), sprintf( esc_html__( 'Please %1$s login %2$s to edit your profile information!', 'framework' ), '<a href="' . esc_url( $theme_login_url ) . '">', '</a>' ) );
					}
				} else {
					alert( esc_html__( 'Login Required:', 'framework' ), esc_html__( 'Please login to edit your profile information!', 'framework' ) );
				}
			} elseif ( is_user_logged_in() ) {
				// Get user information.
				$current_user      = wp_get_current_user();
				$authordata        = get_userdata( $current_user->ID );
				$current_user_meta = get_user_meta( $current_user->ID );
				?>

                <div class="rh_form">
                    <form id="inspiry-edit-user" enctype="multipart/form-data" class="rh_form__form">
                        <div class="rh_form__row">
                            <div class="rh_form__item rh_form__user_profile user-profile-img-wrapper">
                                <div id="user-profile-img">
                                    <div class="profile-thumb">
										<?php
										if ( isset( $current_user_meta['profile_image_id'] ) ) {
											$profile_image_id = intval( $current_user_meta['profile_image_id'][0] );
											if ( $profile_image_id ) {
												echo wp_get_attachment_image( $profile_image_id, 'agent-image' );
												echo '<input type="hidden" class="profile-image-id" name="profile-image-id" value="' . esc_attr( $profile_image_id ) . '"/>';
											}
										}
										?>
                                    </div>
                                </div><!-- end of user profile image -->

                                <div class="profile-img-controls">
                                    <a id="select-profile-image" class="rh_btn rh_btn--secondary" href="javascript:;"><?php esc_html_e( 'Upload New Picture', 'framework' ); ?></a>
                                    <a id="remove-profile-image" class="rh_btn rh_btn--profileDelete" href="#remove-profile-image"><?php esc_html_e( 'Delete', 'framework' ); ?></a>
                                    <p class="field-description">
										<?php esc_html_e( 'Profile image should have minimum width of 128px and minimum height of 128px.', 'framework' ); ?>
										<?php esc_html_e( 'Make sure to save changes after changing the image.', 'framework' ); ?>
                                    </p>
                                    <div id="errors-log"></div>
                                </div><!-- end of profile image controls -->
                            </div><!-- /.rh_form__item -->
                        </div><!-- /.rh_form__row -->

                        <div class="rh_form__row">

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="first-name"><?php esc_html_e( 'First Name', 'framework' ); ?></label>
                                <input name="first-name" type="text" id="first-name" placeholder="<?php esc_attr_e( 'Enter your first name', 'framework' ); ?>" value="<?php if ( isset( $current_user_meta['first_name'] ) ) {
									echo esc_attr( $current_user_meta['first_name'][0] );
								} ?>" autofocus/>
                            </div><!-- /.rh_form__item -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="last-name"><?php esc_html_e( 'Last Name', 'framework' ); ?></label>
                                <input name="last-name" type="text" id="last-name" placeholder="<?php esc_attr_e( 'Enter your last name', 'framework' ); ?>" value="<?php if ( isset( $current_user_meta['last_name'] ) ) {
									echo esc_attr( $current_user_meta['last_name'][0] );
								} ?>"/>
                            </div><!-- /.rh_form__item -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="display-name"><?php esc_html_e( 'Display Name', 'framework' ); ?> *</label>
                                <input class="required" name="display-name" type="text" id="display-name" placeholder="<?php esc_attr_e( 'Enter your display name', 'framework' ); ?>" value="<?php echo esc_attr( $current_user->display_name ); ?>" required/>
                            </div><!-- /.rh_form__item -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="email"><?php esc_html_e( 'Email', 'framework' ); ?> *</label>
                                <input class="required" name="email" type="email" id="email" placeholder="<?php esc_attr_e( 'Enter your email address', 'framework' ); ?>" value="<?php echo esc_attr( $current_user->user_email ); ?>" required/>
                            </div><!-- /.rh_form__item -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="pass1"><?php esc_html_e( 'Password', 'framework' ); ?></label>
                                <input name="pass1" type="password" id="pass1"/>
                                <p class="note"><?php esc_html_e( 'Note: Fill it only if you want to change your password', 'framework' ); ?></p>
                            </div><!-- /.rh_form__item -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="pass2"><?php esc_html_e( 'Confirm Password', 'framework' ); ?></label>
                                <input name="pass2" type="password" id="pass2"/>
                            </div><!-- /.rh_form__item -->

                            <div class="rh_form__item rh_form--2-column rh_form--columnAlign">
                                <label for="description"><?php esc_html_e( 'Biographical Information', 'framework' ) ?></label>
                                <textarea name="description" id="description" rows="5" cols="30"><?php if ( isset( $current_user_meta['description'] ) ) {
										echo esc_textarea( $current_user_meta['description'][0] );
									} ?></textarea>
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--2-column rh_form--columnAlign">
                                <label for="inspiry_user_address"><?php esc_html_e( 'Address', 'framework' ) ?></label>
                                <textarea name="inspiry_user_address" id="inspiry_user_address" rows="5" cols="30"><?php if ( isset( $current_user_meta['inspiry_user_address'] ) ) {
										echo esc_textarea( $current_user_meta['inspiry_user_address'][0] );
									} ?></textarea>
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="mobile-number"><?php esc_html_e( 'Mobile Number', 'framework' ); ?></label>
                                <input name="mobile-number" type="text" id="mobile-number" value="<?php if ( isset( $current_user_meta['mobile_number'] ) ) {
									echo esc_attr( $current_user_meta['mobile_number'][0] );
								} ?>"/>
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="office-number"><?php esc_html_e( 'Office Number', 'framework' ); ?></label>
                                <input name="office-number" type="text" id="office-number" value="<?php if ( isset( $current_user_meta['office_number'] ) ) {
									echo esc_attr( $current_user_meta['office_number'][0] );
								} ?>"/>
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="fax-number"><?php esc_html_e( 'Fax Number', 'framework' ); ?></label>
                                <input name="fax-number" type="text" id="fax-number" value="<?php if ( isset( $current_user_meta['fax_number'] ) ) {
									echo esc_attr( $current_user_meta['fax_number'][0] );
								} ?>"/>
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="inspiry_user_agency"><?php esc_html_e( 'Agency', 'framework' ); ?></label>
                                <select name="inspiry_user_agency" id="inspiry_user_agency" class="inspiry_select_picker_trigger inspiry_bs_default_mod inspiry_bs_orange show-tick">
									<?php if ( isset( $current_user_meta['inspiry_user_agency'] ) ) {
										inspiry_dropdown_posts( 'agency', $current_user_meta['inspiry_user_agency'][0], true );
									} else {
										inspiry_dropdown_posts( 'agency', - 1, true );
									} ?>
                                </select>
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

							<?php
							/**
							 * Collect custom user registration fields
							 */
							$already_displayed_fields = array(
								'profile-image-id',
								'description',
								'first-name',
								'last-name',
								'display-name',
								'email',
								'mobile_number',
								'office_number',
								'fax-number',
								'facebook-url',
								'twitter-url',
								'linkedin-url',
								'instagram-url',
								'pass1',
								'pass2',
							);

							$fields_list = array();
							$user_fields = apply_filters( 'inspiry_additional_user_fields', array() );

							if ( is_array( $user_fields ) && ! empty( $user_fields ) ) {
								foreach ( $user_fields as $field ) {

									// Check if field is enabled for the Profile Frontend Form
									if ( empty( $field['show'] ) || ! is_array( $field['show'] ) || ! in_array( 'profile_frontend', $field['show'] ) ) {
										continue;
									}

									// Validate field data and render it
									if ( ! empty( $field['id'] ) && ! empty( $field['name'] ) ) {

										// Skip to display a field if it's already displayed
										if ( in_array( $field['id'], $already_displayed_fields ) ) {
											continue;
										}

										$required = false;
										if ( ! empty( $field['required'] ) && $field['required'] === true ) {
											$required = true;
										}

										?>
                                        <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                            <label for="<?php echo esc_attr( $field['id'] ); ?>">
												<?php
												echo esc_html( $field['name'] );
												echo ( true === $required ) ? ' *' : '';
												?>
                                            </label>
											<?php
											if ( ! empty( $field['type'] ) && $field['type'] == 'select' && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
												?>
                                                <select name="<?php echo esc_attr( $field['id'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>"
													<?php
													echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
													echo ( true === $required ) ? 'class="required inspiry_bs_default_mod inspiry_bs_orange" required' : 'class="inspiry_bs_default_mod inspiry_bs_orange show-tick"';
													?>>
													<?php
													foreach ( $field['options'] as $key => $value ) {

														$selected = '';
														if ( isset( $current_user_meta[ esc_attr( $field['id'] ) ] ) && $key == $current_user_meta[ esc_attr( $field['id'] ) ][0] ) {
															$selected = 'selected';
														}

														echo '<option value="' . esc_attr( $key ) . '" ' . $selected . '>' . esc_html( $value ) . '</option>';
													}
													?>
                                                </select>
												<?php
											} else {
												?>
                                                <input
                                                        type="text"
                                                        id="<?php echo esc_attr( $field['id'] ); ?>"
                                                        name="<?php echo esc_attr( $field['id'] ); ?>"
                                                        value="<?php
														if ( isset( $current_user_meta[ esc_attr( $field['id'] ) ] ) ) {
															echo esc_attr( $current_user_meta[ esc_attr( $field['id'] ) ][0] );
														} ?>"
													<?php
													echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
													echo ( true === $required ) ? 'class="required" required' : '';
													?>/>
											<?php } ?>
                                        </div>
                                        <!-- /.rh_form__item rh_form--columnAlign -->
										<?php
									}
								}
							}
							?>

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="url"><?php esc_html_e( 'Website', 'framework' ); ?></label>
                                <div class="rh_form__social">
                                    <span class="fas fa-globe fa-lg"></span>
                                    <input name="url" type="text" id="url" value="<?php echo ( isset( $authordata->user_url ) ) ? esc_url( $authordata->user_url ) : esc_attr( 'https://' ); ?>"/>
                                </div><!-- /.rh_form__social -->
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="facebook-url"><?php esc_html_e( 'Facebook URL', 'framework' ); ?></label>
                                <div class="rh_form__social">
                                    <span class="fab fa-facebook fa-lg"></span>
                                    <input name="facebook-url" type="text" id="facebook-url" value="<?php echo ( isset( $current_user_meta['facebook_url'] ) ) ? esc_attr( $current_user_meta['facebook_url'][0] ) : esc_attr( 'https://' ); ?>"/>
                                </div><!-- /.rh_form__social -->
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="twitter-url"><?php esc_html_e( 'Twitter URL', 'framework' ); ?></label>
                                <div class="rh_form__social">
                                    <span class="fab fa-twitter fa-lg"></span>
                                    <input name="twitter-url" type="text" id="twitter-url" value="<?php echo ( isset( $current_user_meta['twitter_url'] ) ) ? esc_attr( $current_user_meta['twitter_url'][0] ) : esc_attr( 'https://' ); ?>"/>
                                </div><!-- /.rh_form__social -->
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="linkedin-url"><?php esc_html_e( 'LinkedIn URL', 'framework' ); ?></label>
                                <div class="rh_form__social">
                                    <span class="fab fa-linkedin fa-lg"></span>
                                    <input name="linkedin-url" type="text" id="linkedin-url" value="<?php echo ( isset( $current_user_meta['linkedin_url'] ) ) ? esc_attr( $current_user_meta['linkedin_url'][0] ) : esc_attr( 'https://' ); ?>"/>
                                </div><!-- /.rh_form__social -->
                            </div><!-- /.rh_form__item rh_form--columnAlign -->

                            <div class="rh_form__item rh_form--3-column rh_form--columnAlign">
                                <label for="instagram-url"><?php esc_html_e( 'Instagram URL', 'framework' ); ?></label>
                                <div class="rh_form__social">
                                    <span class="fab fa-instagram fa-lg"></span>
                                    <input name="instagram-url" type="text" id="instagram-url" value="<?php echo empty( $current_user_meta['instagram_url'] ) ? '' : esc_attr( $current_user_meta['instagram_url'][0] ); ?>"/>
                                </div><!-- /.rh_form__social -->
                            </div><!-- /.rh_form__item rh_form--columnAlign -->
                        </div><!-- /.rh_form__row -->

                        <div class="rh_form__row">
							<?php
							// Action hook for plugin and extra fields.
							// do_action( 'edit_user_profile', $current_user );
							// WordPress Nonce for Security Check.
							wp_nonce_field( 'update_user', 'user_profile_nonce' );
							?>
                            <input type="hidden" name="action" value="inspiry_update_profile"/>
                        </div><!-- /.rh_form__row -->

                        <div class="rh_form__row">
                            <div class="rh_form__item rh_form__submit rh_form--3-column">
                                <input name="update-user" type="submit" id="update-user" class="rh_btn rh_btn--primary" value="<?php esc_attr_e( 'Save Changes', 'framework' ); ?>"/>
                                <span id="form-loader">
									<?php inspiry_safe_include_svg( '/images/loader.svg' ); ?>
								</span>
                            </div><!-- /.rh_form__form -->
                        </div><!-- /.rh_form__row -->

                        <div class="rh_form__row rh_form--columnAlign">
                            <p id="form-message"></p>
                            <ul id="form-errors"></ul>
                        </div><!-- /.rh_form__row -->
                    </form>
                </div><!-- /.rh_form -->
				<?php
			}
			?>
        </div><!-- /.rh_page -->
    </section><!-- /.rh_section rh_wrap rh_wrap--padding -->
<?php
get_footer();
