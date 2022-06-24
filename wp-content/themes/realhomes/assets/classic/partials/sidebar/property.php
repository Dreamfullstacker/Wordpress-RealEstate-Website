<?php
/**
 * Sidebar: Property
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( is_active_sidebar( 'property-sidebar' ) ) : ?>
    <div class="span3 sidebar-wrap">
        <aside class="sidebar">
			<?php dynamic_sidebar( 'property-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>