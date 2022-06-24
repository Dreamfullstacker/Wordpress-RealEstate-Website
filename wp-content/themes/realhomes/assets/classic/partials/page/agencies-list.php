<?php
/**
 * Agencies Listing Template
 *
 * Page template for agency listing.
 *
 * @since   3.5.0
 * @package realhomes/classic
 */

get_header();

// Page Head.
get_template_part( 'assets/classic/partials/banners/default' );
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	?>

    <!-- Content -->
    <div class="container contents listing-grid-layout">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
        <div class="row">
            <div class="span9 main-wrap">
                <div class="main">
                    <section class="listing-layout">
						<?php
						$title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_page_title_display', true );
						if ( 'hide' !== $title_display ) {
							?><h3 class="title-heading"><?php the_title(); ?></h3><?php
						}
						?>
                        <div class="list-container inner-wrapper">
							<?php
							if ( 'show' === get_option( 'inspiry_agencies_sort_controls', 'hide' ) ) : ?>
                                <div class="sort-controls">
                                    <strong><?php esc_html_e( 'Sort By', 'framework' ); ?>:</strong>
                                    <select name="sort-properties" id="sort-properties" class="inspiry_select_picker_trigger">
										<?php inspiry_agency_sort_options(); ?>
                                    </select>
                                </div>
							<?php endif; ?>
							<?php
							$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer', true );

							if ( $get_content_position !== '1' ) {
								if ( have_posts() ) {
									while ( have_posts() ) {
										the_post();
										?>
                                        <article <?php post_class(); ?>>
											<?php the_content(); ?>
                                        </article>
										<?php
									}
								}
							}

							/*
							 * Agencies List
							 */
							$number_of_agencies = intval( get_option( 'inspiry_number_posts_agency', 3 ) );

							$paged = 1;
							if ( get_query_var( 'paged' ) ) {
								$paged = get_query_var( 'paged' );
							}

							$agencies_args = array(
								'post_type'      => 'agency',
								'posts_per_page' => $number_of_agencies,
								'paged'          => $paged,
							);

							$agencies_args  = inspiry_agencies_sort_args( $agencies_args );
							$agencies_query = new WP_Query( apply_filters( 'realhomes_agencies_list', $agencies_args ) );

							if ( $agencies_query->have_posts() ) :
								while ( $agencies_query->have_posts() ) :
									$agencies_query->the_post();
									?>
                                    <article class="about-agent clearfix">
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                                        <div class="row-fluid">
                                            <div class="span3">
												<?php
												if ( has_post_thumbnail() ) {
													?>
                                                    <figure class="agent-pic">
                                                        <a title="<?php the_title_attribute(); ?>"
                                                           href="<?php the_permalink(); ?>">
															<?php the_post_thumbnail( 'agent-image' ); ?>
                                                        </a>
                                                    </figure>
													<?php
												}
												?>
                                            </div>

                                            <div class="span9">
                                                <div class="agent-content">
                                                    <p><?php framework_excerpt( 45 ); ?></p>
                                                </div>
												<?php
												$agency_id = get_the_ID();
												/*
												 * Contact Info
												 */
												$agent_mobile       = get_post_meta( $agency_id, 'REAL_HOMES_mobile_number', true );
												$agent_whatsapp     = get_post_meta( $agency_id, 'REAL_HOMES_whatsapp_number', true );
												$agent_office_phone = get_post_meta( $agency_id, 'REAL_HOMES_office_number', true );
												$agent_office_fax   = get_post_meta( $agency_id, 'REAL_HOMES_fax_number', true );

												if ( ! empty( $agent_office_phone ) || ! empty( $agent_mobile ) || ! empty( $agent_office_fax ) ) {
													?>
                                                    <ul class="contacts-list">
														<?php
														if ( ! empty( $agent_office_phone ) ) {
															?>
                                                            <li class="office"><?php inspiry_safe_include_svg( '/images/icon-phone.svg' );
															esc_html_e( 'Office', 'framework' ); ?> :
                                                            <a href="tel:<?php echo esc_html( $agent_office_phone ); ?>"><?php echo esc_html( $agent_office_phone ); ?></a>
                                                            </li><?php
														}
														if ( ! empty( $agent_mobile ) ) {
															?>
                                                            <li class="mobile"><?php inspiry_safe_include_svg( '/images/icon-mobile.svg' );
															esc_html_e( 'Mobile', 'framework' ); ?> :
                                                            <a href="tel:<?php echo esc_html( $agent_mobile ); ?>"><?php echo esc_html( $agent_mobile ); ?></a>
                                                            </li><?php
														}
														if ( ! empty( $agent_office_fax ) ) {
															?>
                                                            <li class="fax"><?php inspiry_safe_include_svg( '/images/icon-printer.svg' );
															esc_html_e( 'Fax', 'framework' ); ?>  :
                                                            <a href="fax:<?php echo esc_html( $agent_office_fax ); ?>"><?php echo esc_html( $agent_office_fax ); ?></a>
                                                            </li><?php
														}
														if ( ! empty( $agent_whatsapp ) ) {
															?>
                                                            <li class="fax"><?php inspiry_safe_include_svg( '/images/icon-whatsapp.svg' );
															esc_html_e( 'WhatsApp', 'framework' ); ?>  :
                                                            <a href="https://wa.me/<?php echo esc_html( $agent_whatsapp ); ?>"><?php echo esc_html( $agent_whatsapp ); ?></a>
                                                            </li><?php
														}
														?>
                                                    </ul>
													<?php
												}
												?>

                                            </div>

                                        </div><!-- end of .row-fluid -->

                                        <div class="follow-agent clearfix">
                                            <a class="real-btn btn" href="<?php the_permalink(); ?>"><?php esc_html_e( 'More Details', 'framework' ); ?></a>
											<?php
											$facebook_url   = get_post_meta( $agency_id, 'REAL_HOMES_facebook_url', true );
											$twitter_url    = get_post_meta( $agency_id, 'REAL_HOMES_twitter_url', true );
											$linked_in_url  = get_post_meta( $agency_id, 'REAL_HOMES_linked_in_url', true );
											$instagram_url  = get_post_meta( $agency_id, 'inspiry_instagram_url', true );
											$youtube_url    = get_post_meta( $agency_id, 'inspiry_youtube_url', true );
											$pinterest_url  = get_post_meta( $agency_id, 'inspiry_pinterest_url', true );
											$agency_website = get_post_meta( $agency_id, 'REAL_HOMES_website', true );

											if ( ! empty( $facebook_url ) || ! empty( $twitter_url ) || ! empty( $linked_in_url ) || ! empty( $instagram_url ) || ! empty( $agency_website ) || ! empty( $youtube_url ) || ! empty( $pinterest_url ) ) {
												?>
                                                <ul class="social_networks clearfix">
													<?php
													if ( ! empty( $agency_website ) ) {
														?>
                                                        <li class="website">
                                                            <a target="_blank"
                                                               href="<?php echo esc_url( $agency_website ); ?>"><i
                                                                        class="fas fa-globe fa-lg"></i></a>
                                                        </li>
														<?php
													}

													if ( ! empty( $facebook_url ) ) {
														?>
                                                        <li class="facebook">
                                                            <a target="_blank"
                                                               href="<?php echo esc_url( $facebook_url ); ?>"><i
                                                                        class="fab fa-facebook-f fa-lg"></i></a>
                                                        </li>
														<?php
													}

													if ( ! empty( $twitter_url ) ) {
														?>
                                                        <li class="twitter">
                                                            <a target="_blank"
                                                               href="<?php echo esc_url( $twitter_url ); ?>"><i
                                                                        class="fab fa-twitter fa-lg"></i></a>
                                                        </li>
														<?php
													}

													if ( ! empty( $linked_in_url ) ) {
														?>
                                                        <li class="linkedin">
                                                            <a target="_blank"
                                                               href="<?php echo esc_url( $linked_in_url ); ?>"><i
                                                                        class="fab fa-linkedin-in fa-lg"></i></a>
                                                        </li>
														<?php
													}

													if ( ! empty( $instagram_url ) ) {
														?>
                                                        <li class="instagram">
                                                            <a target="_blank"
                                                               href="<?php echo esc_url( $instagram_url ); ?>"><i
                                                                        class="fab fa-instagram fa-lg"></i></a>
                                                        </li>
														<?php
													}

													if ( ! empty( $youtube_url ) ) {
														?>
                                                        <li class="youtube">
                                                            <a target="_blank" href="<?php echo esc_url( $youtube_url ); ?>"><i class="fab fa-youtube fa-lg"></i></a>
                                                        </li>
														<?php
													}

													if ( ! empty( $pinterest_url ) ) {
														?>
                                                        <li class="pinterest">
                                                            <a target="_blank" href="<?php echo esc_url( $pinterest_url ); ?>"><i class="fab fa-pinterest fa-lg"></i></a>
                                                        </li>
														<?php
													}
													?>
                                                </ul>
												<?php
											}
											?>
                                        </div>

                                    </article>
								<?php
								endwhile;
								wp_reset_postdata();
							else :
								?>
                                <h4><?php esc_html_e( 'No Results Found!', 'framework' ); ?></h4>
							<?php
							endif;
							?>
                        </div>

						<?php theme_pagination( $agencies_query->max_num_pages ); ?>

                    </section>
                </div>
            </div>
			<?php get_sidebar( 'pages' ); ?>

        </div>

		<?php
		if ( '1' === $get_content_position ) {
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					?>
                    <article <?php post_class(); ?>>
						<?php the_content(); ?>
                    </article>
					<?php
				}
			}
		}
		?>

    </div><!-- End Content -->

	<?php
}
get_footer();
?>