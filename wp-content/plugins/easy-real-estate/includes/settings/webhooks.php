<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ere_forms_webhook_url                = $this->get_option( 'ere_forms_webhook_url' );
$ere_contact_form_webhook_integration = isset( $_POST['ere_contact_form_webhook_integration'] ) ? $_POST['ere_contact_form_webhook_integration'] : '0';
$ere_agent_form_webhook_integration   = isset( $_POST['ere_agent_form_webhook_integration'] ) ? $_POST['ere_agent_form_webhook_integration'] : '0';
$ere_agency_form_webhook_integration  = isset( $_POST['ere_agency_form_webhook_integration'] ) ? $_POST['ere_agency_form_webhook_integration'] : '0';
if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'inspiry_ere_settings' ) ) {
	update_option( 'ere_forms_webhook_url', $ere_forms_webhook_url );
	update_option( 'ere_contact_form_webhook_integration', $ere_contact_form_webhook_integration );
	update_option( 'ere_agent_form_webhook_integration', $ere_agent_form_webhook_integration );
	update_option( 'ere_agency_form_webhook_integration', $ere_agency_form_webhook_integration );
	$this->notice();
}
?>
<div class="inspiry-ere-page-content">
    <div class="description">
        <p><?php esc_html_e( 'You can use the Webhooks settings below to feed forms data to services like Zapier. For example you can use Zapier Webhooks to create leads in Zoho CRM.', 'easy-real-estate' ); ?></p>
    </div>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="ere_forms_webhook_url"><?php esc_html_e( 'Webhook URL', 'easy-real-estate' ); ?></label></th>
                <td><input name="ere_forms_webhook_url" type="text" id="ere_forms_webhook_url" value="<?php echo esc_url( $ere_forms_webhook_url ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td>
                    <label for="ere_contact_form_webhook_integration">
                        <input name="ere_contact_form_webhook_integration" type="checkbox" id="ere_contact_form_webhook_integration" value="1" <?php checked( '1', get_option( 'ere_contact_form_webhook_integration', '0' ) ); ?>>
			            <strong><?php esc_html_e( 'Integrate Contact Form', 'easy-real-estate' ); ?></strong>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td>
                    <label for="ere_agent_form_webhook_integration">
                        <input name="ere_agent_form_webhook_integration" type="checkbox" id="ere_agent_form_webhook_integration" value="1" <?php checked( '1', get_option( 'ere_agent_form_webhook_integration', '0' ) ); ?>>
                        <strong><?php esc_html_e( 'Integrate Agent Form', 'easy-real-estate' ); ?></strong>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row"></th>
                <td>
                    <label for="ere_agency_form_webhook_integration">
                        <input name="ere_agency_form_webhook_integration" type="checkbox" id="ere_agency_form_webhook_integration" value="1" <?php checked( '1', get_option( 'ere_agency_form_webhook_integration', '0' ) ); ?>>
                        <strong><?php esc_html_e( 'Integrate Agency Form', 'easy-real-estate' ); ?></strong>
                    </label>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="submit">
			<?php wp_nonce_field( 'inspiry_ere_settings' ); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'easy-real-estate' ); ?>">
        </div>
    </form>
</div>