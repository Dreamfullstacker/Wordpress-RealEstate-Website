<?php
/**
 * Section:	`Breadcrumbs`
 * Panel: 	`Property Detail Page`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_property_breadcrumbs_customizer' ) ) :

	/**
	 * inspiry_property_breadcrumbs_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */

	function inspiry_property_breadcrumbs_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Breadcrumbs Section
		 */
		$wp_customize->add_section( 'inspiry_property_breadcrumbs', array(
			'title' => esc_html__( 'Breadcrumbs', 'framework' ),
			'panel' => 'inspiry_property_panel',
			'priority' => 3
		) );

		/* Show/Hide Breadcrumbs */
		$wp_customize->add_setting( 'theme_display_property_breadcrumbs', array(
			'type' => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_property_breadcrumbs', array(
			'label' => esc_html__( 'Property Breadcrumbs', 'framework' ),
			'type' => 'radio',
			'section' => 'inspiry_property_breadcrumbs',
			'choices' => array(
				'true' => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* property breadcrumbs taxonomy */
		$wp_customize->add_setting( 'theme_breadcrumbs_taxonomy', array(
			'type' 		=> 'option',
			'default' 	=> 'property-city',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_breadcrumbs_taxonomy', array(
			'label' 	=> esc_html__( 'Breadcrumbs will be based on', 'framework' ),
			'type' 		=> 'radio',
			'section' 	=> 'inspiry_property_breadcrumbs',
			'choices'	=> array(
				'property-city' 	=> esc_html__( 'Property Location', 'framework' ),
				'property-type' 	=> esc_html__( 'Property Type', 'framework' ),
				'property-status' 	=> esc_html__( 'Property Status', 'framework' ),
			),
		) );

	}

	add_action( 'customize_register', 'inspiry_property_breadcrumbs_customizer' );
endif;


if ( ! function_exists( 'inspiry_property_breadcrumbs_defaults' ) ) :

	/**
	 * inspiry_property_breadcrumbs_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_property_breadcrumbs_defaults( WP_Customize_Manager $wp_customize ) {
		$property_breadcrumbs_settings_ids = array(
			'theme_display_property_breadcrumbs',
			'theme_breadcrumbs_taxonomy',
		);
		inspiry_initialize_defaults( $wp_customize, $property_breadcrumbs_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_property_breadcrumbs_defaults' );
endif;
