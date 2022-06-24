<?php
    global $post;
    $embed_code = get_post_meta(get_the_ID(), 'REAL_HOMES_embed_code', true);

    if(!empty($embed_code))
    {
        ?>
        <div class="post-video">
            <div class="video-wrapper <?php if(is_page_template('templates/home.php')){ echo 'on-home-page'; } ?>">
                <?php echo stripslashes( wp_specialchars_decode( $embed_code ) ); ?>
            </div>
        </div>
        <?php
    }
    elseif(has_post_thumbnail())
    {
        $image_id = get_post_thumbnail_id();
        $image_url = wp_get_attachment_url($image_id);

        ?>
        <div class="post-video">
            <a href="<?php echo esc_url( $image_url ); ?>" data-fancybox class="pretty-photo" title="<?php the_title_attribute(); ?>">
                <?php
                if( is_page_template( 'templates/home.php' )){
                    the_post_thumbnail('gallery-two-column-image');
                }else{
                    the_post_thumbnail('property-detail-slider-image-two');
                }
                ?>
            </a>
        </div>
        <?php
    }
    ?>
