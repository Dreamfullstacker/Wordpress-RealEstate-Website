<?php
/**
 * Gallery Customizer
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_gallery_customizer' ) ) :
	function inspiry_gallery_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Gallery Section
		 */
		$wp_customize->add_section( 'inspiry_gallery_section', array(
			'title'    => esc_html__( 'Gallery Pages', 'framework' ),
			'priority' => 125,
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Header Banner or None */
			$wp_customize->add_setting( 'inspiry_gallery_header_variation', array(
				'type'              => 'option',
				'default'           => 'banner',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'inspiry_gallery_header_variation', array(
				'label'       => esc_html__( 'Header Variation', 'framework' ),
				'description' => esc_html__( 'Header variation to display on Gallery Pages.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_gallery_section',
				'choices'     => array(
					'banner' => esc_html__( 'Banner', 'framework' ),
					'none'   => esc_html__( 'None', 'framework' ),
				),
			) );
		}

		/* Banner Title */
		$wp_customize->add_setting( 'theme_gallery_banner_title', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Properties Gallery', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_gallery_banner_title', array(
			'label'   => esc_html__( 'Banner Title', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_gallery_section',
		) );

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			/* Banner Sub Title */
			$wp_customize->add_setting( 'theme_gallery_banner_sub_title', array(
				'type'              => 'option',
				'default'           => esc_html__( 'Skim Through Available Properties', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'theme_gallery_banner_sub_title', array(
				'label'   => esc_html__( 'Banner Sub Title', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_gallery_section',
			) );
		}

		/* Properties Sorting */
		$wp_customize->add_setting( 'inspiry_gallery_properties_sorting', array(
			'type'              => 'option',
			'default'           => 'hide',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_gallery_properties_sorting', array(
			'label'   => esc_html__( 'Properties Sort Control', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_gallery_section',
			'choices' => array(
				'show' => esc_html__( 'Show', 'framework' ),
				'hide' => esc_html__( 'Hide', 'framework' ),
			),
		) );
	}

	add_action( 'customize_register', 'inspiry_gallery_customizer' );
endif;


if ( ! function_exists( 'inspiry_gallery_defaults' ) ) :
	/**
	 * Set default values for gallery settings
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function inspiry_gallery_defaults( WP_Customize_Manager $wp_customize ) {
		$gallery_settings_ids = array(
			'inspiry_gallery_header_variation',
			'theme_gallery_banner_title',
			'theme_gallery_banner_sub_title',
		);
		inspiry_initialize_defaults( $wp_customize, $gallery_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_gallery_defaults' );
endif;
