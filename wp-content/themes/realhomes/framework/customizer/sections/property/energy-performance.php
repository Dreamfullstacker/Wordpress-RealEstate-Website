<?php
/**
 * Section:    `Energy Performance`
 * Panel:    `Property Detail Page`
 *
 * @since 3.8.4
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_energy_performance_customizer' ) ) :

	/**
	 * inspiry_energy_performance_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  3.8.4
	 */
	function inspiry_energy_performance_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Energy Performance Section
		 */
		$wp_customize->add_section( 'inspiry_energy_performance', array(
			'title'    => esc_html__( 'Energy Performance', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 17
		) );

		/* Show/Hide Energy Performance */
		$wp_customize->add_setting( 'inspiry_display_energy_performance', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_display_energy_performance', array(
			'label'   => esc_html__( 'Energy Performance', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_energy_performance',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Property Energy Performance Title */
		$wp_customize->add_setting( 'inspiry_energy_performance_title', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Energy Performance', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_energy_performance_title', array(
			'label'   => esc_html__( 'Energy Performance Title', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_energy_performance',
		) );

		/* Energy Performance Title Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$energy_performance_selector = '.energy-performance-wrap h4';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$energy_performance_selector = '.rh_property__energy_performance_wrap .rh_property__heading';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_energy_performance_title', array(
				'selector'            => $energy_performance_selector,
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_energy_performance_title_render',
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_energy_performance_customizer' );
endif;


if ( ! function_exists( 'inspiry_energy_performance_title_render' ) ) {
	function inspiry_energy_performance_title_render() {
		if ( get_option( 'inspiry_energy_performance_title' ) ) {
			echo esc_html( get_option( 'inspiry_energy_performance_title' ) );
		}
	}
}