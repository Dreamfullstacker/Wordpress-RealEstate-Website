<?php
/**
 * Property property policies of single property.
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;

/* Property Property Policies */
$property_policies = get_post_meta( get_the_ID(), 'rvr_policies', true );
if ( ! empty( $property_policies ) ) {
	?>
    <div class="rh_property__features_wrap rh_rvr_alternate_wrapper rh_rvr_property_policies_wrapper">
        <h4 class="rh_property__heading"><?php
			$rvr_settings = get_option( 'rvr_settings' );
			echo ! empty( $rvr_settings['rvr_property_policies_label'] ) ? esc_html( $rvr_settings['rvr_property_policies_label'] ) : esc_html__( 'Property Policies', 'framework' );
			?></h4>
        <ul class="rh_property__features arrow-bullet-list no-link-list property-policy">
			<?php
			foreach ( $property_policies as $property_policy ) {
				?>
                <li class="rh_property__feature">
					<?php
					if ( isset( $property_policy['rvr_policy_icon'] ) && ! empty( $property_policy['rvr_policy_icon'] ) ) {
						?>
                        <span class="rh_done_icon rvr_fa_icon">
                            <i class="<?php echo esc_attr( $property_policy['rvr_policy_icon'] ); ?>">
                                <span class="rvr-slash-line"></span>
                            </i>
                        </span>
						<?php
					} else {
						?>
                        <span class="rh_done_icon">
                        <?php inspiry_safe_include_svg( '/images/icons/done.svg' ); ?>
                    </span>
						<?php
					}
					echo esc_html( $property_policy['rvr_policy_detail'] );
					?>
                </li>
				<?php
			}
			?>
        </ul>
    </div>
	<?php
}