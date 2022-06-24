<?php
/**
 * Property yelp nearby places section.
 *
 * @package    realhomes
 * @subpackage classic
 */
if ( 'true' === get_option( 'inspiry_display_yelp_nearby_places', 'false' ) ) : ?>
    <div class="yelp-wrap clearfix">
		<?php
		$yelp_nearby_title = get_option( 'inspiry_property_yelp_nearby_places_title', esc_html__( 'What\'s Nearby?', 'framework' ) );
		if ( ! empty( $yelp_nearby_title ) ) : ?>
            <span class="yelp-label"><?php echo esc_html( $yelp_nearby_title ); ?></span>
		<?php endif; ?>
        <div class="rh_property__yelp"><?php inspiry_yelp_nearby_places(); ?></div>
    </div>
<?php endif; ?>