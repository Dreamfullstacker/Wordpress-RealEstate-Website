<?php
/**
 * Search Template
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();

$banner_image_path = get_default_banner(); ?>

<div class="page-head" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
	<div class="container">
		<div class="wrap clearfix">
			<h1 class="page-title"><span><?php esc_html_e( 'Search Results', 'framework' ); ?></span></h1>
			<p><?php the_search_query(); ?></p>
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
			<div class="main search-post-main">

                <?php get_template_part( 'assets/classic/partials/blog/loop' ); ?>

			</div><!-- End Main Content -->

		</div> <!-- End span8 -->

		<?php get_sidebar(); ?>

	</div><!-- End contents row -->
</div><!-- End Content -->

<?php get_footer(); ?>
