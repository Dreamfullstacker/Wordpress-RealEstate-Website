<?php
/**
 * Misc Customizer Settings
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_floating_features_customizer' ) ) :
	function inspiry_floating_features_customizer( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_panel( 'inspiry_floating_features_section', array(
			'title'    => esc_html__( 'Floating Features', 'framework' ),
			'priority' => 130,
		) );

		$wp_customize->add_section( 'inspiry_floating_features_basic', array(
			'title'    => esc_html__( 'Basics', 'framework' ),
			'panel' => 'inspiry_floating_features_section',
		) );


		$wp_customize->add_setting( 'inspiry_default_floating_button', array(
			'default' => 'half',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );

		$wp_customize->add_control( 'inspiry_default_floating_button', array(
			'label'       => esc_html__( 'Button Show', 'framework' ),
			'description' => esc_html__( 'Only for Currency Switcher and Language Switcher', 'framework' ),
			'section'     => 'inspiry_floating_features_basic',
			'type'        => 'radio',
			'settings'    => 'inspiry_default_floating_button',
			'choices'     => array(
				'half' => esc_html__( 'Half Open (Full open on mouse hover)', 'framework' ),
				'full' => esc_html__( 'Full', 'framework' ),
			),
		) );


		$wp_customize->add_setting( 'inspiry_floating_position', array(
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_floating_position', array(
			'label' 	=> esc_html__( 'Position from Top', 'framework' ),
			'description' => esc_html__('i.e 150px or 10%', 'framework'),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_floating_features_basic',
		) );


		$wp_customize->add_setting( 'inspiry_default_floating_bar_display', array(
			'default' => 'show',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );

		$wp_customize->add_control( 'inspiry_default_floating_bar_display', array(
			'label'    => esc_html__( 'Bar Display Option', 'framework' ),
			'description' => esc_html__('This bar will appear only on small devices','framework'),
			'section'  => 'inspiry_floating_features_basic',
			'type'     => 'radio',
			'settings' => 'inspiry_default_floating_bar_display',
			'choices'  => array(
				'show' => esc_html__( 'Show', 'framework' ),
				'hide' => esc_html__( 'Hide', 'framework' ),
			),
		) );


	}
	add_action( 'customize_register', 'inspiry_floating_features_customizer' );
endif;


