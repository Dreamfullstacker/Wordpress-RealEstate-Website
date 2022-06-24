<?php
/**
 * Template Name: Agents List
 *
 * @since   1.0.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_agents_list_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/agents-list' );
