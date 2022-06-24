<?php
/**
 * Template Name: Properties Search
 *
 * @package realhomes/templates
 */

do_action( 'inspiry_before_properties_search_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/properties/search' );
