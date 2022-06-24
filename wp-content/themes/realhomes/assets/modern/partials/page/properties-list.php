<?php
/**
 * Page: Properties List
 *
 * Displays properties in list layout.
 *
 * @package  realhomes
 * @subpackage modern
 */

get_header();

/*
 * Header Variation
 */
$header_variation = get_option( 'inspiry_listing_header_variation', 'none' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

/*
 * Search Form
 */
if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	/*
	 * View type as list layout can also have buttons to display grid layout.
	 */
	$view_type = 'list';
	if ( isset( $_GET['view'] ) ) {
		$view_type = $_GET['view'];
	}

	if ( 'grid' === $view_type ) {
		get_template_part( 'assets/modern/partials/properties/grid' );
	} else {
		get_template_part( 'assets/modern/partials/properties/list' );
	}

}
get_footer();
