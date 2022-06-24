<div class="form-option price-postfix-field-wrapper">
	<label for="price-postfix"><?php esc_html_e('Price Postfix Text', 'framework'); ?></label>
	<input id="price-postfix" name="price-postfix" type="text" value="<?php
    if (inspiry_is_edit_property()) {
        global $post_meta_data;
        if (isset($post_meta_data[ 'REAL_HOMES_property_price_postfix' ])) {
            echo esc_attr($post_meta_data[ 'REAL_HOMES_property_price_postfix' ][ 0 ]);
        }
    }
    ?>"/>
</div>
