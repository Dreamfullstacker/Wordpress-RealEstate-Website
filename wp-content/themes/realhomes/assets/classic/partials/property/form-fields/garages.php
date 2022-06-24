<div class="form-option garages-field-wrapper">
	<label for="garages"><?php esc_html_e('Garages', 'framework'); ?></label>
	<input id="garages" name="garages" type="text" value="<?php
    if (inspiry_is_edit_property()) {
        global $post_meta_data;
        if (isset($post_meta_data[ 'REAL_HOMES_property_garage' ])) {
            echo esc_attr($post_meta_data[ 'REAL_HOMES_property_garage' ][ 0 ]);
        }
    }
    ?>" title="<?php esc_html_e('* Please provide the value in only digits!', 'framework'); ?>"/>

</div>
