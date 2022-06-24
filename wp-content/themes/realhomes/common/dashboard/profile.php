 <?php
$current_user      = wp_get_current_user();
$author_data       = get_userdata( $current_user->ID );
$current_user_meta = get_user_meta( $current_user->ID );

do_action( 'inspiry_before_edit_profile_page_render', get_the_ID() );
?>
<div id="profile-form-message" class="dashboard-message dashboard-notice"></div>
<div id="dashboard-user-profile" class="dashboard-user-profile">
    <form id="inspiry-edit-user" enctype="multipart/form-data">
        <div class="dashboard-user-profile-inner">
            <div class="profile-image-upload-container">
                <div id="profile-image" class="profile-image">
                    <?php
                    if ( isset( $current_user_meta['profile_image_id'] ) && ! empty( $current_user_meta['profile_image_id'][0] ) ) {
	                    $profile_image_id = intval( $current_user_meta['profile_image_id'][0] );
	                    echo wp_get_attachment_image( $profile_image_id, 'agent-image' );
	                    echo '<input type="hidden" class="profile-image-id" name="profile-image-id" value="' . esc_attr( $profile_image_id ) . '"/>';
                    }
                    ?>
                </div>
                <div class="profile-image-controls">
                    <button id="select-profile-image" class="btn btn-primary"><?php esc_html_e( 'Upload New Picture', 'framework' ); ?></button>
                    <button id="remove-profile-image" class="btn btn-alt"><?php esc_html_e( 'Delete', 'framework' ); ?></button>
                    <p class="description">
                        <?php esc_html_e( '* Minimum required size is 210px by 210px.', 'framework' ); ?>
                        <br>
                        <?php esc_html_e( '* Make sure to Save Changes after uploading fresh image.', 'framework' ); ?>
						<br>
						<?php
						$avatar_fallback = get_option( 'inspiry_user_sync_avatar_fallback', 'true' );
						if ( 'true' === $avatar_fallback && ! empty( $current_user_meta['inspiry_role_post_id'] ) ) {
							esc_html_e( '* Gravatar image will be displayed if no profile image is provided.', 'framework' );
						}
						?>
                    </p>
                    <div id="errors-log" class="errors-log"></div>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-3">
                        <p>
                            <label for="first-name"><?php esc_html_e( 'First Name', 'framework' ); ?></label>
                            <input name="first-name" type="text" id="first-name" placeholder="<?php esc_attr_e( 'Enter your first name', 'framework' ); ?>"
                                   value="<?php if ( isset( $current_user_meta['first_name'] ) ) {
								       echo esc_attr( $current_user_meta['first_name'][0] );
							       } ?>" autofocus/>
                        </p>
                    </div>
                    <div class="col-lg-3">
                        <p>
                            <label for="last-name"><?php esc_html_e( 'Last Name', 'framework' ); ?></label>
                            <input name="last-name" type="text" id="last-name" placeholder="<?php esc_attr_e( 'Enter your last name', 'framework' ); ?>"
                                   value="<?php if ( isset( $current_user_meta['last_name'] ) ) {
								       echo esc_attr( $current_user_meta['last_name'][0] );
							       } ?>"/>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="display-name"><?php esc_html_e( 'Display Name', 'framework' ); ?> *</label>
                            <input class="required" name="display-name" type="text" id="display-name" placeholder="<?php esc_attr_e( 'Enter your display name', 'framework' ); ?>"
                                   value="<?php echo esc_attr( $current_user->display_name ); ?>"/>
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <label for="email"><?php esc_html_e( 'Email', 'framework' ); ?> *</label>
                            <input class="required" name="email" type="email" id="email" placeholder="<?php esc_attr_e( 'Enter your email address', 'framework' ); ?>" value="<?php echo esc_attr( $current_user->user_email ); ?>"/>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="mobile-number"><?php esc_html_e( 'Mobile Number', 'framework' ); ?></label>
                            <input name="mobile-number" type="text" id="mobile-number"
                                   value="<?php if ( isset( $current_user_meta['mobile_number'] ) ) {
				                       echo esc_attr( $current_user_meta['mobile_number'][0] );
			                       } ?>"/>
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <label for="office-number"><?php esc_html_e( 'Office Number', 'framework' ); ?></label>
                            <input name="office-number" type="text" id="office-number"
                                   value="<?php if ( isset( $current_user_meta['office_number'] ) ) {
						               echo esc_attr( $current_user_meta['office_number'][0] );
					               } ?>"/>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="fax-number"><?php esc_html_e( 'Fax Number', 'framework' ); ?></label>
                            <input name="fax-number" type="text" id="fax-number"
                                   value="<?php if ( isset( $current_user_meta['fax_number'] ) ) {
						               echo esc_attr( $current_user_meta['fax_number'][0] );
					               } ?>"/>
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <label for="description"><?php esc_html_e( 'Biographical Information', 'framework' ) ?></label>
                            <textarea name="description" id="description" rows="5" cols="30"><?php
						        if ( isset( $current_user_meta['description'] ) ) {
							        echo esc_textarea( $current_user_meta['description'][0] );
						        }
						        ?></textarea>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="inspiry_user_address"><?php esc_html_e( 'Address', 'framework' ) ?></label>
                            <textarea name="inspiry_user_address" id="inspiry_user_address" rows="5" cols="30"><?php
						        if ( isset( $current_user_meta['inspiry_user_address'] ) ) {
							        echo esc_textarea( $current_user_meta['inspiry_user_address'][0] );
						        }
						        ?></textarea>
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <label for="inspiry_user_agency"><?php esc_html_e( 'Agency', 'framework' ); ?></label>
                            <select name="inspiry_user_agency" id="inspiry_user_agency" class="inspiry_select_picker_trigger show-tick">
								<?php if ( isset( $current_user_meta['inspiry_user_agency'] ) ) {
									inspiry_dropdown_posts( 'agency', $current_user_meta['inspiry_user_agency'][0], true );
								} else {
									inspiry_dropdown_posts( 'agency', - 1, true );
								} ?>
                            </select>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="url"><?php esc_html_e( 'Website', 'framework' ); ?></label>
                            <span class="input-group">
                            <i class="fas fa-globe fa-lg"></i>
                            <input name="url" type="text" id="url" value="<?php echo ( isset( $author_data->user_url ) ) ? esc_url( $author_data->user_url ) : esc_attr( 'https://' ); ?>"/>
                        </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <label for="facebook-url"><?php esc_html_e( 'Facebook URL', 'framework' ); ?></label>
                            <span class="input-group">
                            <i class="fab fa-facebook fa-lg"></i>
                            <input name="facebook-url" type="text" id="facebook-url" value="<?php echo ( isset( $current_user_meta['facebook_url'] ) ) ? esc_attr( $current_user_meta['facebook_url'][0] ) : ''; ?>" placeholder="<?php echo esc_attr( 'https://' ); ?>"/>
                        </span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="twitter-url"><?php esc_html_e( 'Twitter URL', 'framework' ); ?></label>
                            <span class="input-group">
                            <i class="fab fa-twitter fa-lg"></i>
                            <input name="twitter-url" type="text" id="twitter-url" value="<?php echo ( isset( $current_user_meta['twitter_url'] ) ) ? esc_attr( $current_user_meta['twitter_url'][0] ) : ''; ?>" placeholder="<?php echo esc_attr( 'https://' ); ?>"/>
                        </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <label for="linkedin-url"><?php esc_html_e( 'LinkedIn URL', 'framework' ); ?></label>
                            <span class="input-group">
                            <i class="fab fa-linkedin fa-lg"></i>
                            <input name="linkedin-url" type="text" id="linkedin-url" value="<?php echo ( isset( $current_user_meta['linkedin_url'] ) ) ? esc_attr( $current_user_meta['linkedin_url'][0] ) : ''; ?>" placeholder="<?php echo esc_attr( 'https://' ); ?>"/>
                        </span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="instagram-url"><?php esc_html_e( 'Instagram URL', 'framework' ); ?></label>
                            <span class="input-group">
                            <i class="fab fa-instagram fa-lg"></i>
                            <input name="instagram-url" type="text" id="instagram-url" value="<?php echo ( isset( $current_user_meta['instagram_url'] ) ) ? esc_attr( $current_user_meta['instagram_url'][0] ) : ''; ?>" placeholder="<?php echo esc_attr( 'https://' ); ?>"/>
                        </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <label for="pinterest-url"><?php esc_html_e( 'Pinterest URL', 'framework' ); ?></label>
                            <span class="input-group">
                            <i class="fab fa-pinterest fa-lg"></i>
                            <input name="pinterest-url" type="text" id="pinterest-url" value="<?php echo ( isset( $current_user_meta['pinterest_url'] ) ) ? esc_attr( $current_user_meta['pinterest_url'][0] ) : ''; ?>" placeholder="<?php echo esc_attr( 'https://' ); ?>"/>
                        </span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="youtube-url"><?php esc_html_e( 'YouTube URL', 'framework' ); ?></label>
                            <span class="input-group">
                            <i class="fab fa-youtube fa-lg"></i>
                            <input name="youtube-url" type="text" id="youtube-url" value="<?php echo ( isset( $current_user_meta['youtube_url'] ) ) ? esc_attr( $current_user_meta['youtube_url'][0] ) : ''; ?>" placeholder="<?php echo esc_attr( 'https://' ); ?>"/>
                        </span>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                        <p>
                            <label for="whatsapp-number"><?php esc_html_e( 'WhatsApp Number', 'framework' ); ?></label>
                            <span class="input-group">
                            <i class="fab fa-whatsapp fa-lg"></i>
                            <input name="whatsapp-number" type="number" id="whatsapp-number" value="<?php echo ( isset( $current_user_meta['whatsapp_number'] ) ) ? esc_attr( $current_user_meta['whatsapp_number'][0] ) : ''; ?>"/>
                        </span>
                        </p>
                </div>
            </div>

            <div class="form-fields">
                <div class="row">
                    <div class="col-lg-6">
                        <p>
                            <label for="pass1"><?php esc_html_e( 'Password', 'framework' ); ?></label>
                            <input name="pass1" type="password" id="pass1"/>
                            <span class="note"><?php esc_html_e( 'Note: Fill it only if you want to change your password', 'framework' ); ?></span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            <label for="pass2"><?php esc_html_e( 'Confirm Password', 'framework' ); ?></label>
                            <input name="pass2" type="password" id="pass2"/>
                        </p>
                    </div>
                </div>
            </div>

			<?php
            // Collect custom user registration fields
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
				'pinterest-url',
				'youtube-url',
				'whatsapp-number',
				'pass1',
				'pass2',
			);

			$fields_list = array();
			$user_fields = apply_filters( 'inspiry_additional_user_fields', array() );

			if ( is_array( $user_fields ) && ! empty( $user_fields ) ) : ?>
                <div class="form-fields">
                    <div class="row">
						<?php
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
                                <div class="col-lg-6">
                                    <p>
                                        <label for="<?php echo esc_attr( $field['id'] ); ?>">
											<?php
											echo esc_html( $field['name'] );
											echo ( true === $required ) ? ' *' : '';
											?>
                                        </label>
										<?php
										if ( ! empty( $field['type'] ) && $field['type'] == 'select' && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
											?>
                                            <select name="<?php echo esc_attr( $field['id'] ); ?>"
                                                    id="<?php echo esc_attr( $field['id'] ); ?>"
												<?php
												echo ( ! empty( $field['title'] ) ) ? ' title="' . esc_attr( $field['title'] ) . '"' : '';
												echo ( true === $required ) ? ' class="inspiry_select_picker_trigger required" required' : ' class="inspiry_select_picker_trigger" ';
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
												echo ( ! empty( $field['title'] ) ) ? ' title="' . esc_attr( $field['title'] ) . '"' : '';
												echo ( true === $required ) ? ' class="required" required' : '';
												?>/>
										<?php } ?>
                                    </p>
                                </div>
								<?php
							}
						}
						?>
                    </div>
                </div>
			<?php endif; ?>
        </div><!-- .dashboard-user-profile-inner -->
        <div class="submit dashboard-form-actions">
			<?php
			// Action hook for plugin and extra fields.
            // do_action( 'edit_user_profile', $current_user );

			// WordPress Nonce for Security Check.
			wp_nonce_field( 'update_user', 'user_profile_nonce' );
			?>
            <input type="hidden" name="action" value="inspiry_update_profile"/>
            <input name="update-user" type="submit" id="update-user" class="btn btn-primary" value="<?php esc_attr_e( 'Save Changes', 'framework' ); ?>"/>
            <span id="profile-form-loader" class="dashboard-form-loader"><?php inspiry_safe_include_svg( '/images/loader.svg' ); ?></span>
        </div>
    </form>
</div><!-- #dashboard-user-profile -->