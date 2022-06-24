<?php
/**
 * Section: `Basics`
 * Panel:   `Property Detail Page`
 *
 * @package realhomes/customizer
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_property_basics_customizer' ) ) :

	/**
	 * inspiry_property_basics_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @since  2.6.3
	 */
	function inspiry_property_basics_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Basics Section
		 */
		$wp_customize->add_section(
			'inspiry_property_basics', array(
				'title' => esc_html__( 'Basics', 'framework' ),
				'panel' => 'inspiry_property_panel',
				'priority' => 4
			)
		);

		/* Property Detail Page Template */
		$wp_customize->add_setting( 'inspiry_property_single_template', array(
			'type'              => 'option',
			'default'           => 'sidebar',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_property_single_template', array(
			'label'       => esc_html__( 'Page Template for All Properties', 'framework' ),
			'description' => esc_html__( 'You can override this for a specific property using template in page attributes metabox.', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_property_basics',
			'choices'     => array(
				'sidebar' => esc_html__( 'Sidebar Template', 'framework' ),
				'fullwidth' => esc_html__( 'Full Width Template', 'framework' ),
			),
		) );

		/* Require Login to Display Property Detail */
		$wp_customize->add_setting(
			'inspiry_prop_detail_login', array(
				'type'              => 'option',
				'default'           => 'no',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_prop_detail_login', array(
				'label'   => esc_html__( 'Require Login to Display Property Detail', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_basics',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'framework' ),
					'no'  => esc_html__( 'No', 'framework' ),
				),
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Header Variation */
			$wp_customize->add_setting(
				'inspiry_property_detail_header_variation', array(
					'type'              => 'option',
					'default'           => 'banner',
					'sanitize_callback' => 'inspiry_sanitize_radio',
				)
			);

			$wp_customize->add_control(
				'inspiry_property_detail_header_variation', array(
					'label'       => esc_html__( 'Header Variation', 'framework' ),
					'description' => esc_html__( 'Header variation to display on Property Detail Page.', 'framework' ),
					'type'        => 'radio',
					'section'     => 'inspiry_property_basics',
					'choices'     => array(
						'banner' => esc_html__( 'Banner', 'framework' ),
						'none'   => esc_html__( 'None', 'framework' ),
					),
				)
			);
		}

		/* Property Ratings */
		$wp_customize->add_setting(
			'inspiry_property_ratings', array(
				'type'              => 'option',
				'default'           => 'false',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_property_ratings', array(
				'label'   => esc_html__( 'Property Ratings', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_basics',
				'choices' => array(
					'true'  => esc_html__( 'Enable', 'framework' ),
					'false' => esc_html__( 'Disable', 'framework' ),
				),
			)
		);

		/* Display Property Address */
		$wp_customize->add_setting(
			'inspiry_display_property_address', array(
				'type'              => 'option',
				'default'           => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_display_property_address', array(
				'label'   => esc_html__( 'Property Address', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_basics',
				'choices' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
			)
		);

		/* Separator */
		$wp_customize->add_setting( 'inspiry_property_field_titles_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_property_field_titles_separator',
				array(
					'section' => 'inspiry_property_basics',
				)
			)
		);


		/* Property ID Field Title  */
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting(
				'inspiry_prop_id_field_label', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_prop_id_field_label', array(
					'label'       => esc_html__( 'Property ID Label', 'framework' ),
					'description' => esc_html__( 'This will overwrite the Property ID label.', 'framework' ),
					'type'        => 'text',
					'section'     => 'inspiry_property_basics',
				)
			);
		}

		/* Bedrooms Field Title  */
		$wp_customize->add_setting(
			'inspiry_bedrooms_field_label', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_bedrooms_field_label', array(
				'label'       => esc_html__( 'Bedrooms field label', 'framework' ),
				'description' => esc_html__( 'This will overwrite the bedrooms field label.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_property_basics',
			)
		);

		/* Bathrooms Field Title  */
		$wp_customize->add_setting(
			'inspiry_bathrooms_field_label', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_bathrooms_field_label', array(
				'label'       => esc_html__( 'Bathrooms field label', 'framework' ),
				'description' => esc_html__( 'This will overwrite the bathrooms field label.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_property_basics',
			)
		);


		if ( inspiry_is_rvr_enabled() ) {

			$wp_customize->add_setting(
				'inspiry_rvr_min_stay_label', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_rvr_min_stay_label', array(
					'label'       => esc_html__( 'Minimum Stay', 'framework' ),
					'description' => esc_html__( 'This will overwrite the minimum stay field label.', 'framework' ),
					'type'        => 'text',
					'section'     => 'inspiry_property_basics',
				)
			);

			$wp_customize->add_setting(
				'inspiry_rvr_guests_field_label', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_rvr_guests_field_label', array(
					'label'       => esc_html__( 'Guests Capacity', 'framework' ),
					'description' => esc_html__( 'This will overwrite the guests capacity field label.', 'framework' ),
					'type'        => 'text',
					'section'     => 'inspiry_property_basics',
				)
			);
		}


		/* Garages Field Title  */
		$wp_customize->add_setting(
			'inspiry_garages_field_label', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_garages_field_label', array(
				'label'       => esc_html__( 'Garages field label', 'framework' ),
				'description' => esc_html__( 'This will overwrite the garages field label.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_property_basics',
			)
		);

		/* Area Field Title  */
		$wp_customize->add_setting(
			'inspiry_area_field_label', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_area_field_label', array(
				'label'       => esc_html__( 'Area field label', 'framework' ),
				'description' => esc_html__( 'This will overwrite the area field label.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_property_basics',
			)
		);

		/* Year Built Field Title  */
		$wp_customize->add_setting(
			'inspiry_year_built_field_label', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_year_built_field_label', array(
				'label'       => esc_html__( 'Year Built field label', 'framework' ),
				'description' => esc_html__( 'This will overwrite the year-built field label.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_property_basics',
			)
		);

		/* Lot Size Field Title  */
		$wp_customize->add_setting(
			'inspiry_lot_size_field_label', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_lot_size_field_label', array(
				'label'       => esc_html__( 'Lot Size field label', 'framework' ),
				'description' => esc_html__( 'This will overwrite the lot-size field label.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_property_basics',
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Separator */
			$wp_customize->add_setting( 'inspiry_property_share_titles_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Separator_Control(
					$wp_customize,
					'inspiry_property_share_titles_separator',
					array(
						'section' => 'inspiry_property_basics',
					)
				)
			);

			$wp_customize->add_setting(
				'inspiry_share_property_label', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_share_property_label', array(
					'label'       => esc_html__( 'Share Label', 'framework' ),
					'description' => esc_html__( 'This will overwrite the share label.', 'framework' ),
					'type'        => 'text',
					'section'     => 'inspiry_property_basics',
				)
			);

			$wp_customize->add_setting(
				'inspiry_add_to_fav_property_label', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_add_to_fav_property_label', array(
					'label'       => esc_html__( 'Favourite Label', 'framework' ),
					'description' => esc_html__( 'This will overwrite the Favourite label.', 'framework' ),
					'type'        => 'text',
					'section'     => 'inspiry_property_basics',
				)
			);
			$wp_customize->add_setting(
				'inspiry_added_to_fav_property_label', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_added_to_fav_property_label', array(
					'label'       => esc_html__( 'Added To Favourite Label', 'framework' ),
					'description' => esc_html__( 'This will overwrite the Added To Favourite label.', 'framework' ),
					'type'        => 'text',
					'section'     => 'inspiry_property_basics',
				)
			);
			$wp_customize->add_setting(
				'inspiry_print_property_label', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_print_property_label', array(
					'label'       => esc_html__( 'Print Label', 'framework' ),
					'description' => esc_html__( 'This will overwrite the Print label.', 'framework' ),
					'type'        => 'text',
					'section'     => 'inspiry_property_basics',
				)
			);

		}

		/* Separator */
		$wp_customize->add_setting( 'theme_additional_details_title_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'theme_additional_details_title_separator',
				array(
					'section' => 'inspiry_property_basics',
				)
			)
		);


		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting(
				'inspiry_description_property_label', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_description_property_label', array(
					'label'       => esc_html__( 'Description Title', 'framework' ),
					'description' => esc_html__( 'This will overwrite the Description title.', 'framework' ),
					'type'        => 'text',
					'section'     => 'inspiry_property_basics',
				)
			);
		}


		/* Additional Detail Title  */
		$wp_customize->add_setting(
			'theme_additional_details_title', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Additional Details', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'theme_additional_details_title', array(
				'label'       => esc_html__( 'Additional Details Title', 'framework' ),
				'description' => esc_html__( 'This will only display if a property has additional details.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_property_basics',
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial(
					'theme_additional_details_title', array(
						'selector'            => '.rh_property__additional_details',
						'container_inclusive' => false,
						'render_callback'     => 'theme_additional_details_title_render',
					)
				);
			}
		}

		/* Features Title  */
		$wp_customize->add_setting(
			'theme_property_features_title', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Features', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'theme_property_features_title', array(
				'label'   => esc_html__( 'Features Title', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_property_basics',
			)
		);

		/* Features Items Display  */
		$wp_customize->add_setting('inspiry_property_features_display', array(
				'type'              => 'option',
				'default'           => 'link',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control('inspiry_property_features_display', array(
				'label'   => esc_html__( 'Property Features Display', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_basics',
				'choices' => array(
					'link'   => esc_html__( 'Link to Archive', 'framework' ),
					'plain'  => esc_html__( 'Plain Text', 'framework' ),
				),
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial(
					'theme_property_features_title', array(
						'selector'            => '.rh_property__features_wrap .rh_property__heading',
						'container_inclusive' => false,
						'render_callback'     => 'theme_property_features_title_render',
					)
				);
			}
		}

		/* Add/Remove  Open Graph Meta Tags */
		$wp_customize->add_setting(
			'theme_add_meta_tags', array(
				'type'              => 'option',
				'default'           => 'false',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'theme_add_meta_tags', array(
				'label'   => esc_html__( 'Open Graph Meta Tags', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_basics',
				'choices' => array(
					'true'  => esc_html__( 'Enable', 'framework' ),
					'false' => esc_html__( 'Disable', 'framework' ),
				),
			)
		);

		/* Link to Previous and Next Property */
		$wp_customize->add_setting(
			'inspiry_property_prev_next_link', array(
				'type'              => 'option',
				'default'           => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_property_prev_next_link', array(
				'label'   => esc_html__( 'Link to Previous and Next Property', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_basics',
				'choices' => array(
					'true'  => esc_html__( 'Enable', 'framework' ),
					'false' => esc_html__( 'Disable', 'framework' ),
				),
			)
		);
	}

	add_action( 'customize_register', 'inspiry_property_basics_customizer' );
endif;


if ( ! function_exists( 'inspiry_property_basics_defaults' ) ) :

	/**
	 * inspiry_property_basics_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_property_basics_defaults( WP_Customize_Manager $wp_customize ) {
		$property_basics_settings_ids = array(
			'inspiry_property_single_template',
			'inspiry_property_detail_header_variation',
			'theme_additional_details_title',
			'theme_property_features_title',
			'theme_add_meta_tags',
			'inspiry_property_prev_next_link',
			'inspiry_property_ratings',
		);
		inspiry_initialize_defaults( $wp_customize, $property_basics_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_property_basics_defaults' );
endif;

if ( ! function_exists( 'theme_additional_details_title_render' ) ) {

	/**
	 * Partial Refresh Render
	 *
	 * @since  3.0.0
	 */
	function theme_additional_details_title_render() {
		if ( get_option( 'theme_additional_details_title' ) ) {
			echo esc_html( get_option( 'theme_additional_details_title' ) );
		}
	}
}

if ( ! function_exists( 'theme_property_features_title_render' ) ) {

	/**
	 * Partial Refresh Render
	 *
	 * @since  3.0.0
	 */
	function theme_property_features_title_render() {
		if ( get_option( 'theme_property_features_title' ) ) {
			echo esc_html( get_option( 'theme_property_features_title' ) );
		}
	}
}