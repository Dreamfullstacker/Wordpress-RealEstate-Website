<?php
/**
 * Template Name: Property Full Width
 * Template Post Type: property
 */

do_action( 'inspiry_before_property_fullwidth_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/property/single-fullwidth' );