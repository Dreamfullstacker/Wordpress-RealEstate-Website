<?php
$get_post_meta_image         = get_post_meta( get_the_ID(), 'REAL_HOMES_property_images', false );
$get_prop_images             = count( $get_post_meta_image );
$REAL_HOMES_tour_video_url   = get_post_meta( get_the_ID(), 'REAL_HOMES_tour_video_url', true );
$REAL_HOMES_tour_video_image = get_post_meta( get_the_ID(), 'REAL_HOMES_tour_video_image', true );

$inspiry_video_group = get_post_meta( get_the_ID(), 'inspiry_video_group', true );

?>

<div class="rh_media_count">

	<?php if ( $get_prop_images > 0 ) { ?>
        <div class="rh_media rh_media_image"
             data-fancybox-trigger="gallery-<?php echo esc_attr( get_the_ID() ); ?>"
             data-this-id="<?php echo esc_attr( get_the_ID() ); ?>">
	        <?php inspiry_safe_include_svg( '/images/icons/photos.svg', '/common/' ); ?>
            <span>
											<?php echo esc_html( $get_prop_images ); ?>
                                                </span>
        </div>
		<?php
	}

	$count_videos = '';
	if ( isset( $REAL_HOMES_tour_video_url ) && ( ! empty( $REAL_HOMES_tour_video_url ) ) ) {
		$count_videos = count( get_post_meta( get_the_ID(), 'REAL_HOMES_tour_video_url', false ) );
	} elseif ( isset( $inspiry_video_group ) && ! empty( $inspiry_video_group ) ) {
		$count_videos = count( $inspiry_video_group );
	}
	if ( $count_videos > 0 ) {
		?>
        <div class="rh_media rh_media_video"
             data-fancybox-trigger="video-<?php echo esc_attr( get_the_ID() ); ?>"
             data-this-id="<?php echo esc_attr( get_the_ID() ); ?>">
	        <?php inspiry_safe_include_svg( '/images/icons/video.svg', '/common/' ); ?>

            <span>
											<?php echo esc_html( $count_videos ); ?>
                                                </span>
        </div>
		<?php
	}
	?>
</div>
<div class="rh_property_images_load" style="display: none">
	<?php
	foreach ( $get_post_meta_image as $item ) {
		$images_src = wp_get_attachment_image_src( $item, 'post-featured-image' );
		?>
        <span style="display: none;"
           data-fancybox="gallery-<?php echo esc_attr( get_the_ID() ); ?>"
           data-src="<?php echo esc_url( $images_src[0] ); ?>"
           data-thumb="<?php echo esc_url( $images_src[0] ); ?>"></span>
		<?php
	}
	?>

	<?php

	if ( isset( $REAL_HOMES_tour_video_url ) && ( ! empty( $REAL_HOMES_tour_video_url ) ) ) {
		?>
        <span style="display: none;"
           data-fancybox="video-<?php echo esc_attr( get_the_ID() ); ?>"
           data-src="<?php echo esc_url( $REAL_HOMES_tour_video_url ); ?>"
        >
        </span>
		<?php
	} elseif ( isset( $inspiry_video_group ) && ! empty( $inspiry_video_group ) ) {
		foreach ( $inspiry_video_group as $video ) {
			?>
            <span style="display: none;"
               data-fancybox="video-<?php echo esc_attr( get_the_ID() ); ?>"
               data-src="<?php echo esc_url( $video['inspiry_video_group_url'] ); ?>"
            ></span>

			<?php
		}
	}
	?>

</div>



