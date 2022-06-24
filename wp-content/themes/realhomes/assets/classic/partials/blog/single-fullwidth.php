<?php
/**
 * Single Blog Full Width Page
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header(); ?>

<div class="single-post-fullwidth">

	<?php get_template_part( 'assets/classic/partials/banners/blog' ); ?>

    <div class="container contents single">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
        <div class="span12 main-wrap">

            <div class="main single-post-main">
                <?php
                if ( have_posts() ) :

                    while ( have_posts() ) :

                        the_post();

                        $format = get_post_format();
                        if ( false === $format ) {
                            $format = 'standard';
                        }
                        ?>
                        <article <?php post_class(); ?>>

                            <header class="post-header">
                                <h1 class="post-title"><?php the_title(); ?></h1>
                            </header>

                            <?php get_template_part( "assets/classic/partials/blog/post-formats/$format" ); ?>

                            <div class="post-meta">
                                <span class="posted-on"><?php the_time( get_option( 'date_format' ) ); ?></span>
                                <span class="posted-in">
                                <?php esc_html_e( 'in', 'framework' ); ?>
                                <?php the_category( ', ' ); ?>
                            </span>
                            </div>

                            <div class="post-content clearfix">
                                <?php the_content(); ?>
                            </div>

                            <?php if ( get_the_tags() ) : ?>
                                <div class="post-tags clearfix">
                                    <h4 class="tags-title"><?php esc_html_e( 'Tags', 'framework' ) ?></h4>
                                    <?php the_tags( '<i class="fas fa-tags"></i>&nbsp', ', ', '' ); ?>
                                </div>
                            <?php endif; ?>

                            <?php
                            wp_link_pages( array(
                                'before'         => '<div class="pages-nav clearfix">',
                                'after'          => '</div>',
                                'next_or_number' => 'next',
                            ) );
                            ?>

                            <footer class="post-footer clearfix">
                                <div class="post-footer-left">
                                <span class="byline">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 48, null, get_the_author(), array( 'class' => 'img-circle', ) ); ?>
                                    <span class="by"><?php esc_html_e( 'By', 'framework' ) ?></span>
                                    <span class="author vcard"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>'"><?php echo get_the_author(); ?></a></span>
                                </span>
                                </div>
                                <div class="post-footer-right"></div>
                            </footer>
                        </article>
                        <?php if ( 'true' === get_option( 'inspiry_post_prev_next_link' ) ) : ?>
                        <nav class="post-navigation clearfix">
                            <div class="post-navigation-border"></div>
                            <?php
                            $inspiry_previous_post = get_previous_post();
                            if ( $inspiry_previous_post ) : ?>
                                <div class="post-navigation-col post-navigation-prev">
                                    <a class="post-navigation-prev-post" href="<?php echo get_permalink( $inspiry_previous_post->ID ); ?>">
                                        <span class="post-navigation-text"><i class="rh-play fas fa-play fa-flip-horizontal"
                                                                              aria-hidden="true"></i><?php esc_html_e( 'Previous Post', 'framework' ); ?></span>
                                        <span class="post-navigation-inner-wrapper">
                                            <?php if ( has_post_thumbnail( $inspiry_previous_post->ID ) ) : ?>
                                                <span class="post-navigation-post-image"><?php echo get_the_post_thumbnail( $inspiry_previous_post->ID, 'thumbnail' ); ?></span>
                                            <?php endif; ?>
                                            <span class="post-navigation-post-content">
                                                <span class="post-navigation-post-title"><?php echo get_the_title( $inspiry_previous_post->ID ); ?></span>
                                                <span class="post-navigation-post-date"><?php echo get_the_date( '', $inspiry_previous_post->ID ); ?></span>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                                <?php
                            endif;

                            $inspiry_next_post = get_next_post();
                            if ( $inspiry_next_post ) : ?>
                                <div class="post-navigation-col post-navigation-next">
                                    <a class="post-navigation-next-post" href="<?php echo get_permalink( $inspiry_next_post->ID ); ?>">
                                        <span class="post-navigation-text"><?php esc_html_e( 'Next Post', 'framework' ); ?>
                                            <i class="rh-play fas fa-play" aria-hidden="true"></i></span>
                                        <span class="post-navigation-inner-wrapper">
                                            <?php if ( has_post_thumbnail( $inspiry_next_post->ID ) ) : ?>
                                                <span class="post-navigation-post-image"><?php echo get_the_post_thumbnail( $inspiry_next_post->ID, 'thumbnail' ); ?></span>
                                            <?php endif; ?>
                                            <span class="post-navigation-post-content">
                                                <span class="post-navigation-post-title"><?php echo get_the_title( $inspiry_next_post->ID ); ?></span>
                                                <span class="post-navigation-post-date"><?php echo get_the_date( '', $inspiry_next_post->ID ); ?></span>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </nav>
                        <?php
                    endif;
                    endwhile;

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                endif;
                ?>
            </div><!-- End Main Content -->
        </div><!-- End span8 -->

    </div><!-- End Content -->

</div><!-- End Single Post Fullwidth -->

<?php get_footer(); ?>