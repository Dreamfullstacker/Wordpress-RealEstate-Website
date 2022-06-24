<?php
/**
 * Agencies Customizer Settings
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_agencies_customizer' ) ) :
	function inspiry_agencies_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Agencies Section
		 */
		$wp_customize->add_section( 'inspiry_agencies_pages', array(
			'title'    => esc_html__( 'Agencies Pages', 'framework' ),
			'priority' => 125,
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Header Banner or None */
			$wp_customize->add_setting( 'inspiry_agencies_header_variation', array(
				'type'              => 'option',
				'default'           => 'banner',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'inspiry_agencies_header_variation', array(
				'label'       => esc_html__( 'Header Variation', 'framework' ),
				'description' => esc_html__( 'Header variation to display on agency pages.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_agencies_pages',
				'choices'     => array(
					'banner' => esc_html__( 'Banner', 'framework' ),
					'none'   => esc_html__( 'None', 'framework' ),
				),
			) );
		}

		/* Number of Agencies  */
		$wp_customize->add_setting( 'inspiry_number_posts_agency', array(
			'type'              => 'option',
			'default'           => '3',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_number_posts_agency', array(
			'label'       => esc_html__( 'Number of Agencies', 'framework' ),
			'description' => esc_html__( 'Select the maximum number of agencies to display on an agencies list page.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_agencies_pages',
			'choices'     => array(
				'1'  => 1,
				'2'  => 2,
				'3'  => 3,
				'4'  => 4,
				'5'  => 5,
				'6'  => 6,
				'7'  => 7,
				'8'  => 8,
				'9'  => 9,
				'10' => 10,
				'11' => 11,
				'12' => 12,
				'13' => 13,
				'14' => 14,
				'15' => 15,
				'16' => 16,
				'17' => 17,
				'18' => 18,
				'19' => 19,
				'20' => 20,
			),
		) );

		/* Number of Agencies  */
		$wp_customize->add_setting( 'inspiry_number_of_agents_agency', array(
			'type'              => 'option',
			'default'           => '6',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_number_of_agents_agency', array(
			'label'       => esc_html__( 'Number of Agents on Agency Detail Page', 'framework' ),
			'description' => esc_html__( 'Select the number of agents to display on agency detail page.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_agencies_pages',
			'choices'     => array(
				'1'  => 1,
				'2'  => 2,
				'3'  => 3,
				'4'  => 4,
				'5'  => 5,
				'6'  => 6,
				'7'  => 7,
				'8'  => 8,
				'9'  => 9,
				'10' => 10,
				'11' => 11,
				'12' => 12,
				'13' => 13,
				'14' => 14,
				'15' => 15,
				'16' => 16,
				'17' => 17,
				'18' => 18,
				'19' => 19,
				'20' => 20,
			),
		) );

		$wp_customize->add_setting( 'inspiry_agencies_sort_controls', array(
			'type'              => 'option',
			'default'           => 'hide',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_agencies_sort_controls', array(
			'label'       => esc_html__( 'Agencies Sort Control', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_agencies_pages',
			'choices'     => array(
				'show'    => esc_html__( 'Show', 'framework' ),
				'hide'    => esc_html__( 'Hide', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_agencies_properties_count', array(
			'type'              => 'option',
			'default'           => 'hide',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_agencies_properties_count', array(
			'label'       => esc_html__( 'Agencies Properties Count', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_agencies_pages',
			'choices'     => array(
				'show'    => esc_html__( 'Show', 'framework' ),
				'hide'    => esc_html__( 'Hide', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'theme_custom_agency_contact_form', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_custom_agency_contact_form', array(
			'label'       => esc_html__( 'Shortcode to Replace Default Agency Form', 'framework' ),
			'description' => esc_html__( 'Default agency form can be replaced with custom form using contact form 7 or WPForms plugin shortcode.', 'framework' ),
			'type'        => 'text',
			'section'     => 'inspiry_agencies_pages',
		) );
	}

	add_action( 'customize_register', 'inspiry_agencies_customizer' );
endif;


if ( ! function_exists( 'inspiry_agencies_defaults' ) ) :
	/**
	 * Set default values for agencies settings
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function inspiry_agencies_defaults( WP_Customize_Manager $wp_customize ) {
		$agencies_settings_ids = array(
			'inspiry_agencies_header_variation',
			'inspiry_number_posts_agency',
			'inspiry_number_of_agents_agency',
		);
		inspiry_initialize_defaults( $wp_customize, $agencies_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_agencies_defaults' );
endif;