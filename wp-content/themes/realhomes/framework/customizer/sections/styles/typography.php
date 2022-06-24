<?php
/**
 * Section:  `Typography`
 * Panel:    `Styles`
 *
 * @package realhomes/customizer
 * @since 3.0.0
 */
if ( ! function_exists( 'inspiry_typography_customizer' ) ) {
	/**
	 * inspiry_typography_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since  3.0.0
	 */
	function inspiry_typography_customizer( WP_Customize_Manager $wp_customize ) {

		// Typography Section
		$wp_customize->add_section( 'inspiry_typography_section', array(
			'title'       => esc_html__( 'Typography', 'framework' ),
			'description' => esc_html__( 'You can change Google Fonts here, You might have to publish the changes and reload the page for proper results.', 'framework' ),
			'panel'       => 'inspiry_styles_panel',
		) );

		// Body Font
		$wp_customize->add_setting( 'inspiry_body_font', array(
			'type'              => 'option',
			'default'           => 'Default',
			'sanitize_callback' => 'inspiry_sanitize_select_fonts',
		) );
		$wp_customize->add_control( 'inspiry_body_font', array(
			'label'       => esc_html__( 'Base Typography', 'framework' ),
			'description' => esc_html__( 'Select the font for your content.', 'framework' ),
			'section'     => 'inspiry_typography_section',
			'type'        => 'select',
			'choices'     => Inspiry_Google_Fonts::$fonts_list,
		) );

		// Body Font Weight
		$wp_customize->add_setting( 'inspiry_body_font_weight', array(
			'type'              => 'option',
			'default'           => 'Default',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select_fonts',
		) );
		$wp_customize->add_control( 'inspiry_body_font_weight', array(
			'label'       => esc_html__( 'Font Weight', 'framework' ),
			'description' => esc_html__( 'Default selection will use theme specified font widgets.', 'framework' ),
			'section'     => 'inspiry_typography_section',
			'type'        => 'select',
			'choices'     => Inspiry_Google_Fonts::get_font_weights( get_option( 'inspiry_body_font', 'Default' ) ),
		) );

		// Separator
		$wp_customize->add_setting( 'inspiry_heading_font_separator', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_heading_font_separator',
				array(
					'section' => 'inspiry_typography_section',
				)
			)
		);

		// Heading Font
		$wp_customize->add_setting( 'inspiry_heading_font', array(
			'type'              => 'option',
			'default'           => 'Default',
			'sanitize_callback' => 'inspiry_sanitize_select_fonts',
		) );
		$wp_customize->add_control( 'inspiry_heading_font', array(
			'label'       => esc_html__( 'Headings Typography', 'framework' ),
			'description' => esc_html__( 'Select the font for your headings.', 'framework' ),
			'section'     => 'inspiry_typography_section',
			'type'        => 'select',
			'choices'     => Inspiry_Google_Fonts::$fonts_list,
		) );

		// Heading Font Weight
		$wp_customize->add_setting( 'inspiry_heading_font_weight', array(
			'type'              => 'option',
			'default'           => 'Default',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select_fonts',
		) );
		$wp_customize->add_control( 'inspiry_heading_font_weight', array(
			'label'       => esc_html__( 'Font Weight', 'framework' ),
			'description' => esc_html__( 'Default selection will use theme specified font widgets.', 'framework' ),
			'section'     => 'inspiry_typography_section',
			'type'        => 'select',
			'choices'     => Inspiry_Google_Fonts::get_font_weights( get_option( 'inspiry_heading_font', 'Default' ) ),
		) );

		// Separator
		$wp_customize->add_setting( 'inspiry_secondary_font_separator', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_secondary_font_separator',
				array(
					'section' => 'inspiry_typography_section',
				)
			)
		);

		// Secondary Font
		$wp_customize->add_setting( 'inspiry_secondary_font', array(
			'type'              => 'option',
			'default'           => 'Default',
			'sanitize_callback' => 'inspiry_sanitize_select_fonts',
		) );
		$wp_customize->add_control( 'inspiry_secondary_font', array(
			'label'       => esc_html__( 'Secondary Typography', 'framework' ),
			'description' => esc_html__( 'Select the secondary font for your content and headings.', 'framework' ),
			'section'     => 'inspiry_typography_section',
			'type'        => 'select',
			'choices'     => Inspiry_Google_Fonts::$fonts_list,
		) );

		// Secondary Font Weight
		$wp_customize->add_setting( 'inspiry_secondary_font_weight', array(
			'type'              => 'option',
			'default'           => 'Default',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select_fonts',
		) );
		$wp_customize->add_control( 'inspiry_secondary_font_weight', array(
			'label'       => esc_html__( 'Font Weight', 'framework' ),
			'description' => esc_html__( 'Default selection will use theme specified font widgets.', 'framework' ),
			'section'     => 'inspiry_typography_section',
			'type'        => 'select',
			'choices'     => Inspiry_Google_Fonts::get_font_weights( get_option( 'inspiry_secondary_font', 'Default' ) ),
		) );
	}

	add_action( 'customize_register', 'inspiry_typography_customizer' );
}

if ( ! function_exists( 'inspiry_typography_defaults' ) ) {
	/**
	 * inspiry_typography_defaults.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since  3.0.0
	 */
	function inspiry_typography_defaults( WP_Customize_Manager $wp_customize ) {
		$typography_settings_ids = array(
			'inspiry_heading_font',
			'inspiry_secondary_font',
			'inspiry_body_font',
		);
		inspiry_initialize_defaults( $wp_customize, $typography_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_typography_defaults' );
}
