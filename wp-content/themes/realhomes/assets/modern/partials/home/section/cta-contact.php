<?php
/**
 * Contact CTA section of the homepage.
 *
 * @package    realhomes
 * @subpackage modern
 */

$inspiry_home_cta_contact_title    = get_post_meta( get_the_ID(), 'inspiry_home_cta_contact_title', true );
$inspiry_home_cta_contact_desc     = get_post_meta( get_the_ID(), 'inspiry_home_cta_contact_desc', true );
$inspiry_cta_contact_btn_one_title = get_post_meta( get_the_ID(), 'inspiry_cta_contact_btn_one_title', true );
$inspiry_cta_contact_btn_one_url   = get_post_meta( get_the_ID(), 'inspiry_cta_contact_btn_one_url', true );
$inspiry_cta_contact_btn_two_title = get_post_meta( get_the_ID(), 'inspiry_cta_contact_btn_two_title', true );
$inspiry_cta_contact_btn_two_url   = get_post_meta( get_the_ID(), 'inspiry_cta_contact_btn_two_url', true );

$get_border_type = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-mod';
} else {
	$border_class = 'flat-border';
}

?>

<section class="rh_section rh_section__cta rh_cta--contact <?php echo esc_attr($border_class);?>">

	<div class="diagonal-mod-background">
		<div class="rh_cta rh_parallax">
			<div class="rh_cta__overlay"></div>
			<!-- /.rh_cta__overlay -->
		</div>
	</div>
	<!-- /.rh_cta -->

	<div class="wrapper-section-contents">
		<div class="rh_cta__wrap">

			<p class="rh_cta__title">
				<?php echo ( ! empty( $inspiry_home_cta_contact_title ) ) ? esc_html( $inspiry_home_cta_contact_title ) : false; ?>
			</p>
			<!-- /.rh_cta__title -->

			<h3 class="rh_cta__quote">
				<?php echo ( ! empty( $inspiry_home_cta_contact_desc ) ) ? wp_kses( $inspiry_home_cta_contact_desc, inspiry_allowed_html() ) : false; ?>
			</h3>
			<!-- /.rh_cta__quote -->

			<div class="rh_cta__btns">

				<?php if ( ! empty( $inspiry_cta_contact_btn_one_title ) ) : ?>
					<a href="<?php echo esc_url( $inspiry_cta_contact_btn_one_url ); ?>" class="rh_btn rh_btn--blackBG">
						<?php echo esc_html( $inspiry_cta_contact_btn_one_title ); ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $inspiry_cta_contact_btn_two_title ) ) : ?>
					<a href="<?php echo esc_url( $inspiry_cta_contact_btn_two_url ); ?>" class="rh_btn rh_btn--whiteBG">
						<?php echo esc_html( $inspiry_cta_contact_btn_two_title ); ?>
					</a>
				<?php endif; ?>

			</div>
			<!-- /.rh_cta__btns -->

		</div>
	</div>
	<!-- /.rh_cta__wrap -->

</section>
<!-- /.rh_section rh_section__cta -->
