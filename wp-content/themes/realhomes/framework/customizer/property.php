<?php
/**
 * Property Customizer
 *
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_property_customizer' ) ) :
	function inspiry_property_customizer( WP_Customize_Manager $wp_customize ) {
		/**
		 * Property Panel
		 */
		$wp_customize->add_panel( 'inspiry_property_panel', array(
			'title'    => esc_html__( 'Property Detail Page', 'framework' ),
			'priority' => 123,
		) );
	}

	add_action( 'customize_register', 'inspiry_property_customizer' );
endif;

/**
 * Sections Manager
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/sections-manager.php';

/**
 * Banner
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/banner.php';

/**
 * Breadcrumbs
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/breadcrumbs.php';

/**
 * Basics
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/basics.php';

/**
 * Gallery
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/gallery.php';

/**
 * Common Note
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/common-note.php';

/**
 * Property Floor Plan
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/floor-plan.php';

/**
 * Property Video
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/video.php';

/**
 * Property Virtual Tour
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/virtual-tour.php';

/**
 * Property Map
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/map.php';

/**
 * Property Social Sharing
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/social-share.php';

/**
 * Property WalkScore
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/walkscore.php';

/**
 * Yelp Nearby Places
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/yelp-nearby-places.php';

/**
 * Attachments
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/attachments.php';

/**
 *  Child Properties
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/sections/property/child-properties.php' );

/**
 * Agent
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/agent.php';

/**
 * Energy Performance
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/energy-performance.php';

/**
 * Views
 */
if ( inspiry_is_property_analytics_enabled() ) {
	require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/property-views.php';
}

/**
 * Mortgage Calculator
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/mortgage-calculator.php';

/**
 * Similar Properties
 */
require_once INSPIRY_FRAMEWORK . 'customizer/sections/property/similar-properties.php';
