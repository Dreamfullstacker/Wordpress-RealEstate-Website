<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php $this->header(); ?>
<div class="inspiry-page-inner-wrap inspiry-design-content-wrap">
    <h2 class="inspiry-title"><?php esc_html_e( 'Available Design Variations', 'framework' ); ?></h2>
    <div class="description inspiry-note">
        <p><?php esc_html_e( 'It is recommended to finalize a design variation in start and only use that for long term.', 'framework' ); ?></p>
    </div>
    <?php
    $inspiry_design = get_option( 'inspiry_design_variation', 'modern' );
    if ( isset( $_POST['inspiry_settings_nonce'] ) && wp_verify_nonce( $_POST['inspiry_settings_nonce'], 'inspiry_settings_action' ) ) {
        $inspiry_design = isset( $_POST['rh_design'] ) && ! empty( $_POST['rh_design'] ) ? esc_html( $_POST['rh_design'] ) : $rh_design_variation;
        update_option( 'inspiry_design_variation', $inspiry_design );
	    update_option( 'inspiry_default_styles', 'default' );
	    update_option( 'realhomes_color_scheme', 'default' );
    }
    ?>
    <form id="inspiry-wp-settings-form" method="POST" action="<?php menu_page_url( 'realhomes-design' ); ?>">
        <div class="row">
            <div class="col-4">
                <div class="design-wrapper">
                    <h3><?php esc_html_e( 'Classic', 'framework' ); ?></h3>
                    <label class="rh_design__label" for="rh_design_classic">
                        <input type="radio" name="rh_design" id="rh_design_classic" class="rh_design__radio hide" value="classic" <?php checked( $inspiry_design, 'classic' ) ?>>
                        <img class="rh_design__img" src="<?php echo esc_url( get_template_directory_uri() . '/framework/include/admin/images/design-classic.jpg' ); ?>">
                    </label>
                </div>
            </div>
            <div class="col-4">
                <div class="design-wrapper">
                    <h3><?php esc_html_e( 'Modern', 'framework' ); ?></h3>
                    <label class="rh_design__label" for="rh_design_modern">
                        <input type="radio" name="rh_design" id="rh_design_modern" class="rh_design__radio hide" value="modern" <?php checked( $inspiry_design, 'modern' ) ?>>
                        <img class="rh_design__img" src="<?php echo esc_url( get_template_directory_uri() . '/framework/include/admin/images/design-modern.jpg' ); ?>">
                    </label>
                </div>
            </div>
        </div>
        <div class="inspiry-note">
            <p><strong><?php esc_html_e( 'Note', 'framework' ); ?></strong>: <?php printf( esc_html__( 'Make sure to follow the steps given below after changing the design variation and get in touch with %s in case of any issue.', 'framework' ), '<a href="https://support.inspirythemes.com/" target="_blank">' . esc_html__( 'our support', 'framework' ) . '</a>' ); ?></p>
            <ol>
                <li><?php printf( esc_html__( 'Regenerate images on your website using %s plugin.', 'framework' ), '<a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">' . esc_html__( 'Regenerate Thumbnails', 'framework' ) . '</a>' ); ?></li>
                <li><?php esc_html_e( 'Test all pages on your website and rearrange widgets where required.', 'framework' ); ?></li>
            </ol>
        </div>
        <?php wp_nonce_field( 'inspiry_settings_action', 'inspiry_settings_nonce' ); ?>
        <div class="submit-button-wrap">
            <button type="submit" id="inspiry-wp-settings-form-submit" class="button button-primary"><?php esc_html_e( 'Save Changes', 'framework' ); ?></button>
        </div>
    </form>
</div>
<?php $this->footer(); ?>