<?php
/**
 * Property walkscore section.
 *
 * @package    realhomes
 * @subpackage classic
 */
if ( 'true' === get_option( 'inspiry_display_walkscore', 'false' ) ) : ?>
    <div class="walkscore-wrap clearfix">
		<?php
		$walkscore_title = get_option( 'inspiry_property_walkscore_title', esc_html__( 'WalkScore', 'framework' ) );
		if ( ! empty( $walkscore_title ) ) : ?>
            <span class="walkscore-label"><?php echo esc_html( $walkscore_title ); ?></span>
		<?php endif; ?>
        <div class="rh_property__walkscore"><?php inspiry_walkscore(); ?></div>
    </div>
<?php endif; ?>