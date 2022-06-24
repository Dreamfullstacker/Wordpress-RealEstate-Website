<div class="form-option submit-field-wrapper">
	<?php
    wp_nonce_field('submit_property', 'property_nonce');

    if (inspiry_is_edit_property()) {
        global $target_property; ?>
		<input type="hidden" name="action" value="update_property"/>
		<input type="hidden" name="property_id" value="<?php echo esc_attr($target_property->ID); ?>"/>
		<input type="submit" value="<?php esc_html_e('Update Property', 'framework'); ?>" class="real-btn" />
		<?php

    } else {
        ?>
		<input type="hidden" name="action" value="add_property"/>
		<input type="submit" value="<?php esc_html_e('Submit Property', 'framework'); ?>" class="real-btn" />
		<?php

    }
    ?>
</div>
