<?php
/**
 * This file contains functions related to Login, Register and Forgot Password Features
 */
if ( ! function_exists( 'inspiry_is_user_restricted' ) ) :
	/**
	 * Checks if current user is restricted or not
	 *
	 * @return bool
	 */
	function inspiry_is_user_restricted() {
		$current_user = wp_get_current_user();

		// get restricted level from theme options
		$restricted_level = get_option( 'theme_restricted_level' );
		if ( ! empty( $restricted_level ) ) {
			$restricted_level = intval( $restricted_level );
		} else {
			$restricted_level = 0;
		}

		// Redirects user below a certain user level to home url
		// Ref: https://codex.wordpress.org/Roles_and_Capabilities#User_Level_to_Role_Conversion
		if ( $current_user->user_level <= $restricted_level ) {
			return true;
		}

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_restrict_admin_access' ) ) :
	/**
	 * Restrict user access to admin if his level is equal or below restricted level
	 * Or request is an AJAX request or delete request from my properties page
	 */
	function inspiry_restrict_admin_access() {

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			// let it go
		} else if ( isset( $_GET['action'] ) && ( $_GET['action'] == 'delete' ) ) {
			// let it go as it is from my properties delete button
		} else {
			if ( inspiry_is_user_restricted() ) {
				wp_redirect( esc_url_raw( home_url( '/' ) ) );
				exit;
			}
		}

	}

	add_action( 'admin_init', 'inspiry_restrict_admin_access' );
endif;

if ( ! function_exists( 'inspiry_ajax_login' ) ) :
	/**
	 * AJAX login request handler
	 */
	function inspiry_ajax_login() {

		// First check the nonce, if it fails the function will break.
		check_ajax_referer( 'inspiry-ajax-login-nonce', 'inspiry-secure-login' );

		if ( class_exists( 'Easy_Real_Estate' ) ) {
			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();
		}

		// Nonce is checked, get the POST data and sign user on.
		inspiry_auth_user_login( $_POST['log'], $_POST['pwd'], esc_html__( 'Login', 'framework' ) );

		die();
	}

	// Enable the user with no privileges to request ajax login.
	add_action( 'wp_ajax_nopriv_inspiry_ajax_login', 'inspiry_ajax_login' );

endif;

if ( ! function_exists( 'inspiry_auth_user_login' ) ) :
	/**
	 * This function process login request and displays JSON response
	 *
	 * @param $user_login
	 * @param $password
	 * @param $login
	 */
	function inspiry_auth_user_login( $user_login, $password, $login ) {

		$info                  = array();
		$info['user_login']    = $user_login;
		$info['user_password'] = $password;
		$info['remember']      = true;

		$user_signon = wp_signon( $info, true );

		if ( is_wp_error( $user_signon ) ) {
			echo json_encode( array(
				'success' => false,
				'message' => esc_html__( '* Wrong username or password.', 'framework' ),
			) );
		} else {
			wp_set_current_user( $user_signon->ID );
			echo json_encode( array(
				'success'  => true,
				'message'  => $login . ' ' . esc_html__( 'successful. Redirecting...', 'framework' ),
				'redirect' => $_POST['redirect_to']
			) );
		}

		die();
	}
endif;

