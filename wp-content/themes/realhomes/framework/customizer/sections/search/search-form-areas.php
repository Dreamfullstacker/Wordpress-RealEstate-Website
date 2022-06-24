<?php
/**
 * Section:	`Search Form Areas`
 * Panel: 	`Properties Search`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_search_form_areas_customizer' ) ) :

	/**
	 * inspiry_search_form_areas_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */
	function inspiry_search_form_areas_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Search Form Min & Max Areas
		 */
		$wp_customize->add_section( 'inspiry_search_form_areas', array(
			'title' => esc_html__( 'Search Form Areas', 'framework' ),
			'panel' => 'inspiry_properties_search_panel',
		) );

		/* Min Area Label */
		$wp_customize->add_setting( 'inspiry_min_area_label', array(
			'type' 				=> 'option',
			'transport'			=> 'postMessage',
			'default' 			=> esc_html__( 'Min Area', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_min_area_label', array(
			'label' 	=> esc_html__( 'Label for Min Area Field', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_search_form_areas',
		) );

		/* Min Area Label Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial( 'inspiry_min_area_label', array(
					'selector' 				=> '.advance-search .option-bar label[for="min-area"]',
					'container_inclusive'	=> false,
					'render_callback' 		=> 'inspiry_min_area_label_render',
				) );
			}
		}

		/* Min Area Placeholder Text */
		$wp_customize->add_setting( 'inspiry_min_area_placeholder_text', array(
			'type' 				=> 'option',
			'transport'			=> 'postMessage',
			'default' 			=> esc_html__( 'Any', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_min_area_placeholder_text', array(
			'label' 	=> esc_html__( 'Placeholder Text for Min Area', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_search_form_areas',
		) );

		/* Max Area Label */
		$wp_customize->add_setting( 'inspiry_max_area_label', array(
			'type' 				=> 'option',
			'transport'			=> 'postMessage',
			'default' 			=> esc_html__( 'Max Area', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_max_area_label', array(
			'label' 	=> esc_html__( 'Label for Max Area Field', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_search_form_areas',
		) );

		/* Max Area Label Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial( 'inspiry_max_area_label', array(
					'selector' 				=> '.advance-search .option-bar label[for="max-area"]',
					'container_inclusive'	=> false,
					'render_callback' 		=> 'inspiry_max_area_label_render',
				) );
			}
		}

		/* Max Area Placeholder Text */
		$wp_customize->add_setting( 'inspiry_max_area_placeholder_text', array(
			'type' 				=> 'option',
			'transport'			=> 'postMessage',
			'default' 			=> esc_html__( 'Any', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_max_area_placeholder_text', array(
			'label' 	=> esc_html__( 'Placeholder Text for Max Area', 'framework' ),
			'type' 		=> 'text',
			'section' 	=> 'inspiry_search_form_areas',
		) );

		/* Area Measurement Unit */
		$wp_customize->add_setting( 'theme_area_unit', array(
			'type' 				=> 'option',
			'transport'			=> 'postMessage',
			'default' 			=> esc_html__( 'sq ft', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_area_unit', array(
			'label' 		=> esc_html__( 'Area Measurement Unit for Min and Max Area fields.', 'framework' ),
			'description' 	=> esc_html__( 'Example: sq ft', 'framework' ),
			'type' 			=> 'text',
			'section'		=> 'inspiry_search_form_areas',
		) );

	}

	add_action( 'customize_register', 'inspiry_search_form_areas_customizer' );
endif;


if ( ! function_exists( 'inspiry_search_form_areas_defaults' ) ) :

	/**
	 * inspiry_search_form_areas_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_search_form_areas_defaults( WP_Customize_Manager $wp_customize ) {
		$search_form_areas_settings_ids = array(
			'inspiry_min_area_label',
			'inspiry_min_area_placeholder_text',
			'inspiry_max_area_label',
			'inspiry_max_area_placeholder_text',
			'theme_area_unit',
		);
		inspiry_initialize_defaults( $wp_customize, $search_form_areas_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_search_form_areas_defaults' );
endif;


if ( ! function_exists( 'inspiry_min_area_label_render' ) ) {
	function inspiry_min_area_label_render() {
		if ( get_option( 'inspiry_min_area_label' ) ) {
			$area_unit 	= get_option( "theme_area_unit" );
			echo get_option( 'inspiry_min_area_label' );
			echo ' <span>' . esc_html( "($area_unit)" ) . '</span>';
		}
	}
}


if ( ! function_exists( 'inspiry_max_area_label_render' ) ) {
	function inspiry_max_area_label_render() {
		if ( get_option( 'inspiry_max_area_label' ) ) {
			$area_unit 	= get_option( "theme_area_unit" );
			echo get_option( 'inspiry_max_area_label' );
			echo ' <span>' . esc_html( "($area_unit)" ) . '</span>';
		}
	}
}
