<?php
/**
 * Works for both maps ( Google and Open Street )
 *
 * @package    realhomes
 * @subpackage classic
 */

$display_map          = get_option( 'theme_display_google_map' );
$display_social_share = get_option( 'theme_display_social_share', 'true' );

if ( 'true' === $display_map || 'true' === $display_social_share ) {
	?>
    <div class="map-wrap clearfix">
		<?php
		$property_location = get_post_meta( get_the_ID(), 'REAL_HOMES_property_location', true );
		$property_address  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
		$hide_property_map = get_post_meta( get_the_ID(), 'REAL_HOMES_property_map', true );

		if ( ! empty( $property_location ) && ! empty( $property_address ) && ( 'true' == $display_map ) && ( 1 != $hide_property_map ) ) {

			// Property map title
			$property_map_title = get_option( 'theme_property_map_title' );
			if ( ! empty( $property_map_title ) ) {
				?><span class="map-label"><?php echo esc_html( $property_map_title ); ?></span><?php
			}

			// Map div ( works with both maps )
			?>
            <div id="property_map"></div><?php
		}

		/**
		 * Social share
		 */
		if ( 'true' === $display_social_share ) {
			get_template_part( 'assets/classic/partials/property/single/social-share' );
		}
		?>
    </div>
	<?php
}