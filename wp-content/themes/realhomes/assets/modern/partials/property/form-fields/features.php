<?php
/**
 * Field: Features
 *
 * @since    3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_form__item rh_form--1-column rh_form--columnAlign features-fields-wrapper">
    <label><?php esc_html_e( 'Features', 'framework' ); ?></label>
    <ul class="features-checkboxes clearfix">
		<?php
		if ( class_exists( 'ERE_Data' ) ) {

			// Existing features of a property
			$property_features_ids = array();
			if ( inspiry_is_edit_property() ) {
				global $target_property;
				$property_feature_terms = get_the_terms( $target_property->ID, 'property-feature' );
				if ( ! empty( $property_feature_terms ) && ! is_wp_error( $property_feature_terms ) ) {
					foreach ( $property_feature_terms as $feature_term ) {
						$property_features_ids[] = $feature_term->term_id;
					}
				}
			}

			// All features from database
			$feature_terms = ERE_Data::get_hierarchical_property_features();

			if ( ! empty( $feature_terms ) ) {
				$feature_counter = 1;
				foreach ( $feature_terms as $feature ) {
					echo '<li class="rh_checkbox">';
					echo '<label for="feature-' . esc_attr( $feature_counter ) . '"><span class="rh_checkbox__title">' . esc_attr( $feature['name'] ) . '</span>';
					if ( inspiry_is_edit_property() && in_array( $feature['term_id'], $property_features_ids ) ) {
						echo '<input type="checkbox" name="features[]" id="feature-' . esc_attr( $feature_counter ) . '" value="' . esc_attr( $feature['term_id'] ) . '" checked />';
					} else {
						echo '<input type="checkbox" name="features[]" id="feature-' . esc_attr( $feature_counter ) . '" value="' . esc_attr( $feature['term_id'] ) . '" />';
					}
					echo '<span class="rh_checkbox__indicator"></span></label>';
					echo '</li>';
					$feature_counter ++;
				}
			}
		}
		?>
    </ul>
</div>
<!-- /.rh_form__item -->
