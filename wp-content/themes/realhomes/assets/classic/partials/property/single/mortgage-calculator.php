<?php
/**
 * Mortgage Calculator.
 *
 * @since      3.11.2
 * @package    realhomes
 * @subpackage realhomes/classic
 */

$property_rent_status = get_option( 'inspiry_mortgage_calculator_statuses' ); // Get property enabled statuses for the mortgage calculator.
if ( has_term( $property_rent_status, 'property-status', get_the_ID() ) ) { // Display Mortgage Calculator only if current property has enabled status.
	?>
	<div class="rh_property__mc_wrap">
		<?php $section_title = get_option( 'inspiry_mortgage_calculator_title', esc_html__( 'Mortgage Calculator', 'framework' ) ); ?>
		<h4 class="rh_property__heading"><?php echo esc_html( $section_title ); ?></h4>
		<div class="rh_property__mc clearfix">
			<?php
			// Default data for the mortgage calculator.
			$mc_default['terms']       = array_map( 'intval', explode( ',', get_option( 'inspiry_mc_terms', '30,20,15,10,5' ) ) );
			$mc_default['term']        = intval( get_option( 'inspiry_mc_term_default', '10' ) );
			$mc_default['interest']    = floatval( get_option( 'inspiry_mc_interest_default', '3.5' ) );
			$mc_default['downpayment'] = floatval( get_option( 'inspiry_mc_downpayment_default', '20' ) );
			$mc_default['tax']         = intval( get_post_meta( get_the_ID(), 'inspiry_property_tax', true ) );
			$mc_default['fee']         = intval( get_post_meta( get_the_ID(), 'inspiry_additional_fee', true ) );
			$mc_default['price']       = intval( get_post_meta( get_the_ID(), 'REAL_HOMES_property_price', true ) );

			if ( empty( $mc_default['terms'] ) ) {
				$mc_default['terms'] = array( '30', '20', '15', '10' );
			}

			if ( empty( $mc_default['price'] ) ) {
				$mc_default['price'] = intval( get_option( 'inspiry_mc_price_default', '0' ) );

				if ( '' === $mc_default['price'] ) {
					$mc_default['price'] = '0';
				}
			}

			// Currency conversion in case Currency Switcher is enabled.
			if ( function_exists( 'realhomes_currency_switcher_enabled' ) && realhomes_currency_switcher_enabled() ) {
				$base_currency    = realhomes_get_base_currency();
				$current_currency = realhomes_get_current_currency();

				$mc_default['price_converted'] = realhomes_convert_currency( $mc_default['price'], $base_currency, $current_currency );
				$mc_default['tax_converted']   = realhomes_convert_currency( $mc_default['tax'], $base_currency, $current_currency );
				$mc_default['fee_converted']   = realhomes_convert_currency( $mc_default['fee'], $base_currency, $current_currency );

				$currencies_data   = realhomes_get_currencies_data();
				$currency_sign     = $currencies_data[ $current_currency ]['symbol'];
				$currency_position = $currencies_data[ $current_currency ]['position'];
			} else {
				$mc_default['price_converted'] = $mc_default['price'];
				$mc_default['tax_converted']   = $mc_default['tax'];
				$mc_default['fee_converted']   = $mc_default['fee'];
				$currency_sign                 = ere_get_currency_sign();
				$currency_position             = get_option( 'theme_currency_position', 'before' );
			}

			// Fields labels.
			$term_label        = get_option( 'inspiry_mc_term_field_label', esc_html__( 'Term', 'framework' ) );
			$interest_label    = get_option( 'inspiry_mc_interest_field_label', esc_html__( 'Interest', 'framework' ) );
			$price_label       = get_option( 'inspiry_mc_price_field_label', esc_html__( 'Home Price', 'framework' ) );
			$downpayment_label = get_option( 'inspiry_mc_downpayment_field_label', esc_html__( 'Down Payment', 'framework' ) );
			$principle_label   = get_option( 'inspiry_mc_principle_field_label', esc_html__( 'Principle and Interest', 'framework' ) );
			$cost_prefix       = get_option( 'inspiry_mc_cost_prefix', esc_html__( 'per month', 'framework' ) );
			?>
			<!-- Calculator left side -->
			<div class="mc_left_side">

				<!-- Term -->
				<div class="rh_mc_field">
					<label for="mc_term"><?php echo esc_html( $term_label ); ?></label>
					<div class="rh_form__item">
						<select name="mc_term" class="mc_term inspiry_select_picker_trigger show-tick">
							<?php
							foreach ( $mc_default['terms'] as $mc_term ) {
								echo '<option value="' . esc_attr( $mc_term ) . '" ' . selected( $mc_default['term'], $mc_term, false ) . '>' . esc_html( $mc_term ) . ' ' . esc_html__( 'Years Fixed', 'framework' ) . '</option>';
							}
							?>
						</select>
					</div>
				</div>

				<!-- Interest Rate -->
				<div class="rh_mc_field">
					<label for="mc_interest"><?php echo esc_html( $interest_label ); ?></label>
					<div class="rh_form__item">
						<input class="mc_interset" type="text" value="<?php echo esc_attr( $mc_default['interest'] ); ?>%">
						<input class="mc_interset_slider" type="range" min="0" max="10" step="0.1" value="<?php echo esc_attr( $mc_default['interest'] ); ?>">
					</div>
				</div>

				<!-- Home Price -->
				<div class="rh_mc_field">
					<label for="mc_home_price"><?php echo esc_html( $price_label ); ?></label>
					<div class="rh_form__item">
						<input class="mc_home_price" type="text" value="<?php echo esc_html( $mc_default['price_converted'] ); ?>">
						<?php
						$price_slider_max = esc_html( $mc_default['price_converted'] * 3 );
						if ( 200000 > $price_slider_max ) {
							$price_slider_max = 200000;
						}
						?>
						<input class="mc_home_price_slider" type="range" min="100000" max="<?php echo esc_html( $price_slider_max ); ?>" step="1" value="<?php echo esc_html( $mc_default['price_converted'] ); ?>">
						<input type="hidden" class="mc_currency_sign" value="<?php echo esc_attr( $currency_sign ); ?>">
						<input class="mc_currency_sign" type="hidden" value="<?php echo esc_attr( $currency_sign ); ?>">
						<input class="mc_sign_position" type="hidden" value="<?php echo esc_attr( $currency_position ); ?>">
					</div>
				</div>

				<!-- Down Payment -->
				<div class="rh_mc_field">
					<label for="mc_downpayment"><?php echo esc_html( $downpayment_label ); ?></label>
					<div class="rh_form__item">
						<input class="mc_downpayment" type="text" value="<?php echo esc_html( ( $mc_default['price_converted'] * $mc_default['downpayment'] ) / 100 ); ?>">
						<input class="mc_downpayment_percent" type="text" value="<?php echo esc_html( $mc_default['downpayment'] ); ?>%">
						<input class="mc_downpayment_slider" type="range" min="0" max="100" step="1" value="<?php echo esc_html( $mc_default['downpayment'] ); ?>">
					</div>
				</div>

			</div><!-- End of the left side -->

			<!-- Calculator right side -->
			<?php $graph_type = get_option( 'inspiry_mc_graph_type', 'circle' ); ?>
			<div class="mc_right_side <?php echo 'graph_' . esc_attr( $graph_type ); ?>">
				<?php
				$tax_field_display = get_option( 'inspiry_mc_first_field_display', 'true' );
				$hoa_field_display = get_option( 'inspiry_mc_second_field_display', 'true' );

				if ( 'true' !== $tax_field_display ) {
					$mc_default['tax_converted'] = '0';
					$mc_default['tax']           = '0';
				} else {
					$tax_field_label = get_option( 'inspiry_mc_first_field_title', esc_html__( 'Property Taxes', 'framework' ) );
				}

				if ( 'true' !== $hoa_field_display ) {
					$mc_default['fee_converted'] = '0';
					$mc_default['fee']           = '0';
				} else {
					$hoa_field_label = get_option( 'inspiry_mc_second_field_title', esc_html__( 'Additional Fee', 'framework' ) );
				}

				$graph_type = get_option( 'inspiry_mc_graph_type', 'circle' );
				if ( 'circle' === $graph_type ) {
					?>
					<div class="mc_cost_graph_circle">
						<svg class="mc_graph_svg" width="182" height="182" viewPort="0 0 100 100">
							<circle r="81" cx="91" cy="91" fill="transparent" stroke-dasharray="508.938" stroke-dashoffset="0"></circle>
							<circle class="mc_graph_hoa" r="81" cx="91" cy="91" fill="transparent" stroke-dasharray="508.938" stroke-dashoffset="0"></circle>
							<circle class="mc_graph_tax" r="81" cx="91" cy="91" fill="transparent" stroke-dasharray="508.938" stroke-dashoffset="0"></circle>
							<circle class="mc_graph_interest" r="81" cx="91" cy="91" fill="transparent" stroke-dasharray="508.938" stroke-dashoffset="0"></circle>
						</svg>
						<div class="mc_cost_over_graph" data-cost-prefix=" <?php echo esc_html( $cost_prefix ); ?>"></div>
					</div>
					<div class="mc_term_interest"><span class="mc_term_value"><?php echo esc_html( $mc_default['term'] ); ?></span> <?php esc_html_e( 'Years Fixed', 'framework' ); ?>, <span class="mc_interest_value"><?php echo esc_attr( $mc_default['interest'] ); ?></span><span>%</span> <?php echo esc_html( $interest_label ); ?></div>
					<?php
				} else {
					?>
					<div class="mc_cost_total"><span></span> <?php echo esc_html( $cost_prefix ); ?></div>
					<div class="mc_term_interest"><span class="mc_term_value"><?php echo esc_html( $mc_default['term'] ); ?></span> <?php esc_html_e( 'Years Fixed', 'framework' ); ?>, <span class="mc_interest_value"><?php echo esc_attr( $mc_default['interest'] ); ?></span><span>%</span> <?php echo esc_html( $interest_label ); ?></div>
					<div class="mc_cost_graph">
						<ul class="clearfix">
							<li class="mc_graph_interest"><span></span></li>
							<li class="mc_graph_tax"><span></span></li>
							<li class="mc_graph_hoa"><span></span></li>
						</ul>
					</div>
					<?php
				}
				?>

				<div class="mc_cost">
					<ul>
						<li class="mc_cost_interest"><?php echo esc_html( $principle_label ); ?> <span></span></li>
						<?php
						if ( ! empty( $mc_default['tax'] ) ) {
							?>
							<li class="mc_cost_tax"><?php echo esc_html( $tax_field_label ); ?> <span><?php echo esc_html( ere_format_amount( $mc_default['tax'] ) ); ?></span></li>
							<?php
						}

						if ( ! empty( $mc_default['fee'] ) ) {
							?>
							<li class="mc_cost_hoa"><?php echo esc_html( $hoa_field_label ); ?> <span><?php echo esc_html( ere_format_amount( $mc_default['fee'] ) ); ?></span></li>
							<?php
						}
						?>
						<input class="mc_cost_tax_value" type="hidden" value="<?php echo esc_html( $mc_default['tax_converted'] ); ?>">
						<input class="mc_cost_hoa_value" type="hidden" value="<?php echo esc_html( $mc_default['fee_converted'] ); ?>">
					</ul>
				</div>

			</div><!-- End of the right side -->

		</div>
	</div>
	<?php
}
?>
