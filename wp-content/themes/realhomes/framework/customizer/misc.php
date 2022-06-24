<?php
/**
 * Misc Customizer Settings
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_misc_customizer' ) ) :
	function inspiry_misc_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Misc Section
		 */
		$wp_customize->add_section( 'inspiry_misc_section', array(
			'title'    => esc_html__( 'Misc', 'framework' ),
			'priority' => 140,
		) );


		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			/* Change 'View Property' across the theme */
			$wp_customize->add_setting( 'inspiry_property_detail_page_link_text', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'View Property', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_property_detail_page_link_text', array(
				'label'       => esc_html__( 'Property Detail Page Link Text', 'framework' ),
				'description' => esc_html__( 'You can change "View Property" button text ( appears on hovering over property card image ) with any other text across the theme here.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_misc_section',
			) );
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			/* Change 'Know More' across theme */
			$wp_customize->add_setting( 'inspiry_string_know_more', array(
				'type'              => 'option',
				'default'           => esc_html__( 'Know More', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( 'inspiry_string_know_more', array(
				'label'       => esc_html__( 'Replace "Know More" Button Text', 'framework' ),
				'description' => esc_html__( 'You can change "Know More" button text with any other text across the theme here', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_misc_section',
			) );
		}


		$wp_customize->add_setting( 'inspiry_properties_placeholder_image', array(
			'type'              => 'option',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'inspiry_properties_placeholder_image', array(
			'label'       => esc_html__( 'Properties Custom Placeholder Image', 'framework' ),
			'description' => esc_html__( 'Upload an image bigger than 1200px width and 680px height.', 'framework' ),
			'section'     => 'inspiry_misc_section',
		) ) );

		$wp_customize->add_setting( 'inspiry_scroll_to_top', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_scroll_to_top', array(
			'label'   => esc_html__( 'Show Scroll To Top Button', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_misc_section',
			'choices' => array(
				'true'  => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_scroll_to_top_position', array(
			'type'              => 'option',
			'default'           => 'stp_right',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_scroll_to_top_position', array(
			'label'           => esc_html__( 'Scroll To Top Button Position', 'framework' ),
			'type'            => 'radio',
			'section'         => 'inspiry_misc_section',
			'choices'         => array(
				'stp_right' => esc_html__( 'Right', 'framework' ),
				'stp_left'  => esc_html__( 'Left', 'framework' ),
			),
			'active_callback' => 'inspiry_scroll_to_top',
		) );

		$wp_customize->add_setting( 'inspiry_stp_position_from_bottom', array(
			'type'              => 'option',
			'default'           => '15px',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_stp_position_from_bottom', array(
			'label'           => esc_html__( 'Scroll To Top Button Position From Bottom (i.e 15px or 10%)', 'framework' ),
			'type'            => 'text',
			'section'         => 'inspiry_misc_section',
			'active_callback' => 'inspiry_scroll_to_top',
		) );


		$wp_customize->add_setting( 'inspiry_select2_no_result_string', array(
			'type'              => 'option',
			'default'           => esc_html__( 'No Results Found!', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_select2_no_result_string', array(
			'label'   => esc_html__( 'Select Drop Down No Result Text', 'framework' ),
			'type'    => 'text',
			'section' => 'inspiry_misc_section',
		) );

		$wp_customize->add_setting( 'inspiry_unset_default_image_sizes', array(
			'type'              => 'option',
			'default'           => 'false',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_unset_default_image_sizes', array(
			'label'       => esc_html__( 'Disable Default Image Sizes ?', 'framework' ),
			'description' => esc_html__( 'Choosing "Yes" will disable WordPress default cropped image sizes (small, medium, medium_large, large) whenever an image is being uploaded', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_misc_section',
			'choices'     => array(
				'true'  => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );

	}

	add_action( 'customize_register', 'inspiry_misc_customizer' );
endif;


if ( ! function_exists( 'inspiry_misc_defaults' ) ) :
	/**
	 * Set default values for misc settings
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function inspiry_misc_defaults( WP_Customize_Manager $wp_customize ) {
		$misc_settings_ids = array(
			'inspiry_scroll_to_top_position',
		);
		inspiry_initialize_defaults( $wp_customize, $misc_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_misc_defaults' );
endif;

if ( ! function_exists( 'inspiry_scroll_to_top' ) ) {
	/**
	 * Check if show option selected in scroll to top radio button
	 *
	 * @param $control
	 *
	 * @return bool
	 */
	function inspiry_scroll_to_top( $control ) {

		if ( 'false' === $control->manager->get_setting( 'inspiry_scroll_to_top' )->value() ) {
			return false;
		}

		return true;
	}
}