<?php
/**
 * View: Property List Card
 *
 * Property card for listing view.
 *
 * @since    3.0.0
 * @package  realhomes
 */

global $post;
$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
$is_featured        = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );

?>

<article class="rh_list_card">

    <div class="rh_list_card__wrap">

        <figure class="rh_list_card__thumbnail">
            <div class="rh_figure_property_list_one">
				<?php if ( $is_featured ) : ?>
                    <div class="rh_label rh_label__list">
                        <div class="rh_label__wrap">
							<?php esc_html_e( 'Featured', 'framework' ); ?>
                            <span></span>
                        </div>
                    </div>                <!-- /.rh_label -->
				<?php endif; ?>

                <a href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?><?php $post_thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'property-thumb-image' ); ?>
                        <div class="post_thumbnail"
                             style="background: url('<?php echo esc_url( $post_thumbnail_url ); ?>') 50% 50% no-repeat; background-size: cover;"></div>                    <!-- /.post_thumbnail -->
					<?php else : ?><?php $post_thumbnail_url = get_inspiry_image_placeholder_url( 'property-thumb-image' ); ?>
                        <div class="post_thumbnail"
                             style="background: url('<?php echo esc_url( $post_thumbnail_url ); ?>') 50% 50% no-repeat; background-size: cover;"></div>                    <!-- /.post_thumbnail -->
					<?php endif; ?>
                </a>

                <div class="rh_overlay"></div>
                <div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
                    <a href="<?php the_permalink(); ?>"><?php inspiry_property_detail_page_link_text(); ?></a>
                </div>
                <!-- /.rh_overlay__contents -->

				<?php inspiry_display_property_label( get_the_ID() ); ?>

            </div>
            <div class="rh_list_card__btns">

				<?php
				inspiry_favorite_button(); // Display add to favorite button.
				inspiry_add_to_compare_button(); // Display add to compare button.
				?>
            </div>
            <!-- /.rh_list_card__btns -->
        </figure>
        <!-- /.rh_list_card__thumbnail -->

        <div class="rh_list_card__details_wrap">

            <div class="rh_list_card__details">

                <h3>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
				<?php

				if ( inspiry_is_rvr_enabled() ) {
					?>
                    <div class="rh_rvr_ratings_wrapper_stylish inspiry_rating_left inspiry_rating_margin_bottom">
						<?php
						if ( 'property' === $post->post_type && 'true' === get_option( 'inspiry_property_ratings', 'false' ) ) {
							inspiry_rating_average();
						}

						?>
<!--                        <div class="rh_address_sty">-->
<!--                            <a href="--><?php //the_permalink(); ?><!--">-->
<!--                                <span class="rh_address_pin">--><?php //include RHEA_ASSETS_DIR . 'icons/pin.svg'; ?><!--</span>-->
<!--								--><?php
//								$REAL_HOMES_property_address = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
//								echo esc_html( $REAL_HOMES_property_address );
//								?>
<!--                            </a>-->
<!--                        </div>-->
                    </div>
					<?php
				}
				$theme_listing_excerpt_length = get_option( 'theme_listing_excerpt_length' );

				if ( ! empty( $theme_listing_excerpt_length ) && ( 0 < $theme_listing_excerpt_length ) ) {
					$card_excerpt = $theme_listing_excerpt_length;
				} else {
					$card_excerpt = 5;
				}
				?>
                <p class="rh_list_card__excerpt"><?php framework_excerpt( $card_excerpt ); ?></p>
                <!-- /.rh_list_card__excerpt -->

                <div class="rh_list_card__meta_wrap">

					<?php 
						get_template_part( 'assets/modern/partials/properties/card-parts/grid-card-meta' );	
					?>

                </div>
                <!-- /.rh_list_card__meta_wrap -->

            </div>
            <!-- /.rh_list_card__details -->

            <div class="rh_list_card__priceLabel">

                <div class="rh_list_card__price">
					<span class="status">
						<?php echo esc_html( display_property_status( get_the_ID() ) ); ?>
					</span>
                    <!-- /.rh_prop_card__type -->

                    <p class="price">
						<?php
						if ( function_exists( 'ere_property_price' ) ) {
							ere_property_price( '', true );
						}
						?>
                    </p>
                    <!-- /.price -->
                </div>
                <!-- /.rh_list_card__price -->

				<?php
				if ( inspiry_is_rvr_enabled() ) {
					$REAL_HOMES_property_owner = get_post_meta( get_the_ID(), 'rvr_property_owner', true );
					if ( ! empty( $REAL_HOMES_property_owner ) ) {
						?>
                        <p class="rh_list_card__author">
							<?php esc_html_e( 'By', 'framework' ); ?>
                            <span class="author"><?php echo esc_html( get_the_title($REAL_HOMES_property_owner) ); ?></span>

                        </p>
						<?php
					}
				} else {
					$agent_display_option = get_post_meta( get_the_ID(), 'REAL_HOMES_agent_display_option', true );
					if ( ( ! empty( $agent_display_option ) ) && ( 'none' !== $agent_display_option ) ) {
						if ( 'my_profile_info' === $agent_display_option ) {
							$author_display_name = get_the_author_meta( 'display_name' );
							if ( ! empty( $author_display_name ) ) {
								?>
                                <p class="rh_list_card__author">
									<?php esc_html_e( 'By', 'framework' ); ?>
                                    <span class="author"><?php echo esc_html( $author_display_name ); ?></span>
                                </p>                            <!-- /.rh_list_card__author -->
								<?php
							}
						} else {
							$agents_names = inspiry_get_property_agents_names();
							if ( ! empty( $agents_names ) ) {
								?>
                                <p class="rh_list_card__author">
									<?php esc_html_e( 'By', 'framework' ); ?>
                                    <span class="author"><?php echo esc_html( $agents_names ); ?></span>
                                </p>                            <!-- /.rh_list_card__author -->
								<?php
							}
						}
					}
				}
				?>

            </div>
            <!-- /.rh_list_card__priceLabel -->

        </div>
        <!-- /.rh_list_card__details_wrap -->

    </div>
    <!-- /.rh_list_card__wrap -->

</article><!-- /.rh_list_card -->
