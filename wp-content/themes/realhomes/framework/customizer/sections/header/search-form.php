<?php
/**
 * Section:	`Search Form`
 * Panel: 	`Header`
 *
 * @since 3.4.1
 */
if ( ! function_exists( 'inspiry_header_search_form_customizer' ) ) :
	/**
	 * inspiry_header_search_form_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  3.4.1
	 */
	function inspiry_header_search_form_customizer( WP_Customize_Manager $wp_customize ) {

		// Search Form
		$wp_customize->add_section( 'inspiry_header_search_form', array(
			'title' => esc_html__( 'Search Form', 'framework' ),
			'panel' => 'inspiry_header_panel',
		) );

		// Search Form Appearance in Header
		$wp_customize->add_setting(
			'inspiry_show_search_in_header', array(
			'type'              => 'option',
			'default'           => '1',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control(
			'inspiry_show_search_in_header', array(
			'label'       => esc_html__( 'Search Form on Header', 'framework' ),
			'description' => esc_html__( 'Enabling advance search form in header will hide advance search form widget in the sidebar but this setting has no effect on homepage.', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_header_search_form',
			'choices'     => array(
				'1' => esc_html__( 'Show', 'framework' ),
				'0' => esc_html__( 'Hide', 'framework' ),
			),
		) );
	}

	add_action( 'customize_register', 'inspiry_header_search_form_customizer' );
endif;
