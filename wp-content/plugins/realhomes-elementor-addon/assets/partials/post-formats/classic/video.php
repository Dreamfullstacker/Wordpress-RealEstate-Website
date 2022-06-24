<?php
    global $post;
    global $news_grid_size;
    $embed_code = get_post_meta($post->ID, 'REAL_HOMES_embed_code', true);

    if(!empty($embed_code))
    {
        ?>
        <div class="rhea_thumb_wrapper rhea_post_set_height post-video">
            <div class="video-wrapper on-home-page">
                <?php echo stripslashes(htmlspecialchars_decode($embed_code)); ?>
            </div>
        </div>
        <?php
    }
    elseif(has_post_thumbnail())
    {
        $image_id = get_post_thumbnail_id();
        $image_url = wp_get_attachment_url($image_id);

        ?>
        <div class="rhea_thumb_wrapper rhea_post_set_height post-video">
            <a href="<?php echo esc_url( $image_url ); ?>" class="pretty-photo" title="<?php the_title(); ?>">
                <?php
                    the_post_thumbnail($news_grid_size);
                ?>
            </a>
        </div>
        <?php
    }
    ?>
