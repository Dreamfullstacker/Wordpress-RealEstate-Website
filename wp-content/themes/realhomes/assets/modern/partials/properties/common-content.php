<?php
/**
 * Contains content part for multiple properties pages
 */

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
        <div class="rh_content rh_content_above_footer  <?php if ( get_the_content() ) {
			echo esc_attr( 'rh_page__content' );
		} ?>">
			<?php the_content(); ?>
        </div>
        <!-- /.rh_content -->
		<?php

	}
}

?>



