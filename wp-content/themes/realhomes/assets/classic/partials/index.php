<?php
/**
 * Blog Index File
 *
 * @package realhomes
 * @subpackage classic
 */

get_header(); ?>

<!-- Page Head -->
<?php get_template_part( 'assets/classic/partials/banners/blog' ); ?>

<!-- Content -->
<div class="container contents blog-page">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="row">
		<div class="span8 main-wrap">
			<!-- Main Content -->
			<div class="main posts-main">

                <?php get_template_part( 'assets/classic/partials/blog/loop' ); ?>

			</div><!-- End Main Content -->

		</div> <!-- End span8 -->

		<?php get_sidebar(); ?>

	</div><!-- End contents row -->
</div><!-- End Content -->

<?php get_footer(); ?>
