<?php
/**
 * Realhomes - Mortgage Calculator Widget.
 *
 * @since      3.11.1
 * @package    easy-realestate
 * @subpackage easy-real-estate/widgets
 */

if ( ! class_exists( 'Realhomes_Mortgage_Calculator_Widget' ) ) {
	/**
	 * Realhomes - Mortgage Calculator Widget Class
	 *
	 * @since 3.11.1
	 */
	class Realhomes_Mortgage_Calculator_Widget extends WP_Widget {

		/**
		 * Constuctor - Set widget ID, title and description.
		 */
		public function __construct() {
			parent::__construct(
				'realhomes_mortgage_calculator', // Base ID of the widget.
				esc_html__( 'Realhomes - Mortgage Calculator', 'easy-real-estate' ), // Widget name will appear in UI.
				array( 'description' => esc_html__( 'This widget display Mortgage Calculator.', 'easy-real-estate' ) ) // Widget description.
			);
		}

		/**
		 * Creating widget front-end side.
		 *
		 * @param array $args     Widget wrapping tags.
		 * @param array $instance Widget fields contents.
		 */
		public function widget( $args, $instance ) {

			$property_rent_status = get_option( 'inspiry_mortgage_calculator_statuses' ); // Get property enabled statuses for the mortgage calculator.
			if ( has_term( $property_rent_status, 'property-status', get_the_ID() ) ) { // Display Mortgage Calculator only if current property has enabled status.

				if ( isset( $instance['title'] ) ) {
					$title = apply_filters( 'widget_title', $instance['title'] );
				}
				// before and after widget arguments are defined by themes.
				echo $args['before_widget'];

				if ( ! empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];	
				}
				?>
				<div class="rh_property__mc_wrap">
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
						$term_label        = get_option( 'inspiry_mc_term_field_label', esc_html__( 'Term', 'easy-real-estate' ) );
						$interest_label    = get_option( 'inspiry_mc_interest_field_label', esc_html__( 'Interest', 'easy-real-estate' ) );
						$price_label       = get_option( 'inspiry_mc_price_field_label', esc_html__( 'Home Price', 'easy-real-estate' ) );
						$downpayment_label = get_option( 'inspiry_mc_downpayment_field_label', esc_html__( 'Down Payment', 'easy-real-estate' ) );
						$principle_label   = get_option( 'inspiry_mc_principle_field_label', esc_html__( 'Principle and Interest', 'easy-real-estate' ) );
						$cost_prefix       = get_option( 'inspiry_mc_cost_prefix', esc_html__( 'per month', 'easy-real-estate' ) );
						?>
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
								$tax_field_label = get_option( 'inspiry_mc_first_field_title', esc_html__( 'Property Taxes', 'easy-real-estate' ) );
							}

							if ( 'true' !== $hoa_field_display ) {
								$mc_default['fee_converted'] = '0';
								$mc_default['fee']           = '0';
							} else {
								$hoa_field_label = get_option( 'inspiry_mc_second_field_title', esc_html__( 'Additional Fee', 'easy-real-estate' ) );
							}

							$graph_type = get_option( 'inspiry_mc_graph_type', 'circle' );
							if ( 'circle' === $graph_type ) {
								?>
								<div class="mc_cost_graph_circle">
								<?php
								if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
									?>
									<svg class="mc_graph_svg" width="162" height="162" viewPort="0 0 100 100">
										<circle r="71" cx="81" cy="81" fill="transparent" stroke-dasharray="446.106" stroke-dashoffset="0"></circle>
										<circle class="mc_graph_hoa" r="71" cx="81" cy="81" fill="transparent" stroke-dasharray="446.106" stroke-dashoffset="0"></circle>
										<circle class="mc_graph_tax" r="71" cx="81" cy="81" fill="transparent" stroke-dasharray="446.106" stroke-dashoffset="0"></circle>
										<circle class="mc_graph_interest" r="71" cx="81" cy="81" fill="transparent" stroke-dasharray="446.106" stroke-dashoffset="0"></circle>
									</svg>
									<?php
								} else {
									?>
									<svg class="mc_graph_svg" width="200" height="200" viewPort="0 0 100 100">
										<circle r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
										<circle class="mc_graph_hoa" r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
										<circle class="mc_graph_tax" r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
										<circle class="mc_graph_interest" r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
									</svg>
									<?php
								}
								?>
								<div class="mc_cost_over_graph" data-cost-prefix=" <?php echo esc_html( $cost_prefix ); ?>"></div>
							</div>
							<div class="mc_term_interest"><span class="mc_term_value"><?php echo esc_html( $mc_default['term'] ); ?></span> <?php esc_html_e( 'Years Fixed', 'easy-real-estate' ); ?>, <span class="mc_interest_value"><?php echo esc_attr( $mc_default['interest'] ); ?></span><span>%</span> <?php echo esc_html( $interest_label ); ?></div>
								<?php
							} else {
								?>
								<div class="mc_cost_total"><span></span> <?php echo esc_html( $cost_prefix ); ?></div>
								<div class="mc_term_interest"><span class="mc_term_value"><?php echo esc_html( $mc_default['term'] ); ?></span> <?php esc_html_e( 'Years Fixed', 'easy-real-estate' ); ?>, <span class="mc_interest_value"><?php echo esc_attr( $mc_default['interest'] ); ?></span><span>%</span> <?php echo esc_html( $interest_label ); ?></div>
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

						<!-- Calculator left side -->
						<div class="mc_left_side">

							<!-- Term -->
							<div class="rh_mc_field">
								<label for="mc_term"><?php echo esc_html( $term_label ); ?></label>
								<div class="rh_form__item">
									<select name="mc_term" class="mc_term inspiry_select_picker_trigger inspiry_bs_default_mod inspiry_bs_green show-tick">
										<?php
										foreach ( $mc_default['terms'] as $mc_term ) {
											echo '<option value="' . esc_attr( $mc_term ) . '" ' . selected( $mc_default['term'], $mc_term, false ) . '>' . esc_html( $mc_term ) . ' ' . esc_html__( 'Years Fixed', 'easy-real-estate' ) . '</option>';
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

					</div><!-- End of rh_property__mc -->
				</div><!-- End of rh_property__mc_wrap -->
				<?php

				echo $args['after_widget'];
			}
		}

		/**
		 * Creating widget backend side.
		 *
		 * @param array $instance Widget fields contents.
		 */
		public function form( $instance ) {
			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];
			} else {
				$title = esc_html__( 'Mortgage Calculator', 'easy-real-estate' );
			}
			// Widget admin form.
			?>
			<p>
				<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'easy-real-estate' ); ?></label> 
				<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php
		}

		/**
		 * Updating widget replacing old instances with new.
		 *
		 * @param array $new_instance New values of the widget fields.
		 * @param array $old_instance Old values of the widget fields.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			return $instance;
		}
	}
}

// TODO: redo it.
function inspiry_load_widget() {
    register_widget( 'Realhomes_Mortgage_Calculator_Widget' );
}
add_action( 'widgets_init', 'inspiry_load_widget' );