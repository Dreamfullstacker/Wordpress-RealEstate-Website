<?php
$order_id       = '';
$order_title    = esc_html__( 'Order ID', 'framework' );
$payment_method = '';
$show_thanks    = false;

if ( ( isset( $_GET['membership'] ) && 'successful' === $_GET['membership'] ) || ( isset( $_POST['order_id'] ) && ! empty( $_POST['order_id'] ) ) || ( isset( $_GET['order_id'] ) && ! empty( $_GET['order_id'] ) ) ) {
	$show_thanks = true;
	if ( ! empty( $_POST['order_id'] ) ) {
		$order_id = $_POST['order_id'];
	} elseif ( ! empty( $_GET['order_id'] ) ) {
		$order_id = $_GET['order_id'];
	}
} else {
	$order_title = esc_html__( 'Error', 'framework' );
	$order_id    = esc_html__( 'Failed to process order!', 'framework' );
}

$package_id = '';
if ( isset( $_POST['package_id'] ) || isset( $_GET['package_id'] ) ) {
	if ( ! empty( $_POST['package_id'] ) ) {
		$package_id = $_POST['package_id'];
	} elseif ( ! empty( $_GET['package_id'] ) ) {
		$package_id = $_GET['package_id'];
	}
}

$payment_method = '';
if ( isset( $_POST['payment_method'] ) || isset( $_GET['payment_method'] ) ) {
	if ( ! empty( $_POST['payment_method'] ) ) {
		$payment_method = $_POST['payment_method'];
	} elseif ( ! empty( $_GET['payment_method'] ) ) {
		$payment_method = $_GET['payment_method'];
	}
}
?>
<div class="order-completed">
	<?php
	if ( $show_thanks ) :
		$dialog_heading = get_option( 'inspiry_order_dialog_heading', esc_html__( 'Thank you!', 'framework' ) );
		if ( ! empty( $dialog_heading ) ) :
			?>
            <div class="check-box"><i class="fas fa-check"></i></div>
            <h3 class="thankyou-text"><?php echo esc_html( $dialog_heading ); ?></h3>
		<?php
		endif;
	endif;
	?>
    <div class="order-details dl-list">
		<?php
		if ( ! empty( $order_id ) ) :
			?>
            <dl class="order-id-wrap">
                <dt><?php echo esc_html( $order_title ); ?></dt>
                <dd><?php echo esc_html( $order_id ); ?></dd>
            </dl>
		<?php
		endif;

		if ( ! empty( $package_id ) ) :
			$package_id = intval( $package_id );
			$package = ims_get_membership_object( $package_id );
			$package_title = get_the_title( $package_id );
			$price = $package->get_price();
			if ( ! empty( $package_title ) ) {
				?>
                <dl class="pacakge-title-wrap">
                    <dt><?php esc_html_e( 'Package', 'framework' ); ?></dt>
                    <dd><?php echo esc_html( $package_title ); ?></dd>
                </dl>
				<?php
			}
			?>
            <dl class="amount-wrap">
                <dt><?php esc_html_e( 'Amount', 'framework' ); ?></dt>
                <dd class="amount">
					<?php
					if ( ! empty( $price ) ) {
						$duration      = $package->get_duration();
						$duration_unit = $package->get_duration_unit();

						if ( $duration < 2 ) {

							$duration_unit = rtrim( $duration_unit, 's' );
							if ( 'day' === $duration_unit ) {
								$duration_unit = esc_html__( 'day', 'framework' );
							} elseif ( 'week' === $duration_unit ) {
								$duration_unit = esc_html__( 'week', 'framework' );
							} elseif ( 'month' === $duration_unit ) {
								$duration_unit = esc_html__( 'mo', 'framework' );
							} else {
								$duration_unit = esc_html__( 'yr', 'framework' );
							}

							$duration_unit = sprintf( '/%s', esc_html( $duration_unit ) );

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

							$duration_unit = sprintf( ' for %s %s', esc_html( $duration ), esc_html( $duration_unit ) );
						}

						printf( '%s%s', esc_html( $package->get_formatted_price() ), esc_html( $duration_unit ) );
					} else {
						$currency_symbol   = '';
						$currency_settings = get_option( 'ims_basic_settings' );
						if ( isset( $currency_settings['ims_currency_symbol'] ) && ! empty( $currency_settings['ims_currency_symbol'] ) ) {
							$currency_symbol = $currency_settings['ims_currency_symbol'];
						}
						printf( '%s%s', esc_html( $currency_symbol ), esc_html__( '0', 'framework' ) );
					}
					?>
                </dd>
            </dl>
			<?php
			if ( ! empty( $payment_method ) && ! empty( $price ) ) :
				$payment_method = sanitize_text_field( $payment_method );
				$payment_method_title = esc_html__( 'Direct Bank Transfer', 'framework' );
				if ( 'paypal' === $payment_method ) {
					$payment_method_title = esc_html__( 'PayPal', 'framework' );
				} elseif ( 'stripe' === $payment_method ) {
					$payment_method_title = esc_html__( 'Stripe', 'framework' );
				}
				?>
                <dl class="payment-method-wrap">
                    <dt><?php esc_html_e( 'Payment Method', 'framework' ); ?></dt>
                    <dd><?php echo esc_html( $payment_method_title ); ?></dd>
                </dl>
			<?php
			endif;

			// Direct Bank Transfer Payment Method
			if ( 'direct_bank' === $payment_method && ! empty( $price ) ) {
				$wire_settings = get_option( 'ims_wire_settings' );
				if ( ! empty( $wire_settings['ims_wire_enable'] ) && 'on' === $wire_settings['ims_wire_enable'] ) : ?>
                    <div class="payment-instructions">
						<?php
						if ( isset( $wire_settings['ims_wire_transfer_instructions'] ) && ! empty( $wire_settings['ims_wire_transfer_instructions'] ) ) {
							echo '<p>' . esc_html( $wire_settings['ims_wire_transfer_instructions'] ) . '</p>';
						}

						if ( isset( $wire_settings['ims_wire_account_name'] ) && ! empty( $wire_settings['ims_wire_account_name'] ) ) {
							echo '<p class="account-name"><span>' . esc_html__( 'Account Name: ', 'framework' ) . '</span><strong>' . esc_html( $wire_settings['ims_wire_account_name'] ) . '</strong></p>';
						}

						if ( isset( $wire_settings['ims_wire_account_number'] ) && ! empty( $wire_settings['ims_wire_account_number'] ) ) {
							echo '<p class="account-number"><span>' . esc_html__( 'Account Number: ', 'framework' ) . '</span><strong>' . esc_html( $wire_settings['ims_wire_account_number'] ) . '</strong></p>';
						}
						?>
                    </div>
				<?php endif;
			}

		endif;
		?>
    </div>
</div>