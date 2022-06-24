<?php
/**
 * Field: Reviewer Message
 *
 * @since    3.0.0
 * @package realhomes/dashboard
 */
$target_email = get_option( 'theme_submit_notice_email' );
if ( ! empty( $target_email ) ) {
	?>
    <div class="reviewer-message-field-wrapper">
        <p>
            <label for="message_to_reviewer"><?php esc_html_e( 'Message to the Reviewer', 'framework' ); ?></label>
            <textarea name="message_to_reviewer" id="message_to_reviewer" cols="30" rows="8"></textarea>
        </p>
    </div>
	<?php
}