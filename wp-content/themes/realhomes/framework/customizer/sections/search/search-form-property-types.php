<?php
/**
 * Section: `Search Form Property Types`
 * Panel:   `Properties Search`
 *
 * @package realhomes/customizer
 * @since 3.13
 */
if ( ! function_exists( 'inspiry_search_form_property_types_customizer' ) ) {
	/**
	 * Search Form Property Types Customizer Settings.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since 3.13
	 */
	function inspiry_search_form_property_types_customizer( WP_Customize_Manager $wp_customize ) {

		// Search Form Property Types Section
		$wp_customize->add_section(
			'inspiry_properties_search_form_property_types', array(
			'title' => esc_html__( 'Search Form Property Types', 'framework' ),
			'panel' => 'inspiry_properties_search_panel',
		) );

		$wp_customize->add_setting(
			'inspiry_search_form_multiselect_types', array(
			'type'              => 'option',
			'default'           => 'yes',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );

		$wp_customize->add_control( 'inspiry_search_form_multiselect_types', array(
			'label'   => esc_html__( 'Enable Multi Select For Property Types Field? ', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_properties_search_form_property_types',
			'choices' => array(
				'yes' => esc_html__( 'Yes', 'framework' ),
				'no'  => esc_html__( 'No', 'framework' ),
			),
		) );

		// Property Type Label
		$wp_customize->add_setting(
			'inspiry_property_type_label', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Property Type', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			'inspiry_property_type_label', array(
			'label'   => esc_html__( 'Label for Property Type', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_property_types',
		) );

		$wp_customize->add_setting( 'inspiry_property_type_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_type_placeholder', array(
			'label'   => esc_html__( 'Placeholder for Property Type', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_property_types',
		) );

		$wp_customize->add_setting( 'inspiry_property_types_counter_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( ' Types Selected ', 'framework' ),
		) );
		$wp_customize->add_control( 'inspiry_property_types_counter_placeholder', array(
			'label'       => esc_html__( ' Types Selected ', 'framework' ),
			'description' => esc_html__( 'When selected types are greater than 2  ', 'framework' ),
			'type'        => 'text',
			'section'     => 'inspiry_properties_search_form_property_types',
		) );
	}

	add_action( 'customize_register', 'inspiry_search_form_property_types_customizer' );
}