<?php
/**
 * Display Property Views Graph
 *
 * @since 3.10
 * @package realhomes/classic
 */

if ( inspiry_is_property_analytics_enabled() ) {
	$section_title = get_option( 'inspiry_property_views_title', esc_html__( 'Property Views', 'framework' ) );
	?>
	<div class="property-views-wrap">
		<?php
		if ( ! empty( $section_title ) ) {
			echo '<h4 class="title">' . esc_html( $section_title ) . '</h4>';
		}
		?>
		<canvas id="property-views-graph"></canvas>
	</div>
	<?php
}
?>
