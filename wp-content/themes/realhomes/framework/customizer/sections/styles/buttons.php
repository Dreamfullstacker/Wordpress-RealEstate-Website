<?php
/**
 * Section:    `Buttons`
 * Panel:    `Styles`
 *
 * @package realhomes/customizer
 * @since 3.0.0
 */

if ( ! function_exists( 'inspiry_styles_buttons_customizer' ) ) :

	/**
	 * inspiry_styles_buttons_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since  3.0.0
	 */
	function inspiry_styles_buttons_customizer( WP_Customize_Manager $wp_customize ) {

		// Buttons Section
		$wp_customize->add_section( 'inspiry_buttons_styles', array(
			'title' => esc_html__( 'Buttons', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting(
				'inspiry_buttons_transition_style', array(
				'type'              => 'option',
				'default'           => 'default',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control(
				'inspiry_buttons_transition_style', array(
				'label'   => esc_html__( 'Transition Style', 'framework' ),
				'type'    => 'select',
				'section' => 'inspiry_buttons_styles',
				'choices' => array(
					'default' => esc_html__( 'Default', 'framework' ),
					'style_1' => esc_html__( 'Style 1', 'framework' ),
					'style_2' => esc_html__( 'Style 2', 'framework' ),
					'style_3' => esc_html__( 'Style 3', 'framework' ),
					'style_4' => esc_html__( 'Style 4', 'framework' ),
					'style_5' => esc_html__( 'Style 5', 'framework' ),
				),
			) );
		}

		$wp_customize->add_setting( 'theme_button_text_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_button_text_color',
				array(
					'label'   => esc_html__( 'Button Color', 'framework' ),
					'section' => 'inspiry_buttons_styles',
				)
			)
		);

		$wp_customize->add_setting( 'theme_button_hover_text_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_button_hover_text_color',
				array(
					'label'   => esc_html__( 'Button Hover Color', 'framework' ),
					'section' => 'inspiry_buttons_styles',
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_btn_bg_color = '#ec894d';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_btn_bg_color = '#1ea69a';
		}
		$wp_customize->add_setting( 'theme_button_bg_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_button_bg_color',
				array(
					'label'       => esc_html__( 'Button Background Color', 'framework' ),
					'section'     => 'inspiry_buttons_styles',
					'description' => sprintf( esc_html__( 'Default color is %s', 'framework' ), $default_btn_bg_color ),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_btn_hover_bg_color = '#e3712c';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_btn_hover_bg_color = '#0b8278';
		}
		$wp_customize->add_setting( 'theme_button_hover_bg_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_button_hover_bg_color',
				array(
					'label'       => esc_html__( 'Button Hover Background Color', 'framework' ),
					'section'     => 'inspiry_buttons_styles',
					'description' => sprintf( esc_html__( 'Default color is %s', 'framework' ), $default_btn_hover_bg_color ),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			/* Separator */
			$wp_customize->add_setting( 'inspiry_scroll_to_top_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Separator_Control(
					$wp_customize,
					'inspiry_scroll_to_top_separator',
					array(
						'section' => 'inspiry_buttons_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_back_to_top_bg_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_back_to_top_bg_color',
					array(
						'label'       => esc_html__( 'Scroll to Top Button Background Color', 'framework' ),
						'section'     => 'inspiry_buttons_styles',
						'description' => esc_html__( 'Default color is #4dc7ec', 'framework' ),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_back_to_top_bg_hover_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_back_to_top_bg_hover_color',
					array(
						'label'       => esc_html__( 'Scroll to Top Button Background Hover Color', 'framework' ),
						'section'     => 'inspiry_buttons_styles',
						'description' => esc_html__( 'Default color is #37b3d9', 'framework' ),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_back_to_top_color', array(
				'type'              => 'option',
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_back_to_top_color',
					array(
						'label'   => esc_html__( 'Scroll to Top Button Icon Color', 'framework' ),
						'section' => 'inspiry_buttons_styles',
					)
				)
			);
		}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {


			$wp_customize->add_setting( 'inspiry_submit_button_border_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_submit_button_border_color',
					array(
						'label'           => esc_html__( 'Header Submit Button Border Color', 'framework' ),
						'section'         => 'inspiry_buttons_styles',
						'active_callback' => function () {
							if ( 'two' == get_option( 'inspiry_header_mod_variation_option' ) ||
							     'three' == get_option( 'inspiry_header_mod_variation_option' ) ||
							     'four' == get_option( 'inspiry_header_mod_variation_option' ) ) {
								return true;
							}

							return false;
						}
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_submit_button_border_hover_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_submit_button_border_hover_color',
					array(
						'label'           => esc_html__( 'Header Submit Button Border Hover Color', 'framework' ),
						'section'         => 'inspiry_buttons_styles',
						'active_callback' => function () {
							if ( 'two' == get_option( 'inspiry_header_mod_variation_option' ) ||
							     'three' == get_option( 'inspiry_header_mod_variation_option' ) ||
							     'four' == get_option( 'inspiry_header_mod_variation_option' ) ) {
								return true;
							}

							return false;
						}
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_advance_search_btn_bg', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_advance_search_btn_bg',
					array(
						'label'       => esc_html__( 'Advance Search Button Background', 'framework' ),
						'section'     => 'inspiry_buttons_styles',
						'description' => esc_html__( 'Default color is #18998e', 'framework' ),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_advance_search_btn_hover_bg', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_advance_search_btn_hover_bg',
					array(
						'label'       => esc_html__( 'Advance Search Button Hover Background', 'framework' ),
						'section'     => 'inspiry_buttons_styles',
						'description' => esc_html__( 'Default color is #179086', 'framework' ),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_advance_search_btn_text', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_advance_search_btn_text',
					array(
						'label'       => esc_html__( 'Advance Search Button Icon', 'framework' ),
						'section'     => 'inspiry_buttons_styles',
						'description' => esc_html__( 'Default color is #ffffff', 'framework' ),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_advance_search_btn_text_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_advance_search_btn_text_hover',
					array(
						'label'       => esc_html__( 'Advance Search Button Icon Hover', 'framework' ),
						'section'     => 'inspiry_buttons_styles',
						'description' => esc_html__( 'Default color is #ffffff', 'framework' ),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_advance_search_arrow_and_text', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'inspiry_advance_search_arrow_and_text',
				array(
					'label'           => esc_html__( 'Advance Search Arrow & Text', 'framework' ),
					'section'         => 'inspiry_buttons_styles',
					'description'     => esc_html__( 'Default color is #333333', 'framework' ),
					'active_callback' => function () {
						if ( 'default' == get_option( 'inspiry_search_form_mod_layout_options', 'default' ) ) {
							return true;
						}

						return false;
					}
				)
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_styles_buttons_customizer' );
endif;

if ( ! function_exists( 'inspiry_styles_buttons_defaults' ) ) :
	/**
	 * inspiry_styles_buttons_defaults.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since  3.0.0
	 */
	function inspiry_styles_buttons_defaults( WP_Customize_Manager $wp_customize ) {
		$styles_buttons_settings_ids = array(
			'theme_button_text_color',
			'theme_button_bg_color',
			'theme_button_hover_text_color',
			'theme_button_hover_bg_color',
		);
		inspiry_initialize_defaults( $wp_customize, $styles_buttons_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_styles_buttons_defaults' );
endif;