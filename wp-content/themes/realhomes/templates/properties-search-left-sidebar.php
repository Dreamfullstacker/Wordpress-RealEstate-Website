<?php
/**
 * Template Name: Properties Search Left Sidebar
 *
 * @since   1.0.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_properties_search_left_sidebar_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/search-left-sidebar' );
