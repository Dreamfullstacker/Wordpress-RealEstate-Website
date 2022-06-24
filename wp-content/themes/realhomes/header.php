<?php
/**
 * Header file for the Realhomes WordPress theme.
 *
 * @link https://themeforest.net/item/real-homes-wordpress-real-estate-theme/5373914
 *
 * @package Realhomes
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
wp_body_open(); // Fire the wp_body_open action.

if ( is_page_template( 'templates/dashboard.php' ) ) {
	get_template_part( 'common/dashboard/header' );
} else {

	if ( INSPIRY_DESIGN_VARIATION === 'modern' ) {
		echo '<div class="rh_wrap rh_wrap_stick_footer">';
	}

	if ( is_page_template( 'templates/half-map-layout.php' ) ||
	     is_page_template( 'templates/properties-search-half-map.php' ) ) {
		echo '<div class="inspiry_half_map_header_wrapper">'; // wrap-up header to make half map fixed compatible with Elementor.
	}

	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
		if ( function_exists( 'hfe_header_enabled' ) && true == hfe_header_enabled() ) {
			hfe_render_header();
		} else {
			get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/header' );
		}
	}
}