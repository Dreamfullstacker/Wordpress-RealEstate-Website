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
	<div class="rvr_price_details_wrap">
		<h4 class="rh_property__heading"><?php echo esc_html( $section_heading ); ?></h4>
		<div class="rvr_price_details">
			<?php
				$bulk_prices       = get_post_meta( get_the_ID(), 'rvr_bulk_pricing', true );
				$service_charges   = get_post_meta( get_the_ID(), 'rvr_service_charges', true );
				$govt_tax          = get_post_meta( get_the_ID(), 'rvr_govt_tax', true );
				$additional_fees   = get_post_meta( get_the_ID(), 'rvr_additional_fees', true );
				$extra_guest_price = get_post_meta( get_the_ID(), 'rvr_extra_guest_price', true );
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
                                    case 'per_stay':
                                        $fee_info_label = esc_html__( 'per stay', 'framework' );
                                        break;
                                    default:
                                        $fee_info_label = '';
                                }

                                $fee_info = '(' . $fee_info_label . ')';
								?>
								<li><strong><?php echo esc_html( $additional_fee['rvr_fee_label'] ); ?>:</strong><span><?php echo ( ! empty( $fee_info ) ) ? '<i>' . esc_html( $fee_info ) . '</i>' : ''; ?></span><?php echo esc_html( $fee_amount ); ?></li>
								<?php
							}
						}
					}

					if ( ! empty( $extra_guest_price ) ) {
						?>
						<li><strong><?php esc_html_e( 'Extra Guest Price', 'framework' ); ?>:</strong><span><i><?php esc_html_e( '(per night)', 'framework' ); ?></i></span><?php echo ere_format_amount( $extra_guest_price ); ?></li>
						<?php
					}

					if ( ! empty( $service_charges ) ) {
						?>
						<li><strong><?php esc_html_e( 'Service Charges', 'framework' ); ?>:</strong><span><i><?php esc_html_e( '(per stay)', 'framework' ); ?></i></span><?php echo intval( $service_charges ) . '%'; ?></li>
						<?php
					}
					if ( ! empty( $govt_tax ) ) {
						?>
						<li><strong><?php esc_html_e( 'Govt Tax', 'framework' ); ?>:</strong><span><i><?php esc_html_e( '(per stay)', 'framework' ); ?></i></span><?php echo intval( $govt_tax ) . '%'; ?></li>
						<?php
					}

					if ( ! empty( $bulk_prices ) ) {
						?>
						<li class="bulk-pricing-heading"><?php esc_html_e( 'Bulk Prices', 'framework' ); ?></li>
						<?php

						foreach( $bulk_prices as $bulk_price ) {
						    if ( ! empty( $bulk_price['number_of_nights'] ) && ! empty( $bulk_price['price_per_night'] ) ) {
							    ?>
                                <li><strong><?php echo sprintf( esc_html__( 'Price per night (%sdays+)', 'framework' ), $bulk_price['number_of_nights'] ); ?>:</strong><?php echo ere_format_amount( $bulk_price['price_per_night'] ); ?></li>
							    <?php
                            }
						}
					}
				?>
			</ul>
		</div>
	</div>
	<?php
}
?>
