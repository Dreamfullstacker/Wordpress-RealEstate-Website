<?php
/**
 * Template Name: Properties List Full Width
 *
 * Display properties in List layout full width.
 *
 * @since 3.7.1
 * @package realhomes/templates
 */

do_action( 'inspiry_before_properties_list_fullwidth_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/properties-list-full-width' );

