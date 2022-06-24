<?php
/**
 * Property meta.
 *
 * @package    realhomes
 * @subpackage classic
 */

$post_meta_data = get_post_custom( get_the_ID() );

if ( is_singular( 'property' ) && ! empty( $post_meta_data['REAL_HOMES_property_id'][0] ) ) {
	$prop_id = $post_meta_data['REAL_HOMES_property_id'][0];
	echo '<span class="property-meta-id" title="' . esc_html__( 'Property ID', 'framework' ) . '">';
	inspiry_safe_include_svg( '/images/icon-id.svg' );
	echo esc_html( $prop_id );
	echo '</span>';
}

if ( ! empty( $post_meta_data['REAL_HOMES_property_size'][0] ) ) {
	$prop_size = $post_meta_data['REAL_HOMES_property_size'][0];
	echo '<span class="property-meta-size" title="' . esc_html__( 'Area Size', 'framework' ) . '">';
	inspiry_safe_include_svg( '/images/icon-size.svg' );
	echo esc_html( $prop_size );
	if ( ! empty( $post_meta_data['REAL_HOMES_property_size_postfix'][0] ) ) {
		$prop_size_postfix = $post_meta_data['REAL_HOMES_property_size_postfix'][0];
		echo '&nbsp;' . esc_html( $prop_size_postfix );
	}
	echo '</span>';
}

if ( ! empty( $post_meta_data['REAL_HOMES_property_bedrooms'][0] ) ) {
	$prop_bedrooms     = floatval( $post_meta_data['REAL_HOMES_property_bedrooms'][0] );
	$bedrooms_label    = ( $prop_bedrooms > 1 ) ? esc_html__( 'Bedrooms', 'framework' ) : esc_html__( 'Bedroom', 'framework' );
	$cs_bedrooms_label = get_option( 'inspiry_bedrooms_field_label' );

	if ( ! empty( $cs_bedrooms_label ) ) {
		$bedrooms_label = $cs_bedrooms_label;
	}

	echo '<span class="property-meta-bedrooms">';
	inspiry_safe_include_svg( '/images/icon-bed.svg' );
	echo esc_html( $prop_bedrooms . '&nbsp;' . $bedrooms_label );
	echo '</span>';
}

if ( ! empty( $post_meta_data['REAL_HOMES_property_bathrooms'][0] ) ) {
	$prop_bathrooms  = floatval( $post_meta_data['REAL_HOMES_property_bathrooms'][0] );
	$bathrooms_label = ( $prop_bathrooms > 1 ) ? esc_html__( 'Bathrooms', 'framework' ) : esc_html__( 'Bathroom', 'framework' );
	$cs_bathrooms_label = get_option( 'inspiry_bathrooms_field_label' );

	if ( ! empty( $cs_bathrooms_label ) ) {
		$bathrooms_label = $cs_bathrooms_label;
	}

	echo '<span class="property-meta-bath">';
	inspiry_safe_include_svg( '/images/icon-bath.svg' );
	echo esc_html( $prop_bathrooms . '&nbsp;' . $bathrooms_label );
	echo '</span>';
}

if ( ! empty( $post_meta_data['REAL_HOMES_property_garage'][0] ) ) {
	$prop_garage  = floatval( $post_meta_data['REAL_HOMES_property_garage'][0] );
	$garage_label = ( $prop_garage > 1 ) ? esc_html__( 'Garages', 'framework' ) : esc_html__( 'Garage', 'framework' );
	$cs_garage_label = get_option( 'inspiry_garages_field_label' );

	if ( ! empty( $cs_garage_label ) ) {
		$garage_label = $cs_garage_label;
	}

	echo '<span class="property-meta-garage">';
	inspiry_safe_include_svg( '/images/icon-garage.svg' );
	echo esc_html( $prop_garage . '&nbsp;' . $garage_label );
	echo '</span>';
}

