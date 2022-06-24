<?php
/**
 * 404 Template
 *
 * @since 1.0.0
 * @package realhomes/classic
 */

get_header();
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	get_template_part( 'assets/classic/partials/404-temp' );
}

 get_footer();
