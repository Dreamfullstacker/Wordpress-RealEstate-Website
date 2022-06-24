<a class="rhea_fp_thumb" href="<?php the_permalink(); ?>">
	<?php

	if ( INSPIRY_DESIGN_VARIATION == 'modern' ) {
		$default_prop_grid_size = 'post-featured-image';
	} else {
		$default_prop_grid_size = 'property-detail-slider-image-two';
	}

	if ( has_post_thumbnail( get_the_ID() ) ) {
		the_post_thumbnail( $default_prop_grid_size );
	} else {
		inspiry_image_placeholder( $default_prop_grid_size );
	}
	?>
</a>