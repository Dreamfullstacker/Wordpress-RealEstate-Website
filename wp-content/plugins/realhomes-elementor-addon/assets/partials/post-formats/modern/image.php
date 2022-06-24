<?php
/**
 * Image post format.
 */

if ( has_post_thumbnail() ) {
	?>
	<figure>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php
			global $news_grid_size;
			the_post_thumbnail( $news_grid_size );
			?>
		</a>
	</figure>
	<?php
} else {
	?><p></p><?php
}