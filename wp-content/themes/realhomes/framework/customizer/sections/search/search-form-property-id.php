<?php
/**
 * Section: `Search Form Property ID`
 * Panel:   `Properties Search`
 *
 * @package realhomes/customizer
 * @since 3.13
 */
if ( ! function_exists( 'inspiry_search_form_property_id_customizer' ) ) {
	/**
	 * Search Form Property ID Customizer Settings.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since 3.13
	 */
	function inspiry_search_form_property_id_customizer( WP_Customize_Manager $wp_customize ) {

		// Search Form Property ID Section
		$wp_customize->add_section(
			'inspiry_properties_search_form_property_id', array(
			'title' => esc_html__( 'Search Form Property ID', 'framework' ),
			'panel' => 'inspiry_properties_search_panel',
		) );

		// Property ID Label
		$wp_customize->add_setting(
			'inspiry_property_id_label', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Property ID', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			'inspiry_property_id_label', array(
			'label'   => esc_html__( 'Label for Property ID', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_property_id',
		) );

		// Property ID Placeholder Text
		$wp_customize->add_setting(
			'inspiry_property_id_placeholder_text', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Any', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			'inspiry_property_id_placeholder_text', array(
			'label'   => esc_html__( 'Placeholder Text for Property ID', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_property_id',
		) );
	}

	add_action( 'customize_register', 'inspiry_search_form_property_id_customizer' );
}