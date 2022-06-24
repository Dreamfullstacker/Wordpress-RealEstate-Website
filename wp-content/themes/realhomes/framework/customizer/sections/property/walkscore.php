<?php
/**
 * Section:    `WalkScore`
 * Panel:    `Property Detail Page`
 *
 * @since 3.9.6
 */

if ( ! function_exists( 'inspiry_property_walkscore_customizer' ) ) :

	/**
	 * inspiry_property_walkscore_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  3.9.6
	 */
	function inspiry_property_walkscore_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * WalkScore Section
		 */
		$wp_customize->add_section( 'inspiry_property_walkscore', array(
			'title'    => esc_html__( 'WalkScore', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 12
		) );

		/* Show/Hide WalkScore */
		$wp_customize->add_setting( 'inspiry_display_walkscore', array(
			'type'              => 'option',
			'default'           => 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_display_walkscore', array(
			'label'   => esc_html__( 'WalkScore', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_walkscore',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* WalkScore API */
		$wp_customize->add_setting( 'inspiry_walkscore_api_key', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_walkscore_api_key', array(
			'label'       => esc_html__( 'WalkScore API', 'framework' ),
			'description' => wp_kses( __( 'Click here to get your <a target="_blank" href="https://www.walkscore.com/professional/api-sign-up.php">WalkScore API Key</a>', 'framework' ), array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
					)
				)
			),
			'type'        => 'text',
			'section'     => 'inspiry_property_walkscore',
		) );

		/* WalkScore Section Title */
		$wp_customize->add_setting( 'inspiry_property_walkscore_title', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'WalkScore', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_walkscore_title', array(
			'label'   => esc_html__( 'Section Title', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_property_walkscore',
		) );

		$walkscore_title_selector = '.walkscore-wrap .walkscore-label';
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$walkscore_title_selector = '.rh_property__walkscore_wrap .rh_property__heading';
		}

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_property_walkscore_title', array(
				'selector'            => $walkscore_title_selector,
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_property_walkscore_title_render',
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_property_walkscore_customizer' );
endif;


if ( ! function_exists( 'inspiry_property_walkscore_defaults' ) ) :

	/**
	 * inspiry_property_walkscore_defaults.
	 *
	 * @since  3.9.6
	 */
	function inspiry_property_walkscore_defaults( WP_Customize_Manager $wp_customize ) {
		$property_walkscore_settings_ids = array(
			'inspiry_display_walkscore',
			'inspiry_property_walkscore_title',
		);
		inspiry_initialize_defaults( $wp_customize, $property_walkscore_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_property_walkscore_defaults' );
endif;


if ( ! function_exists( 'inspiry_property_walkscore_title_render' ) ) {
	function inspiry_property_walkscore_title_render() {
		if ( get_option( 'inspiry_property_walkscore_title' ) ) {
			echo get_option( 'inspiry_property_walkscore_title' );
		}
	}
}