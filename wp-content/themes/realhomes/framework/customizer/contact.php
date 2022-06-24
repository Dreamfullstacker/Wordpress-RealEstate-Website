<?php
/**
 * Contact Page Customizer Settings
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_contact_customizer' ) ) :
	function inspiry_contact_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Contact Section
		 */
		$wp_customize->add_section( 'inspiry_contact_section', array(
			'title'    => esc_html__( 'Contact Page', 'framework' ),
			'priority' => 125,
		) );
		
		/* Header Variation */
		$wp_customize->add_setting( 'inspiry_contact_header_variation', array(
			'type'              => 'option',
			'default'           => 'banner',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );

		$wp_customize->add_control( 'inspiry_contact_header_variation', array(
			'label'       => esc_html__( 'Header Variation', 'framework' ),
			'description' => esc_html__( 'Header variation to display on Contact Page.', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_contact_section',
			'choices'     => array(
				'banner' => esc_html__( 'Banner', 'framework' ),
				'none'   => esc_html__( 'None', 'framework' ),
			),
		) );
	}

	add_action( 'customize_register', 'inspiry_contact_customizer' );
endif;
