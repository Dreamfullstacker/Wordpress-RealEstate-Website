<?php
/**
 * Common top par for grid and list files.
 */

/*
 * Skip sticky properties.
 */
if ( function_exists( 'ere_skip_sticky_properties' ) ) {
	ere_skip_sticky_properties();
}

/*
 * List page module
 */
$theme_listing_module = get_option( 'theme_listing_module' );

$map_class = ( inspiry_show_header_search_form() ) ? 'rh_map__search' : false;

switch ( $theme_listing_module ) {
	case 'properties-map':
		echo '<div class="rh_map ' . esc_attr( $map_class ) . ' ">';
		get_template_part( 'assets/modern/partials/properties/map' );
		echo '</div>';
		break;

	default:
		break;
}