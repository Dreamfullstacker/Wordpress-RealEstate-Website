<?php
if ( ! function_exists( 'inspiry_login_register_customizer' ) ) :

	function inspiry_login_register_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Login and Register Basics Section
		 */
		$wp_customize->add_section( 'inspiry_members_login', array(
			'title' => esc_html__( 'Login & Register Basics', 'framework' ),
			'panel' => 'inspiry_header_panel',
		) );

		/* Show / Hide User related stuff in header */
		$wp_customize->add_setting( 'theme_enable_user_nav', array(
			'type' 		=> 'option',
			'default' 	=> 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_enable_user_nav', array(
			'label' 	=> esc_html__( 'User related stuff in header?', 'framework' ),
			'type' 		=> 'radio',
			'section' 	=> 'inspiry_members_login',
			'choices' 	=> array(
				'true' 	=> esc_html__( 'Show', 'framework' ),
				'false'	=> esc_html__( 'Hide', 'framework' ),
			)
		) );

		/* Login Redirect Page Setting */
		$wp_customize->add_setting( 'inspiry_login_redirect_page', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_login_redirect_page', array(
			'label'       => esc_html__( 'After Login, Redirect User to Selected Page (optional)', 'framework' ),
			'description' => esc_html__( 'User will be redirected to the selected page after successful login. By default user will be redirected to the Homepage.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_login',
			'choices'     => RH_Data::get_pages_array(),
		) );

		/* Login and Register Page Setting */
		$wp_customize->add_setting( 'inspiry_login_register_page', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_login_register_page', array(
			'label'       => esc_html__( 'Login and Register Page (optional)', 'framework' ),
			'description' => esc_html__( 'By default the login dialog box will appear and you do not need to configure this option. Selected page should have Login & Register Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_login',
			'choices'     => RH_Data::get_pages_array(),
		) );




		/**
		 *  Login and Register Dialog Section
		 */
		$wp_customize->add_section( 'inspiry_login_register_dialog', array(
			'title' => esc_html__( 'Login & Register Dialog', 'framework' ),
			'panel' => 'inspiry_header_panel',
		) );

		$wp_customize->add_setting( 'inspiry_login_quote_side_display', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_quote_side_display', array(
			'label'   => esc_html__( 'Quote Side (Half of Dialog)', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_login_register_dialog',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );


		$wp_customize->add_setting( 'theme_login_modal_background', array(
			'type'              => 'option',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'theme_login_modal_background', array(
			'label'    => esc_html__( 'Login Background Image', 'framework' ),
			'section'  => 'inspiry_login_register_dialog',
			'settings' => 'theme_login_modal_background',
		) ) );

		$wp_customize->add_setting( 'inspiry_login_quote_text', array(
			'type'              => 'option',
			'default'           => 'Owning a home is a keystone of wealth… both financial affluence and emotional security.',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_quote_text', array(
			'label'     => esc_html__( 'Quote Text', 'framework' ),
			'type'      => 'textarea',
			'transport' => 'postMessage',
			'section'   => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_login_quote_author', array(
			'type'              => 'option',
			'default'           => 'Suze Orman',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_quote_author', array(
			'label'   => esc_html__( 'Quote Author', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_login_date_day_display', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_date_day_display', array(
			'label'   => esc_html__( 'Show Date and Day', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_login_register_dialog',
			'choices' => array(
				'true'  => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_login_bloginfo_display', array(
			'type'              => 'option',
			'default'           => 'site-title',
			'sanitize_callback' => 'inspiry_sanitize_radio',
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_bloginfo_display', array(
			'label'   => esc_html__( 'Select Site Title/Logo', 'framework' ),
			'type'    => 'select',
			'section' => 'inspiry_login_register_dialog',
			'choices' => array(
				'none'       => esc_html__( 'None', 'framework' ),
				'site-title' => esc_html__( 'Site Title', 'framework' ),
				'site-logo'  => esc_html__( 'Site Logo', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_login_text', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Login', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_text', array(
			'label'   => esc_html__( 'Login Tab Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_login_register_text', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Register', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_register_text', array(
			'label'   => esc_html__( 'Register Tab Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_login_forget_text', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Forget Password?', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_forget_text', array(
			'label'   => esc_html__( 'Forget Password Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_login_user_name_label', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Username', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_user_name_label', array(
			'label'   => esc_html__( 'Username Label', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_login_user_name_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Username', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_user_name_placeholder', array(
			'label'   => esc_html__( 'Username Placeholder', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );
		$wp_customize->add_setting( 'inspiry_login_password_label', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Password', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_password_label', array(
			'label'   => esc_html__( 'Password Label', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );
		$wp_customize->add_setting( 'inspiry_login_password_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Password', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_password_placeholder', array(
			'label'   => esc_html__( 'Password Placeholder', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_login_button_text', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Login', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_login_button_text', array(
			'label'   => esc_html__( 'Login Button Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_login_form_separator', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_login_form_separator',
				array(
					'section' => 'inspiry_login_register_dialog',
				)
			)
		);

		$wp_customize->add_setting( 'inspiry_register_email_label', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Email', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_register_email_label', array(
			'label'   => esc_html__( 'Email Label', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_register_email_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Email', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_register_email_placeholder', array(
			'label'   => esc_html__( 'Email Placeholder', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_register_user_role_label', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'User Role', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_register_user_role_label', array(
			'label'   => esc_html__( 'User Role Label', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_register_user_role_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'User Role', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_register_user_role_placeholder', array(
			'label'   => esc_html__( 'User Role Placeholder', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_register_button_text', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Register', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_register_button_text', array(
			'label'   => esc_html__( 'Register Button Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_register_form_separator', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_register_form_separator',
				array(
					'section' => 'inspiry_login_register_dialog',
				)
			)
		);

		$wp_customize->add_setting( 'inspiry_restore_password_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Username or Email', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_restore_password_placeholder', array(
			'label'   => esc_html__( 'Restore Field Placeholder', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

		$wp_customize->add_setting( 'inspiry_restore_button_text', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Reset Password', 'framework' ),
			'transport'         => 'postMessage'
		) );
		$wp_customize->add_control( 'inspiry_restore_button_text', array(
			'label'   => esc_html__( 'Reset Password Button Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_login_register_dialog',
		) );

	}

	add_action( 'customize_register', 'inspiry_login_register_customizer' );
endif;


if ( ! function_exists( 'inspiry_login_register_defaults' ) ) :

	function inspiry_login_register_defaults( WP_Customize_Manager $wp_customize ) {
		$login_register_settings_ids = array(
			'theme_enable_user_nav',
			'inspiry_login_quote_side_display',
			'inspiry_login_quote_text',
			'inspiry_login_quote_author',
			'inspiry_login_date_day_display',
			'inspiry_login_bloginfo_display',
			'inspiry_login_text',
			'inspiry_login_register_text',
			'inspiry_login_forget_text',
			'inspiry_login_user_name_label',
			'inspiry_login_user_name_placeholder',
			'inspiry_login_password_label',
			'inspiry_login_password_placeholder',
			'inspiry_login_button_text',
			'inspiry_register_email_label',
			'inspiry_register_email_placeholder',
			'inspiry_register_user_role_label',
			'inspiry_register_user_role_placeholder',
			'inspiry_register_button_text',
			'inspiry_restore_password_placeholder',
			'inspiry_restore_button_text',
		);
		inspiry_initialize_defaults( $wp_customize, $login_register_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_login_register_defaults' );
endif;