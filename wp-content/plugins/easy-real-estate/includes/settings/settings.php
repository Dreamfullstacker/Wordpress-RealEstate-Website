<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">
    <h1 class="screen-reader-text"><?php esc_html_e( 'Easy Real Estate', 'easy-real-estate' ); ?></h1>
    <div class="inspiry-ere-page">
        <header class="inspiry-ere-page-header">
            <h2 class="title"><span class="theme-title"><?php esc_html_e( 'Easy Real Estate', 'easy-real-estate' ); ?></span></h2>
            <p class="credit">
                <a class="inspiry-ere-logo-wrap" href="<?php echo esc_url( 'https://themeforest.net/user/inspirythemes/portfolio?order_by=sales' ); ?>" target="_blank">
                    <img src="<?php echo ERE_PLUGIN_URL . '/images/logo.png'; ?>" alt=""><?php esc_html_e( 'Inspiry Themes', 'easy-real-estate' ); ?>
                </a>
            </p>
        </header>
		<?php
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'easy-real-estate' ) );
		}

		$current_tab = 'price';
		if ( isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $this->tabs() ) ) {
			$current_tab = $_GET['tab'];
		}

		$this->tabs_nav( $current_tab );

		if ( file_exists( ERE_PLUGIN_DIR . 'includes/settings/' . $current_tab . '.php' ) ) {
			require_once ERE_PLUGIN_DIR . 'includes/settings/' . $current_tab . '.php';
		}
        //Hook to add RHPE settings page
        do_action('rhpe_settings_page',$current_tab);
        
		?>
        <footer class="inspiry-ere-page-footer">
            <p><?php printf( esc_html__( 'Version  %s', 'easy-real-estate' ), esc_html( $this->version ) ); ?></p>
        </footer>
    </div><!-- /.inspiry-ere-page -->
</div><!-- /.wrap -->
