<?php
/**
 * Template Name: Agencies List
 *
 * @since   3.5.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_agencies_list_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/agencies-list' );