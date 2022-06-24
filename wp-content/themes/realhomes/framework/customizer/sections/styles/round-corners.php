<?php
/**
 * Section:  `Theme Round Corners`
 * Panel:    `Styles`
 *
 * @package realhomes/customizer
 * @since 3.15
 */

/**
 * Determines whether the round corners option is enabled.
 */
function realhomes_is_round_corners() {
	return ( 'enable' === get_option( 'realhomes_round_corners', 'disable' ) );
}

if ( ! function_exists( 'realhomes_round_corners_customizer' ) ) :

	function realhomes_round_corners_customizer( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section( 'realhomes_round_corners_section', array(
			'title'    => esc_html__( 'Round Corners', 'framework' ),
			'panel'    => 'inspiry_styles_panel',
		) );

		$wp_customize->add_setting( 'realhomes_round_corners', array(
			'type'              => 'option',
			'default'           => 'disable',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'realhomes_round_corners', array(
			'label'       => esc_html__( 'Round Corners for Theme Elements', 'framework' ),
			'description' => esc_html__( 'This option allows you to change corners of some common theme elements.', 'framework' ),
			'type'        => 'radio',
			'choices'     => array(
				'enable'  => esc_html__( 'Enable', 'framework' ),
				'disable' => esc_html__( 'Disable', 'framework' ),
			),
			'section'     => 'realhomes_round_corners_section',
		) );

        $round_corners_values = array(
			'small'  => '4',
			'medium' => '8',
			'large'  => '12',
		);

		foreach ( $round_corners_values as $k => $v ) {
			$id = 'realhomes_round_corners_' . $k;
			$wp_customize->add_setting( $id, array(
				'type'              => 'option',
				'default'           => $v,
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( $id, array(
				'label'   => ucfirst( $k ) . esc_html__( ' Round Corners Value', 'framework' ),
				'type'    => 'text',
				'section' => 'realhomes_round_corners_section',
				'active_callback' => 'realhomes_is_round_corners'
			) );
		}

	}

	add_action( 'customize_register', 'realhomes_round_corners_customizer' );
endif;