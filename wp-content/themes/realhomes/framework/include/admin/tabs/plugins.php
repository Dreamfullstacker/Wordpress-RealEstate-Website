<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php $this->header( 'plugins' ); ?>
    <div class="inspiry-page-inner-wrap inspiry-plugins-content-wrap">
		<?php
		$filters = array(
			'plugin-card-wrapper' => esc_html__( 'All', 'framework' ),
			'required'            => esc_html__( 'Required', 'framework' ),
			'recommended'         => esc_html__( 'Recommended', 'framework' ),
			'free'                => esc_html__( 'Free', 'framework' ),
			'paid'                => esc_html__( 'Paid', 'framework' ),
		);
		if ( ! empty( $filters ) ) : ?>
            <div id="inspiry-plugin-filter" class="inspiry-plugin-filter">
                <ul>
                    <li><strong><?php esc_html_e( 'Plugins:', 'framework' ); ?></strong></li>
					<?php foreach ( $filters as $key => $value ) : ?>
                        <li><a href="#" data-filter=".<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></a></li>
					<?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <h2 class="inspiry-title"><?php esc_html_e( 'Required and Recommended Plugins', 'framework' ); ?></h2>
        <div class="row">
			<?php
			$inspiry_plugins = $this->inspiry_plugins();

			if ( ! empty( $inspiry_plugins ) && is_array( $inspiry_plugins ) ) {

				include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

				foreach ( $inspiry_plugins as $plugin ) {
					$is_required       = ( isset( $plugin['required'] ) && $plugin['required'] ) ? esc_html__( 'Required', 'framework' ) : esc_html__( 'Recommended', 'framework' );
					$is_premium        = ( isset( $plugin['premium'] ) && $plugin['premium'] ) ? esc_html__( 'Paid', 'framework' ) : esc_html__( 'Free', 'framework' );
					$required_class    = ( isset( $plugin['required'] ) && $plugin['required'] ) ? 'required' : 'recommended';
					$premium_class     = ( isset( $plugin['premium'] ) && $plugin['premium'] ) ? 'paid' : 'free';
					$plugin_card_class = $premium_class . ' ' . $required_class;
					$file_path         = $plugin['file_path'];

					if ( $this->inspiry_is_active_plugin( $file_path ) ) {
						$plugin_card_class .= ' active';
					}

					if ( is_plugin_inactive( $file_path ) ) {
						$plugin_card_class .= ' inactive';
					}

					$plugin_icon_url = get_template_directory_uri() . '/framework/include/admin/images/inspiry-logo.png';
					if ( isset( $plugin['icons'] ) && ! empty( $plugin['icons'] ) ) {
						$plugin_icon_url = $plugin['icons'];
					}
					?>
                    <div class="col-3 inspiry-plugin-card-wrapper plugin-card-wrapper <?php echo esc_attr( $plugin_card_class ); ?>">
                        <div class="inspiry-plugin-card plugin-card plugin-card-<?php echo sanitize_html_class( $plugin['slug'] ); ?>">
                            <div class="inspiry-plugin-card-top plugin-card-top">
                                <div class="name column-name">
                                    <img src="<?php echo esc_attr( $plugin_icon_url ) ?>" class="plugin-icon" alt="<?php echo esc_attr( $plugin['name'] ); ?>">
                                    <h3><?php echo esc_html( $plugin['name'] ); ?></h3>
                                </div>
                                <div class="inspiry-plugin-card-description desc column-description">
                                    <p><?php echo wp_trim_words( strip_tags( $plugin['short_description'] ), 12 ); ?></p>
                                    <div class="inspiry-plugin-tags">
                                        <span class="plugin-<?php echo esc_attr( $required_class ); ?>"><?php echo esc_html( $is_required ); ?></span>
                                        <span>|</span>
                                        <span class="plugin-<?php echo esc_html( $premium_class ); ?>"><?php echo esc_html( $is_premium ); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="inspiry-plugin-card-footer plugin-card-bottom">
								<?php
								if ( isset( $plugin['author'] ) && ! empty( $plugin['author'] ) && isset( $plugin['author_url'] ) && ! empty( $plugin['author_url'] ) ) {
									printf( '<span class="authors"><cite>By <a href="%s" target="_blank">%s</a></cite></span>', esc_url( $plugin['author_url'] ), $plugin['author'] );
								}

								if ( class_exists( 'ERE_Subscription_API' ) && ERE_Subscription_API::status() ) : ?>
                                    <div class="action-links">
										<?php
										$action_links = $this->inspiry_get_plugin_action_links( $plugin );
										if ( $action_links ) {
											echo '<ul class="plugin-action-buttons"><li>' . implode( '</li><li>', $action_links ) . '</li></ul>';
										}
										?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
					<?php
				}
			}
			?>
        </div>
    </div>
<?php $this->footer( 'plugins' ); ?>