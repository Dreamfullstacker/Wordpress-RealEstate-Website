<div class="form-option price-field-wrapper">
	<label for="price"><?php esc_html_e('Sale OR Rent Price', 'framework'); ?></label>
	<input id="price" name="price" type="text" value="<?php
    if (inspiry_is_edit_property()) {
        global $post_meta_data;
        if (isset($post_meta_data[ 'REAL_HOMES_property_price' ])) {
            echo esc_attr($post_meta_data[ 'REAL_HOMES_property_price' ][ 0 ]);
        }
    }
    ?>" title="<?php esc_html_e('* Please provide the value in only digits!', 'framework'); ?>"/>
</div>
