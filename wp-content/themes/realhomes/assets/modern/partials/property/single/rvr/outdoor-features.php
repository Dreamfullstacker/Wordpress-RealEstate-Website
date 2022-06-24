<?php
/**
 * Property outdoor features of single property.
 *
 * @package    realhomes
 * @subpackage modern
 */

/* Property Outdoor Features */
$rvr_outdoor_features = get_post_meta( get_the_ID(), 'rvr_outdoor_features', true );

if ( ! empty( $rvr_outdoor_features ) && ( 0 < count( $rvr_outdoor_features ) ) ) {
	?>
    <div class="rh_property__features_wrap rh_rvr_outdoor_features_wrapper">
        <h4 class="rh_property__heading"><?php
			$rvr_settings = get_option( 'rvr_settings' );
			echo ! empty( $rvr_settings['rvr_outdoor_features_label'] ) ? esc_html( $rvr_settings['rvr_outdoor_features_label'] ) : esc_html__( 'Outdoor Features', 'framework' );
			?></h4>
        <ul class="rh_property__features arrow-bullet-list no-link-list">
			<?php
			foreach ( $rvr_outdoor_features as $rvr_outdoor_feature ) {
				echo '<li class="rh_property__feature">' . '<span class="rh_done_icon">';
				inspiry_safe_include_svg( '/images/icons/sun.svg' );
				echo '</span>' . esc_html( $rvr_outdoor_feature ) . '</li>';
			}
			?>
        </ul>
    </div>
	<?php
}