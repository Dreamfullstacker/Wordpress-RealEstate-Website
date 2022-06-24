<?php
/**
 * Styles Settings
 *
 * @package realhomes/customizer
 * @since 1.0.0
 */
if ( ! function_exists( 'inspiry_styles_customizer' ) ) :

	/**
	 * Customizer Section: Styles
	 *
	 * @param  WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since  1.0.0
	 */
	function inspiry_styles_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Styles Panel
		 */
		$wp_customize->add_panel( 'inspiry_styles_panel', array(
			'title'    => esc_html__( 'Styles', 'framework' ),
			'priority' => 2,
		) );
	}

	add_action( 'customize_register', 'inspiry_styles_customizer' );
endif;

/**
 * Typography
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/typography.php' );

/**
 * Round Corners
 */
if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
	require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/round-corners.php' );
}

/**
 * Core Colors
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/core-colors.php' );

/**
 * Header Styles
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/header-styles.php' );

/**
 * Slider
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/slider.php' );

/**
 * Slider
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/search-form.php' );

/**
 * Banner
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/banner.php' );

/**
 * Home Page Styles
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/home-page.php' );

/**
 * Property Item
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/property-item.php' );

/**
 * Buttons
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/buttons.php' );

/**
 * News
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/news.php' );

/**
 * Gallery
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/gallery.php' );

/**
 * Footer
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/footer.php' );

/**
 * Floating Features CSS
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/styles/floating-features.php' );