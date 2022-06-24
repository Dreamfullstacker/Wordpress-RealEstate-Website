<?php
/**
 * Testimonial section of the homepage.
 *
 * @package    realhomes
 * @subpackage modern
 */

$inspiry_testimonial_text = get_post_meta( get_the_ID(), 'inspiry_testimonial_text', true );
$inspiry_testimonial_name = get_post_meta( get_the_ID(), 'inspiry_testimonial_name', true );
$inspiry_testimonial_url  = get_post_meta( get_the_ID(), 'inspiry_testimonial_url', true );
$get_border_type          = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-mod';
} else {
	$border_class = 'flat-border';
}
?>

<section class="rh_section rh_section__testimonial <?php echo esc_attr($border_class); ?>">

	<div class="diagonal-mod-background"></div>
	<!--<div class="rh_testimonial__quote_bg">-->
	<!---->
	<!--</div>-->

	<!-- /.rh_testimonial__quote_left -->

	<div class="wrapper-section-contents">

		<div class="rh_testimonial">
			<div class="quotes-marks mark-left">
				<?php inspiry_safe_include_svg( '/images/icons/quotes.svg' ); ?>
			</div>
			<div class="quotes-marks mark-right">
				<?php inspiry_safe_include_svg( '/images/icons/quotes.svg' ); ?>
			</div>
			<blockquote class="rh_testimonial__quote">
				<?php echo wp_kses( $inspiry_testimonial_text, inspiry_allowed_html() ); ?>
			</blockquote>
			<!-- /.rh_testimonial__quote -->
			<div class="rh_testimonial__author">
				<p class="rh_testimonial__author_name">
					<?php echo esc_html( $inspiry_testimonial_name ); ?>
				</p>
				<!-- /.rh_testimonial__author_name -->
				<p class="rh_testimonial__author__link">
					<a href="<?php echo esc_url( $inspiry_testimonial_url ); ?>">
						<?php echo esc_html( $inspiry_testimonial_url ); ?>
					</a>
				</p>
				<!-- /.rh_testimonial__author__link -->
			</div>
			<!-- /.rh_testimonial__author -->

		</div>
		<!-- /.rh_testimonial -->

	</div>
</section><!-- /.rh_section rh_section__testimonial -->
