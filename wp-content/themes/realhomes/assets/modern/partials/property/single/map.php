<?php
/**
 * Map of the single property.
 *
 * @package    realhomes
 * @subpackage modern
 */

$display_map   = get_option( 'theme_display_google_map' );
if ( 'true' === $display_map ) {
	$property_location = get_post_meta( get_the_ID(), 'REAL_HOMES_property_location', true );
	$property_address  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
	$hide_property_map      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_map', true );

	if ( !empty( $property_address ) && !empty( $property_location ) && ( 1 != $hide_property_map ) ) {
		?>
		<div class="rh_property__map_wrap">
			<?php
			$property_map_title = get_option( 'theme_property_map_title' );
			if ( ! empty( $property_map_title ) ) {
				?><h4 class="rh_property__heading"><?php echo esc_html( $property_map_title ); ?></h4><?php
			}
			?>
			<div id="property_map"></div>
		</div>
		<?php
	}
}
