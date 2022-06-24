<?php
/**
 * Sidebar: dsIDXpress
 *
 * @package    realhomes
 * @subpackage modern
 */


if ( is_active_sidebar( 'dsidx-sidebar' ) ) {
	?>
    <aside class="rh_sidebar">
		<?php dynamic_sidebar( 'dsidx-sidebar' ); ?>
    </aside>
	<?php
}
?>
