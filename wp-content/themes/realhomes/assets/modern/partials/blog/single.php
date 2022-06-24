<?php
/**
 * Single Blog Post
 *
 * @package    realhomes
 * @subpackage modern
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	get_template_part( 'assets/modern/partials/blog/post/single-contents' );
}
get_footer();
