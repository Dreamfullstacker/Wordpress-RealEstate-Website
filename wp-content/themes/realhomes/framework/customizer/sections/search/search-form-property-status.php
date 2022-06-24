<?php
/**
 * Section: `Search Form Property Status`
 * Panel:   `Properties Search`
 *
 * @package realhomes/customizer
 * @since 3.13
 */
if ( ! function_exists( 'inspiry_search_form_property_status_customizer' ) ) {
	/**
	 * Search Form Property Status Customizer Settings.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since 3.13
	 */
	function inspiry_search_form_property_status_customizer( WP_Customize_Manager $wp_customize ) {

		// Search Form Property Status Section
		$wp_customize->add_section(
			'inspiry_properties_search_form_property_status', array(
			'title' => esc_html__( 'Search Form Property Status', 'framework' ),
			'panel' => 'inspiry_properties_search_panel',
		) );

		// Property Status Label
		$wp_customize->add_setting(
			'inspiry_property_status_label', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Property Status', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			'inspiry_property_status_label', array(
			'label'   => esc_html__( 'Label for Property Status', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_property_status',
		) );

		$wp_customize->add_setting( 'inspiry_property_status_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_status_placeholder', array(
			'label'   => esc_html__( 'Placeholder for Property Status', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_property_status',
		) );
	}

	add_action( 'customize_register', 'inspiry_search_form_property_status_customizer' );
}