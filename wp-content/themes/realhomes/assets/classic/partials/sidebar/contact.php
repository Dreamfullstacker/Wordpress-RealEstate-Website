<?php
/**
 * Sidebar: Contact
 *
 * @package realhomes
 * @subpackage classic
 */

if ( is_active_sidebar( 'contact-sidebar' ) ) : ?>
    <div class="span3 sidebar-wrap">
        <aside class="sidebar">
			<?php dynamic_sidebar( 'contact-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>