if ( ! function_exists( 'inspiry_ajax_register' ) ) :
	/**
	 * AJAX register request handler
	 */
	function inspiry_ajax_register() {

		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'inspiry-ajax-register-nonce', 'inspiry-secure-register' );

		if ( class_exists( 'Easy_Real_Estate' ) ) {
			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();
		}

		// Nonce is checked, Get to work
		$info                  = array();
		$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user( $_POST['register_username'] );
		$info['user_pass']     = wp_generate_password( 12 );
		$info['user_email']    = sanitize_email( $_POST['register_email'] );

		if ( inspiry_is_user_sync_enabled() && empty( $_POST['user_role'] ) ) {
			echo json_encode( array(
				'success' => false,
				'message' => esc_html__( 'Please select a user role.', 'framework' ),
			) );
			die();
		}

		// Register the user
		$user_register = wp_insert_user( $info );

		if ( is_wp_error( $user_register ) ) {

			$error = $user_register->get_error_codes();
			if ( in_array( 'empty_user_login', $error ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => $user_register->get_error_message( 'empty_user_login' )
				) );
			} elseif ( in_array( 'existing_user_login', $error ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'This username already exists.', 'framework' )
				) );
			} elseif ( in_array( 'existing_user_email', $error ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => esc_html__( 'This email is already registered.', 'framework' )
				) );
			} else {
				echo json_encode( array(
					'success' => false,
					'message' => $user_register->get_error_message()
				) );
			}

		} else {

			/**
			 * Add user meta for the custom user fields if values are set for them.
			 */
			$user_fields = apply_filters( 'inspiry_additional_user_fields', array() );
			if ( is_array( $user_fields ) && ! empty( $user_fields ) ) {
				foreach ( $user_fields as $field ) {

					// Check if field is enabled for the Register Form
					if ( empty( $field['show'] ) || ! is_array( $field['show'] ) || ! in_array( 'register_form', $field['show'] ) ) {
						continue;
					}

					// Validate field data and add it as user meta
					if ( ! empty( $field['id'] ) && ! empty( $_POST[ $field['id'] ] ) ) {
						add_user_meta( $user_register, sanitize_key( $field['id'] ), sanitize_text_field( $_POST[ $field['id'] ] ) );
					}
				}
			}

			// User notification function exists in plugin
			if ( class_exists( 'Easy_Real_Estate' ) ) {
				// Send email notification to newly registered user and admin
				ere_new_user_notification( $user_register, $info['user_pass'] );
			}

			// Insert Role Post
			if ( inspiry_is_user_sync_enabled() ) {
				$role       = $_POST['user_role'];
				$user_roles = inspiry_user_sync_roles();

				if ( array_key_exists( $role, $user_roles ) ) {

					update_user_meta( $user_register, 'inspiry_user_role', $role );
					inspiry_insert_role_post( $user_register, $role );
				}
			}

			echo json_encode( array(
				'success' => true,
				'message' => esc_html__( 'Registration is complete. Check your email for details!', 'framework' ),
			) );

		}

		die();
	}

	// Enable the user with no privileges to request ajax register
	add_action( 'wp_ajax_nopriv_inspiry_ajax_register', 'inspiry_ajax_register' );

endif;

