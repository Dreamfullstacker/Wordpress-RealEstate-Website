<?php
/**
 * Property location surroundings of single property.
 *
 * @package    realhomes
 * @subpackage modern
 */

/* Property Location Surroundings */
$location_surroundings = get_post_meta( get_the_ID(), 'rvr_surroundings', true );
if ( ! empty( $location_surroundings ) ) {
	?>
    <div class="rh_property__features_wrap rh_rvr_property_surroundings">
        <h4 class="rh_property__heading"><?php
			$rvr_settings = get_option( 'rvr_settings' );
			echo ! empty( $rvr_settings['rvr_surroundings_label'] ) ? esc_html( $rvr_settings['rvr_surroundings_label'] ) : esc_html__( 'Surroundings', 'framework' );
			?>
        </h4>
        <ul class="rh_property__features arrow-bullet-list no-link-list">
			<?php
			foreach ( $location_surroundings as $surrounding ) {

				?>
                <li class="rh_property__feature">
					<?php
					if ( isset( $surrounding['rvr_surrounding_point'] ) && ! empty( $surrounding['rvr_surrounding_point'] ) ) {
						?>
                        <span class="rh_done_icon"><i class="rvr_fa_icon fas fa-map-marker-alt"></i>
							<?php
							?>
                    </span>
						<?php
						echo '<h5>' . esc_html( $surrounding['rvr_surrounding_point'] ) . '</h5> ';
					}

					if ( isset( $surrounding['rvr_surrounding_point_distance'] ) && ! empty( $surrounding['rvr_surrounding_point_distance'] ) ) {
						?>

                        <span class="rh_POI_distance">

						<?php echo esc_html( $surrounding['rvr_surrounding_point_distance'] ); ?>
                            </span>

						<?php
					}
					?>
                </li>
				<?php
			}
			?>
        </ul>
    </div>
	<?php
}