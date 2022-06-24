<?php

$search_data      = (array) $args['search_data'];
$search_page_url  = inspiry_get_search_page_url();
$search_query_str = $search_data['search_query_str'];
$search_view_url  = $search_page_url . '?' . $search_query_str;
$search_args      = $search_data['search_wp_query_args'];
$search_args      = unserialize( base64_decode( $search_args ) );
$separator        = $args['separator'];
?>
<div class="property-column-wrap search-item-wrap" data-search-item="<?php echo esc_attr( $search_data['id'] ); ?>">

	<!-- Search Information -->
	<div class="saved-search-column-wrap">
		<div class="column search-query">
		<?php
		if ( isset( $search_args['s'] ) && ! empty( $search_args['s'] ) ) {
			echo '<strong>' . esc_html__( 'Keyword', 'framework' ) . ':</strong> ' . esc_attr( $search_args['s'] ) . $separator;
		}

		if ( isset( $search_args['tax_query'] ) ) {

			$feature_terms = array();

			foreach ( $search_args['tax_query'] as $key => $value ) {

				if ( isset( $value['taxonomy'] ) && isset( $value['terms'] ) && 'property-city' === $value['taxonomy'] ) {
					$property_city = inspiry_tax_terms_string( $value['terms'], 'property-city' );
					if ( ! empty( $property_city ) ) {
						echo '<strong>' . esc_html__( 'City', 'framework' ) . ':</strong> ' . esc_attr( $property_city ) . $separator;
					}
				}

				if ( isset( $value['taxonomy'] ) && isset( $value['terms'] ) && 'property-status' === $value['taxonomy'] ) {
					$property_status = inspiry_tax_terms_string( $value['terms'], 'property-status' );
					if ( ! empty( $property_status ) ) {
						echo '<strong>' . esc_html__( 'Status', 'framework' ) . ':</strong> ' . esc_attr( $property_status ) . $separator;
					}
				}

				if ( isset( $value['taxonomy'] ) && isset( $value['terms'] ) && 'property-type' === $value['taxonomy'] ) {
					$property_type = inspiry_tax_terms_string( $value['terms'], 'property-type' );
					if ( ! empty( $property_type ) ) {
						echo '<strong>' . esc_html__( 'Type', 'framework' ) . ':</strong> ' . esc_attr( $property_type ) . $separator;
					}
				}

				if ( isset( $value['taxonomy'] ) && isset( $value['terms'] ) && 'property-feature' === $value['taxonomy'] ) {
					$feature_terms[] = $value['terms'];
				}
			}

			if ( is_array( $feature_terms ) && ! empty( $feature_terms ) ) {
				$property_feature = inspiry_tax_terms_string( $feature_terms, 'property-feature' );
				if ( ! empty( $property_feature ) ) {
					echo '<strong>' . esc_html__( 'Feature', 'framework' ) . ':</strong> ' . esc_attr( $property_feature ) . $separator;
				}
			}
		}

		if ( isset( $search_args['meta_query'] ) ) {
			foreach( $search_args['meta_query'] as $key => $value ) {
				if ( isset( $value['key'] ) && ! empty( $value['key'] ) ) {

					if ( 'REAL_HOMES_property_id' === $value['key'] ) {
						echo '<strong>' . esc_html__( 'Property ID', 'framework' ) . ':</strong> ' . esc_html( $value['value'] ) . $separator;
					}

					if ( 'REAL_HOMES_property_bathrooms' === $value['key'] ) {
						echo '<strong>' . esc_html__( 'Bathrooms', 'framework' ) . ':</strong>' . esc_html( $value['value'] ) . $separator;
					}

					if ( 'REAL_HOMES_property_bedrooms' === $value['key'] ) {
						echo '<strong>' . esc_html__( 'Bedrooms', 'framework' ) . ':</strong>' . esc_html( $value['value'] ) . $separator;
					}

					if ( 'REAL_HOMES_property_garage' === $value['key'] ) {
						echo '<strong>' . esc_html__( 'Garages', 'framework' ) . ':</strong>' . esc_html( $value['value'] ) . $separator;
					}

					if ( 'REAL_HOMES_property_price' === $value['key'] ) {
						echo '<strong>' . esc_html__( 'Price', 'framework' ) . ':</strong>';

						if ( is_array( $value['value'] ) ) {
							echo esc_html( $value['value'][0] ) . ' - ' . esc_attr( $value['value'][1] ) . $separator;
						} else {
							echo esc_html( $value['value'] ) . $separator;
						}
					}

					if ( 'REAL_HOMES_agents' === $value['key'] && is_array( $value['value'] ) ) {
						echo '<strong>' . esc_html__( 'Agent', 'framework' ) . ':</strong>';
						$count = 1;
						foreach ( $value['value'] as $agent_id ) {
							echo ( $count > 1 ) ? ', ' : '';
							echo esc_html( get_the_title( $agent_id ) );
							$count++;
						}

						echo $separator;
					}

					// Additional Fields.
					$additional_fields = get_option( 'inspiry_property_additional_fields' );

					if ( ! empty( $additional_fields['inspiry_additional_fields_list'] ) ) {
						foreach ( $additional_fields['inspiry_additional_fields_list'] as $field ) {
							$field_key = sanitize_key( 'inspiry_' . strtolower( preg_replace( '/\s+/', '_', $field['field_name'] ) ) );

							if ( $value['key'] === $field_key ) {
								echo '<strong>' . esc_html( $field['field_name'] ) . ':</strong>' . esc_html( $value['value'] ) . $separator;
							}
						}
					}
				}
			}
		}
		?>
		</div>
	</div>

	<!-- Actions -->
	<div class="property-actions-wrapper search-actions">
		<a class="preview-search" target="_blank" href="<?php echo esc_url( $search_view_url ); ?>">
			<i class="fas fa-eye"></i>
			<?php esc_html_e( 'View', 'framework' ); ?>
		</a>
		<a class="delete-search" href="#">
			<i class="fas fa-trash"></i>
			<?php esc_html_e( 'Delete', 'framework' ); ?>
		</a>
	</div>
</div>
