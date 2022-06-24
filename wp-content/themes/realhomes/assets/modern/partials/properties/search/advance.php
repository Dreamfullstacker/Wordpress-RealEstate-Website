<?php
/**
 * Properties advance search.
 *
 * @package    realhomes
 * @subpackage modern
 */

// Get current page ID other home page.
$page_id = get_the_ID();

if ( is_home() ) {
	$page_id = get_queried_object_id();
} elseif ( is_singular( 'post' ) ) {
	// Use posts page (REAL_HOMES_hide_advance_search) meta setting for single post page.
	$posts_page_id = get_option( 'page_for_posts' );
	if ( ! empty( $posts_page_id ) ) {
		$page_id = $posts_page_id;
	}
}

if ( '1' !== get_post_meta( $page_id, 'REAL_HOMES_hide_advance_search', true ) ) {
	$show_search = is_page_template( 'templates/home.php' ) ? get_post_meta( $page_id, 'theme_show_home_search', true ) : inspiry_show_header_search_form();
	if ( inspiry_is_search_page_configured() && $show_search ) {
		$advance_search_expand = '';
		if ( inspiry_is_rvr_enabled() || 'false' === get_option( 'inspiry_search_advance_search_expander', 'true' ) ) {
			$advance_search_expand = 'rh_hide_advance_fields';
		}
		?>
        <div class="inspiry_show_on_doc_ready rh_prop_search rh_prop_search_init <?php echo esc_attr( $advance_search_expand ); ?>">
			<?php
			if ( inspiry_is_rvr_enabled() ) {
				get_template_part( 'assets/modern/partials/properties/search/rvr-form' );
			} else {
				switch ( get_option( 'inspiry_search_form_mod_layout_options', 'default' ) ) {
					case 'default';
						get_template_part( 'assets/modern/partials/properties/search/form' );
						break;
					case 'smart';
						get_template_part( 'assets/modern/partials/properties/search/form-smart' );
						break;
				}
			}
			?>
        </div><!-- /.rh_prop_search -->
		<?php
	}
}