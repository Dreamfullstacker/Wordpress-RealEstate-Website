<?php
/**
 * Property Grid Listing Template
 *
 * Page template for property grid listing.
 *
 * @since    2.7.0
 * @package  realhomes/classic
 */

get_header();

/* Theme Listing Page Module */
$theme_listing_module = get_option( 'theme_listing_module' );

/* Only for demo purpose only */
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
	?>

    <!-- Content -->
	<?php
	$view_type = 'grid';
	if ( isset( $_GET['view'] ) ) {
		$view_type = $_GET['view'];
	}

	if ( 'list' === $view_type ) {
		get_template_part( 'assets/classic/partials/properties/list-full-width' );
	} else {
		get_template_part( 'assets/classic/partials/properties/grid-full-width' );
	}
	?>
    <!-- End Content -->

	<?php
}
get_footer();
?>