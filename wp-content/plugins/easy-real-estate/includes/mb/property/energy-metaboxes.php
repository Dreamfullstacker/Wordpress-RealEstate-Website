<?php
/**
 * Add energy metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function ere_energy_metabox_tab( $property_metabox_tabs ) {
	if ( is_array( $property_metabox_tabs ) ) {
		$property_metabox_tabs['energy-performance'] = array(
			'label' => esc_html__( 'Energy Performance', 'easy-real-estate' ),
			'icon'  => 'dashicons-performance',
		);
	}

	return $property_metabox_tabs;
}

add_filter( 'ere_property_metabox_tabs', 'ere_energy_metabox_tab', 70 );


/**
 * Add energy metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function ere_energy_metabox_fields( $property_metabox_fields ) {

	$energy_classes_data = get_option( 'inspiry_property_energy_classes' );

	if ( empty( $energy_classes_data ) ) {

		$energy_classes = array(
			'none' => esc_html__( 'None', 'easy-real-estate' ),
		);

		$energy_classes_data = ere_epc_default_fields();

		if ( ! empty( $energy_classes_data ) && is_array( $energy_classes_data ) ) {
			foreach ( $energy_classes_data as $energy_class ) {
				$energy_classes[ $energy_class['name'] ] = $energy_class['name'];
			}
		}
	} else {
		$energy_classes = array(
			'none' => esc_html__( 'None', 'easy-real-estate' ),
		);
		foreach ( $energy_classes_data as $class => $data ) {
			$energy_classes[ $data['name'] ] = $data['name'];
		}
	}

	$ere_energy_fields = array(
		array(
			'name'    => esc_html__( 'Energy Class', 'easy-real-estate' ),
			'id'      => "REAL_HOMES_energy_class",
			'type'    => 'select',
			'std'     => 'none',
			'options' => $energy_classes,
			'columns' => 6,
			'tab'     => 'energy-performance',
		),
		array(
			'id'      => "REAL_HOMES_energy_performance",
			'name'    => esc_html__( 'Energy Performance', 'easy-real-estate' ),
			'desc'    => esc_html__( 'Example: 100 kWh/m²a', 'easy-real-estate' ),
			'type'    => 'text',
			'std'     => '',
			'columns' => 6,
			'tab'     => 'energy-performance',
		),
		array(
			'id'      => "REAL_HOMES_epc_current_rating",
			'name'    => sprintf( esc_html__( '%s Current Rating', 'easy-real-estate' ), '<abbr title="Energy Performance Certificate">EPC</abbr>' ),
			'desc'    => esc_html__( 'Example: 83', 'easy-real-estate' ),
			'type'    => 'text',
			'std'     => '',
			'columns' => 6,
			'tab'     => 'energy-performance',
		),
		array(
			'id'      => "REAL_HOMES_epc_potential_rating",
			'name'    => sprintf( esc_html__( '%s Potential Rating', 'easy-real-estate' ), '<abbr title="Energy Performance Certificate">EPC</abbr>' ),
			'desc'    => esc_html__( 'Example: 94', 'easy-real-estate' ),
			'type'    => 'text',
			'std'     => '',
			'columns' => 6,
			'tab'     => 'energy-performance',
		),
	);

	return array_merge( $property_metabox_fields, $ere_energy_fields );

}

add_filter( 'ere_property_metabox_fields', 'ere_energy_metabox_fields', 70 );
