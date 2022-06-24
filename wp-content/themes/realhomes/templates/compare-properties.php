<?php
/**
 * Template Name: Compare Properties
 *
 * @package realhomes/templates
 */

do_action( 'inspiry_before_compare_properties_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/properties/compare' );
