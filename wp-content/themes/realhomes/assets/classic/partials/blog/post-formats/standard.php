<?php
if ( has_post_thumbnail() ){
    ?>
    <figure class="post-thumbnail">
        <?php
        if( is_single() ){
            $image_id = get_post_thumbnail_id();
            $image_url = wp_get_attachment_url($image_id);
            ?>
            <a href="<?php echo esc_url( $image_url ); ?>" data-fancybox title="<?php the_title_attribute(); ?>">
            <?php
        }else{
            ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php
        }

        if( is_page_template( 'templates/home.php' )){
            the_post_thumbnail('gallery-two-column-image');
        } else {
            the_post_thumbnail('property-detail-slider-image-two');
        }
        ?>
        </a>
    </figure>
    <?php
}
?>