<?php
global $dashboard_globals, $current_module;

if ( isset( $dashboard_globals['page_title'] ) && ! empty( $dashboard_globals['page_title'] ) ) : ?>
    <nav class="dashboard-breadcrumbs">
        <ul>
            <li>
                <a href="<?php echo esc_url( realhomes_get_dashboard_page_url() ); ?>"><?php esc_html_e( 'Home', 'framework' ) ?></a>
                <i class="fas fa-angle-right separator"></i>
            </li>
			<?php
			if ( isset( $dashboard_globals['submenu_page_title'] ) ) : ?>
                <li>
                    <a href="<?php echo esc_url( realhomes_get_dashboard_page_url( $current_module ) ); ?>"><?php echo esc_html( $dashboard_globals['page_title'] ); ?></a>
                    <i class="fas fa-angle-right separator"></i>
                </li>
                <li>
                    <span><?php echo esc_html( $dashboard_globals['submenu_page_title'] ); ?></span>
                </li>
			<?php else: ?>
                <li><span><?php echo esc_html( $dashboard_globals['page_title'] ); ?></span>
                </li>
			<?php endif; ?>
        </ul>
    </nav>
	<?php
	$page_title = '';
	if ( isset( $dashboard_globals['submenu_page_title'] ) ) {
		$page_title = $dashboard_globals['submenu_page_title'];
	} else {
		$page_title = $dashboard_globals['page_title'];
	}
	if ( ! empty( $page_title ) ) {
		printf( '<h1 class="dashboard-page-title">%s</h1>', esc_html( $page_title ) );
	}
	?>
<?php
endif;