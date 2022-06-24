<?php
/**
 * Sidebar: Property Listing
 *
 * @package    realhomes
 * @subpackage modern
 */


if ( is_active_sidebar( 'property-listing-sidebar' ) ) {
	?>
    <aside class="rh_sidebar">
		<?php dynamic_sidebar( 'property-listing-sidebar' ); ?>
    </aside>
	<?php
}
?>
