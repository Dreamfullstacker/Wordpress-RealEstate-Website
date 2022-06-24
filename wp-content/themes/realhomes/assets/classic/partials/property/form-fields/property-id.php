<div class="form-option property-id-field-wrapper">
	<label for="property-id"><?php esc_html_e('Property ID', 'framework'); ?></label>
	<input id="property-id" name="property-id" type="text" value="<?php
    if (inspiry_is_edit_property()) {
        global $post_meta_data;
        if (isset($post_meta_data[ 'REAL_HOMES_property_id' ])) {
            echo esc_attr($post_meta_data[ 'REAL_HOMES_property_id' ][ 0 ]);
        }
    } else {
        $auto_property_id        = get_option('inspiry_auto_property_id_check');
        $property_id_pattern    = get_option('inspiry_auto_property_id_pattern');
        if (! empty($auto_property_id) && ('true' === $auto_property_id) && ! empty($property_id_pattern)) {
            echo esc_attr($property_id_pattern);
        }
    }
    ?>" title="<?php esc_html_e('Property ID', 'framework'); ?>"
	<?php echo ((! empty($auto_property_id) && ('true' === $auto_property_id)) || isset($post_meta_data[ 'REAL_HOMES_property_id' ])) ? 'disabled' : ''; ?> />
</div>
