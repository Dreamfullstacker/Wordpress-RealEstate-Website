<div class="property-detail-slider-wrapper property-detail-pagination-style clearfix">
	<div class="property-detail-slider-three">
			<?php

			$properties_images = $args['gallery'];

			foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {
				echo '<div>';
				if ( 'true' === $args['lightbox'] ) {
					echo '<a href="' . $prop_image_meta['full_url'] . '" data-fancybox="gallery" class=" " data-caption="' . $prop_image_meta['title'] . '">';
				} else {
					echo '<a href="' . $prop_image_meta['full_url'] . '" data-fancybox="gallery" class="" >';
				}
				echo '<img src="' . $prop_image_meta['url'] . '" alt="' . $prop_image_meta['title'] . '" />';
				echo '</a>';
				echo '</div>';
			}
			?>
	</div>
	<div class="property-detail-carousel-three">
			<?php
			foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {
				$slider_thumb = wp_get_attachment_image_src( $prop_image_id, 'property-thumb-image' );
				echo '<img src="' . $slider_thumb[0] . '" alt="' . $prop_image_meta['title'] . '" />';
			}
			?>
	</div>
</div>
