<?php
/**
 * Member: Properties
 *
 * Inner template for my properties page. This page contains
 * member properties.
 *
 * @package    realhomes
 * @subpackage modern
 */

// Page Head.
$header_variation = get_option( 'inspiry_member_pages_header_variation', 'banner' );


global $paged;

// Get current user.
$current_user = wp_get_current_user();

// My properties arguments.
$my_props_args = array(
	'post_type'      => 'property',
	'posts_per_page' => 10,
	'paged'          => $paged,
	'post_status'    => array( 'pending', 'draft', 'publish', 'future' ),
	'author'         => $current_user->ID,
);

// Add searched parameter
$my_properties_search = get_option( 'inspiry_my_properties_search', 'show' );
$prop_searched        = false;
if ( isset( $_GET['prop_search'] ) && 'show' == $my_properties_search ) {
	$my_props_args['s'] = sanitize_text_field( $_GET['prop_search'] );
	$prop_searched      = true;
}

$my_properties_query = new WP_Query( apply_filters( 'realhomes_my_properties', $my_props_args ) );

?>
<section class="rh_section rh_wrap rh_wrap--padding rh_wrap--topPadding">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
    <div class="rh_page">

        <div class="rh_page__head">

			<?php if ( ! is_user_logged_in() && 'banner' !== $header_variation ) : ?>
                <h2 class="rh_page__title">
					<?php
					global $post;
					$page_title = get_the_title( get_the_ID() );
					echo inspiry_get_exploded_heading( $page_title );
					?>
                </h2>
                <!-- /.rh_page__title -->
			<?php endif; ?>

            <div class="rh_page__nav rh_page__nav_properties">
                <div class="property-count-box">
					<?php
					if ( is_user_logged_in() ) {
						$my_post_count = $my_properties_query->post_count;
						$my_post_found = $my_properties_query->found_posts;

						if ( $my_post_count < $my_post_found ) {
							echo '<h2 class="rh_page__title"><span class="sub">' . $my_post_count . esc_html__( ' of ', 'framework' ) . $my_post_found . '</span><span class="title">' . esc_html__( ' Properties', 'framework' ) . '</span></h2>';
						} elseif ( $my_post_count == 1 ) {
							echo '<h2 class="rh_page__title"><span class="sub">' . $my_post_count . '</span><span class="title">' . esc_html__( ' Property', 'framework' ) . '</span></h2>';
						} else {
							echo '<h2 class="rh_page__title"><span class="sub">' . $my_post_count . '</span><span class="title">' . esc_html__( ' Properties', 'framework' ) . '</span></h2>';
						}
					}
					?>
                </div>
                <div class="user-nav-items-box">
					<?php
					$profile_url = inspiry_get_edit_profile_url();
					if ( ! empty( $profile_url ) && is_user_logged_in() ) :
						?>
                        <a href="<?php echo esc_url( $profile_url ); ?>" class="rh_page__nav_item">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-profile.svg' ); ?>
                            <p><?php esc_html_e( 'Profile', 'framework' ); ?></p>
                        </a>
					<?php
					endif;

					$my_properties_url = inspiry_get_my_properties_url();
					if ( ! empty( $my_properties_url ) && is_user_logged_in() ) :
						?>
                        <a href="<?php echo esc_url( $my_properties_url ); ?>" class="rh_page__nav_item active">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-my-properties.svg' ); ?>
                            <p><?php esc_html_e( 'My Properties', 'framework' ); ?></p>
                        </a>
					<?php
					endif;

					$favorites_url = inspiry_get_favorites_url(); // Favorites page.
					if ( ! empty( $favorites_url ) ) :
						?>
                        <a href="<?php echo esc_url( $favorites_url ); ?>" class="rh_page__nav_item">
							<?php inspiry_safe_include_svg( '/images/icons/icon-dash-favorite.svg' ); ?>
                            <p><?php esc_html_e( 'Favorites', 'framework' ); ?></p>
                        </a>
					<?php endif; 

					if ( is_user_logged_in() && function_exists( 'IMS_Helper_Functions' ) ) {
						$ims_helper_functions  = IMS_Helper_Functions();
						$is_memberships_enable = $ims_helper_functions::is_memberships();
						$membership_url        = inspiry_get_membership_url(); // Memberships page.

						if ( ( ! empty( $is_memberships_enable ) ) && ! empty( $membership_url ) ) {
							?>
						<a href="<?php echo esc_url( $membership_url ); ?>" class="rh_page__nav_item">
							<?php inspiry_safe_include_svg( '/images/icons/icon-membership.svg' ); ?>
							<p><?php esc_html_e( 'Membership', 'framework' ); ?></p>
						</a>
							<?php
						}
					}
					?>
                </div>
            </div>
            <!-- /.rh_page__nav -->

        </div>
        <!-- /.rh_page__head -->

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>

				<?php if ( get_the_content() ) : ?>
                    <div class="rh_content rh_page__content">
						<?php the_content(); ?>
                    </div>
                    <!-- /.rh_content -->
				<?php endif; ?>

			<?php endwhile; ?>
		<?php endif; ?>

        <div class="rh_properties">
			<?php

			if ( ! is_user_logged_in() ) {
				$enable_user_nav = get_option( 'theme_enable_user_nav' );
				$theme_login_url = inspiry_get_login_register_url(); // Login and Register.

				if ( ! empty( $enable_user_nav ) && 'true' === $enable_user_nav ) {
					if ( empty( $theme_login_url ) ) {
						alert( esc_html__( 'Login Required:', 'framework' ), esc_html__( 'Please login to view your properties!', 'framework' ) );
					} elseif ( ! empty( $theme_login_url ) ) {
						alert( esc_html__( 'Login Required:', 'framework' ), sprintf( esc_html__( 'Please %1$s login %2$s to view your properties!', 'framework' ), '<a href="' . esc_url( $theme_login_url ) . '">', '</a>' ) );
					}
				} else {
					alert( esc_html__( 'Login Required:', 'framework' ), esc_html__( 'Please login to view your properties!', 'framework' ) );
				}
			} elseif ( is_user_logged_in() ) {

				if ( isset( $_GET['deleted'] ) && ( 1 == intval( $_GET['deleted'] ) ) ) {
					alert( esc_html__( 'Success:', 'framework' ), esc_html__( 'Property removed.', 'framework' ) );
				} elseif ( isset( $_GET['property-added'] ) && ( true == $_GET['property-added'] ) ) {
					alert( esc_html__( 'Success:', 'framework' ), inspiry_kses( get_option( 'theme_submit_message' ) ) );
				} elseif ( isset( $_GET['property-updated'] ) && ( true == $_GET['property-updated'] ) ) {
					alert( esc_html__( 'Success:', 'framework' ), esc_html__( 'Property Updated.', 'framework' ) );
				} elseif ( isset( $_GET['payment'] ) && ( 'paid' == $_GET['payment'] ) ) {
					alert( esc_html__( 'Success:', 'framework' ), esc_html__( 'Payment Submitted.', 'framework' ) );
				} elseif ( isset( $_GET['payment'] ) && ( 'failed' == $_GET['payment'] ) ) {
					alert( esc_html__( 'Error:', 'framework' ), esc_html__( 'Payment Failed.', 'framework' ) );
				}

				if ( class_exists( 'IMS_Helper_Functions' ) && is_user_logged_in() ) {

					// Membership enable option.
					$ims_helper_functions  = IMS_Helper_Functions();
					$is_memberships_enable = $ims_helper_functions::is_memberships();

					if ( ! empty( $is_memberships_enable ) ) {

						// Get current user.
						$ims_user = wp_get_current_user();

						// Get property numbers.
						$ims_membership = get_user_meta( $ims_user->ID, 'ims_current_membership', true );
						$ims_properties = get_user_meta( $ims_user->ID, 'ims_current_properties', true );
						$ims_featured   = get_user_meta( $ims_user->ID, 'ims_current_featured_props', true );

						$available_properties_heading          = esc_html__( 'Number of properties that you can publish:', 'framework' );
						$available_featured_properties_heading = esc_html__( 'Number of properties that can be marked as featured:', 'framework' );

						if ( ! empty( $ims_membership ) && ! empty( $ims_properties ) ) {
							$notices = array(
								'0' => array(
									'heading' => $available_properties_heading,
									'message' => $ims_properties,
								),
								'1' => array(
									'heading' => $available_featured_properties_heading,
									'message' => $ims_featured,
								),
							);
							display_notice( $notices );
						} elseif ( ! empty( $ims_membership ) && empty( $ims_properties ) ) {
							$notices = array(
								'0' => array(
									'heading' => $available_properties_heading,
									'message' => '',
								),
								'1' => array(
									'heading' => $available_featured_properties_heading,
									'message' => $ims_featured,
								),
							);
							display_notice( $notices );
						} elseif ( ! empty( $ims_membership ) && empty( $ims_featured ) ) {
							$notices = array(
								'0' => array(
									'heading' => $available_properties_heading,
									'message' => $ims_properties,
								),
								'1' => array(
									'heading' => $available_featured_properties_heading,
									'message' => '',
								),
							);
							display_notice( $notices );
						} elseif ( ! empty( $ims_membership ) && empty( $ims_properties ) && empty( $ims_featured ) ) {
							$notices = array(
								'0' => array(
									'heading' => $available_properties_heading,
									'message' => '',
								),
								'1' => array(
									'heading' => $available_featured_properties_heading,
									'message' => '',
								),
							);
							display_notice( $notices );
						} elseif ( empty( $ims_membership ) ) {
							alert( esc_html__( 'Please subscribe a membership package to start publishing properties.', 'framework' ) );
						}
					}
				}

				if ( ( $my_properties_query->have_posts() && 'show' == $my_properties_search ) || true == $prop_searched ) {
					?>
                    <div id="my-properties-search-wrap">
                        <form id="my-properties-search" class="clearfix">
							<?php
							$prop_search = '';
							if ( isset( $_GET['prop_search'] ) ) {
								$prop_search = $_GET['prop_search'];
							}
							?>
                            <input type="text" name="prop_search" placeholder="<?php esc_html_e( 'Search in your properties', 'framework' ); ?>" value="<?php echo esc_attr( $prop_search ); ?>">
                            <input type="submit" class="rh_btn--primary" value="<?php esc_html_e( 'Search', 'framework' ); ?>">
                        </form>
						<?php
						if ( isset( $_GET['prop_search'] ) && ! empty( $_GET['prop_search'] ) ) {
							?><h3><?php
							esc_html_e( 'Search results for: ', 'framework' );
							?><strong><?php echo esc_html( $_GET['prop_search'] ); ?></strong>
                            </h3><?php
						}
						?>
                    </div>
					<?php
				}

				if ( $my_properties_query->have_posts() ) :

					while ( $my_properties_query->have_posts() ) :

						$my_properties_query->the_post();

						get_template_part( 'assets/modern/partials/member/my-property' );

					endwhile;

					wp_reset_postdata();

				else :
					alert( esc_html__( 'Note:', 'framework' ), esc_html__( 'No Properties Found!', 'framework' ) );
				endif;

				inspiry_theme_pagination( $my_properties_query->max_num_pages );

			}
			?>

        </div>
        <!-- /.rh_properties -->

    </div>
    <!-- /.rh_page -->

</section>
<!-- /.rh_section rh_wrap rh_wrap--padding -->