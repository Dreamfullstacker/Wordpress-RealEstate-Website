<?php
/**
 * Single agent sidebar.
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( is_active_sidebar( 'agent-sidebar' ) ) : ?>
    <div class="span3 sidebar-wrap">
        <aside class="sidebar">
			<?php dynamic_sidebar( 'agent-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>