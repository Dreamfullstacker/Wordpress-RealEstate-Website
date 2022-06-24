<?php
/**
 * Agency sidebar.
 *
 * @since 3.5.0
 * @package    realhomes
 * @subpackage classic
 */

if ( is_active_sidebar( 'agency-sidebar' ) ) : ?>
    <div class="span3 sidebar-wrap">
        <aside class="sidebar">
			<?php dynamic_sidebar( 'agency-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>