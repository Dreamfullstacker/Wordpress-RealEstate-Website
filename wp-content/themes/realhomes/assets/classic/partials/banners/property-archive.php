<?php
/**
 * Banner: Property Archive
 *
 * @package    realhomes
 * @subpackage classic
 */

// Banner Image.
$banner_image_path = get_default_banner();
?>

<div class="page-head" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
	<?php if ( ! ( 'true' == get_option( 'theme_banner_titles' ) ) ) { ?>
		<div class="container">
			<div class="wrap clearfix">
				<h1 class="page-title"><span><?php post_type_archive_title(); ?></span></h1>
			</div>
		</div>
	<?php } ?>
</div><!-- End Page Head -->
