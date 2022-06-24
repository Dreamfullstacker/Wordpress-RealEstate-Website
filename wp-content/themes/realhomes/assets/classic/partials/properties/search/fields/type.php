<?php
/**
 * Property Types Field
 */
?>
<div class="option-bar rh-search-field rh_classic_type_field small">
    <label for="select-property-type">
		<?php
        $inspiry_property_type_label = get_option( 'inspiry_property_type_label' );
        if ( ! empty( $inspiry_property_type_label ) ) {
            echo esc_html( $inspiry_property_type_label );
        } else {
	        esc_html_e( 'Property Type', 'framework' );
        }
        ?>
    </label>
    <span class="selectwrap">
       		<select name="type[]"
                    id="select-property-type"
                    class="inspiry_select_picker_trigger show-tick"
                    data-selected-text-format="count > 2"
                    data-actions-box="true"
                    data-size="5"
                    <?php
                    $inspiry_search_form_multiselect_types = get_option( 'inspiry_search_form_multiselect_types', 'yes' );
                    if ( 'yes' == $inspiry_search_form_multiselect_types ) {
                        ?>
                        multiple
                        <?php
                    }
                    ?>
                    title="<?php
	                if ( ! empty( get_option( 'inspiry_property_type_placeholder' ) ) ) {
		                echo esc_attr( get_option( 'inspiry_property_type_placeholder' ) );
	                } else {
		                esc_attr_e( 'All Types', 'framework' );
	                } ?>"
                    data-count-selected-text="{0} <?php
	                $types_counter_placeholder = get_option('inspiry_property_types_counter_placeholder');
	                if(!empty($types_counter_placeholder)){
		                echo esc_html($types_counter_placeholder);
	                }else{
		                esc_attr_e( ' Types Selected ', 'framework' );
	                }
	                ?>"
            >
	        <?php realhomes_hierarchical_options( 'property-type' ); ?>
        </select>
    </span>
</div>