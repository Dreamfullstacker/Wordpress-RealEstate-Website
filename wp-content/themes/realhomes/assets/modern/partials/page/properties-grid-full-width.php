<?php
/**
 * Page: Properties Grid
 *
 * Display properties in grid layout.
 *
 * @since    3.0.0
 * @package  realhomes
 */

get_header();

/*
 * Header variation.
 */
$header_variation = get_option( 'inspiry_listing_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

/*
 * Search Form.
 */
if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	/*
	 * View type as grid layout can also have buttons to display list layout.
	 */
	$view_type = 'grid';
	if ( isset( $_GET['view'] ) ) {
		$view_type = $_GET['view'];
	}

	if ( 'list' === $view_type ) {
		get_template_part( 'assets/modern/partials/properties/list-full-width' );
	} else {
		get_template_part( 'assets/modern/partials/properties/grid-full-width' );
	}

}
get_footer();
