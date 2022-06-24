<?php
/**
 * Widget: RVR Booking Widget
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/assets
 */

if ( ! class_exists( 'RVR_Booking_Widget' ) ) {

	class RVR_Booking_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array(
				'classname'   => 'RVR_Booking_Widget',
				'description' => esc_html__( 'This widget displays rental booking form and can be used only on property single page.', 'realhomes-vacation-rentals' ),
			);
			parent::__construct( 'rvr_booking_widget', esc_html__( 'RealHomes - Vacation Rentals Booking Widget', 'realhomes-vacation-rentals' ), $widget_ops );
		}

		public function widget( $args, $instance ) {

			$rvr_settings = get_option( 'rvr_settings' );

			extract( $args );
			$title                      = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : esc_html__( 'Request a Booking', 'realhomes-vacation-rentals' );
			$name_field_text            = ( ! empty( $instance['name_field_text'] ) ) ? $instance['name_field_text'] : esc_html__( 'Name', 'realhomes-vacation-rentals' );
			$name_field_placeholder     = ( ! empty( $instance['name_field_placeholder'] ) ) ? $instance['name_field_placeholder'] : esc_html__( 'Enter Name', 'realhomes-vacation-rentals' );
			$email_field_text           = ( ! empty( $instance['email_field_text'] ) ) ? $instance['email_field_text'] : esc_html__( 'Email', 'realhomes-vacation-rentals' );
			$email_field_placeholder    = ( ! empty( $instance['email_field_placeholder'] ) ) ? $instance['email_field_placeholder'] : esc_html__( 'Enter Email', 'realhomes-vacation-rentals' );
			$email_required_text        = ( ! empty( $instance['email_required_text'] ) ) ? $instance['email_required_text'] : esc_html__( 'Email field is required.', 'realhomes-vacation-rentals' );
			$phone_field_text           = ( ! empty( $instance['phone_field_text'] ) ) ? $instance['phone_field_text'] : esc_html__( 'Phone', 'realhomes-vacation-rentals' );
			$phone_placeholder_text     = ( ! empty( $instance['phone_placeholder_text'] ) ) ? $instance['phone_placeholder_text'] : esc_html__( '1-800-123-4567', 'realhomes-vacation-rentals' );
			$check_in_field_text        = ( ! empty( $instance['check_in_field_text'] ) ) ? $instance['check_in_field_text'] : esc_html__( 'Check In', 'realhomes-vacation-rentals' );
			$check_in_placeholder_text  = ( ! empty( $instance['check_in_placeholder_text'] ) ) ? $instance['check_in_placeholder_text'] : esc_html__( 'yyyy-mm-dd', 'realhomes-vacation-rentals' );
			$check_in_required_text     = ( ! empty( $instance['check_in_required_text'] ) ) ? $instance['check_in_required_text'] : esc_html__( 'Check-In field is required.', 'realhomes-vacation-rentals' );
			$check_out_field_text       = ( ! empty( $instance['check_out_field_text'] ) ) ? $instance['check_out_field_text'] : esc_html__( 'Check Out', 'realhomes-vacation-rentals' );
			$check_out_placeholder_text = ( ! empty( $instance['check_out_placeholder_text'] ) ) ? $instance['check_out_placeholder_text'] : esc_html__( 'yyyy-mm-dd', 'realhomes-vacation-rentals' );
			$check_out_required_text    = ( ! empty( $instance['check_out_required_text'] ) ) ? $instance['check_out_required_text'] : esc_html__( 'Check-Out field is required.', 'realhomes-vacation-rentals' );
			$adults_field_text          = ( ! empty( $instance['adults_field_text'] ) ) ? $instance['adults_field_text'] : esc_html__( 'Adults', 'realhomes-vacation-rentals' );
			$children_field_text        = ( ! empty( $instance['children_field_text'] ) ) ? $instance['children_field_text'] : esc_html__( 'Children', 'realhomes-vacation-rentals' );
			$staying_nights             = ( ! empty( $instance['staying_nights'] ) ) ? $instance['staying_nights'] : esc_html__( ' Staying Nights', 'realhomes-vacation-rentals' );
			$price_for_staying          = ( ! empty( $instance['price_for_staying'] ) ) ? $instance['price_for_staying'] : esc_html__( 'Price For Staying Nights', 'realhomes-vacation-rentals' );
			$services_charges           = ( ! empty( $instance['services_charges'] ) ) ? $instance['services_charges'] : esc_html__( 'Services Charges', 'realhomes-vacation-rentals' );
			$subtotal                   = ( ! empty( $instance['subtotal'] ) ) ? $instance['subtotal'] : esc_html__( 'Subtotal', 'realhomes-vacation-rentals' );
			$government_taxes           = ( ! empty( $instance['government_taxes'] ) ) ? $instance['government_taxes'] : esc_html__( 'Government Taxes', 'realhomes-vacation-rentals' );
			$total_price                = ( ! empty( $instance['total_price'] ) ) ? $instance['total_price'] : esc_html__( 'Total Price', 'realhomes-vacation-rentals' );
			$payable                    = ( ! empty( $instance['payable'] ) ) ? $instance['payable'] : esc_html__( 'Payable', 'realhomes-vacation-rentals' );
			$show_details               = ( ! empty( $instance['show_details'] ) ) ? $instance['show_details'] : esc_html__( 'Show Details', 'realhomes-vacation-rentals' );
			$hide_details               = ( ! empty( $instance['hide_details'] ) ) ? $instance['hide_details'] : esc_html__( 'Hide Details', 'realhomes-vacation-rentals' );
			$rvr_or                     = ( ! empty( $instance['rvr_or'] ) ) ? $instance['rvr_or'] : esc_html__( 'OR', 'realhomes-vacation-rentals' );
			$rvr_call_now               = ( ! empty( $instance['rvr_call_now'] ) ) ? $instance['rvr_call_now'] : esc_html__( 'Call Now', 'realhomes-vacation-rentals' );

			if ( rvr_is_wc_payment_enabled() && rvr_is_instant_booking( get_the_ID() ) ) {
				$button_text = ( ! empty( $rvr_settings['rvr_instant_booking_button_label'] ) ) ? $rvr_settings['rvr_instant_booking_button_label'] : esc_html__( 'Instant Booking', 'realhomes-vacation-rentals' );
			} else {
				$button_text = ( ! empty( $instance['button_text'] ) ) ? $instance['button_text'] : esc_html__( 'Book Now', 'realhomes-vacation-rentals' );
			}

			/**
			 * Check for the translation.
			 */
			$name_field_text            = apply_filters( 'wpml_translate_single_string', $name_field_text, 'Widgets', 'RVR - Name Label' );
			$name_field_placeholder     = apply_filters( 'wpml_translate_single_string', $name_field_placeholder, 'Widgets', 'RVR - Name Placeholder' );
			$email_field_text           = apply_filters( 'wpml_translate_single_string', $email_field_text, 'Widgets', 'RVR - Email Label' );
			$email_field_placeholder    = apply_filters( 'wpml_translate_single_string', $email_field_placeholder, 'Widgets', 'RVR - Email Placeholder' );
			$email_required_text        = apply_filters( 'wpml_translate_single_string', $email_required_text, 'Widgets', 'RVR - Email Required Text' );
			$phone_field_text           = apply_filters( 'wpml_translate_single_string', $phone_field_text, 'Widgets', 'RVR - Phone Label' );
			$phone_placeholder_text     = apply_filters( 'wpml_translate_single_string', $phone_placeholder_text, 'Widgets', 'RVR - Phone Placeholder' );
			$check_in_field_text        = apply_filters( 'wpml_translate_single_string', $check_in_field_text, 'Widgets', 'RVR - Check-In Label' );
			$check_in_placeholder_text  = apply_filters( 'wpml_translate_single_string', $check_in_placeholder_text, 'Widgets', 'RVR - Check-In Placeholder' );
			$check_in_required_text     = apply_filters( 'wpml_translate_single_string', $check_in_required_text, 'Widgets', 'RVR - Check-In Required Text' );
			$check_out_field_text       = apply_filters( 'wpml_translate_single_string', $check_out_field_text, 'Widgets', 'RVR - Check-Out Label' );
			$check_out_placeholder_text = apply_filters( 'wpml_translate_single_string', $check_out_placeholder_text, 'Widgets', 'RVR - Check-Out Placeholder' );
			$check_out_required_text    = apply_filters( 'wpml_translate_single_string', $check_out_required_text, 'Widgets', 'RVR - Check-Out Required Text' );
			$adults_field_text          = apply_filters( 'wpml_translate_single_string', $adults_field_text, 'Widgets', 'RVR - Adults Label' );
			$children_field_text        = apply_filters( 'wpml_translate_single_string', $children_field_text, 'Widgets', 'RVR - Childern Label' );
			$staying_nights             = apply_filters( 'wpml_translate_single_string', $staying_nights, 'Widgets', 'RVR - Staying Nights Text' );
			$price_for_staying          = apply_filters( 'wpml_translate_single_string', $price_for_staying, 'Widgets', 'RVR - Price for Staying Nights Text' );
			$services_charges           = apply_filters( 'wpml_translate_single_string', $services_charges, 'Widgets', 'RVR - Services Charges Text' );
			$subtotal                   = apply_filters( 'wpml_translate_single_string', $subtotal, 'Widgets', 'RVR - Subtotal Text' );
			$government_taxes           = apply_filters( 'wpml_translate_single_string', $government_taxes, 'Widgets', 'RVR - Government Taxes Text' );
			$total_price                = apply_filters( 'wpml_translate_single_string', $total_price, 'Widgets', 'RVR - Total Price Text' );
			$payable                    = apply_filters( 'wpml_translate_single_string', $payable, 'Widgets', 'RVR - Payable Text' );
			$show_details               = apply_filters( 'wpml_translate_single_string', $show_details, 'Widgets', 'RVR - (Show Details) Text' );
			$hide_details               = apply_filters( 'wpml_translate_single_string', $hide_details, 'Widgets', 'RVR - (Hide Details) Text' );
			$rvr_or                     = apply_filters( 'wpml_translate_single_string', $rvr_or, 'Widgets', 'RVR - OR Tag Text' );
			$rvr_call_now               = apply_filters( 'wpml_translate_single_string', $rvr_call_now, 'Widgets', 'RVR - Call Now Text' );
			$button_text                = apply_filters( 'wpml_translate_single_string', $button_text, 'Widgets', 'RVR - Submit Button Text' );

			if ( empty( $title ) ) {
				$title = false;
			}

			$property_statuses = array();
			if ( isset( $instance['property_statuses'] ) && ! empty( $instance['property_statuses'] ) ) {
				$property_statuses = $instance['property_statuses'];
			}

			if ( ! $this->show_booking_widget( $property_statuses ) ) {
				return false;
			}

			echo $before_widget;

			if ( $title ) :

				$rvr_enabled = $rvr_settings['rvr_activation'];

				if ( ! is_singular( 'property' ) ) {
					echo '<p class="warning-message">' . esc_html__( 'Booking widget can be used only on property single page.', 'realhomes-vacation-rentals' ) . '</p>';
				} elseif ( $rvr_enabled ) {

					$contact_page_id  = $rvr_settings['rvr_contact_page'];
					$contact_page_url = get_the_permalink( $contact_page_id );
					$phone_number     = $rvr_settings['rvr_contact_phone'];

					if ( ! empty( $contact_page_id ) && ! empty( $contact_page_url ) ) {
						echo '<h4 class="title"><a href="' . esc_url( $contact_page_url ) . '">' . esc_html( $title ) . '</a></h4>';
					} else {
						echo '<h4 class="title">' . esc_html( $title ) . '</h4>';
					}

					?>
                    <div class="rvr-booking-form-wrap">

                        <form class="rvr-booking-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">

                            <div class="option-bar large rvr_no_top_border">
                                <label for="rvr-user-name-<?php echo esc_attr( $this->id ); ?>"><?php echo esc_html( $name_field_text ); ?></label>
                                <input id="rvr-user-name-<?php echo esc_attr( $this->id ); ?>" type="text" class="rvr-user-name" name="user_name" placeholder="<?php echo esc_attr( $name_field_placeholder ); ?>">
                            </div>

                            <div class="option-bar large">
                                <label for="rvr-email-<?php echo esc_attr( $this->id ); ?>"><?php echo esc_html( $email_field_text ); ?></label>
                                <input id="rvr-email-<?php echo esc_attr( $this->id ); ?>" type="text" name="email" class="rvr-email required" placeholder="<?php echo esc_attr( $email_field_placeholder ); ?>" title="<?php echo esc_attr( $email_required_text ); ?>">
                            </div>

                            <div class="option-bar large">
                                <label for="rvr-phone-<?php echo esc_attr( $this->id ); ?>"><?php echo esc_html( $phone_field_text ); ?></label>
                                <input id="rvr-phone-<?php echo esc_attr( $this->id ); ?>" type="text" class="rvr-phone" name="phone" placeholder="<?php echo esc_attr( $phone_placeholder_text ); ?>">
                            </div>

                            <div class="option-bar small">
                                <label for="rvr-check-in-<?php echo esc_attr( $this->id ); ?>"><?php echo esc_html( $check_in_field_text ); ?></label>
                                <input id="rvr-check-in-<?php echo esc_attr( $this->id ); ?>" type="text" name="check_in" class="rvr-check-in required" placeholder="<?php echo esc_attr( $check_in_placeholder_text ) ?>" title="<?php echo esc_attr( $check_in_required_text ); ?>" autocomplete="off">
                            </div>

                            <div class="option-bar small">
                                <label for="rvr-check-out-<?php echo esc_attr( $this->id ); ?>"><?php echo esc_html( $check_out_field_text ); ?></label>
                                <input id="rvr-check-out-<?php echo esc_attr( $this->id ); ?>" type="text" name="check_out" class="rvr-check-out required" placeholder="<?php echo esc_attr( $check_out_placeholder_text ) ?>" title="<?php echo esc_attr( $check_out_required_text ); ?>" autocomplete="off">
                            </div>

                            <div class="option-bar small rvr_no_bottom_border">
                                <label for="rvr-adult-<?php echo esc_attr( $this->id ); ?>"><?php echo esc_html( $adults_field_text ); ?></label>
                                <select id="rvr-adult-<?php echo esc_attr( $this->id ); ?>" name="adult" class="rvr-adult inspiry_select_picker_trigger inspiry_bs_green show-tick">
									<?php
									for ( $num = 1; $num <= 10; $num += 1 ) {
										echo "<option value='{$num}'>{$num}</option>";
									}
									?>
                                </select>
                            </div>

                            <div class="option-bar bar-right small rvr_no_bottom_border">
                                <label for="rvr-child-<?php echo esc_attr( $this->id ); ?>"><?php echo esc_html( $children_field_text ); ?></label>
                                <select id="rvr-child-<?php echo esc_attr( $this->id ); ?>" name="child" class="rvr-child inspiry_select_picker_trigger inspiry_bs_green show-tick">
									<?php
									for ( $num = 0; $num <= 10; $num += 1 ) {
										echo "<option value='{$num}'>{$num}</option>";
									}
									?>
                                </select>
                            </div>

							<?php
							if ( $rvr_settings['rvr_terms_info'] && ! empty( $rvr_settings['rvr_terms_anchor_text'] ) ) {
								?>
                                <div class="option-bar rvr-terms-conditions">
                                    <label for="rvr-terms-conditions-<?php echo esc_attr( $this->id ); ?>">
                                        <input id="rvr-terms-conditions-<?php echo esc_attr( $this->id ); ?>" type="checkbox" name="terms_conditions" class="rvr-terms-conditions required" title="<?php esc_html_e( 'Please accept the terms and conditions.', 'realhomes-vacation-rentals' ); ?>">
                                        <span><?php echo wp_kses( $rvr_settings['rvr_terms_anchor_text'], wp_kses_allowed_html( 'post' ) ); ?></span>
                                    </label>
                                </div>
								<?php
							}

							if ( function_exists( 'ere_is_reCAPTCHA_configured' ) && ere_is_reCAPTCHA_configured() ) {
								?>
                                <div class="rvr-reCAPTCHA-wrapper inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( get_option( 'inspiry_reCAPTCHA_type', 'v2' ) ); ?>">
                                    <div class="inspiry-google-recaptcha"></div>
                                </div>
								<?php
							}
							?>
                            <div class="booking-cost">

                                <!-- Booking payable amount field -->
                                <div class="cost-field total-price-field">
                                    <div class="cost-desc">
                                        <strong><?php echo esc_html( $payable ); ?></strong>
                                        <a class="rvr-show-details" data-alt-label="(<?php echo esc_html( $hide_details ); ?>)">(<?php echo esc_html( $show_details ); ?>)</a>
                                    </div>
                                    <div class="cost-value"></div>
                                </div>

                                <!-- Booking cost details -->
                                <div class="booking-cost-details">
                                    <div class="cost-field staying-nights-count-field">
                                        <div class="cost-desc"><?php echo esc_html( $staying_nights ); ?></div>
                                        <div class="cost-value"></div>
                                    </div>
                                    <div class="cost-field staying-nights-field">
                                        <div class="cost-desc"><?php echo esc_html( $price_for_staying ); ?></div>
                                        <div class="cost-value"></div>
                                    </div>
									<?php
									// Additional fees calculation fields display.
									$additional_fees = get_post_meta( get_the_ID(), 'rvr_additional_fees', true );
									if ( ! empty( $additional_fees ) && is_array( $additional_fees ) ) {
										foreach ( $additional_fees as $additional_fee ) {
											if ( ! empty( $additional_fee['rvr_fee_label'] ) && ! empty( $additional_fee['rvr_fee_amount'] ) ) {
												?>
                                                <div class="cost-field <?php echo sanitize_key( $additional_fee['rvr_fee_label'] ); ?>-fee-field">
                                                    <div class="cost-desc"><?php echo esc_html( $additional_fee['rvr_fee_label'] );
														echo ( 'percentage' === $additional_fee['rvr_fee_type'] ) ? '<span>' . intVal( $additional_fee['rvr_fee_amount'] ) . '%</span>' : ''; ?></div>
                                                    <div class="cost-value"></div>
                                                </div>
												<?php
											}
										}
									}

									// Guests capacity extension.
									$guests_capacity   = get_post_meta( get_the_ID(), 'rvr_guests_capacity', true );
									$book_child_as     = get_post_meta( get_the_ID(), 'rvr_book_child_as', true );
									$extra_guests      = get_post_meta( get_the_ID(), 'rvr_guests_capacity_extend', true );
									$extra_guest_price = get_post_meta( get_the_ID(), 'rvr_extra_guest_price', true );

									if ( 'allowed' === $extra_guests && ! empty( $extra_guest_price ) ) {
										?>
                                        <div class="cost-field extra-guests-field">
                                            <div class="cost-desc"><?php echo esc_html__( 'Extra Guests' ); ?>
                                                <span>0</span></div>
                                            <div class="cost-value"></div>
                                        </div>
										<?php
									}

									// Govt tax and service charges percentages.
									$service_charges_percentage = get_post_meta( get_the_ID(), 'rvr_service_charges', true );
									$govt_tax_percentage        = get_post_meta( get_the_ID(), 'rvr_govt_tax', true );

									if ( ! empty( $service_charges_percentage ) ) {
										?>
                                        <div class="cost-field services-charges-field">
                                            <div class="cost-desc"><?php echo esc_html( $services_charges ); ?>
                                                <span><?php echo floatval( $service_charges_percentage ); ?>%</span></div>
                                            <div class="cost-value"></div>
                                        </div>
										<?php
									}

									if ( ! empty( $govt_tax_percentage ) ) {
										?>
                                        <div class="cost-field subtotal-price-field">
                                            <div class="cost-desc">
                                                <strong><?php echo esc_html( $subtotal ); ?></strong>
                                            </div>
                                            <div class="cost-value"></div>
                                        </div>
                                        <div class="cost-field govt-tax-field">
                                            <div class="cost-desc"><?php echo esc_html( $government_taxes ); ?>
                                                <span><?php echo floatval( $govt_tax_percentage ); ?>%</span></div>
                                            <div class="cost-value"></div>
                                        </div>
										<?php
									}
									?>
                                    <div class="cost-field total-price-field">
                                        <div class="cost-desc">
                                            <strong><?php echo esc_html( $total_price ); ?></strong>
                                        </div>
                                        <div class="cost-value"></div>
                                    </div>
                                </div><!-- End of .booking-cost-details -->
                            </div><!-- End of .booking-cost -->
                            <div class="submission-area clearfix">
								<?php
								$additional_fees = get_post_meta( get_the_ID(), 'rvr_additional_fees', true );
								if ( ! empty( $additional_fees ) && is_array( $additional_fees ) ) {
									echo '<div class="rvr-additional-fees">';
									foreach ( $additional_fees as $additional_fee ) {
										if ( ! empty( $additional_fee['rvr_fee_label'] ) && ! empty( $additional_fee['rvr_fee_amount'] ) ) {
											?>
                                            <input type="hidden" name="<?php echo sanitize_key( $additional_fee['rvr_fee_label'] ); ?>" data-label="<?php echo esc_attr( $additional_fee['rvr_fee_label'] ); ?>" data-type="<?php echo esc_attr( $additional_fee['rvr_fee_type'] ); ?>" data-calculation="<?php echo esc_attr( $additional_fee['rvr_fee_calculation'] ); ?>" data-amount="<?php echo esc_html( $additional_fee['rvr_fee_amount'] ); ?>"/>
											<?php
										}
									}
									echo '</div>';
								}

								// Property pricing flag if seasonal are available.
								$seasonal_prices  = get_post_meta( get_the_ID(), 'rvr_seasonal_prices_table', true );
								$property_pricing = 'flat';
								if ( ! empty( $seasonal_prices ) && is_array( $seasonal_prices ) ) {
									$property_pricing = 'seasonal';
								}

								// Bulk prices data.
								$bulk_prices = get_post_meta( get_the_ID(), 'rvr_bulk_pricing', true );
								if ( is_array( $bulk_prices ) && ! empty( $bulk_prices ) ) {
									sort( $bulk_prices );

									$bulk_price_pairs = array();
									foreach ( $bulk_prices as $bulk_price ) {
										if ( ! empty( $bulk_price['number_of_nights'] ) && ! empty( $bulk_price['number_of_nights'] ) ) {
											$bulk_price_pairs[ $bulk_price['number_of_nights'] ] = $bulk_price['price_per_night'];
										}
									}
									?>
                                    <input type="hidden" name="bulk_prices" class="bulk-prices" value="<?php echo esc_html( htmlspecialchars( wp_json_encode( $bulk_price_pairs ) ) ); ?>"/>
									<?php
								}
								?>
                                <input type="hidden" name="guests_capacity" class="guests-capacity" value="<?php echo esc_html( $guests_capacity ); ?>"/>
                                <input type="hidden" name="book_child_as" class="book-child-as" value="<?php echo esc_html( $book_child_as ); ?>"/>
                                <input type="hidden" name="extra_guests" class="extra-guests" value="<?php echo esc_html( $extra_guests ); ?>"/>
                                <input type="hidden" name="extra_guest_price" class="per-extra-guest-price" value="<?php echo esc_html( $extra_guest_price ); ?>"/>
                                <input type="hidden" name="property_pricing" class="property-pricing" value="<?php echo esc_attr( $property_pricing ); ?>"/>
                                <input type="hidden" name="property_id" class="property-id" value="<?php echo get_the_ID(); ?>"/>
                                <input type="hidden" name="price_per_night" class="price-per-night" value="<?php echo intval( get_post_meta( get_the_ID(), 'REAL_HOMES_property_price', true ) ); ?>"/>
                                <input type="hidden" name="service_charges" class="service-charges" value="<?php echo floatval( get_post_meta( get_the_ID(), 'rvr_service_charges', true ) ); ?>"/>
                                <input type="hidden" name="govt_charges" class="govt-charges" value="<?php echo floatval( get_post_meta( get_the_ID(), 'rvr_govt_tax', true ) ); ?>"/>
                                <input type="hidden" name="action" value="rvr_booking_request"/>
                                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'rvr_booking_request' ); ?>"/>
                                <div class="rvr-booking-button-wrapper">
                                    <input type="submit" value="<?php echo esc_html( $button_text ); ?>" class="rvr-booking-button real-btn btn">
                                </div>
								<?php
								if ( INSPIRY_DESIGN_VARIATION === 'classic' ) {
									?>
                                    <img class="rvr-ajax-loader" src="<?php echo plugins_url( 'images/ajax-loader.gif', __FILE__ ); ?>" alt="<?php esc_html_e( 'Ajax Loader', 'realhomes-vacation-rentals' ); ?>">
									<?php
								} else {
									?>
                                    <span class="rvr-ajax-loader"><?php include INSPIRY_THEME_DIR . '/images/loader.svg'; ?></span>
									<?php
								}
								?>

                                <div class="rvr-message-container"></div>
                                <div class="rvr-error-container"></div>
                            </div>
                        </form>
                    </div>

					<?php
					if ( ! empty( $phone_number ) ) {
						?>
                        <div class="rvr_request_cta_booking">
                            <span class="rvr_cta_or"><?php echo esc_html( $rvr_or ); ?></span>

                            <div class="rvr_request_cta_number_wrapper">
								<span class="rvr_phone_icon_wrapper">
									<span class="rvr_phone_icon"><?php inspiry_safe_include_svg( '/images/phone-cfos.svg', '/common/' ); ?></span>
								</span>
                                <p class="rvr-phone-number">
                                    <strong><?php echo esc_html( $rvr_call_now ); ?></strong>
                                    <a href="tel:<?php echo esc_attr( $phone_number ); ?>"><?php echo esc_html( $phone_number ); ?></a>
                                </p>
                            </div>
                        </div>
						<?php
					}
				} else {
					echo '<p class="warning-message"><strong>' . esc_html__( 'Note: ', 'realhomes-vacation-rentals' ) . '</strong>' . esc_html__( 'Please activate the RVR from its settings to display Booking form.', 'realhomes-vacation-rentals' ) . '</p>';
				}

			endif;

			echo $after_widget;
		}

		public function form( $instance ) {
			$instance = wp_parse_args(
				(array) $instance,
				array(
					'title'                      => esc_html__( 'Request a Booking', 'realhomes-vacation-rentals' ),
					'button_text'                => esc_html__( 'Book Now', 'realhomes-vacation-rentals' ),
					'name_field_text'            => esc_html__( 'Name', 'realhomes-vacation-rentals' ),
					'name_field_placeholder'     => esc_html__( 'Enter Name', 'realhomes-vacation-rentals' ),
					'email_field_text'           => esc_html__( 'Email', 'realhomes-vacation-rentals' ),
					'email_field_placeholder'    => esc_html__( 'Enter Email', 'realhomes-vacation-rentals' ),
					'email_required_text'        => esc_html__( 'Email field is required.', 'realhomes-vacation-rentals' ),
					'phone_field_text'           => esc_html__( 'Phone', 'realhomes-vacation-rentals' ),
					'phone_placeholder_text'     => esc_html__( '1-800-123-4567', 'realhomes-vacation-rentals' ),
					'check_in_field_text'        => esc_html__( 'Check In', 'realhomes-vacation-rentals' ),
					'check_in_placeholder_text'  => esc_html__( 'yyyy-mm-dd', 'realhomes-vacation-rentals' ),
					'check_in_required_text'     => esc_html__( 'Check-In field is required.', 'realhomes-vacation-rentals' ),
					'check_out_field_text'       => esc_html__( 'Check Out', 'realhomes-vacation-rentals' ),
					'check_out_placeholder_text' => esc_html__( 'yyyy-mm-dd', 'realhomes-vacation-rentals' ),
					'check_out_required_text'    => esc_html__( 'Check-Out field is required.', 'realhomes-vacation-rentals' ),
					'adults_field_text'          => esc_html__( 'Adults', 'realhomes-vacation-rentals' ),
					'children_field_text'        => esc_html__( 'Children', 'realhomes-vacation-rentals' ),
					'staying_nights'             => esc_html__( 'Staying Nights', 'realhomes-vacation-rentals' ),
					'price_for_staying'          => esc_html__( 'Price For Staying Nights', 'realhomes-vacation-rentals' ),
					'services_charges'           => esc_html__( 'Services Charges', 'realhomes-vacation-rentals' ),
					'subtotal'                   => esc_html__( 'Subtotal', 'realhomes-vacation-rentals' ),
					'government_taxes'           => esc_html__( 'Government Taxes', 'realhomes-vacation-rentals' ),
					'total_price'                => esc_html__( 'Total Price', 'realhomes-vacation-rentals' ),
					'payable'                    => esc_html__( 'Payable', 'realhomes-vacation-rentals' ),
					'show_details'               => esc_html__( 'Show Details', 'realhomes-vacation-rentals' ),
					'hide_details'               => esc_html__( 'Hide Details', 'realhomes-vacation-rentals' ),
					'rvr_or'                     => esc_html__( 'OR', 'realhomes-vacation-rentals' ),
					'rvr_call_now'               => esc_html__( 'Call Now', 'realhomes-vacation-rentals' ),
					'property_statuses'          => array(),
				)
			);

			$title                      = esc_attr( $instance['title'] );
			$button_text                = esc_attr( $instance['button_text'] );
			$name_field_text            = esc_attr( $instance['name_field_text'] );
			$name_field_placeholder     = esc_attr( $instance['name_field_placeholder'] );
			$email_field_text           = esc_attr( $instance['email_field_text'] );
			$email_field_placeholder    = esc_attr( $instance['email_field_placeholder'] );
			$email_required_text        = esc_attr( $instance['email_required_text'] );
			$phone_field_text           = esc_attr( $instance['phone_field_text'] );
			$phone_placeholder_text     = esc_attr( $instance['phone_placeholder_text'] );
			$check_in_field_text        = esc_attr( $instance['check_in_field_text'] );
			$check_in_placeholder_text  = esc_attr( $instance['check_in_placeholder_text'] );
			$check_in_required_text     = esc_attr( $instance['check_in_required_text'] );
			$check_out_field_text       = esc_attr( $instance['check_out_field_text'] );
			$check_out_placeholder_text = esc_attr( $instance['check_out_placeholder_text'] );
			$check_out_required_text    = esc_attr( $instance['check_out_required_text'] );
			$adults_field_text          = esc_attr( $instance['adults_field_text'] );
			$children_field_text        = esc_attr( $instance['children_field_text'] );
			$staying_nights             = esc_attr( $instance['staying_nights'] );
			$price_for_staying          = esc_attr( $instance['price_for_staying'] );
			$services_charges           = esc_attr( $instance['services_charges'] );
			$subtotal                   = esc_attr( $instance['subtotal'] );
			$government_taxes           = esc_attr( $instance['government_taxes'] );
			$total_price                = esc_attr( $instance['total_price'] );
			$payable                    = esc_attr( $instance['payable'] );
			$show_details               = esc_attr( $instance['show_details'] );
			$hide_details               = esc_attr( $instance['hide_details'] );
			$rvr_or                     = esc_attr( $instance['rvr_or'] );
			$rvr_call_now               = esc_attr( $instance['rvr_call_now'] );
			$property_statuses          = $instance['property_statuses'];
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>" class="widefat"/>
            </p>

            <p>
                <label><?php esc_html_e( 'Choose Property Statuses to Show Booking Form', 'realhomes-vacation-rentals' ); ?></label>
				<?php
				$property_status_terms = get_terms( array(
					'taxonomy'   => 'property-status',
					'hide_empty' => false,
				) );
				if ( ! empty( $property_status_terms ) && ! is_wp_error( $property_status_terms ) ) :
					foreach ( $property_status_terms as $term ) :
						$term_id = $term->term_id;
						?>
                        <br/>
                        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( $term_id ); ?>" name="<?php echo $this->get_field_name( 'property_statuses' ); ?>[]" value="<?php echo esc_attr( $term_id ); ?>"<?php checked( in_array( $term_id, $property_statuses ) ); ?> />
                        <label for="<?php echo $this->get_field_id( $term_id ); ?>"><?php echo esc_html( $term->name ); ?></label>
					<?php
					endforeach;
				endif;
				?>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'name_field_text' ) ); ?>"><?php esc_html_e( 'Name Label', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'name_field_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'name_field_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $name_field_text ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'name_field_placeholder' ) ); ?>"><?php esc_html_e( 'Name Placeholder', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'name_field_placeholder' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'name_field_placeholder' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $name_field_placeholder ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'email_field_text' ) ); ?>"><?php esc_html_e( 'Email Label', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'email_field_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'email_field_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $email_field_text ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'email_field_placeholder' ) ); ?>"><?php esc_html_e( 'Email Placeholder', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'email_field_placeholder' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'email_field_placeholder' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $email_field_placeholder ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'email_required_text' ) ); ?>"><?php esc_html_e( 'Required Email Text (If field is empty)', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'email_required_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'email_required_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $email_required_text ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'phone_field_text' ) ); ?>"><?php esc_html_e( 'Phone Label', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'phone_field_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'phone_field_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $phone_field_text ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'phone_placeholder_text' ) ); ?>"><?php esc_html_e( 'Phone Placeholder', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'phone_placeholder_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'phone_placeholder_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $phone_placeholder_text ); ?>" class="widefat"/>
            </p>


            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'check_in_field_text' ) ); ?>"><?php esc_html_e( 'Check-In Label', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'check_in_field_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'check_in_field_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $check_in_field_text ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'check_in_placeholder_text' ) ); ?>"><?php esc_html_e( 'Check-In Placeholder', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'check_in_placeholder_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'check_in_placeholder_text' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $check_in_placeholder_text ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'check_in_required_text' ) ); ?>"><?php esc_html_e( 'Check-In Required Text (IF no date is selected)', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'check_in_required_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'check_in_required_text' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $check_in_required_text ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'check_out_field_text' ) ); ?>"><?php esc_html_e( 'Check-Out Label', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'check_out_field_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'check_out_field_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $check_out_field_text ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'check_out_placeholder_text' ) ); ?>"><?php esc_html_e( 'Check-Out Placeholder', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'check_out_placeholder_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'check_out_placeholder_text' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $check_out_placeholder_text ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'check_out_required_text' ) ); ?>"><?php esc_html_e( 'Check-Out Required Text (IF no date is selected)', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'check_out_required_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'check_out_required_text' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $check_out_required_text ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'adults_field_text' ) ); ?>"><?php esc_html_e( 'Adults Label', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'adults_field_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'adults_field_text' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $adults_field_text ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'children_field_text' ) ); ?>"><?php esc_html_e( 'Children Label', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'children_field_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'children_field_text' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $children_field_text ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'staying_nights' ) ); ?>"><?php esc_html_e( 'Staying Nights Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'staying_nights' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'staying_nights' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $staying_nights ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'price_for_staying' ) ); ?>"><?php esc_html_e( 'Price for Staying Nights Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'price_for_staying' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'price_for_staying' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $price_for_staying ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'services_charges' ) ); ?>"><?php esc_html_e( 'Services Charges Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'services_charges' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'services_charges' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $services_charges ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'subtotal' ) ); ?>"><?php esc_html_e( 'Subtotal Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'subtotal' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'subtotal' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $subtotal ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'government_taxes' ) ); ?>"><?php esc_html_e( 'Government Taxes Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'government_taxes' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'government_taxes' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $government_taxes ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'total_price' ) ); ?>"><?php esc_html_e( 'Total Price Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'total_price' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'total_price' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $total_price ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'payable' ) ); ?>"><?php esc_html_e( 'Payable Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'payable' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'payable' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $payable ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'show_details' ) ); ?>"><?php esc_html_e( '(Show Details) Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'show_details' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'show_details' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $show_details ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'hide_details' ) ); ?>"><?php esc_html_e( '(Hide Details) Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'hide_details' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'hide_details' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $hide_details ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'rvr_or' ) ); ?>"><?php esc_html_e( 'OR Tag Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'rvr_or' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'rvr_or' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $rvr_or ); ?>" class="widefat"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'rvr_call_now' ) ); ?>"><?php esc_html_e( 'Call Now Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'rvr_call_now' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'rvr_call_now' ) ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $rvr_call_now ); ?>" class="widefat"/>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Submit Button Text', 'realhomes-vacation-rentals' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $button_text ); ?>" class="widefat"/>
            </p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance                               = $old_instance;
			$instance['title']                      = strip_tags( $new_instance['title'] );
			$instance['button_text']                = strip_tags( $new_instance['button_text'] );
			$instance['name_field_text']            = strip_tags( $new_instance['name_field_text'] );
			$instance['name_field_placeholder']     = strip_tags( $new_instance['name_field_placeholder'] );
			$instance['email_field_text']           = strip_tags( $new_instance['email_field_text'] );
			$instance['email_field_placeholder']    = strip_tags( $new_instance['email_field_placeholder'] );
			$instance['email_required_text']        = strip_tags( $new_instance['email_required_text'] );
			$instance['phone_field_text']           = strip_tags( $new_instance['phone_field_text'] );
			$instance['phone_placeholder_text']     = strip_tags( $new_instance['phone_placeholder_text'] );
			$instance['check_in_field_text']        = strip_tags( $new_instance['check_in_field_text'] );
			$instance['check_in_placeholder_text']  = strip_tags( $new_instance['check_in_placeholder_text'] );
			$instance['check_in_required_text']     = strip_tags( $new_instance['check_in_required_text'] );
			$instance['check_out_field_text']       = strip_tags( $new_instance['check_out_field_text'] );
			$instance['check_out_placeholder_text'] = strip_tags( $new_instance['check_out_placeholder_text'] );
			$instance['check_out_required_text']    = strip_tags( $new_instance['check_out_required_text'] );
			$instance['adults_field_text']          = strip_tags( $new_instance['adults_field_text'] );
			$instance['children_field_text']        = strip_tags( $new_instance['children_field_text'] );
			$instance['staying_nights']             = strip_tags( $new_instance['staying_nights'] );
			$instance['price_for_staying']          = strip_tags( $new_instance['price_for_staying'] );
			$instance['services_charges']           = strip_tags( $new_instance['services_charges'] );
			$instance['subtotal']                   = strip_tags( $new_instance['subtotal'] );
			$instance['government_taxes']           = strip_tags( $new_instance['government_taxes'] );
			$instance['total_price']                = strip_tags( $new_instance['total_price'] );
			$instance['payable']                    = strip_tags( $new_instance['payable'] );
			$instance['show_details']               = strip_tags( $new_instance['show_details'] );
			$instance['hide_details']               = strip_tags( $new_instance['hide_details'] );
			$instance['rvr_or']                     = strip_tags( $new_instance['rvr_or'] );
			$instance['rvr_call_now']               = strip_tags( $new_instance['rvr_call_now'] );
			$instance['property_statuses']          = empty( $new_instance['property_statuses'] ) ? array() : array_map( 'sanitize_key', $new_instance['property_statuses'] );

			/**
			 * Register strings for WPML translation.
			 */
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Name Label', $instance['name_field_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Name Placeholder', $instance['name_field_placeholder'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Email Label', $instance['email_field_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Email Placeholder', $instance['email_field_placeholder'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Email Required Text', $instance['email_required_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Phone Label', $instance['phone_field_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Phone Placeholder', $instance['phone_placeholder_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Check-In Label', $instance['check_in_field_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Check-In Placeholder', $instance['check_in_placeholder_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Check-In Required Text', $instance['check_in_required_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Check-Out Label', $instance['check_out_field_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Check-Out Placeholder', $instance['check_out_placeholder_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Check-Out Required Text', $instance['check_out_required_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Adults Label', $instance['adults_field_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Childern Label', $instance['children_field_text'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Staying Nights Text', $instance['staying_nights'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Price for Staying Nights Text', $instance['price_for_staying'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Services Charges Text', $instance['services_charges'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Subtotal Text', $instance['subtotal'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Government Taxes Text', $instance['government_taxes'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Total Price Text', $instance['total_price'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Payable Text', $instance['payable'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - (Show Details) Text', $instance['show_details'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - (Hide Details) Text', $instance['hide_details'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - OR Tag Text', $instance['rvr_or'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Call Now Text', $instance['rvr_call_now'] );
			do_action( 'wpml_register_single_string', 'Widgets', 'RVR - Submit Button Text', $instance['button_text'] );

			return $instance;
		}

		/**
		 * Checks for allowed property statuses to show booking widget.
		 *
		 * @param array $property_statuses
		 *
		 * @return bool
		 */
		public function show_booking_widget( $property_statuses = array() ) {

			if ( ! empty( $property_statuses ) ) {
				// Get current property statuses
				$current_statuses = get_the_terms( get_the_ID(), 'property-status' );
				if ( ! empty( $current_statuses ) && ! is_wp_error( $current_statuses ) ) {
					$show_widget = false;
					foreach ( $current_statuses as $current_status ) {
						// Stop if current status exists in allowed statuses.
						if ( in_array( $current_status->term_id, $property_statuses ) ) {
							$show_widget = true;
							break;
						}
					}

					return $show_widget;
				}
			}

			return true;
		}
	}
}
