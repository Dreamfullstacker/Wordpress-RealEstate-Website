<?php
global $current_module;

if ( is_user_logged_in() && ( 'show' == get_option( 'inspiry_my_properties_search', 'show' ) ) ) :
	$redirect_page_url = realhomes_get_dashboard_page_url( 'properties' );
	if ( 'favorites' === $current_module ) {
		$redirect_page_url = realhomes_get_dashboard_page_url( $current_module );
	}
	?>
    <div class="dashboard-search-wrap">
        <form id="dashboard-search-form" class="dashboard-search-form" action="<?php echo esc_url( $redirect_page_url ); ?>" autocomplete="off">
            <input type="text" name="prop_search" value="" id="dashboard-search-form-input" placeholder="<?php esc_html_e( 'Search Properties', 'framework' ); ?>">
            <button type="submit" id="dashboard-search-form-submit-button" class="submit-button"><i class="fas fa-search"></i></button>
        </form>
    </div>
<?php
endif;