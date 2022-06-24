<a class="rh_permalink rh_scale_animation" href="<?php the_permalink() ?>">
	<?php
	if ( has_post_thumbnail( get_the_ID() ) ) {
		the_post_thumbnail( 'modern-property-child-slider' );
	} else {
		if ( function_exists( 'inspiry_image_placeholder' ) ) {
			inspiry_image_placeholder( 'modern-property-child-slider' );
		}
	}
	?>
</a>