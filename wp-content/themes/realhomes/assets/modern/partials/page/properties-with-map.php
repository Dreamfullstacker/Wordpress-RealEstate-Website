<?php
/**
 * Page: Half Google Map with Properties List
 *
 * @package    realhomes
 * @subpackage modern
 */


get_header();

// Page Head.
$header_variation = get_option( 'inspiry_listing_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}
	echo '</div>'; // close inspiry_half_map_header_wrapper in header.php

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}


// Half Map Based Properties List.
get_template_part( 'assets/modern/partials/properties/half-map-list' );

get_footer();
