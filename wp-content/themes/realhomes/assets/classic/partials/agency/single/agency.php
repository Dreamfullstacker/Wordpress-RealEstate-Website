<?php
/**
 * Single Agency
 *
 * Single agency template part.
 *
 * @since    3.5.0
 * @package  realhomes/classic
 */

get_header();
?>

<!-- Page Head -->
<?php
get_template_part( 'assets/classic/partials/banners/default' );

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	?>

    <div class="container contents listing-grid-layout">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
        <div class="row">
            <div class="span9 main-wrap">
                <div class="main">
                    <section class="listing-layout">
                        <h3 class="title-heading"><?php the_title(); ?></h3>
                        <div class="list-container">
							<?php
							if ( have_posts() ) :
								while ( have_posts() ) :
									the_post();
									?>
                                    <article class="about-agent agent-single clearfix">
                                        <div class="detail">
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
														<?php the_content(); ?>
                                                    </div>
													<?php
													$agency_id = get_the_ID();
													/* Agency Contact Info */
													$agency_mobile       = get_post_meta( $agency_id, 'REAL_HOMES_mobile_number', true );
													$agency_whatsapp     = get_post_meta( $agency_id, 'REAL_HOMES_whatsapp_number', true );
													$agency_office_phone = get_post_meta( $agency_id, 'REAL_HOMES_office_number', true );
													$agency_office_fax   = get_post_meta( $agency_id, 'REAL_HOMES_fax_number', true );
													$agency_address      = get_post_meta( $agency_id, 'REAL_HOMES_address', true );

													if ( ! empty( $agency_mobile ) || ! empty( $agency_whatsapp ) || ! empty( $agency_office_phone ) || ! empty( $agency_office_fax ) || ! empty( $agency_address ) ) {
														?>
                                                        <hr/>
                                                        <h5><?php esc_html_e( 'Contact Details', 'framework' ); ?></h5>
                                                        <ul class="contacts-list">
															<?php
															if ( ! empty( $agency_office_phone ) ) {
																?>
                                                                <li class="office">
																	<?php
																	inspiry_safe_include_svg( '/images/icon-phone.svg' );
																	esc_html_e( 'Office', 'framework' );
																	?>
                                                                    :
                                                                    <a href="tel:<?php echo esc_html( $agency_office_phone ); ?>"><?php echo esc_html( $agency_office_phone ); ?></a>
                                                                </li>
																<?php
															}
															if ( ! empty( $agency_mobile ) ) {
																?>
                                                                <li class="mobile">
																	<?php
																	inspiry_safe_include_svg( '/images/icon-mobile.svg' );
																	esc_html_e( 'Mobile', 'framework' );
																	?>
                                                                    :
                                                                    <a href="tel:<?php echo esc_html( $agency_mobile ); ?>"><?php echo esc_html( $agency_mobile ); ?></a>
                                                                </li>
																<?php
															}
															if ( ! empty( $agency_office_fax ) ) {
																?>
                                                                <li class="fax">
																	<?php
																	inspiry_safe_include_svg( '/images/icon-printer.svg' );
																	esc_html_e( 'Fax', 'framework' );
																	?>
                                                                    :
                                                                    <a href="fax:<?php echo esc_html( $agency_office_fax ); ?>"><?php echo esc_html( $agency_office_fax ); ?></a>
                                                                </li>
																<?php
															}
															if ( ! empty( $agency_whatsapp ) ) {
																?>
                                                                <li class="whatsapp">
																	<?php
																	inspiry_safe_include_svg( '/images/icon-whatsapp.svg' );
																	esc_html_e( 'WhatsApp', 'framework' );
																	?>
                                                                    :
                                                                    <a href="https://wa.me/<?php echo esc_html( $agency_whatsapp ); ?>"><?php echo esc_html( $agency_whatsapp ); ?></a>
                                                                </li>
																<?php
															}

															if ( ! empty( $agency_address ) ) {
																?>
                                                                <li class="address">
																	<?php
																	inspiry_safe_include_svg( '/images/icon-map.svg' );
																	esc_html_e( 'Address', 'framework' );
																	?>
                                                                    :
                                                                    <span><?php echo esc_html( $agency_address ); ?></span>
                                                                </li>
																<?php
															}
															?>
                                                        </ul>
														<?php
													}

													get_template_part( 'assets/classic/partials/agency/single/contact-form' );
													?>
                                                </div>
                                            </div><!-- end of .row-fluid -->
                                        </div>
                                        <div class="follow-agent clearfix">
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
							endif;

							$number_of_posts = intval( get_option( 'inspiry_number_of_agents_agency', 3 ) );

							$paged = 1;
							if ( get_query_var( 'paged' ) ) {
								$paged = get_query_var( 'paged' );
							}

							$agency_agents_args = array(
								'post_type'      => 'agent',
								'posts_per_page' => $number_of_posts,
								'meta_query'     => array(
									array(
										'key'     => 'REAL_HOMES_agency',
										'value'   => $agency_id,
										'compare' => '=',
									),
								),
								'paged'          => $paged
							);

							$agency_agents_query = new WP_Query( apply_filters( 'realhomes_agency_agents', $agency_agents_args ) );

							if ( $agency_agents_query->have_posts() ) :

								echo '<h4>' . esc_html__( 'Our Agents:', 'framework' ) . '</h4>';

								while ( $agency_agents_query->have_posts() ) :
									$agency_agents_query->the_post();
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
												$agent_id = get_the_ID();
												/* Agent Contact Info */
												$agent_mobile       = get_post_meta( $agent_id, 'REAL_HOMES_mobile_number', true );
												$agent_whatsapp     = get_post_meta( $agent_id, 'REAL_HOMES_whatsapp_number', true );
												$agent_office_phone = get_post_meta( $agent_id, 'REAL_HOMES_office_number', true );
												$agent_office_fax   = get_post_meta( $agent_id, 'REAL_HOMES_fax_number', true );
												$agent_address      = get_post_meta( $agent_id, 'REAL_HOMES_address', true );

												if ( ! empty( $agent_mobile ) || ! empty( $agent_whatsapp ) || ! empty( $agent_office_phone ) || ! empty( $agent_office_fax ) || ! empty( $agent_address ) ) {
													?>
                                                    <ul class="contacts-list">
														<?php
														if ( ! empty( $agent_office_phone ) ) {
															?>
                                                            <li class="office"><?php inspiry_safe_include_svg( '/images/icon-phone.svg' );
																esc_html_e( 'Office', 'framework' ); ?> : <a
                                                                        href="tel:<?php echo esc_html( $agent_office_phone ); ?>"><?php echo esc_html( $agent_office_phone ); ?></a>
                                                            </li>
															<?php
														}
														if ( ! empty( $agent_mobile ) ) {
															?>
                                                            <li class="mobile"><?php inspiry_safe_include_svg( '/images/icon-mobile.svg' );
																esc_html_e( 'Mobile', 'framework' ); ?> : <a
                                                                        href="tel:<?php echo esc_html( $agent_mobile ); ?>"><?php echo esc_html( $agent_mobile ); ?></a>
                                                            </li>
															<?php
														}
														if ( ! empty( $agent_office_fax ) ) {
															?>
                                                            <li class="fax"><?php inspiry_safe_include_svg( '/images/icon-printer.svg' );
															esc_html_e( 'Fax', 'framework' ); ?>  : <a
                                                                    href="fax:<?php echo esc_html( $agent_office_fax ); ?>"><?php echo esc_html( $agent_office_fax ); ?></a>
                                                            </li><?php
														}
														if ( ! empty( $agent_whatsapp ) ) {
															?>
                                                            <li class="whatsapp"><?php inspiry_safe_include_svg( '/images/icon-whatsapp.svg' );
															esc_html_e( 'WhatsApp', 'framework' ); ?>  : <a
                                                                    href="https://wa.me/<?php echo esc_html( $agent_whatsapp ); ?>"><?php echo esc_html( $agent_whatsapp ); ?></a>
                                                            </li><?php
														}

														if ( ! empty( $agent_address ) ) {
															?>
                                                            <li class="address"><?php inspiry_safe_include_svg( '/images/icon-map.svg' );;
																esc_html_e( 'Address', 'framework' ); ?> :
                                                                <span><?php echo esc_html( $agent_address ); ?></span>
                                                            </li>
															<?php
														}
														?>
                                                    </ul>
													<?php
												}
												?>
                                            </div>
                                        </div><!-- end of .row-fluid -->

                                        <div class="follow-agent clearfix">
                                            <a class="real-btn btn"
                                               href="<?php the_permalink(); ?>"><?php esc_html_e( 'More Details', 'framework' ); ?></a>
											<?php
											$facebook_url  = get_post_meta( $agent_id, 'REAL_HOMES_facebook_url', true );
											$twitter_url   = get_post_meta( $agent_id, 'REAL_HOMES_twitter_url', true );
											$linked_in_url = get_post_meta( $agent_id, 'REAL_HOMES_linked_in_url', true );
											$instagram_url = get_post_meta( $agent_id, 'inspiry_instagram_url', true );
											$youtube_url   = get_post_meta( $agent_id, 'inspiry_youtube_url', true );
											$pinterest_url = get_post_meta( $agent_id, 'inspiry_pinterest_url', true );
											$agent_website = get_post_meta( $agent_id, 'REAL_HOMES_website', true );

											if ( ! empty( $facebook_url ) || ! empty( $twitter_url ) || ! empty( $linked_in_url ) || ! empty( $instagram_url ) || ! empty( $agent_website ) || ! empty( $youtube_url ) || ! empty( $pinterest_url ) ) {
												?>
                                                <ul class="social_networks clearfix">
													<?php
													if ( ! empty( $agent_website ) ) {
														?>
                                                        <li class="website">
                                                            <a target="_blank"
                                                               href="<?php echo esc_url( $agent_website ); ?>"><i
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
							endif;
							?>
                        </div>
						<?php theme_pagination( $agency_agents_query->max_num_pages ); ?>
                    </section>
                </div><!-- End Main Content -->
            </div> <!-- End span9 -->

			<?php get_sidebar( 'agency' ); ?>

        </div><!-- End contents row -->
    </div><!-- End Content -->

	<?php
}
    get_footer();
    ?>