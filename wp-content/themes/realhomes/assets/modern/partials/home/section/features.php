<?php
/**
 * Features section of the homepage.
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;
$inspiry_features = get_post_meta( get_the_ID(), 'inspiry_features', true );
$get_border_type  = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-mod';
} else {
	$border_class = 'flat-border';
}
?>

<section class="rh_section rh_section__features <?php echo esc_attr($border_class); ?>">

	<div class="diagonal-mod-background"></div>

	<div class="wrapper-section-contents">

	<?php
	$inspiry_home_features_subtitle = get_post_meta( get_the_ID(), 'inspiry_home_features_sub_title', true );
	$inspiry_home_features_title    = get_post_meta( get_the_ID(), 'inspiry_home_features_title', true );
	$inspiry_home_features_desc     = get_post_meta( get_the_ID(), 'inspiry_home_features_desc', true );
	inspiry_modern_home_heading( $inspiry_home_features_subtitle, $inspiry_home_features_title, $inspiry_home_features_desc );
	?>

	<?php if ( ! empty( $inspiry_features ) ) : ?>

		<div class="rh_section__features_wrap">

			<?php foreach ( $inspiry_features as $inspiry_feature => $feature ) : ?>
				<div class="rh_feature">
					<?php
					$icon_id       = $feature['inspiry_feature_icon'][0];
					$feature_title = ( isset( $feature['inspiry_feature_name'] ) ) ? $feature['inspiry_feature_name'] : false;
					$feature_url   = ( isset( $feature['inspiry_feature_link'] ) ) ? $feature['inspiry_feature_link'] : false;
					$feature_desc  = ( isset( $feature['inspiry_feature_desc'] ) ) ? $feature['inspiry_feature_desc'] : false;
					if ( $icon_id ) {
						$icon_url = wp_get_attachment_image_url( $icon_id, 'full' );
						if ( $icon_url && ! empty( $feature_url ) ) {
							?>
							<a href="<?php echo esc_url( $feature_url ); ?>" class="rh_feature__icon">
								<img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_html( $feature_title ); ?>">
							</a>
							<!-- /.rh_feature__icon -->
							<?php
						} elseif ( $icon_url && empty( $feature_url ) ) {
							?>
							<div class="rh_feature__icon">
								<img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_html( $feature_title ); ?>">
							</div>
							<!-- /.rh_feature__icon -->
							<?php
						}
					}
					?>
					<?php if ( ! empty( $feature_title ) && ! empty( $feature_url ) ) : ?>
						<h4 class="rh_feature__title">
							<a href="<?php echo esc_url( $feature_url ); ?>">
								<?php echo esc_html( $feature_title ); ?>
							</a>
						</h4>
						<!-- /.rh_feature__title -->
					<?php elseif ( ! empty( $feature_title ) && empty( $feature_url ) ) : ?>
						<h4 class="rh_feature__title"><?php echo esc_html( $feature_title ); ?></h4>
						<!-- /.rh_feature__title -->
					<?php endif; ?>

					<?php if ( ! empty( $feature_desc ) ) : ?>
						<div class="rh_feature__desc">
							<p><?php echo inspiry_kses( $feature_desc ); ?></p>
						</div>
						<!-- /.rh_feature__desc -->
					<?php endif; ?>
				</div>
				<!-- /.rh_feature -->
			<?php endforeach; ?>

		</div>
		<!-- /.rh_section__features_wrap -->

	<?php endif; ?>
</div>
</section>
<!-- /.rh_section rh_section__features -->
