<?php
/**
 * Banner: Gallery
 *
 * Banner for gallery pages.
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

$rev_slider_alias = trim( get_post_meta( get_the_ID(),'REAL_HOMES_rev_slider_alias',true ) );
if ( function_exists( 'putRevSlider' ) && ( ! empty( $rev_slider_alias ) ) ) {
	putRevSlider( $rev_slider_alias );
} else {

	// Banner Image.
	$banner_image_path = '';
	$banner_image_id = get_post_meta( get_the_ID(), 'REAL_HOMES_page_banner_image', true );
	if ( $banner_image_id ) {
	    $banner_image_path = wp_get_attachment_url( $banner_image_id );
	} else {
	    $banner_image_path = get_default_banner();
	}

	// Banner Title.
	$banner_title = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title', true );
	if ( empty( $banner_title ) ) {
	    $banner_title = get_option( 'theme_gallery_banner_title' );
	    if ( empty( $banner_title ) ) {
	        $banner_title = get_the_title( get_the_ID() );
	    }
	}

	// website level banner title show/hide setting
	$hide_banner_title = get_option( 'theme_banner_titles' );
	if ( is_front_page() ) {
		$hide_banner_title = 'true';
	}
	?>
	<section class="rh_banner rh_banner__image" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
		<div class="rh_banner__cover"></div>
		<div class="rh_banner__wrap">
            <?php
            // Page level banner title show/hide setting
            $banner_title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title_display', true );

            if ( ( 'true' != $hide_banner_title ) && ( 'hide' != $banner_title_display ) ) {
	            ?><h1 class="rh_banner__title"><?php echo esc_html( $banner_title ); ?></h1><?php
            }
            ?>

			<?php if ( is_page_template( 'templates/list-layout.php' ) || is_page_template( 'templates/list-layout-full-width.php' ) || is_page_template( 'templates/grid-layout.php' ) || is_page_template( 'templates/grid-layout-full-width.php' ) ) : ?>
				<div class="rh_banner__controls">
					<?php get_template_part( 'assets/modern/partials/properties/view-buttons' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</section>
	<?php

}
