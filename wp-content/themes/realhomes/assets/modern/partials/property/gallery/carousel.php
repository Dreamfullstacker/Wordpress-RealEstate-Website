<div class="property-detail-slider-wrapper clearfix <?php echo esc_attr( $args['class'] ); ?>">
	<div class="inspiry_property_carousel_style rh_property_car_height clearfix images_<?php echo esc_attr( $args['count'] ); ?>">
		<?php

		$properties_images = $args['gallery'];

		foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {

			if ( 'true' === $args['lightbox'] ) {

				echo '<a class="slider-img"  style="background-image:url(' . esc_url( $prop_image_meta['url'] ) . ')" data-fancybox="gallery" href="' . esc_url( $prop_image_meta['full_url'] ) . '" data-thumb="' . esc_url( $prop_image_meta['full_url'] ) . '" data-caption="' . esc_attr( $prop_image_meta['title'] ) . '"></a>';

			} else {

				echo '<a class="slider-img"  style="background-image:url(' . esc_url( $prop_image_meta['url'] ) . ')" data-fancybox="gallery" href="' . esc_url( $prop_image_meta['full_url'] ) . '" data-thumb="' . esc_url( $prop_image_meta['full_url'] ) . '" ></a>';

			}
		}
		?>
	</div>
</div>
