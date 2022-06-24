<?php
/**
 * Sidebar
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( is_active_sidebar( 'default-sidebar' ) )  : ?>
    <div class="span4 sidebar-wrap">
        <aside class="sidebar">
			<?php dynamic_sidebar( 'default-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>