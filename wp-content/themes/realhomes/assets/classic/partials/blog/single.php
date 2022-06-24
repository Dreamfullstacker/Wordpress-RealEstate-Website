<?php
/**
 * Single Blog Page
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	get_template_part( 'assets/classic/partials/blog/single-contents' );
}
get_footer();
