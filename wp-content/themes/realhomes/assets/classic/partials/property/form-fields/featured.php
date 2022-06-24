<div class="form-option checkbox-option clearfix featured-field-wrapper">
	<input id="featured" name="featured" type="checkbox" <?php
    if (inspiry_is_edit_property()) {
        global $post_meta_data;
        if (isset($post_meta_data[ 'REAL_HOMES_featured' ]) && ($post_meta_data[ 'REAL_HOMES_featured' ][ 0 ] == 1)) {
            echo 'checked';
        }
    }
    ?> />
	<label for="featured"><?php esc_html_e('Mark this property as featured property', 'framework'); ?></label>
</div>
