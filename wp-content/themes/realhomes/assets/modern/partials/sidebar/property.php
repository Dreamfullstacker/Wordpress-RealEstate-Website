<?php
/**
 * Sidebar: Property
 *
 * @package    realhomes
 * @subpackage modern
 */

if ( is_active_sidebar( 'property-sidebar' ) ) {
	?>
    <aside class="rh_sidebar">
		<?php dynamic_sidebar( 'property-sidebar' ); ?>
    </aside>
	<?php
}
?>
