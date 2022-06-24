<?php
/**
 * Compare Button for the single property page.
 *
 * @package    realhomes
 * @subpackage classic
 */

$property_id = get_the_ID();

$property_img_url = get_the_post_thumbnail_url( $property_id, 'property-thumb-image' );
if ( empty( $property_img_url ) ) {
	$property_img_url = get_inspiry_image_placeholder_url( 'property-thumb-image' );
}
?>
<span class="add-to-compare-span add-to-compare-classic-icon compare-btn-<?php echo esc_attr( $property_id ); ?>"
		data-property-id ="<?php echo esc_attr( $property_id ); ?>"
		data-property-title ="<?php echo esc_attr( get_the_title( $property_id ) ); ?>"
		data-property-url ="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>"
		data-property-image ="<?php echo esc_url( $property_img_url ); ?>"
>
	<div title="<?php esc_attr_e( 'Added To Compare', 'framework' ) ?>" class="compare-placeholder highlight hide">
		<i class="rh_classic_icon_atc fas fa-sync rh_highlight"></i>
	</div>
	<a title="<?php esc_attr_e( 'Add To Compare', 'framework' ) ?>" href="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>" class="rh_trigger_compare add-to-compare">
		<i class="rh_classic_icon_atc fas fa-sync"></i>
	</a>
</span>
