<?php
/**
 * Section:	`Styles`
 * Panel: 	`Footer`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_footer_styles_customizer' ) ) :

	/**
	 * inspiry_footer_styles_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */
	function inspiry_footer_styles_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Footer Styles
		 */
		$wp_customize->add_section( 'inspiry_footer_styles', array(
			'title' => esc_html__( 'Footer', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'inspiry_footer_background_color', array(
				'type' 				=> 'option',
				'default' 			=> '#f5f5f5',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control( $wp_customize, 'inspiry_footer_background_color',
					array(
						'label'   => esc_html__( 'Footer Background Color', 'framework' ),
						'section' => 'inspiry_footer_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_widget_title_color', array(
				'type' 				=> 'option',
				'default' 			=> '#394041',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_widget_title_color',
					array(
						'label' 	=> esc_html__( 'Footer Widget Title Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_widget_text_color', array(
				'type' 				=> 'option',
				'default' 			=> '#8b9293',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_widget_text_color',
					array(
						'label' 	=> esc_html__( 'Footer Text Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_widget_link_color', array(
				'type' 				=> 'option',
//				'default' 			=> '#75797A',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_widget_link_color',
					array(
						'label' 	=> esc_html__( 'Footer Link Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
						'description' => esc_html__('Default color is #75797A','framework')
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_widget_link_hover_color', array(
				'type' 				=> 'option',
//				'default' 			=> '#dc7d44',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_widget_link_hover_color',
					array(
						'label' 	=> esc_html__( 'Footer Link Hover Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
						'description' => esc_html__('Default color is #dc7d44','framework')
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_border_color', array(
				'type' 				=> 'option',
				'default' 			=> '#dedede',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_border_color',
					array(
						'label' 	=> esc_html__( 'Footer Border Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_disable_footer_bg', array(
				'type' 		=> 'option',
				'default' 	=> 'false',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'theme_disable_footer_bg', array(
				'label' 	=> esc_html__( 'Do you want to disable footer bottom background image?', 'framework' ),
				'type' 		=> 'radio',
				'section' 	=> 'inspiry_footer_styles',
				'choices' 	=> array(
					'true' 	=> esc_html__( 'Yes', 'framework' ),
					'false' => esc_html__( 'No', 'framework' ),
				),
			) );

			$wp_customize->add_setting( 'theme_footer_bg_img', array(
				'type' 				=> 'option',
				'sanitize_callback' => 'esc_url_raw',
			) );
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'theme_footer_bg_img',
					array(
						'label' 		=> esc_html__( 'Footer Bottom Background Image', 'framework' ),
						'description' 	=> esc_html__( 'Note: Default background image is 235px in height and 1770px in width.', 'framework' ),
						'section' 		=> 'inspiry_footer_styles',
					)
				)
			);
		}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_footer_bg', array(
				'type' 				=> 'option',
				'default' 			=> '#303030',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_footer_bg',
					array(
						'label' 	=> esc_html__( 'Footer Background Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_widget_text_color', array(
				'type' 				=> 'option',
				'default' 			=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_widget_text_color',
					array(
						'label' 	=> esc_html__( 'Footer Text Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_widget_link_color', array(
				'type' 				=> 'option',
				'default' 			=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_widget_link_color',
					array(
						'label' 	=> esc_html__( 'Footer Link Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_widget_link_hover_color', array(
				'type' 				=> 'option',
				'default' 			=> '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_widget_link_hover_color',
					array(
						'label' 	=> esc_html__( 'Footer Link Hover Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_footer_widget_title_hover_color', array(
				'type' 				=> 'option',
				'default' 			=> '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_footer_widget_title_hover_color',
					array(
						'label' 	=> esc_html__( 'Footer Widget Title Color', 'framework' ),
						'section' 	=> 'inspiry_footer_styles',
					)
				)
			);
		}

	}

	add_action( 'customize_register', 'inspiry_footer_styles_customizer' );
endif;


if ( ! function_exists( 'inspiry_footer_styles_defaults' ) ) :

	/**
	 * inspiry_footer_styles_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_footer_styles_defaults( WP_Customize_Manager $wp_customize ) {
		$footer_styles_settings_ids = array(
			'theme_footer_widget_title_color',
			'theme_footer_widget_text_color',
			'theme_footer_widget_link_color',
			'theme_footer_widget_link_hover_color',
			'theme_footer_border_color',
			'theme_disable_footer_bg',
			'inspiry_footer_bg',
		);
		inspiry_initialize_defaults( $wp_customize, $footer_styles_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_footer_styles_defaults' );
endif;
