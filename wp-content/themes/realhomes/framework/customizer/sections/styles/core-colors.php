<?php
/**
 * Section:    `Core Styles`
 * Panel:    `Styles`
 *
 * @package realhomes/customizer
 * @since 3.4.2
 */
if ( ! function_exists( 'inspiry_basic_settings_customizer' ) ) {
	function inspiry_basic_settings_customizer( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section( 'inspiry_core_colors_section', array(
			'title' => esc_html__( 'Core Colors', 'framework' ),
			'panel' => 'inspiry_styles_panel',
		) );

		$wp_customize->add_setting( 'inspiry_basic_core_note_two', array( 'sanitize_callback' => 'sanitize_text_field', ) );
		$wp_customize->add_control(
			new Inspiry_Intro_Customize_Control(
				$wp_customize,
				'inspiry_basic_core_note_two',
				array(
					'section'     => 'inspiry_core_colors_section',
					'label'       => esc_html__( 'Important Note:', 'framework' ),
					'description' => esc_html__( "The setting will be restored to the Default option automatically whenever the design variation is changed. So that you can view freshly changed design variations in original colors.", 'framework' ),
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'inspiry_default_styles', array(
				'default'           => 'custom',
				'sanitize_callback' => 'inspiry_sanitize_radio',
				'type'              => 'option'
			) );
			$wp_customize->add_control( 'inspiry_default_styles', array(
				'label'    => esc_html__( 'Theme colors', 'framework' ),
				'section'  => 'inspiry_core_colors_section',
				'type'     => 'radio',
				'choices'  => array(
					'default' => esc_html__( 'Default', 'framework' ),
					'custom'  => esc_html__( 'Custom', 'framework' ),
				),
			) );

			// Separator
			$wp_customize->add_setting( 'inspiry_core_note_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Separator_Control(
					$wp_customize,
					'inspiry_core_note_separator',
					array(
						'section' => 'inspiry_core_colors_section',
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_color_orange_light', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#ec894d',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_color_orange_light',
					array(
						'label'       => esc_html__( 'Orange Light', 'framework' ),
						'description' => sprintf( esc_html__( 'Change core colors of %1$s
														• Main Menu %1$s
														• Search Form Button %1$s
														• Property Status Tag %1$s
														• Agent Know More Button %1$s
														• Agent Contact Form Button %1$s
														• Post Read More Button %1$s
														• Post Author Link %1$s
														• Post Tags %1$s
														• Post Reply Button %1$s
														• Gallery Filter %1$s
														• Contact Form Button %1$s
														 Default color is #ec894d ', 'framework' ), "<br>" ),
						'section'     => 'inspiry_core_colors_section',
						'settings'    => 'theme_core_color_orange_light',
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_color_orange_dark', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#dc7d44',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_color_orange_dark',
					array(
						'label'       => esc_html__( 'Orange Dark', 'framework' ),
						'description' => sprintf( esc_html__( 'Change core colors of %1$s
														• Main Menu Hover %1$s
														• Footer Widgets Links Hover %1$s
														• Sidebar Widgets Links Hover %1$s
														 Default color is #dc7d44 ', 'framework' ), "<br>" ),
						'section'     => 'inspiry_core_colors_section',
						'settings'    => 'theme_core_color_orange_dark',
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_color_orange_glow', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#e3712c',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_color_orange_glow',
					array(
						'label'       => esc_html__( 'Orange Glow', 'framework' ),
						'description' => sprintf( esc_html__( 'Change core colors of %1$s
														• Search Form Button Hover %1$s
														• Agent Know More Button Hover %1$s
														• Agent Contact Form Button Hover %1$s
														• Post Read More Button Hover %1$s
														• Post Tags Hover %1$s
														• Post Reply Button Hover %1$s
														• Pagination %1$s
														 Default color is #e3712c ', 'framework' ), "<br>" ),
						'section'     => 'inspiry_core_colors_section',
						'settings'    => 'theme_core_color_orange_glow',
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_color_orange_burnt', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#df5400',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_color_orange_burnt',
					array(
						'label'       => esc_html__( 'Orange Burnt', 'framework' ),
						'description' => sprintf( esc_html__( 'Change core colors of %1$s
														• Home Slider price and Title Hover %1$s
														• Property Title Hover %1$s
														• Property More Details Link Hover %1$s
														• footer Links Hover %1$s
														• Post Title Hover %1$s
														• Agent Title Hover in Listing  %1$s
														• Title Hover of Featured Properties Widget %1$s
														• Contact Page Email Hover %1$s
														• Feature Search Hover in Search Form Widget %1$s
														 Default color is #df5400 ', 'framework' ), "<br>" ),
						'section'     => 'inspiry_core_colors_section',
						'settings'    => 'theme_core_color_orange_burnt',
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_color_blue_light', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#4dc7ec',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_color_blue_light',
					array(
						'label'       => esc_html__( 'Blue light', 'framework' ),
						'description' => sprintf( esc_html__( 'Change core colors of %1$s
														• Header Phone Number Background %1$s
														• Search Form Drop Down Item Background  %1$s
														• Home Slider Know More %1$s
														• Property Price & type color/Background %1$s
														• Scroll To Top Button %1$s
														• Post Format Icon Background %1$s
														• Post Slider Navigation %1$s
														• Gallery Property Overlay %1$s

														 Default color is #4dc7ec ', 'framework' ), "<br>" ),
						'section'     => 'inspiry_core_colors_section',
						'settings'    => 'theme_core_color_blue_light',
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_color_blue_dark', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#37b3d9',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_color_blue_dark',
					array(
						'label'       => esc_html__( 'Blue Dark', 'framework' ),
						'description' => sprintf( esc_html__( 'Change core colors of %1$s
														• Header Phone Icon %1$s
														• Home Slider Know More Hover %1$s
														• Scroll To Top Button Hover %1$s
														• Banner Description Background %1$s
														• Banner Breadcrumbs Background %1$s

														 Default color is #37b3d9 ', 'framework' ), "<br>" ),
						'section'     => 'inspiry_core_colors_section',
						'settings'    => 'theme_core_color_blue_dark',
					)
				)
			);

		}

		if ( 'classic' !== INSPIRY_DESIGN_VARIATION ) {

			// Color schemes
			$wp_customize->add_setting( 'realhomes_color_scheme', array(
				'type'              => 'option',
				'default'           => 'custom',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'realhomes_color_scheme', array(
				'label'   => esc_html__( 'Color Scheme', 'framework' ),
				'type'    => 'select',
				'section' => 'inspiry_core_colors_section',
				'choices' => realhomes_color_schemes_list(),
			) );

			// Separator
			$wp_customize->add_setting( 'inspiry_color_scheme_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Separator_Control(
					$wp_customize,
					'inspiry_color_scheme_separator',
					array(
						'section' => 'inspiry_core_colors_section',
						'active_callback' => 'realhomes_is_custom_color_scheme'
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_mod_color_green', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#1ea69a',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_mod_color_green',
					array(
						'label'           => esc_html__( 'Primary', 'framework' ),
						'section'         => 'inspiry_core_colors_section',
						'active_callback' => 'realhomes_is_custom_color_scheme'
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_mod_color_green_dark', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#0b8278',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control( $wp_customize,
					'theme_core_mod_color_green_dark',
					array(
						'label'           => esc_html__( 'Primary Dark', 'framework' ),
						'section'         => 'inspiry_core_colors_section',
						'active_callback' => 'realhomes_is_custom_color_scheme'
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_mod_color_orange', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#ea723d',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_mod_color_orange',
					array(
						'label'           => esc_html__( 'Secondary', 'framework' ),
						'section'         => 'inspiry_core_colors_section',
						'active_callback' => 'realhomes_is_custom_color_scheme'
					)
				)
			);

			$wp_customize->add_setting( 'theme_core_mod_color_orange_dark', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#ea5819',
				'type'              => 'option'
			) );
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'theme_core_mod_color_orange_dark',
					array(
						'label'           => esc_html__( 'Secondary Dark', 'framework' ),
						'section'         => 'inspiry_core_colors_section',
						'active_callback' => 'realhomes_is_custom_color_scheme'
					)
				)
			);

			// Separator
			$wp_customize->add_setting( 'realhomes_separator_2', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control( new Inspiry_Separator_Control( $wp_customize, 'realhomes_separator_2',
				array(
					'section'         => 'inspiry_core_colors_section',
					'active_callback' => 'realhomes_is_custom_color_scheme'
				)
			) );

			// Body Color
			$wp_customize->add_setting( 'inspiry_body_font_color', array(
				'type'              => 'option',
				'default'           => '#808080',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'inspiry_body_font_color',
				array(
					'label'           => esc_html__( 'Text Color', 'framework' ),
					'section'         => 'inspiry_core_colors_section',
					'active_callback' => 'realhomes_is_custom_color_scheme'
				)
			) );

			// Heading Color
			$wp_customize->add_setting( 'inspiry_heading_font_color', array(
				'type'              => 'option',
				'default'           => '#1a1a1a',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'inspiry_heading_font_color',
				array(
					'label'           => esc_html__( 'Headings Color', 'framework' ),
					'section'         => 'inspiry_core_colors_section',
					'active_callback' => 'realhomes_is_custom_color_scheme'
				)
			) );

			// Headings Color Hover
			$wp_customize->add_setting( 'realhomes_global_headings_hover_color', array(
				'type'              => 'option',
				'default'           => '#ea723d',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'realhomes_global_headings_hover_color',
				array(
					'label'           => esc_html__( 'Headings Hover Color', 'framework' ),
					'section'         => 'inspiry_core_colors_section',
					'active_callback' => 'realhomes_is_custom_color_scheme'
				)
			) );

			// Link Color
			$wp_customize->add_setting( 'realhomes_global_link_color', array(
				'type'              => 'option',
				'default'           => '#444444',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'realhomes_global_link_color',
				array(
					'label'           => esc_html__( 'Link Color', 'framework' ),
					'section'         => 'inspiry_core_colors_section',
					'active_callback' => 'realhomes_is_custom_color_scheme'
				)
			) );

			// Link Color Hover
			$wp_customize->add_setting( 'realhomes_global_link_hover_color', array(
				'type'              => 'option',
				'default'           => '#ea723d',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'realhomes_global_link_hover_color',
				array(
					'label'           => esc_html__( 'Link Hover Color', 'framework' ),
					'section'         => 'inspiry_core_colors_section',
					'active_callback' => 'realhomes_is_custom_color_scheme'
				)
			) );

			// Separator
			$wp_customize->add_setting( 'realhomes_selection_bg_color_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control( new Inspiry_Separator_Control( $wp_customize, 'realhomes_selection_bg_color_separator',
				array(
					'section'         => 'inspiry_core_colors_section',
					'active_callback' => 'realhomes_is_custom_color_scheme'
				)
			) );

			$wp_customize->add_setting( 'realhomes_selection_bg_color', array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => '#1ea69a',
				'type'              => 'option'
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'realhomes_selection_bg_color',
				array(
					'label'           => esc_html__( 'Site Selection Background Color', 'framework' ),
					'section'         => 'inspiry_core_colors_section',
					'active_callback' => 'realhomes_is_custom_color_scheme'
				)
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_basic_settings_customizer' );
}

function realhomes_is_custom_color_scheme() {

	if ( 'custom' === get_option( 'realhomes_color_scheme', 'custom' ) ) {
		return true;
	}

	return false;
}