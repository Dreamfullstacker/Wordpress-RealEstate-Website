<?php
global $settings;
$compare_properties_module = get_option( 'theme_compare_properties_module' );
$inspiry_compare_page      = get_option( 'inspiry_compare_page' );
if ( 'enable' === $compare_properties_module && $inspiry_compare_page ) {

	$property_id      = get_the_ID();
	$property_img_url = get_the_post_thumbnail_url( $property_id, 'property-thumb-image' );
	if ( empty( $property_img_url ) ) {
		$property_img_url = get_inspiry_image_placeholder_url( 'property-thumb-image' );
	}
//	if ( 'yes' == $settings['ere_enable_compare_properties'] ) {
	?>
	<span class="add-to-compare-span rhea_compare_icons rhea_svg_fav_icons compare-btn-<?php echo esc_attr( $property_id ); ?>"
			data-property-id="<?php echo esc_attr( $property_id ); ?>"
			data-property-title="<?php echo esc_attr( get_the_title( $property_id ) ); ?>"
			data-property-url="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>"
			data-property-image="<?php echo esc_url( $property_img_url ); ?>"

	>
		<span class="compare-placeholder highlight hide"
			data-tooltip="<?php echo esc_attr( $settings['ere_property_compare_added_label'] ); ?>">
			<?php include RHEA_ASSETS_DIR . 'icons/icon-compare.svg'; ?>
		</span>
		<a class="rh_trigger_compare rhea_add_to_compare" data-tooltip="<?php echo esc_attr( $settings['ere_property_compare_label'] ); ?>" href="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>">
			<?php include RHEA_ASSETS_DIR . 'icons/icon-compare.svg'; ?>
		</a>
	</span>
	<?php
//	}
}
