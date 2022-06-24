<?php
/**
 * Section:	`Partners`
 * Panel: 	`Footer`
 *
 * @since 2.6.3
 */

if ( ! function_exists( 'inspiry_footer_partners_customizer' ) ) :

	/**
	 * inspiry_footer_partners_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  2.6.3
	 */
	function inspiry_footer_partners_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Partners Section
		 */
		$wp_customize->add_section( 'inspiry_footer_partners', array(
			'title' => esc_html__( 'Partners', 'framework' ),
			'panel' => 'inspiry_footer_panel',
		) );

		/* Show / Hide Partners */
		$wp_customize->add_setting( 'theme_show_partners', array(
			'type'    => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_show_partners', array(
			'label' 	=> esc_html__( 'Partners Section Above Footer', 'framework' ),
			'type' 		=> 'radio',
			'section' 	=> 'inspiry_footer_partners',
			'choices' 	=> array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false' => esc_html__( 'Hide', 'framework' ),
			),
		) );

		/* Partners Section Variation */
		$wp_customize->add_setting( 'inpsiry_partners_variation', array(
			'type'    => 'option',
			'default' => 'carousel',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inpsiry_partners_variation', array(
			'label' 	=> esc_html__( 'Partners Design Variation to Display', 'framework' ),
			'type' 		=> 'radio',
			'section' 	=> 'inspiry_footer_partners',
			'choices' 	=> array(
				'simple'  	=> esc_html__( 'Simple', 'framework' ),
				'carousel'	=> esc_html__( 'Carousel', 'framework' ),
			),
		) );

		/* Partners Title */
		$wp_customize->add_setting( 'theme_partners_title', array(
			'type' 				=> 'option',
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_partners_title', array(
			'label' 			=> esc_html__( 'Partners Title', 'framework' ),
			'type' 				=> 'text',
			'section' 			=> 'inspiry_footer_partners',
			'active_callback' 	=> 'inspiry_display_partners_carousel',
		) );

		/* Partners to show */
		$wp_customize->add_setting( 'inspiry_footer_partners_to_show', array(
			'type' 				=> 'option',
			'default'			=> '20',
			'sanitize_callback'	=> 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_footer_partners_to_show', array(
			'label' 	=> esc_html__( 'Number of Partners', 'framework' ),
			'type' 		=> 'text',
			'section'	=> 'inspiry_footer_partners',
			'active_callback' => function(){
				$partners_variation = get_option( 'inpsiry_partners_variation' );
				return ( 'simple' === $partners_variation ) ;
			}
		) );

	}

	add_action( 'customize_register', 'inspiry_footer_partners_customizer' );
endif;


if ( ! function_exists( 'inspiry_footer_partners_defaults' ) ) :

	/**
	 * inspiry_footer_partners_defaults.
	 *
	 * @since  2.6.3
	 */
	function inspiry_footer_partners_defaults( WP_Customize_Manager $wp_customize ) {
		$footer_partners_settings_ids = array(
			'theme_show_partners',
			'inpsiry_partners_variation',
			'inspiry_footer_partners_to_show',
		);
		inspiry_initialize_defaults( $wp_customize, $footer_partners_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_footer_partners_defaults' );
endif;


if ( ! function_exists( 'inspiry_display_partners_carousel' ) ) {

	/**
	 * Callback function for Partner Carousel Title setting
	 *
	 * @return boolean
	 * @since  2.6.3
	 */
	function inspiry_display_partners_carousel() {
		$inpsiry_partners_variation	= get_option( 'inpsiry_partners_variation' );
		if ( 'carousel' == $inpsiry_partners_variation ) {
			return true;
		}
		return false;
	}
}
