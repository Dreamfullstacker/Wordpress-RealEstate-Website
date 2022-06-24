<?php
/**
 * CTA section of the homepage.
 *
 * @package    realhomes
 * @subpackage modern
 */

$inspiry_cta_title         = get_post_meta( get_the_ID(), 'inspiry_cta_title', true );
$inspiry_cta_desc          = get_post_meta( get_the_ID(), 'inspiry_cta_desc', true );
$inspiry_cta_btn_one_title = get_post_meta( get_the_ID(), 'inspiry_cta_btn_one_title', true );
$inspiry_cta_btn_one_url   = get_post_meta( get_the_ID(), 'inspiry_cta_btn_one_url', true );
$inspiry_cta_btn_two_title = get_post_meta( get_the_ID(), 'inspiry_cta_btn_two_title', true );
$inspiry_cta_btn_two_url   = get_post_meta( get_the_ID(), 'inspiry_cta_btn_two_url', true );
$get_border_type           = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-mod';
}else{
	$border_class = 'flat-border';
}

?>

<section class="rh_section my-test rh_section__cta rh_cta--featured <?php echo esc_attr($border_class); ?>">

	<div class="diagonal-mod-background">
	<div class="rh_cta rh_parallax_cta">
	</div>
	</div>
	<!-- /.rh_cta -->

	<div class="wrapper-section-contents">
	<div class="rh_cta__wrap">

		<?php if ( ! empty( $inspiry_cta_title ) ) : ?>
			<p class="rh_cta__title">
				<?php echo esc_html( $inspiry_cta_title ); ?>
			</p>
			<!-- /.rh_cta__title -->
		<?php endif; ?>

		<?php if ( $inspiry_cta_desc ) : ?>
			<h3 class="rh_cta__quote">
				<?php echo wp_kses( $inspiry_cta_desc, inspiry_allowed_html() ); ?>
			</h3>
			<!-- /.rh_cta__quote -->
		<?php endif; ?>

		<div class="rh_cta__btns">

			<?php if ( $inspiry_cta_btn_one_title ) : ?>
				<a href="<?php echo esc_url( $inspiry_cta_btn_one_url ); ?>" class="rh_btn rh_btn--secondary">
					<?php echo esc_html( $inspiry_cta_btn_one_title ); ?>
				</a>
			<?php endif; ?>

			<?php if ( $inspiry_cta_btn_one_title ) : ?>
				<a href="<?php echo esc_url( $inspiry_cta_btn_two_url ); ?>" class="rh_btn rh_btn--greyBG">
					<?php echo esc_html( $inspiry_cta_btn_two_title ); ?>
				</a>
			<?php endif; ?>

		</div>
		<!-- /.rh_cta__btns -->

	</div>
	</div>
	<!-- /.rh_cta__wrap -->

</section>
<!-- /.rh_section rh_section__cta -->
