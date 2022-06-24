<?php
/**
 * Section:	`Home Page Styles`
 * Panel: 	`Home`
 *
 * @since 2.6.3
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_home_page_styles_customizer' ) ) {

	function inspiry_home_page_styles_customizer( WP_Customize_Manager $wp_customize ){

		$wp_customize->add_section( 'inspiry_home_page_styles', array(
			'title' => esc_html__( 'Home Page', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'inspiry_home_properties_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_home_properties_sep_labels',
					array(
						'label' => esc_html__('Home Properties ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);


			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_properties_title_span_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_properties_title_span_color',
					array(
						'label'       => esc_html__( 'Text Over Title Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #1ea69a', 'framework' ),
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_properties_title_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_properties_title_color',
					array(
						'label' 	=> esc_html__( 'Section Title Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Description Color */
			$wp_customize->add_setting( 'inspiry_home_properties_desc_color', array(
				'type' 		=> 'option',
				'default'	=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_properties_desc_color',
					array(
						'label' 	=> esc_html__( 'Section Description Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			//Section Background Color
			$wp_customize->add_setting( 'inspiry_home_properties_background_color', array(
				'type' 		=> 'option',
				'default'	=> '#F7F7F7',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_properties_background_color',
					array(
						'label' 	=> esc_html__( 'Section Background Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);


			$wp_customize->add_setting( 'inspiry_featured_properties_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_featured_properties_sep_labels',
					array(
						'label' => esc_html__('Featured Properties ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'theme_featured_prop_title_span_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_featured_prop_title_span_color',
					array(
						'label'       => esc_html__( 'Text Over Title Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #1ea69a', 'framework' ),
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'theme_featured_prop_title_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_featured_prop_title_color',
					array(
						'label' 	=> esc_html__( 'Section Title Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Description Color */
			$wp_customize->add_setting( 'theme_featured_prop_text_color', array(
				'type' 		=> 'option',
				'default'	=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_featured_prop_text_color',
					array(
						'label' 	=> esc_html__( 'Section Description Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_featured_properties_background_color', array(
				'type' 		=> 'option',
				'default'	=> '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_featured_properties_background_color',
					array(
						'label' 	=> esc_html__( 'Section Background Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_featured_testimonials_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_featured_testimonials_sep_labels',
					array(
						'label' => esc_html__('Testimonials ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Testimonial Color */
			$wp_customize->add_setting( 'inspiry_testimonial_color', array(
				'type' 		=> 'option',
				'default'	=> '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_testimonial_color',
					array(
						'label' 	=> esc_html__( 'Testimonial Text Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);



			$wp_customize->add_setting( 'inspiry_testimonial_bg_quote', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_testimonial_bg_quote',
					array(
						'label'       => esc_html__( 'Testimonial Quote Mark Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #0b8278', 'framework' )
					)
				)
			);

			/* Testimonial Color */
			$wp_customize->add_setting( 'inspiry_testimonial_name_color', array(
				'type' 		=> 'option',
				'default'	=> '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_testimonial_name_color',
					array(
						'label' 	=> esc_html__( 'Name Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Testimonial Color */
			$wp_customize->add_setting( 'inspiry_testimonial_url_color', array(
				'type' 		=> 'option',
				'default'	=> '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_testimonial_url_color',
					array(
						'label' 	=> esc_html__( 'URL Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Testimonial Background */
			$wp_customize->add_setting( 'inspiry_testimonial_bg', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_testimonial_bg',
					array(
						'label'       => esc_html__( 'Section Background Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #1ea69a', 'framework' )
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_home_cta_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_home_cta_sep_labels',
					array(
						'label' => esc_html__('Call To Action ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* CTA Title Color */
			$wp_customize->add_setting( 'inspiry_cta_title_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_title_color',
					array(
						'label' => esc_html__( 'CTA Title Color', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			/* CTA Description Color */
			$wp_customize->add_setting( 'inspiry_cta_desc_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_desc_color',
					array(
						'label' => esc_html__( 'CTA Description Color', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);


			$wp_customize->add_setting( 'inspiry_cta_btn_one_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_btn_one_color',
					array(
						'label' => esc_html__( 'CTA Button Color One', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_cta_btn_one_bg', array(
				'type' => 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_btn_one_bg',
					array(
						'label' => esc_html__( 'CTA Button Background Color One', 'framework' ),
						'section' => 'inspiry_home_page_styles',
						'description' => esc_html__('Default color is #ea723d','framework'),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_cta_btn_two_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_btn_two_color',
					array(
						'label' => esc_html__( 'CTA Button Color Two', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_cta_btn_two_bg', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_btn_two_bg',
					array(
						'label' => esc_html__( 'CTA Button Background Color Two', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_agents_home_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_agents_home_sep_labels',
					array(
						'label' => esc_html__('Agents ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_agents_title_span_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_agents_title_span_color',
					array(
						'label'       => esc_html__( 'Text Over Title Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #1ea69a', 'framework' ),
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_agents_title_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_agents_title_color',
					array(
						'label' 	=> esc_html__( 'Section Title Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Description Color */
			$wp_customize->add_setting( 'inspiry_home_agents_desc_color', array(
				'type' 		=> 'option',
				'default'	=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_agents_desc_color',
					array(
						'label' 	=> esc_html__( 'Section Description Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Agent Title Color */
			$wp_customize->add_setting( 'inspiry_agents_title_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_agents_title_color',
					array(
						'label' 	=> esc_html__( 'Agent Title Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Agent Title Hover Color */
			$wp_customize->add_setting( 'inspiry_agents_title_hover_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_agents_title_hover_color',
					array(
						'label' 	=> esc_html__( 'Agent Title Hover Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
						'description' => esc_html__('Default color is #1ea69a','framework'),
					)
				)
			);

			/* Agent Text Color */
			$wp_customize->add_setting( 'inspiry_agents_text_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_agents_text_color',
					array(
						'label' 	=> esc_html__( 'Agent Text Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Agent Phone Color */
			$wp_customize->add_setting( 'inspiry_agents_phone_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_agents_phone_color',
					array(
						'label' 	=> esc_html__( 'Agent Phone And Email Hover Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
						'description' => esc_html__('Default color is #1ea69a','framework'),
					)
				)
			);

			/* Agent Listed Properties Color */
			$wp_customize->add_setting( 'inspiry_agents_listed_props_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_agents_listed_props_color',
					array(
						'label' 	=> esc_html__( 'Agent Listed Properties Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
						'description' => esc_html__('Default color is #1ea69a','framework'),
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_agents_background_color', array(
				'type' 		=> 'option',
				'default'	=> '#f7f7f7',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_agents_background_color',
					array(
						'label'       => esc_html__( 'Section Background Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_features_home_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_features_home_sep_labels',
					array(
						'label' => esc_html__('Features ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_features_title_span_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_features_title_span_color',
					array(
						'label'       => esc_html__( 'Text Over Title Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #1ea69a', 'framework' ),
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_features_title_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_features_title_color',
					array(
						'label' 	=> esc_html__( 'Section Title Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Description Color */
			$wp_customize->add_setting( 'inspiry_home_features_desc_color', array(
				'type' 		=> 'option',
				'default'	=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_features_desc_color',
					array(
						'label' 	=> esc_html__( 'Section Description Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Feature Title Color */
			$wp_customize->add_setting( 'inspiry_home_feature_title_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_feature_title_color',
					array(
						'label' 	=> esc_html__( 'Feature Title Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Feature Text Color */
			$wp_customize->add_setting( 'inspiry_home_feature_text_color', array(
				'type' 		=> 'option',
				'default'	=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_feature_text_color',
					array(
						'label' 	=> esc_html__( 'Feature Text Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Features Background */
			$wp_customize->add_setting( 'inspiry_home_features_background_colors', array(
				'type' 		=> 'option',
			'default'	=> '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_features_background_colors',
					array(
						'label'       => esc_html__( 'Section Background Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
					)
				)
			);


			$wp_customize->add_setting( 'inspiry_partners_home_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_partners_home_sep_labels',
					array(
						'label' => esc_html__('Partners ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_partners_title_span_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_partners_title_span_color',
					array(
						'label'       => esc_html__( 'Text Over Title Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #1ea69a', 'framework' ),
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_partners_title_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_partners_title_color',
					array(
						'label' 	=> esc_html__( 'Section Title Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Description Color */
			$wp_customize->add_setting( 'inspiry_home_partners_desc_color', array(
				'type' 		=> 'option',
				'default'	=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_partners_desc_color',
					array(
						'label' 	=> esc_html__( 'Section Description Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_home_partners_background_colors', array(
				'type' 		=> 'option',
				'default'	=> '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_partners_background_colors',
					array(
						'label'       => esc_html__( 'Section Background Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_news_home_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_news_home_sep_labels',
					array(
						'label' => esc_html__('News & Updates ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);


			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_news_title_span_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_news_title_span_color',
					array(
						'label'       => esc_html__( 'Text Over Title Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #1ea69a', 'framework' ),
					)
				)
			);

			/* Section Title Color */
			$wp_customize->add_setting( 'inspiry_home_news_title_color', array(
				'type' 		=> 'option',
				'default'	=> '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_news_title_color',
					array(
						'label' 	=> esc_html__( 'Section Title Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Section Description Color */
			$wp_customize->add_setting( 'inspiry_home_news_desc_color', array(
				'type' 		=> 'option',
				'default'	=> '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_news_desc_color',
					array(
						'label' 	=> esc_html__( 'Section Description Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_home_news_background_colors', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_news_background_colors',
					array(
						'label'       => esc_html__( 'Section Background Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_cta_contact_home_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_cta_contact_home_sep_labels',
					array(
						'label' => esc_html__('CTA-Contact ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);

			// CTA Background Color.
			$wp_customize->add_setting( 'inspiry_home_cta_bg_color', array(
				'type' 		=> 'option',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_home_cta_bg_color',
					array(
						'label' 	=> esc_html__( 'CTA Overlay Color', 'framework' ),
						'section' 	=> 'inspiry_home_page_styles',
						'description' => esc_html__('Default color is #1EA69A','framework'),
					)
				)
			);

			/* CTA Contact Title Color */
			$wp_customize->add_setting( 'inspiry_cta_contact_title_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_contact_title_color',
					array(
						'label' => esc_html__( 'CTA Contact Title Color', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			/* CTA Contact Description Color */
			$wp_customize->add_setting( 'inspiry_cta_contact_desc_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_contact_desc_color',
					array(
						'label' => esc_html__( 'CTA Contact Description Color', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_cta_contact_btn_one_color', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_contact_btn_one_color',
					array(
						'label' => esc_html__( 'CTA Button Color One', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_cta_contact_btn_one_bg', array(
				'type' => 'option',
				'default' => '#303030',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_contact_btn_one_bg',
					array(
						'label' => esc_html__( 'CTA Button Background Color One', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_cta_contact_btn_two_color', array(
				'type' => 'option',
				'default' => '#303030',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_contact_btn_two_color',
					array(
						'label' => esc_html__( 'CTA Button Color Two', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);

			$wp_customize->add_setting( 'inspiry_cta_contact_btn_two_bg', array(
				'type' => 'option',
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_cta_contact_btn_two_bg',
					array(
						'label' => esc_html__( 'CTA Button Background Color Two', 'framework' ),
						'section' => 'inspiry_home_page_styles',
					)
				)
			);



		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_features_section_home_sep_labels', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Heading_Customize_Control(
					$wp_customize,
					'inspiry_features_section_home_sep_labels',
					array(
						'label' => esc_html__('Features Section ','framework'),
						'section' 	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Features Section Text Color */
			$wp_customize->add_setting( 'inspiry_features_text_color', array(
				'default' 			=> '#FFFFFF',
				'type' 				=> 'option',
				'sanitize_callback'	=> 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_features_text_color',
					array(
						'label' 	=> esc_html__( 'Section Text Color', 'framework' ),
						'section'	=> 'inspiry_home_page_styles',
					)
				)
			);

			/* Features Section Background Color */
			$wp_customize->add_setting( 'inspiry_features_background_color', array(
				'type' 				=> 'option',
				'sanitize_callback'	=> 'sanitize_hex_color',
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'inspiry_features_background_color',
					array(
						'label'       => esc_html__( 'Section Background Color', 'framework' ),
						'section'     => 'inspiry_home_page_styles',
						'description' => esc_html__( 'Default color is #3EB6E0', 'framework' ),
					)
				)
			);

		}

	}

	add_action( 'customize_register', 'inspiry_home_page_styles_customizer' );

}

if ( ! function_exists( 'inspiry_styles_homepage_defaults' ) ) :

	/**
	 * inspiry_styles_gallery_defaults.
	 *
	 * @param  WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 * @since  3.0.0
	 */
	function inspiry_styles_homepage_defaults( WP_Customize_Manager $wp_customize ) {
		$styles_settings_ids = array(
			'theme_featured_prop_title_span_color',
			'theme_featured_prop_title_color',
			'theme_featured_prop_text_color',
			'inspiry_features_text_color',
			'inspiry_features_background_color',
			'inspiry_home_agents_title_span_color',
			'inspiry_home_agents_title_color',
			'inspiry_home_agents_desc_color',
			'inspiry_agents_title_color',
			'inspiry_agents_title_hover_color',
			'inspiry_agents_text_color',
			'inspiry_agents_phone_color',
			'inspiry_agents_listed_props_color',
			'inspiry_home_features_title_span_color',
			'inspiry_home_features_title_color',
			'inspiry_home_features_desc_color',
			'inspiry_home_feature_title_color',
			'inspiry_home_feature_text_color',
			'inspiry_home_partners_title_span_color',
			'inspiry_home_partners_title_color',
			'inspiry_home_partners_desc_color',
			'inspiry_testimonial_color',
			'inspiry_testimonial_name_color',
			'inspiry_testimonial_url_color',
		);
		inspiry_initialize_defaults( $wp_customize, $styles_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_styles_homepage_defaults' );
endif;
