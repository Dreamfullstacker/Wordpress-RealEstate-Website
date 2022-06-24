<?php
global $paged, $posts_per_page, $property_status_filter, $dashboard_posts_query;
?>
<div class="dashboard-posts-list-topnav">
    <select name="property_status_filter" id="property-status-filter" class="noJs-select">
		<?php
		printf( '<option value="-1"%s>%s</option>', selected( $property_status_filter, '-1', false ), esc_html__( 'All', 'framework' ) );

		if ( class_exists( 'ERE_Data' ) ) {
			$all_statuses = ERE_Data::get_statuses_slug_name();
			if ( ! empty( $all_statuses ) ) {
				foreach ( $all_statuses as $term_slug => $term_name ) {
					printf( '<option value="%s"%s>%s</option>', esc_attr( $term_slug ), selected( $property_status_filter, $term_slug, false ), esc_html( $term_name ) );
				}
			}
		}
		?>
    </select>

    <ul id="paging-entries" class="paging-entries">
		<?php
		$posts_per_page_list = realhomes_dashboard_posts_per_page_list();
		if ( is_array( $posts_per_page_list ) && ! empty( $posts_per_page_list ) ) : ?>
            <li><?php esc_html_e( 'Show', 'framework' ); ?></li>
            <li class="posts-per-page-filter-wrap">
                <select id="posts-per-page" name="posts_per_page" class="noJs-select">
					<?php foreach ( $posts_per_page_list as $number ) :
						if ( '-1' === $number ) {
							printf( '<option value="%s"%s>%s</option>', esc_attr( $number ), selected( $posts_per_page, $number, false ), esc_html__( 'All', 'framework' ) );
						} else {
							printf( '<option value="%1$s"%2$s>%1$s</option>', esc_attr( $number ), selected( $posts_per_page, $number, false ) );
						}
						?>
					<?php endforeach; ?>
                </select>
            </li>
            <li><?php esc_html_e( 'Entries', 'framework' ); ?></li>
		<?php
		endif;

		$found_posts = $dashboard_posts_query->found_posts;
		if ( $found_posts ) : ?>
            <li class="paging">
				<?php
				$pagenum = ( $dashboard_posts_query->query_vars['paged'] < 1 ) ? 1 : $dashboard_posts_query->query_vars['paged'];
				$start   = ( ( $pagenum - 1 ) * $dashboard_posts_query->query_vars['posts_per_page'] ) + 1;
				$end     = ( $start + $dashboard_posts_query->post_count ) - 1;
				?>
                <span class="displaying-num"><span class="start-num"><?php echo esc_html( $start ); ?></span> - <span class="end-num"><?php echo esc_html( $end ); ?></span></span>
                <span class="paging-text"><?php esc_html_e( ' of ', 'framework' ); ?></span>
                <span class="total-posts"><?php echo esc_html( $found_posts ); ?></span>
            </li>
		<?php endif; ?>
    </ul>
</div>