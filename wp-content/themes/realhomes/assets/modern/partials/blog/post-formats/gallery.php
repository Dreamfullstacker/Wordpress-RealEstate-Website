<?php
/**
 * Gallery post format.
 *
 * @package    realhomes
 * @subpackage modern
 */

?>
<div class="rh_slider_mod">
	<div class="listing-slider ">
		<ul class="slides">
			<?php
			if( is_page_template('templates/home.php') ){
				list_gallery_images( 'modern-property-child-slider' );
			}else{
				list_gallery_images();
			}
			?>
		</ul>
	</div>
	<div class="rh_flexslider__nav_main_gallery">
		<a href="#" class="flex-prev rh_flexslider__prev nav-mod">
			<?php inspiry_safe_include_svg( '/images/icons/icon-arrow-right.svg' ); ?>
		</a>
		<!-- /.rh_flexslider__prev -->
		<a href="#" class="flex-next rh_flexslider__next nav-mod">
			<?php inspiry_safe_include_svg( '/images/icons/icon-arrow-right.svg' ); ?>
		</a>
		<!-- /.rh_flexslider__next -->
	</div>
</div>
