<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$inspiry_gdpr                 = $this->get_option( 'inspiry_gdpr', '0' );
$inspiry_gdpr_label           = $this->get_option( 'inspiry_gdpr_label', esc_html__( 'GDPR Agreement', 'easy-real-estate' ) );
$inspiry_gdpr_text            = $this->get_option( 'inspiry_gdpr_text', esc_html__( 'I consent to having this website store my submitted information so they can respond to my inquiry.', 'easy-real-estate' ), 'textarea' );
$inspiry_gdpr_validation_text = $this->get_option( 'inspiry_gdpr_validation_text', esc_html__( '* Please accept GDPR agreement', 'easy-real-estate' ) );
$inspiry_gdpr_in_email        = $this->get_option( 'inspiry_gdpr_in_email', '0' );

if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'inspiry_ere_settings' ) ) {
	update_option( 'inspiry_gdpr', $inspiry_gdpr );
	update_option( 'inspiry_gdpr_label', $inspiry_gdpr_label );
	update_option( 'inspiry_gdpr_text', $inspiry_gdpr_text );
	update_option( 'inspiry_gdpr_validation_text', $inspiry_gdpr_validation_text );
	update_option( 'inspiry_gdpr_in_email', $inspiry_gdpr_in_email );
	$this->notice();
}
?>
<div class="inspiry-ere-page-content">
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><?php esc_html_e( 'Add GDPR agreement checkbox in forms across website?', 'easy-real-estate' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php esc_html_e( 'Add GDPR agreement checkbox in forms across website?', 'easy-real-estate' ); ?></span></legend>
                        <label>
                            <input type="radio" name="inspiry_gdpr" value="1" <?php checked( $inspiry_gdpr, '1' ) ?>>
                            <span><?php esc_html_e( 'Yes', 'easy-real-estate' ); ?></span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="inspiry_gdpr" value="0" <?php checked( $inspiry_gdpr, '0' ) ?>>
                            <span><?php esc_html_e( 'No', 'easy-real-estate' ); ?></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_gdpr_label"><?php esc_html_e( 'GDPR agreement checkbox label', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_gdpr_label" type="text" id="inspiry_gdpr_label" value="<?php echo esc_attr( $inspiry_gdpr_label ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_gdpr_text"><?php esc_html_e( 'GDPR agreement checkbox text', 'easy-real-estate' ); ?></label></th>
                <td><textarea name="inspiry_gdpr_text" rows="6" cols="40" id="inspiry_gdpr_text" class="code"><?php
                        echo wp_kses( $inspiry_gdpr_text, array(
                            'a' => array(
                                'class'  => array(),
                                'href'   => array(),
                                'target' => array(),
                                'title'  => array()
                            ),
                            'br' => array(),
                            'em' => array(),
                            'strong' => array(),
                        ) );
                        ?></textarea>
                    <p class="description"><?php esc_html_e( 'You can use <a>,<br>,<em> and <strong> tags in your GDPR agreement text.', 'easy-real-estate' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_gdpr_validation_text"><?php esc_html_e( 'GDPR agreement checkbox validation message', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_gdpr_validation_text" type="text" id="inspiry_gdpr_validation_text" value="<?php echo esc_attr( $inspiry_gdpr_validation_text ); ?>" class="regular-text code"></td>
            </tr>
            <th scope="row"><?php esc_html_e( 'Add GDPR detail in resulting email?', 'easy-real-estate' ); ?></th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php esc_html_e( 'Add GDPR detail in resulting email?', 'easy-real-estate' ); ?></span></legend>
                    <label>
                        <input type="radio" name="inspiry_gdpr_in_email" value="1" <?php checked( $inspiry_gdpr_in_email, '1' ) ?>>
                        <span><?php esc_html_e( 'Yes', 'easy-real-estate' ); ?></span>
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="inspiry_gdpr_in_email" value="0" <?php checked( $inspiry_gdpr_in_email, '0' ) ?>>
                        <span><?php esc_html_e( 'No', 'easy-real-estate' ); ?></span>
                    </label>
                </fieldset>
            </td>
            </tr>
            </tbody>
        </table>
        <div class="submit">
            <?php wp_nonce_field('inspiry_ere_settings'); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'easy-real-estate' ); ?>">
        </div>
    </form>
</div>