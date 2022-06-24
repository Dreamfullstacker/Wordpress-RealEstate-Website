<?php
/**
 * Template Name: Deprecated - My Properties
 *
 * @since 1.0.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_my_properties_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/my-properties' );
