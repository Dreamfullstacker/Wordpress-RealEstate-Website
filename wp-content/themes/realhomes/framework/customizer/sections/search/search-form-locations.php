<?php
/**
 * Section:	`Search Form Locations`
 * Panel: 	`Properties Search`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_search_form_locations_customizer' ) ) :

	/**
	 * inspiry_search_form_locations_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */
	function inspiry_search_form_locations_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Search Form Locations
		 */
		$wp_customize->add_section( 'inspiry_search_form_locations', array(
			'title' => esc_html__( 'Search Form Locations', 'framework' ),
			'panel' => 'inspiry_properties_search_panel',
		) );

		if ( ! inspiry_is_rvr_enabled() ) {
			/* Number of Location Boxes */
			$wp_customize->add_setting( 'theme_location_select_number', array(
				'type' 		=> 'option',
				'default' 	=> '1',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'theme_location_select_number', array(
				'label' 		=> esc_html__( 'Number of Location Select Boxes', 'framework' ),
				'description' 	=> esc_html__( 'In case of 1 location box, all locations will be listed in that select box. In case of 2 or more, Each select box will list parent locations of a level that matches its number and all the remaining children locations will be listed in last select box.', 'framework' ),
				'type' 			=> 'select',
				'section' 		=> 'inspiry_search_form_locations',
				'choices' 		=> array(
					'1' 		=> 1,
					'2' 		=> 2,
					'3' 		=> 3,
					'4' 		=> 4,
				),
				'active_callback' => 'inspiry_ajax_location_field'
			) );

			/* 1st Location Box Title */
			$wp_customize->add_setting( 'theme_location_title_1', array(
				'type' 				=> 'option',
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'theme_location_title_1', array(
				'label' 		=> esc_html__( 'Title for 1st Location Select Box', 'framework' ),
				'description' 	=> esc_html__( 'Example: Country', 'framework' ),
				'type' 			=> 'text',
				'section' 		=> 'inspiry_search_form_locations',
			) );

			$wp_customize->add_setting( 'inspiry_location_placeholder_1', array(
				'type' 				=> 'option',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_location_placeholder_1', array(
				'label' 	=> esc_html__( 'Placeholder for 1st Location Field', 'framework' ),
				'type' 		=> 'text',
				'section' 	=> 'inspiry_search_form_locations',
			) );

			$wp_customize->add_setting( 'inspiry_location_count_placeholder_1', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_location_count_placeholder_1', array(
				'label'           => esc_html__( 'Location Selected Placeholder', 'framework' ),
				'description'     => esc_html__( 'When selected locations are greater than 2', 'framework' ),
				'type'            => 'text',
				'section'         => 'inspiry_search_form_locations',
				'active_callback' => 'inspiry_ajax_location_field_display'
			) );

			/* 2nd Location Box Title */
			$wp_customize->add_setting( 'theme_location_title_2', array(
				'type' 				=> 'option',
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'theme_location_title_2', array(
				'label' 		=> esc_html__( 'Title for 2nd Location Select Box', 'framework' ),
				'description' 	=> esc_html__( 'Example: State', 'framework' ),
				'type' 			=> 'text',
				'section' 		=> 'inspiry_search_form_locations',
				'active_callback' => 'inspiry_ajax_location_field'
			) );

			$wp_customize->add_setting( 'inspiry_location_placeholder_2', array(
				'type' 				=> 'option',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_location_placeholder_2', array(
				'label' 	=> esc_html__( 'Placeholder for 2nd Location Field', 'framework' ),
				'type' 		=> 'text',
				'section' 	=> 'inspiry_search_form_locations',
				'active_callback' => 'inspiry_ajax_location_field'
			) );

			/* 3rd Location Box Title */
			$wp_customize->add_setting( 'theme_location_title_3', array(
				'type' 				=> 'option',
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'theme_location_title_3', array(
				'label' 		=> esc_html__( 'Title for 3rd Location Select Box', 'framework' ),
				'description' 	=> esc_html__( 'Example: City', 'framework' ),
				'type' 			=> 'text',
				'section' 		=> 'inspiry_search_form_locations',
				'active_callback' => 'inspiry_ajax_location_field'
			) );

			$wp_customize->add_setting( 'inspiry_location_placeholder_3', array(
				'type' 				=> 'option',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_location_placeholder_3', array(
				'label' 	=> esc_html__( 'Placeholder for 3rd Location Field', 'framework' ),
				'type' 		=> 'text',
				'section' 	=> 'inspiry_search_form_locations',
				'active_callback' => 'inspiry_ajax_location_field'
			) );

			/* 4th Location Box Title */
			$wp_customize->add_setting( 'theme_location_title_4', array(
				'type' 				=> 'option',
				'transport'			=> 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'theme_location_title_4', array(
				'label' 		=> esc_html__( 'Title for 4th Location Select Box', 'framework' ),
				'description' 	=> esc_html__( 'Example: Area', 'framework' ),
				'type' 			=> 'text',
				'section' 		=> 'inspiry_search_form_locations',
				'active_callback' => 'inspiry_ajax_location_field'
			) );

			$wp_customize->add_setting( 'inspiry_location_placeholder_4', array(
				'type' 				=> 'option',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_location_placeholder_4', array(
				'label' 	=> esc_html__( 'Placeholder for 4th Location Field', 'framework' ),
				'type' 		=> 'text',
				'section' 	=> 'inspiry_search_form_locations',
				'active_callback' => 'inspiry_ajax_location_field'
			) );
		}

		// Setting to hide empty locations
		$wp_customize->add_setting( 'inspiry_hide_empty_locations', array(
			'type' 		=> 'option',
			'default' 	=> 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_hide_empty_locations', array(
			'label' 		=> esc_html__( 'Hide Empty Locations ?', 'framework' ),
			'description' 	=> esc_html__( 'Optimize Locations by hiding the ones with zero property.', 'framework' ),
			'type' 			=> 'radio',
			'section' 		=> 'inspiry_search_form_locations',
			'choices' 		=> array(
				'true' 		=> esc_html__( 'Yes', 'framework' ),
				'false' 	=> esc_html__( 'No', 'framework' ),
			),
		) );

		// To enable dynamic location feature
		$wp_customize->add_setting( 'inspiry_ajax_location_field', array(
			'type'              => 'option',
			'default'           => 'no',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_ajax_location_field', array(
			'label'   => esc_html__( 'Enable Dynamic Location Field', 'framework' ),
			'description' 	=> esc_html__( 'It is recommended for large number of locations. As it will allow search through all locations, but list 15 locations non-hierarchically in start and 15 more with each last scroll till all locations are listed.', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_search_form_locations',
			'choices' => array(
				'yes' => esc_html__( 'Yes', 'framework' ),
				'no'  => esc_html__( 'No', 'framework' ),
			),
		) );

		$wp_customize->add_setting(
			'inspiry_search_form_multiselect_locations', array(
				'type'              => 'option',
				'default'           => 'yes',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control( 'inspiry_search_form_multiselect_locations', array(
			'label'       => esc_html__( 'Enable Multi Select For Locations Field? ', 'framework' ),
			'description' => esc_html__( 'Enabled for ( Dynamic Location ) or when ( Number of Location Select Boxes is equal to 1 )', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_search_form_locations',
			'choices'     => array(
				'yes'  => esc_html__( 'Yes', 'framework' ),
				'no'  => esc_html__( 'No', 'framework' ),
			),
		) );

	}

	add_action( 'customize_register', 'inspiry_search_form_locations_customizer' );
endif;


if ( ! function_exists( 'inspiry_search_form_locations_defaults' ) ) :

	/**
	 * inspiry_search_form_locations_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_search_form_locations_defaults( WP_Customize_Manager $wp_customize ) {
		$search_form_locations_settings_ids = array(
			'theme_location_select_number',
			'inspiry_hide_empty_locations',
		);
		inspiry_initialize_defaults( $wp_customize, $search_form_locations_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_search_form_locations_defaults' );
endif;

if ( ! function_exists( 'inspiry_ajax_location_field' ) ) {
	/**
	 * Check if Ajax feature is enabled for the search location field
	 *
	 * @param $control
	 *
	 * @return bool
	 */
	function inspiry_ajax_location_field( $control ) {

		if ( 'yes' === $control->manager->get_setting( 'inspiry_ajax_location_field' )->value() ) {
			return false;
		}

		return true;
	}
}
if ( ! function_exists( 'inspiry_ajax_location_field_display' ) ) {
	/**
	 * Display field if Ajax feature is enabled for the search location field
	 *
	 * @param $control
	 *
	 * @return bool
	 */
	function inspiry_ajax_location_field_display( $control ) {

		if ( 'yes' === $control->manager->get_setting( 'inspiry_ajax_location_field' )->value() ) {
			return true;
		}

		return false;
	}
}