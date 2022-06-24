<div id="dashboard-membership-packages" class="dashboard-membership-packages">
	<?php
	$ims_helper_functions = IMS_Helper_Functions();
	$inspiry_memberships  = $ims_helper_functions::ims_get_all_memberships();

	$currency_symbol   = '';
	$currency_settings = get_option( 'ims_basic_settings' );
	if ( isset( $currency_settings['ims_currency_symbol'] ) && ! empty( $currency_settings['ims_currency_symbol'] ) ) {
		$currency_symbol = $currency_settings['ims_currency_symbol'];
	}

	if ( is_array( $inspiry_memberships ) && ! empty( $inspiry_memberships ) ) {
		$package_count = count( $inspiry_memberships );

		$package_column_class = 'col-lg-4';
		if ( $package_count > 3 && 0 === $package_count % 2 ) {
			$package_column_class .= ' col-xl-3';
		}
		?>
		<div class="row row-membership-packages">
			<?php
			foreach ( $inspiry_memberships as $inspiry_membership ) :

				$package_id = $inspiry_membership['ID'];

				$is_popular = false;
				if ( isset( $inspiry_membership['is_popular'] ) && ! empty( $inspiry_membership['is_popular'] ) ) {
					$is_popular = true;
				}

				$popular_class = '';
				if ( $is_popular ) {
					$popular_class = 'popular';
				}
				?>
				<div class="col-membership-package col-sm-6 <?php echo esc_attr( $package_column_class ); ?>">
					<div class="membership-package <?php echo esc_attr( $popular_class ); ?>">
						<?php
						if ( $is_popular ) {
							printf( '<div class="membership-package-popular-tag"><span>%s</span></div>', esc_html__( 'Popular', 'framework' ) );
						}
						?>
						<div class="membership-package-top">
							<?php
							if ( isset( $inspiry_membership['title'] ) && ! empty( $inspiry_membership['title'] ) ) :
								?>
								<h4 class="membership-package-title">
									<?php echo esc_html( $inspiry_membership['title'] ); ?>
								</h4>
								<?php
							endif;

							$text_before_price = get_option( 'inspiry_text_before_price', esc_html__( 'Starting at', 'framework' ) );
							if ( ! empty( $text_before_price ) ) :
								?>
								<span class="membership-package-starting-at"><?php echo esc_html( $text_before_price ); ?></span>
								<?php
							endif;

							$duration_unit = '';
							if ( isset( $inspiry_membership['duration_unit'] ) && ! empty( $inspiry_membership['duration_unit'] ) ) {
								if ( '1' === $inspiry_membership['duration'] ) {
									$duration_unit = rtrim( $inspiry_membership['duration_unit'], 's' );
									if ( 'day' === $duration_unit ) {
										$duration_unit = esc_html__( 'day', 'framework' );
									} elseif ( 'week' === $duration_unit ) {
										$duration_unit = esc_html__( 'week', 'framework' );
									} elseif ( 'month' === $duration_unit ) {
										$duration_unit = esc_html__( 'mo', 'framework' );
									} else {
										$duration_unit = esc_html__( 'yr', 'framework' );
									}
								}
							}

							if ( isset( $inspiry_membership['format_price'] ) && ! empty( $inspiry_membership['format_price'] ) && ( 0 < $inspiry_membership['price'] ) ) {
								if ( ! empty( $currency_symbol ) ) {
									printf( '<p class="membership-package-price"><span class="currency-symbol">%s</span><strong>%s</strong><span class="duration-unit">%s</span></p>', esc_html( $currency_symbol ), esc_html( $inspiry_membership['price'] ), esc_html( $duration_unit ) );
								}
							} else {
								if ( ! empty( $currency_symbol ) ) {
									printf( '<p class="membership-package-price"><span class="currency-symbol">%s</span><strong>%s</strong><span class="duration-unit">%s</span></p>', esc_html( $currency_symbol ), esc_html__( '0', 'framework' ), esc_html( $duration_unit ) );
								}
							}

							$description = get_the_excerpt( $package_id );
							if ( ! empty( $description ) ) {
								printf( '<p class="description">%s</p>', esc_html( $description ) );
							}
							?>
						</div>
						<div class="membership-package-bottom">
							<?php

							// Get current membership data.
							$user_has_membership   = inspiry_has_user_membership();
							$current_membership_id = get_user_meta( get_current_user_id(), 'ims_current_membership', true );

							if ( $user_has_membership && intval( $current_membership_id ) === intval( $package_id ) ) {
								?>
									<a class="btn btn-primary btn-select-package current-package">
									<?php
									$button_label = get_option( 'inspiry_current_package_btn_text' );
									if ( empty( $button_label ) ) {
										$button_label = esc_html__( 'Current Package', 'framework' );
									}
									echo esc_html( $button_label );
									?>
									</a>
								<?php
							} else {
								$button_label = get_option( 'inspiry_package_btn_text' );
								if ( empty( $button_label ) ) {
									$button_label = esc_html__( 'Get Started', 'framework' );
								}

								if ( realhomes_is_wc_ims_payment_enabled() ) {
									?>
									<a class="btn btn-primary btn-select-package package-woo-payment" data-package-id="<?php echo esc_attr( $package_id ); ?>">
									<?php
									echo esc_html( $button_label );
									?>
									</a>
									<?php
								} else {
									$membership_checkout_url = realhomes_get_dashboard_page_url(
										'membership',
										array(
											'submodule'  => 'checkout',
											'package_id' => $package_id,
										)
									);
									?>
									<a class="btn btn-primary btn-select-package" href="<?php echo esc_url( $membership_checkout_url ); ?>">
									<?php
									echo esc_html( $button_label );
									?>
									</a>
									<?php
								}
							}

							if ( $inspiry_membership['duration'] > 0 ) {
								$duration_unit = ( isset( $inspiry_membership['duration_unit'] ) ) ? $inspiry_membership['duration_unit'] : false;
								if ( '1' === $inspiry_membership['duration'] ) {
									if ( 'days' === $duration_unit ) {
										$duration_unit = esc_html__( 'Day', 'framework' );
									} elseif ( 'weeks' === $duration_unit ) {
										$duration_unit = esc_html__( 'Week', 'framework' );
									} elseif ( 'months' === $duration_unit ) {
										$duration_unit = esc_html__( 'Month', 'framework' );
									} else {
										$duration_unit = esc_html__( 'Year', 'framework' );
									}
								} else {
									if ( 'days' === $duration_unit ) {
										$duration_unit = esc_html__( 'Days', 'framework' );
									} elseif ( 'weeks' === $duration_unit ) {
										$duration_unit = esc_html__( 'Weeks', 'framework' );
									} elseif ( 'months' === $duration_unit ) {
										$duration_unit = esc_html__( 'Months', 'framework' );
									} else {
										$duration_unit = esc_html__( 'Years', 'framework' );
									}
								}
								printf( '<p><i class="fas fa-clock"></i><strong>%s</strong> %s %s</p>', esc_html( $inspiry_membership['duration'] ), esc_html( $duration_unit ), esc_html__( 'Time Duration', 'framework' ) );
							}

							if ( isset( $inspiry_membership['properties'] ) && ! empty( $inspiry_membership['properties'] ) ) {
								printf( '<p><i class="fas fa-building"></i><strong>%s</strong> %s</p>', esc_html( $inspiry_membership['properties'] ), esc_html__( 'Properties Allowed', 'framework' ) );
							}

							if ( isset( $inspiry_membership['featured_prop'] ) && ! empty( $inspiry_membership['featured_prop'] ) ) {
								printf( '<p><i class="fas fa-star"></i><strong>%s</strong> %s</p>', esc_html( $inspiry_membership['featured_prop'] ), esc_html__( 'Featured Properties', 'framework' ) );
							}
							?>
						</div>
					</div>
				</div>
				<?php
			endforeach;
			?>
		</div>
		<?php
	} else {
		realhomes_dashboard_notice( esc_html__( 'No Package Found!', 'framework' ) );
	}
	?>
</div><!-- #dashboard-membership-packages -->
