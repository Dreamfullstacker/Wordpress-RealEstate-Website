<?php
/**
 * Section: Guests Accommodation
 * Panel:   Property Detail page.
 *
 * @since 1.3.0
 * @package realhomes_vacation_rentals/admin/customizer
 */

if ( ! function_exists( 'inspiry_guests_accommodation_customizer' ) ) {

	/**
	 * Guests Accommodation Customizer Settings Section.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer Object.
	 *
	 * @since  1.3.0
	 */
	function inspiry_guests_accommodation_customizer( WP_Customize_Manager $wp_customize ) {

		// Section Title.
		$wp_customize->add_section(
			'inspiry_guests_accommodation_section',
			array(
				'title'    => esc_html__( 'Guests Accommodation', 'realhomes-vacation-rentals' ),
				'panel'    => 'inspiry_property_panel',
				'priority' => 33
			)
		);

		/* Guests Accommodation Section Display */
		$wp_customize->add_setting(
			'inspiry_guests_accommodation_display',
			array(
				'type'              => 'option',
				'default'           => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_guests_accommodation_display',
			array(
				'label'   => esc_html__( 'Guests Accommodation', 'realhomes-vacation-rentals' ),
				'type'    => 'radio',
				'section' => 'inspiry_guests_accommodation_section',
				'choices' => array(
					'true'  => esc_html__( 'Show', 'realhomes-vacation-rentals' ),
					'false' => esc_html__( 'Hide', 'realhomes-vacation-rentals' ),
				),
			),
		);

		/* Guests Accommodation Section Heading */
		$wp_customize->add_setting(
			'inspiry_guests_accommodation_heading',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Guests Accommodation', 'realhomes-vacation-rentals' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_guests_accommodation_heading',
			array(
				'label'   => esc_html__( 'Guests Accommodation Heading', 'realhomes-vacation-rentals' ),
				'type'    => 'text',
				'section' => 'inspiry_guests_accommodation_section',
			)
		);

		/* Guests Accommodation Heading Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'inspiry_guests_accommodation_heading',
				array(
					'selector'            => '.rvr_guests_accommodation_wrap .rh_property__heading',
					'container_inclusive' => false,
					'render_callback'     => 'inspiry_guests_accommodation_heading_render',
				)
			);
		}
	}

	add_action( 'customize_register', 'inspiry_guests_accommodation_customizer' );
}

if ( ! function_exists( 'inspiry_guests_accommodation_heading_render' ) ) {
	/**
	 * Guests accommodation heading selective refresh rendering.
	 */
	function inspiry_guests_accommodation_heading_render() {
		$guests_accommodation_heading = get_option( 'inspiry_guests_accommodation_heading' );
		if ( $guests_accommodation_heading ) {
			echo esc_html( $guests_accommodation_heading );
		}
	}
}
