<?php
/**
 * Section:	`Common Note`
 * Panel: 	`Property Detail Page`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_common_note_customizer' ) ) :

	/**
	 * inspiry_common_note_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */
	function inspiry_common_note_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Common Note Section
		 */

		$wp_customize->add_section( 'inspiry_property_common_note', array(
			'title' => esc_html__( 'Common Note', 'framework' ),
			'panel' => 'inspiry_property_panel',
			'priority' => 6
		) );

		/* Show/Hide Note */
		$wp_customize->add_setting( 'theme_display_common_note', array(
			'type' => 'option',
			'default' => 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_common_note', array(
			'label' => esc_html__( 'Common Note', 'framework' ),
			'type' => 'radio',
			'section' => 'inspiry_property_common_note',
			'choices' => array(
				'true' => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Common Note Title */
		$wp_customize->add_setting( 'theme_common_note_title', array(
			'type' 				=> 'option',
			'transport' 		=> 'postMessage',
			'default' 			=> esc_html__( 'Note', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_common_note_title', array(
			'label' 	=> esc_html__( 'Common Note Title', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_property_common_note',
		) );

		/* Common Note Title Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$common_title_selector = '#overview .common-note .common-note-heading';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$common_title_selector = '.rh_property__common_note .rh_property__heading';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_common_note_title', array(
				'selector' 				=> $common_title_selector,
				'container_inclusive'	=> false,
				'render_callback' 		=> 'inspiry_common_note_title_render',
			) );
		}

		/* Common Note Text */
		$wp_customize->add_setting( 'theme_common_note', array(
			'type' 				=> 'option',
			'transport' 		=> 'postMessage',
			'sanitize_callback' => 'wp_kses_data',
		) );
		$wp_customize->add_control( 'theme_common_note', array(
			'label' 	=> esc_html__( 'Common Note', 'framework' ),
			'desc' 		=> esc_html__( 'Provide common note text. It will be displayed on all properties detail pages.', 'framework' ),
			'type' 		=> 'textarea',
			'section' 	=> 'inspiry_property_common_note',
		) );

		/* Common Note Text Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$common_text_selector = '#overview .common-note p';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$common_text_selector = '.rh_property__common_note p';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_common_note', array(
				'selector' 				=> $common_text_selector,
				'container_inclusive'	=> false,
				'render_callback' 		=> 'inspiry_common_note_render',
			) );
		}

	}

	add_action( 'customize_register', 'inspiry_common_note_customizer' );
endif;


if ( ! function_exists( 'inspiry_common_note_defaults' ) ) :

	/**
	 * inspiry_common_note_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_common_note_defaults( WP_Customize_Manager $wp_customize ) {
		$common_note_settings_ids = array(
			'theme_display_common_note',
			'theme_common_note_title',
		);
		inspiry_initialize_defaults( $wp_customize, $common_note_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_common_note_defaults' );
endif;


if ( ! function_exists( 'inspiry_common_note_title_render' ) ) {
	function inspiry_common_note_title_render() {
		if ( get_option( 'theme_common_note_title' ) ) {
			echo esc_html( get_option( 'theme_common_note_title' ) );
		}
	}
}


if ( ! function_exists( 'inspiry_common_note_render' ) ) {
	function inspiry_common_note_render() {
		if ( get_option( 'theme_common_note' ) ) {
			echo esc_html( get_option( 'theme_common_note' ) );
		}
	}
}
