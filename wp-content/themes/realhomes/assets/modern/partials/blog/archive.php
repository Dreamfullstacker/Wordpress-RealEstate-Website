<?php
/**
 * Blog: Archive Template
 *
 * Archive template for blog.
 *
 * @package    realhomes
 * @subpackage modern
 */

get_header();
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
	get_template_part( 'assets/modern/partials/blog/post/archive-contents' );
}
get_footer();
