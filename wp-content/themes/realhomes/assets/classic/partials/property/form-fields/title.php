<div class="form-option title-field-wrapper">
	<label for="inspiry_property_title"><?php esc_html_e('Property Title', 'framework'); ?></label>
	<input id="inspiry_property_title" name="inspiry_property_title" type="text" class="required" value="<?php
    if (inspiry_is_edit_property()) {
        global $target_property;
        echo esc_attr($target_property->post_title);
    }
    ?>" title="<?php esc_html_e('* Please provide property title!', 'framework'); ?>" autofocus required/>
</div>