<?php
/**
 * Properties Templates and Archive Pages Settings
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_templates_and_archive_customizer' ) ) :
	function inspiry_templates_and_archive_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Properties Templates and Taxonomy Archives Section
		 */
		$wp_customize->add_section( 'inspiry_properties_templates_and_archive', array(
			'title'    => esc_html__( 'Properties Templates & Archive', 'framework' ),
			'priority' => 124,
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Header Banner or None */
			$wp_customize->add_setting( 'inspiry_listing_header_variation', array(
				'type'              => 'option',
				'default'           => 'banner',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'inspiry_listing_header_variation', array(
				'label'       => esc_html__( 'Header Variation', 'framework' ),
				'description' => esc_html__( 'For properties templates and taxonomy archive pages.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_properties_templates_and_archive',
				'choices'     => array(
					'banner' => esc_html__( 'Banner', 'framework' ),
					'none'   => esc_html__( 'None', 'framework' ),
				),
			) );
		}

		/* Module Below Header  */
		$wp_customize->add_setting( 'theme_listing_module', array(
			'type'              => 'option',
			'default'           => 'simple-banner',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_control( 'theme_listing_module', array(
				'label'       => esc_html__( 'Module Below Header', 'framework' ),
				'description' => esc_html__( 'What to display in area below header on properties templates and taxonomy archive pages?', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_properties_templates_and_archive',
				'choices'     => array(
					'properties-map' => esc_html__( 'Map With Properties Markers', 'framework' ),
					'simple-banner'  => esc_html__( 'Image Banner', 'framework' ),
				),
			) );
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_control( 'theme_listing_module', array(
				'label'       => esc_html__( 'Module Below Header', 'framework' ),
				'description' => esc_html__( 'What to display in area below header on properties templates and taxonomy archive pages?', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_properties_templates_and_archive',
				'choices'     => array(
					'properties-map' => esc_html__( 'Map with Properties Markers', 'framework' ),
					'simple-banner'  => esc_html__( 'None', 'framework' ),
				),
			) );
		}

		$map_type = inspiry_get_maps_type();
		if ( 'google-maps' == $map_type ) {

			/* Google Map Type */
			$wp_customize->add_setting( 'inspiry_list_tax_map_type', array(
				'type'              => 'option',
				'default'           => 'roadmap',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'inspiry_list_tax_map_type', array(
				'label'           => esc_html__( 'Google Map Type', 'framework' ),
				'type'            => 'select',
				'section'         => 'inspiry_properties_templates_and_archive',
				'choices'         => array(
					'roadmap'   => esc_html__( 'RoadMap', 'framework' ),
					'satellite' => esc_html__( 'Satellite', 'framework' ),
					'hybrid'    => esc_html__( 'Hybrid', 'framework' ),
					'terrain'   => esc_html__( 'Terrain', 'framework' ),
				),
				'active_callback' => 'inspiry_listing_map_enabled',
			) );
		}

		// Skip Sticky Properties Option.
		$wp_customize->add_setting( 'inspiry_listing_skip_sticky', array(
			'type'              => 'option',
			'default'           => false,
			'sanitize_callback' => 'inspiry_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'inspiry_listing_skip_sticky', array(
			'label'       => esc_html__( 'Check to Skip Sticky Properties on Properties Templates. (Not Recommended)', 'framework' ),
			'section'     => 'inspiry_properties_templates_and_archive',
			'type'        => 'checkbox',
		) );

		$wp_customize->add_setting( 'inspiry_section_label_properties_archives', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control( new Inspiry_Heading_Customize_Control(
			$wp_customize,
			'inspiry_section_label_properties_archives',
			array(
				'label'   => esc_html__( 'Archive Pages', 'framework' ),
				'section' => 'inspiry_properties_templates_and_archive',
			)
		) );

		// Layout
		$wp_customize->add_setting( 'theme_listing_layout', array(
			'type'              => 'option',
			'default'           => 'list',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_listing_layout', array(
			'label'       => esc_html__( 'Default Layout for Archive Pages', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_properties_templates_and_archive',
			'choices'     => array(
				'list' => esc_html__( 'List', 'framework' ),
				'grid' => esc_html__( 'Grid', 'framework' ),
			),
		) );

		// Number of Properties
		$wp_customize->add_setting( 'theme_number_of_properties', array(
			'type'              => 'option',
			'default'           => '3',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_number_of_properties', array(
			'label'       => esc_html__( 'Max Number of Properties on a Page', 'framework' ),
			'description' => esc_html__( 'Can be overridden for templates through page metabox.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_properties_templates_and_archive',
			'choices'     => array(
				'1'  => 1,
				'2'  => 2,
				'3'  => 3,
				'4'  => 4,
				'5'  => 5,
				'6'  => 6,
				'7'  => 7,
				'8'  => 8,
				'9'  => 9,
				'10' => 10,
				'11' => 11,
				'12' => 12,
				'13' => 13,
				'14' => 14,
				'15' => 15,
				'16' => 16,
				'17' => 17,
				'18' => 18,
				'19' => 19,
				'20' => 20,
			),
		) );

		// Default Sort Order
		$wp_customize->add_setting( 'theme_listing_default_sort', array(
			'type'              => 'option',
			'default'           => 'date-desc',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'theme_listing_default_sort', array(
			'label'       => esc_html__( 'Default Sort Order', 'framework' ),
			'description' => esc_html__( 'For Search Results, Properties Templates and Taxonomy Archive pages.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_properties_templates_and_archive',
			'choices'     => array(
				'price-asc'  => esc_html__( 'Price - Low to High', 'framework' ),
				'price-desc' => esc_html__( 'Price - High to Low', 'framework' ),
				'date-asc'   => esc_html__( 'Date - Old to New', 'framework' ),
				'date-desc'  => esc_html__( 'Date - New to Old', 'framework' ),
			),
		) );

		// Term Description
		$wp_customize->add_setting( 'inspiry_term_description', array(
			'type'              => 'option',
			'default'           => 'show',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_term_description', array(
			'label'       => esc_html__( 'Taxonomy Term Description', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_properties_templates_and_archive',
			'choices'     => array(
				'show' => esc_html__( 'Show', 'framework' ),
				'hide' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		// number of properties to display on map
		$wp_customize->add_setting(
			'inspiry_properties_list_tax_on_map',
			array(
				'type'              => 'option',
				'default'           => 'all',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_properties_list_tax_on_map', array(
				'label'   => esc_html__( 'Number of Properties to Mark on Map?', 'framework' ),
				'section' => 'inspiry_properties_templates_and_archive',
				'type'    => 'radio',
				'choices' => array(
					'all'            => esc_html__( 'All Found', 'framework' ),
					'as_on_one_page' => esc_html__( 'As on One Page', 'framework' ),
				),
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'inspiry_section_label_properties_cards', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control( new Inspiry_Heading_Customize_Control(
				$wp_customize,
				'inspiry_section_label_properties_cards',
				array(
					'label'   => esc_html__( 'Property Card', 'framework' ),
					'section' => 'inspiry_properties_templates_and_archive',
				)
			) );

			$wp_customize->add_setting(
				'inspiry_property_card_variation',
				array(
					'type'              => 'option',
					'default'           => '1',
					'sanitize_callback' => 'inspiry_sanitize_select',
				)
			);
			$wp_customize->add_control( 'inspiry_property_card_variation', array(
					'section' => 'inspiry_properties_templates_and_archive',
					'type'    => 'select',
					'label'   => esc_html__( 'Grid Layout Property Card Design', 'framework' ),
					'choices' => array(
						'1' => esc_html__( 'One', 'framework' ),
						'2' => esc_html__( 'Two', 'framework' ),
						'3' => esc_html__( 'Three', 'framework' ),
					),
				)
			);

			$wp_customize->add_setting( 'theme_listing_excerpt_length', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( 'theme_listing_excerpt_length', array(
				'label'       => esc_html__( 'Excerpt Length for Property Card', 'framework' ),
				'description' => esc_html__( 'Leave empty for default behaviour.', 'framework' ),
				'type'        => 'number',
				'section'     => 'inspiry_properties_templates_and_archive',
				'settings'    => 'theme_listing_excerpt_length',
			) );


			$wp_customize->add_setting( 'inspiry_property_date_format', array(
				'type'              => 'option',
				'default'           => 'dashboard',
				'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
			) );
			$wp_customize->add_control( 'inspiry_property_date_format', array(
				'section' => 'inspiry_properties_templates_and_archive',
				'type'    => 'select',
				'label'   => esc_html__( 'Select Date Format', 'framework' ),
				'choices' => array(
					'dashboard' => esc_html__( 'Default ( Dashboard > Settings > General )', 'framework' ),
					'human'     => esc_html__( 'Human Readable', 'framework' ),
				),
			) );

			$wp_customize->add_setting(
				'inspiry_address_lightbox_enable',
				array(
					'type'              => 'option',
					'default'           => 'enable',
					'sanitize_callback' => 'inspiry_sanitize_radio',
				)
			);
			$wp_customize->add_control(
				'inspiry_address_lightbox_enable', array(
					'label'   => esc_html__( 'Enable Map Lightbox On Address Click', 'framework' ),
					'section' => 'inspiry_properties_templates_and_archive',
					'type'    => 'radio',
					'choices' => array(
						'enable'  => esc_html__( 'Enable', 'framework' ),
						'disable' => esc_html__( 'Disable', 'framework' ),
					),
				)
			);

			$get_stored_order = get_option( 'inspiry_property_card_meta' );

			if ( inspiry_is_rvr_enabled() ) {
				$meta_fields = array(
					'bedrooms'   => esc_html__( 'Bedrooms', 'framework' ),
					'bathrooms'  => esc_html__( 'Bathrooms', 'framework' ),
					'area'       => esc_html__( 'Area', 'framework' ),
					'garage'     => esc_html__( 'Garages/Parking', 'framework' ),
					'year-built' => esc_html__( 'Year Built', 'framework' ),
					'lot-size'   => esc_html__( 'Lot Size', 'framework' ),
					'guests'     => esc_html__( 'Guests Capacity', 'framework' ),
					'min-stay'   => esc_html__( 'Min Stay', 'framework' ),
				);
			} else {

				$meta_fields = array(
					'bedrooms'   => esc_html__( 'Bedrooms', 'framework' ),
					'bathrooms'  => esc_html__( 'Bathrooms', 'framework' ),
					'area'       => esc_html__( 'Area', 'framework' ),
					'garage'     => esc_html__( 'Garages/Parking', 'framework' ),
					'year-built' => esc_html__( 'Year Built', 'framework' ),
					'lot-size'   => esc_html__( 'Lot Size', 'framework' ),
				);
			}

			$meta_fields = apply_filters( 'inspiry_sort_meta_label', $meta_fields );

			if ( ! empty( $get_stored_order ) && is_array( $get_stored_order ) ) {
				$unique_fields = array_intersect_key( array_flip( $get_stored_order ), $meta_fields );
				$meta_fields   = array_merge( $unique_fields, $meta_fields );
			}

			if ( inspiry_is_rvr_enabled() ) {
				$default_meta_labels = array( 'bedrooms', 'bathrooms', 'area', 'guests' );
			} else {
				$default_meta_labels = array( 'bedrooms', 'bathrooms', 'area' );
			}

			$wp_customize->add_setting(
				'inspiry_property_card_meta',
				array(
					'type'              => 'option',
					'default'           => $default_meta_labels,
					'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
				)
			);
			$wp_customize->add_control(
				new Inspiry_Multiple_Checkbox_Customize_Control_sortable(
					$wp_customize,
					'inspiry_property_card_meta',
					array(
						'section' => 'inspiry_properties_templates_and_archive',
						'label'   => esc_html__( 'Select & Sort Property Card Meta', 'framework' ),
						'choices' => $meta_fields,
					)
				)
			);

		}

	}

	add_action( 'customize_register', 'inspiry_templates_and_archive_customizer' );
endif;


if ( ! function_exists( 'inspiry_templates_and_archive_defaults' ) ) :
	/**
	 * Set default values for properties templates and taxonomy settings
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function inspiry_templates_and_archive_defaults( WP_Customize_Manager $wp_customize ) {
		$templates_and_archive_settings_ids = array(
			'inspiry_listing_header_variation',
			'theme_listing_module',
			'theme_listing_layout',
			'theme_number_of_properties',
			'theme_listing_default_sort',
		);
		inspiry_initialize_defaults( $wp_customize, $templates_and_archive_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_templates_and_archive_defaults' );
endif;


if ( ! function_exists( 'inspiry_listing_map_enabled' ) ) {
	/**
	 * Check if Listing & Taxonomy pages map is enabled
	 *
	 * @param $control
	 *
	 * @return bool
	 */
	function inspiry_listing_map_enabled( $control ) {
		if ( 'properties-map' === $control->manager->get_setting( 'theme_listing_module' )->value() ) {
			return true;
		} else {
			return false;
		}
	}
}