<div id="dashboard-content" class="dashboard-content">
	<?php
	global $dashboard_globals, $current_module;

	// Dashboard page head
	get_template_part( 'common/dashboard/page-head' );

	/**
	 * Fires before the dashboard page content.
	 *
	 * @since 3.12
	 */
	do_action( 'realhomes_dashboard_before_content' );

	/**
	 * Overrides the current module variable if sub module exists.
	 */
	if ( isset( $dashboard_globals['submodule'] ) && ! empty( $dashboard_globals['submodule'] ) ) {
		$current_module = $dashboard_globals['submodule'];
	}

	/**
	 * Includes the dashboard current page.
	 */
	if ( ! empty( $current_module ) ) {
		get_template_part( 'common/dashboard/' . $current_module );
	} else {
		realhomes_dashboard_notice( esc_html__( 'You must be logged in to view this page.', 'framework' ) . ' <a href="#" class="ask-for-login"><strong>' . esc_html__( 'Login Now', 'framework' ) . '</strong></a>' );
	}

	/**
	 * Fires after the dashboard page content.
	 *
	 * @since 3.12
	 */
	do_action( 'realhomes_dashboard_after_content' );
	?>
</div><!-- #dashboard-content -->