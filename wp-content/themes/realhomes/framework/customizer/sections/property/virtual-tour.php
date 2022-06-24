<?php
/**
 * Section:	`Virtual Tour`
 * Panel: 	`Property Detail Page`
 *
 * @since 3.0.1
 */

if ( ! function_exists( 'inspiry_property_virtual_tour_customizer' ) ) :

	/**
	 * inspiry_property_virtual_tour_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  3.0.1
	 */
	function inspiry_property_virtual_tour_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Virtual Tour Section
		 */
		$wp_customize->add_section( 'inspiry_virtual_tour', array(
			'title' => esc_html__( 'Virtual Tour', 'framework' ),
			'panel' => 'inspiry_property_panel',
			'priority' => 9
		) );

		/* Show/Hide Virtual Tour */
		$wp_customize->add_setting( 'inspiry_display_virtual_tour', array(
			'type' 		=> 'option',
			'default' 	=> 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_display_virtual_tour', array(
			'label' => esc_html__( 'Property Virtual Tour', 'framework' ),
			'type' 	=> 'radio',
			'section' => 'inspiry_virtual_tour',
			'choices' => array(
				'true' 	=> esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Virtual Tour Title */
		$wp_customize->add_setting( 'inspiry_virtual_tour_title', array(
			'type' 				=> 'option',
			'transport' 		=> 'postMessage',
			'default' 			=> esc_html__( 'Property Virtual Tour', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_virtual_tour_title', array(
			'label' 	=> esc_html__( 'Property Virtual Tour Title', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_virtual_tour',
		) );

		/* Virtual Tour Title Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$video_title_selector = '.property-virtual-tour .virtual-tour-label';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$video_title_selector = '.rh_property__virtual_tour .rh_property__heading';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_virtual_tour_title', array(
				'selector' 				=> $video_title_selector,
				'container_inclusive'	=> false,
				'render_callback' 		=> 'inspiry_virtual_tour_title_render',
			) );
		}

	}

	add_action( 'customize_register', 'inspiry_property_virtual_tour_customizer' );
endif;


if ( ! function_exists( 'inspiry_virtual_tour_defaults' ) ) :

	/**
	 * inspiry_virtual_tour_defaults.
	 *
	 * @since  3.0.1
	 */
	function inspiry_virtual_tour_defaults( WP_Customize_Manager $wp_customize ) {
		$property_video_settings_ids = array(
			'inspiry_display_virtual_tour',
			'inspiry_virtual_tour_title',
		);
		inspiry_initialize_defaults( $wp_customize, $property_video_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_virtual_tour_defaults' );
endif;


if ( ! function_exists( 'inspiry_virtual_tour_title_render' ) ) {
	function inspiry_virtual_tour_title_render() {
		if ( get_option( 'inspiry_virtual_tour_title' ) ) {
			echo esc_html( get_option( 'inspiry_virtual_tour_title' ) );
		}
	}
}
