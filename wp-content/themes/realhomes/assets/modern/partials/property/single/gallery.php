<?php
/**
 * Single Property: Gallery
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;

$size = 'post-featured-image';

$change_gallery_slider_type = get_post_meta( get_the_ID(), 'REAL_HOMES_change_gallery_slider_type', true );
$gallery_slider_type        = get_post_meta( get_the_ID(), 'REAL_HOMES_gallery_slider_type', true );
$properties_images          = rwmb_meta( 'REAL_HOMES_property_images', 'type=plupload_image&size=' . $size, get_the_ID() );
$prop_detail_login          = inspiry_prop_detail_login();
$images_count               = count( $properties_images );
$title_in_lightbox          = get_option( 'inspiry_display_title_in_lightbox' );
$class                      = '';

if ( '1' !== $change_gallery_slider_type ) {
	$gallery_slider_type = get_option( 'inspiry_gallery_slider_type', 'thumb-on-right' );
}

if ( 'fw-carousel-style' === $gallery_slider_type ) {
	$class = 'inspiry_property_fw_carousel_style';
}

if ( ! empty( $properties_images ) && 1 < count( $properties_images ) && ( 'yes' != $prop_detail_login || is_user_logged_in() ) ) { ?>
	<?php

	$args = array(
		'class'    => $class,
		'count'    => $images_count,
		'gallery'  => $properties_images,
		'lightbox' => $title_in_lightbox,
	);

	if ( 'carousel-style' === $gallery_slider_type || 'fw-carousel-style' === $gallery_slider_type ) {

		get_template_part( 'assets/modern/partials/property/gallery/carousel', '', $args );

	} elseif ( 'masonry-style' === $gallery_slider_type ) {

		get_template_part( 'assets/modern/partials/property/gallery/masonry', '', $args );

	} elseif ( 'thumb-on-bottom' === $gallery_slider_type ) {

		get_template_part( 'assets/modern/partials/property/gallery/gallery-with-thumb', '', $args );

	} elseif ( 'img-pagination' === $gallery_slider_type ) {

		get_template_part( 'assets/modern/partials/property/gallery/gallery-with-thumb2', '', $args );

	} else {
		get_template_part( 'assets/modern/partials/property/gallery/default', '', $args );

	};

	if ( has_post_thumbnail() ) {
		?>
		<div id="property-featured-image" class="clearfix only-for-print">
			<?php
			$image_id  = get_post_thumbnail_id();
			$image_url = wp_get_attachment_url( $image_id );
			echo '<img src="' . esc_url( $image_url ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" />';
			?>
		</div>
		<?php
	};

} elseif ( has_post_thumbnail() ) {
	?>
	<div id="property-featured-image" class="clearfix">
		<?php
		$image_id  = get_post_thumbnail_id();
		$image_url = wp_get_attachment_url( $image_id );
		echo '<a href="' . esc_url( $image_url ) . '" data-fancybox="gallery" class="" >';
		echo '<img src="' . esc_url( $image_url ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" />';
		echo '</a>';
		?>
	</div>
	<?php
}
