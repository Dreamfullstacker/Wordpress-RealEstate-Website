<?php
/**
 * Section:    `Child Properties`
 * Panel:    `Property Detail Page`
 *
 * @since 3.10
 */

if ( ! function_exists( 'inspiry_child_properties_customizer' ) ) :
	/**
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  3.10
	 */
	function inspiry_child_properties_customizer( WP_Customize_Manager $wp_customize ) {
		/**
		 * Child Properties Section
		 */
		$wp_customize->add_section( 'inspiry_child_properties', array(
			'title'    => esc_html__( 'Child Properties', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 15
		) );

		/* Child Properties Title  */
		$wp_customize->add_setting(
			'theme_child_properties_title', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Sub Properties', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			'theme_child_properties_title', array(
			'label'       => esc_html__( 'Child Properties Title', 'framework' ),
			'description' => esc_html__( 'This will only display if a property has child properties.', 'framework' ),
			'type'        => 'text',
			'section'     => 'inspiry_child_properties',
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial(
					'theme_child_properties_title', array(
						'selector'            => '.rh_property__child_properties .rh_property__heading',
						'container_inclusive' => false,
						'render_callback'     => 'theme_child_properties_title_render',
					)
				);
			}
		}

		/* Child Properties Layout */
		$wp_customize->add_setting( 'inspiry_child_properties_layout', array(
			'type'              => 'option',
			'default'           => 'default',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_child_properties_layout', array(
			'label'   => esc_html__( 'Child Properties Layout', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_child_properties',
			'choices' => array(
				'default' => esc_html__( 'Default', 'framework' ),
				'table'   => esc_html__( 'Table', 'framework' ),
			),
		) );
	}

	add_action( 'customize_register', 'inspiry_child_properties_customizer' );
endif;

if ( ! function_exists( 'inspiry_child_properties_defaults' ) ) :
	/**
	 * @since 3.10
	 */
	function inspiry_child_properties_defaults( WP_Customize_Manager $wp_customize ) {
		$child_properties_settings_ids = array(
			'theme_child_properties_title',
			'inspiry_child_properties_layout',
		);

		inspiry_initialize_defaults( $wp_customize, $child_properties_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_child_properties_defaults' );
endif;

if ( ! function_exists( 'theme_child_properties_title_render' ) ) {
	/**
	 * Partial Refresh Render
	 *
	 * @since  3.0.0
	 */
	function theme_child_properties_title_render() {
		if ( get_option( 'theme_child_properties_title' ) ) {
			echo esc_html( get_option( 'theme_child_properties_title' ) );
		}
	}
}