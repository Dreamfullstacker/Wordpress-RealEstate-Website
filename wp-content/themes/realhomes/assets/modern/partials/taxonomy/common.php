<?php
/**
 * Common template for taxonomy archives.
 *
 * @package realhomes
 * @subpackage modern
 */

get_header();

// Page Head.
$header_variation = get_option( 'inspiry_listing_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/taxonomy' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

if ( isset( $_GET['view'] ) ) {
	$view_type = $_GET['view'];
} else {
	/* Theme Options Listing Layout */
	$view_type = get_option( 'theme_listing_layout' );
}

if ( 'grid' === $view_type ) {
	get_template_part( 'assets/modern/partials/taxonomy/grid-layout' );
} else {
	get_template_part( 'assets/modern/partials/taxonomy/list-layout' );
}

get_footer();
