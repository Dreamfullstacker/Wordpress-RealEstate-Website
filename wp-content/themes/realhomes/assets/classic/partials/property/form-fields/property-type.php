<div class="form-option property-type-field-wrapper">
    <label for="type"><?php esc_html_e( 'Type', 'framework' ); ?></label>
    <span class="selectwrap">
        <select name="type[]"
            id="type"
            class="inspiry_select_picker_trigger show-tick"
            title="<?php esc_attr_e( 'None', 'framework' ); ?>"
            <?php
            $inspiry_search_form_multiselect_types = get_option( 'inspiry_search_form_multiselect_types', 'yes' );
            if ( 'yes' == $inspiry_search_form_multiselect_types ) {
                ?>
                multiple="multiple"
                data-count-selected-text="{0} <?php esc_attr_e( ' Types Selected ', 'framework' ); ?>"
                data-selected-text-format="count > 2"
                <?php
            }
            ?> >
            <?php
            if ( inspiry_is_edit_property() ) {
                global $target_property;
                realhomes_edit_form_hierarchical_options( $target_property->ID, 'property-type' );
            } else {
                if ( 'no' == $inspiry_search_form_multiselect_types ) {
                    ?><option selected="selected" value="-1"><?php esc_html_e( 'None', 'framework' ); ?></option><?php
                }

	            if ( class_exists( 'ERE_Data' ) ) {
		            realhomes_id_based_hierarchical_options( ERE_Data::get_hierarchical_property_types(), -1 );
	            }
            }
            ?>
        </select>
    </span>
</div>
