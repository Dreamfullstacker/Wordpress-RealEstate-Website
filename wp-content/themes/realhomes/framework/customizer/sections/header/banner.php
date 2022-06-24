<?php
/**
 * Section: `Banner`
 * Panel: `Header`
 *
 * @package realhomes/customizer
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_banner_customizer' ) ) :

	/**
	 * Banner section in the Header Panel.
	 *
	 * @param  object $wp_customize - Instance of WP_Customize_Manager.
	 * @since  2.6.3
	 */
	function inspiry_banner_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Banner Section
		 */
		$wp_customize->add_section( 'inspiry_header_banner', array(
			'title' => esc_html__( 'Banner', 'framework' ),
			'panel' => 'inspiry_header_panel',
		) );

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$description = esc_html__( 'Required minimum height is 230px and minimum width is 2000px.', 'framework' );
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$description = esc_html__( 'Required minimum height is 550px and minimum width is 2000px.', 'framework' );
		}

		$wp_customize->add_setting( 'theme_general_banner_image', array(
			'type' => 'option',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'theme_general_banner_image',
				array(
					'label' => esc_html__( 'Header Banner Image', 'framework' ),
					'description' => esc_html( $description ),
					'section' => 'inspiry_header_banner',
				)
			)
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$banner_label = esc_html__( 'Hide Title and Subtitle From Image Banner', 'framework' );
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$banner_label = esc_html__( 'Hide Title From Image Banner', 'framework' );
		}

		$wp_customize->add_setting( 'theme_banner_titles', array(
			'type' => 'option',
			'default' => 'false',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_banner_titles', array(
			'label' => esc_html( $banner_label ),
			'type' => 'radio',
			'section' => 'inspiry_header_banner',
			'choices' => array(
				'true' => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );

	}

	add_action( 'customize_register', 'inspiry_banner_customizer' );
endif;


if ( ! function_exists( 'inspiry_banner_defaults' ) ) :

	/**
	 * Default settings.
	 *
	 * @param object $wp_customize - Instance of WP_Customize_Manager.
	 * @since  2.6.3
	 */
	function inspiry_banner_defaults( WP_Customize_Manager $wp_customize ) {
		$banner_settings_ids = array(
			'theme_banner_titles',
		);
		inspiry_initialize_defaults( $wp_customize, $banner_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_banner_defaults' );
endif;
