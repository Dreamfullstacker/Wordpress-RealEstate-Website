<?php
/**
 * Single agency sidebar.
 *
 * @package realhomes
 * @subpackage modern
 * @since 3.5.0
 */

if ( is_active_sidebar( 'agency-sidebar' ) ) {
	?>
    <aside class="rh_sidebar">
		<?php dynamic_sidebar( 'agency-sidebar' ); ?>
    </aside>
	<?php
}
?>
