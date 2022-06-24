<?php
/**
 * Page: Properties List
 *
 * Displays properties in list layout.
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();

// properties list page module.
$theme_listing_module = get_option( 'theme_listing_module' );

// only for demo purpose.
if ( isset( $_GET['module'] ) ) {
	$theme_listing_module = $_GET['module'];
}

switch ( $theme_listing_module ) {
	case 'properties-map':
		get_template_part( 'assets/classic/partials/banners/map' );
		break;

	default:
		get_template_part( 'assets/classic/partials/banners/default' );
		break;
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {

	$view_type = 'list';
	if ( isset( $_GET['view'] ) ) {
		$view_type = $_GET['view'];
	}

	if ( 'grid' === $view_type ) {
		get_template_part( 'assets/classic/partials/properties/grid' );
	} else {
		get_template_part( 'assets/classic/partials/properties/list' );
	}
}
get_footer();