if ( is_singular( 'property' ) && ! empty( $post_meta_data['REAL_HOMES_property_year_built'][0] ) ) {
	$year_built = intval( $post_meta_data['REAL_HOMES_property_year_built'][0] );
	$year_built_label = esc_html__( 'Year Built', 'framework' );
	$cs_year_built_label = get_option( 'inspiry_year_built_field_label' );

	if ( ! empty( $cs_year_built_label ) ) {
		$year_built_label = $cs_year_built_label;
	}

	echo '<span class="property-meta-year-built">';
	inspiry_safe_include_svg( '/images/icon-calendar.svg' );
	echo esc_html( $year_built . '&nbsp;' . $year_built_label );
	echo '</span>';
}

if ( is_singular( 'property' ) && ! empty( $post_meta_data['REAL_HOMES_property_lot_size'][0] ) ) {
	$lot_size = $post_meta_data['REAL_HOMES_property_lot_size'][0];
	echo '<span class="property-meta-lot-size" title="' . esc_html__( 'Lot Size', 'framework' ) . '">';
	inspiry_safe_include_svg( '/images/icon-lot.svg' );
	echo esc_html( $lot_size );
	if ( ! empty( $post_meta_data['REAL_HOMES_property_lot_size_postfix'][0] ) ) {
		$lot_size_postfix = $post_meta_data['REAL_HOMES_property_lot_size_postfix'][0];
		echo '&nbsp;' . esc_html( $lot_size_postfix );
	}
	echo '</span>';
}

if ( inspiry_is_rvr_enabled() ) {
	// RVR - minimum nights stay
	if ( is_singular( 'property' ) && ! empty( $post_meta_data['rvr_min_stay'][0] ) ) {
		$minimum_stay = $post_meta_data['rvr_min_stay'][0];
		echo '<span class="property-meta-min-stay" title="' . esc_html__( 'Minimum Stay', 'framework' ) . '">';
		inspiry_safe_include_svg( '/images/icon-bed.svg' );
		echo esc_html( $minimum_stay );
		echo '&nbsp;' . esc_html__( 'Nights Minimum Stay', 'framework' );
		echo '</span>';
	}

	// RVR - max number of guests
	if ( is_singular( 'property' ) && ! empty( $post_meta_data['rvr_guests_capacity'][0] ) ) {
		$guests_capacity = $post_meta_data['rvr_guests_capacity'][0];
		echo '<span class="property-meta-guests-capacity" title="' . esc_html__( 'Guests Capacity', 'framework' ) . '">';
		inspiry_safe_include_svg( '/images/icon-lot.svg' );
		echo esc_html( $guests_capacity );
		echo '&nbsp;' . esc_html__( 'Guests Capacity', 'framework' );
		echo '</span>';
	}
}

/**
 * This hook can be used to display more property meta fields
 */
do_action( 'inspiry_additional_property_meta_fields', get_the_ID() );

/**
 * Custom property fields
 */
if ( is_singular( 'property' ) ) {

	/**
	 * Custom property meta via filter
	 */
	$custom_fields = apply_filters(
		'inspiry_property_custom_fields', array(
			array(
				'tab'    => array(),
				'fields' => array(),
			),
		)
	);

	if ( isset( $custom_fields['fields'] ) && ! empty( $custom_fields['fields'] ) ) {

		$prefix    = 'REAL_HOMES_';
		$icons_dir = INSPIRY_THEME_DIR . '/icons/';
		$icons_uri = INSPIRY_DIR_URI . '/icons/';

		foreach ( $custom_fields['fields'] as $field ) {

			if ( isset( $field['display'] ) && true === $field['display'] ) {

				$meta_key = $prefix . inspiry_backend_safe_string( $field['id'] );

				if ( isset( $post_meta_data[ $meta_key ] ) && ! empty( $post_meta_data[ $meta_key ][0] ) ) {

					$field_label = ( ! empty( $field['postfix'] ) ) ? $field['postfix'] : '';

					echo '<span>';
					if ( file_exists( $icons_dir . $field['icon'] . '.png' ) ) {

						$data_rjs = ( file_exists( $icons_dir . $field['icon'] . '@2x.png' ) ) ? '2' : '';

						echo '<img src="' . esc_url( $icons_uri . $field['icon'] ) . '.png" alt="icon" data-rjs="' . esc_attr( $data_rjs ) . '">';
					}
					echo esc_html( $post_meta_data[ $meta_key ][0] . '&nbsp;' . $field_label );
					echo '</span>';
				}
			}
		}
	}
}

