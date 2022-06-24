<?php
/**
 * Blog Loop File
 *
 * Loop file of blog.
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'assets/classic/partials/blog/article' );
	endwhile;

	the_posts_pagination(array(
	        'mid_size' => 2,
        'prev_text' => esc_html__('Prev','framework'),
        'next_text' => esc_html__('Next','framework'),
    ));
else :
	?><p class="nothing-found"><?php esc_html_e( 'No Posts Found!', 'framework' ); ?></p><?php
endif;
