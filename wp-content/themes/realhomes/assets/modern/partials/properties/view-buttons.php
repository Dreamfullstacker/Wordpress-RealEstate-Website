<?php
/**
 * Listing View Buttons
 *
 * View buttons for property listing.
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_view_type">
	<?php
	$page_url = null;
	// Page url.
	if ( is_post_type_archive( 'property' ) ) {
	    $page_url = get_post_type_archive_link( 'property' );
	} elseif ( is_tax() ) {

		$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$page_url = get_term_link( $current_term );

	} else {
	    global $post;
	    $page_url = get_permalink( get_the_ID() );
	}

	// Separator.
	$separator = ( null == parse_url( $page_url, PHP_URL_QUERY ) ) ? '?' : '&';

	// View Type.
	$view_type = 'list';
	if ( isset( $_GET['view'] ) ) {
	    if ( 'grid' === $_GET['view'] ) {
	        $view_type = 'grid';
	    }
	} else {
	    if ( is_page_template( 'templates/grid-layout.php' ) ) {
	        $view_type = 'grid';
	    }
	}
	?>
	<a class="grid <?php echo ( 'grid' === $view_type ) ? 'active' : ''; ?>" href="<?php echo esc_url( $page_url . $separator . 'view=grid' ); ?>">
	    <?php inspiry_safe_include_svg( '/images/icons/icon-sort-grid.svg' ); ?>
	</a>
	<a class="list <?php echo ( 'list' === $view_type ) ? 'active' : ''; ?>" href="<?php echo esc_url( $page_url . $separator . 'view=list' ); ?>">
	    <?php inspiry_safe_include_svg( '/images/icons/icon-sort-list.svg' ); ?>
	</a>
</div>
<!-- /.rh_view_type -->
