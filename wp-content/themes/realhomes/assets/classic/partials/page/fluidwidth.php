<?php
/**
 * Fluid width Page Template
 *
 * @package    realhomes
 * @subpackage classic
 *
 * @since 3.5.0
 */

get_header();
?>

<!-- Page Head -->
<?php get_template_part( 'assets/classic/partials/banners/default' ); ?>

<!-- Content -->
<div class="container-fluid contents single">
<div class="full-width-row">
	<div class="main-wrap">
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

	</div> <!-- End span12 -->

</div><!-- End contents row -->

</div><!-- End Content -->

<?php get_footer(); ?>