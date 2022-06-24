<?php

/* Page Head */
$banner_image_path = get_default_banner();

$banner_title   = esc_html__( 'Archives', 'framework' );
$banner_details = '';

$post = $posts[0]; // Hack. Set $post so that the_date() works.
if ( is_category() ) {
	$banner_title   = esc_html__( 'All Posts in Category', 'framework' );
	$banner_details = single_cat_title( '', false );
} elseif ( is_tag() ) {
	$banner_title   = esc_html__( 'All Posts in Tag', 'framework' );
	$banner_details = single_tag_title( '', false );
} elseif ( is_day() ) {
	$banner_title   = esc_html__( 'Archives', 'framework' );
	$banner_details = get_the_date();
} elseif ( is_month() ) {
	$banner_title   = esc_html__( 'Archives', 'framework' );
	$banner_details = get_the_date( 'F Y' );
} elseif ( is_year() ) {
	$banner_title   = esc_html__( 'Archives', 'framework' );
	$banner_details = get_the_date( 'Y' );
} elseif ( is_author() ) {
	global $wp_query;
	$curauth        = $wp_query->get_queried_object();
	$banner_title   = esc_html__( 'All Posts By', 'framework' );
	$banner_details = $curauth->display_name;
} elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {
	$banner_title   = esc_html__( 'Archives', 'framework' );
	$banner_details = '';
}

$header_variation = get_option( 'inspiry_news_header_variation', 'none' );

if ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) :
	?>
    <section class="rh_banner rh_banner__image" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>'); ">

        <div class="rh_banner__cover"></div>
        <!-- /.rh_banner__cover -->

        <div class="rh_banner__wrap">

            <h2 class="rh_banner__title">
				<?php echo esc_html( $banner_title ) . ': ' . esc_html( $banner_details ); ?>
            </h2>
            <!-- /.rh_banner__title -->

        </div>
        <!-- /.rh_banner__wrap -->

    </section>
    <!-- /.rh_banner -->
<?php
elseif ( empty( $header_variation ) || ( 'none' === $header_variation ) ) :
	get_template_part( 'assets/modern/partials/banner/header' );
endif;

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

?>

<section class="rh_section rh_section--flex rh_wrap--padding rh_wrap--topPadding">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
    <div class="rh_page rh_page__listing_page rh_page__main">

		<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
            <div class="rh_page__head">

                <h2 class="rh_page__title">
                    <span class="sub"><?php echo esc_html( $banner_title ); ?></span>
					<?php if ( ! empty( $banner_title ) ) : ?>
                        <span class="title"><?php echo esc_html( $banner_details ); ?></span>
					<?php endif; ?>
                </h2>
                <!-- /.rh_page__title -->

            </div>
            <!-- /.rh_page__head -->
		<?php endif; ?>

		<?php get_template_part( 'assets/modern/partials/blog/loop' ); ?>

    </div>
    <!-- /.rh_page rh_page__main -->

	<?php if ( is_active_sidebar( 'default-sidebar' ) ) : ?>
        <div class="rh_page rh_page__sidebar">
			<?php get_sidebar(); ?>
        </div><!-- /.rh_page rh_page__sidebar -->
	<?php endif; ?>

</section>
<!-- /.rh_section rh_wrap rh_wrap--padding -->
