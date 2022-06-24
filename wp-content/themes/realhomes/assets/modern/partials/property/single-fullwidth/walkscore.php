<?php
/**
 * Property walkscore section.
 *
 * @package    realhomes
 * @subpackage modern
 */
if ( 'true' === get_option( 'inspiry_display_walkscore', 'false' ) ) : ?>
    <div class="walkscore-content-wrapper single-property-section">
        <div class="container">
			<?php get_template_part( 'assets/modern/partials/property/single/walkscore' ); ?>
        </div>
    </div>
<?php endif; ?>