<?php
/**
 * Section:	`Styles`
 * Panel: 	`Banner`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_banner_styles_customizer' ) ) {

	/**
	 * Banner section in the Style Panel.
	 *
	 * @param  object $wp_customize - Instance of WP_Customize_Manager.
	 * @since  2.6.3
	 */
	function inspiry_banner_styles_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Banner Section
		 */
		$wp_customize->add_section( 'inspiry_styles_banner', array(
			'title' => esc_html__( 'Banner', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_title_color = '#394041';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_title_color = '#ffffff';
		}

		$wp_customize->add_setting( 'theme_banner_text_color', array(
			'type'              => 'option',
			'default'           => $default_title_color,
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control( $wp_customize, 'theme_banner_text_color',
				array(
					'label'   => esc_html__( 'Banner Title Color', 'framework' ),
					'section' => 'inspiry_styles_banner',
				)
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_banner_bg_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_banner_bg_color',
					array(
						'label' => esc_html__( 'Banner Background Color', 'framework' ),
						'section' => 'inspiry_styles_banner',
					)
				)
			);

			$wp_customize->add_setting( 'theme_banner_bg_overlay_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_banner_bg_overlay_color',
					array(
						'label' => esc_html__( 'Banner Image Overlay Color', 'framework' ),
						'section' => 'inspiry_styles_banner',
					)
				)
			);
			$wp_customize->add_setting( 'theme_banner_bg_overlay_opacity', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control(
				'theme_banner_bg_overlay_opacity',
				array(
					'label'     => esc_html__( 'Banner Image Overlay Opacity', 'framework' ),
					'description'     => esc_html__( 'Set opacity in decimal points between 0 and 1 (i.e .5)', 'framework' ),
					'type'      => 'text',
					'section'   => 'inspiry_styles_banner',
				)
			);

			$wp_customize->add_setting(
				'inspiry_banner_height', array(
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_banner_height', array(
					'label'     => esc_html__( 'Banner Height', 'framework' ),
					'description'     => esc_html__( 'i.e 300px / 30rem / 20% ', 'framework' ),
					'type'      => 'text',
					'section'   => 'inspiry_styles_banner',
				)
			);
		}


		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'theme_banner_title_bg_color', array(
				'type' => 'option',
				'default' => '#f5f4f3',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_banner_title_bg_color',
					array(
						'label' => esc_html__( 'Banner Title Background Color', 'framework' ),
						'section' => 'inspiry_styles_banner',
					)
				)
			);

			$wp_customize->add_setting( 'theme_banner_sub_text_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_banner_sub_text_color',
					array(
						'label' => esc_html__( 'Banner Sub Title Color', 'framework' ),
						'section' => 'inspiry_styles_banner',
					)
				)
			);

			$wp_customize->add_setting( 'theme_banner_sub_title_bg_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_banner_sub_title_bg_color',
					array(
						'label' => esc_html__( 'Banner Sub Title Background Color', 'framework' ),
						'section' => 'inspiry_styles_banner',
						'description' => esc_html__('Default color is #37B3D9','framework'),
					)
				)
			);

		}

	}

	add_action( 'customize_register', 'inspiry_banner_styles_customizer' );

}

if ( ! function_exists( 'inspiry_banner_styles_defaults' ) ) :

	/**
	 * Default settings.
	 *
	 * @param object $wp_customize - Instance of WP_Customize_Manager.
	 * @since  2.6.3
	 */
	function inspiry_banner_styles_defaults( WP_Customize_Manager $wp_customize ) {
		$banner_settings_ids = array(
//			'theme_banner_titles',
			'theme_banner_text_color',
			'theme_banner_title_bg_color',
			'theme_banner_sub_text_color',
			'theme_banner_sub_title_bg_color',
		);
		inspiry_initialize_defaults( $wp_customize, $banner_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_banner_styles_defaults' );
endif;