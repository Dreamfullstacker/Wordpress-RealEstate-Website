<?php

if ( ! function_exists( 'inspiry_pages_customizer' ) ) {
	function inspiry_pages_customizer( WP_Customize_Manager $wp_customize ) {

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/**
			 * Pages Section
			 */
			$wp_customize->add_section( 'inspiry_pages_section', array(
				'title'    => esc_html__( 'General Pages', 'framework' ),
				'priority' => 125,
			) );

			/* Header Banner or None */
			$wp_customize->add_setting( 'inspiry_pages_header_variation', array(
				'type'              => 'option',
				'default'           => 'banner',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'inspiry_pages_header_variation', array(
				'label'       => esc_html__( 'Header Variation', 'framework' ),
				'description' => esc_html__( 'Header variation to display on Pages.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_pages_section',
				'choices'     => array(
					'banner' => esc_html__( 'Banner', 'framework' ),
					'none'   => esc_html__( 'None', 'framework' ),
				),
			) );

			/* Explode Listing Title */
			$wp_customize->add_setting( 'inspiry_explode_listing_title', array(
				'type'              => 'option',
				'default'           => 'yes',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'inspiry_explode_listing_title', array(
				'label'       => esc_html__( 'Explode Title', 'framework' ),
				'description' => esc_html__( 'Explode page title into sub-title and title.', 'framework' ),
				'type'        => 'select',
				'section'     => 'inspiry_pages_section',
				'choices'     => array(
					'yes' => esc_html__( 'Yes', 'framework' ),
					'no'  => esc_html__( 'No', 'framework' ),
				),
			) );
		}
	}
	add_action( 'customize_register', 'inspiry_pages_customizer' );
}


if ( ! function_exists( 'inspiry_pages_defaults' ) ) {

	function inspiry_pages_defaults( WP_Customize_Manager $wp_customize ) {
		$pages_settings_ids = array(
			'inspiry_pages_header_variation',
			'inspiry_explode_listing_title',
		);
		inspiry_initialize_defaults( $wp_customize, $pages_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_pages_defaults' );
}