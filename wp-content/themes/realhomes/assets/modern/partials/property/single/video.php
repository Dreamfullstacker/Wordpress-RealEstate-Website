<?php
/**
 * Video of the single property.
 *
 * @package    realhomes
 * @subpackage modern
 */


$display_video = get_option( 'theme_display_video', 'true' );

if ( 'true' === $display_video ) {

    $tour_video_url       = get_post_meta( get_the_ID(), 'REAL_HOMES_tour_video_url', true );

	if ( ! empty( $tour_video_url ) ) {
		?>
        <div class="rh_property__video">
			<?php
			$property_video_title = get_option( 'theme_property_video_title' );
			if ( ! empty( $property_video_title ) ) {
				?><h4 class="rh_property__heading"><?php echo esc_html( $property_video_title ); ?></h4><?php
			}
			?>
            <a href="<?php echo esc_url( $tour_video_url ); ?>" data-fancybox class="inspiry-lightbox-item" data-autoplay="true" data-vbtype="video">
                <div class="play-btn"></div>
				<?php
				$tour_video_image_url = '';
				$tour_video_image_id  = get_post_meta( get_the_ID(), 'REAL_HOMES_tour_video_image', true );
				if ( !empty( $tour_video_image_id ) ) {
					$tour_video_image_src = wp_get_attachment_image_src( $tour_video_image_id, 'property-detail-video-image' );
					if ( isset( $individual_video_image_src[0] ) and !empty( $individual_video_image_src[0] ) ) {
						$tour_video_image_url = $tour_video_image_src[0];
					}
				}

				if ( ! empty( $tour_video_image_url ) ) {
					echo '<img src="' . esc_url( $tour_video_image_url ) . '" alt="' . esc_attr( get_the_title( get_the_ID() ) ) . '">';
				} elseif ( has_post_thumbnail( get_the_ID() ) ) {
					the_post_thumbnail( 'property-detail-video-image' );
				} else {
					inspiry_image_placeholder( 'property-detail-video-image' );
				}
				?>
            </a>
        </div>
		<?php
	} else {

		$inspiry_video_group = get_post_meta( get_the_ID(), 'inspiry_video_group', true );

		if ( ! empty( $inspiry_video_group ) ) {
			?>
            <div class="rh_property__video">
				<?php
				$property_video_title = get_option( 'theme_property_video_title' );
				if ( ! empty( $property_video_title ) ) {
					?><h4 class="rh_property__heading"><?php echo esc_html( $property_video_title ); ?></h4><?php
				}
				?>
                <div class="rh_wrapper_property_videos_slider flexslider">
                    <ul class="slides">
						<?php
						foreach ( $inspiry_video_group as $individual_video ) {

							if ( isset( $individual_video['inspiry_video_group_url'] ) && !empty( $individual_video['inspiry_video_group_url'] ) ) {

								$individual_video_url = $individual_video['inspiry_video_group_url'];
								?>
                                <li>
                                    <div class="rh_property_video">
                                        <div class="rh_property_video_inner">
											<?php
											if ( isset( $individual_video['inspiry_video_group_title'] ) && !empty( $individual_video['inspiry_video_group_title'] ) ) {
												?><h5 class="rh_video_title"><?php echo esc_html( $individual_video['inspiry_video_group_title'] ); ?></h5><?php
											}
											?>
                                            <a data-fancybox href="<?php echo esc_url( $individual_video_url ); ?>"
                                               class="inspiry-lightbox-item"
                                               data-autoplay="true" data-vbtype="video">
                                                <div class="play-btn"></div>
												<?php
												$individual_video_image_url = '';
												if ( isset( $individual_video['inspiry_video_group_image'] ) ) {
													$individual_video_image_id = $individual_video['inspiry_video_group_image'][0];
													if ( !empty( $individual_video_image_id ) ) {
														$individual_video_image_src = wp_get_attachment_image_src( $individual_video_image_id, 'property-detail-video-image' );
														if ( isset( $individual_video_image_src[0] ) and !empty( $individual_video_image_src[0] ) ) {
															$individual_video_image_url = $individual_video_image_src[0];
														}
													}
												}

												if ( ! empty( $individual_video_image_url ) ) {
													echo '<img src="' . esc_url( $individual_video_image_url ) . '" alt="' . esc_attr( get_the_title( get_the_ID() ) ) . '">';
												} elseif ( has_post_thumbnail( get_the_ID() ) ) {
													the_post_thumbnail( 'property-detail-video-image' );
												} else {
													inspiry_image_placeholder( 'property-detail-video-image' );
												}
												?>
                                            </a>
                                        </div>
                                    </div>
                                </li>
								<?php
							}
						}
						?>
                    </ul>
                </div>
            </div>
			<?php
		}
	}
}


