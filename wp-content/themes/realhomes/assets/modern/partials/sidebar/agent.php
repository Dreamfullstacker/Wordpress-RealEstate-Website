<?php
/**
 * Single agent sidebar.
 *
 * @package realhomes
 * @subpackage modern
 */

if ( is_active_sidebar( 'agent-sidebar' ) ) {
	?>
    <aside class="rh_sidebar">
		<?php dynamic_sidebar( 'agent-sidebar' ); ?>
    </aside>
	<?php
}
?>
