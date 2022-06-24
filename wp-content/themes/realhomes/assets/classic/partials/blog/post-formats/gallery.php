<div class="listing-slider">
    <ul class="slides">
        <?php
        if( is_page_template('templates/home.php') ){
            list_gallery_images( 'gallery-two-column-image' );
        }else{
            list_gallery_images( 'property-detail-slider-image-two');
        }
        ?>
    </ul>
</div>