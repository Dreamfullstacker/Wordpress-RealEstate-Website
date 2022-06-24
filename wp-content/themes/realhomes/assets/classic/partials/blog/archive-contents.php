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
	$curauth        = $wp_query->get_queried_object();
	$banner_title   = esc_html__( 'All Posts By', 'framework' );
	$banner_details = $curauth->display_name;
} elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {
	$banner_title   = esc_html__( 'Archives', 'framework' );
	$banner_details = '';
}
?>

<div class="page-head" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
	<div class="container">
		<div class="wrap clearfix">
			<h1 class="page-title"><span><?php echo esc_html( $banner_title ); ?></span></h1>
			<?php if ( ! empty( $banner_details ) ) { ?>
				<p><?php echo esc_html( $banner_details ); ?></p>
			<?php } ?>
		</div>
	</div>
</div><!-- End Page Head -->

<!-- Content -->
<div class="container contents blog-page">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="row">
		<div class="span8 main-wrap">
			<!-- Main Content -->
			<div class="main archives-main">

				<?php get_template_part( 'assets/classic/partials/blog/loop' ); ?>

			</div><!-- End Main Content -->

		</div> <!-- End span8 -->

		<?php get_sidebar(); ?>

	</div><!-- End contents row -->
</div><!-- End Content -->
