<?php
/**
 * Grid Property Card
 *
 */
global $properties_query;
global $settings;
global $widget_id;
$show_fav_button         = $settings['ere_enable_fav_properties'];
$fav_label               = $settings['ere_property_fav_label'];
$fav_added_label         = $settings['ere_property_fav_added_label'];
$view_property_label     = $settings['ere_property_view_prop_label'];
$ere_property_grid_image = $settings['ere_property_grid_thumb_sizes'];
$prop_excerpt_length     = $settings['prop_excerpt_length'];

?>

<div class="container-latest-properties">
    <div class="wrapper-section-contents">
        <div class="home-properties-section-inner home-properties-section-inner-target">
			<?php
			if ( $properties_query->have_posts() ) { ?>
                <div class="rh_properties_element rh_properties_pagination_append">
				<?php
				while ( $properties_query->have_posts() ) {
					$properties_query->the_post();

					$REAL_HOMES_property_address = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
					$is_featured                 = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );

					?>
                    <div class="wrapper_properties_ele">

                        <article class="rh_prop_card_elementor">

                            <div class="rh_prop_card__wrap">

								<?php if ( $is_featured ) : ?>
                                    <div class="rh_label_elementor rh_label__property_elementor">
                                        <div class="rh_label__wrap">
											<?php
											if ( ! empty( $settings['ere_property_featured_label'] ) ) {
												echo esc_html( $settings['ere_property_featured_label'] );
											} else {
												esc_html_e( 'Featured', 'realhomes-elementor-addon' );
											}
											?>
                                            <span></span>
                                        </div>
                                    </div>
								<?php endif; ?>

                                <figure class="rh_prop_card__thumbnail">
                                    <div class="rhea_figure_property_one">
                                        <div class="rhea_top_tags_box">
	                                    <?php
	                                    if ( $settings['ere_show_property_media_count'] == 'yes' ) {
		                                    rhea_get_template_part( 'assets/partials/stylish/media-count' );
	                                    }
	                                    ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>">
											<?php
											if ( has_post_thumbnail( get_the_ID() ) ) {
												the_post_thumbnail( $ere_property_grid_image );
											} else {
												inspiry_image_placeholder( $ere_property_grid_image );
											}
											?>
                                        </a>

                                        <div class="rh_overlay"></div>
                                        <div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
                                            <a href="<?php the_permalink(); ?>"><?php
												if ( ! empty( $view_property_label ) ) {
													echo esc_html( $view_property_label );
												} else {
													echo esc_attr__( 'View Property', 'realhomes-elementor-addon' );
												};
												?>
                                            </a>
                                        </div>
										<?php rhea_display_property_label( get_the_ID() ); ?>

                                    </div>

                                    <div class="rh_prop_card__btns">
										<?php
										if ( 'yes' === $settings['ere_enable_fav_properties'] ) {
											if ( function_exists( 'inspiry_favorite_button' ) ) {
												inspiry_favorite_button( get_the_ID(), null, $settings['ere_property_fav_label'], $settings['ere_property_fav_added_label'] );
											}
										}
										rhea_get_template_part( 'assets/partials/stylish/compare' );
										?>
                                    </div>
                                </figure>

                                <div class="rh_prop_card__details_elementor">

                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<?php if ( 'yes' == $settings['show_excerpt'] ) { ?>

                                        <p class="rh_prop_card__excerpt"><?php rhea_framework_excerpt( esc_html( $prop_excerpt_length ) ); ?></p>

										<?php
									}
									if ( 'yes' == $settings['show_address'] ) {
										if ( isset( $REAL_HOMES_property_address ) && ! empty( $REAL_HOMES_property_address ) ) {
											?>
                                            <div class="rhea_address_sty">
                                                <a
	                                                <?php rhea_lightbox_data_attributes( $widget_id, get_the_ID() ) ?>
                                                        href="<?php the_permalink(); ?>"
                                                >

                                                    <span class="rhea_address_pin"><?php include RHEA_ASSETS_DIR . 'icons/pin.svg'; ?></span>
													<?php echo esc_html( $REAL_HOMES_property_address ); ?>
                                                </a>
                                            </div>
											<?php
										}
									}
									?>

                                    <div class="rh_prop_card__meta_wrap_elementor">

										<?php rhea_get_template_part( 'assets/partials/stylish/grid-card-meta' ); ?>

                                    </div>

                                    <div class="rh_prop_card__priceLabel <?php if ( inspiry_is_rvr_enabled() ) {
										echo esc_attr( 'rhea_rvr_ratings_wrapper' );
									} ?>">
                                        <div class="rhea_property_price_box">
                                            <span class="rh_prop_card__status">
                                                <?php
                                                if ( function_exists( 'ere_get_property_statuses' ) ) {
	                                                echo esc_html( ere_get_property_statuses( get_the_ID() ) );
                                                }
                                                ?>
                                            </span>
                                            <p class="rh_prop_card__price">
												<?php
												if ( function_exists( 'ere_property_price' ) ) {
													ere_property_price();
												}
												?>
                                            </p>

                                        </div>
										<?php if ( inspiry_is_rvr_enabled() && 'yes' == $settings['rhea_rating_enable'] ) { ?>
                                            <div class="rhea_rvr_ratings rvr_rating_right">
												<?php rhea_rvr_rating_average(); ?>
                                            </div>
										<?php } ?>
                                    </div>

                                </div>

                            </div>

                        </article>

                    </div>
					<?php
				}
				wp_reset_postdata();
				?>
                </div><?php
			}

			if ( 'yes' == $settings['show_pagination'] ) {
				?>
                <div class="rhea_svg_loader">
					<?php include RHEA_ASSETS_DIR . '/icons/loading-bars.svg'; ?>
                </div>
				<?php
				RHEA_ajax_pagination( $properties_query->max_num_pages );
			}
			?>
        </div>
    </div>
</div>
<!-- /.rh_prop_card -->
