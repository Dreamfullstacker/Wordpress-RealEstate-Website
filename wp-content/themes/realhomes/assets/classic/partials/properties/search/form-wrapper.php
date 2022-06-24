<?php
/**
 * Properties search form wrapper.
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( inspiry_is_search_page_configured() ) :
	?>
    <section class="advance-search rh_classic_main_search">
		<?php
		$home_advance_search_title = get_option( 'theme_home_advance_search_title' );
		if ( ! empty( $home_advance_search_title ) ) {
			?><h3 class="search-heading">
            <i class="fas fa-search"></i><?php echo esc_html( $home_advance_search_title ); ?></h3><?php
		}

		if ( inspiry_is_rvr_enabled() ) {
			get_template_part( 'assets/classic/partials/properties/search/rvr-form' );
		} else {
			get_template_part( 'assets/classic/partials/properties/search/form' );
		}
		?>
    </section>
<?php
endif;