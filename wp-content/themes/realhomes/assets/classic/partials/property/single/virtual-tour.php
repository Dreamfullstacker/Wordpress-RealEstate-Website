<?php
/**
 * Property Virtual Tour
 *
 * @package    realhomes
 * @subpackage classic
 */

$inspiry_display_virtual_tour = get_option( 'inspiry_display_virtual_tour' );
if ( 'true' === $inspiry_display_virtual_tour ) {
	global $post;
	$rh_360_virtual_tour = get_post_meta( get_the_ID(), 'REAL_HOMES_360_virtual_tour', true );

	if ( ! empty( $rh_360_virtual_tour ) ) {
		?>
		<div class="property-virtual-tour">
			<?php
			$inspiry_virtual_tour_title = get_option( 'inspiry_virtual_tour_title' );
			if ( ! empty( $inspiry_virtual_tour_title ) ) {
				?><span class="virtual-tour-label"><?php echo esc_html( $inspiry_virtual_tour_title ); ?></span><?php
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
