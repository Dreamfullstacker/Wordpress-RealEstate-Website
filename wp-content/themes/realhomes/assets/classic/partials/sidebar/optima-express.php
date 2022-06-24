<?php
/**
 * Sidebar: Optima Express
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( is_active_sidebar( 'optima-express-page-sidebar' ) ) : ?>
    <div class="span3 sidebar-wrap">
        <aside class="sidebar">
			<?php dynamic_sidebar( 'optima-express-page-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>