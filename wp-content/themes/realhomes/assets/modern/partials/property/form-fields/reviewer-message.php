<?php
/**
 * Field: Reviewer Message
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

$target_email = get_option( 'theme_submit_notice_email' );
if ( ! empty( $target_email ) ) {
	?>
	<div class="rh_form__item rh_form--1-column rh_form--columnAlign reviewer-message-field-wrapper">
		<label for="message_to_reviewer"><?php esc_html_e( 'Message to the Reviewer', 'framework' ); ?></label>
		<textarea name="message_to_reviewer" id="message_to_reviewer" cols="30" rows="3"></textarea>
	</div>
	<?php

}
