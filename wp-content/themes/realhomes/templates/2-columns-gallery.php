<?php
/**
 * Template Name: 2 Columns Gallery
 *
 * @since   1.0.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_2_columns_gallery_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/2-columns-gallery' );
