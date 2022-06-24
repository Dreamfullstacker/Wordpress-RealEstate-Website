<?php
/**
 * Property Guests Accommodation Section.
 *
 * @since 3.15.0
 * @package realhomes/modern/property
 */

$accommodation_display = get_option( 'inspiry_guests_accommodation_display', 'true' );

if ( inspiry_is_rvr_enabled() && 'true' === $accommodation_display ) {

	$section_heading = get_option( 'inspiry_guests_accommodation_heading', esc_html__( 'Guests Accommodation', 'framework' ) );
	$beds_details = get_post_meta( get_the_ID(), 'rvr_accommodation', true );

	if ( ! empty( $beds_details ) && is_array( $beds_details ) ) {
		?>
		<div class="rvr_guests_accommodation_wrap single-property-section">
			<div class="container">
				<h4 class="rh_property__heading"><?php echo esc_html( $section_heading ); ?></h4>
				<div class="rvr_guests_accommodation">
					<ul>
						<?php
						foreach ( $beds_details as $bed_detail ) {
							if ( ! empty( $bed_detail['room_type'] ) && ! empty( $bed_detail['bed_type'] ) && ! empty( $bed_detail['beds_number'] ) && ! empty( $bed_detail['guests_number'] ) ) {
								?><li><i class="fas fa-bed"></i><strong><?php echo esc_html( $bed_detail['room_type'] ); ?>:</strong> <?php echo intval( $bed_detail['beds_number'] ) . ' ' . esc_html( $bed_detail['bed_type'] ) . ' <i class="guests-info">(' . intval( $bed_detail['guests_number'] ) . ' ' . esc_html__( 'guests', 'framework' ) . ')</i>'; ?></li><?php
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}
}
?>
