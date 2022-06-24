<div class="form-option area-field-wrapper">
	<label for="size"><?php esc_html_e('Area', 'framework'); ?></label>
	<input id="size" name="size" type="text" value="<?php
    if (inspiry_is_edit_property()) {
        global $post_meta_data;
        if (isset($post_meta_data[ 'REAL_HOMES_property_size' ])) {
            echo esc_attr($post_meta_data[ 'REAL_HOMES_property_size' ][ 0 ]);
        }
    } ?>" title="<?php esc_html_e('* Please provide the value in only digits!', 'framework'); ?>"/>
</div>
