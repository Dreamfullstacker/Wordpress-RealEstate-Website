<?php
global $dashboard_globals;

if ( is_user_logged_in() ) :
	$count_properties = realhomes_count_posts();
	$total_properties = 0;
	$published_properties = 0;
	$pending_properties = 0;
	$favorite_properties = 0;

	if ( $count_properties ) {
		$published_properties = $count_properties->publish;
		$pending_properties   = $count_properties->pending;
		$total_properties     = $published_properties + $pending_properties;
	}

	$favorite_pro_ids = realhomes_get_favorite_pro_ids();
	if ( ! empty( $favorite_pro_ids ) ) {
		$favorite_properties = count( $favorite_pro_ids );
	}
	?>
    <div class="dashboard-small-widgets">
        <div class="row">
	        <?php
	        if ( inspiry_no_membership_disable_stuff() ) :
		        ?>
                <div class="col-sm-6 col-xl-4">
                    <div class="widget-common widget-small widget-total-properties-count">
                        <i class="fas fa-home"></i>
                        <div class="widget-body">
                            <h4><?php esc_html_e( 'Total Properties', 'framework' ); ?></h4>
                            <p><?php echo esc_html( $total_properties ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="widget-common widget-small widget-published-properties-count">
                        <i class="fas fa-upload"></i>
                        <div class="widget-body">
                            <h4><?php esc_html_e( 'Published Properties', 'framework' ); ?></h4>
                            <p><?php echo esc_html( $published_properties ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="widget-common widget-small widget-pending-properties-count">
                        <i class="fas fa-archive"></i>
                        <div class="widget-body">
                            <h4><?php esc_html_e( 'Pending Properties', 'framework' ); ?></h4>
                            <p><?php echo esc_html( $pending_properties ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4">
                    <div class="widget-common widget-small widget-featured-properties-count">
                        <i class="fas fa-star"></i>
                        <div class="widget-body">
                            <h4><?php esc_html_e( 'Featured Properties', 'framework' ); ?></h4>
                            <p><?php echo esc_html( realhomes_count_featured_properties() ); ?></p>
                        </div>
                    </div>
                </div>
	        <?php
	        endif;
	        ?>
            <div class="col-sm-6 col-xl-4">
                <div class="widget-common widget-small widget-favorite-properties-count">
                    <i class="fas fa-heart"></i>
                    <div class="widget-body">
                        <h4><?php esc_html_e( 'My Favorites', 'framework' ); ?></h4>
                        <p><?php echo esc_html( $favorite_properties ); ?></p>
                    </div>
                </div>
            </div>
			<?php do_action( 'realhomes_dashboard_add_small_widget' ); ?>
        </div>
    </div>
    <div class="dashboard-large-widgets">
        <div class="row">
			<?php do_action( 'realhomes_dashboard_add_large_widget' ); ?>
        </div>
    </div>
	<?php
	do_action( 'realhomes_dashboard_add_widget' );
endif;