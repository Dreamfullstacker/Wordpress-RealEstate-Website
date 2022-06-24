<?php
/**
 * Page: My Properties
 *
 * Page template for My Properties page.
 *
 * @package    realhomes
 * @subpackage modern
 */

get_header();

// Page Head.
$header_variation = get_option( 'inspiry_member_pages_header_variation', 'banner' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

get_template_part( 'assets/modern/partials/member/properties' );

get_footer();
