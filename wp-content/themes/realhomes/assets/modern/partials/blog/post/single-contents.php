<?php

$header_variation = get_option( 'inspiry_news_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/blog' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

?>

	<section class="rh_section rh_section--flex rh_wrap--padding rh_wrap--topPadding">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
		<div class="rh_page rh_page__listing_page rh_page__news rh_page__main">

			<?php if ( have_posts() ) : ?>

				<div class="rh_blog rh_blog__listing rh_blog__single">

					<?php
					while ( have_posts() ) :
						the_post();

						$format = get_post_format( get_the_ID() );
						if ( false === $format ) {
							$format = 'standard';
						}
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<?php
							// Image, gallery or video based on format.
							if ( in_array( $format, array( 'standard', 'image', 'gallery', 'video' ), true ) ) :
								get_template_part( 'assets/modern/partials/blog/post-formats/' . $format );
							endif;
							?>

							<div class="entry-header blog-post-entry-header">
								<?php
								// Post title.
								get_template_part( 'assets/modern/partials/blog/post/title' );

								// Post meta.
								get_template_part( 'assets/modern/partials/blog/post/meta' );
								?>
							</div>

							<div class="rh_content entry-content">
								<?php the_content(); ?>
							</div>

							<?php if ( get_the_tags() ) : ?>
								<div class="post-tags clearfix">
									<?php the_tags( '<i class="fas fa-tags"></i>&nbsp', ', ', '' ); ?>
								</div>
							<?php endif; ?>

						</article>


						<?php
						wp_link_pages( array(
							'before'         => '<div class="rh_pagination__pages-nav">',
							'after'          => '</div>',
							'next_or_number' => 'next',
						) );
					endwhile;

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				</div>
				<!-- /.rh_blog rh_blog__listing -->

			<?php endif; ?>

		</div>
		<!-- /.rh_page rh_page__main -->

		<?php if ( is_active_sidebar( 'default-sidebar' ) ) : ?>
            <div class="rh_page rh_page__sidebar">
				<?php get_sidebar(); ?>
            </div><!-- /.rh_page rh_page__sidebar -->
		<?php endif; ?>

	</section>
	<!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php
