<?php
/**
 * Banner: Property Archive
 *
 * Banner for property archive.
 *
 * @package realhomes
 * @subpackage modern
 */

// Banner Image.
$banner_image_path = get_default_banner(); ?>

<section class="rh_banner rh_banner__image" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
	<div class="rh_banner__cover"></div>
	<div class="rh_banner__wrap">

		<h1 class="rh_banner__title"><?php post_type_archive_title(); ?></h1>

		<div class="rh_banner__controls">
			<?php get_template_part( 'assets/modern/partials/properties/view-buttons' ); ?>
		</div>

	</div>
</section>
