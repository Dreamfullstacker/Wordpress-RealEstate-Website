<?php
/**
 * Customizer settings for Header
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_header_customizer' ) ) :
	function inspiry_header_customizer( WP_Customize_Manager $wp_customize ) {

		// Header Panel
		$wp_customize->add_panel( 'inspiry_header_panel', array(
			'title'    => esc_html__( 'Header', 'framework' ),
			'priority' => 121,
		) );
	}

	add_action( 'customize_register', 'inspiry_header_customizer' );
endif;

/**
 * Basics
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/header/basics.php' );

/**
 * Contact Information
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/header/contact-information.php' );

/**
 * Login & Register
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/header/login-register.php' );

/**
 * Banner
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/header/banner.php' );

/**
 * Search Form
 */
if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
	require_once( INSPIRY_FRAMEWORK . 'customizer/sections/header/search-form.php' );
}