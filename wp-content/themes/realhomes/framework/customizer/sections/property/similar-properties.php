<?php
/**
 * Section:    `Similar Properties`
 * Panel:    `Property Detail Page`
 *
 * @since 2.6.3
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_similar_properties_customizer' ) ) :

	/**
	 * inspiry_similar_properties_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  2.6.3
	 */
	function inspiry_similar_properties_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Similar Properties Section
		 */
		$wp_customize->add_section( 'inspiry_property_similar', array(
			'title'    => esc_html__( 'Similar Properties', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 19
		) );

		/* Show/Hide Similar */
		$wp_customize->add_setting( 'theme_display_similar_properties', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_display_similar_properties', array(
			'label'   => esc_html__( 'Similar Properties', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_similar',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Similar Properties Title */
		$wp_customize->add_setting( 'theme_similar_properties_title', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Similar Properties', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_similar_properties_title', array(
			'label'   => esc_html__( 'Similar Properties Title', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_property_similar',
		) );

		/* Number of Similar Properties  */
		$default_number_of_similar_properties = 3;
		$number_of_similar_properties_choices = array(
			'1' => 1,
			'2' => 2,
			'3' => 3,
			'4' => 4,
			'5' => 5,
			'6' => 6,
		);
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_number_of_similar_properties = 2;
			$number_of_similar_properties_choices = array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
			);
		}
		$wp_customize->add_setting( 'theme_number_of_similar_properties', array(
			'type'              => 'option',
			'default'           => $default_number_of_similar_properties,
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_number_of_similar_properties', array(
			'label'   => esc_html__( 'Number of Similar Properties', 'framework' ),
			'type'    => 'select',
			'section' => 'inspiry_property_similar',
			'choices' => $number_of_similar_properties_choices,
		) );

		/* Similar Properties Title Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$similar_properties_selector = '.detail .list-container h3';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$similar_properties_selector = '.rh_property__similar_properties .rh_property__heading';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_similar_properties_title', array(
				'selector'            => $similar_properties_selector,
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_similar_properties_title_render',
			) );
		}

		// Similar Properties Filters
		$similar_properties_filters = array(
			'property-feature' => esc_html__( 'Property Features', 'framework' ),
			'property-type'    => esc_html__( 'Property Type', 'framework' ),
			'property-city'    => esc_html__( 'Property Location', 'framework' ),
			'property-status'  => esc_html__( 'Property Status', 'framework' ),
			'property-agent'   => esc_html__( 'Agent', 'framework' ),
		);

		// Properties for Similar Properties section
		$wp_customize->add_setting( 'inspiry_similar_properties', array(
			'type'              => 'option',
			'default'           => array( 'property-type', 'property-city' ),
			'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
		) );
		$wp_customize->add_control(
			new Inspiry_Multiple_Checkbox_Customize_Control(
				$wp_customize,
				'inspiry_similar_properties',
				array(
					'section' => 'inspiry_property_similar',
					'label'   => esc_html__( 'Show Similar Properties Based on', 'framework' ),
					'choices' => $similar_properties_filters,
				)
			)
		);

		// Frontend Similar Properties Filters
		$wp_customize->add_setting( 'inspiry_similar_properties_frontend_filters', array(
			'type'              => 'option',
			'default'           => 'disable',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_similar_properties_frontend_filters', array(
			'label'   => esc_html__( 'Similar Properties Filters on Frontend', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_similar',
			'choices' => array(
				'enable'  => esc_html__( 'Enable', 'framework' ),
				'disable' => esc_html__( 'Disable', 'framework' ),
			),
		) );

		// Selection of Similar Properties Filters
		$wp_customize->add_setting( 'inspiry_similar_properties_filters', array(
			'type'              => 'option',
			'default'           => array_keys( $similar_properties_filters ),
			'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
		) );
		$wp_customize->add_control(
			new Inspiry_Multiple_Checkbox_Customize_Control(
				$wp_customize,
				'inspiry_similar_properties_filters',
				array(
					'section' => 'inspiry_property_similar',
					'label'   => esc_html__( 'Select Filters to Show on Frontend', 'framework' ),
					'choices' => $similar_properties_filters,
				)
			)
		);

		// Properties for Similar Properties section
		$wp_customize->add_setting( 'inspiry_similar_properties_sorty_by', array(
			'type'              => 'option',
			'default'           => 'random',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_similar_properties_sorty_by', array(
			'label'   => esc_html__( 'Sort Properties By', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_property_similar',
			'choices' => array(
				'recent'      => esc_html__( 'Time - Recent First', 'framework' ),
				'low-to-high' => esc_html__( 'Price - Low to High', 'framework' ),
				'high-to-low' => esc_html__( 'Price - High to Low', 'framework' ),
				'random'      => esc_html__( 'Random', 'framework' ),
			),
		) );

	}

	add_action( 'customize_register', 'inspiry_similar_properties_customizer' );
endif;


if ( ! function_exists( 'inspiry_similar_properties_defaults' ) ) :

	/**
	 * inspiry_similar_properties_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_similar_properties_defaults( WP_Customize_Manager $wp_customize ) {
		$similar_properties_settings_ids = array(
			'theme_display_similar_properties',
			'theme_similar_properties_title',
			'theme_number_of_similar_properties',
			'inspiry_similar_properties',
			'inspiry_similar_properties_sorty_by',
			'inspiry_similar_properties_frontend_filters',
			'inspiry_similar_properties_filters',
		);
		inspiry_initialize_defaults( $wp_customize, $similar_properties_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_similar_properties_defaults' );
endif;


if ( ! function_exists( 'inspiry_similar_properties_title_render' ) ) {
	function inspiry_similar_properties_title_render() {
		if ( get_option( 'theme_similar_properties_title' ) ) {
			echo esc_html( get_option( 'theme_similar_properties_title' ) );
		}
	}
}
