<?php
if (has_post_thumbnail()) {
    ?>
    <div class="rhea_thumb_wrapper rhea_post_get_height rhea_post_thumbnail">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php
            global $news_grid_size;
            the_post_thumbnail($news_grid_size);
        ?>
        </a>
    </div>
<?php
}
?>
