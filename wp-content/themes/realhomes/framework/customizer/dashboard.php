<?php
/**
 * Dashboard Settings
 *
 * @package realhomes/customizer
 */
if ( ! function_exists( 'inspiry_dashboard_customizer' ) ) {
	function inspiry_dashboard_customizer( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_panel( 'inspiry_dashboard_panel', array(
			'title'    => esc_html__( 'Dashboard', 'framework' ),
			'priority' => 128,
		) );

		// Dashboard Basic
		$wp_customize->add_section( 'inspiry_dashboard_basic', array(
			'title' => esc_html__( 'Basic', 'framework' ),
			'panel' => 'inspiry_dashboard_panel',
		) );

		// Dashboard Page
		$wp_customize->add_setting( 'inspiry_dashboard_page', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_dashboard_page', array(
			'label'       => esc_html__( 'Select Dashboard Page', 'framework' ),
			'description' => esc_html__( 'Selected page should have Dashboard Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_dashboard_basic',
			'choices'     => RH_Data::get_pages_array(),
		) );

		// Restrict Admin Dashboard Access.
		$wp_customize->add_setting( 'theme_restricted_level', array(
			'type'              => 'option',
			'default'           => '0',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_restricted_level', array(
			'label'       => esc_html__( 'Restrict Admin Side Access', 'framework' ),
			'description' => esc_html__( 'Restrict admin side access to any user level equal to or below the selected user level.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_dashboard_basic',
			'choices'     => array(
				'0' => esc_html__( 'Subscriber ( Level 0 )', 'framework' ),
				'1' => esc_html__( 'Contributor ( Level 1 )', 'framework' ),
				'2' => esc_html__( 'Author ( Level 2 )', 'framework' ),
				// '7' => esc_html__( 'Editor ( Level 7 )','framework'),
			),
		) );

		// Logged-in User Greeting Text
		$wp_customize->add_setting( 'inspiry_user_greeting_text', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Hello', 'framework' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_user_greeting_text', array(
			'label'   => esc_html__( 'Greeting Text for Logged-in User', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_dashboard_basic',
		) );

		// Dashboard Module Display
		$wp_customize->add_setting( 'inspiry_dashboard_page_display', array(
			'type'              => 'option',
			'default'           => 'true',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_dashboard_page_display', array(
			'label'   => esc_html__( 'Summarized Info on Dashboard', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_dashboard_basic',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		// Properties Search Field
		$wp_customize->add_setting( 'inspiry_my_properties_search', array(
			'type'              => 'option',
			'default'           => 'show',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_my_properties_search', array(
			'label'   => esc_html__( 'Properties Search Field', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_dashboard_basic',
			'choices' => array(
				'show' => esc_html__( 'Show', 'framework' ),
				'hide' => esc_html__( 'Hide', 'framework' )
			),
		) );

		// Posts Per Page
		$posts_per_page_list = realhomes_dashboard_posts_per_page_list();
		if ( is_array( $posts_per_page_list ) && ! empty( $posts_per_page_list ) ) {
			$wp_customize->add_setting( 'inspiry_dashboard_posts_per_page', array(
				'type'              => 'option',
				'default'           => '10',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'inspiry_dashboard_posts_per_page', array(
				'label'   => esc_html__( 'Posts Per Page', 'framework' ),
				'type'    => 'select',
				'section' => 'inspiry_dashboard_basic',
				'choices' => $posts_per_page_list
			) );
		}

		// Submit Property
		$wp_customize->add_section( 'inspiry_members_submit', array(
			'title' => esc_html__( 'Submit Property', 'framework' ),
			'panel' => 'inspiry_dashboard_panel',
		) );

		// Submit Property Module
		$wp_customize->add_setting( 'inspiry_submit_property_module_display', array(
			'type'              => 'option',
			'default'           => 'true',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_submit_property_module_display', array(
			'label'   => esc_html__( 'Submit Property Module', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_submit',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_dashboard_submit_page_layout', array(
			'type'              => 'option',
			'default'           => 'steps',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_dashboard_submit_page_layout', array(
			'label'   => esc_html__( 'Page Layout', 'framework' ),
			'type'    => 'select',
			'section' => 'inspiry_members_submit',
			'choices' => array(
				'steps' => esc_html__( 'Multi Steps', 'framework' ),
				'step'  => esc_html__( 'Single Step', 'framework' ),
			),
		) );

		/* Show submit button when user login */
		$show_submit_on_login_default = 'true';
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$show_submit_on_login_default = 'false';
		}
		$wp_customize->add_setting( 'inspiry_show_submit_on_login', array(
			'type'              => 'option',
			'default'           => $show_submit_on_login_default,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_show_submit_on_login', array(
			'label'   => esc_html__( 'Submit Button in Header', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_submit',
			'choices' => array(
				'true'  => esc_html__( 'Show to Logged In Users Only', 'framework' ),
				'false' => esc_html__( 'Show to All Users', 'framework' ),
				'hide'  => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Submit button text */
		$wp_customize->add_setting( 'theme_submit_button_text', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Submit', 'framework' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_submit_button_text', array(
			'label'           => esc_html__( 'Submit Button Text', 'framework' ),
			'type'            => 'text',
			'section'         => 'inspiry_members_submit',
			'active_callback' => function () {
				return ( 'hide' !== get_option( 'inspiry_show_submit_on_login', 'true' ) );
			},
		) );

		/* Guest Property Submission */
		$wp_customize->add_setting( 'inspiry_guest_submission', array(
			'type'              => 'option',
			'default'           => 'false',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_guest_submission', array(
			'label'   => esc_html__( 'Guest Property Submission', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_submit',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		// Submit Property Form Fields
		$submit_property_form_fields = array(
			'title'              => esc_html__( 'Property Title', 'framework' ),
			'address-and-map'    => esc_html__( 'Property Address and Map', 'framework' ),
			'description'        => esc_html__( 'Property Description', 'framework' ),
			'price'              => esc_html__( 'Price', 'framework' ),
			'price-postfix'      => esc_html__( 'Price Postfix', 'framework' ),
			'property-id'        => esc_html__( 'Property ID', 'framework' ),
			'parent'             => esc_html__( 'Parent Property', 'framework' ),
			'property-type'      => esc_html__( 'Type', 'framework' ),
			'property-status'    => esc_html__( 'Status', 'framework' ),
			'locations'          => esc_html__( 'Location', 'framework' ),
			'bedrooms'           => esc_html__( 'Bedrooms', 'framework' ),
			'bathrooms'          => esc_html__( 'Bathrooms', 'framework' ),
			'garages'            => esc_html__( 'Garages', 'framework' ),
			'area'               => esc_html__( 'Area', 'framework' ),
			'area-postfix'       => esc_html__( 'Area Postfix', 'framework' ),
			'lot-size'           => esc_html__( 'Lot Size', 'framework' ),
			'lot-size-postfix'   => esc_html__( 'Lot Size Postfix', 'framework' ),
			'year-built'         => esc_html__( 'Year Built', 'framework' ),
			'video'              => esc_html__( 'Video', 'framework' ),
			'virtual-tour'       => esc_html__( '360 Virtual Tour', 'framework' ),
			'mortgage-fields'    => esc_html__( 'Mortgage Calculator Fields', 'framework' ),
			'featured'           => esc_html__( 'Mark as Featured', 'framework' ),
			'images'             => esc_html__( 'Property Images', 'framework' ),
			'attachments'        => esc_html__( 'Property Attachments', 'framework' ),
			'slider-image'       => esc_html__( 'Homepage Slider Image', 'framework' ),
			'floor-plans'        => esc_html__( 'Floor Plans', 'framework' ),
			'additional-details' => esc_html__( 'Additional Details', 'framework' ),
			'features'           => esc_html__( 'Features', 'framework' ),
			'label-and-color'    => esc_html__( 'Label and Color', 'framework' ),
			'energy-performance' => esc_html__( 'Energy Performance', 'framework' ),
			'agent'              => esc_html__( 'Agent', 'framework' ),
			'owner-information'  => esc_html__( 'Owner Information', 'framework' ),
			'reviewer-message'   => esc_html__( 'Message to Reviewer', 'framework' ),
			'terms-conditions'   => esc_html__( 'Terms & Conditions', 'framework' ),
		);

		$wp_customize->add_setting( 'inspiry_submit_property_fields', array(
			'type'              => 'option',
			'default'           => array_keys( $submit_property_form_fields ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
		) );
		$wp_customize->add_control( new Inspiry_Multiple_Checkbox_Customize_Control( $wp_customize, 'inspiry_submit_property_fields',
			array(
				'section' => 'inspiry_members_submit',
				'label'   => esc_html__( 'Enable/Disable Submit Property Form Fields?', 'framework' ),
				'choices' => $submit_property_form_fields
			)
		) );

		/* Separator */
		$wp_customize->add_setting( 'inspiry_submit_property_fields_separator', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_submit_property_fields_separator',
				array(
					'section' => 'inspiry_members_submit',
				)
			)
		);

		// terms & conditions field note
		$wp_customize->add_setting( 'inspiry_submit_property_terms_text', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Accept Terms & Conditions before property submission.', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'inspiry_submit_property_terms_text', array(
			'label'           => esc_html__( 'Terms & Conditions Note', 'framework' ),
			'description'     => '<strong>' . esc_html__( 'Important:', 'framework' ) . ' </strong>' . esc_html__( 'Please use {link text} pattern in your note text as it will be linked to the Terms & Conditions page.', 'framework' ),
			'type'            => 'text',
			'section'         => 'inspiry_members_submit',
			'active_callback' => 'inspiry_is_submit_property_field_terms'
		) );

		// terms and conditions detail page
		$wp_customize->add_setting( 'inspiry_submit_property_terms_page', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_submit_property_terms_page', array(
			'label'           => esc_html__( 'Select Terms & Conditions Page', 'framework' ),
			'description'     => esc_html__( 'Selected page should have terms & conditions details.', 'framework' ),
			'type'            => 'select',
			'section'         => 'inspiry_members_submit',
			'choices'         => RH_Data::get_pages_array(),
			'active_callback' => 'inspiry_is_submit_property_field_terms'
		) );

		// require to access the terms and conditions
		$wp_customize->add_setting( 'inspiry_submit_property_terms_require', array(
			'type'              => 'option',
			'default'           => true,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_checkbox',
		) );
		$wp_customize->add_control(
			'inspiry_submit_property_terms_require',
			array(
				'label'           => esc_html__( 'Require Terms & Conditions.', 'framework' ),
				'section'         => 'inspiry_members_submit',
				'type'            => 'checkbox',
				'active_callback' => 'inspiry_is_submit_property_field_terms'
			)
		);

		/* Submitted Property Status */
		$wp_customize->add_setting( 'theme_submitted_status', array(
			'type'              => 'option',
			'default'           => 'pending',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_submitted_status', array(
			'label'   => esc_html__( 'Default Status for Submitted Property', 'framework' ),
			'type'    => 'select',
			'section' => 'inspiry_members_submit',
			'choices' => array(
				'pending' => esc_html__( 'Pending ( Recommended )', 'framework' ),
				'publish' => esc_html__( 'Publish', 'framework' ),
			),
		) );

		/* Updated Property Status */
		$wp_customize->add_setting( 'inspiry_updated_property_status', array(
			'type'              => 'option',
			'default'           => 'publish',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_updated_property_status', array(
			'label'   => esc_html__( 'Default Status for Updated Property', 'framework' ),
			'type'    => 'select',
			'section' => 'inspiry_members_submit',
			'choices' => array(
				'publish' => esc_html__( 'Publish', 'framework' ),
				'pending' => esc_html__( 'Pending ( Recommended )', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_submit_max_number_images', array(
			'type'              => 'option',
			'default'           => 48,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_submit_max_number_images', array(
			'label'   => esc_html__( 'Max Number of Images to Upload', 'framework' ),
			'type'    => 'number',
			'section' => 'inspiry_members_submit',
		) );

		$wp_customize->add_setting( 'inspiry_allowed_max_attachments', array(
			'type'              => 'option',
			'default'           => 15,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_allowed_max_attachments', array(
			'label'   => esc_html__( 'Max Number of Attachments to Upload', 'framework' ),
			'type'    => 'number',
			'section' => 'inspiry_members_submit',
		) );

		/*  Property default additional details */
		$wp_customize->add_setting( 'inspiry_property_additional_details', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'inspiry_property_additional_details', array(
			'label'       => esc_html__( 'Default Additional Details', 'framework' ),
			'description' => wp_kses( __( 'Add title and value \'colon\' separated and fields \'comma\' separated. <br><br><strong>For Example</strong>: <pre>Plot Size:300,Built Year:2017</pre>', 'framework' ), array(
				'br'     => array(),
				'strong' => array(),
				'pre'    => array(),
			) ),
			'type'        => 'textarea',
			'section'     => 'inspiry_members_submit',
		) );

		/* Message after Submit */
		$wp_customize->add_setting( 'theme_submit_message', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Thanks for Submitting Property!', 'framework' ),
			'sanitize_callback' => 'inspiry_sanitize_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'theme_submit_message', array(
			'label'       => esc_html__( 'Message After Successful Submit', 'framework' ),
			'description' => esc_html__( 'a, strong, em and i HTML tags are allowed in the message.', 'framework' ),
			'type'        => 'textarea',
			'section'     => 'inspiry_members_submit',
		) );

		/* After Property Submit Redirect Page */
		$wp_customize->add_setting( 'inspiry_property_submit_redirect_page', array(
			'type'              => 'option',
			'sanitize_callback' => 'inspiry_sanitize_select',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'inspiry_property_submit_redirect_page', array(
			'label'       => esc_html__( 'Redirect to Selected Page After Submission', 'framework' ),
			'description' => esc_html__( 'This not applies on guest submission.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_submit',
			'choices'     => RH_Data::get_pages_array(),
		) );

		/* Submit Notice */
		$wp_customize->add_setting( 'theme_submit_notice_email', array(
			'type'              => 'option',
			'default'           => get_option( 'admin_email' ),
			'sanitize_callback' => 'sanitize_email',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'theme_submit_notice_email', array(
			'label'   => esc_html__( 'Email Address to Received Submission Notices', 'framework' ),
			'type'    => 'email',
			'section' => 'inspiry_members_submit',
		) );

		// My Properties
		$wp_customize->add_section( 'inspiry_members_properties', array(
			'title' => esc_html__( 'My Properties', 'framework' ),
			'panel' => 'inspiry_dashboard_panel',
		) );

		// My Properties Module
		$wp_customize->add_setting( 'inspiry_properties_module_display', array(
			'type'              => 'option',
			'default'           => 'true',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_properties_module_display', array(
			'label'   => esc_html__( 'My Properties Module', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_properties',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		// My Profile
		$wp_customize->add_section( 'inspiry_members_profile', array(
			'title' => esc_html__( 'My Profile', 'framework' ),
			'panel' => 'inspiry_dashboard_panel',
		) );

		// My Profile Module
		$wp_customize->add_setting( 'inspiry_profile_module_display', array(
			'type'              => 'option',
			'default'           => 'true',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_profile_module_display', array(
			'label'   => esc_html__( 'My Profile Module', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_profile',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		// My Favorites
		$wp_customize->add_section( 'inspiry_members_favorites', array(
			'title' => esc_html__( 'My Favorites', 'framework' ),
			'panel' => 'inspiry_dashboard_panel',
		) );

		// My Favorites Module
		$wp_customize->add_setting( 'inspiry_favorites_module_display', array(
			'type'              => 'option',
			'default'           => 'true',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_favorites_module_display', array(
			'label'   => esc_html__( 'My Favorites Module', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_favorites',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		// Enable/Disable Add to Favorites
		$wp_customize->add_setting( 'theme_enable_fav_button', array(
			'type'              => 'option',
			'default'           => 'true',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_enable_fav_button', array(
			'label'   => esc_html__( 'Add to Favorites Button on Property Detail Page', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_favorites',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		// Require Login to Favorite Properties
		$wp_customize->add_setting( 'inspiry_login_on_fav', array(
			'type'              => 'option',
			'default'           => 'no',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_login_on_fav', array(
			'label'   => esc_html__( 'Require Login for Add to Favorites.', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_members_favorites',
			'choices' => array(
				'yes' => esc_html__( 'Yes', 'framework' ),
				'no'  => esc_html__( 'No', 'framework' ),
			),
		) );

		$wp_customize->add_section(
			'realhomes_saved_searches',
			array(
				'title' => esc_html__( 'Saved Searches', 'framework' ),
				'panel' => 'inspiry_dashboard_panel',
			)
		);

		$wp_customize->add_setting(
			'realhomes_saved_searches_enabled', array(
				'type'              => 'option',
				'default'           => 'yes',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);

		$wp_customize->add_control(
			'realhomes_saved_searches_enabled',
			array(
				'label'       => esc_html__( 'Enable Saved Searches? ', 'framework' ),
				'description' => esc_html__( 'Enabling this feature will display a "Save Search" button at the top of search results. It will also add a "Saved Searches" menu item to the user menu.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'realhomes_saved_searches',
				'choices'     => array(
					'yes' => esc_html__( 'Yes', 'framework' ),
					'no'  => esc_html__( 'No', 'framework' ),
				),
			)
		);

		$wp_customize->add_setting(
			'realhomes_search_emails_frequency', array(
				'type'              => 'option',
				'default'           => 'daily',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);

		$wp_customize->add_control(
			'realhomes_search_emails_frequency',
			array(
				'label'   => esc_html__( 'Search Emails Frequency', 'framework' ),
				'type'    => 'radio',
				'section' => 'realhomes_saved_searches',
				'choices' => array(
					'daily'  => esc_html__( 'Daily', 'framework' ),
					'weekly' => esc_html__( 'Weekly', 'framework' ),
				),
			)
		);

		$wp_customize->add_setting(
			'realhomes_saved_searches_labels_separator',
			array(
				'sanitize_callback' => 'inspiry_sanitize',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'realhomes_saved_searches_labels_separator',
				array(
					'section' => 'realhomes_saved_searches',
				)
			)
		);

		$wp_customize->add_setting(
			'realhomes_save_search_btn_label',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Save Search', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'realhomes_save_search_btn_label',
			array(
				'label'   => esc_html__( 'Save Search Button Label', 'framework' ),
				'type'    => 'text',
				'section' => 'realhomes_saved_searches',
			)
		);

		$wp_customize->add_setting(
			'realhomes_search_saved_btn_label',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Search Saved', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'realhomes_search_saved_btn_label',
			array(
				'label'   => esc_html__( 'Search Saved Button Label', 'framework' ),
				'type'    => 'text',
				'section' => 'realhomes_saved_searches',
			)
		);

		$wp_customize->add_setting(
			'realhomes_save_search_btn_tooltip',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Receive email notification for the latest properties matching your search criteria.', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'realhomes_save_search_btn_tooltip',
			array(
				'label'   => esc_html__( 'Save Search Button Tooltip Text', 'framework' ),
				'type'    => 'textarea',
				'section' => 'realhomes_saved_searches',
			)
		);

		$wp_customize->add_setting(
			'realhomes_saved_searches_label',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Saved Searches', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'realhomes_saved_searches_label',
			array(
				'label'   => esc_html__( '"Saved Searches" Menu Button and Page Name', 'framework' ),
				'type'    => 'text',
				'section' => 'realhomes_saved_searches',
			)
		);

		/**
		 * Saved Search Email Template Setting
		 */
		$wp_customize->add_setting(
			'realhomes_saved_searches_email_separator',
			array(
				'sanitize_callback' => 'inspiry_sanitize',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'realhomes_saved_searches_email_separator',
				array(
					'section' => 'realhomes_saved_searches',
				)
			)
		);

		// Email subject.
		$wp_customize->add_setting(
			'realhomes_saved_search_email_subject',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Check Out Latest Properties Matching Your Saved Search Criteria', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'realhomes_saved_search_email_subject',
			array(
				'label'   => esc_html__( 'Saved Search Email Subject', 'framework' ),
				'type'    => 'textarea',
				'section' => 'realhomes_saved_searches',
			)
		);

		// Email header text.
		$wp_customize->add_setting(
			'realhomes_saved_search_email_header',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Following new properties are listed matching your search criteria. You can check the [search results here].', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'realhomes_saved_search_email_header',
			array(
				'label'       => esc_html__( 'Saved Search Email Header Text', 'framework' ),
				'description' => esc_html__( 'Wrapped text within square brackets [] will be linked to the saved search results page.', 'framework' ),
				'type'        => 'textarea',
				'section'     => 'realhomes_saved_searches',
			)
		);

		// Email footer text.
		$wp_customize->add_setting(
			'realhomes_saved_search_email_footer',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'To stop getting such emails, Simply remove related saved search from your account.', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'realhomes_saved_search_email_footer',
			array(
				'label'   => esc_html__( 'Saved Search Email Footer Text', 'framework' ),
				'type'    => 'textarea',
				'section' => 'realhomes_saved_searches',
			)
		);

		// User & Agent/Agency Sync
		$wp_customize->add_section(
			'inspiry_members_user_sync',
			array(
				'title' => esc_html__( 'User & Agent/Agency Sync', 'framework' ),
				'panel' => 'inspiry_dashboard_panel',
			)
		);

		/* Enable/Disable User Sync with Agents/Agencies */
		$wp_customize->add_setting(
			'inspiry_user_sync',
			array(
				'type'              => 'option',
				'default'           => 'false',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_user_sync',
			array(
				'label'   => esc_html__( 'Enable User Synchronisation with Agent/Agency', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_members_user_sync',
				'choices' => array(
					'true'  => esc_html__( 'Yes', 'framework' ),
					'false' => esc_html__( 'No', 'framework' ),
				),
			)
		);

		/* Enable/Disable Avatar support as fallback for Agent/Agency/Profile Image. */
		$wp_customize->add_setting(
			'inspiry_user_sync_avatar_fallback',
			array(
				'type'              => 'option',
				'default'           => 'true',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_user_sync_avatar_fallback',
			array(
				'label'           => esc_html__( 'Enable Avatar as fallback for Agent/Agency/User-Profile Image', 'framework' ),
				'type'            => 'radio',
				'section'         => 'inspiry_members_user_sync',
				'choices'         => array(
					'true'  => esc_html__( 'Yes', 'framework' ),
					'false' => esc_html__( 'No', 'framework' ),
				),
				'active_callback' => 'inspiry_user_sync',
			)
		);

		/**
		 * Dashboard customizer settings for membership plugin pages.
		 * @since  3.12
		 */
		if ( class_exists( 'IMS_Helper_Functions' ) ) {

			// Membership Section
			$wp_customize->add_section( 'inspiry_membership_section', array(
				'title' => esc_html__( 'Membership', 'framework' ),
				'panel' => 'inspiry_dashboard_panel',
			) );

			$wp_customize->add_setting( 'inspiry_disable_submit_property', array(
				'type'              => 'option',
				'default'           => 'true',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'inspiry_disable_submit_property', array(
				'label'   => esc_html__( 'Disable Submit Property Functionality for Users without Membership Package?', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_membership_section',
				'choices' => array(
					'true'  => esc_html__( 'Yes', 'framework' ),
					'false' => esc_html__( 'No', 'framework' )
				),
			) );

			$wp_customize->add_setting( 'inspiry_text_before_price', array(
				'type'              => 'option',
				'default'           => esc_html__( 'Starting at', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_text_before_price', array(
				'label'   => esc_html__( 'Membership Package Text Before Price', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_membership_section',
			) );

			$wp_customize->add_setting( 'inspiry_package_btn_text', array(
				'type'              => 'option',
				'default'           => esc_html__( 'Get Started', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_package_btn_text', array(
				'label'   => esc_html__( 'Membership Package Button Text', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_membership_section',
			) );

			$wp_customize->add_setting( 'inspiry_current_package_btn_text', array(
				'type'              => 'option',
				'default'           => esc_html__( 'Current Package', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_current_package_btn_text', array(
				'label'   => esc_html__( 'Membership Current Package Button Text', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_membership_section',
			) );

			$wp_customize->add_setting( 'inspiry_checkout_badges_display', array(
				'type'              => 'option',
				'default'           => 'show',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'inspiry_checkout_badges_display', array(
				'label'   => esc_html__( 'Checkout Page Payment Methods Badges', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_membership_section',
				'choices' => array(
					'show' => esc_html__( 'Show', 'framework' ),
					'hide' => esc_html__( 'Hide', 'framework' )
				),
			) );

			$wp_customize->add_setting( 'inspiry_order_dialog_heading', array(
				'type'              => 'option',
				'default'           => esc_html__( 'Thank you!', 'framework' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_order_dialog_heading', array(
				'label'   => esc_html__( 'Order Page Dialog Box Heading', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_membership_section',
			) );
		}

		/**
		 * Dashboard styles customizer settings.
		 * @since  3.12
		 */
		$wp_customize->add_section( 'inspiry_dashboard_styles', array(
			'title' => esc_html__( 'Styles', 'framework' ),
			'panel' => 'inspiry_dashboard_panel',
		) );

		$color_settings = realhomes_dashboard_color_settings();
		if ( is_array( $color_settings ) && ! empty( $color_settings ) ) {
			foreach ( $color_settings as $setting ) {
				$id = 'inspiry_dashboard_' . $setting['id'];
				$wp_customize->add_setting( $id, array(
					'type'              => 'option',
					'default'           => $setting['default'],
					'transport'         => 'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id,
					array(
						'label'   => $setting['label'],
						'section' => 'inspiry_dashboard_styles',
					)
				) );
			}
		}
	}

	add_action( 'customize_register', 'inspiry_dashboard_customizer' );
}

if ( ! function_exists( 'inspiry_dashboard_defaults' ) ) {
	/**
	 * Set default values for dashboard settings
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function inspiry_dashboard_defaults( WP_Customize_Manager $wp_customize ) {
		$dashboard_settings_ids = array(
			'theme_restricted_level',
			'theme_submitted_status',
			'theme_submit_default_address',
			'theme_submit_default_location',
			'theme_submit_message',
			'theme_submit_notice_email',
			'theme_enable_fav_button',
			'theme_submit_button_text',
			'inspiry_guest_submission',
			'inspiry_submit_property_fields',
			'inspiry_submit_property_terms_text',
			'inspiry_updated_property_status',
			'inspiry_user_greeting_text',
			'inspiry_dashboard_page_display',
			'inspiry_my_properties_search',
			'inspiry_dashboard_posts_per_page',
			'inspiry_submit_property_module_display',
			'inspiry_dashboard_submit_page_layout',
			'inspiry_show_submit_on_login',
			'inspiry_submit_property_terms_require',
			'inspiry_submit_max_number_images',
			'inspiry_allowed_max_attachments',
			'inspiry_properties_module_display',
			'inspiry_profile_module_display',
			'inspiry_favorites_module_display',
			'inspiry_login_on_fav',
			'inspiry_user_sync',
			'inspiry_user_sync_avatar_fallback',
			'inspiry_disable_submit_property',
			'inspiry_text_before_price',
			'inspiry_package_btn_text',
			'inspiry_checkout_badges_display',
			'inspiry_order_dialog_heading',
		);
		inspiry_initialize_defaults( $wp_customize, $dashboard_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_dashboard_defaults' );
}

if ( ! function_exists( 'inspiry_is_submit_property_field_terms' ) ) {
	/**
	 * Check if terms and condidtions field is enabled on the property submit page.
	 *
	 * @return bool|int
	 */
	function inspiry_is_submit_property_field_terms() {

		$term_field_check = get_option( 'inspiry_submit_property_fields' );

		return ( false != strpos( implode( ' ', $term_field_check ), 'terms-conditions' ) ) ? true : false;
	}
}

if ( ! function_exists( 'inspiry_user_sync' ) ) {
	/**
	 * Check if User Sync function is enabled.
	 *
	 * @param object $control complete setting control.
	 *
	 * @return bool
	 */
	function inspiry_user_sync( $control ) {
		if ( 'true' === $control->manager->get_setting( 'inspiry_user_sync' )->value() ) {
			return true;
		}

		return false;
	}
}