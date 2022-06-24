<?php
/**
 * Section:	`Social Share`
 * Panel: 	`Property Detail Page`
 */
if ( ! function_exists( 'inspiry_property_social_share_customizer' ) ) :
	/**
	 * Property social share customizer settings.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  3.11.0
	 */
	function inspiry_property_social_share_customizer( WP_Customize_Manager $wp_customize ) {

		// Social Share Section
		$wp_customize->add_section( 'inspiry_property_social_share', array(
			'title' => esc_html__( 'Social Share', 'framework' ),
			'panel' => 'inspiry_property_panel',
			'priority' => 11
		) );

		// Enable/Disable Social Share Section
		$wp_customize->add_setting(
			'theme_display_social_share', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control(
			'theme_display_social_share', array(
			'label'   => esc_html__( 'Property Share', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_social_share',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		// Enable/Disable LINE Social Share
		$wp_customize->add_setting(
			'realhomes_line_social_share', array(
			'type'              => 'option',
			'default'           => 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control(
			'realhomes_line_social_share', array(
			'label'   => esc_html__( 'LINE Share', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_social_share',
			'choices' => array(
				'true'  => esc_html__( 'Enable', 'framework' ),
				'false' => esc_html__( 'Disable', 'framework' ),
			),
		) );
	}

	add_action( 'customize_register', 'inspiry_property_social_share_customizer' );
endif;

if ( ! function_exists( 'inspiry_property_social_share_defaults' ) ) :
	/**
	 * Property social share defaults.
	 *
	 * @since  3.11.0
	 */
	function inspiry_property_social_share_defaults( WP_Customize_Manager $wp_customize ) {
		inspiry_initialize_defaults( $wp_customize, array( 'theme_display_social_share' ) );
	}

	add_action( 'customize_save_after', 'inspiry_property_social_share_defaults' );
endif;