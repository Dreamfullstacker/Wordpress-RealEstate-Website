<?php
/**
 * Section:	`Search Form Beds & Baths`
 * Panel: 	`Properties Search`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_search_form_beds_customizer' ) ) :

	/**
	 * inspiry_search_form_beds_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */
	function inspiry_search_form_beds_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Search Form Beds & Baths
		 */

		$wp_customize->add_section( 'inspiry_search_form_beds_baths', array(
			'title' => esc_html__( 'Search Form Beds & Baths', 'framework' ),
			'panel' => 'inspiry_properties_search_panel',
		) );

		/* Min Beds Label */
		$wp_customize->add_setting( 'inspiry_min_beds_label', array(
			'type' 				=> 'option',
			'transport'			=> 'postMessage',
			'default' 			=> esc_html__( 'Min Beds', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_min_beds_label', array(
			'label' 	=> esc_html__( 'Label for Min Beds Field', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_search_form_beds_baths',
		) );

		$wp_customize->add_setting( 'inspiry_min_beds_placeholder', array(
			'type' 				=> 'option',
			'transport'			=> 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_min_beds_placeholder', array(
			'label' 	=> esc_html__( 'Placeholder for Min Beds Field', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_search_form_beds_baths',
		) );

		/* Min Beds for Advance Search */
		$wp_customize->add_setting( 'inspiry_min_beds', array(
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default' 			=> "1,2,3,4,5,6,7,8,9,10",
		) );
		$wp_customize->add_control( 'inspiry_min_beds', array(
			'label' 		=> esc_html__( 'Minimum Beds Values', 'framework' ),
			'description' 	=> esc_html__( 'Only provide comma separated numbers.', 'framework' ),
			'type' 			=> 'textarea',
			'section' 		=> 'inspiry_search_form_beds_baths',
		) );

		/* Min Baths Label */
		$wp_customize->add_setting( 'inspiry_min_baths_label', array(
			'type' 				=> 'option',
			'transport'			=> 'postMessage',
			'default' 			=> esc_html__( 'Min Baths', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_min_baths_label', array(
			'label' 	=> esc_html__( 'Label for Min Baths Field', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_search_form_beds_baths',
		) );

		$wp_customize->add_setting( 'inspiry_min_baths_placeholder', array(
			'type' 				=> 'option',
			'transport'			=> 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_min_baths_placeholder', array(
			'label' 	=> esc_html__( 'Placeholder for Min Baths Field', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_search_form_beds_baths',
		) );

		/* Min Baths for Advance Search */
		$wp_customize->add_setting( 'inspiry_min_baths', array(
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default' 			=> "1,2,3,4,5,6,7,8,9,10",
		) );
		$wp_customize->add_control( 'inspiry_min_baths', array(
			'label' 		=> esc_html__( 'Minimum Baths Values', 'framework' ),
			'description' 	=> esc_html__( 'Only provide comma separated numbers.', 'framework' ),
			'type' 			=> 'textarea',
			'section' 		=> 'inspiry_search_form_beds_baths',
		) );

		/* Beds & Baths search behaviour */
		$wp_customize->add_setting( 'inspiry_beds_baths_search_behaviour', array(
			'type'    	=> 'option',
			'default'	=> 'min',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_beds_baths_search_behaviour', array(
			'label'       	=> esc_html__( 'Beds and Baths Search Behaviour', 'framework' ),
			'description' 	=> esc_html__( 'Do you want the search functionality to look for minimum beds, maximum beds or exact equals ?', 'framework' ),
			'type'        	=> 'select',
			'section'     	=> 'inspiry_search_form_beds_baths',
			'choices'     	=> array(
				'min'   	=> esc_html__( 'Minimum', 'framework' ),
				'max'   	=> esc_html__( 'Maximum', 'framework' ),
				'equal' 	=> esc_html__( 'Equal', 'framework' ),
			),
		) );

	}

	add_action( 'customize_register', 'inspiry_search_form_beds_customizer' );
endif;


if ( ! function_exists( 'inspiry_search_form_beds_defaults' ) ) :

	/**
	 * inspiry_search_form_beds_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_search_form_beds_defaults( WP_Customize_Manager $wp_customize ) {
		$search_form_beds_settings_ids = array(
			'inspiry_min_beds_label',
			'inspiry_min_beds',
			'inspiry_min_baths_label',
			'inspiry_min_baths',
		);
		inspiry_initialize_defaults( $wp_customize, $search_form_beds_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_search_form_beds_defaults' );
endif;
