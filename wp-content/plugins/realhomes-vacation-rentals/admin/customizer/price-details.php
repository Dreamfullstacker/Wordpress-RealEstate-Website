<?php
/**
 * Section: Price Details
 * Panel:   Property Detail page.
 *
 * @since 1.3.0
 * @package realhoems_vacation_rentals/admin/customizer
 */

if ( ! function_exists( 'inspiry_price_details_customizer' ) ) {

	/**
	 * Price Details Customizer Settings Section.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Object.
	 *
	 * @since  1.3.0
	 */
	function inspiry_price_details_customizer( WP_Customize_Manager $wp_customize ) {

		// Section Title.
		$wp_customize->add_section(
			'inspiry_price_details_section',
			array(
				'title'    => esc_html__( 'Price Details', 'realhomes-vacation-rentals' ),
				'panel'    => 'inspiry_property_panel',
				'priority' => 31
			)
		);

		/* Price Details Section Display */
		$wp_customize->add_setting(
			'inspiry_price_details_display',
			array(
				'type'              => 'option',
				'default'           => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_price_details_display',
			array(
				'label'   => esc_html__( 'Price Details', 'realhomes-vacation-rentals' ),
				'type'    => 'radio',
				'section' => 'inspiry_price_details_section',
				'choices' => array(
					'true'  => esc_html__( 'Show', 'realhomes-vacation-rentals' ),
					'false' => esc_html__( 'Hide', 'realhomes-vacation-rentals' ),
				),
			),
		);

		/* Price Details Section Heading */
		$wp_customize->add_setting(
			'inspiry_price_details_heading',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Price Details', 'realhomes-vacation-rentals' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_price_details_heading',
			array(
				'label'   => esc_html__( 'Price Details Heading', 'realhomes-vacation-rentals' ),
				'type'    => 'text',
				'section' => 'inspiry_price_details_section',
			)
		);

		/* Price Details Heading Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$section_heading_selector = '#price-details-wrap .title';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$section_heading_selector = '.rvr_price_details_wrap .rh_property__heading';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'inspiry_price_details_heading',
				array(
					'selector'            => $section_heading_selector,
					'container_inclusive' => false,
					'render_callback'     => 'inspiry_price_details_heading_render',
				)
			);
		}
	}

	add_action( 'customize_register', 'inspiry_price_details_customizer' );
}
add_action( 'customize_register', 'inspiry_price_details_customizer', 1, 10 );
if ( ! function_exists( 'inspiry_price_details_heading_render' ) ) {
	/**
	 * Price Details heading selective refresh rendering.
	 */
	function inspiry_price_details_heading_render() {
		if ( get_option( 'inspiry_price_details_heading' ) ) {
			echo esc_html( get_option( 'inspiry_price_details_heading' ) );
		}
	}
}
