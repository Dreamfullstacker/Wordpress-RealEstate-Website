<div class="property-detail-slider-wrapper clearfix">
	<div id="property-detail-flexslider" class="inspiry_property_portrait_slider clearfix">
		<div class="flexslider rh_property_load_height">
			<ul class="slides">
				<?php

				$properties_images = $args['gallery'];

				foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {

					echo '<li>';
					if ( 'true' === $args['lightbox'] ) {
						echo '<a href="' . $prop_image_meta['full_url'] . '" data-fancybox="gallery" class=""  data-caption="' . $prop_image_meta['title'] . '">';
					} else {
						echo '<a href="' . $prop_image_meta['full_url'] . '" data-fancybox="gallery" class=""  >';
					}
					echo '<img src="' . $prop_image_meta['url'] . '" alt="' . esc_attr( $prop_image_meta['title'] ) . '" />';
					echo '</a>';
					echo '</li>';
				}
				?>
			</ul>
		</div>
	</div>
	<?php
	if ( $args['count'] && ( 'fullwidth' === get_option( 'inspiry_property_single_template', 'sidebar' ) || is_page_template( 'templates/property-full-width-layout.php' ) ) ) { ?>
        <span id="slider-item" class="slider-item-count <?php echo esc_attr( 'slides-count-on-' . get_option( 'realhomes_header_layout', 'default' ) ); ?>">
			<span class="slider-item-current">1</span>
			<span class="of"><?php esc_html_e( 'of', 'framework' ); ?></span>
			<span class="slider-item-total"><?php echo esc_html( $args['count'] ); ?></span>
		</span>
	<?php } ?>
</div>