<?php
/**
 * Functions: Compare.
 *
 * This file contain functions related to compare properties.
 *
 * @since 2.6.0
 * @package realhomes
 */

if ( ! function_exists( 'inspiry_add_to_compare_button' ) ) {
	/**
	 * Display add to compare button markup.
	 */
	function inspiry_add_to_compare_button() {
		$compare_properties_module = get_option( 'theme_compare_properties_module' );
		$inspiry_compare_page      = get_option( 'inspiry_compare_page' );
		if ( ( 'enable' === $compare_properties_module ) && ( $inspiry_compare_page ) ) {

			$property_id      = get_the_ID();
			$property_img_url = get_the_post_thumbnail_url( $property_id, 'property-thumb-image' );
			if ( empty( $property_img_url ) ) {
				$property_img_url = get_inspiry_image_placeholder_url( 'property-thumb-image' );
			}

			if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				?>
				<span class="add-to-compare-span compare-btn-<?php echo esc_attr( $property_id ); ?>"
						data-property-id="<?php echo esc_attr( $property_id ); ?>"
						data-property-title="<?php echo esc_attr( get_the_title( $property_id ) ); ?>"
						data-property-url="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>"
						data-property-image="<?php echo esc_url( $property_img_url ); ?>"
				>
					<span class="compare-placeholder highlight hide" data-tooltip="<?php esc_attr_e( 'Added to compare', 'framework' ); ?>">
						<?php inspiry_safe_include_svg( '/images/icons/icon-compare.svg' ); ?>
					</span>
					<a class="rh_trigger_compare add-to-compare" href="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>" data-tooltip="<?php esc_attr_e( 'Add to compare', 'framework' ); ?>">
						<?php inspiry_safe_include_svg( '/images/icons/icon-compare.svg' ); ?>
					</a>
				</span>
				<?php
			} else {
				?>
				<span class="add-to-compare-span compare-btn-<?php echo esc_attr( $property_id ); ?>"
						data-property-id="<?php echo esc_attr( $property_id ); ?>"
						data-property-title="<?php echo esc_attr( get_the_title( $property_id ) ); ?>"
						data-property-url="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>"
						data-property-image="<?php echo esc_url( $property_img_url ); ?>"
				>
					<i class="rh_added_to_compare compare-placeholder highlight hide">
						<i class="rh_classic_icon_atc fas fa-plus-circle dim"></i> <i class="rh_classic_added"><?php esc_html_e( 'Added to Compare', 'framework' ); ?></i>
					</i>
					<a class="rh_trigger_compare add-to-compare" href="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>">
						<i class="rh_classic_icon_atc fas fa-plus-circle"></i>
						<i class="rh_classic_atc"><?php esc_html_e( 'Add to Compare', 'framework' ); ?></i>
					</a>
				</span>
				<?php
			}
		}
	}
}
