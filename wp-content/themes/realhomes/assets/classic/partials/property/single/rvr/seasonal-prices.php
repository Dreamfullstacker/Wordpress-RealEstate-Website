<?php
/**
 * Property Seasonal Prices Section.
 *
 * @since 3.15.0
 * @package realhomes/modern/property
 */

$seasonal_prices_display = get_option( 'inspiry_seasonal_prices_display', 'true' );

if ( inspiry_is_rvr_enabled() && 'true' === $seasonal_prices_display ) {

	$seasonal_prices = get_post_meta( get_the_ID(), 'rvr_seasonal_pricing', true );

	if ( ! empty( $seasonal_prices ) ) {
		$section_heading         = get_option( 'inspiry_seasonal_prices_heading', esc_html__( 'Seasonal Prices', 'framework' ) );
		$start_date_column_label = get_option( 'inspiry_sp_start_date_column_label', esc_html__( 'Start Date', 'framework' ) );
		$end_date_column_label   = get_option( 'inspiry_sp_end_date_column_label', esc_html__( 'End Date', 'framework' ) );
		$price_column_label      = get_option( 'inspiry_sp_price_column_label', esc_html__( 'Per Night' ) );
		?>
		<div id="seasonal-prices-wrap">
			<h4 class='title'><?php echo esc_html( $section_heading ); ?></h4>
			<div id="seasonal-prices">
				<table class="rvr_seasonal_prices">
				<tr>
					<th class="sp-start-date-column"><?php echo esc_html( $start_date_column_label ); ?></th>
					<th class="sp-end-date-column"><?php echo esc_html( $end_date_column_label ); ?></th>
					<th class="sp-price-column"><?php echo esc_html( $price_column_label ); ?></th>
				</tr>
				<?php
				foreach ( $seasonal_prices as $season_price ) {
					if ( ! empty( $season_price['rvr_price_start_date'] ) && ! empty( $season_price['rvr_price_start_date'] ) && ! empty( $season_price['rvr_price_start_date'] ) ) {
						?>
						<tr>
							<td><?php echo esc_html( $season_price['rvr_price_start_date'] ); ?></td>
							<td><?php echo esc_html( $season_price['rvr_price_end_date'] ); ?></td>
							<td><?php echo esc_html( ere_format_amount( intval( $season_price['rvr_price_amount'] ) ) ); ?></td>
						</tr>
						<?php
					}
				}
				?>
				</table>
			</div>
		</div>
		<?php
	}
}
?>
