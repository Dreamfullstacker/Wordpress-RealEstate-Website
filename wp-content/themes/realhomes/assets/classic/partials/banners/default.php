<?php
/**
 * Banner: Default
 *
 * @package    realhomes
 * @subpackage classic
 */

global $post;

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

	?>
	<div class="page-head" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
		<?php
        // website level setting ( hide theme banner titles )
        if ( ( 'true' != get_option( 'theme_banner_titles' ) ) ) {

            // Page level setting
	        $banner_title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title_display', true );
	        if ( 'hide' != $banner_title_display ) {

		        // Banner title
		        $banner_title = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title', true );
		        if ( empty( $banner_title ) ) {
			        $banner_title = get_the_title( get_the_ID() );
		        }

		        if ( realhomes_is_woocommerce_activated() ) {
			        if ( is_shop() ) {
				        $banner_title = woocommerce_page_title( false );
			        }
		        }
		        ?>
                <div class="container">
                    <div class="wrap clearfix">
                        <h1 class="page-title"><span><?php echo esc_html( $banner_title ); ?></span></h1>
				        <?php
				        // Banner Sub Title.
				        $banner_sub_title = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_sub_title', true );

				        if ( $banner_sub_title ) {
					        ?><p><?php echo esc_html( $banner_sub_title ); ?></p><?php
				        }
				        ?>
                    </div>
                </div>
		        <?php
	        }
        }
        ?>
	</div><!-- End Page Head -->
	<?php
}
?>