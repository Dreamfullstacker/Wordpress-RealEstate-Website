<?php
/**
 * Blog sidebar.
 *
 * @package realhomes
 * @subpackage modern
 */
if ( is_active_sidebar( 'default-sidebar' ) ) {
	?>
    <aside class="rh_sidebar">
		<?php dynamic_sidebar( 'default-sidebar' ); ?>
    </aside>
	<?php
}
?>