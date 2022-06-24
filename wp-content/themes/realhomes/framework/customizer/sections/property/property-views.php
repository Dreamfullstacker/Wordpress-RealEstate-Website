<?php
/**
 * Section: `Property Views`
 * Panel:   `Property Detail Page`
 *
 * @since 3.10
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_property_views_customizer' ) ) :
	/**
	 * Add Property Views customizer section options.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	function inspiry_property_views_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Property Views Section.
		 */
		$wp_customize->add_section(
			'inspiry_property_views',
			array(
				'title'    => esc_html__( 'Property Views', 'framework' ),
				'panel'    => 'inspiry_property_panel',
				'priority' => 8
			)
		);

		// Show/Hide Property Views.
		$wp_customize->add_setting(
			'inspiry_display_property_views',
			array(
				'type'              => 'option',
				'default'           => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);

		$wp_customize->add_control(
			'inspiry_display_property_views',
			array(
				'label'   => esc_html__( 'Property Views', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_views',
				'choices' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
			)
		);

		// Property Views Title.
		$wp_customize->add_setting(
			'inspiry_property_views_title',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Property Views', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'inspiry_property_views_title',
			array(
				'label'   => esc_html__( 'Property Views Title', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_property_views',
			)
		);

		// Property Views Title Selective Refresh.
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$heading_selector = '.property-views-wrap h4';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$heading_selector = '.rh_property__views_wrap .rh_property__heading';
		}

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'inspiry_property_views_title',
				array(
					'selector'            => $heading_selector,
					'container_inclusive' => false,
					'render_callback'     => 'inspiry_property_views_title_render',
				)
			);
		}
	}

	add_action( 'customize_register', 'inspiry_property_views_customizer' );
endif;

if ( ! function_exists( 'inspiry_property_views_title_render' ) ) {
	/**
	 * Return property views section title.
	 */
	function inspiry_property_views_title_render() {
		if ( get_option( 'inspiry_property_views_title' ) ) {
			echo esc_html( get_option( 'inspiry_property_views_title' ) );
		}
	}
}
