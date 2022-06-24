<?php
/**
 * Section: `Floor Plan`
 * Panel:   `Property Detail Page`
 *
 * @package realhomes/customizer
 * @since 3.9.0
 */

if ( ! function_exists( 'inspiry_property_floor_plan_customizer' ) ) :

	function inspiry_property_floor_plan_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Floor Plan Section
		 */
		$wp_customize->add_section( 'inspiry_property_floor_plan', array(
			'title' => esc_html__( 'Floor Plan', 'framework' ),
			'panel' => 'inspiry_property_panel',
			'priority' => 7
		) );

		$wp_customize->add_setting( 'inspiry_property_floor_plans_label', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Floor Plans', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_floor_plans_label', array(
			'label'   => esc_html__( 'Floor Plans Label', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_property_floor_plan',
		) );

	}

	add_action( 'customize_register', 'inspiry_property_floor_plan_customizer' );
endif;


if ( ! function_exists( 'inspiry_property_floor_plan_defaults' ) ) :
	/**
	 * @since  3.9.0
	 */
	function inspiry_property_floor_plan_defaults( WP_Customize_Manager $wp_customize ) {
		$property_floor_plans_settings_ids = array(
			'inspiry_property_floor_plans_label',
		);
		inspiry_initialize_defaults( $wp_customize, $property_floor_plans_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_property_floor_plan_defaults' );
endif;
