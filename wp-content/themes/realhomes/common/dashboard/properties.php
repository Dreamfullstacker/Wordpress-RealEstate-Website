<?php
global $paged, $posts_per_page, $property_status_filter, $dashboard_posts_query;

if ( isset( $_GET['deleted'] ) && ( 1 == intval( $_GET['deleted'] ) ) ) {
	realhomes_dashboard_notice(
		array(
			esc_html__( 'Success:', 'framework' ),
			esc_html__( 'Property removed successfully!', 'framework' )
		),
		'success',
		true
	);
} elseif ( isset( $_GET['property-added'] ) && ( true == $_GET['property-added'] ) ) {
	realhomes_dashboard_notice(
		array(
			esc_html__( 'Success:', 'framework' ),
			get_option( 'theme_submit_message' )
		),
		'success',
        true
	);
} elseif ( isset( $_GET['property-updated'] ) && ( true == $_GET['property-updated'] ) ) {
	realhomes_dashboard_notice(
		array(
			esc_html__( 'Success:', 'framework' ),
			esc_html__( 'Property updated successfully!', 'framework' )
		),
		'success',
		true
	);
} elseif ( isset( $_GET['payment'] ) && ( 'paid' == $_GET['payment'] ) ) {
	realhomes_dashboard_notice(
		array(
			esc_html__( 'Success:', 'framework' ),
			esc_html__( 'Payment Submitted.', 'framework' )
		),
		'success',
		true
	);
} elseif ( isset( $_GET['payment'] ) && ( 'failed' == $_GET['payment'] ) ) {
	realhomes_dashboard_notice(
		array(
			esc_html__( 'Error:', 'framework' ),
			esc_html__( 'Payment Failed.', 'framework' )
		),
		'error',
		true
	);
}

if ( class_exists( 'IMS_Helper_Functions' ) && ! empty( IMS_Helper_Functions::is_memberships() ) ) {
	if ( empty( get_user_meta( wp_get_current_user()->ID, 'ims_current_membership', true ) ) ) {
		realhomes_dashboard_notice( esc_html__( 'Please subscribe a membership package to start publishing properties.', 'framework' ) );
	}
}

$posts_per_page = realhomes_dashboard_posts_per_page();

$property_statuses = array( 'publish', 'private', 'draft', 'pending', 'future' );
if ( isset( $_GET['status'] ) && ! empty( $_GET['status'] ) ) {
	if ( in_array( $_GET['status'], $property_statuses ) ) {
		$property_statuses = array( sanitize_text_field( $_GET['status'] ) );
	}
}

$current_user = wp_get_current_user();

$properties_args = array(
	'post_type'      => 'property',
	'posts_per_page' => $posts_per_page,
	'paged'          => $paged,
	'post_status'    => $property_statuses,
	'author'         => $current_user->ID,
);

$property_status_filter = realhomes_dashboard_properties_status_filter();
if ( '-1' !== $property_status_filter ) {
	$properties_args['tax_query'] = array(
		array(
			'taxonomy' => 'property-status',
			'field'    => 'slug',
			'terms'    => $property_status_filter
		)
	);
}

// Add searched parameter
if ( isset( $_GET['prop_search'] ) && 'show' == get_option( 'inspiry_my_properties_search', 'show' ) ) {
	$properties_args['s'] = sanitize_text_field( $_GET['prop_search'] );
	printf( '<div class="dashboard-notice"><p>%s <strong>%s</strong></p></div>', esc_html__( 'Search results for: ', 'framework' ), esc_html( $_GET['prop_search'] ) );
}

$dashboard_posts_query = new WP_Query( apply_filters( 'realhomes_my_properties', $properties_args ) );

do_action( 'inspiry_before_my_properties_page_render', get_the_ID() );
?>
<div id="property-message"></div>
<div id="dashboard-properties" class="dashboard-properties">
	<?php get_template_part( 'common/dashboard/top-nav' ); ?>
	<?php if ( $dashboard_posts_query->have_posts() ) : ?>
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
	<?php else :
		realhomes_dashboard_no_items();
	endif;
	?>
	<?php get_template_part( 'common/dashboard/bottom-nav' ); ?>
</div><!-- #dashboard-favorites -->