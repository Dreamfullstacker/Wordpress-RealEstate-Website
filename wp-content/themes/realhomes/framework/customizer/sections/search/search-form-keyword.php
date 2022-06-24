<?php
/**
 * Section: `Search Form Keyword`
 * Panel:   `Properties Search`
 *
 * @package realhomes/customizer
 * @since 3.13
 */
if ( ! function_exists( 'inspiry_search_form_keyword_customizer' ) ) {
	/**
	 * Search Form Keyword Customizer Settings.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since 3.13
	 */
	function inspiry_search_form_keyword_customizer( WP_Customize_Manager $wp_customize ) {

		// Search Form Keyword Section
		$wp_customize->add_section(
			'inspiry_properties_search_form_keyword', array(
				'title' => esc_html__( 'Search Form Keyword', 'framework' ),
				'panel' => 'inspiry_properties_search_panel',
			)
		);

		// Keyword Label
		$wp_customize->add_setting(
			'inspiry_keyword_label', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Keyword', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			'inspiry_keyword_label', array(
			'label'   => esc_html__( 'Label for Keyword Search', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_keyword',
		) );

		// Keyword Placeholder Text
		$wp_customize->add_setting(
			'inspiry_keyword_placeholder_text', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Any', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			'inspiry_keyword_placeholder_text', array(
			'label'   => esc_html__( 'Placeholder Text for Keyword Search', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_properties_search_form_keyword',
		) );
	}

	add_action( 'customize_register', 'inspiry_search_form_keyword_customizer' );
}