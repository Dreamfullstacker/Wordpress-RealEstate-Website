<?php
/**
 * Section: `Search Form Agent`
 * Panel:   `Properties Search`
 *
 * @package realhomes/customizer
 * @since 3.13
 */
if ( ! function_exists( 'inspiry_search_form_agent_customizer' ) ) {
	/**
	 * Search Form Agent Customizer Settings.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since 3.13
	 */
	function inspiry_search_form_agent_customizer( WP_Customize_Manager $wp_customize ) {

		// Search Form Agent Section
		$wp_customize->add_section(
			'inspiry_properties_search_form_agent', array(
				'title' => esc_html__( 'Search Form Agents', 'framework' ),
				'panel' => 'inspiry_properties_search_panel',
			)
		);

		$wp_customize->add_setting(
			'inspiry_search_form_multiselect_agents', array(
			'type'              => 'option',
			'default'           => 'yes',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_search_form_multiselect_agents', array(
			'label'   => esc_html__( 'Enable Multi Select For Property Agents Field? ', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_properties_search_form_agent',
			'choices' => array(
				'yes' => esc_html__( 'Yes', 'framework' ),
				'no'  => esc_html__( 'No', 'framework' ),
			),
		) );

		// Agent Label
		$wp_customize->add_setting(
			'inspiry_agent_field_label', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Agent', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			'inspiry_agent_field_label', array(
			'label'   => esc_html__( 'Label for Agent', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_agent',
		) );

		$wp_customize->add_setting( 'inspiry_property_agent_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_agent_placeholder', array(
			'label'   => esc_html__( 'Placeholder for Property Agent', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_agent',
		) );

		$wp_customize->add_setting( 'inspiry_property_agent_counter_placeholder', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( ' Agents Selected ', 'framework' ),
		) );
		$wp_customize->add_control( 'inspiry_property_agent_counter_placeholder', array(
			'label'       => esc_html__( 'Agents Selected', 'framework' ),
			'description' => esc_html__( 'When selected agents are greater than 2  ', 'framework' ),
			'type'        => 'text',
			'section'     => 'inspiry_properties_search_form_agent',
		) );
	}

	add_action( 'customize_register', 'inspiry_search_form_agent_customizer' );
}