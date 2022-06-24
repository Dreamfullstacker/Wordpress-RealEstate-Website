<?php
/**
 * Archive Template
 *
 * @package realhomes
 * @subpackage classic
 */

get_header();
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
	get_template_part( 'assets/classic/partials/blog/archive-contents' );
}

 get_footer();
