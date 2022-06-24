<?php
/**
 * Property walkscore section.
 *
 * @package    realhomes
 * @subpackage modern
 */
if ( 'true' === get_option( 'inspiry_display_walkscore', 'false' ) ) : ?>
    <div class="rh_property__walkscore_wrap">
		<?php
		$walkscore_title = get_option( 'inspiry_property_walkscore_title', esc_html__( 'WalkScore', 'framework' ) );
		if ( ! empty( $walkscore_title ) ) : ?>
            <h4 class="rh_property__heading"><?php echo esc_html( $walkscore_title ); ?></h4>
		<?php endif; ?>
        <div class="rh_property__walkscore"><?php inspiry_walkscore(); ?></div>
    </div>
<?php endif; ?>