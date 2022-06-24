<?php
/**
 * Currency Switcher Customizer Settings
 */

if ( ! function_exists( 'inspiry_language_switcher_customizer' ) ) :
	function inspiry_language_switcher_customizer( WP_Customize_Manager $wp_customize ) {

		if ( class_exists( 'SitePress' ) ) {

			$wp_customize->add_section( 'inspiry_language_switcher', array(
				'title' => esc_html__( 'WPML Language Switcher', 'framework' ),
				'panel' => 'inspiry_floating_features_section',
			) );

			/* Enable / Disable WPML Language switcher */
			$wp_customize->add_setting( 'theme_wpml_lang_switcher', array(
				'type'    => 'option',
				'default' => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'theme_wpml_lang_switcher', array(
				'label'   => esc_html__( 'WPML Language Switcher Display', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_language_switcher',
				'choices' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
			) );

			$wp_customize->add_setting( 'theme_switcher_language_display', array(
				'type'    => 'option',
				'default' => 'inspiry_name_and_flag',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'theme_switcher_language_display', array(
				'label'   => esc_html__( 'Switcher Language Display Options', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_language_switcher',
				'choices' => array(
					'language_name_and_flag' => esc_html__( 'Name and Flag', 'framework' ),
					'language_name_only' => esc_html__( 'Name Only', 'framework' ),
					'language_flag_only' => esc_html__( 'Flag Only ', 'framework' ),
				),
				'active_callback' => 'inspiry_wpml_language_switcher_callback'
			) );
		}

	}

	add_action( 'customize_register', 'inspiry_language_switcher_customizer' );
endif;

if ( ! function_exists( 'inspiry_wpml_language_switcher_defaults' ) ) :

	/**
	 * inspiry_user_navigation_defaults.
	 *
	 * @since  2.6.3
	 */

	function inspiry_wpml_language_switcher_defaults( WP_Customize_Manager $wp_customize ) {
		$wpml_language_settings_ids = array(
			'theme_wpml_lang_switcher',
			'theme_switcher_language_display'
		);
		inspiry_initialize_defaults( $wp_customize, $wpml_language_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_wpml_language_switcher_defaults' );
endif;


if ( ! function_exists( 'inspiry_wpml_language_switcher_callback' ) ) :

	function inspiry_wpml_language_switcher_callback() {


		if ( 'true' === get_option( 'theme_wpml_lang_switcher', 'true' ) ) {

			return true;
		}

		return false;
	}
endif;