<?php
/**
 * Blog post meta
 *
 * @package    realhomes
 * @subpackage modern
 */
?>
<div class="entry-meta blog-post-entry-meta">
	<?php
	printf(
		esc_html_x( 'By %s', 'author byline', 'framework' ),
		sprintf(
			'<p class="vcard fn">%1$s</p>',
			esc_html( get_the_author_meta( 'display_name' ) )
		)
	);
	echo ' ';
	esc_html_e( 'Posted in', 'framework' );
	echo ' ';
	the_category( ', ' );
	echo ' ';
	esc_html_e( 'On ', 'framework' );
	echo ' ';
	?>
	<time class="entry-date published" datetime="<?php the_time( 'c' ); ?>"><?php the_time( get_option('date_format', 'M d, Y' ) ); ?></time>
</div>