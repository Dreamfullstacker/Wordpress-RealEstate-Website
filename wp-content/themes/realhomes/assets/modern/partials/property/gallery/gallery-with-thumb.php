<div class="property-detail-slider-wrapper clearfix">
	<div id="property-detail-slider-two" class="property-detail-slider-two inspiry_property_portrait_slider flexslider rh_property_load_height">
		<ul class="slides">
			<?php

			$properties_images = $args['gallery'];

			foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {
				echo '<li>';
				if ( 'true' === $args['lightbox'] ) {
					echo '<a href="' . $prop_image_meta['full_url'] . '" data-fancybox="gallery" class=" " data-caption="' . $prop_image_meta['title'] . '">';
				} else {
					echo '<a href="' . $prop_image_meta['full_url'] . '" data-fancybox="gallery" class="" >';
				}
				echo '<img src="' . $prop_image_meta['url'] . '" alt="' . $prop_image_meta['title'] . '" />';
				echo '</a>';
				echo '</li>';
			}
			?>
		</ul>
	</div>

	<div id="property-detail-slider-carousel-nav" class="property-detail-slider-carousel-nav inspiry_property_portrait_thumbnails flexslider">
		<ul class="slides">
			<?php
			foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {
				$slider_thumb = wp_get_attachment_image_src( $prop_image_id, 'property-thumb-image' );
				echo '<li>';
				echo '<img src="' . $slider_thumb[0] . '" alt="' . $prop_image_meta['title'] . '" />';
				echo '</li>';
			}
			?>
		</ul>
	</div>
</div>
