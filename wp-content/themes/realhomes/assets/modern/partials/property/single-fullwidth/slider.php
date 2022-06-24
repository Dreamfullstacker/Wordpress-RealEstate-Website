<?php
/**
 * Single Property: Slider Fullwidth
 */
$gallery_slider_type = get_post_meta( get_the_ID(), 'REAL_HOMES_gallery_slider_type', true );
$properties_images   = rwmb_meta( 'REAL_HOMES_property_images', 'type=plupload_image&size=' . 'post-featured-image', get_the_ID() );
$prop_detail_login   = inspiry_prop_detail_login();
$images_count        = count( $properties_images );
$title_in_lightbox   = get_option( 'inspiry_display_title_in_lightbox' );
$change_slider_type  = get_post_meta( get_the_ID(), 'REAL_HOMES_change_gallery_slider_type', true );
$class               = '';

if ( '1' !== $change_slider_type ) {
	$gallery_slider_type = get_option( 'inspiry_gallery_slider_type', 'thumb-on-right' );
}

if ( 'fw-carousel-style' === $gallery_slider_type ) {
	$class = 'inspiry_property_fw_carousel_style';
}
?>
<div class="single-property-fullwidth-flexslider <?php echo esc_attr( $gallery_slider_type ); ?>">
	<?php
	if ( ! empty( $properties_images ) && count( $properties_images ) && ( 'yes' != $prop_detail_login || is_user_logged_in() ) ) {
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
		} elseif ( 'img-pagination' === $gallery_slider_type ) {
			get_template_part( 'assets/modern/partials/property/gallery/gallery-with-thumb2', '', $args );
		} elseif ( 'thumb-on-bottom' === $gallery_slider_type ) {
			get_template_part( 'assets/modern/partials/property/gallery/gallery-with-thumb', '', $args );
		} else {
			get_template_part( 'assets/modern/partials/property/gallery/default', '', $args );
		}

		if ( has_post_thumbnail() ) { ?>
            <div id="property-featured-image" class="clearfix only-for-print">
				<?php
				$image_id  = get_post_thumbnail_id();
				$image_url = wp_get_attachment_url( $image_id );
				echo '<img src="' . esc_url( $image_url ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" />';
				?>
            </div>
			<?php
		}

	} elseif ( has_post_thumbnail() ) { ?>
        <div id="property-featured-image" class="clearfix">
			<?php
			$image_id  = get_post_thumbnail_id();
			$image_url = wp_get_attachment_url( $image_id );
			echo '<a href="' . esc_url( $image_url ) . '" data-fancybox="gallery" class="">';
			echo '<img src="' . esc_url( $image_url ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" />';
			echo '</a>';
			?>
        </div>
		<?php
	} else {
		// Page Head.
		$header_variation = get_option( 'inspiry_property_detail_header_variation' );
		if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
			get_template_part( 'assets/modern/partials/banner/header' );
		} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
			// Banner Image.
			$banner_image_path = '';
			$banner_image_id   = get_post_meta( get_the_ID(), 'REAL_HOMES_page_banner_image', true );
			if ( $banner_image_id ) {
				$banner_image_path = wp_get_attachment_url( $banner_image_id );
			} else {
				$banner_image_path = get_default_banner();
			}
			?>
            <section class="rh_banner rh_banner__image" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
                <div class="rh_banner__wrap"></div><!-- /.rh_banner__wrap -->
            </section><!-- /.rh_banner -->
			<?php
		}
	}

	if ( ! in_array( $gallery_slider_type, array( 'carousel-style', 'fw-carousel-style', 'masonry-style'  ) ) ) { ?>
        <div class="property-head-wrapper">
			<?php get_template_part( 'assets/modern/partials/property/single-fullwidth/head' ); ?>
        </div>
	<?php } ?>
</div>