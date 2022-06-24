<?php
/**
 * Sidebar: Pages
 *
 * @package    realhomes
 * @subpackage modern
 */

if ( is_active_sidebar( 'default-page-sidebar' ) ) {
	?>
    <aside class="rh_sidebar">
		<?php dynamic_sidebar( 'default-page-sidebar' ); ?>
    </aside>
	<?php
}
?>