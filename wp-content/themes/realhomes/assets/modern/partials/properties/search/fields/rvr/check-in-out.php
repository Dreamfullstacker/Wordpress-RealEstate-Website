<?php
/**
 * Field: Check-In & Check-Out
 *
 * Check-In & Check-Out field for advance property search.
 * @package realhomes/modern
 */
?>
<div class="rh_prop_search__option rvr_check_in rh_mod_text_field">
	<label for="rvr-check-in-search">
	<?php
	$checkin_label = get_option( 'inspiry_checkin_label' );
	if ( ! empty( $checkin_label ) ) {
		echo esc_html( $checkin_label );
	} else {
		echo esc_html__( 'Check In', 'framework' );
	}
	?>
	</label>
	<?php
	$checkin_placeholder_text = get_option( 'inspiry_checkin_placeholder_text' );
	if ( empty( $checkin_placeholder_text ) ) {
		$checkin_placeholder_text = rh_any_text();
	}
	?>
	<input type="text" name="check-in" id="rvr-check-in-search" value="<?php echo ! empty( $_GET['check-in'] ) ? esc_attr( $_GET['check-in'] ) : ''; ?>" placeholder="<?php echo esc_attr( $checkin_placeholder_text ); ?>" autocomplete="off" />
</div>

<div class="rh_prop_search__option rvr_check_out rh_mod_text_field">
	<label for="rvr-check-out-search">
	<?php
	$checkout_label = get_option( 'inspiry_checkout_label' );
	if ( ! empty( $checkout_label ) ) {
		echo esc_html( $checkout_label );
	} else {
		echo esc_html__( 'Check Out', 'framework' );
	}
	?>
	</label>
	<?php
	$checkout_placeholder_text = get_option( 'inspiry_checkout_placeholder_text' );
	if ( empty( $checkout_placeholder_text ) ) {
		$checkout_placeholder_text = rh_any_text();
	}
	?>
	<input type="text" name="check-out" id="rvr-check-out-search" value="<?php echo ! empty( $_GET['check-out'] ) ? esc_attr( $_GET['check-out'] ) : ''; ?>" placeholder="<?php echo esc_attr( $checkout_placeholder_text ); ?>" autocomplete="off" />
</div>
