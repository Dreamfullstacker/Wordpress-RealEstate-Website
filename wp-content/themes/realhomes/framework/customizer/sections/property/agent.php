<?php
/**
 * Section: `Agent`
 * Panel:   `Property Detail Page`
 *
 * @package realhomes/customizer
 * @since 2.6.3
 */
if ( ! function_exists( 'inspiry_property_agent_customizer' ) ) :
	/**
	 * inspiry_property_agent_customizer.
	 *
	 * @param object $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since  2.6.3
	 */
	function inspiry_property_agent_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Agent Section
		 */
		$wp_customize->add_section( 'inspiry_property_agent', array(
			'title'    => esc_html__( 'Agent', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 16
		) );

		/* property detail variation */
		$wp_customize->add_setting(
			'theme_property_detail_variation', array(
				'type'              => 'option',
				'default'           => 'default',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'theme_property_detail_variation', array(
				'label'   => esc_html__( 'Agent Section Position', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_agent',
				'choices' => array(
					'default'          => esc_html__( 'Agent info in Main Content', 'framework' ),
					'agent-in-sidebar' => esc_html__( 'Agent info in Sidebar', 'framework' ),
				),
			)
		);

		/*
		Show/Hide Agent Information
		*/


		//Customize > Property Detail Page > Agent
		$wp_customize->add_setting( 'theme_display_agent_info', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_agent_info', array(
			'label'   => esc_html__( 'Agent Section Display', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_agent',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_property_agent_label', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Agent', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_agent_label', array(
			'label'   => esc_html__( 'Agent Title Prefix', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_property_agent',
		) );

		$wp_customize->add_setting( 'theme_display_agent_contact_info', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_agent_contact_info', array(
			'label'   => esc_html__( 'Agent Contact Information', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_agent',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'theme_display_agent_description', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_agent_description', array(
			'label'   => esc_html__( 'Agent Description', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_agent',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'theme_display_agent_detail_page_link', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_agent_detail_page_link', array(
			'label'   => esc_html__( 'Agent Detail Page Link', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_agent',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );


		$agent_detail_page_default_link_text = esc_html__( 'Know More', 'framework' );
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$agent_detail_page_default_link_text = esc_html__( 'View My Listings', 'framework' );
		}
		$wp_customize->add_setting( 'theme_agent_detail_page_link_text', array(
			'type'              => 'option',
			'default'           => $agent_detail_page_default_link_text,
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_agent_detail_page_link_text', array(
			'label'   => esc_html__( 'Agent Detail Page Link Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_property_agent',
		) );

		/* Show/Hide Agent Contact Form */
		$wp_customize->add_setting( 'inspiry_property_agent_form', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_property_agent_form', array(
			'label'   => esc_html__( 'Agent Contact Form', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_agent',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'realhomes_agent_whatsapp_button_label', array(
			'type'              => 'option',
			'default'           => esc_html__( 'WhatsApp', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'realhomes_agent_whatsapp_button_label', array(
			'label'       => esc_html__( 'WhatsApp Button Label', 'framework' ),
			'type'        => 'text',
			'section'     => 'inspiry_property_agent',
		) );

		$wp_customize->add_setting( 'realhomes_agent_callnow_button_label', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Call Now', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'realhomes_agent_callnow_button_label', array(
			'label'       => esc_html__( 'Call Now Button Label', 'framework' ),
			'type'        => 'text',
			'section'     => 'inspiry_property_agent',
		) );

		$wp_customize->add_setting( 'realhomes_agent_form_default_message', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Hello, I am interested in [%s]', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'realhomes_agent_form_default_message', array(
			'label'       => esc_html__( 'Agent Form Default Message Text', 'framework' ),
			'description' => esc_html__( '%s will be replaced with the Property Title', 'framework' ),
			'type'        => 'text',
			'section'     => 'inspiry_property_agent',
		) );

		/* Enable/Disable Message Copy */
		$wp_customize->add_setting( 'theme_send_message_copy', array(
			'type'              => 'option',
			'default'           => 'false',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_send_message_copy', array(
			'label'   => esc_html__( 'Get Copy of Message Sent to Agent', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_agent',
			'choices' => array(
				'true'  => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );

		/* Email Address to Get a Copy of Agent Message */
		$wp_customize->add_setting( 'theme_message_copy_email', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'theme_message_copy_email', array(
			'label'       => esc_html__( 'Email Address to Get Copy of Message', 'framework' ),
			'description' => esc_html__( 'Given email address will get a copy of message sent to agent.', 'framework' ),
			'type'        => 'email',
			'section'     => 'inspiry_property_agent',
		) );

		/* Agent Form Success Redirect Page */
		$wp_customize->add_setting( 'inspiry_agent_form_success_redirect_page', array(
			'type'              => 'option',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_agent_form_success_redirect_page', array(
			'label'       => esc_html__( 'Select Page For Redirection', 'framework' ),
			'description' => esc_html__( 'User will be redirected to the selected page after successful submission of the agent contact form.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_property_agent',
			'choices'     => RH_Data::get_pages_array(),
		) );
	}

	add_action( 'customize_register', 'inspiry_property_agent_customizer' );
endif;


if ( ! function_exists( 'inspiry_property_agent_defaults' ) ) :

	/**
	 * inspiry_property_agent_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_property_agent_defaults( WP_Customize_Manager $wp_customize ) {
		$property_agent_settings_ids = array(
			'theme_property_detail_variation',
			'theme_display_agent_info',
			'inspiry_property_agent_label',
			'theme_display_agent_contact_info',
			'theme_display_agent_description',
			'theme_display_agent_detail_page_link',
			'realhomes_agent_form_default_message',
			'theme_send_message_copy',
			'inspiry_property_agent_form',
		);
		inspiry_initialize_defaults( $wp_customize, $property_agent_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_property_agent_defaults' );
endif;
