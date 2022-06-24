<?php
/**
 * Section:    `Styles`
 * Panel:    `Floating Features`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_floating_features_styles_customizer' ) ) {

	/**
	 * inspiry_footer_styles_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @since  2.6.3
	 */

	function inspiry_floating_features_styles_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Footer Styles
		 */
		$wp_customize->add_section( 'inspiry_floating_styles', array(
			'title' => esc_html__( 'Floating Features', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );


		$wp_customize->add_setting( 'theme_floating_responsive_background', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_floating_responsive_background',
				array(
					'label'   => esc_html__( 'Small Devices Bar Background Color', 'framework' ),
					'description' => esc_html__('This bar will appear only on small devices','framework'),
					'section' => 'inspiry_floating_styles',
				)
			)
		);


		if ( class_exists( 'WP_Currencies' ) ) {

			$wp_customize->add_setting( 'inspiry_currency_switcher_label', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_currency_switcher_label',
					array(
						'label'   => esc_html__( 'Currency Switcher ', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);


			$wp_customize->add_setting( 'theme_currency_switcher_background', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_currency_switcher_background',
					array(
						'label'   => esc_html__( 'Background Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_currency_switcher_selected_text', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_currency_switcher_selected_text',
					array(
						'label'   => esc_html__( 'Text Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_currency_switcher_background_open', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_currency_switcher_background_open',
					array(
						'label'   => esc_html__( 'Background Open/Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_currency_switcher_text_open', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_currency_switcher_text_open',
					array(
						'label'   => esc_html__( 'Text Open/Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_currency_switcher_background_dropdown', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_currency_switcher_background_dropdown',
					array(
						'label'   => esc_html__( 'Dropdown Background Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);


			$wp_customize->add_setting( 'theme_currency_switcher_text_dropdown', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_currency_switcher_text_dropdown',
					array(
						'label'   => esc_html__( 'Dropdown text Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_currency_switcher_background_hover_dropdown', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_currency_switcher_background_hover_dropdown',
					array(
						'label'   => esc_html__( 'Dropdown Background Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_currency_switcher_text_hover_dropdown', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_currency_switcher_text_hover_dropdown',
					array(
						'label'   => esc_html__( 'Dropdown Text Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

		}

		if ( class_exists( 'SitePress' ) ) {

			$wp_customize->add_setting( 'inspiry_language_switcher_label', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_language_switcher_label',
					array(
						'label'   => esc_html__( 'Language Switcher ', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);


			$wp_customize->add_setting( 'theme_language_switcher_background', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_language_switcher_background',
					array(
						'label'   => esc_html__( 'Background Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_language_switcher_selected_text', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_language_switcher_selected_text',
					array(
						'label'   => esc_html__( 'Text Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_language_switcher_background_open', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_language_switcher_background_open',
					array(
						'label'   => esc_html__( 'Background Open/Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_language_switcher_text_open', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_language_switcher_text_open',
					array(
						'label'   => esc_html__( 'Text Open/Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_language_switcher_background_dropdown', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_language_switcher_background_dropdown',
					array(
						'label'   => esc_html__( 'Dropdown Background Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);


			$wp_customize->add_setting( 'theme_language_switcher_text_dropdown', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_language_switcher_text_dropdown',
					array(
						'label'   => esc_html__( 'Dropdown text Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_language_switcher_background_hover_dropdown', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_language_switcher_background_hover_dropdown',
					array(
						'label'   => esc_html__( 'Dropdown Background Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_language_switcher_text_hover_dropdown', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_language_switcher_text_hover_dropdown',
					array(
						'label'   => esc_html__( 'Dropdown Text Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);
		}

		if ( ( 'enable' === get_option( 'theme_compare_properties_module' ) && get_option( 'inspiry_compare_page' ) ) ) {

			$wp_customize->add_setting( 'inspiry_compare_properties_label', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_compare_properties_label',
					array(
						'label'   => esc_html__( 'Compare Properties ', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);


			$wp_customize->add_setting( 'theme_compare_switcher_background', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_switcher_background',
					array(
						'label'   => esc_html__( 'Background Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_switcher_selected_text', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_switcher_selected_text',
					array(
						'label'   => esc_html__( 'Text Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_switcher_background_open', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_switcher_background_open',
					array(
						'label'   => esc_html__( 'Background Open/Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_switcher_text_open', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_switcher_text_open',
					array(
						'label'   => esc_html__( 'Text Open/Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_view_background', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_view_background',
					array(
						'label'   => esc_html__( 'Compare View Background Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_view_title_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_view_title_color',
					array(
						'label'   => esc_html__( 'Compare View Title Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);


			$wp_customize->add_setting( 'theme_compare_view_property_title_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_view_property_title_color',
					array(
						'label'   => esc_html__( 'Compare View Property Title Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_view_property_title_hover_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_view_property_title_hover_color',
					array(
						'label'   => esc_html__( 'Compare View Property Title Hover Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_view_property_button_background', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_view_property_button_background',
					array(
						'label'   => esc_html__( 'Compare View Button Background Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_view_property_button_text', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_view_property_button_text',
					array(
						'label'   => esc_html__( 'Compare View Button Text Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_view_property_button_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_view_property_button_hover',
					array(
						'label'   => esc_html__( 'Compare View Button Hover Background Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_compare_view_property_button_text_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_compare_view_property_button_text_hover',
					array(
						'label'   => esc_html__( 'Compare View Button Hover Text Color', 'framework' ),
						'section' => 'inspiry_floating_styles',
					)
				)
			);


		}

	}

	add_action( 'customize_register', 'inspiry_floating_features_styles_customizer' );

}