<?php
/**
 * Section:    `Styles`
 * Panel:    `Header`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_header_styles_customizer' ) ) :

	/**
	 * inspiry_header_styles_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  2.6.3
	 */
	function inspiry_header_styles_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Styles Section
		 */
		$wp_customize->add_section( 'inspiry_header_styles', array(
			'title' => esc_html__( 'Header', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_header_menu_top_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_menu_top_color',
					array(
						'label'           => esc_html__( 'Menu wrapper Background Color', 'framework' ),
						'section'         => 'inspiry_header_styles',
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
			$wp_customize->add_setting( 'theme_header_meta_bg_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_meta_bg_color',
					array(
						'label'           => esc_html__( 'Header Meta wrapper Background Color', 'framework' ),
						'section'         => 'inspiry_header_styles',
						'active_callback' => function () {
							if ( 'two' === get_option( 'inspiry_header_mod_variation_option' ) || 'four' === get_option( 'inspiry_header_mod_variation_option' ) ) {
								return true;
							}
							return false;
						}
					)
				)
			);


		}

		/* Header Background Color */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_header_bg = '#252A2B';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_header_bg = '#303030';
		}
		$wp_customize->add_setting( 'theme_header_bg_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,              // WP_Customize_Manager.
				'theme_header_bg_color',    // Setting id.
				array(
					'label'       => esc_html__( 'Header/Banner Background Color', 'framework' ),
					'section'     => 'inspiry_header_styles',
					'description' => sprintf( esc_html__( 'Applies when no banner image appears. Default Color is %s', 'framework' ), $default_header_bg ),
				)
			)
		);

		/* Logo Text Color */
		$wp_customize->add_setting( 'theme_logo_text_color', array(
			'type'              => 'option',
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_logo_text_color',
				array(
					'label'   => esc_html__( 'Logo Text Color', 'framework' ),
					'section' => 'inspiry_header_styles',
				)
			)
		);

		/* Logo Text Hover Color */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_logo_hover = '#4dc7ec';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_logo_hover = '#1ea69a';
		}
		$wp_customize->add_setting( 'theme_logo_text_hover_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_logo_text_hover_color',
				array(
					'label'       => esc_html__( 'Logo Text Hover Color', 'framework' ),
					'section'     => 'inspiry_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), $default_logo_hover ),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			/* Tagline Text Color */
			$wp_customize->add_setting( 'theme_tagline_text_color', array(
				'type'              => 'option',
				'default'           => '#8b9293',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_tagline_text_color',
					array(
						'label'   => esc_html__( 'Tagline Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Tagline Background Color */
			$wp_customize->add_setting( 'theme_tagline_bg_color', array(
				'type'              => 'option',
				'default'           => '#343a3b',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_tagline_bg_color',
					array(
						'label'   => esc_html__( 'Tagline Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Header Text Color */
			$wp_customize->add_setting( 'theme_header_text_color', array(
				'type'              => 'option',
				'default'           => '#929A9B',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_text_color',
					array(
						'label'   => esc_html__( 'Header Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Header Links Hover Color */
			$wp_customize->add_setting( 'theme_header_link_hover_color', array(
				'type'              => 'option',
				'default'           => '#b0b8b9',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_link_hover_color',
					array(
						'label'   => esc_html__( 'Header Links Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Header Borders Color */
			$wp_customize->add_setting( 'theme_header_border_color', array(
				'type'              => 'option',
				'default'           => '#343A3B',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_border_color',
					array(
						'label'   => esc_html__( 'Header Borders Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			/* Main Menu Text Color */

		}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Header Var 1  gradient color*/
			$wp_customize->add_setting( 'inspiry_top_menu_gradient_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_top_menu_gradient_color',
					array(
						'label'       => esc_html__( 'Header Background Gradient Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => esc_html__( 'Starting gradient color from top (default #000000)', 'framework' ),
					)
				)
			);
		}

		$wp_customize->add_setting( 'theme_main_menu_text_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_main_menu_text_color',
				array(
					'label'   => esc_html__( 'Main Menu Text Color', 'framework' ),
					'section' => 'inspiry_header_styles',
				)
			)
		);

		$wp_customize->add_setting( 'theme_main_menu_text_hover_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_main_menu_text_hover_color',
				array(
					'label'   => esc_html__( 'Main Menu Text Hover Color', 'framework' ),
					'section' => 'inspiry_header_styles',
				)
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Main Menu Text Color */


			/* Main Menu Text Hover Color */
			$wp_customize->add_setting( 'inspiry_main_menu_hover_bg', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_main_menu_hover_bg',
					array(
						'label'       => esc_html__( 'Main Menu Hover Background/border', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => esc_html__( 'Default color is #ea723d', 'framework' ),
					)
				)
			);
		}

		/* Drop Down Menu Background Color */
		$default_dd_menu_bg = '';
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_dd_menu_bg = '#ec894d';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_dd_menu_bg = '#ffffff';
		}
		$wp_customize->add_setting( 'theme_menu_bg_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_menu_bg_color',
				array(
					'label'       => esc_html__( 'Drop Down Menu Background Color', 'framework' ),
					'section'     => 'inspiry_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), $default_dd_menu_bg ),
				)
			)
		);

		/* Drop Down Menu Text Color */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_dd_menu_text_color = '#ffffff';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_dd_menu_text_color = '#808080';
		}
		$wp_customize->add_setting( 'theme_menu_text_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_menu_text_color',
				array(
					'label'       => esc_html__( 'Drop Down Menu Text Color', 'framework' ),
					'section'     => 'inspiry_header_styles',
					'description' => sprintf( esc_html__( 'Default color is %s', 'framework' ), $default_dd_menu_text_color ),
				)
			)
		);

		/* Drop Down Menu Background Color on Mouse Over */

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_menu_bg_color = '#dc7d44';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_menu_bg_color = '#ffffff';
		}

		$wp_customize->add_setting( 'theme_menu_hover_bg_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_menu_hover_bg_color',
				array(
					'label'       => esc_html__( 'Drop Down Menu Background Color on Mouse Over', 'framework' ),
					'section'     => 'inspiry_header_styles',
					'description' => sprintf( esc_html__( 'Default color is %s', 'framework' ), $default_menu_bg_color ),
				)
			)
		);

		/* Drop Down Menu Text Color on Mouse Over */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_menu_text_color = '#ffffff';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_menu_text_color = '#000000';
		}
		$wp_customize->add_setting( 'theme_menu_hover_text_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_menu_hover_text_color',
				array(
					'label'       => esc_html__( 'Drop Down Menu Text Color on Mouse Over', 'framework' ),
					'section'     => 'inspiry_header_styles',
					'description' => sprintf( esc_html__( 'Default color is %s', 'framework' ), $default_menu_text_color ),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {


			/* Header Phone Number Background Color */
			$wp_customize->add_setting( 'theme_phone_bg_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_bg_color',
					array(
						'label'       => esc_html__( 'Header Phone Number Background Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => esc_html__( 'Default color is #4dc7ec', 'framework' ),
					)
				)
			);
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_phone_text_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_text_color',
					array(
						'label'       => esc_html__( 'Phone Number Text Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => esc_html__( 'Default color is #e7eff7', 'framework' ),
					)
				)
			);
		}


		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'theme_phone_text_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_text_color',
					array(
						'label'       => esc_html__( 'Phone/Email Number Text Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => esc_html__( 'Default color is #ffffff', 'framework' ),
					)
				)
			);

			$wp_customize->add_setting( 'theme_phone_text_color_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_text_color_hover',
					array(
						'label'       => esc_html__( 'Phone/Email Number Text Hover Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => esc_html__( 'Default color is #ffffff', 'framework' ),
					)
				)
			);

		}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'theme_header_social_icon_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_social_icon_color',
					array(
						'label'           => esc_html__( 'Social Icon Color', 'framework' ),
						'section'         => 'inspiry_header_styles',
						'active_callback' => 'inspiry_header_variation_option_two'
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_social_icon_color_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_header_social_icon_color_hover',
					array(
						'label'           => esc_html__( 'Social Icon Hover Color', 'framework' ),
						'section'         => 'inspiry_header_styles',
						'active_callback' => 'inspiry_header_variation_option_two'
					)
				)
			);
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_phone_icon_bg_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_phone_icon_bg_color',
					array(
						'label'       => esc_html__( 'Header Phone Icon Background Color', 'framework' ),
						'section'     => 'inspiry_header_styles',
						'description' => esc_html__( 'Default color is #37b3d9', 'framework' ),
					)
				)
			);
		}

		if ( 'modern' == INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'inspiry_home_responsive_header_labels',
				array( 'sanitize_callback' => 'sanitize_text_field', )
			);
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_home_responsive_header_labels',
					array(
						'label'   => esc_html__( 'Responsive Header ', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_responsive_header_bg_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_responsive_header_bg_color',    // Setting id.
					array(
						'label'   => esc_html__( 'Responsive Header Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_logo_responsive_text_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_logo_responsive_text_color',
					array(
						'label'   => esc_html__( 'Logo Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_responsive_phone_text_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_phone_text_color',
					array(
						'label'   => esc_html__( 'Phone Number Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_responsive_phone_text_color_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_phone_text_color_hover',
					array(
						'label'   => esc_html__( 'Phone Number Text Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_responsive_submit_button_bg', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_submit_button_bg',
					array(
						'label'   => esc_html__( 'Submit Button Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_responsive_submit_button_bg_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_submit_button_bg_hover',
					array(
						'label'   => esc_html__( 'Submit Button Background Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_responsive_submit_button_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_submit_button_color',
					array(
						'label'   => esc_html__( 'Submit Button Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_responsive_submit_button_color_hover', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_submit_button_color_hover',
					array(
						'label'   => esc_html__( 'Submit Button Text Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_responsive_menu_icon_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_menu_icon_color',
					array(
						'label'   => esc_html__( 'Responsive Menu Icon Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_responsive_menu_bg_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_menu_bg_color',
					array(
						'label'   => esc_html__( 'Responsive Menu Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_responsive_menu_text_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_menu_text_color',
					array(
						'label'   => esc_html__( 'Responsive Menu Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_responsive_menu_text_hover_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_menu_text_hover_color',
					array(
						'label'   => esc_html__( 'Responsive Menu Text Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

		}

		if ( 'classic' == INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_home_responsive_header_labels',
				array( 'sanitize_callback' => 'sanitize_text_field', )
			);
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_home_responsive_header_labels',
					array(
						'label'   => esc_html__( 'Responsive Header ', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_bg_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_bg_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Header/Banner Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_email_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_email_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Email Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_email_hover_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_email_hover_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Email Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_user_nav_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_user_nav_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'User Nav Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_user_nav_hover_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_user_nav_hover_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'User Nav Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_user_nav_border_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_user_nav_border_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'User Nav Border Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_site_logo_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_site_logo_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Site Logo Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_header_site_logo_hover_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_site_logo_hover_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Site Logo Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_header_tag_line_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_tag_line_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Tag Line Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_header_tag_line_bg_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_tag_line_bg_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Tag Line Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_header_phone_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_phone_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Phone Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_header_phone_hover_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,              // WP_Customize_Manager.
					'theme_header_phone_hover_color_responsive',    // Setting id.
					array(
						'label'   => esc_html__( 'Phone Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_responsive_menu_icon_color', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_responsive_menu_icon_color',
					array(
						'label'   => esc_html__( 'Responsive Menu Icon Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_nav_bg_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_nav_bg_color_responsive',
					array(
						'label'   => esc_html__( 'Nav Container Background Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_nav_text_color_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_nav_text_color_responsive',
					array(
						'label'   => esc_html__( 'Nav Text Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);
			$wp_customize->add_setting( 'theme_nav_text_color_hover_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_nav_text_color_hover_responsive',
					array(
						'label'   => esc_html__( 'Nav Text Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_nav_bg_color_hover_responsive', array(
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_nav_bg_color_hover_responsive',
					array(
						'label'   => esc_html__( 'Nav Background Hover Color', 'framework' ),
						'section' => 'inspiry_header_styles',
					)
				)
			);

		}


	}

	add_action( 'customize_register', 'inspiry_header_styles_customizer' );
endif;

if ( ! function_exists( 'inspiry_sticky_header_styles_customizer' ) ) :
	/**
	 * inspiry_sticky_header_styles_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  2.6.3
	 */
	function inspiry_sticky_header_styles_customizer( WP_Customize_Manager $wp_customize ) {

		// Only for modern variation.
		if ( 'modern' !== INSPIRY_DESIGN_VARIATION ) {
			return false;
		}

		// Sticky Header Styles Section
		$wp_customize->add_section( 'inspiry_sticky_header_styles', array(
			'title' => esc_html__( 'Sticky Header', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		// Sticky Header Logo
		$wp_customize->add_setting( 'realhomes_sticky_header_logo', array(
			'type'              => 'option',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'realhomes_sticky_header_logo', array(
			'label'       => esc_html__( 'Logo', 'framework' ),
			'description' => esc_html__( 'Logo for sticky header. Site Logo will be used if no image selected.', 'framework' ),
			'section'     => 'inspiry_sticky_header_styles',
			'settings'    => 'realhomes_sticky_header_logo',
		) ) );

		// Sticky Header Color Scheme
		$wp_customize->add_setting( 'realhomes_sticky_header_color_scheme', array(
			'type'              => 'option',
			'default'           => 'dark',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'realhomes_sticky_header_color_scheme', array(
			'label'   => esc_html__( 'Color Scheme', 'framework' ),
			'description' => esc_html__( 'Use predefined color schemes for sticky header. Choose custom to create your desired Color Scheme using controls below.', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_sticky_header_styles',
			'choices' => array(
				'dark'  => esc_html__( 'Dark', 'framework' ),
				'light' => esc_html__( 'Light', 'framework' ),
				'custom' => esc_html__( 'Custom', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'theme_modern_sticky_header_bg_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_bg_color',
				array(
					'label'       => esc_html__( 'Background Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#303030' ),
				)
			)
		);

		$wp_customize->add_setting( 'theme_modern_sticky_header_site_title_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_site_title_color',
				array(
					'label'       => esc_html__( 'Site Title Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
				)
			)
		);

		$wp_customize->add_setting( 'theme_modern_sticky_header_site_title_hover_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_site_title_hover_color',
				array(
					'label'       => esc_html__( 'Site Title Hover Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#1ea69a' ),
				)
			)
		);

		$wp_customize->add_setting( 'theme_modern_sticky_header_menu_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_menu_color',
				array(
					'label'       => esc_html__( 'Menu Text Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
				)
			)
		);

		$wp_customize->add_setting( 'theme_modern_sticky_header_menu_text_hover_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_menu_text_hover_color',
				array(
					'label'       => esc_html__( 'Menu Text Hover Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#1ea69a' ),
				)
			)
		);

		$wp_customize->add_setting( 'theme_modern_sticky_header_btn_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_btn_color',
				array(
					'label'       => esc_html__( 'Submit Button Background Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#1ea69a' ),
				)
			)
		);

		$wp_customize->add_setting( 'theme_modern_sticky_header_btn_hover_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_btn_hover_color',
				array(
					'label'       => esc_html__( 'Submit Button Hover Background Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#0b8278' ),
				)
			)
		);

		$wp_customize->add_setting( 'theme_modern_sticky_header_btn_text_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_btn_text_color',
				array(
					'label'       => esc_html__( 'Submit Button Text Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
				)
			)
		);

		$wp_customize->add_setting( 'theme_modern_sticky_header_btn_hover_text_color', array(
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_modern_sticky_header_btn_hover_text_color',
				array(
					'label'       => esc_html__( 'Submit Button Hover Text Color', 'framework' ),
					'section'     => 'inspiry_sticky_header_styles',
					'description' => sprintf( esc_html__( 'Default Color is %s', 'framework' ), '#ffffff' ),
				)
			)
		);
	}

	add_action( 'customize_register', 'inspiry_sticky_header_styles_customizer' );
endif;

if ( ! function_exists( 'inspiry_header_styles_defaults' ) ) :
	/**
	 * inspiry_header_styles_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_header_styles_defaults( WP_Customize_Manager $wp_customize ) {
		$header_styles_settings_ids = array(
			'theme_header_bg_color',
			'theme_logo_text_color',
			'theme_logo_text_hover_color',
			'theme_tagline_text_color',
			'theme_tagline_bg_color',
			'theme_header_text_color',
			'theme_header_link_hover_color',
			'theme_header_border_color',
			'theme_main_menu_text_color',
			'inspiry_main_menu_hover_bg',
			'theme_menu_bg_color',
			'theme_menu_text_color',
			'theme_menu_hover_bg_color',
			'theme_phone_bg_color',
			'theme_phone_text_color',
			'theme_phone_icon_bg_color',
			'theme_language_switcher_bg_color',
			'theme_language_switcher_link_color',
			'theme_language_switcher_link_hover_color'
		);
		inspiry_initialize_defaults( $wp_customize, $header_styles_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_header_styles_defaults' );
endif;

if ( ! function_exists( 'inspiry_header_variation_option_one' ) ) {
	/**
	 * Checks if header variation one is enable
	 *
	 * @return true|false
	 */
	function inspiry_header_variation_option_one() {
		$theme_homepage_module = get_option( 'inspiry_header_mod_variation_option' );
		if ( 'one' == $theme_homepage_module ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_header_variation_option_two' ) ) {
	/**
	 * Checks if header variation two is enable
	 *
	 * @return true|false
	 */
	function inspiry_header_variation_option_two() {
		$theme_homepage_module = get_option( 'inspiry_header_mod_variation_option' );
		if ( 'two' == $theme_homepage_module ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_header_variation_option_three' ) ) {
	/**
	 * Checks if header variation three is enable
	 *
	 * @return true|false
	 */
	function inspiry_header_variation_option_three() {
		$theme_homepage_module = get_option( 'inspiry_header_mod_variation_option' );
		if ( 'three' == $theme_homepage_module ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_header_variation_option_four' ) ) {
	/**
	 * Checks if header variation four is enable
	 *
	 * @return true|false
	 */
	function inspiry_header_variation_option_four() {
		$theme_homepage_module = get_option( 'inspiry_header_mod_variation_option' );
		if ( 'four' == $theme_homepage_module ) {
			return true;
		}

		return false;
	}
}