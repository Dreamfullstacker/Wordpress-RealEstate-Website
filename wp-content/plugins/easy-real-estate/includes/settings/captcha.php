<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_show_reCAPTCHA        = $this->get_option( 'theme_show_reCAPTCHA', 'false' );
$theme_recaptcha_public_key  = $this->get_option( 'theme_recaptcha_public_key' );
$theme_recaptcha_private_key = $this->get_option( 'theme_recaptcha_private_key' );
$theme_recaptcha_type        = $this->get_option( 'inspiry_reCAPTCHA_type', 'v2' );

if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'inspiry_ere_settings' ) ) {
	update_option( 'theme_show_reCAPTCHA', $theme_show_reCAPTCHA );
	update_option( 'theme_recaptcha_public_key', $theme_recaptcha_public_key );
	update_option( 'theme_recaptcha_private_key', $theme_recaptcha_private_key );
	update_option( 'inspiry_reCAPTCHA_type', $theme_recaptcha_type );
	$this->notice();
}
?>
<div class="inspiry-ere-page-content">
    <div class="description">
        <p><?php esc_html_e( 'For spam protection on agent and contact forms!', 'easy-real-estate' ); ?></p>
    </div>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><?php esc_html_e( 'Google reCAPTCHA', 'easy-real-estate' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php esc_html_e( 'Google reCAPTCHA', 'easy-real-estate' ); ?></span></legend>
                        <label>
                            <input type="radio" name="theme_show_reCAPTCHA" value="true" <?php checked( $theme_show_reCAPTCHA, 'true' ) ?>>
                            <span><?php esc_html_e( 'Enable', 'easy-real-estate' ); ?></span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="theme_show_reCAPTCHA" value="false" <?php checked( $theme_show_reCAPTCHA, 'false' ) ?>>
                            <span><?php esc_html_e( 'Disable', 'easy-real-estate' ); ?></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e( 'Google reCAPTCHA Type', 'easy-real-estate' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php esc_html_e( 'Google reCAPTCHA Type', 'easy-real-estate' ); ?></span></legend>
                        <label>
                            <input type="radio" name="inspiry_reCAPTCHA_type" value="v2" <?php checked( $theme_recaptcha_type, 'v2' ) ?>>
                            <span><?php esc_html_e( 'V2', 'easy-real-estate' ); ?></span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="inspiry_reCAPTCHA_type" value="v3" <?php checked( $theme_recaptcha_type, 'v3' ) ?>>
                            <span><?php esc_html_e( 'V3', 'easy-real-estate' ); ?></span>
                        </label>
                    </fieldset>
                    <p class="description"><?php esc_html_e( 'Get new keys for V3 as V2 keys will not work!', 'easy-real-estate' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="theme_recaptcha_public_key"><?php esc_html_e( 'Site Key', 'easy-real-estate' ); ?></label></th>
                <td>
                    <input name="theme_recaptcha_public_key" type="text" id="theme_recaptcha_public_key" value="<?php echo esc_attr( $theme_recaptcha_public_key ); ?>" class="regular-text code">
                    <p class="description"><?php printf( esc_html__( 'You can get new keys for your website by %s signing in here %s', 'easy-real-estate' ), '<a href="https://www.google.com/recaptcha/admin#whyrecaptcha" target="_blank">', '</a>' ); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="theme_recaptcha_public_key"><?php esc_html_e( 'Secret Key', 'easy-real-estate' ); ?></label></th>
                <td><input name="theme_recaptcha_private_key" type="text" id="theme_recaptcha_private_key" value="<?php echo esc_attr( $theme_recaptcha_private_key ); ?>" class="regular-text code"></td>
            </tr>
            </tbody>
        </table>
        <div class="submit">
			<?php wp_nonce_field( 'inspiry_ere_settings' ); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'easy-real-estate' ); ?>">
        </div>
    </form>
</div>