<?php
/**
 * Section:	`Property Item`
 * Panel: 	`Styles`
 *
 * @package realhomes/customizer
 * @since 3.0.0
 */

if ( ! function_exists( 'inspiry_styles_property_item_customizer' ) ) :

	/**
	 * inspiry_styles_property_item_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 * @since  3.0.0
	 */
	function inspiry_styles_property_item_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Property Item Section
		 */
		$wp_customize->add_section( 'inspiry_property_item_styles', array(
			'title' => esc_html__( 'Property Item', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		$wp_customize->add_setting( 'theme_property_item_bg_color', array(
			'type' => 'option',
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_property_item_bg_color',
				array(
					'label' => esc_html__( 'Property Item Background Color', 'framework' ),
					'section' => 'inspiry_property_item_styles',
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_property_item_border_color', array(
				'type' => 'option',
				'default' => '#dedede',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_property_item_border_color',
					array(
						'label' => esc_html__( 'Property Item Border Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
					)
				)
			);
		}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_property_image_overlay', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_property_image_overlay',
					array(
						'label' => esc_html__( 'Property Image Overlay', 'framework' ),
						'section' => 'inspiry_property_item_styles',
						'description' => esc_html__('Default color is #1ea69a','framework'),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_property_featured_label_bg', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_property_featured_label_bg',
					array(
						'label' => esc_html__( 'Featured Property Label Background', 'framework' ),
						'section' => 'inspiry_property_item_styles',
						'description' => esc_html__('Default color is #ea723d','framework'),
					)
				)
			);
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_title_color = '#394041';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_title_color = '#1a1a1a';
		}
		$wp_customize->add_setting( 'theme_property_title_color', array(
			'type' => 'option',
			'default' => $default_title_color,
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_property_title_color',
				array(
					'label' => esc_html__( 'Property Title Color', 'framework' ),
					'section' => 'inspiry_property_item_styles',
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_title_hover = '#df5400';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_title_hover = '#1ea69a';
		}
		$wp_customize->add_setting( 'theme_property_title_hover_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_property_title_hover_color',
				array(
					'label' => esc_html__( 'Property Title Hover Color', 'framework' ),
					'section' => 'inspiry_property_item_styles',
					'description' => sprintf( esc_html__( 'Default color is %s', 'framework' ), $default_title_hover ),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_price_color = '#ffffff';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_price_color = '#1ea69a';
		}
		$wp_customize->add_setting( 'theme_property_price_text_color', array(
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_property_price_text_color',
				array(
					'label' => esc_html__( 'Property Price Text Color', 'framework' ),
					'section' => 'inspiry_property_item_styles',
					'description' => sprintf( esc_html__( 'Default color is %s', 'framework' ), $default_price_color ),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_property_price_bg_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_property_price_bg_color',
					array(
						'label' => esc_html__( 'Property Price Background Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
						'description' => esc_html__('Default color is #4dc7ec','framework'),
					)
				)
			);

			$wp_customize->add_setting( 'theme_property_status_text_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_property_status_text_color',
					array(
						'label' => esc_html__( 'Property Status Text Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_property_status_bg_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_property_status_bg_color',
					array(
						'label' => esc_html__( 'Property Status Background Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
						'description' => esc_html__('Default color is #ec894d','framework'),
					)
				)
			);
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_desc_color = '#666666';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_desc_color = '#808080';
		}
		$wp_customize->add_setting( 'theme_property_desc_text_color', array(
			'type' => 'option',
			'default' => $default_desc_color,
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_property_desc_text_color',
				array(
					'label' => esc_html__( 'Property Description Text Color', 'framework' ),
					'section' => 'inspiry_property_item_styles',
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_more_details_text_color', array(
				'type' => 'option',
				'default' => '#394041',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_more_details_text_color',
					array(
						'label' => esc_html__( 'More Details Text Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
					)
				)
			);

			$wp_customize->add_setting( 'theme_more_details_text_hover_color', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_more_details_text_hover_color',
					array(
						'label' => esc_html__( 'More Details Text Hover Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
						'description' => esc_html__('Default color is #df5400','framework'),
					)
				)
			);
		}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_property_meta_heading_color', array(
				'type' => 'option',
				'default' => '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_property_meta_heading_color',
					array(
						'label' => esc_html__( 'Property Meta Heading Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
					)
				)
			);
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$default_meta_color = '#394041';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_meta_color = '#444';
		}
		$wp_customize->add_setting( 'theme_property_meta_text_color', array(
			'type' => 'option',
			'default' => $default_meta_color,
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'theme_property_meta_text_color',
				array(
					'label' => esc_html__( 'Property Meta Text Color', 'framework' ),
					'section' => 'inspiry_property_item_styles',
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'theme_property_meta_bg_color', array(
				'type' => 'option',
				'default' => '#f5f5f5',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_property_meta_bg_color',
					array(
						'label' => esc_html__( 'Property Meta Background Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
					)
				)
			);
		}

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_property_meta_icon_color', array(
				'type' => 'option',
				'default' => '#b3b3b3',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_property_meta_icon_color',
					array(
						'label' => esc_html__( 'Property Meta Icon Color', 'framework' ),
						'section' => 'inspiry_property_item_styles',
					)
				)
			);
		}

	}

	add_action( 'customize_register', 'inspiry_styles_property_item_customizer' );
endif;


if ( ! function_exists( 'inspiry_styles_property_item_defaults' ) ) :

	/**
	 * inspiry_styles_property_item_defaults.
	 *
	 * @param  WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 * @since  3.0.0
	 */
	function inspiry_styles_property_item_defaults( WP_Customize_Manager $wp_customize ) {
		$styles_property_item_settings_ids = array(
			'theme_property_item_bg_color',
			'theme_property_item_border_color',
			'inspiry_property_image_overlay',
			'inspiry_property_featured_label_bg',
			'theme_property_title_color',
			'theme_property_title_hover_color',
			'theme_property_price_text_color',
			'theme_property_price_bg_color',
			'theme_property_status_text_color',
			'theme_property_status_bg_color',
			'theme_property_desc_text_color',
			'theme_more_details_text_color',
			'theme_more_details_text_hover_color',
			'theme_property_meta_text_color',
			'theme_property_meta_bg_color',
			'inspiry_property_meta_heading_color',
			'inspiry_property_meta_icon_color',
		);
		inspiry_initialize_defaults( $wp_customize, $styles_property_item_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_styles_property_item_defaults' );
endif;
