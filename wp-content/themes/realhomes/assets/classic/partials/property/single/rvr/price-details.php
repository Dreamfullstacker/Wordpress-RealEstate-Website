<?php
/**
 * Property Price Details Section.
 *
 * @since 3.15.0
 * @package realhomes/modern/property
 */

$price_details_display = get_option( 'inspiry_price_details_display', 'true' );

if ( inspiry_is_rvr_enabled() && 'true' === $price_details_display ) {

	$section_heading = get_option( 'inspiry_price_details_heading', esc_html__( 'Price Details', 'framework' ) );
	?>
	<div id="price-details-wrap">
		<h4 class="title"><?php echo esc_html( $section_heading ); ?></h4>
		<div id="price-details">
			<?php
				$service_charges = get_post_meta( get_the_ID(), 'rvr_service_charges', true );
				$govt_tax        = get_post_meta( get_the_ID(), 'rvr_govt_tax', true );
				$additional_fees = get_post_meta( get_the_ID(), 'rvr_additional_fees', true );
			?>
			<ul>
				<?php

					if ( ! empty( $additional_fees ) && is_array( $additional_fees ) ) {
						foreach ( $additional_fees as $additional_fee ) {
							if ( ! empty( $additional_fee['rvr_fee_label'] ) && ! empty( $additional_fee['rvr_fee_amount'] ) ) {
	
								if ( 'fixed' === $additional_fee['rvr_fee_type'] ) {
									$fee_amount = ere_format_amount( $additional_fee['rvr_fee_amount'] );
								} else {
									$fee_amount = intval( $additional_fee['rvr_fee_amount'] ) . '%';
								}
	
								$fee_info = '';
								if ( 'per_stay' !== $additional_fee['rvr_fee_calculation'] ) {
	
									switch ( $additional_fee['rvr_fee_calculation'] ) {
										case 'per_night':
											$fee_info_label = esc_html__( 'per night', 'framework' );
											break;
										case 'per_guest':
											$fee_info_label = esc_html__( 'per guest', 'framework' );
											break;
										case 'per_night_guest':
											$fee_info_label = esc_html__( 'per night per guest', 'framework' );
											break;
										default:
											$fee_info_label = '';
									}
									 
	
									$fee_info = '(' . $fee_info_label . ')';
								}
								?>
								<li><strong><?php echo esc_html( $additional_fee['rvr_fee_label'] ); ?>:</strong><span><?php echo ( ! empty( $fee_info ) ) ? '<i>' . esc_html( $fee_info ) . '</i>' : ''; ?></span><?php echo esc_html( $fee_amount ); ?></li>
								<?php
							}
						}
					}

					if ( ! empty( $service_charges ) ) {
						?>
						<li><strong><?php echo esc_html_e( 'Service Charges', 'framework' ); ?>:</strong><?php echo intval( $service_charges ) . '%'; ?></li>
						<?php
					}
					if ( ! empty( $govt_tax ) ) {
						?>
						<li><strong><?php echo esc_html_e( 'Govt Tax', 'framework' ); ?>:</strong><?php echo intval( $govt_tax ) . '%'; ?></li>
						<?php
					}
				?>
			</ul>
		</div>
	</div>
	<?php
}
?>
