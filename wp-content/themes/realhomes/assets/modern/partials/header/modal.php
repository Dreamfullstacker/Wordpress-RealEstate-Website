<?php
/**
 * Header Modal
 *
 * Header modal for login in the header.
 *
 * @package realhomes
 * @subpackage modern
 */

$is_user_logged_in     = is_user_logged_in();
$favorites_after_login = get_option( 'inspiry_login_on_fav', 'no' );

$favorites_url = inspiry_get_favorites_url();
if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_favorites_module_display' ) ) {
	$favorites_url = realhomes_get_dashboard_page_url( 'favorites' );
}
?>
<div class="rh_modal">
<?php
if ( $is_user_logged_in || ( ! empty( $favorites_url ) && 'no' === $favorites_after_login ) ) :
	?>
        <div class="rh_modal__corner"></div><!-- /.rh_modal__corner -->
        <div class="rh_modal__wrap">
			<?php
			if ( $is_user_logged_in ) : ?>
                <div class="rh_user">
                    <div class="rh_user__avatar">
						<?php
						$current_user      = wp_get_current_user();
						$current_user_meta = get_user_meta( $current_user->ID );

						if ( isset( $current_user_meta['profile_image_id'][0] ) ) {
							echo wp_get_attachment_image( $current_user_meta['profile_image_id'][0], array(
								'40',
								'40'
							), "", array( "class" => "rh_modal_profile_img" ) );
						} else {
							$user_email    = $current_user->user_email;
							$user_gravatar = inspiry_get_gravatar( $user_email, '150' );
							?>
                            <img alt="<?php echo esc_attr( $current_user->display_name ); ?>"
                                 src="<?php echo esc_url( $user_gravatar ); ?>">
							<?php
						}
						?>
                    </div><!-- /.rh_user__avatar -->
                    <div class="rh_user__details">
                        <p class="rh_user__msg"><?php esc_html_e( 'Welcome', 'framework' ); ?></p><!-- /.rh_user__msg -->
                        <h3 class="rh_user__name"><?php echo esc_html( $current_user->display_name ); ?></h3>
                    </div><!-- /.rh_user__details -->
                </div><!-- /.rh_user -->
			<?php endif; ?>
            <div class="rh_modal__dashboard">
				<?php
				if ( ! empty( $favorites_url ) && 'no' === $favorites_after_login && ! $is_user_logged_in ) : ?>
                    <a href="<?php echo esc_url( $favorites_url ); ?>" class="rh_modal__dash_link add-favorites-without-login">
						<?php inspiry_safe_include_svg( '/images/icons/icon-dash-favorite.svg' ); ?>
                        <span><?php esc_html_e( 'Favorites', 'framework' ); ?></span>
                    </a>
				<?php
				endif;

				if ( $is_user_logged_in ) :
					$profile_url = inspiry_get_edit_profile_url();
					if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_profile_module_display' ) ) {
						$profile_url = realhomes_get_dashboard_page_url( 'profile' );
					}

					if ( ! empty( $profile_url ) ) :
						?>
                        <a href="<?php echo esc_url( $profile_url ); ?>" class="rh_modal__dash_link">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-profile.svg' ); ?>
                            <span><?php esc_html_e( 'Profile', 'framework' ); ?></span>
                        </a>
					<?php
					endif;

					$my_properties_url = inspiry_get_my_properties_url();
					if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_properties_module_display' ) ) {
						$my_properties_url = realhomes_get_dashboard_page_url( 'properties' );
					}

					if ( ! empty( $my_properties_url ) && inspiry_no_membership_disable_stuff() ) :
						?>
                        <a href="<?php echo esc_url( $my_properties_url ); ?>" class="rh_modal__dash_link">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-my-properties.svg' ); ?>
                            <span><?php esc_html_e( 'My Properties', 'framework' ); ?></span>
                        </a>
					<?php
					endif;

					// Favorites page link
					if ( ! empty( $favorites_url ) ) :
						?>
                        <a href="<?php echo esc_url( $favorites_url ); ?>" class="rh_modal__dash_link">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-favorite.svg' ); ?>
                            <span><?php esc_html_e( 'Favorites', 'framework' ); ?></span>
                        </a>
					<?php
					endif;

					if ( inspiry_is_save_search_enabled() ) {
						$saved_searches_url = '';
						if ( realhomes_get_dashboard_page_url() ) {
							$saved_searches_url = realhomes_get_dashboard_page_url( 'saved-searches' );
						}

						$saved_searches_label = get_option( 'realhomes_saved_searches_label', esc_html__( 'Saved Searches', 'framework' ) );
						if ( ! empty( $saved_searches_url ) && ! empty( $saved_searches_label ) ) :
							?>
                            <a href="<?php echo esc_url( $saved_searches_url ); ?>" class="rh_modal__dash_link">
								<?php inspiry_safe_include_svg( 'images/icon-dash-alert.svg', '/common/' ); ?>
                                <span><?php echo esc_html( $saved_searches_label ); ?></span>
                            </a>
						<?php
						endif;
					}

					if ( function_exists( 'IMS_Helper_Functions' ) ) :
						$ims_helper_functions  = IMS_Helper_Functions();
						$is_memberships_enable = $ims_helper_functions::is_memberships();

						$membership_url = inspiry_get_membership_url();
						if ( realhomes_get_dashboard_page_url() ) {
							$membership_url = realhomes_get_dashboard_page_url( 'membership' );
						}

						if ( ! empty( $is_memberships_enable ) && ! empty( $membership_url ) ) :
							?>
                            <a href="<?php echo esc_url( $membership_url ); ?>" class="rh_modal__dash_link">
								<?php inspiry_safe_include_svg( '/images/icons/icon-membership.svg' ); ?>
                                <span><?php esc_html_e( 'Membership', 'framework' ); ?></span>
                            </a>
						<?php
						endif;
					endif;
					?>
                    <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="rh_modal__dash_link">
						<?php inspiry_safe_include_svg( '/images/icons/icon-dash-logout.svg' ); ?>
                        <span><?php esc_html_e( 'Logout', 'framework' ); ?></span>
                    </a>
				<?php
				endif;
				?>
            </div><!-- /.rh_modal__dashboard -->
        </div><!-- /.rh_modal__wrap -->
    </div><!-- /.rh_menu__modal -->
<?php endif; ?>




