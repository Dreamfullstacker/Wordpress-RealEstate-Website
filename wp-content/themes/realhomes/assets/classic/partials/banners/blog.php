<?php
/**
 * Banner: Blog Page
 *
 * @package    realhomes
 * @subpackage classic
 */
$banner_wrap_display  = '';
$banner_image_path    = '';
$banner_title_display = get_option( 'inspiry_news_page_banner_title_display', 'true' );
$banner_title         = get_option( 'theme_news_banner_title', esc_html__( 'News', 'framework' ) );
$banner_sub_title     = get_option( 'theme_news_banner_sub_title', esc_html__( 'Check out market updates', 'framework' ) );

if ( 'false' === $banner_title_display ) {
	$banner_wrap_display = 'display:none';
}

// If posts page is set in Reading Settings
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
<div class="page-head" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
	<?php if ( ! ( 'true' == get_option( 'theme_banner_titles' ) ) ) : ?>
		<div class="container">
			<div class="wrap clearfix" style="<?php echo esc_attr( $banner_wrap_display ); ?>">
				<?php
				if ( ! empty( $banner_title ) ) :
					if ( is_single() ) :
                        ?><h2 class="page-title"><span><?php echo esc_html( $banner_title ); ?></span></h2><?php
                    else :
                        ?><h1 class="page-title"><span><?php echo esc_html( $banner_title ); ?></span></h1><?php
					endif;
				endif;

				if( ! empty( $banner_sub_title ) ) :
                    ?><p><?php echo esc_html( $banner_sub_title ); ?></p><?php
                endif;
                ?>
			</div>
		</div>
	<?php endif; ?>
</div><!-- End Page Head -->