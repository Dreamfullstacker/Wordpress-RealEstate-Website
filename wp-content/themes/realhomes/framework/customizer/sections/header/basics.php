<?php
/**
 * Section:  `Basics`
 * Panel:    `Header`
 *
 * @since 3.15.2
 */

if ( ! function_exists( 'inspiry_header_basics_customizer' ) ) :
	/**
	 * Header Basics Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @since  2.6.3
	 */
	function inspiry_header_basics_customizer( WP_Customize_Manager $wp_customize ) {

		// Header Basics
		$wp_customize->add_section( 'inspiry_header_basics', array(
			'title' => esc_html__( 'Basics', 'framework' ),
			'panel' => 'inspiry_header_panel',
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			// Header Variation
			$wp_customize->add_setting(
				'inspiry_header_mod_variation_option', array(
				'type'              => 'option',
				'default'           => 'one',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( new Inspiry_Custom_Radio_Image_Control( $wp_customize, 'inspiry_header_mod_variation_option',
				array(
					'section'     => 'inspiry_header_basics',
					'label'       => esc_html__( 'Header Variations', 'framework' ),
					'description' => esc_html__( 'Choose your desired header style.', 'framework' ),
					'settings'    => 'inspiry_header_mod_variation_option',
					'choices'     => array(
						'one'   => get_template_directory_uri() . '/assets/modern/images/header-one.png',
						'two'   => get_template_directory_uri() . '/assets/modern/images/header-two.png',
						'three' => get_template_directory_uri() . '/assets/modern/images/header-three.png',
						'four'  => get_template_directory_uri() . '/assets/modern/images/header-four.jpg',
					)
				)
			) );

			$wp_customize->add_setting( 'realhomes_header_layout', array(
				'type'              => 'option',
				'default'           => 'default',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'realhomes_header_layout', array(
				'label'   => esc_html__( 'Header Layout', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_header_basics',
				'choices' => array(
					'default'   => esc_html__( 'Default (Boxed)', 'framework' ),
					'fullwidth' => esc_html__( 'Full Width', 'framework' ),
				),
			) );

			$wp_customize->add_setting(
				'inspiry_responsive_header_option', array(
					'type'              => 'option',
					'default'           => 'solid',
					'sanitize_callback' => 'inspiry_sanitize_radio',
				)
			);
			$wp_customize->add_control(
				'inspiry_responsive_header_option', array(
					'label'       => esc_html__( 'Header Display on Mobile Devices', 'framework' ),
					'type'        => 'radio',
					'section'     => 'inspiry_header_basics',
					'choices'     => array(
						'transparent' => esc_html__( 'Transparent', 'framework' ),
						'solid'       => esc_html__( 'Solid', 'framework' ),
					),
				)
			);
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_header_variation', array(
				'type'              => 'option',
				'default'           => 'default',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'inspiry_header_variation', array(
				'label'   => esc_html__( 'Choose Header Variation', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_header_basics',
				'choices' => array(
					'default' => esc_html__( 'Default', 'framework' ),
					'center'  => esc_html__( 'Center', 'framework' ),
				),
			) );
		}

		// Sticky Header
		$wp_customize->add_setting( 'theme_sticky_header', array(
			'type'              => 'option',
			'default'           => 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_sticky_header', array(
			'label'   => esc_html__( 'Sticky Header', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_header_basics',
			'choices' => array(
				'true'  => 'Enable',
				'false' => 'Disable',
			),
		) );
	}

	add_action( 'customize_register', 'inspiry_header_basics_customizer' );
endif;

if ( ! function_exists( 'inspiry_header_basics_defaults' ) ) :
	/**
	 * inspiry_header_basics_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_header_basics_defaults( WP_Customize_Manager $wp_customize ) {
		$header_basics_settings_ids = array(
			'theme_sticky_header',
			'inspiry_header_variation',
		);
		inspiry_initialize_defaults( $wp_customize, $header_basics_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_header_basics_defaults' );
endif;
