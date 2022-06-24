<?php
/**
 *
 * Field: Guests
 *
 * Guests field for advance property search.
 *
 * @package realhomes/modern
 */

?>
<div class="rh_prop_search__option rh_prop_search__select inspiry_select_picker_field">
	<label for="rvr-guests">
		<?php
		$guest_label = get_option( 'inspiry_guests_label' );
		if ( ! empty( $guest_label ) ) {
			echo esc_html( $guest_label );
		} else {
			echo esc_html__( 'Guests', 'framework' );
		}
		?>
	</label>
	<span class="rh_prop_search__selectwrap">
		<select name="guests" id="rvr-guests" class="inspiry_select_picker_trigger show-tick">
			<?php inspiry_min_guests(); ?>
		</select>
	</span>
</div>
