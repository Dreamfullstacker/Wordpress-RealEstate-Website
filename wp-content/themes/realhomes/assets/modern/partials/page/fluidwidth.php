<?php
/**
 * Page: Fluid Width Template
 *
 * @package  realhomes
 * @subpackage modern
 *
 * @since 3.5.0
 */

get_header();

$header_variation = get_option( 'inspiry_pages_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}


if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}
?>

<section class="rh_section rh_wrap--fluidwidth rh_wrap--topPadding">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="rh_page">

		<?php if ( have_posts() ) : ?>

			<div class="rh_blog rh_blog__listing rh_blog__single">

				<?php while ( have_posts() ) : ?>
					<?php
					the_post();

					// meta box setting to display page title or not
					$page_title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_page_title_display', true );
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php
						if ( 'hide' !== $page_title_display ) {
							?>
							<div class="entry-header blog-post-entry-header">
								<?php get_template_part( 'assets/modern/partials/blog/post/title' ); ?>
							</div>
							<?php
						}
						?>

						<div class="rh_content entry-content">
							<?php the_content(); ?>
						</div>

					</article>
					<?php
					wp_link_pages( array(
						'before'         => '<div class="rh_pagination__pages-nav">',
						'after'          => '</div>',
						'next_or_number' => 'next',
					) );
					?>
				<?php endwhile; ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			</div>
			<!-- /.rh_blog rh_blog__listing -->

		<?php endif; ?>

	</div>
	<!-- /.rh_page -->

</section>
<!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php
get_footer();
