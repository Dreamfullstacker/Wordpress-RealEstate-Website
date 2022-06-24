<div class="property-detail-slider-wrapper clearfix">
	<div class="inspiry_property_masonry_style images_<?php echo esc_attr( $args['count'] ); ?>">
		<?php
		$div_insert        = 1;
		$properties_images = $args['gallery'];
		$template          = get_post_meta( get_the_ID(), '_wp_page_template', true );
		
		if ( empty( $template ) ) {
			$template = get_option( 'inspiry_property_single_template' );
		}
		
		foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {

			if ( 'true' === $args['lightbox'] ) {

				echo '<a class="slider-img" style="background-image:url(' . esc_url( $prop_image_meta['url'] ) . ')" data-fancybox="gallery" href="' . esc_url( $prop_image_meta['full_url'] ) . '" data-thumb="' . esc_url( $prop_image_meta['full_url'] ) . '" data-caption="' . esc_attr( $prop_image_meta['title'] ) . '">';

			} else {

				echo '<a class="slider-img" style="background-image:url(' . esc_url( $prop_image_meta['url'] ) . ')" data-fancybox="gallery" href="' . esc_url( $prop_image_meta['full_url'] ) . '" data-thumb="' . esc_url( $prop_image_meta['full_url'] ) . '" >';
			}

			if ( 'templates/property-full-width-layout.php' === $template || 'fullwidth' === $template ) {

				if ( 5 < $args['count'] && 5 === $div_insert || 3 < $args['count'] && 3 === $div_insert ) {

					echo '<span>' . get_option( 'inspiry_masonry_gallery_count_text', 'See All Photos' ) . ' (' . $args['count'] . ')</span>';

				}
			} else {
				if ( 6 < $args['count'] && 6 === $div_insert || 3 < $args['count'] && 3 === $div_insert ) {

					echo '<span>' . get_option( 'inspiry_masonry_gallery_count_text', 'See All Photos' ) . ' (' . $args['count'] . ')</span>';

				}
			}

			echo '</a>';

			$div_insert++;
		}
		?>
	</div>
</div>
