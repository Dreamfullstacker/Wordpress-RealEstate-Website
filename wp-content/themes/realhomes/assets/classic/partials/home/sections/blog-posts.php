<?php
/**
 * Template: `Blog/News Posts - Homepage`
 *
 * @package realhomes/classic
 * @since   2.6.3
 */

?>
<div class="container">

    <div class="row">

        <div class="span12">

            <div class="main">

                <section class="home-recent-posts container-fluid clearfix">
                    <?php
                    $news_posts_title   = get_post_meta( get_the_ID(), 'theme_news_posts_title', true );
                    $news_posts_text    = get_post_meta( get_the_ID(), 'theme_news_posts_text', true );

                    if (! empty($news_posts_title)) {
                        ?>
                        <div class="section-title">
                            <h3><?php echo esc_html($news_posts_title); ?></h3>
                            <?php
                            if (! empty($news_posts_text)) {
                                ?><p><?php echo wp_kses( $news_posts_text, inspiry_allowed_html() ); ?></p><?php

                            } ?>
                        </div>
                        <?php

                    }
                    ?>
                    <div class="recent-posts-container row-fluid clearfix">
                        <?php
                        $recent_posts_args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 3,
                            'ignore_sticky_posts' => 1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'post_format',
                                    'field' => 'slug',
                                    'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio'),
                                    'operator' => 'NOT IN'
                                )
                            ),
                            'meta_query' => array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_thumbnail_id',
                                    'compare' => 'EXISTS'
                                ),
                                array(
                                    'key' => 'REAL_HOMES_embed_code',
                                    'compare' => 'EXISTS'
                                ),
                                array(
                                    'key' => 'REAL_HOMES_gallery',
                                    'compare' => 'EXISTS'
                                )
                            )
                        );

                        // The Query
                        $recent_posts_query = new WP_Query($recent_posts_args);

                        // The Loop
                        if ($recent_posts_query->have_posts()) {
                            while ($recent_posts_query->have_posts()) {
                                $recent_posts_query->the_post();
                                $format = get_post_format(get_the_ID());
                                if (false === $format) {
                                    $format = 'standard';
                                } ?>
                                <article class="span4 clearfix">
                                    <?php get_template_part("assets/classic/partials/blog/post-formats/$format"); ?>
                                    <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <div class="post-meta">
                                        <span><?php esc_html_e('On', 'framework'); ?> <span class="date"> <?php the_time(get_option('date_format')); ?></span></span>
                                        <span><?php esc_html_e('by', 'framework'); ?> <span class="author-link"><?php the_author() ?></span></span>
                                    </div>
                                    <p><?php framework_excerpt(12); ?></p>
                                    <a class="more-details" href="<?php the_permalink() ?>"><?php esc_html_e('Read More ', 'framework'); ?><i class="fas fa-caret-right"></i></a>
                                </article>
                                <?php

                            }
                        } else {
                            ?>
                            <div class="span12">
                                <p class="nothing-found"><?php esc_html_e('No Posts Found!', 'framework'); ?></p>
                            </div>
                            <?php

                        }

                        /* Restore original Post Data */
                        wp_reset_query();
                        ?>
                    </div>

                </section>

            </div>
            <!-- /.main -->

        </div>
        <!-- /.span12 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
