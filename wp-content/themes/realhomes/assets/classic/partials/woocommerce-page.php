<?php
get_header();

get_template_part( 'assets/classic/partials/banners/default' );
?>
<div class="container contents single woocommerce-page-wrapper">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
    <div class="row">
        <div class="span8 main-wrap">
            <div class="main page-main">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="post-content rh_classic_content_zero clearfix">
						<?php woocommerce_content(); ?>
                    </div>
                </article>
            </div><!-- End Main Content -->
        </div> <!-- End span8 -->
        <div class="span4 sidebar-wrap">
            <aside class="sidebar">
				<?php
				if ( is_active_sidebar( 'shop-page-sidebar' ) ) {
					dynamic_sidebar( 'shop-page-sidebar' );
				}
				?>
            </aside>
        </div>
    </div><!-- End contents row -->
</div><!-- End Content -->
<?php
get_footer();