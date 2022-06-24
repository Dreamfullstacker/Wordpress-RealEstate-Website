<?php
/**
 * Sidebar: dsIDX
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( is_active_sidebar( 'dsidx-sidebar' ) )  : ?>
    <div class="span3 sidebar-wrap">
        <aside id="dsidx-sidebar" class="sidebar">
			<?php dynamic_sidebar( 'dsidx-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>