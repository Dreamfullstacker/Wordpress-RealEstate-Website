<?php
/**
 * Page Template
 *
 * @package realhomes
 * @subpackage classic
 */

get_header();
?>

<!-- Page Head -->
<?php
get_template_part( 'assets/classic/partials/banners/default' );
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	?>

    <!-- Content -->
    <div class="container contents single">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
        <div class="row">
            <div class="span8 main-wrap">
                <!-- Main Content -->
                <div class="main page-main">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php
								$title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_page_title_display', true );
								if ( 'hide' !== $title_display ) {
									?>
                                    <header class="post-header">
                                        <h3 class="post-title"><?php the_title(); ?></h3>
                                    </header>
									<?php
								}

								if ( has_post_thumbnail() ) {
									$image_id  = get_post_thumbnail_id();
									$image_url = wp_get_attachment_url( $image_id );
									echo '<a data-fancybox="thumbnail" href="' . esc_attr( $image_url ) . '" title="' . the_title_attribute( 'echo=0' ) . '" >';
									the_post_thumbnail( 'property-detail-slider-image-two' );
									echo '</a>';
								}

								?>
                                <div class="post-content rh_classic_content_zero clearfix">
									<?php the_content(); ?>
                                </div>
								<?php

								// WordPress Link Pages.
								wp_link_pages( array(
									'before'         => '<div class="pages-nav clearfix">',
									'after'          => '</div>',
									'next_or_number' => 'next',
								) );
								?>
                            </article>
						<?php
						endwhile;

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endif;
					?>
                </div><!-- End Main Content -->

            </div> <!-- End span8 -->

            <div class="span4 sidebar-wrap">
                <aside class="sidebar">
					<?php
					if ( is_active_sidebar( 'default-page-sidebar' ) ) {
						dynamic_sidebar( 'default-page-sidebar' );
					}
					?>
                </aside>
            </div>

        </div><!-- End contents row -->

    </div><!-- End Content -->

	<?php
}
get_footer();
?>
