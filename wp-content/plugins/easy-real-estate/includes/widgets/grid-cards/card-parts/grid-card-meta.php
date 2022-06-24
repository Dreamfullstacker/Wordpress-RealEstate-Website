<?php
$default = array('bedrooms','bathrooms','area');
$inspiry_meta_selection = get_option( 'inspiry_property_card_meta',$default );
$inspiry_meta_selection = array_filter( $inspiry_meta_selection );


$rhea_add_meta_select = array();



$settings_to_keys = array(
	'bedrooms'   => array(
		'label'   => get_option( 'inspiry_bedrooms_field_label' ) ? esc_html( get_option( 'inspiry_bedrooms_field_label' ) ) : esc_html__( 'Bedrooms', 'easy-real-estate' ),
		'key'     => 'REAL_HOMES_property_bedrooms',
		'icon'    => 'icon-bed',
		'postfix' => ''
	),
	'bathrooms'  => array(
		'label'   => get_option( 'inspiry_bathrooms_field_label' ) ? esc_html( get_option( 'inspiry_bathrooms_field_label' ) ) : esc_html__( 'Bathrooms', 'easy-real-estate' ),
		'key'     => 'REAL_HOMES_property_bathrooms',
		'icon'    => 'icon-shower',
		'postfix' => ''
	),
	'area'       => array(
		'label'   => get_option( 'inspiry_area_field_label' ) ? esc_html( get_option( 'inspiry_area_field_label' ) ) : esc_html__( 'Area', 'easy-real-estate' ),
		'key'     => 'REAL_HOMES_property_size',
		'icon'    => 'icon-area',
		'postfix' => 'REAL_HOMES_property_size_postfix'
	),
	'garage'     => array(
		'label'   => get_option( 'inspiry_garages_field_label' ) ? esc_html( get_option( 'inspiry_garages_field_label' ) ) : esc_html__( 'Garage', 'easy-real-estate' ),
		'key'     => 'REAL_HOMES_property_garage',
		'icon'    => 'icon-garage',
		'postfix' => ''
	),
	'year-built' => array(
		'label'   => get_option( 'inspiry_year_built_field_label' ) ? esc_html( get_option( 'inspiry_year_built_field_label' ) ) : esc_html__( 'Year', 'easy-real-estate' ),
		'key'     => 'REAL_HOMES_property_year_built',
		'icon'    => 'icon-calendar',
		'postfix' => ''
	),
	'lot-size'   => array(
		'label'   => get_option( 'inspiry_lot_size_field_label' ) ? esc_html( get_option( 'inspiry_lot_size_field_label' ) ) : esc_html__( 'Lot Size', 'easy-real-estate' ),
		'key'     => 'REAL_HOMES_property_lot_size',
		'icon'    => 'icon-lot',
		'postfix' => 'REAL_HOMES_property_lot_size_postfix'
	),


);

if ( inspiry_is_rvr_enabled() ) {
	$rvr_meta = array(
		'guests'   => array(
			'label'   => get_option( 'inspiry_rvr_guests_field_label' ) ? esc_html( get_option( 'inspiry_rvr_guests_field_label' ) ) : esc_html__( 'Guests', 'easy-real-estate' ),
			'key'     => 'rvr_guests_capacity',
			'icon'    => 'guests-icons',
			'postfix' => ''
		),
		'min-stay' => array(
			'label'   => get_option( 'inspiry_rvr_min_stay_label' ) ? esc_html( get_option( 'inspiry_rvr_min_stay_label' ) ) : esc_html__( 'Min Stay', 'easy-real-estate' ),
			'key'     => 'rvr_min_stay',
			'icon'    => 'icon-min-stay',
			'postfix' => ''
		),
	);

	$settings_to_keys = array_merge( $settings_to_keys, $rvr_meta );

}


if ( ! empty( $inspiry_meta_selection ) && is_array( $inspiry_meta_selection ) ) {

	$inspiry_meta_selection_flip = array_flip( $inspiry_meta_selection );

	$array_replaced = array_intersect_key( array_replace( $inspiry_meta_selection_flip, $settings_to_keys ), $inspiry_meta_selection_flip );
	?>
    <div class="rh_prop_card_meta_theme_stylish">
		<?php
		$count = 0;
		foreach ( $array_replaced as $meta ) {

			if ( ! empty( $meta ) && is_array( $meta ) ) {
				$post_meta = get_post_meta( get_the_ID(), $meta['key'], true );
				ere_stylish_meta(
					$meta['label'],
					$meta['key'],
					$meta['icon'],
					$meta['postfix']
				);

				$count ++;
			}
		}
		?>
    </div>
	<?php
}

?>




