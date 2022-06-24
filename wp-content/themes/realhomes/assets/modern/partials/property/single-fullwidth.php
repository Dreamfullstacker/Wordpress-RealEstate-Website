<?php
/**
 * Template for Single Property Fullwidth
 */

get_header();

$get_header_variations = apply_filters( 'inspiry_header_variation', get_option( 'inspiry_header_mod_variation_option', 'one' ) );
$gallery_slider_type   = get_post_meta( get_the_ID(), 'REAL_HOMES_gallery_slider_type', true );
$change_slider_type    = get_post_meta( get_the_ID(), 'REAL_HOMES_change_gallery_slider_type', true );

if ( '1' !== $change_slider_type ) {
	$gallery_slider_type = get_option( 'inspiry_gallery_slider_type', 'thumb-on-right' );
}
$advance_search_class = '';
if ( 'carousel-style' === $gallery_slider_type || 'masonry-style' === $gallery_slider_type || 'fw-carousel-style' === $gallery_slider_type ) {
	$header_variation = get_option( 'inspiry_property_detail_header_variation' );
	if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
		get_template_part( 'assets/modern/partials/banner/header' );
	} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
		// Banner Image.
		$banner_image_path = '';
		$banner_image_id   = get_post_meta( get_the_ID(), 'REAL_HOMES_page_banner_image', true );
		if ( $banner_image_id ) {
			$banner_image_path = wp_get_attachment_url( $banner_image_id );
		} else {
			$banner_image_path = get_default_banner();
		}
		?>
        <section class="rh_banner rh_banner__image rh_banner_image_full_width" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">
            <div class="rh_banner__wrap"></div><!-- /.rh_banner__wrap -->
        </section><!-- /.rh_banner -->
		<?php
	}
	$advance_search_class = 'carousel-masonry-style';
}
?>
    <div class="selected-header-variation-<?php
	echo esc_attr( $get_header_variations );
	echo esc_attr( $advance_search_class );
	?>
	">
		<?php
		if ( inspiry_show_header_search_form() ) {
			$REAL_HOMES_hide_property_advance_search = get_post_meta( get_the_ID(), 'REAL_HOMES_hide_property_advance_search', true );
			if ( ! $REAL_HOMES_hide_property_advance_search ) {
				get_template_part( 'assets/modern/partials/properties/search/advance' );
			}
		}
		?>
    </div>

    <div class="single-property-fullwidth">
		<?php
		// Property detail page sections
		$sortable_property_sections = array(
			'content'                   => 'true',
			'additional-details'        => 'true',
			'common-note'               => get_option( 'theme_display_common_note', 'true' ),
			'features'                  => 'true',
			'attachments'               => get_option( 'theme_display_attachments', 'true' ),
			'floor-plans'               => 'true',
			'video'                     => get_option( 'theme_display_video', 'true' ),
			'virtual-tour'              => get_option( 'inspiry_display_virtual_tour', 'false' ),
			'map'                       => get_option( 'theme_display_google_map', 'true' ),
			'walkscore'                 => get_option( 'inspiry_display_walkscore', 'false' ),
			'yelp-nearby-places'        => get_option( 'inspiry_display_yelp_nearby_places', 'false' ),
			'energy-performance'        => get_option( 'inspiry_display_energy_performance', 'true' ),
			'property-views'            => get_option( 'inspiry_display_property_views', 'true' ),
			'rvr/guests-accommodation'  => get_option( 'inspiry_guests_accommodation_display', 'true' ),
			'rvr/price-details'         => get_option( 'inspiry_price_details_display', 'true' ),
			'rvr/seasonal-prices'       => get_option( 'inspiry_seasonal_prices_display', 'true' ),
			'rvr/availability-calendar' => get_option( 'inspiry_display_availability_calendar', 'true' ),
			'children'                  => 'true',
			'agent'                     => get_option( 'theme_display_agent_info', 'true' ),
			'mortgage-calculator'       => get_option( 'inspiry_mc_display', 'false' ),
		);

		$property_sections_order = array_keys( $sortable_property_sections );
		$order_settings          = get_theme_mod( 'inspiry_property_sections_order_default', 'default' );
		if ( 'custom' === $order_settings ) {
			$property_sections_order_string = get_option( 'inspiry_property_sections_order_mod' );
			$property_sections_order        = array_unique( array_merge( explode( ',', $property_sections_order_string ), $property_sections_order ) );
		}

		if ( have_posts() ) :

			while ( have_posts() ) :
				the_post();

				if ( ! post_password_required() ) :

					global $post;
					if ( 'carousel-style' === $gallery_slider_type || 'masonry-style' === $gallery_slider_type || 'fw-carousel-style' === $gallery_slider_type ) {
						get_template_part( 'assets/modern/partials/property/single/head' );
					}
					/**
					 * Property Slider.
					 */
					get_template_part( 'assets/modern/partials/property/single-fullwidth/slider' );
					?>

                    <div id="primary" class="content-area rh_property">
						<?php

						// Display the login form if login is required and user is not logged in
						$prop_detail_login = inspiry_prop_detail_login();
						if ( 'yes' == $prop_detail_login && ! is_user_logged_in() ) {
							?>
                            <div class="content-wrapper single-property-section">
                                <div class="container">
                                    <div class="rh_form rh_form__login_wrap rh_property_detail_login">
										<?php get_template_part( 'assets/modern/partials/member/login-form' ); ?>
										<?php get_template_part( 'assets/modern/partials/member/register-form' ); ?>
                                    </div>
                                </div>
                            </div>
							<?php
						} elseif ( ! empty( $property_sections_order ) && is_array( $property_sections_order ) ) {
							// Display sections according to their order
							foreach ( $property_sections_order as $section ) {
								if ( isset( $sortable_property_sections[ $section ] ) && 'true' === $sortable_property_sections[ $section ] ) {
									get_template_part( 'assets/modern/partials/property/single-fullwidth/' . $section );
								}
							}
						}

						/**
						 * Similar Properties.
						 */
						get_template_part( 'assets/modern/partials/property/single-fullwidth/similar-properties' );

						/**
						 * Comments
						 * If comments are open or we have at least one comment, load up the comment template.
						 */
						if ( comments_open() || get_comments_number() ) :
							?>
                            <div class="comments-content-wrapper single-property-section">
                                <div class="container">
									<?php comments_template(); ?>
                                </div>
                            </div>
						<?php endif; ?>
                    </div><!-- /.content-area -->
				<?php else : ?>
                    <div id="primary" class="content-area">
						<?php echo get_the_password_form(); ?>
                    </div><!-- /.content-area -->
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
    </div><!-- /.single-property-fullwidth -->
<?php
get_footer();
