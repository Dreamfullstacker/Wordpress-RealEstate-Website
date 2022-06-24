<?php
/**
 * Property yelp nearby places section.
 *
 * @package    realhomes
 * @subpackage modern
 */
if ( 'true' === get_option( 'inspiry_display_yelp_nearby_places', 'false' ) ) : ?>
	<div class="yelp-content-wrapper single-property-section">
		<div class="container">
			<?php get_template_part( 'assets/modern/partials/property/single/yelp-nearby-places' ); ?>
		</div>
	</div>
<?php endif; ?>
