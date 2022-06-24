<?php
/**
 * Section:    `Attachments`
 * Panel:    `Property Detail Page`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_property_attachments_customizer' ) ) :

	/**
	 * inspiry_property_attachments_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  2.6.3
	 */
	function inspiry_property_attachments_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Attachments Section
		 */

		$wp_customize->add_section( 'inspiry_property_attachments', array(
			'title'    => esc_html__( 'Attachments', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 14
		) );

		/* Show/Hide Attachments */
		$wp_customize->add_setting( 'theme_display_attachments', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_attachments', array(
			'label'       => esc_html__( 'Property Attachments', 'framework' ),
			'description' => esc_html__( 'Attachments will only appear if there are any.', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_property_attachments',
			'choices'     => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Attachments Title */
		$wp_customize->add_setting( 'theme_property_attachments_title', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Property Attachments', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_property_attachments_title', array(
			'label'   => esc_html__( 'Property Attachments Title', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_property_attachments',
		) );

		/* Attachments Title Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$attachments_title_selector = '.attachments-wrap .attachments-label';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$attachments_title_selector = '.rh_property__attachments_wrap .rh_property__heading';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_property_attachments_title', array(
				'selector'            => $attachments_title_selector,
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_property_attachments_title_render',
			) );
		}

	}

	add_action( 'customize_register', 'inspiry_property_attachments_customizer' );
endif;


if ( ! function_exists( 'inspiry_property_attachments_defaults' ) ) :

	/**
	 * inspiry_property_attachments_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_property_attachments_defaults( WP_Customize_Manager $wp_customize ) {
		$property_attachments_settings_ids = array(
			'theme_display_attachments',
			'theme_property_attachments_title',
		);
		inspiry_initialize_defaults( $wp_customize, $property_attachments_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_property_attachments_defaults' );
endif;


if ( ! function_exists( 'inspiry_property_attachments_title_render' ) ) {
	function inspiry_property_attachments_title_render() {
		if ( get_option( 'theme_property_attachments_title' ) ) {
			echo esc_html( get_option( 'theme_property_attachments_title' ) );
		}
	}
}
