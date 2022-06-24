<?php
/**
 * Property optional services of single property.
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;

/* Property Optional Services */
$rvr_included     = get_post_meta( get_the_ID(), 'rvr_included', true );
$rvr_not_included = get_post_meta( get_the_ID(), 'rvr_not_included', true );
if ( ! empty( $rvr_included ) || ! empty( $rvr_not_included ) ) {
	?>
    <div class="rh_property__features_wrap rh_rvr_optional_services_wrapper">
        <h4 class="rh_property__heading"><?php
			$rvr_settings = get_option( 'rvr_settings' );
			echo ! empty( $rvr_settings['rvr_optional_services_label'] ) ? esc_html( $rvr_settings['rvr_optional_services_label'] ) : esc_html__( 'Optional Services', 'framework' );
			?></h4>
        <div class="rh_rvr_optional_services">
			<?php
			if ( ! empty( $rvr_included ) ) {
				?>
                <div class="rvr_optional_services_status">
                    <h5>
						<?php echo ! empty( $rvr_settings['rvr_optional_services_inc_label'] ) ? esc_html( $rvr_settings['rvr_optional_services_inc_label'] ) : esc_html__( 'Included', 'framework' ); ?>
                    </h5>
                    <ul class="rh_property__features arrow-bullet-list no-link-list rh_rvr_optional_included">
						<?php
						foreach ( $rvr_included as $rvr_include ) {
							echo '<li class="rh_property__feature">';
							echo '<span class="rh_done_icon">';
							inspiry_safe_include_svg( '/images/icons/right-right.svg' );
							echo '</span>';
							echo esc_html( $rvr_include );
							echo '</li>';
						}
						?>
                    </ul>
                </div>
				<?php
			}

			if ( ! empty( $rvr_not_included ) ) {
				?>
                <div class="rvr_optional_services_status">
                    <h5>
						<?php echo ! empty( $rvr_settings['rvr_optional_services_not_inc_label'] ) ? esc_html( $rvr_settings['rvr_optional_services_not_inc_label'] ) : esc_html__( 'Not Included', 'framework' ); ?>
                    </h5>
                    <ul class="rh_property__features arrow-bullet-list no-link-list icon-cross">
						<?php
						foreach ( $rvr_not_included as $rvr_not_include ) {
							echo '<li class="rh_property__feature">';
							echo '<span class="rh_done_icon rvr_not_available"> <i class="fas fa-times"></i>';
//							inspiry_safe_include_svg( '/images/icons/done.svg' );
							echo '</span>';
							echo esc_html( $rvr_not_include );
							echo '</li>';
						}
						?>
                    </ul>
                </div>
				<?php
			}
			?>
        </div>

    </div>
	<?php
}