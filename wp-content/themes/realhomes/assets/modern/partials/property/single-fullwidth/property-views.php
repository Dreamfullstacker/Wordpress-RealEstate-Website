<?php
/**
 * Display Property Views Graph
 *
 * @since 3.10
 * @package realhomes/modern
 */

if ( inspiry_is_property_analytics_enabled() ) {
	$section_title = get_option( 'inspiry_property_views_title', esc_html__( 'Property Views', 'framework' ) );
	?>
	<div class="property-views-wrapper single-property-section">
		<div class="container">
		<div class="rh_property__views_wrap">
			<?php
			if ( ! empty( $section_title ) ) {
				echo '<h4 class="rh_property__heading">' . esc_html( $section_title ) . '</h4>';
			}
			?>
			<canvas id="property-views-graph"></canvas>
		</div>
		</div>
	</div>
	<?php
}
?>
