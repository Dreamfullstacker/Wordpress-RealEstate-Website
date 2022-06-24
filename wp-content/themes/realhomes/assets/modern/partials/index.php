<?php
/**
 * Blog: Index Template
 *
 * @package  realhomes
 * @subpackage modern
 */

global $post;

get_header();

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

			<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
				<div class="rh_page__head">

					<h2 class="rh_page__title">
						<?php
						$banner_title = get_option( 'theme_news_banner_title' );
						$banner_title = empty( $banner_title ) ? esc_html__( 'News', 'framework' ) : $banner_title;

						echo inspiry_get_exploded_heading( $banner_title );
						?>
					</h2><!-- /.rh_page__title -->

				</div><!-- /.rh_page__head -->
			<?php endif; ?>

			<?php get_template_part( 'assets/modern/partials/blog/loop' ); ?>

		</div><!-- /.rh_page rh_page__main -->

		<?php if ( is_active_sidebar( 'default-sidebar' ) ) : ?>
            <div class="rh_page rh_page__sidebar">
				<?php get_sidebar(); ?>
            </div><!-- /.rh_page rh_page__sidebar -->
		<?php endif; ?>

	</section><!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php
get_footer();
