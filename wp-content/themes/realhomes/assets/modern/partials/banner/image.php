<?php
/**
 * Banner: Image
 *
 * Image banner for page templates.
 *
 * @package realhomes
 * @subpackage modern
 */

// Revolution Slider if alias is provided and plugin is installed.
$rev_slider_alias = get_post_meta( get_the_ID(), 'REAL_HOMES_rev_slider_alias', true );
if ( function_exists( 'putRevSlider' ) && ( ! empty( $rev_slider_alias ) ) ) {
	putRevSlider( $rev_slider_alias );
} else {
	// Banner Image.
	$banner_image_path = '';

	if ( is_page_template( 'templates/home.php' ) ) {
		$banner_image_id = get_post_meta( get_the_ID(), 'REAL_HOMES_home_banner_image', true );
	} else {
		$banner_image_id = get_post_meta( get_the_ID(), 'REAL_HOMES_page_banner_image', true );
	}

	if ( $banner_image_id ) {
		$banner_image_path = wp_get_attachment_url( $banner_image_id );
	} else {
		$banner_image_path = get_default_banner();
	}

	// Banner Title.
	$banner_title = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title', true );
	if ( empty( $banner_title ) ) {
		$banner_title = get_the_title( get_the_ID() );
	}

	if ( realhomes_is_woocommerce_activated() ) {
		if ( is_shop() ) {
			$banner_title = woocommerce_page_title( false );
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
				if ( is_page_template( array(
					'templates/2-columns-gallery.php',
					'templates/3-columns-gallery.php',
					'templates/4-columns-gallery.php',
					'templates/agencies-list.php',
					'templates/agents-list.php',
					'templates/compare-properties.php',
					'templates/contact.php',
					'templates/dsIDXpress.php',
					'templates/edit-profile.php',
					'templates/favorites.php',
					'templates/grid-layout.php',
					'templates/half-map-layout.php',
					'templates/list-layout.php',
					'templates/login-register.php',
					'templates/membership-plans.php',
					'templates/my-properties.php',
					'templates/optima-express.php',
					'templates/properties-search.php',
					'templates/properties-search-half-map.php',
					'templates/properties-search-left-sidebar.php',
					'templates/properties-search-right-sidebar.php',
					'templates/submit-property.php',
					'templates/users-lists.php',
				) ) ) {
					?><h1 class="rh_banner__title"><?php echo esc_html( $banner_title ); ?></h1><?php
				} else {
					?><h2 class="rh_banner__title"><?php echo esc_html( $banner_title ); ?></h2><?php
				}
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
