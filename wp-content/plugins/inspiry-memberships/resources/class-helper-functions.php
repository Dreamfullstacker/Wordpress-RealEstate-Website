<?php
/**
 * Functions Class
 *
 * Class for general plugin functions.
 *
 * @since   2.1.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * IMS_Helper_Functions.
 *
 * Class for helper plugin functions.
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'IMS_Helper_Functions' ) ) {

	class IMS_Helper_Functions {

		/**
		 * Single Instance of Class.
		 *
		 * @var    IMS_Helper_Functions
		 * @since  1.0.0
		 */
		protected static $_instance;

		/**
		 * $basic_settings.
		 *
		 * @var    array
		 * @since  1.0.0
		 */
		public $basic_settings;

		/**
		 * $stripe_settings.
		 *
		 * @var    array
		 * @since  1.0.0
		 */
		public $stripe_settings;

		/**
		 * Method: Provides a single instance of the class.
		 *
		 * @since 1.0.0
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * is_memberships.
		 *
		 * @since 1.0.0
		 */
		public static function is_memberships() {

			// Get settings.
			$plugin_settings = get_option( 'ims_basic_settings' );

			if ( ! empty( $plugin_settings ) && ( 'on' === $plugin_settings['ims_memberships_enable'] ) ) {
				return true;
			}

			return false;
		}

		/**
		 * get_formatted_price.
		 *
		 * @since 1.0.0
		 */
		public static function get_formatted_price( $price ) {

			// Get settings.
			$currency_settings = get_option( 'ims_basic_settings' );
			$currency_position = $currency_settings['ims_currency_position']; // Currency Symbol Position.
			$formatted_price   = '';

			if ( ! empty( $price ) ) {
				if ( 'after' === $currency_position ) {
					$formatted_price = esc_html( $price . $currency_settings['ims_currency_symbol'] );
				} else {
					$formatted_price = esc_html( $currency_settings['ims_currency_symbol'] . $price );
				}
			} else {
				//return esc_html__( 'Price not available', 'inspiry-memberships' );
				if ( 'after' === $currency_position ) {
					$formatted_price = esc_html( '0' . $currency_settings['ims_currency_symbol'] );
				} else {
					$formatted_price = esc_html( $currency_settings['ims_currency_symbol'] . '0' );
				}
			}

			return $formatted_price;
		}

		/**
		 * Get all memberships.
		 *
		 * @return array|bool Array of Memberships data.
		 * @since 1.0.0
		 */
		public static function ims_get_all_memberships() {
			/**
			 * The WordPress Query class.
			 * @link http://codex.wordpress.org/Function_Reference/WP_Query
			 */
			$membership_args = array(
				'post_type'      => 'ims_membership',
				'post_status'    => 'publish',
				'posts_per_page' => 100,
				'orderby'        => 'menu_order',
				'meta_key'       => 'ims_membership_duration',
				'meta_value'     => '0',
				'meta_type'      => 'numeric',
				'meta_compare'   => '>',
			);

			$memberships_query = new WP_Query( apply_filters( 'ims_membership_args', $membership_args ) );

			if ( $memberships_query->have_posts() ) {

				// Membership Data array.
				$memberships_data = array();

				while ( $memberships_query->have_posts() ) {
					$memberships_query->the_post();
					$membership_obj = ims_get_membership_object( get_the_ID() );

					// Memberships data.
					$memberships_data[] = array(
						'ID'            => get_the_ID(),
						'title'         => get_the_title(),
						'format_price'  => self::get_formatted_price( $membership_obj->get_price() ),
						'price'         => $membership_obj->get_price(),
						'properties'    => $membership_obj->get_properties(),
						'featured_prop' => $membership_obj->get_featured_properties(),
						'duration'      => $membership_obj->get_duration(),
						'duration_unit' => $membership_obj->get_duration_unit(),
						'is_popular'    => $membership_obj->get_popular(),
					);
				}

				return $memberships_data;
			}

			return false;
		}

		/**
		 * Get membership by user.
		 *
		 * @since 1.0.0
		 */
		public static function ims_get_membership_by_user( $user ) {

			// Get user id.
			if ( ! is_object( $user ) ) {
				return false;
			}

			$user_id = $user->ID;

			// Get current membership details.
			$membership_id          = get_user_meta( $user_id, 'ims_current_membership', true );
			$package_properties     = get_user_meta( $user_id, 'ims_package_properties', true );
			$current_properties     = get_user_meta( $user_id, 'ims_current_properties', true );
			$package_featured_props = get_user_meta( $user_id, 'ims_package_featured_props', true );
			$current_featured_props = get_user_meta( $user_id, 'ims_current_featured_props', true );
			$membership_due_date    = get_user_meta( $user_id, 'ims_membership_due_date', true );

			if ( ! empty( $membership_id ) ) {

				// Get membership object.
				$membership_id  = intval( $membership_id );
				$membership_obj = ims_get_membership_object( $membership_id );

				$membership_data = array(
					'ID'               => get_the_ID(),
					'title'            => get_the_title( $membership_id ),
					'format_price'     => self::get_formatted_price( $membership_obj->get_price() ),
					'price'            => $membership_obj->get_price(),
					'properties'       => $package_properties,
					'current_props'    => $current_properties,
					'featured_prop'    => $package_featured_props,
					'current_featured' => $current_featured_props,
					'duration'         => $membership_obj->get_duration(),
					'duration_unit'    => $membership_obj->get_duration_unit(),
					'due_date'         => $membership_due_date,
				);

				return $membership_data;
			}

			return false;
		}

		/**
		 * Method: Displays cancel membership form.
		 *
		 * @since 1.0.0
		 */
		public static function cancel_user_membership_form( $user ) {

			// Get user id.
			if ( is_object( $user ) ) {
				$user_id = $user->ID;
			} else {
				return;
			}

			if ( ! empty( $user_id ) ) : ?>
				<form action="" method="POST" id="ims-cancel-user-membership">
					<h4><?php esc_html_e( 'Are you sure?', 'inspiry-memberships' ); ?></h4>
					<button class="btn btn-secondary" id="ims-btn-confirm" type="submit"><?php esc_html_e( 'Yes', 'inspiry-memberships' ); ?></button>
					<button class="btn btn-secondary" id="ims-btn-close" type="button"><?php esc_html_e( 'No', 'inspiry-memberships' ); ?></button>
					<input type="hidden" name="action" value="ims_cancel_user_membership"/>
					<input type="hidden" name="user_id" value="<?php echo esc_attr( $user_id ); ?>"/>
					<input type="hidden" name="ims_cancel_membership_nonce" value="<?php echo wp_create_nonce( 'ims-cancel-membership-nonce' ); ?>"/>
				</form>
			<?php
			endif;
		}

		/**
		 * @param string $duration_unit
		 *
		 * @return mixed|string
		 */
		public static function get_readable_duration_unit( $duration_unit ) {

			$duration_units = array(
				'day'    => esc_html__( 'Day', 'inspiry-memberships' ),
				'days'   => esc_html__( 'Days', 'inspiry-memberships' ),
				'week'   => esc_html__( 'Week', 'inspiry-memberships' ),
				'weeks'  => esc_html__( 'Weeks', 'inspiry-memberships' ),
				'month'  => esc_html__( 'Month', 'inspiry-memberships' ),
				'months' => esc_html__( 'Months', 'inspiry-memberships' ),
				'year'   => esc_html__( 'Year', 'inspiry-memberships' ),
				'years'  => esc_html__( 'Years', 'inspiry-memberships' ),
			);

			if ( ! empty( $duration_unit ) && isset( $duration_units[ $duration_unit ] ) ) {
				return $duration_units[ $duration_unit ];
			}

			return $duration_unit;
		}

		/**
		 * Displays package checkout form.
		 *
		 * @since 1.1.3
		 *
		 * @param string $redirect_url Redirect URL after successfull payment.
		 */
		public static function checkout_form( $redirect_url = '' ) {

			if ( empty( $redirect_url ) ) {
				$redirect_url = home_url();
			}

			// Get plugin settings.
			$basic_settings  = get_option( 'ims_basic_settings' );
			$stripe_settings = get_option( 'ims_stripe_settings' );
			$paypal_settings = get_option( 'ims_paypal_settings' );
			$wire_settings   = get_option( 'ims_wire_settings' );

			if ( isset( $_GET['package_id'] ) && ! empty( $_GET['package_id'] ) && intval( $_GET['package_id'] ) ) {
				$package_id = intval( $_GET['package_id'] );

				// Check for valid package id.
				if ( 'publish' !== get_post_status( $package_id ) ) {
					esc_html_e( 'Invalid Package ID', 'inspiry-memberships' );
					return;
				}

				// Get current package.
				$package       = ims_get_membership_object( $package_id );
				$package_price = $package->get_price();
				?>
				<form id="ims-checkout-form" class="ims-checkout-form" method="post" action="<?php echo esc_url( $redirect_url ); ?>">
					<div class="row">
						<!-- Package Information -->
						<div class="col-lg-4 order-lg-2">
							<div class="box">
								<div class="box-head">
									<h3 class="box-title"><?php esc_html_e( 'Your Order', 'inspiry-memberships' ); ?></h3>
								</div>
								<div class="box-body">
									<table class="package-order-table">
										<thead>
											<tr>
												<th><?php esc_html_e( 'Package', 'inspiry-memberships' ); ?></th>
												<th><?php esc_html_e( 'Price', 'inspiry-memberships' ); ?></th>
											</tr>
										</thead>
										<tbody>
											<tr class="data-row">
												<td><strong><?php echo esc_html( get_the_title( $package_id ) ); ?></strong></td>
												<td><strong><?php echo esc_html( $package->get_formatted_price() ); ?></strong></td>
											</tr>
											<tr class="total-price">
												<td><strong><?php esc_html_e( 'Total', 'inspiry-memberships' ); ?></strong></td>
												<td><strong><?php echo esc_html( $package->get_formatted_price() ); ?></strong></td>
											</tr>
										</tbody>
									</table>
								</div><!-- .box-body -->
							</div><!-- .box -->
						</div><!-- End Package Information -->

						<div class="col-lg-8 order-lg-1">
							<div class="box">
								<div class="box-head">
									<h3 class="box-title"><?php esc_html_e( 'Payment Method', 'inspiry-memberships' ); ?></h3>
								</div>
								<div class="box-body">
								<?php
								// Store all payment methods.
								$payment_methods = array();
								$hide_stripe_btn = 'hide';
								$hide_main_btn   = 'hide';

								// Add direct payment method.
								if ( ! empty( $wire_settings['ims_wire_enable'] ) && 'on' === $wire_settings['ims_wire_enable'] ) {
									$payment_methods[] = array(
										'id'    => 'direct_bank',
										'label' => esc_html__( 'Direct Bank Transfer', 'inspiry-memberships' ),
									);
									wp_nonce_field( 'membership-wire-nonce', 'membership_wire_nonce' );
								}

								// Add paypal payment method.
								if ( ! empty( $paypal_settings['ims_paypal_enable'] ) && 'on' === $paypal_settings['ims_paypal_enable'] ) {
									$payment_methods[] = array(
										'id'    => 'paypal',
										'label' => esc_html__( 'PayPal', 'inspiry-memberships' ),
									);
									wp_nonce_field( 'membership-paypal-nonce', 'membership_paypal_nonce' );
								}

								// Add stripe payment method.
								if ( ! empty( $stripe_settings['ims_stripe_enable'] ) && 'on' === $stripe_settings['ims_stripe_enable'] ) {
									$payment_methods[] = array(
										'id'    => 'stripe',
										'label' => esc_html__( 'Stripe', 'inspiry-memberships' ),
									);
								}
								?>
								<!-- Payment Methods -->
								<div id="payment-methods" class="payment-methods">
									<div class="row">
										<?php
										foreach ( $payment_methods as $key => $value ) :
											$id = $value['id'];

											$image_wrap_class = '';
											$is_checked       = false;

											// Set first item as current.
											if ( 0 === $key ) {
												$is_checked       = true;
												$image_wrap_class = ' current';

												// Show stripe button.
												if ( 'stripe' === $id ) {
													$hide_stripe_btn = '';
												} else {
													$hide_main_btn = '';
												}
											}
											?>
											<div class="payment-method">
												<label for="payment-method-<?php echo esc_attr( $id ); ?>" class="image-wrap<?php echo esc_attr( $image_wrap_class ); ?>">
													<span class="image-wrap-inner">
														<?php include_once IMS_BASE_DIR . 'resources/img/' . esc_html( $id ) . '.svg'; ?>
													</span>
												</label>
												<div class="radio-field radio-field-white">
													<input id="payment-method-<?php echo esc_attr( $id ); ?>" type="radio" name="payment_method" value="<?php echo esc_html( $id ); ?>"<?php checked( true, $is_checked ); ?>>
													<label for="payment-method-<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $value['label'] ); ?></label>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div><!-- End Payment Methods -->

								<?php
								// Recuring payment option.
								if ( ! empty( $package_price ) && 'on' === $basic_settings['ims_recurring_memberships_enable'] ) {
									?>
									<div id="ims-recurring-wrap" class="ims-recurring-wrap checkbox-field checkbox-field-white hide">
										<input type="checkbox" name="ims_recurring" id="ims_recurring"/>
										<label for="ims_recurring"><?php esc_html_e( 'Recurring Payments?', 'inspiry-memberships' ); ?></label>
									</div>
									<?php
								}
								?>

								<?php if ( isset( $basic_settings['ims_terms_and_conditions'] ) && ! empty( $basic_settings['ims_terms_and_conditions'] ) ) : ?>
									<div id="ims-terms-and-conditions-wrap" class="ims-terms-and-conditions-wrap checkbox-field checkbox-field-white">
										<input type="checkbox" name="ims_terms_and_conditions" id="ims_terms_and_conditions"/>
										<label for="ims_terms_and_conditions">
											<?php
											echo wp_kses(
												$basic_settings['ims_terms_and_conditions'],
												array(
													'a'  => array(
														'href'   => array(),
														'title'  => array(),
														'alt'    => array(),
														'target' => array(),
													),
													'br' => array(),
													'em' => array(),
													'strong' => array(),
												)
											);
											?>
										</label>
									</div>
								<?php endif; ?>

								</div><!-- .box-body -->
								<?php if ( empty( $package_price ) ) { ?>
									<div class="box-overlay"></div>
								<?php } ?>
						</div>

						<div class="ims-btn-wrap">
							<?php if ( ! empty( $package_price ) ) { ?>
								<div class="ims-stripe-button <?php echo esc_attr( $hide_stripe_btn ); ?>"></div>
							<?php } ?>
							<div class="ims-btn-inner-wrap <?php echo esc_attr( $hide_main_btn ); ?>">
								<?php if ( ! empty( $package_price ) ) { ?>
									<button type="button" class="btn btn-primary" id="ims-btn-complete-payment"><?php esc_html_e( 'Complete Payment', 'inspiry-memberships' ); ?></button>
								<?php } else { ?>
									<button type="button" class="btn btn-primary" id="ims-free-membership-btn"><?php esc_html_e( 'Subscribe', 'inspiry-memberships' ); ?></button>
								<?php } ?>

								<span class="ims-form-loader">
									<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 128 128"><rect x="0" y="0" width="100%" height="100%" fill="#FFFFFF"></rect><g><path d="M75.4 126.63a11.43 11.43 0 0 1-2.1-22.65 40.9 40.9 0 0 0 30.5-30.6 11.4 11.4 0 1 1 22.27 4.87h.02a63.77 63.77 0 0 1-47.8 48.05v-.02a11.38 11.38 0 0 1-2.93.37z" fill="#1ea69a" fill-opacity="1"></path><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1000ms" repeatCount="indefinite"></animateTransform></g></svg>
								</span>
							</div>
							<?php
							if ( 'show' === get_option( 'inspiry_checkout_badges_display', 'show' ) ) :
								$badges = array(
									'visa',
									'mastercard',
									'amex',
									'discover',
								);
								?>
								<div class="ims-badges">
									<?php foreach ( $badges as $badge ) : ?>
										<div class="cards-wrapper <?php echo esc_attr( $badge ); ?>-card"><?php include_once IMS_BASE_DIR . 'resources/img/' . $badge . '.svg'; ?></div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="checkout-form-response-log"></div>
					</div><!-- .col-lg-8 -->
					</div><!-- .row -->
					<input type="hidden" name="package_id" value="<?php echo esc_attr( $package_id ); ?>"/>
					<input type="hidden" name="order_id" value=""/>
					<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect_url ); ?>"/>
					<?php wp_nonce_field( 'membership-select-nonce', 'membership_select_nonce' ); ?>
					<button type="submit" class="btn btn-primary hide" id="ims-submit-order"><?php esc_html_e( 'Complete Payment', 'inspiry-memberships' ); ?></button>
				</form>
				<?php
			} else {
				esc_html_e( 'Invalid Package ID', 'inspiry-memberships' );
			}
		}
	}
}

/**
 * Returns the main instance of IMS_Helper_Functions.
 *
 * @since 2.1.0
 */
function IMS_Helper_Functions() {
	return IMS_Helper_Functions::instance();
}

IMS_Helper_Functions();
