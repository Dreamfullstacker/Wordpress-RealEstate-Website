<?php
/**
 * Gallery post format.
 */
?>
<div class="rh_slider_mod_elementor">
	<div class="listing-slider_elementor">
		<ul class="slides">
			<?php
			global $news_grid_size;
			rhea_list_gallery_images( $news_grid_size );
            ?>
		</ul>
	</div>
	<div class="rh_flexslider__nav_main_gallery">
		<a href="#" class="flex-prev rh_flexslider__prev nav-mod">
			<?php include( RHEA_ASSETS_DIR . '/icons/arrow-right.svg' ); ?>
		</a>
		<a href="#" class="flex-next rh_flexslider__next nav-mod">
			<?php include( RHEA_ASSETS_DIR . '/icons/arrow-right.svg' ); ?>
		</a>
	</div>
</div>
