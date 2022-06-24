<?php
/**
 * Blog banner.
 *
 * @package    realhomes
 * @subpackage modern
 */

$banner_title = get_option( 'theme_news_banner_title' );
$banner_title = empty( $banner_title ) ? esc_html__( 'News', 'framework' ) : $banner_title;

$banner_image_path = '';

/* If posts page is set in Reading Settings */
$page_for_posts = get_option( 'page_for_posts' );
if ( $page_for_posts ) {
	$banner_image_id = get_post_meta( $page_for_posts, 'REAL_HOMES_page_banner_image', true );
	if ( $banner_image_id ) {
		$banner_image_path = wp_get_attachment_url( $banner_image_id );
	} else {
		$banner_image_path = get_default_banner();
	}
} else {
	$banner_image_path = get_default_banner();
}
?>

<section class="rh_banner rh_banner__image" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
	<div class="rh_banner__cover"></div>
	<div class="rh_banner__wrap">

		<?php if ( is_home() ) { ?>
		<h1 class="rh_banner__title"><?php echo esc_html( $banner_title ); ?></h1>
		<?php } else { ?>
		<h2 class="rh_banner__title"><?php echo esc_html( $banner_title ); ?></h2>
		<?php } ?>

		<?php if ( is_page_template( 'templates/list-layout.php' ) || is_page_template( 'templates/list-layout-full-width.php' ) || is_page_template( 'templates/grid-layout.php' ) || is_page_template( 'templates/grid-layout-full-width.php' ) ) : ?>
			<div class="rh_banner__controls">
				<?php get_template_part( 'assets/modern/partials/properties/view-buttons' ); ?>
			</div>
		<?php endif; ?>

	</div>
</section>
