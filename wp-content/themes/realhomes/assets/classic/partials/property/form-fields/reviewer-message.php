<?php
/*
 * Message to reviewer
 */
$target_email = get_option('theme_submit_notice_email');
if (!empty($target_email)) {
    ?>
	<div class="form-option reviewer-message-field-wrapper">
		<label for="message_to_reviewer"><?php esc_html_e('Message to the Reviewer', 'framework'); ?></label>
		<textarea name="message_to_reviewer" id="message_to_reviewer" cols="30" rows="3"></textarea>
	</div>
	<?php

}