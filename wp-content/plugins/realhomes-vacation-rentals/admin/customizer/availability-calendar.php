<?php
/**
 * Section:    `Availability Calendar`
 * Panel:    `Property Detail Page`
 *
 * @since 1.3.0
 * @package realhomes_vacation_rentals/customizer
 */

if ( ! function_exists( 'inspiry_availability_calendar_customizer' ) ) :

	/**
	 * inspiry_availability_calendar_customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @since  1.3.0
	 */
	function inspiry_availability_calendar_customizer( WP_Customize_Manager $wp_customize ) {

		if ( ! class_exists( 'ERE_Data' ) ) {
			return;
		}

		/**
		 * Availability Calendar Section
		 */
		$wp_customize->add_section( 'inspiry_availability_calendar', array(
			'title'    => esc_html__( 'Availability Calendar', 'realhomes-vacation-rentals' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 34
		) );

		/* Show/Hide Availability Calendar */
		$wp_customize->add_setting( 'inspiry_display_availability_calendar', array(
			'type'              => 'option',
			'default'           => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_display_availability_calendar', array(
			'label'   => esc_html__( 'Availability Calendar', 'realhomes-vacation-rentals' ),
			'type'    => 'radio',
			'section' => 'inspiry_availability_calendar',
			'choices' => array(
				'true'  => esc_html__( 'Show', 'realhomes-vacation-rentals' ),
				'false' => esc_html__( 'Hide', 'realhomes-vacation-rentals' ),
			),
		) );

		$wp_customize->add_setting( 'inspiry_statuses_to_show_availability_calendar', array(
			'type'              => 'option',
			'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
		) );
		$wp_customize->add_control( new Inspiry_Multiple_Checkbox_Customize_Control( $wp_customize, 'inspiry_statuses_to_show_availability_calendar',
			array(
				'label'   => esc_html__( 'Choose Property Statuses to Show Availability Calendar', 'realhomes-vacation-rentals' ),
				'section' => 'inspiry_availability_calendar',
				'choices' => ERE_Data::get_statuses_id_name(),
			)
		) );

		/* Property Availability Calendar Title */
		$wp_customize->add_setting( 'inspiry_availability_calendar_title', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Property Availability', 'realhomes-vacation-rentals' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_availability_calendar_title', array(
			'label'   => esc_html__( 'Property Availability Title', 'realhomes-vacation-rentals' ),
			'type'    => 'text',
			'section' => 'inspiry_availability_calendar',
		) );

		/* Availability Calendar Title Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$availability_calendar_selector = '.availability-calendar-wrap h4';
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$availability_calendar_selector = '.rh_property__ava_calendar_wrap .rh_property__heading';
		}
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_availability_calendar_title', array(
				'selector'            => $availability_calendar_selector,
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_availability_calendar_title_render',
			) );
		}

		/* Show/Hide Property Reserved Dates in REST API */
		$wp_customize->add_setting(
			'inspiry_property_reservations_in_rest',
			array(
				'type'              => 'option',
				'default'           => 'hide',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_property_reservations_in_rest',
			array(
				'label'       => esc_html__( 'Property Reserved Dates in REST API', 'realhomes-vacation-rentals' ),
				'description' => sprintf( esc_html__( 'You can learn about WordPress REST API by %s.', 'realhomes-vacation-rentals' ), '<a href="https://developer.wordpress.org/rest-api/" target="_blank">clicking here</a>' ),
				'type'        => 'radio',
				'section'     => 'inspiry_availability_calendar',
				'choices'     => array(
					'show' => esc_html__( 'Show', 'realhomes-vacation-rentals' ),
					'hide' => esc_html__( 'Hide', 'realhomes-vacation-rentals' ),
				),
			)
		);
	}

	add_action( 'customize_register', 'inspiry_availability_calendar_customizer' );
endif;


if ( ! function_exists( 'inspiry_availability_calendar_title_render' ) ) {
	function inspiry_availability_calendar_title_render() {
		if ( get_option( 'inspiry_availability_calendar_title' ) ) {
			echo esc_html( get_option( 'inspiry_availability_calendar_title' ) );
		}
	}
}