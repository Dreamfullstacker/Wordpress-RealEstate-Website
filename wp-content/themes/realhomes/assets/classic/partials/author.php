<?php
/**
 * Author Template
 *
 * @package realhomes
 * @subpackage classic
 */

if ( is_singular( 'agent' ) ) {
	global $post;
} elseif ( is_author() ) {
	global $current_author;
}

get_header(); ?>

<div class="page-head" style="background-image: url('<?php echo get_default_banner(); ?>');">
	<div class="container">
		<div class="wrap clearfix">
			<h1 class="page-title"><span><?php esc_html_e( 'All Properties By', 'framework' ); ?></span></h1>
		</div>
	</div>
</div><!-- End Page Head -->

<!-- Content -->
<div class="container contents listing-grid-layout">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="row">

		<div class="span9 main-wrap">

			<!-- Main Content -->
			<div class="main">

				<section class="listing-layout">

					<?php
					// Get Author Information.
					global $wp_query;
					$current_author      = $wp_query->get_queried_object();
					$current_author_id   = $current_author->ID;
					$current_author_meta = get_user_meta( $current_author_id );

					// Display Author Name.
					if ( ! empty( $current_author->display_name ) ) {
						?><h3 class="title-heading"><?php echo esc_html( $current_author->display_name ); ?></h3><?php
					}
					?>

					<div class="list-container">

						<article class="about-agent agent-single clearfix">

							<div class="detail">

								<div class="row-fluid">

									<div class="span3">
										<?php
										// Author profile image.
										if ( isset( $current_author_meta['profile_image_id'] ) ) {
											$profile_image_id = intval( $current_author_meta['profile_image_id'][0] );
											if ( $profile_image_id ) {
												echo '<figure class="agent-pic">';
												echo wp_get_attachment_image( $profile_image_id, 'agent-image' );
												echo '</figure>';
											}
										} elseif ( function_exists( 'get_avatar' ) ) {
											echo '<figure class="agent-pic">';
											echo get_avatar( $current_author->user_email, '210' );
											echo '</figure>';
										}
										?>
									</div>

									<div class="span9">

										<div class="agent-content">
											<?php
											// Author description.
											if ( isset( $current_author_meta['description'] ) ) {
												echo '<p>';
												echo esc_html( $current_author_meta['description'][0] );
												echo '</p>';
											}
											?>
										</div>

										<?php
										// Author Contact Info.
										if ( isset( $current_author_meta['mobile_number'] ) || isset( $current_author_meta['office_number'] ) || isset( $current_author_meta['fax_number'] ) ) {
											?>
											<hr/>
											<h5><?php esc_html_e( 'Contact Details', 'framework' ); ?></h5>
											<ul class="contacts-list">
												<?php
												if ( ! empty( $current_author_meta['office_number'][0] ) ) {
													?>
													<li class="office">
														<?php
														inspiry_safe_include_svg( '/images/icon-phone.svg' );
														esc_html_e( 'Office', 'framework' );
													?>
													: <a href="tel:<?php echo esc_html( $current_author_meta['office_number'][0] ); ?>"><?php echo esc_html( $current_author_meta['office_number'][0] ); ?></a>
                                                    </li>
													<?php
												}

												if ( ! empty( $current_author_meta['mobile_number'][0] ) ) {
													?>
													<li class="mobile">
														<?php
														inspiry_safe_include_svg( '/images/icon-mobile.svg' );
														esc_html_e( 'Mobile', 'framework' );
														?>
													: <a href="tel:<?php echo esc_html( $current_author_meta['mobile_number'][0] ); ?>"><?php echo esc_html( $current_author_meta['mobile_number'][0] ); ?></a>
                                                    </li>
													<?php
												}

												if ( ! empty( $current_author_meta['fax_number'][0] ) ) {
													?>
													<li class="fax">
													<?php
													inspiry_safe_include_svg( '/images/icon-printer.svg' );
													esc_html_e( 'Fax', 'framework' );
													?>
													: <a href="fax:<?php echo esc_html( $current_author_meta['fax_number'][0] ); ?>"><?php echo esc_html( $current_author_meta['fax_number'][0] ); ?></a>
                                                    </li><?php
												}

												if ( ! empty( $current_author_meta['inspiry_user_address'][0] ) ) {
													?>
                                                    <li class="address">
														<?php
														inspiry_safe_include_svg( '/images/icon-map.svg' );
														esc_html_e( 'Address', 'framework' );
														?>
                                                        : <span><?php echo esc_html( $current_author_meta['inspiry_user_address'][0] ); ?></span>
                                                    </li>
													<?php
												}
												?>
											</ul>
											<?php
										}

										// Agent contact form.
										get_template_part( 'assets/classic/partials/agent/single/contact-form' );
										?>
									</div>
								</div><!-- end of .row-fluid -->
							</div>

							<div class="follow-agent clearfix">
								<?php
								$authordata = get_userdata( $current_author_id );
								if ( ( isset( $authordata->user_url ) && ! empty( $authordata->user_url ) ) || isset( $current_author_meta['facebook_url'] ) || isset( $current_author_meta['twitter_url'] ) || isset( $current_author_meta['instagram_url'] ) || isset( $current_author_meta['linkedin_url'] ) ) {
									?>
									<ul class="social_networks clearfix">
										<?php
										if ( isset( $authordata->user_url ) && ! empty( $authordata->user_url ) ) {
											?>
                                            <li class="website">
                                                <a target="_blank" href="<?php echo esc_url( $authordata->user_url ); ?>"><i class="fas fa-globe fa-lg"></i></a>
                                            </li>
											<?php
										}

										if ( ! empty( $current_author_meta['facebook_url'][0] ) ) {
											?>
											<li class="facebook">
												<a target="_blank" href="<?php echo esc_url( $current_author_meta['facebook_url'][0] ); ?>"><i class="fab fa-facebook-f fa-lg"></i></a>
											</li>
											<?php
										}

										if ( ! empty( $current_author_meta['twitter_url'][0] ) ) {
											?>
											<li class="twitter">
												<a target="_blank" href="<?php echo esc_url( $current_author_meta['twitter_url'][0] ); ?>"><i class="fab fa-twitter fa-lg"></i></a>
											</li>
											<?php
										}

										if ( ! empty( $current_author_meta['linkedin_url'][0] ) ) {
											?>
											<li class="linkedin">
												<a target="_blank" href="<?php echo esc_url( $current_author_meta['linkedin_url'][0] ); ?>"><i class="fab fa-linkedin-in fa-lg"></i></a>
											</li>
											<?php
										}

										if ( ! empty( $current_author_meta['instagram_url'][0] ) ) {
											?>
											<li class="instagram">
												<a target="_blank" href="<?php echo esc_url( $current_author_meta['instagram_url'][0] ); ?>"><i class="fab fa-instagram fa-lg"></i></a>
											</li>
											<?php
										}

										if ( ! empty( $current_author_meta['youtube_url'][0] ) ) {
											?>
                                            <li class="youtube">
                                                <a target="_blank" href="<?php echo esc_url( $current_author_meta['youtube_url'][0] ); ?>"><i class="fab fa-youtube fa-lg"></i></a>
                                            </li>
											<?php
										}

										if ( ! empty( $current_author_meta['pinterest_url'][0] ) ) {
											?>
                                            <li class="pinterest">
                                                <a target="_blank" href="<?php echo esc_url( $current_author_meta['pinterest_url'][0] ); ?>"><i class="fab fa-pinterest fa-lg"></i></a>
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
						/**
						 * Properties related to author
						 */

						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();

								/* Display Property */
								get_template_part( 'assets/classic/partials/agent/single/property-card' );

							endwhile;
							wp_reset_postdata();
						else :
							alert( '', esc_html__( 'No Properties Found!', 'framework' ) );
						endif;
						?>

					</div>

					<?php theme_pagination( $wp_query->max_num_pages ); ?>

				</section>

			</div><!-- End Main Content -->

		</div> <!-- End span9 -->

		<?php get_sidebar( 'agent' ); ?>

	</div><!-- End contents row -->

</div><!-- End Content -->

<?php get_footer(); ?>
