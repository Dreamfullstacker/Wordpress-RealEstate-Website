<?php
/**
 * Content Section of homepage.
 *
 * @package    realhomes
 * @subpackage modern
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$get_border_type   = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-mod';
} else {
	$border_class = 'flat-border';
}

global $post;

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
        <section class="rh_section <?php  echo esc_attr($border_class);
        if ( ! empty( get_the_content() ) ) {
			echo esc_attr( ' rh_section__content rh_section--content_padding' );
		} ?> ">
            <article id="post-<?php the_ID(); ?>" class="rh_content"><?php the_content(); ?></article>
		</section>
		<?php
	endwhile;
endif;
