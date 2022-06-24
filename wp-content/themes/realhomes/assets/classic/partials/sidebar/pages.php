<?php
/**
 * Sidebar: Pages
 *
 * @package     realhomes
 * @subpackages classic
 */

if ( is_active_sidebar( 'default-page-sidebar' ) ) : ?>
    <div class="span3 sidebar-wrap">
        <aside class="sidebar">
			<?php dynamic_sidebar( 'default-page-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>