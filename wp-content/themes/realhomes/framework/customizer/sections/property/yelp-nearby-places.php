<?php
/**
 * Section:    `Yelp Nearby Places`
 * Panel:    `Property Detail Page`
 *
 * @since 3.9.6
 */

if ( ! function_exists( 'inspiry_property_yelp_customizer' ) ) :

	/**
	 * inspiry_property_yelp_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  3.9.6
	 */
	function inspiry_property_yelp_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Yelp Nearby Places Section
		 */
		$wp_customize->add_section( 'inspiry_property_yelp', array(
			'title'    => esc_html__( 'Yelp Nearby Places', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 13
		) );

		/* Show/Hide Yelp Nearby Places Section */
		$wp_customize->add_setting( 'inspiry_display_yelp_nearby_places', array(
			'type'              => 'option',
			'default'           => 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_display_yelp_nearby_places', array(
			'label'   => esc_html__( 'Nearby Places', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_yelp',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Yelp API */
		$wp_customize->add_setting( 'inspiry_yelp_api_key', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_yelp_api_key', array(
			'label'       => esc_html__( 'API Key', 'framework' ),
			'description' => wp_kses( __( 'Click here to get your <a target="_blank" href="https://www.yelp.com/developers/v3/manage_app">Yelp API Key</a>', 'framework' ), array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
					)
				)
			),
			'type'        => 'text',
			'section'     => 'inspiry_property_yelp',
		) );

		/* Yelp Nearby Places Title */
		$wp_customize->add_setting( 'inspiry_property_yelp_nearby_places_title', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'What\'s Nearby?', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_property_yelp_nearby_places_title', array(
			'label'   => esc_html__( 'Section Title', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_property_yelp',
		) );

		$yelp_title_selector = '.yelp-wrap .yelp-label';
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$yelp_title_selector = '.rh_property__yelp_wrap .rh_property__heading';
		}

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_property_yelp_nearby_places_title', array(
				'selector'            => $yelp_title_selector,
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_property_yelp_nearby_places_title_render',
			) );
		}

		/* Yelp Distance Unit */
		$wp_customize->add_setting( 'inspiry_yelp_distance_unit', array(
			'type'              => 'option',
			'default'           => 'mi',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_yelp_distance_unit', array(
			'label'   => esc_html__( 'Distance Unit', 'framework' ),
			'section' => 'inspiry_property_yelp',
			'type'    => 'select',
			'choices' => array(
				'mi' => esc_html__( 'Miles', 'framework' ),
				'km' => esc_html__( 'Kilometers', 'framework' ),
			),
		) );

		/* Yelp Search Result Limit */
		$wp_customize->add_setting( 'inspiry_yelp_search_limit', array(
			'type'              => 'option',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_yelp_search_limit', array(
			'label'   => esc_html__( 'Search Results Limit', 'framework' ),
			'section' => 'inspiry_property_yelp',
			'type'    => 'text',
		) );


		/* Yelp Preset Terms */
		$wp_customize->add_setting( 'inspiry_yelp_terms', array(
			'type'              => 'option',
			'default'           => array( 'education', 'realestate', 'health' ),
			'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
		) );
		$wp_customize->add_control( new Inspiry_Multiple_Checkbox_Customize_Control( $wp_customize, 'inspiry_yelp_terms', array(
				'section' => 'inspiry_property_yelp',
				'label'   => esc_html__( 'Select Terms', 'framework' ),
				'choices' => array(
					'active'             => esc_html__( 'Active Life', 'framework' ),
					'arts'               => esc_html__( 'Arts & Entertainment', 'framework' ),
					'auto'               => esc_html__( 'Automotive', 'framework' ),
					'beautysvc'          => esc_html__( 'Beauty & Spas', 'framework' ),
					'education'          => esc_html__( 'Education', 'framework' ),
					'eventservices'      => esc_html__( 'Event Planning & Services', 'framework' ),
					'financialservices'  => esc_html__( 'Financial Services', 'framework' ),
					'food'               => esc_html__( 'Food', 'framework' ),
					'health'             => esc_html__( 'Health & Medical', 'framework' ),
					'homeservices'       => esc_html__( 'Home Services ', 'framework' ),
					'hotelstravel'       => esc_html__( 'Hotels & Travel', 'framework' ),
					'localflavor'        => esc_html__( 'Local Flavor', 'framework' ),
					'localservices'      => esc_html__( 'Local Services', 'framework' ),
					'massmedia'          => esc_html__( 'Mass Media', 'framework' ),
					'nightlife'          => esc_html__( 'Nightlife', 'framework' ),
					'pets'               => esc_html__( 'Pets', 'framework' ),
					'professional'       => esc_html__( 'Professional Services', 'framework' ),
					'publicservicesgovt' => esc_html__( 'Public Services & Government', 'framework' ),
					'realestate'         => esc_html__( 'Real Estate', 'framework' ),
					'religiousorgs'      => esc_html__( 'Religious Organizations', 'framework' ),
					'restaurants'        => esc_html__( 'Restaurants', 'framework' ),
					'shopping'           => esc_html__( 'Shopping', 'framework' ),
					'transport'          => esc_html__( 'Transportation', 'framework' ),
				),
			)
		) );
	}

	add_action( 'customize_register', 'inspiry_property_yelp_customizer' );
endif;


if ( ! function_exists( 'inspiry_property_yelp_defaults' ) ) :

	/**
	 * inspiry_property_yelp_defaults.
	 *
	 * @since  3.9.6
	 */
	function inspiry_property_yelp_defaults( WP_Customize_Manager $wp_customize ) {
		$property_yelp_settings_ids = array(
			'inspiry_display_yelp_nearby_places',
			'inspiry_property_yelp_nearby_places_title',
			'inspiry_yelp_distance_unit',
			'inspiry_yelp_search_limit',
			'inspiry_yelp_terms',
		);
		inspiry_initialize_defaults( $wp_customize, $property_yelp_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_property_yelp_defaults' );
endif;


if ( ! function_exists( 'inspiry_property_yelp_nearby_places_title_render' ) ) {
	function inspiry_property_yelp_nearby_places_title_render() {
		if ( get_option( 'inspiry_property_yelp_nearby_places_title' ) ) {
			echo get_option( 'inspiry_property_yelp_nearby_places_title' );
		}
	}
}