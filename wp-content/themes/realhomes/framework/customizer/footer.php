<?php
/**
 * Footer Customizer Settings
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_footer_customizer' ) ) :
	function inspiry_footer_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Footer Panel
		 */
		$wp_customize->add_panel( 'inspiry_footer_panel', array(
			'title' 	=> esc_html__( 'Footer', 'framework' ),
			'priority' 	=> 121,
		) );

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {

			// Footer Basics
			$wp_customize->add_section( 'realhomes_footer_basics', array(
				'title' => esc_html__( 'Basics', 'framework' ),
				'panel' => 'inspiry_footer_panel',
			) );

			// Footer Layout
			$wp_customize->add_setting( 'realhomes_footer_layout', array(
				'type'              => 'option',
				'default'           => 'default',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );
			$wp_customize->add_control( 'realhomes_footer_layout', array(
				'label'   => esc_html__( 'Footer Layout', 'framework' ),
				'type'    => 'radio',
				'section' => 'realhomes_footer_basics',
				'choices' => array(
					'default'   => esc_html__( 'Default', 'framework' ),
					'centered'  => esc_html__( 'Centered', 'framework' ),
					'fullwidth' => esc_html__( 'Full Width', 'framework' ),
				),
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_footer_customizer' );
endif;


/**
 * Partners
 */
if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
	require_once( INSPIRY_FRAMEWORK . 'customizer/sections/footer/partners.php' );
}

/**
 * Logo
 */
if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
	require_once( INSPIRY_FRAMEWORK . 'customizer/sections/footer/logo.php' );
}

/**
 * Layout
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/footer/layout.php' );

/**
 * Text
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/footer/text.php' );


