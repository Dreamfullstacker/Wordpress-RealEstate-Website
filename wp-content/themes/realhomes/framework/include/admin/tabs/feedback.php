<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_user = wp_get_current_user();
?>
<?php $this->header('feedback'); ?>
<div class="inspiry-page-inner-wrap inspiry-feedback-content-wrap">
<!--    <h2 class="inspiry-title">--><?php //esc_html_e( 'Feedback', 'framework' ); ?><!--</h2>-->
    <div class="description">
        <p><?php esc_html_e( 'Want something to be added or improved in RealHomes? Let us know about it!', 'framework' ); ?></p>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="inspiry-postbox postbox">
                <div class="inspiry-postbox-header">
                    <h2 class="title"><span aria-hidden="true" class="dashicons dashicons-welcome-write-blog"></span><?php esc_html_e( 'Feedback Form', 'framework' ); ?></h2>
                </div>
                <div class="inspiry-postbox-inside inside">
                    <form id="inspiry-feedback-form" class="inspiry-feedback-form" method="post">
                        <p class="field-wrap text-wrap">
                            <label for="inspiry-feedback-form-email"><?php esc_html_e( 'Your Email', 'framework' ); ?> <strong>*</strong></label>
                            <input type="email" name="inspiry_feedback_form_email" id="inspiry-feedback-form-email" class="inspiry-form-field-email required" value="<?php echo esc_attr( $current_user->user_email ); ?>">
                        </p>
                        <p class="field-wrap textarea-wrap">
                            <label for="inspiry-feedback-form-textarea"><?php esc_html_e( 'Feedback Details', 'framework' ); ?> <strong>*</strong></label>
                            <textarea name="inspiry_feedback_form_textarea" id="inspiry-feedback-form-textarea" class="inspiry-feedback-form-textarea"></textarea>
                            <small class="inspiry-form-required-items"><?php printf( esc_html__( 'Fields marked with an %s are required.', 'framework' ), '<strong>*</strong>' ); ?></small>
                        </p>
                        <p class="field-wrap submit-wrap">
			                <?php wp_nonce_field( 'inspiry_feedback_form_action', 'inspiry_feedback_form_nonce' ); ?>
                            <input type="hidden" name="action" value="inspiry_send_feedback">
                            <input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Send Feedback', 'framework' ); ?>">
                        </p>
                        <p id="inspiry-feedback-form-success" class="inspiry-feedback-form-success"></p>
                        <p id="inspiry-feedback-form-error" class="inspiry-feedback-form-error"></p>
                    </form>
                </div>
                <div class="inspiry-postbox-footer"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->footer('feedback'); ?>