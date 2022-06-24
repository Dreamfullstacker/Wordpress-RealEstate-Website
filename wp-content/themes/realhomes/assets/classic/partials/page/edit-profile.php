<?php
/**
 * Display edit profile template related stuff
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();

// Page Head.
get_template_part( 'assets/classic/partials/banners/default' );
?>
<!-- Content -->
<div class="container contents single">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
    <div class="row">
        <div class="span12 main-wrap">

            <!-- Main Content -->
            <div class="main">
                <div class="inner-wrapper">
					<?php
					/* Page contents */
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php the_content(); ?>
                            </article>
						<?php
						endwhile;
					endif;


					/* Stuff related to property submit or property edit */
					if ( is_user_logged_in() ) {

						// Get user information.
						$current_user      = wp_get_current_user();
						$authordata        = get_userdata( $current_user->ID );
						$current_user_meta = get_user_meta( $current_user->ID );

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

									$fields_list[] = $field;
								}
							}
						}

						$len          = count( $fields_list );
						$left_fields  = array_slice( $fields_list, 0, $len / 2 );
						$right_fields = array_slice( $fields_list, $len / 2 );
						?>
                        <form id="inspiry-edit-user" enctype="multipart/form-data" class="submit-form">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="form-option user-profile-img-wrapper clearfix">
                                        <div id="user-profile-img">
                                            <div class="profile-thumb">
						                        <?php
						                        if ( isset( $current_user_meta['profile_image_id'] ) ) {
							                        $profile_image_id = intval( $current_user_meta['profile_image_id'][0] );
							                        if ( $profile_image_id ) {
								                        echo wp_get_attachment_image( $profile_image_id, 'agent-image' );
								                        echo '<input type="hidden" class="profile-image-id" name="profile-image-id" value="' . $profile_image_id . '"/>';
							                        }
						                        }
						                        ?>
                                            </div>
                                        </div><!-- end of user profile image -->

                                        <div class="profile-img-controls">
                                            <a id="select-profile-image" class="real-btn" href="javascript:;"><?php esc_html_e( 'Change', 'framework' ); ?>
                                                <i class="far fa-image"></i></a><br/>
                                            <a id="remove-profile-image" class="real-btn" href="#remove-profile-image"><?php esc_html_e( 'Remove', 'framework' ); ?>
                                                <i class="far fa-trash-alt"></i></a>

                                            <ul class="field-description">
                                                <li><?php esc_html_e( 'Profile image should have minimum width of 210px and minimum height of 210px.', 'framework' ); ?>
                                                    <br/></li>
                                                <li><?php esc_html_e( 'Make sure to save changes after changing the image.', 'framework' ); ?></li>
                                            </ul>

                                            <div id="errors-log"></div>
                                        </div><!-- end of profile image controls -->
                                    </div><!-- end of user-profile-img-wrapper wrapper -->
                                </div><!-- end of span6 -->
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="first-name"><?php esc_html_e( 'First Name', 'framework' ); ?></label>
                                        <input name="first-name" type="text" id="first-name" value="<?php
				                        if ( isset( $current_user_meta['first_name'] ) ) {
					                        echo esc_attr( $current_user_meta['first_name'][0] );
				                        } ?>" autofocus/>
                                    </div>
                                    <div class="form-option">
                                        <label for="last-name"><?php esc_html_e( 'Last Name', 'framework' ); ?></label>
                                        <input name="last-name" type="text" id="last-name" value="<?php
				                        if ( isset( $current_user_meta['last_name'] ) ) {
					                        echo esc_attr( $current_user_meta['last_name'][0] );
				                        } ?>"/>
                                    </div>
                                    <div class="form-option">
                                        <label for="display-name"><?php esc_html_e( 'Display Name', 'framework' ); ?>
                                            *</label>
                                        <input class="required" name="display-name" type="text" id="display-name" value="<?php echo esc_attr( $current_user->display_name ); ?>" required/>
                                    </div>
                                </div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="email"><?php esc_html_e( 'Email', 'framework' ); ?> *</label>
                                        <input class="required" name="email" type="email" id="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" required/>
                                    </div>
                                </div><!-- end of span6 -->
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="mobile-number"><?php esc_html_e( 'Mobile Number', 'framework' ); ?></label>
                                        <input name="mobile-number" type="text" id="mobile-number" value="<?php
				                        if ( isset( $current_user_meta['mobile_number'] ) ) {
					                        echo esc_attr( $current_user_meta['mobile_number'][0] );
				                        } ?>"/>
                                    </div>
                                </div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="office-number"><?php esc_html_e( 'Office Number', 'framework' ); ?></label>
                                        <input name="office-number" type="text" id="office-number" value="<?php
		                                if ( isset( $current_user_meta['office_number'] ) ) {
			                                echo esc_attr( $current_user_meta['office_number'][0] );
		                                } ?>"/>
                                    </div>
                                </div><!-- end of span6 -->
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="fax-number"><?php esc_html_e( 'Fax Number', 'framework' ); ?></label>
                                        <input name="fax-number" type="text" id="fax-number" value="<?php
		                                if ( isset( $current_user_meta['fax_number'] ) ) {
			                                echo esc_attr( $current_user_meta['fax_number'][0] );
		                                } ?>"/>
                                    </div>
                                </div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="description"><?php esc_html_e( 'Biographical Information', 'framework' ); ?></label>
                                        <textarea name="description" id="description" rows="5" cols="30"><?php
					                        if ( isset( $current_user_meta['description'] ) ) {
						                        echo esc_textarea( $current_user_meta['description'][0] );
					                        } ?></textarea>
                                    </div>
                                </div><!-- end of span6 -->
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="inspiry_user_address"><?php esc_html_e( 'Address', 'framework' ); ?></label>
                                        <textarea name="inspiry_user_address" id="inspiry_user_address" rows="5" cols="30"><?php
					                        if ( isset( $current_user_meta['inspiry_user_address'] ) ) {
						                        echo esc_textarea( $current_user_meta['inspiry_user_address'][0] );
					                        } ?></textarea>
                                    </div>
                                </div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="inspiry_user_agency"><?php esc_html_e( 'Agency', 'framework' ); ?></label>
                                        <select name="inspiry_user_agency" id="inspiry_user_agency" class="inspiry_select_picker_trigger show-tick">
			                                <?php
			                                if ( isset( $current_user_meta['inspiry_user_agency'] ) ) {
				                                inspiry_dropdown_posts( 'agency', $current_user_meta['inspiry_user_agency'][0], true );
			                                } else {
				                                inspiry_dropdown_posts( 'agency', - 1, true );
			                                }
			                                ?>
                                        </select>
                                    </div>
                                </div><!-- end of span6 -->
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="url"><?php esc_html_e( 'Website', 'framework' ); ?></label>
                                        <input name="url" type="text" id="url" value="<?php echo esc_url( $authordata->user_url ); ?>"/>
                                    </div>
                                </div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="facebook-url"><?php esc_html_e( 'Facebook URL', 'framework' ); ?></label>
                                        <input name="facebook-url" type="text" id="facebook-url" value="<?php
		                                if ( isset( $current_user_meta['facebook_url'] ) ) {
			                                echo esc_attr( $current_user_meta['facebook_url'][0] );
		                                } ?>"/>
                                    </div>
                                </div><!-- end of span6 -->
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="twitter-url"><?php esc_html_e( 'Twitter URL', 'framework' ); ?></label>
                                        <input name="twitter-url" type="text" id="twitter-url" value="<?php
				                        if ( isset( $current_user_meta['twitter_url'] ) ) {
					                        echo esc_attr( $current_user_meta['twitter_url'][0] );
				                        } ?>"/>
                                    </div>
                                </div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="linkedin-url"><?php esc_html_e( 'LinkedIn URL', 'framework' ); ?></label>
                                        <input name="linkedin-url" type="text" id="linkedin-url" value="<?php
		                                if ( isset( $current_user_meta['linkedin_url'] ) ) {
			                                echo esc_attr( $current_user_meta['linkedin_url'][0] );
		                                } ?>"/>
                                    </div>
                                </div><!-- end of span6 -->
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="instagram-url"><?php esc_html_e( 'Instagram URL', 'framework' ); ?></label>
                                        <input name="instagram-url" type="text" id="instagram-url" value="<?php
				                        if ( isset( $current_user_meta['instagram_url'] ) ) {
					                        echo esc_attr( $current_user_meta['instagram_url'][0] );
				                        } ?>"/>
                                    </div>
                                </div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="pass1"><?php esc_html_e( 'Password', 'framework' ); ?>
                                            <small>
                                                ( <?php esc_html_e( 'Fill it only if you want to change your password', 'framework' ); ?>
                                                )
                                            </small>
                                        </label>
                                        <input name="pass1" type="password" id="pass1"/>
                                    </div>
                                </div><!-- end of span6 -->
                                <div class="span6">
                                    <div class="form-option">
                                        <label for="pass2"><?php esc_html_e( 'Confirm Password', 'framework' ); ?></label>
                                        <input name="pass2" type="password" id="pass2"/>
                                    </div>
                                </div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid edit-user-profile-form-custom-fields">
                                <div class="span6"><?php
			                        /**
			                         * Render custom user registration fields (top half)
			                         */
			                        foreach ( $left_fields as $field ) {
				                        $required = false;
				                        if ( ! empty( $field['required'] ) && $field['required'] === true ) {
					                        $required = true;
				                        }
				                        ?>
                                        <div class="form-option">
                                            <label for="<?php echo esc_attr( $field['id'] ); ?>">
						                        <?php
						                        echo esc_html( $field['name'] );
						                        echo ( true === $required ) ? ' *' : '';
						                        ?>
                                            </label>
					                        <?php
					                        if ( ! empty( $field['type'] ) && $field['type'] == 'select' && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
						                        ?>
                                                <span class="selectwrap">
                                                    <select name="<?php echo esc_attr( $field['id'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>"
                                                    <?php
                                                    echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
                                                    echo ( true === $required ) ? 'class="required inspiry_select_picker_trigger show-tick" required' : 'class="inspiry_select_picker_trigger show-tick"';
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
                                                </span>
						                        <?php
					                        } else {
						                        ?>
                                                <input
                                                        type="text"
                                                        id="<?php echo esc_attr( $field['id'] ); ?>"
                                                        name="<?php echo esc_attr( $field['id'] ); ?>"
                                                        value="<?php
								                        if ( isset( $current_user_meta[ esc_attr( $field['id'] ) ] ) ) {
									                        echo esc_attr( $current_user_meta[ $field['id'] ][0] );
								                        } ?>"
							                        <?php
							                        echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
							                        echo ( true === $required ) ? 'class="required" required' : '';
							                        ?>/>
					                        <?php } ?>
                                        </div>
				                        <?php
			                        }
			                        ?></div><!-- end of span6 -->
                                <div class="span6"><?php
			                        /**
			                         * Render custom user registration fields (bottom half)
			                         */
			                        foreach ( $right_fields as $field ) {
				                        $required = false;
				                        if ( ! empty( $field['required'] ) && $field['required'] === true ) {
					                        $required = true;
				                        }
				                        ?>
                                        <div class="form-option">
                                            <label for="<?php echo esc_attr( $field['id'] ); ?>">
						                        <?php echo esc_html( $field['name'] ); ?>
						                        <?php echo ( true === $required ) ? '*' : ''; ?>
                                            </label>
					                        <?php
					                        if ( ! empty( $field['type'] ) && $field['type'] == 'select' && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
						                        ?>
                                                <span class="selectwrap">
                                                    <select name="<?php echo esc_attr( $field['id'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>"
                                                    <?php
                                                    echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
                                                    echo ( true === $required ) ? 'class="required inspiry_select_picker_trigger show-tick" required' : 'class="inspiry_select_picker_trigger show-tick"';
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
                                                </span>
						                        <?php
					                        } else {
						                        ?>
                                                <input
                                                        type="text"
                                                        id="<?php echo esc_attr( $field['id'] ); ?>"
                                                        name="<?php echo esc_attr( $field['id'] ); ?>"
                                                        value="<?php
								                        if ( isset( $current_user_meta[ esc_attr( $field['id'] ) ] ) ) {
									                        echo esc_attr( $current_user_meta[ $field['id'] ][0] );
								                        } ?>"
							                        <?php
							                        echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
							                        echo ( true === $required ) ? 'class="required" required' : '';
							                        ?>/>
					                        <?php } ?>
                                        </div>
				                        <?php
			                        }
			                        ?></div><!-- end of span6 -->
                            </div>

                            <div class="row-fluid">
                                <div class="span12">
                                    <?php
                                    // Action hook for plugin and extra fields.
                                    // do_action( 'edit_user_profile', $current_user );
                                    // WordPress Nonce for Security Check.
                                    wp_nonce_field( 'update_user', 'user_profile_nonce' );
                                    ?>
                                    <input type="hidden" name="action" value="inspiry_update_profile"/>
                                    <div class="form-option">
                                        <input name="update-user" type="submit" id="update-user" class="real-btn" value="<?php esc_attr_e( 'Save Changes', 'framework' ); ?>"/>
                                        <img src="<?php echo esc_attr( INSPIRY_DIR_URI ); ?>/images/ajax-loader.gif" id="form-loader" alt="<?php esc_attr_e( 'Loading...', 'framework' ); ?>">
                                    </div>
                                    <p id="form-message"></p>
                                    <ul id="form-errors"></ul>
                                </div><!-- end of span6 -->
                            </div>
                        </form><!-- #adduser -->
						<?php

						/**
						 * `inspiry_extend_user_profile`
						 *
						 * This hook is used to extend the profile page of RealHomes.
						 * Membership module is no longer added to this hook.
						 *
						 * @param object $current_user This parameter contains the current user object.
						 *
						 * @since 2.6.4
						 */
						do_action( 'inspiry_extend_user_profile', $current_user );

					} else {
						alert( esc_html__( 'Login Required:', 'framework' ), esc_html__( 'Please login to edit your profile information!', 'framework' ) );
					}
					?>
                </div>
            </div><!-- End Main Content -->
        </div><!-- End span12 -->
    </div><!-- End contents row -->
</div><!-- End Content -->
<?php get_footer(); ?>