if ( ! function_exists( 'inspiry_get_edit_profile_url' ) ) :
	/**
	 * Get edit profile URL
	 */
	function inspiry_get_edit_profile_url() {

		/* Check edit profile page */
		$inspiry_edit_profile_page = get_option( 'inspiry_edit_profile_page' );
		if ( ! empty( $inspiry_edit_profile_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_edit_profile_page = apply_filters( 'wpml_object_id', $inspiry_edit_profile_page, 'page', true );

			return get_permalink( $inspiry_edit_profile_page );
		}

		/* Check edit profile page url which is deprecated and this code is to provide backward compatibility */
		$theme_profile_url = get_option( 'theme_profile_url' );
		if ( ! empty( $theme_profile_url ) ) {
			return $theme_profile_url;
		}

		/* Return false if all fails */

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_get_submit_property_url' ) ) :
	/**
	 * Get submit property page's URL
	 */
	function inspiry_get_submit_property_url() {

		/* Check submit property page */
		$inspiry_submit_property_page = get_option( 'inspiry_submit_property_page' );
		if ( ! empty( $inspiry_submit_property_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_submit_property_page = apply_filters( 'wpml_object_id', $inspiry_submit_property_page, 'page', true );

			return get_permalink( $inspiry_submit_property_page );
		}

		/* Check submit property page url which is deprecated and this code is to provide backward compatibility */
		$theme_submit_url = get_option( 'theme_submit_url' );
		if ( ! empty( $theme_submit_url ) ) {
			return $theme_submit_url;
		}

		/* Return false if all fails */

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_get_my_properties_url' ) ) :
	/**
	 * Get my properties page URL
	 */
	function inspiry_get_my_properties_url() {

		/* Check my properties page */
		$inspiry_my_properties_page = get_option( 'inspiry_my_properties_page' );
		if ( ! empty( $inspiry_my_properties_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_my_properties_page = apply_filters( 'wpml_object_id', $inspiry_my_properties_page, 'page', true );

			return get_permalink( $inspiry_my_properties_page );
		}

		/* Check my properties page url which is deprecated and this code is to provide backward compatibility */
		$theme_my_properties_url = get_option( 'theme_my_properties_url' );
		if ( ! empty( $theme_my_properties_url ) ) {
			return $theme_my_properties_url;
		}

		/* Return false if all fails */

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_get_favorites_url' ) ) :
	/**
	 * Get favorite properties page URL
	 */
	function inspiry_get_favorites_url() {

		/* Check favorite properties page */
		$inspiry_favorites_page = get_option( 'inspiry_favorites_page' );
		if ( ! empty( $inspiry_favorites_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_favorites_page = apply_filters( 'wpml_object_id', $inspiry_favorites_page, 'page', true );

			return get_permalink( $inspiry_favorites_page );
		}

		/* Check favorite properties page url which is deprecated and this code is to provide backward compatibility */
		$theme_favorites_url = get_option( 'theme_favorites_url' );
		if ( ! empty( $theme_favorites_url ) ) {
			return $theme_favorites_url;
		}

		/* Return false if all fails */

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_get_compare_url' ) ) :
	/**
	 * Get compare properties page URL
	 */
	function inspiry_get_compare_url() {

		/* Check compare properties page */
		$inspiry_compare_page = get_option( 'inspiry_compare_page' );
		if ( ! empty( $inspiry_compare_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_compare_page = apply_filters( 'wpml_object_id', $inspiry_compare_page, 'page', true );

			return get_permalink( $inspiry_compare_page );
		}

		/* Return false if all fails */

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_get_membership_url' ) ) :
	/**
	 * Get memberships page URL
	 */
	function inspiry_get_membership_url() {

		/* Check compare properties page */
		$inspiry_membership_page = get_option( 'inspiry_membership_page' );
		if ( ! empty( $inspiry_membership_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_membership_page = apply_filters( 'wpml_object_id', $inspiry_membership_page, 'page', true );

			return get_permalink( $inspiry_membership_page );
		}

		/* Return false if all fails */

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_get_login_register_url' ) ) :
	/**
	 * Get login and register page URL
	 */
	function inspiry_get_login_register_url() {

		/* Check login and register page */
		$inspiry_login_register_page = get_option( 'inspiry_login_register_page' );
		if ( ! empty( $inspiry_login_register_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_login_register_page = apply_filters( 'wpml_object_id', $inspiry_login_register_page, 'page', true );

			return get_permalink( $inspiry_login_register_page );
		}

		/* Check login and register page url which is deprecated and this code is to provide backward compatibility */
		$theme_login_url = get_option( 'theme_login_url' );
		if ( ! empty( $theme_login_url ) ) {
			return $theme_login_url;
		}

		/* Return false if all fails */

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_header_login_enabled' ) ) :
	/**
     * @deprecated
     * This function is deprecated as related setting was confusing and no longer required.
	 */
	function inspiry_header_login_enabled() {
		$inspiry_header_login = get_option( 'inspiry_header_login' );   // this settings is removed as it was confusing as per latest updates.
		if ( $inspiry_header_login == 'false' ) {
			return false;
		}
		return true;
	}
endif;

if ( ! function_exists( 'inspiry_social_login_links' ) ) :
	function inspiry_social_login_links( $provider_id, $provider_name, $authenticate_url ) {
		?>
        <a rel="nofollow" href="<?php echo esc_url( $authenticate_url ); ?>" data-provider="<?php echo esc_attr( $provider_id ); ?>" class="wp-social-login-provider wp-social-login-provider-<?php echo strtolower( $provider_id ); ?>">
			<?php
		    if ( strtolower( $provider_id ) == 'stackoverflow' ) {
				$provider_id = 'fab fa-stack-overflow';
			} elseif ( strtolower( $provider_id ) == 'vkontakte' ) {
				$provider_id = 'fab fa-vk';
			} elseif ( strtolower( $provider_id ) == 'twitchtv' ) {
				$provider_id = 'fab fa-twitch';
			} elseif ( strtolower( $provider_id ) == 'live' ) {
				$provider_id = 'fab fa-windows';
			}
			?>
            <span><i class="<?php echo esc_attr( strtolower( $provider_id ) ); ?>"></i> <?php echo esc_html( $provider_name ); ?></span>
        </a>
		<?php
	}

	add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'inspiry_social_login_links', 10, 3 );
endif;

if ( ! function_exists( 'inspiry_get_gravatar' ) ) {
	/**
	 * Gravatar Image WP Custom Function
	 *
	 * @param string $email user/author email address.
	 * @param string $size size of gravatar.
	 *
	 * @return string           gravatar image url
	 */
	function inspiry_get_gravatar( $email, $size ) {
		// Convert email into md5 hash and set image size to 200 px.
		$gravatar_url = 'https://www.gravatar.com/avatar/' . md5( $email ) . '?s=' . $size;

		return $gravatar_url;
	}
}

if ( ! function_exists( 'inspiry_is_user_sync_enabled' ) ) {
	/**
	 * Check if Users synchronisation is enabled with Agents and Agencies
	 *
	 * @return bool
	 */
	function inspiry_is_user_sync_enabled() {
		$user_sync = get_option( 'inspiry_user_sync', 'false' );
		if ( 'true' == $user_sync ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_user_sync_roles' ) ) {
	/**
	 * Return available user roles to be synced
	 * @return array
	 */
	function inspiry_user_sync_roles() {
		$user_sync_roles = array(
			'agent'  => esc_html__( 'Agent', 'framework' ),
			'agency' => esc_html__( 'Agency', 'framework' )
		);

		return $user_sync_roles;
	}
}

if ( ! function_exists( 'inspiry_insert_role_post' ) ) {
	/**
	 * Insert an Agent/Agency post based on defined role
	 *
	 * @param $user_id
	 * @param $role
	 */
	function inspiry_insert_role_post( $user_id, $role ) {

		remove_action( 'publish_agency', 'inspiry_insert_role_user', 10 );
		remove_action( 'publish_agent', 'inspiry_insert_role_user', 10 );

		$post_args = array(
			'post_title'  => ucfirst( get_the_author_meta( 'display_name', $user_id ) ),
			'post_type'   => $role,
			'post_status' => 'publish',
			'post_author' => $user_id,
		);
		$post_id   = wp_insert_post( $post_args );

		// set agent/agency email address.
		$email_address = get_the_author_meta( 'user_email', $user_id );
		update_post_meta( $post_id, 'REAL_HOMES_' . $role . '_email', $email_address );
		update_post_meta( $post_id, 'inspiry_post_term', 'update' );

		// assign featured image to agent/agency.
		$image_url = get_avatar_url( $user_id );

		if ( ! empty( $image_url ) ) {
			$image_name = get_the_author_meta( 'nickname', $user_id ) . '.png';
			$attach_id  = inspiry_insert_attachment( $post_id, $image_url, $image_name );
			set_post_thumbnail( $post_id, $attach_id );
		}

		// attach agent/agency to the user.
		update_user_meta( $user_id, 'inspiry_role_post_id', $post_id );
	}
}

if ( ! function_exists( 'inspiry_update_role_post' ) ) {
	/**
	 * Update agent/agency post meta information on attached user update
	 *
	 * @param int $user_id Current user ID.
	 */
	function inspiry_update_role_post( $user_id ) {

		remove_action( 'save_post', 'inspiry_update_role_user', 10 );
		remove_action( 'publish_agency', 'inspiry_insert_role_user', 10 );
		remove_action( 'publish_agent', 'inspiry_insert_role_user', 10 );

		// get agent id.
		$post_id = get_the_author_meta( 'inspiry_role_post_id', $user_id );

		if ( $post_id > 0 ) {

			$post_type = get_post_type( $post_id );
			$user_role = get_the_author_meta( 'inspiry_user_role', $user_id );

			if ( $post_type === $user_role ) {
				// get user information.
				$name             = get_the_author_meta( 'display_name', $user_id );
				$description      = get_the_author_meta( 'description', $user_id );
				$email_address    = get_the_author_meta( 'user_email', $user_id );
				$website_url      = get_the_author_meta( 'user_url', $user_id );
				$mobile_number    = get_the_author_meta( 'mobile_number', $user_id );
				$office_number    = get_the_author_meta( 'office_number', $user_id );
				$fax_number       = get_the_author_meta( 'fax_number', $user_id );
				$whatsapp_number  = get_the_author_meta( 'whatsapp_number', $user_id );
				$facebook_url     = get_the_author_meta( 'facebook_url', $user_id );
				$twitter_url      = get_the_author_meta( 'twitter_url', $user_id );
				$linkedin_url     = get_the_author_meta( 'linkedin_url', $user_id );
				$instagram_url    = get_the_author_meta( 'instagram_url', $user_id );
				$user_address     = get_the_author_meta( 'inspiry_user_address', $user_id );
				$profile_image_id = get_user_meta( $user_id, 'profile_image_id' );

				// set email.
				if ( ! empty( $email_address ) ) {
					update_post_meta( $post_id, 'REAL_HOMES_' . $user_role . '_email', $email_address );
				}

				// set numbers and address.
				update_post_meta( $post_id, 'REAL_HOMES_mobile_number', $mobile_number );
				update_post_meta( $post_id, 'REAL_HOMES_whatsapp_number', $whatsapp_number );
				update_post_meta( $post_id, 'REAL_HOMES_office_number', $office_number );
				update_post_meta( $post_id, 'REAL_HOMES_fax_number', $fax_number );
				update_post_meta( $post_id, 'REAL_HOMES_address', $user_address );

				// set social urls.
				update_post_meta( $post_id, 'REAL_HOMES_website', $website_url );
				update_post_meta( $post_id, 'REAL_HOMES_facebook_url', $facebook_url );
				update_post_meta( $post_id, 'REAL_HOMES_twitter_url', $twitter_url );
				update_post_meta( $post_id, 'REAL_HOMES_linked_in_url', $linkedin_url );
				update_post_meta( $post_id, 'inspiry_instagram_url', $instagram_url );

				// assign featured image to agent/agency.
				$avatar_fallback = get_option( 'inspiry_user_sync_avatar_fallback', 'true' );

				if ( ! empty( $profile_image_id ) && is_array( $profile_image_id ) ) {
					$profile_image_id = intval( $profile_image_id[0] );
				} elseif ( 'true' === $avatar_fallback ) {
					$image_url        = get_avatar_url( $user_id, array( 'size' => '128' ) );
					$image_name       = get_the_author_meta( 'nickname', $user_id ) . '.png';
					$profile_image_id = inspiry_insert_attachment( $post_id, $image_url, $image_name );
					update_user_meta( $user_id, 'profile_image_id', $profile_image_id );
				}

				if ( $profile_image_id ) {
					set_post_thumbnail( $post_id, $profile_image_id );
				}

				// update role post title & content.
				$edited_post = array(
					'ID'           => $post_id,
					'post_title'   => $name,
					'post_content' => $description,
				);
				wp_update_post( $edited_post );
			}
		}
	}

	if ( inspiry_is_user_sync_enabled() ) {
		add_action( 'profile_update', 'inspiry_update_role_post', 10 );
		add_action( 'edit_user_profile_update', 'inspiry_update_role_post' );
	}
}

if ( ! function_exists( 'inspiry_insert_role_user' ) ) {
	/**
	 * Create user on Agent/Agency post insertion
	 *
	 * @param $post_id
	 * @param $post
	 */
	function inspiry_insert_role_user( $post_id, $post ) {

		$post_term = get_post_meta( $post_id, 'inspiry_post_term', true );

		if ( 'update' === $post_term ) {
			return;
		}

		$post_id   = intval( $post_id );
		$user_pass = wp_generate_password( 12 );

		$user_data = array(
			'user_login'   => $post->post_name,
			'display_name' => $post->post_title,
			'user_pass'    => $user_pass,
		);

		$user_id = wp_insert_user( $user_data );

		// On success.
		if ( ! is_wp_error( $user_id ) ) {
			update_user_meta( $user_id, 'inspiry_role_post_id', $post_id );
			update_user_meta( $user_id, 'inspiry_user_role', $post->post_type );
		}
	}

	if ( inspiry_is_user_sync_enabled() ) {
		add_action( 'publish_agency', 'inspiry_insert_role_user', 10, 2 );
		add_action( 'publish_agent', 'inspiry_insert_role_user', 10, 2 );
	}
}

if ( ! function_exists( 'inspiry_update_role_user' ) ) {
	/**
	 * Update role post user
	 *
	 * @param int    $post_id Post id that's attached to the user.
	 * @param object $post    Attached post object.
	 */
	function inspiry_update_role_user( $post_id, $post ) {

		if ( 'agent' !== $post->post_type && 'agency' !== $post->post_type ) {
			return;
		}

		$save_count = get_post_meta( $post_id, 'inspiry_post_term', true );

		if ( 'update' !== $save_count ) {

			if ( empty( $save_count ) ) {
				update_post_meta( $post_id, 'inspiry_post_term', 1 );
			} else {
				$save_count ++;
				update_post_meta( $post_id, 'inspiry_post_term', $save_count );
			}

			$save_count = get_post_meta( $post_id, 'inspiry_post_term', true );

			if ( $save_count >= 3 ) {
				inspiry_update_role_user_request( $post_id, true );
				update_post_meta( $post_id, 'inspiry_post_term', 'update' );
			}
		} else {
			inspiry_update_role_user_request( $post_id, false );
		}
	}

	if ( inspiry_is_user_sync_enabled() ) {
		add_action( 'save_post', 'inspiry_update_role_user', 10, 2 );
	}
}

if ( ! function_exists( 'inspiry_update_role_user_request' ) ) {
	/**
	 * Update role post information to its related user
	 *
	 * @param $post_id
	 * @param $user_pass
	 */
	function inspiry_update_role_user_request( $post_id, $user_pass = false ) {

		remove_action( 'profile_update', 'inspiry_update_role_post' );
		remove_action( 'edit_user_profile_update', 'inspiry_update_role_post' );

		$post_id   = intval( $post_id );
		$post_type = get_post_type( $post_id );

		if ( 'agent' != $post_type && 'agency' != $post_type ) {
			return;
		}

		// User Query
		$users = get_users( array(
				'meta_query' => array(
					array(
						'key'   => 'inspiry_role_post_id',
						'value' => $post_id,
					),
					array(
						'key'   => 'inspiry_user_role',
						'value' => $post_type,
					)
				)
			)
		);

		// Update the first user info.
		if ( ! empty( $users ) && is_object( $users[0] ) ) {
			$user_id          = $users[0]->ID;
			$post_meta        = get_post_custom( $post_id );
			$name             = get_the_title( $post_id );
			$content_post     = get_post( $post_id );
			$description      = $content_post->post_content;
			$profile_image_id = get_post_thumbnail_id( $post_id );

			// Updating User Meta.
			if ( isset( $post_meta['REAL_HOMES_mobile_number'] ) ) {
				update_user_meta( $user_id, 'mobile_number', $post_meta['REAL_HOMES_mobile_number'][0] );
			}

			if ( isset( $post_meta['REAL_HOMES_office_number'] ) ) {
				update_user_meta( $user_id, 'office_number', $post_meta['REAL_HOMES_office_number'][0] );
			}

			if ( isset( $post_meta['REAL_HOMES_fax_number'] ) ) {
				update_user_meta( $user_id, 'fax_number', $post_meta['REAL_HOMES_fax_number'][0] );
			}

			if ( isset( $post_meta['REAL_HOMES_address'] ) ) {
				update_user_meta( $user_id, 'inspiry_user_address', $post_meta['REAL_HOMES_address'][0] );
			}

			if ( isset( $post_meta['REAL_HOMES_website'] ) ) {
				wp_update_user( array( 'ID' => $user_id, 'user_url' => esc_url( $post_meta['REAL_HOMES_website'][0] ) ) );
			}

			if ( isset( $post_meta['REAL_HOMES_whatsapp_number'] ) ) {
				update_user_meta( $user_id, 'whatsapp_number', $post_meta['REAL_HOMES_whatsapp_number'][0] );
			}

			if ( isset( $post_meta['REAL_HOMES_facebook_url'] ) ) {
				update_user_meta( $user_id, 'facebook_url', $post_meta['REAL_HOMES_facebook_url'][0] );
			}

			if ( isset( $post_meta['REAL_HOMES_twitter_url'] ) ) {
				update_user_meta( $user_id, 'twitter_url', $post_meta['REAL_HOMES_twitter_url'][0] );
			}

			if ( isset( $post_meta['REAL_HOMES_linked_in_url'] ) ) {
				update_user_meta( $user_id, 'linkedin_url', $post_meta['REAL_HOMES_linked_in_url'][0] );
			}

			if ( isset( $post_meta['inspiry_instagram_url'] ) ) {
				update_user_meta( $user_id, 'instagram_url', $post_meta['inspiry_instagram_url'][0] );
			}

			if ( isset( $post_meta['inspiry_pinterest_url'] ) ) {
				update_user_meta( $user_id, 'pinterest_url', $post_meta['inspiry_pinterest_url'][0] );
			}

			if ( isset( $post_meta['inspiry_youtube_url'] ) ) {
				update_user_meta( $user_id, 'youtube_url', $post_meta['inspiry_youtube_url'][0] );
			}

			update_user_meta( $user_id, 'profile_image_id', $profile_image_id );
			update_user_meta( $user_id, 'description', $description );

			$user_data = array(
				'ID'           => $user_id,
				'display_name' => $name,
			);

			if ( isset( $post_meta[ 'REAL_HOMES_' . $post_type . '_email' ] ) && ! empty( isset( $post_meta[ 'REAL_HOMES_' . $post_type . '_email' ][0] ) ) ) {
				$user_data['user_email'] = $post_meta[ 'REAL_HOMES_' . $post_type . '_email' ][0];
			}

			if ( $user_pass ) {
				$user_data['user_pass'] = wp_generate_password( 12 );
			}

			$user_id = wp_update_user( $user_data );

			// User notification function exists in plugin
			if ( isset( $user_data['user_pass'] ) && function_exists( 'ere_new_user_notification' ) ) {
				// Send email notification to newly registered user and admin
				ere_new_user_notification( $user_id, $user_data['user_pass'] );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_insert_attachment' ) ) {
	/**
	 * Insert attachment and retrieve its ID
	 *
	 * @param $post_id
	 * @param $image_url
	 * @param $image_name
	 *
	 * @return int|WP_Error
	 */
	function inspiry_insert_attachment( $post_id, $image_url, $image_name ) {

		global $wp_filesystem;

		// protect if the the global filesystem isn't setup yet
		if ( is_null( $wp_filesystem ) ) {
			WP_Filesystem();
		}

		// Add Featured Image to Post
		$upload_dir       = wp_upload_dir(); // Set upload folder
		$image_data       = $wp_filesystem->get_contents( $image_url ); // Get image data
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
		$filename         = basename( $unique_file_name ); // Create image file name

		// Check folder permission and define file location
		if ( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}

		// Create the image  file on the server
		$wp_filesystem->put_contents( $file, $image_data );

		// Check image file type
		$wp_filetype = wp_check_filetype( $filename, null );

		// Set attachment data
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		// Create the attachment
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

		// Include image.php
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		// Define attachment metadata
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		// Assign metadata to attachment
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}
}

if ( ! function_exists( 'inspiry_add_user_custom_fields' ) ) {
	/**
	 * Add user role related files.
	 *
	 * @param Object|string $user User object or the current page name.
	 */
	function inspiry_add_user_custom_fields( $user ) {

		if ( 'add-existing-user' === $user ) {
			return;
		}

		?>
		<h3><?php esc_html_e( 'User Role Information', 'framework' ); ?></h3>
		<table class="form-table">
		<?php
		if ( 'add-new-user' !== $user ) {
			?>
			<tr>
				<th>
					<label for="inspiry_role_post_id"><?php esc_html_e( 'User Agent/Agency ID', 'framework' ); ?></label>
				</th>
					<td>
						<?php $role_post_id = get_the_author_meta( 'inspiry_role_post_id', $user->ID ); ?>
						<input type="text" name="inspiry_role_post_id" value="<?php echo esc_attr( $role_post_id ); ?>">
					</td>
				</tr>
			<?php
		}
		?>
		<tr>
			<th><label for="inspiry_user_role"><?php esc_html_e( 'User Role', 'framework' ); ?></label></th>
			<td>
			<?php
			$user_roles = inspiry_user_sync_roles();
			if ( ! empty( $user_roles ) && is_array( $user_roles ) ) {
				if ( 'add-existing-user' === $user || 'add-new-user' === $user ) {
					$user_role = '';
				} else {
					$user_role = get_the_author_meta( 'inspiry_user_role', $user->ID );
				}
				?>
				<select name="inspiry_user_role" id="inspiry_user_role">
					<?php
					foreach ( $user_roles as $key => $value ) {
						$selected = '';
						if ( $user_role == $key ) {
							$selected = 'selected';
						}
						echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
					}
					?>
				</select>
				<?php
			}
			?>
			</td>
		</tr>
	</table>
		<?php
	}

	if ( inspiry_is_user_sync_enabled() ) {
		add_action( 'show_user_profile', 'inspiry_add_user_custom_fields' );
		add_action( 'edit_user_profile', 'inspiry_add_user_custom_fields' );
		add_action( 'user_new_form', 'inspiry_add_user_custom_fields' );
	}
}

if ( ! function_exists( 'inspiry_update_user_custom_fields' ) ) {
	/**
	 * Update user profile custom fields
	 *
	 * @param $user_id
	 *
	 * @return bool
	 */
	function inspiry_update_user_custom_fields( $user_id ) {

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		if ( ! empty( $_POST['inspiry_role_post_id'] ) ) {
			update_user_meta( $user_id, 'inspiry_role_post_id', sanitize_text_field( $_POST['inspiry_role_post_id'] ) );
		}

		if ( ! empty( $_POST['inspiry_user_role'] ) ) {
			update_user_meta( $user_id, 'inspiry_user_role', sanitize_text_field( $_POST['inspiry_user_role'] ) );
		}
	}

	if ( inspiry_is_user_sync_enabled() ) {
		add_action( 'personal_options_update', 'inspiry_update_user_custom_fields' );
		add_action( 'edit_user_profile_update', 'inspiry_update_user_custom_fields' );
	}
}

if ( ! function_exists( 'inspiry_insert_role_post_backend' ) ) {
	/**
	 * Update user role data and add related role post after getting
	 * a user registered from backend side.
	 *
	 * @param int $user_id Newly registered user id.
	 *
	 * @return bool
	 */
	function inspiry_insert_role_post_backend( $user_id ) {

		if ( ! current_user_can( 'edit_user', $user_id ) || empty( $_POST['inspiry_user_role'] ) ) {
			return false;
		}

		// Insert Role Post.
		if ( inspiry_is_user_sync_enabled() ) {
			$role       = sanitize_text_field( wp_unslash( $_POST['inspiry_user_role'] ) );
			$user_roles = inspiry_user_sync_roles();

			if ( array_key_exists( $role, $user_roles ) ) {

				update_user_meta( $user_id, 'inspiry_user_role', $role );
				inspiry_insert_role_post( $user_id, $role );
			}
		}
	}

	if ( inspiry_is_user_sync_enabled() ) {
		add_action( 'user_register', 'inspiry_insert_role_post_backend' );
	}
}

if ( ! function_exists( 'inspiry_add_user_agency_field' ) ) {
	/**
	 * Adds user agency field
	 *
	 * @since 3.10.2
	 *
	 * @param $user
	 */
	function inspiry_add_user_agency_field( $user ) {
		?>
        <table class="form-table">
            <tr>
                <th><label for="inspiry_user_agency"><?php esc_html_e( 'Select Agency If Any', 'framework' ); ?></label></th>
                <td>
					<?php
                    $user_agency = get_the_author_meta( 'inspiry_user_agency', $user->ID );
					if ( 0 >= intval( $user_agency ) ) {
					    $user_agency = '-1';
                    }
					?>
					<select name="inspiry_user_agency" id="inspiry_user_agency">
						<?php inspiry_dropdown_posts( 'agency', $user_agency, true ); ?>
					</select>
                </td>
            </tr>
	        <tr class="inspiry-user-address-wrap">
		        <th><label for="inspiry_user_address"><?php esc_html_e( 'Address', 'framework' ); ?></label></th>
		        <td><textarea name="inspiry_user_address" id="inspiry_user_address" rows="3" cols="30"><?php echo get_the_author_meta( 'inspiry_user_address', $user->ID ); ?></textarea></td>
	        </tr>
        </table>
		<?php
	}

	add_action( 'show_user_profile', 'inspiry_add_user_agency_field' );
	add_action( 'edit_user_profile', 'inspiry_add_user_agency_field' );
}

if ( ! function_exists( 'inspiry_update_user_agency_field' ) ) {
	/**
	 * Update user agency field
	 *
	 * @since  3.10.2
	 *
	 * @param $user_id
	 *
	 * @return bool
	 */
	function inspiry_update_user_agency_field( $user_id ) {

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		if ( isset( $_POST['inspiry_user_agency'] ) && ! empty( $_POST['inspiry_user_agency'] ) ) {
			update_user_meta( $user_id, 'inspiry_user_agency', sanitize_text_field( $_POST['inspiry_user_agency'] ) );
		}

		if ( isset( $_POST['inspiry_user_address'] ) ) {
			update_user_meta( $user_id, 'inspiry_user_address', sanitize_textarea_field( $_POST['inspiry_user_address'] ) );
		}
	}

	add_action( 'personal_options_update', 'inspiry_update_user_agency_field' );
	add_action( 'edit_user_profile_update', 'inspiry_update_user_agency_field' );
}

if ( ! function_exists( 'inspiry_get_login_redirect_Url' ) ) {
	/**
	 * Return URL to redirect on after login
	 *
	 * @return false|string
	 */
	function inspiry_get_login_redirect_Url() {

		$current_URL      = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$redirect_to      = $current_URL;
		$redirect_page_id = get_option( 'inspiry_login_redirect_page' );
		if ( ! empty( $redirect_page_id ) ) {
			$redirect_to = get_the_permalink( $redirect_page_id );
		}

		return $redirect_to;
	}
}