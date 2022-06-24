<?php
/**
 * User Listing Template
 *
 * Page template for users listing.
 *
 * @since    2.7.0
 * @package  realhomes/classic
 */

get_header();

// Page Head.
get_template_part( 'assets/classic/partials/banners/default' ); ?>

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
					$title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_page_title_display', true );
					if ( 'hide' !== $title_display ) {
						?>
						<h3 class="title-heading"><?php the_title(); ?></h3>
						<?php
					}
					?>

					<div class="list-container">

						<?php
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();

								$page_content_class = '';
								if ( ! get_the_content() ) {
									$page_content_class = 'rh_ul_content_empty';
								}
									?>
                                    <article id="post-<?php the_ID(); ?>" <?php post_class($page_content_class); ?>>
										<?php the_content(); ?>
                                    </article>
                                    <br>
									<?php
							endwhile;
						endif;

						// Number of users to display based on number of agents from theme options.
						$number_of_posts = intval( get_option( 'theme_number_posts_agent' ) );
						if ( ! $number_of_posts ) {
							$number_of_posts = 3;
						}

						$paged = 1;
						if ( get_query_var( 'paged' ) ) {
							$paged = get_query_var( 'paged' );
						} elseif ( get_query_var( 'page' ) ) { // if is static front page
							$paged = get_query_var( 'page' );
						}

						// Offset for users query.
						$offset = 0;
						if ( $paged > 1 ) {
							$offset = $number_of_posts * ( $paged - 1 );
						}

						// Users query arguments.
						$users_args = array(
							'number' => $number_of_posts,
							'offset' => $offset,
						);

						// Users Query.
						$user_query = new WP_User_Query( $users_args );

						if ( $user_query->results ) :
							// Users loop.
							foreach ( $user_query->results as $user ) :
								// Get user meta.
								$user_meta = get_user_meta( $user->ID );
								$author_page_url = get_author_posts_url( $user->ID );
								?>
								<article class="about-agent clearfix">

									<!-- Username -->
									<h4>
										<a href="<?php echo esc_url( $author_page_url ); ?>"><?php echo esc_html( $user->display_name ); ?></a>
									</h4>

									<div class="row-fluid">

										<div class="span3">
											<?php
											// User Profile Image.
											if ( isset( $user_meta['profile_image_id'] ) ) {
												$profile_image_id = intval( $user_meta['profile_image_id'][0] );
												if ( $profile_image_id ) {
													?>
													<!-- user profile image -->
													<figure class="agent-pic">
														<a title="<?php echo esc_attr( $user->display_name ); ?>" href="<?php echo esc_url( $author_page_url ); ?>">
															<?php echo wp_get_attachment_image( $profile_image_id, 'agent-image' ); ?>
														</a>
													</figure>
													<?php
												}
											} elseif ( function_exists( 'get_avatar' ) ) {
												?>
												<!-- user avatar -->
												<figure class="agent-pic">
													<a title="<?php echo esc_attr( $user->display_name ); ?>" href="<?php echo esc_url( $author_page_url ); ?>">
														<?php echo get_avatar( $user->user_email, '180' ); ?>
													</a>
												</figure>
												<?php
											}
											?>
										</div>


										<div class="span9">

											<div class="agent-content">
												<?php
												// Author Description.
												if ( isset( $user_meta['description'] ) ) {
													echo '<p>' . esc_html( get_framework_custom_excerpt( $user_meta['description'][0], 45 ) ) . '</p>';
												}
												?>
											</div>

											<?php
											// Author Contact Info.
											if ( isset( $user_meta['mobile_number'] ) || isset( $user_meta['office_number'] ) || isset( $user_meta['fax_number'] ) ) {
												?>
												<ul class="contacts-list">
													<?php
													if ( ! empty( $user_meta['office_number'][0] ) ) {
														?>
														<li class="office">
															<?php
															inspiry_safe_include_svg( '/images/icon-phone.svg' );
															esc_html_e( 'Office', 'framework' );
															?>
															:
                                                            <a href="tel:<?php echo esc_html( $user_meta['office_number'][0] ); ?>"><?php echo esc_html( $user_meta['office_number'][0] ); ?></a>
														</li>
														<?php
													}
													if ( ! empty( $user_meta['mobile_number'][0] ) ) {
														?>
														<li class="mobile">
															<?php
															inspiry_safe_include_svg( '/images/icon-mobile.svg' );
															esc_html_e( 'Mobile', 'framework' );
															?>
															:
                                                            <a href="tel:<?php echo esc_html( $user_meta['mobile_number'][0] ); ?>"><?php echo esc_html( $user_meta['mobile_number'][0] ); ?></a>
														</li>
														<?php
													}
													if ( ! empty( $user_meta['fax_number'][0] ) ) {
														?>
														<li class="fax">
															<?php
															inspiry_safe_include_svg( '/images/icon-printer.svg' );
															esc_html_e( 'Fax', 'framework' );
															?>
															:
                                                            <a href="tel:<?php echo esc_html( $user_meta['fax_number'][0] ); ?>"><?php echo esc_html( $user_meta['fax_number'][0] ); ?></a>
														</li>
														<?php
													}
													?>
												</ul>

												<?php
											}
											?>

										</div>

									</div>

									<div class="follow-agent clearfix">
										<a class="real-btn btn" href="<?php echo esc_url( $author_page_url ); ?>"><?php esc_html_e( 'More Details', 'framework' ); ?></a>
										<?php
										// Author social links.
										if ( isset( $user_meta['facebook_url'] ) || isset( $user_meta['twitter_url'] ) || isset( $user_meta['google_plus_url'] ) || isset( $user_meta['linkedin_url'] ) ) {
											?>
											<!-- Agent's Social Navigation -->
											<ul class="social_networks clearfix">
												<?php
												if ( ! empty( $user_meta['facebook_url'][0] ) ) {
													?>
													<li class="facebook">
														<a target="_blank" href="<?php echo esc_url( $user_meta['facebook_url'][0] ); ?>"><i class="fab fa-facebook-f fa-lg"></i></a>
													</li>
													<?php
												}

												if ( ! empty( $user_meta['twitter_url'][0] ) ) {
													?>
													<li class="twitter">
														<a target="_blank" href="<?php echo esc_url( $user_meta['twitter_url'][0] ); ?>"><i class="fab fa-twitter fa-lg"></i></a>
													</li>
													<?php
												}

												if ( ! empty( $user_meta['linkedin_url'][0] ) ) {
													?>
													<li class="linkedin">
														<a target="_blank" href="<?php echo esc_url( $user_meta['linkedin_url'][0] ); ?>"><i class="fab fa-linkedin-in fa-lg"></i></a>
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
							endforeach;
						else :
							?><h4><?php esc_html_e( 'No Users Found!', 'framework' ); ?></h4><?php
						endif;
						?>
					</div>

					<?php
					// Users pagination.
					$total_user  = $user_query->total_users;
					$total_pages = ceil( $total_user / $number_of_posts );
					inspiry_users_pagination( $total_pages );
					?>

				</section>

			</div><!-- End Main Content -->

		</div><!-- End span9 -->

		<?php get_sidebar( 'pages' ); ?>

	</div><!-- End contents row -->

</div><!-- End Content -->

<?php get_footer(); ?>
