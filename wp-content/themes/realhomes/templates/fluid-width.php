<?php
/**
 * Template Name: Fluid Width
 *
 * @since 3.5.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_fluidwidth_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/fluidwidth' );
