<?php
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
    <section class="rh_section rh_section--flex rh_wrap--padding rh_wrap--topPadding woocommerce-page-wrapper">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
		<div class="rh_page rh_page__listing_page rh_page__main">
            <div class="rh_blog rh_blog__listing rh_blog__single">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="rh_content entry-content">
						<?php woocommerce_content(); ?>
                    </div>
                </article>
            </div><!-- /.rh_blog rh_blog__listing -->
        </div><!-- /.rh_page rh_page__main -->
		<?php if ( is_active_sidebar( 'shop-page-sidebar' ) ) : ?>
            <div class="rh_page rh_page__sidebar">
                <aside class="rh_sidebar">
		            <?php dynamic_sidebar( 'shop-page-sidebar' ); ?>
                </aside>
            </div><!-- /.rh_page rh_page__sidebar -->
		<?php endif; ?>
    </section><!-- /.rh_section rh_wrap rh_wrap--padding -->
<?php
get_footer();
