<?php
/**
 * Sidebar: Property Listing
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( is_active_sidebar( 'property-listing-sidebar' ) ) : ?>
    <div class="span3 sidebar-wrap">
        <aside class="sidebar">
			<?php dynamic_sidebar( 'property-listing-sidebar' ); ?>
        </aside>
    </div>
<?php endif; ?>