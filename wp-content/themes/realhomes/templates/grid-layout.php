<?php
/**
 * Template Name: Properties Grid
 *
 * Display properties in grid layout.
 *
 * @since 1.0.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_properties_grid_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/properties-grid' );

