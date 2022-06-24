<?php
/**
 * Template Name: Post Full Width
 * Template Post Type: Post
 */

do_action( 'inspiry_before_post_fullwidth_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/blog/single-fullwidth' );