<?php
/**
 * Property meta of single property template.
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;
$property_size       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix        = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$lot_size            = get_post_meta( get_the_ID(), 'REAL_HOMES_property_lot_size', true );
$lot_size_postfix    = get_post_meta( get_the_ID(), 'REAL_HOMES_property_lot_size_postfix', true );
$property_bedrooms   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_garage     = get_post_meta( get_the_ID(), 'REAL_HOMES_property_garage', true );
$property_year_built = get_post_meta( get_the_ID(), 'REAL_HOMES_property_year_built', true );

// get property custom meta
// todo: above all individual meta fields should be used from $post_meta_data variable
$post_meta_data = get_post_custom( get_the_ID() );


?>

<div class="rh_property__row rh_property__meta_wrap">



	<?php if ( ! empty( $property_bedrooms ) ) : ?>
        <div class="rh_property__meta prop_bedrooms">
            <span class="rh_meta_titles">
				<?php
				$bedrooms_label = get_option( 'inspiry_bedrooms_field_label' );
				echo ( empty ( $bedrooms_label ) ) ? esc_html__( 'Bedrooms', 'framework' ) : esc_html( $bedrooms_label );
				?>
            </span>
            <div>
				<?php inspiry_safe_include_svg( '/images/icons/icon-bed.svg' ); ?>
                <span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
            </div>
        </div>
        <!-- /.rh_property__meta -->
	<?php endif; ?>

	<?php if ( ! empty( $property_bathrooms ) ) : ?>
        <div class="rh_property__meta prop_bathrooms">
            <span class="rh_meta_titles">
				<?php
				$bathrooms_label = get_option( 'inspiry_bathrooms_field_label' );
				echo ( empty ( $bathrooms_label ) ) ? esc_html__( 'Bathrooms', 'framework' ) : esc_html( $bathrooms_label );
				?>
            </span>
            <div>
				<?php inspiry_safe_include_svg( '/images/icons/icon-shower.svg' ); ?>
                <span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
            </div>
        </div>
        <!-- /.rh_property__meta -->
	<?php endif; ?>

	<?php if ( ! empty( $property_garage ) ) : ?>
        <div class="rh_property__meta prop_garages">
            <span class="rh_meta_titles">
				<?php
				$garages_label = get_option( 'inspiry_garages_field_label' );
				echo ( empty ( $garages_label ) ) ? esc_html__( 'Garage', 'framework' ) : esc_html( $garages_label );
				?>
            </span>
            <div>
				<?php inspiry_safe_include_svg( '/images/icons/icon-garage.svg' ); ?>
                <span class="figure">
					<?php echo esc_html( $property_garage ); ?>
				</span>
            </div>
        </div>
        <!-- /.rh_property__meta -->
	<?php endif; ?>


	<?php
	/**
	 * Display RVR related property metadata if it's enabled.
	 */
	if ( inspiry_is_rvr_enabled() ) {


		if ( ! empty( $post_meta_data['rvr_guests_capacity'][0] ) ) : ?>
            <div class="rh_property__meta rvr_guest_capacity">
                <span class="rh_meta_titles">
                    <?php
                    $inspiry_rvr_guests_field_label = get_option('inspiry_rvr_guests_field_label');
                    if(!empty($inspiry_rvr_guests_field_label)){
	                    echo esc_html($inspiry_rvr_guests_field_label);
                    }else{
	                    esc_html_e( 'Capacity', 'framework' );
                    }
                    ?>
                </span>
                <div>
					<?php
					inspiry_safe_include_svg('images/guests-icons.svg','/common/');
                    ?>
                    <span class="figure"><?php echo esc_html( $post_meta_data['rvr_guests_capacity'][0] ); ?></span>
                </div>
            </div>
            <!-- /.rh_property__meta -->
		<?php endif;

		// minimum stay
		if ( ! empty( $post_meta_data['rvr_min_stay'][0] ) ) : ?>
            <div class="rh_property__meta rvr_min_stay">
                <span class="rh_meta_titles">
                    <?php
                    $inspiry_rvr_min_stay_label = get_option( 'inspiry_rvr_min_stay_label' );
                    if ( ! empty( $inspiry_rvr_min_stay_label ) ) {
	                    echo esc_html( $inspiry_rvr_min_stay_label );
                    } else {
	                    esc_html_e( 'Min Stay', 'framework' );
                    }
                    ?>
                </span>
                <div>
					<?php inspiry_safe_include_svg( '/images/icons/icon-min-stay.svg' ); ?>
                    <span class="figure"><?php echo esc_html( $post_meta_data['rvr_min_stay'][0] ); ?></span>
                </div>
            </div>
            <!-- /.rh_property__meta -->
		<?php endif;

		// max guests capacity

	}
	?>


	<?php if ( ! empty( $property_year_built ) ) : ?>
        <div class="rh_property__meta prop_year_built">
            <span class="rh_meta_titles">
				<?php
				$year_built_label = get_option( 'inspiry_year_built_field_label' );
				echo ( empty ( $year_built_label ) ) ? esc_html__( 'Year Built', 'framework' ) : esc_html( $year_built_label );
				?>
            </span>
            <div>
				<?php inspiry_safe_include_svg( '/images/icons/icon-calendar.svg' ); ?>
                <span class="figure">
					<?php echo esc_html( $property_year_built ); ?>
				</span>
            </div>
        </div>
        <!-- /.rh_property__meta -->
	<?php endif; ?>


	<?php if ( ! empty( $property_size ) ) : ?>
        <div class="rh_property__meta prop_area">
            <span class="rh_meta_titles">
				<?php
				$area_label = get_option( 'inspiry_area_field_label' );
				echo ( empty ( $area_label ) ) ? esc_html__( 'Area', 'framework' ) : esc_html( $area_label );
				?>
            </span>
            <div>
				<?php inspiry_safe_include_svg( '/images/icons/icon-area.svg' ); ?>
                <span class="figure">
					<?php echo esc_html( $property_size ); ?>
				</span>
				<?php if ( ! empty( $size_postfix ) ) : ?>
                    <span class="label">
						<?php echo esc_html( $size_postfix ); ?>
					</span>
				<?php endif; ?>
            </div>
        </div>
        <!-- /.rh_property__meta -->
	<?php endif; ?>


	<?php if ( ! empty( $lot_size ) ) : ?>
        <div class="rh_property__meta prop_lot_size">
            <span class="rh_meta_titles">
				<?php
				$lot_size_label = get_option( 'inspiry_lot_size_field_label' );
				echo ( empty ( $lot_size_label ) ) ? esc_html__( 'Lot Size', 'framework' ) : esc_html( $lot_size_label );
				?>
            </span>
            <div>
				<?php inspiry_safe_include_svg( '/images/icons/icon-lot.svg' ); ?>
                <span class="figure">
					<?php echo esc_html( $lot_size ); ?>
				</span>
				<?php if ( ! empty( $lot_size_postfix ) ) : ?>
                    <span class="label">
						<?php echo esc_html( $lot_size_postfix ); ?>
					</span>
				<?php endif; ?>
            </div>
        </div>
        <!-- /.rh_property__meta -->
	<?php endif;


	/**
	 * This hook can be used to display more property meta fields
	 */
	do_action( 'inspiry_additional_property_meta_fields', get_the_ID() );

	/**
	 * Custom property fields
	 */
	if ( is_singular( 'property' ) ) {

		$post_meta_data = get_post_custom( get_the_ID() );
		$custom_fields  = apply_filters(
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
						?>
                        <div class="rh_property__meta <?php echo esc_attr( $meta_key ); ?>">
                            <span class="rh_meta_titles"><?php echo esc_html( $field['name'] ); ?></span>
                            <div>
								<?php
								if ( file_exists( $icons_dir . $field['icon'] . '.png' ) ) {

									$data_rjs = ( file_exists( $icons_dir . $field['icon'] . '@2x.png' ) ) ? '2' : '';

									echo '<img src="' . esc_url( $icons_uri . $field['icon'] ) . '.png" alt="icon" data-rjs="' . esc_attr( $data_rjs ) . '">';
								}
								?>

                                <span class="figure">
									<?php echo esc_html( $post_meta_data[ $meta_key ][0] ); ?>
								</span>
								<?php if ( ! empty( $field_label ) ) : ?>
                                    <span class="label">
										<?php echo esc_html( $field_label ); ?>
									</span>
								<?php endif; ?>
                            </div>
                        </div>
                        <!-- /.rh_property__meta -->
						<?php
					}
				}
			}
		}
	}
	?>

</div>
<!-- /.rh_property__row rh_property__meta -->
