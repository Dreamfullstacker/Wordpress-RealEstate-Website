<?php
/**
 * Properties Slider
 *
 * @package    realhomes
 * @subpackage classic
 */

$number_of_slides = intval( get_post_meta( get_the_ID(), 'theme_number_of_slides_cfos', true ) );
if ( ! $number_of_slides ) {
	$number_of_slides = - 1;
}

$theme_cpt_cfoss = get_post_meta( get_the_ID(), 'theme_cpt_cfoss', true );

if ( $theme_cpt_cfoss == 'slide' ) {
	$slider_args = array(
		'post_type'      => 'slide',
		'posts_per_page' => $number_of_slides,
	);
} else {
	$slider_args = array(
		'post_type'      => 'property',
		'posts_per_page' => $number_of_slides,
		'meta_query'     => array(
			array(
				'key'     => 'REAL_HOMES_add_in_slider',
				'value'   => 'yes',
				'compare' => 'LIKE',
			),
		),
	);
}


$slider_query = new WP_Query( $slider_args );

if ( $slider_query->have_posts() ) : ?>
    <!-- Slider -->

    <div id="home-flexslider" class="clearfix rh_cfos_slider">
		<?php
		$theme_cfos_rev_alias = get_post_meta( get_the_ID(), 'theme_cfos_rev_alias' );

		if ( function_exists( 'putRevSlider' ) && ( ! empty( $theme_cfos_rev_alias ) ) ) {
			putRevSlider( $theme_cfos_rev_alias );
		} else {
			?>
            <div class="flexslider loading">

				<?php

				if ( $theme_cpt_cfoss == 'slide' ) {
					?>
                    <ul class="slides">
						<?php

						while ( $slider_query->have_posts() ) {
							$slider_query->the_post();
							if ( has_post_thumbnail() ) {
								$image_id         = get_post_thumbnail_id();
								$slider_image_url = wp_get_attachment_url( $image_id );
								$slide_title      = get_the_title();
								$slide_sub_text   = get_post_meta( get_the_ID(), 'slide_sub_text', true );
								$slide_url        = get_post_meta( get_the_ID(), 'slide_url', true );
								if ( ! empty( $slide_url ) ) {
									$slide_url = addhttp( $slide_url );
								}

								?>
                                <li>
                                    <a class="slide" href="<?php the_permalink(); ?>"
                                       style="background: url('<?php echo esc_url( $slider_image_url ); ?>') 50% 50% no-repeat;
                                               background-size: cover;">
                                    </a>
                                    <div class="desc-wrap cfos_slide_visible_sm">
										<?php
										if ( ! empty( $slide_title ) || ! empty( $slide_sub_text ) ) {
											?>
                                            <div class="slide-description ">
												<?php
												if ( ! empty( $slide_title ) ) {
													?>
                                                    <h3>
														<?php
														if ( $slide_url ) {
															echo '<a href="' . esc_url( $slide_url ) . '">';
															echo esc_html( $slide_title );
															echo '</a>';
														} else {
															echo esc_html( $slide_title );
														}
														?>
                                                    </h3>
													<?php

												}

												if ( ! empty( $slide_sub_text ) ) {
													echo '<p>' . $slide_sub_text . '</p>';
												}

												if ( ! empty( $slide_url ) ) {
													$button_label = get_option( 'inspiry_string_know_more', esc_html__( 'Know More', 'framework' ) );
													echo '<a href="' . esc_url( $slide_url ) . '" class="know-more">' . $button_label . '</a>';
												}
												?>
                                            </div>
											<?php

										}
										?>
                                    </div>

                                </li>
								<?php
							}
						}
						wp_reset_postdata();
						?>
                    </ul>
					<?php
				} else {
					?>
                    <ul class="slides">
						<?php
						while ( $slider_query->have_posts() ) :
							$slider_query->the_post();
							$slider_image_id = get_post_meta( get_the_ID(), 'REAL_HOMES_slider_image', true );
							if ( $slider_image_id ) {
								$slider_image_url = wp_get_attachment_url( $slider_image_id );
								?>
                                <li>
                                    <a class="slide" href="<?php the_permalink(); ?>"
                                       style="background: url('<?php echo esc_url( $slider_image_url ); ?>') 50% 50% no-repeat;
                                               background-size: cover;">
                                    </a>
                                    <div class="desc-wrap cfos_slide_visible_sm">
                                        <div class="slide-description">
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <p><?php framework_excerpt( 15 ); ?></p>
											<?php
											$price = null;

											if ( function_exists( 'ere_get_property_price' ) ) {
												$price = ere_get_property_price();
											}

											if ( $price ) {
												echo '<span>' . esc_html( $price ) . '</span>';
											}

											$button_label = get_option( 'inspiry_string_know_more', esc_html__( 'Know More', 'framework' ) );
											?>
                                            <a href="<?php the_permalink(); ?>"
                                               class="know-more"><?php echo esc_html( $button_label ); ?></a>
                                        </div>
                                    </div>

                                </li>
								<?php
							}
						endwhile;
						wp_reset_postdata();
						?>
                    </ul>
					<?php
				}
				?>

            </div>

			<?php
		}
		get_template_part( 'assets/classic/partials/home/slider/cfos' );
		?>

    </div><!-- End Slider -->
<?php

else :
	get_template_part( 'assets/classic/partials/banners/default' );
endif;
?>
