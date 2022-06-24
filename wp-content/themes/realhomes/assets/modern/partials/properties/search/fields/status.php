<?php
/**
 * Field: Property Status
 *
 * Property Status field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_prop_search__option rh_prop_search__select rh_status_field_wrapper inspiry_select_picker_field">
    <label for="select-status">
		<?php
		$inspiry_property_status_label = get_option( 'inspiry_property_status_label' );
		if ( !empty( $inspiry_property_status_label ) ) {
			echo esc_html( $inspiry_property_status_label );
		} else {
			echo esc_html__( 'Property Status', 'framework' );
		}
		?>
    </label>
    <span class="rh_prop_search__selectwrap">
		<select name="status" id="select-status" class="inspiry_select_picker_trigger inspiry_select_picker_status show-tick" data-size="5">
			<?php realhomes_hierarchical_options( 'property-status' ); ?>
		</select>
	</span>
</div>
