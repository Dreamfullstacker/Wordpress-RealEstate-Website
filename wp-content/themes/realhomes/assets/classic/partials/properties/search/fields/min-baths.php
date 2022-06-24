<?php
/**
 * Minimum Baths Field
 */
?>
<div class="option-bar rh-search-field rh_classic_baths_field small">
    <label for="select-bathrooms">
		<?php
		$inspiry_min_baths_label = get_option( 'inspiry_min_baths_label' );
		echo !empty( $inspiry_min_baths_label ) ? esc_html( $inspiry_min_baths_label ): esc_html__( 'Min Baths', 'framework' );
		?>
    </label>
    <span class="selectwrap">
        <select name="bathrooms" id="select-bathrooms" class="inspiry_select_picker_trigger show-tick">
            <?php inspiry_min_baths(); ?>
        </select>
    </span>
</div>