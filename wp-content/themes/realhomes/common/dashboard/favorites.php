<?php
global $paged, $posts_per_page, $property_status_filter, $dashboard_posts_query;

$favorite_properties_count = 0;
$favorite_pro_ids     = realhomes_get_favorite_pro_ids();
if ( ! empty( $favorite_pro_ids ) ) {
	$favorite_properties_count = count( $favorite_pro_ids );
}

$posts_per_page = realhomes_dashboard_posts_per_page();

$favorites_properties_args = array(
	'post_type'      => 'property',
	'posts_per_page' => $posts_per_page,
	'paged'          => $paged,
	'post__in'       => $favorite_pro_ids,
	'orderby'        => 'post__in',
);

$property_status_filter = realhomes_dashboard_properties_status_filter();
if ( '-1' !== $property_status_filter ) {
	$favorites_properties_args['tax_query'] = array(
		array(
			'taxonomy' => 'property-status',
			'field'    => 'slug',
			'terms'    => $property_status_filter
		)
	);
}

// Add searched parameter
if ( isset( $_GET['prop_search'] ) && 'show' == get_option( 'inspiry_my_properties_search', 'show' ) ) {
	$favorites_properties_args['s'] = sanitize_text_field( $_GET['prop_search'] );
	printf( '<div class="dashboard-notice"><p>%s <strong>%s</strong></p></div>', esc_html__( 'Search results for: ', 'framework' ), esc_html( $_GET['prop_search'] ) );
}

$dashboard_posts_query = new WP_Query( $favorites_properties_args );
?>
<div id="property-message"></div>
<div id="dashboard-favorites" class="dashboard-favorites">
	<?php
	if ( $favorite_properties_count > 0 ) {
		get_template_part( 'common/dashboard/top-nav' );

		if ( $dashboard_posts_query->have_posts() ) : ?>
            <div class="dashboard-posts-list">
				<?php get_template_part( 'common/dashboard/property-columns' ); ?>
                <div class="dashboard-posts-list-body">
					<?php
					while ( $dashboard_posts_query->have_posts() ) : $dashboard_posts_query->the_post();
						get_template_part( 'common/dashboard/property-card' );
					endwhile;
					wp_reset_postdata();
					?>
                </div>
            </div>
		<?php
		else :
			realhomes_dashboard_no_items();
		endif;

		get_template_part( 'common/dashboard/bottom-nav' );
	} else {
		realhomes_dashboard_no_items( esc_html__( 'You have no property in favorites!', 'framework' ) );
	}
	?>
</div><!-- #dashboard-favorites -->