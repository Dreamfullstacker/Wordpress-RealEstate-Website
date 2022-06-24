<?php
/**
 * Dashboard: Saved Searches Page
 *
 * @since 3.13
 * @package realhomes/dashboard
 */

realhomes_dashboard_notice(
	array(
		esc_html__( 'Welcome to Saved Searches!', 'framework' ),
		sprintf( esc_html__( "You will get email updates about latest properties that will match your saved search criteria.", 'framework' ), get_option( 'realhomes_search_emails_frequency', 'daily' ) ),
	),
	'info',
	true
);

global $wpdb;

$user_id        = get_current_user_id();
$table_name     = $wpdb->prefix . 'realhomes_saved_searches';
$saved_searches = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE user_id = ' . $user_id . ' ORDER BY id DESC', OBJECT );

?>
<div id="saved-searches" class="saved-searches">
	<div class="dashboard-posts-list">
		<div class="dashboard-posts-list-body">
			<?php
			if ( ! empty( $saved_searches ) && is_array( $saved_searches ) ) {
				foreach ( $saved_searches as $search_data ) {

					$args = array(
						'search_data' => $search_data,
						'separator'   => '<span>|</span>',
					);

					get_template_part( 'common/dashboard/saved-search-item', '', $args );
				}
			} else {
				$message = esc_html__( 'You have not saved any search!', 'framework' );
				realhomes_dashboard_no_items( $message );
			}
			?>
		</div>
	</div><!-- .dashboard-posts-list -->
</div><!-- #dashboard-favorites -->
