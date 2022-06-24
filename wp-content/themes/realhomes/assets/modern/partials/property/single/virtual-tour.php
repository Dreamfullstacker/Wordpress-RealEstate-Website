<?php
/**
 * 360 virtual tour of the single property.
 *
 * @package    realhomes
 * @subpackage modern
 */
if ( 'true' === get_option( 'inspiry_display_virtual_tour' ) ) {
	$rh_360_virtual_tour = trim( get_post_meta( get_the_ID(), 'REAL_HOMES_360_virtual_tour', true ) );
	if ( ! empty( $rh_360_virtual_tour ) ) {
		?>
		<div class="rh_property__virtual_tour">
			<?php
			$inspiry_virtual_tour_title = get_option( 'inspiry_virtual_tour_title' );
			if ( ! empty( $inspiry_virtual_tour_title ) ) { ?>
				<h4 class="rh_property__heading"><?php echo esc_html( $inspiry_virtual_tour_title ); ?></h4><?php
			}

			if ( ( has_shortcode( $rh_360_virtual_tour, 'ipanorama' ) || has_shortcode( $rh_360_virtual_tour, 'ipano' ) ) && class_exists( 'iPanorama_Activator' ) ) {
				echo do_shortcode( $rh_360_virtual_tour );
			} else {
				echo wp_kses( $rh_360_virtual_tour, inspiry_embed_code_allowed_html() );
			}

			?>
		</div>
		<?php
	}
}