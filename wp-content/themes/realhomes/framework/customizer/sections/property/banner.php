<?php
if ( ! function_exists( 'inspiry_single_property_banner_customizer' ) ) {
	/**
	 * Single property banner customizer settings.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since 3.10.2
	 */
	function inspiry_single_property_banner_customizer( WP_Customize_Manager $wp_customize ) {

		// Banner Section
		$wp_customize->add_section( 'inspiry_single_property_banner', array(
			'title'    => esc_html__( 'Banner', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 2
		) );

		// Single Property Banner Title Display
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_single_property_banner_title', array(
				'type'              => 'option',
				'default'           => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'inspiry_single_property_banner_title', array(
				'label'   => esc_html__( 'Property Title', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_single_property_banner',
				'choices' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_single_property_banner_customizer' );
}