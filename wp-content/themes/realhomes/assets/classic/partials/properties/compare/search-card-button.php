<?php
/**
 * Compare property button for the search results page properties.
 *
 * @package    realhomes
 * @subpackage classic
 */

$property_id      = get_the_ID();
$property_img_url = get_the_post_thumbnail_url( $property_id, 'property-thumb-image' );
if ( empty( $property_img_url ) ) {
	$property_img_url = get_inspiry_image_placeholder_url( 'property-thumb-image' );
}
?>
<span class="add-to-compare-span add-to-compare-search compare-btn-<?php echo esc_attr( $property_id ); ?>">
	<span class="compare-placeholder compare_output hide">
		<span class="compare-tooltip" aria-label="<?php esc_html_e( 'Added to Compare', 'framework' ); ?>">
			<i class="fas fa-plus dim"></i>
		</span>
		<span class="compare_target dim compare-label"></span>
	</span>
	<span class="compare-tooltip" aria-label="<?php esc_html_e( 'Add to Compare', 'framework' ); ?>"
			data-property-id="<?php echo esc_attr( $property_id ); ?>"
			data-property-title="<?php echo esc_attr( get_the_title( $property_id ) ); ?>"
			data-property-url="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>"
			data-property-image="<?php echo esc_url( $property_img_url ); ?>"
	>
		<a class="rh_trigger_compare add-to-compare" href="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>">
			<i class="fas fa-plus"></i><span class="compare-label"><?php esc_html_e( 'Add to Compare', 'framework' ); ?></span>
		</a>
	</span>
</span>
