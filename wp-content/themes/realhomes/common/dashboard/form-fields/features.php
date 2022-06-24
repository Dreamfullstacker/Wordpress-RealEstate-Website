<?php
/**
 * Field: Features
 *
 * @package realhomes/dashboard
 */
?>
<div class="property-features-fields">
    <label><?php esc_html_e( 'Features', 'framework' ); ?></label>
    <ul class="property-features list-unstyled">
		<?php
		if ( class_exists( 'ERE_Data' ) ) {

			// Existing features of a property
			$property_features_ids = array();
			if ( realhomes_dashboard_edit_property() ) {
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
					echo '<li class="property-features-item checkbox-field">';
					if ( realhomes_dashboard_edit_property() && in_array( $feature['term_id'], $property_features_ids ) ) {
						echo '<input type="checkbox" name="features[]" id="feature-' . esc_attr( $feature_counter ) . '" value="' . esc_attr( $feature['term_id'] ) . '" checked />';
					} else {
						echo '<input type="checkbox" name="features[]" id="feature-' . esc_attr( $feature_counter ) . '" value="' . esc_attr( $feature['term_id'] ) . '" />';
					}
					echo '<label for="feature-' . esc_attr( $feature_counter ) . '">' . esc_attr( $feature['name'] ) . '</label>';
					echo '</li>';
					$feature_counter ++;
				}
			}
		}
		?>
    </ul>
</div>