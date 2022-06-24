<?php
/**
 * Property Status Field
 */
?>
<div class="option-bar rh-search-field rh_classic_status_field small">
    <label for="select-status">
		<?php
		$inspiry_property_status_label = get_option( 'inspiry_property_status_label' );
		echo ! empty( $inspiry_property_status_label ) ? esc_html( $inspiry_property_status_label ) : esc_html__( 'Property Status', 'framework' );
		?>
    </label>
    <span class="selectwrap">
        <select name="status" id="select-status" class="inspiry_select_picker_trigger inspiry_select_picker_status show-tick">
            <?php realhomes_hierarchical_options( 'property-status' ); ?>
        </select>
    </span>
</div>