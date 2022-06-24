<?php
/**
 * Display users list for modern design variation.
 *
 * @since   3.3.2
 * @package realhomes
 */


get_header();

// Page Head.
$header_variation = get_option( 'inspiry_agents_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

?>

	<section class="rh_section rh_section--flex rh_wrap--padding rh_wrap--topPadding">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
		<div class="rh_page rh_page__agents rh_page__main">

			<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
				<div class="rh_page__head rh_page--agents_listing">

					<h2 class="rh_page__title">
						<?php
						// Page Title.
						$page_title = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title', true );
						if ( empty( $page_title ) ) {
							$page_title = get_the_title( get_the_ID() );
						}
						echo inspiry_get_exploded_heading( $page_title );
						?>
					</h2>
					<!-- /.rh_page__title -->

				</div>
				<!-- /.rh_page__head -->
			<?php endif; ?>

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

			<div class="rh_page__listing">
				<?php
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
				$users_query = new WP_User_Query( $users_args );

				if ( $users_query->results ) :
					foreach ( $users_query->results as $user ) :
						$user_meta = get_user_meta( $user->ID );
						$author_page_url = get_author_posts_url( $user->ID );
						?>

						<article class="rh_agent_card">

							<div class="rh_agent_card__wrap">

								<div class="rh_agent_card__head">

									<?php
									// Profile image.
									if ( isset( $user_meta['profile_image_id'] ) ) {
										$profile_image_id = intval( $user_meta['profile_image_id'][0] );
										if ( $profile_image_id ) {
											?>
											<figure class="rh_agent_card__dp">
												<a title="<?php echo esc_attr( $user->display_name ); ?>" href="<?php echo esc_url( $author_page_url ); ?>">
													<?php echo wp_get_attachment_image( $profile_image_id, 'agent-image' ); ?>
												</a>
											</figure>
											<?php
										}
									} elseif ( function_exists( 'get_avatar' ) ) {
										?>
										<figure class="rh_agent_card__dp">
											<a title="<?php echo esc_attr( $user->display_name ); ?>" href="<?php echo esc_url( $author_page_url ); ?>">
												<?php echo get_avatar( $user->user_email, '180' ); ?>
											</a>
										</figure>
										<?php
									}
									?>

									<div class="rh_agent_card__name">

										<h4 class="name">
											<a href="<?php echo esc_url( $author_page_url ); ?>"><?php echo esc_attr( $user->display_name ); ?></a>
										</h4>

										<?php
										// User's social networks.
										if ( isset( $user_meta['facebook_url'] ) || isset( $user_meta['twitter_url'] ) || isset( $user_meta['google_plus_url'] ) || isset( $user_meta['linkedin_url'] ) || isset( $user_meta['instagram_url'] ) ) {
											?>
											<div class="social">
												<?php
												if ( ! empty( $user_meta['facebook_url'][0] ) ) {
													?>
													<a target="_blank" href="<?php echo esc_url( $user_meta['facebook_url'][0] ); ?>"><i class="fab fa-facebook fa-lg"></i></a>
													<?php
												}

												if ( ! empty( $user_meta['twitter_url'][0] ) ) {
													?>
													<a target="_blank" href="<?php echo esc_url( $user_meta['twitter_url'][0] ); ?>"><i class="fab fa-twitter fa-lg"></i></a>
													<?php
												}

												if ( ! empty( $user_meta['linkedin_url'][0] ) ) {
													?>
													<a target="_blank" href="<?php echo esc_url( $user_meta['linkedin_url'][0] ); ?>"><i class="fab fa-linkedin fa-lg"></i></a>
													<?php
												}

												if ( ! empty( $user_meta['instagram_url'][0] ) ) {
													?>
													<a target="_blank" href="<?php echo esc_url( $user_meta['instagram_url'][0] ); ?>"><i class="fab fa-instagram fa-lg"></i></a>
													<?php
												}
												?>
											</div>
											<!-- /.social -->
											<?php
										}
										?>

									</div>
									<!-- /.rh_agent_card__name -->

									<?php
									// Properties count by user.
									$properties_count = inspiry_author_properties_count( $user->ID );
									?>
									<div class="rh_agent_card__listings">
										<p class="head"><?php ( 1 === $properties_count ) ? esc_html_e( 'Listed Property', 'framework' ) : esc_html_e( 'Listed Properties', 'framework' ); ?></p>
										<!-- /.head -->
										<p class="count"><?php echo ( ! empty( $properties_count ) ) ? esc_html( $properties_count ) : 0; ?></p>
										<!-- /.count -->
									</div>
									<!-- /.rh_agent_card__listings -->

								</div>
								<!-- /.rh_agent_card__head -->

								<div class="rh_agent_card__details">

									<?php
									// User description.
									if ( isset( $user_meta['description'] ) ) {
										echo '<p class="content">' . esc_html( get_framework_custom_excerpt( $user_meta['description'][0], 45 ) ) . '</p>';
									}
									?>

									<div class="rh_agent_card__contact">

										<?php
										// user contact details.
										if ( isset( $user_meta['mobile_number'] ) || isset( $user_meta['office_number'] ) || isset( $user_meta['fax_number'] ) || isset( $user_meta['whatsapp_number'] ) ) {
											?>
											<div class="rh_agent_card__contact_wrap">
												<?php
												if ( ! empty( $user_meta['office_number'][0] ) ) {
													?>
													<p class="contact office"><?php esc_html_e( 'Office', 'framework' ); ?>
													:
													<a href="tel:<?php echo esc_attr( $user_meta['office_number'][0] ); ?>"><?php echo esc_html( $user_meta['office_number'][0] ); ?></a>
													</p>
													<?php
												}
												if ( ! empty( $user_meta['mobile_number'][0] ) ) {
													?>
													<p class="contact mobile"><?php esc_html_e( 'Mobile', 'framework' ); ?>
													:
													<a href="tel:<?php echo esc_attr( $user_meta['mobile_number'][0] ); ?>"><?php echo esc_html( $user_meta['mobile_number'][0] ); ?></a>
													</p>
													<?php
												}
												if ( ! empty( $user_meta['fax_number'][0] ) ) {
													?>
													<p class="contact fax"><?php esc_html_e( 'Fax', 'framework' ); ?>:
													<a href="tel:<?php echo esc_attr( $user_meta['fax_number'][0] ); ?>"><?php echo esc_html( $user_meta['fax_number'][0] ); ?></a>
													</p>
													<?php
												}
												if ( ! empty( $user_meta['whatsapp_number'][0] ) ) {
													?>
													<p class="contact whatsapp"><?php esc_html_e( 'WhatsApp', 'framework' ); ?>
													:
													<a href="https://wa.me/<?php echo esc_attr( $user_meta['whatsapp_number'][0] ); ?>"><?php echo esc_html( $user_meta['whatsapp_number'][0] ); ?></a>
													</p>
													<?php
												}
												if ( ! empty( $user->user_email ) ) {
													?>
													<p class="contact email"><?php esc_html_e( 'Email', 'framework' ); ?>
													:
													<a href="mailto:<?php echo esc_attr( antispambot( $user->user_email ) ); ?>"><?php echo esc_html( antispambot( $user->user_email ) ); ?></a>
													</p>
													<?php
												}
												?>
											</div>
											<?php
										}
										?>

										<!-- /.rh_agent_card__contact_wrap -->
										<a href="<?php echo esc_url( $author_page_url ); ?>" class="rh_agent_card__link">
											<p><?php esc_html_e( 'View My Listings', 'framework' ); ?></p>
											<i class="fas fa-angle-right"></i>
										</a>
										<!-- /.rh_agent_card__link -->

									</div>
									<!-- /.rh_agent_card__contact -->

								</div>
								<!-- /.rh_agent_card__details -->

							</div>
							<!-- /.rh_agent_card__wrap -->

						</article>
						<!-- /.rh_agent_card -->

						<?php
					endforeach;
				else :
					?>
					<div class="rh_alert-wrapper">
						<h4 class="no-results"><?php esc_html_e( 'No Results Found!', 'framework' ); ?></h4>
					</div>
					<?php
				endif;
				?>
			</div>
			<!-- /.rh_page__listing -->

			<?php
			// Users pagination.
			$total_user  = $users_query->total_users;
			$total_pages = ceil( $total_user / $number_of_posts );
			inspiry_users_pagination( $total_pages );
			?>

		</div>
		<!-- /.rh_page rh_page__main -->

		<?php if ( is_active_sidebar( 'property-listing-sidebar' ) ) : ?>
            <div class="rh_page rh_page__sidebar">
				<?php get_sidebar( 'property-listing' ); ?>
            </div><!-- /.rh_page rh_page__sidebar -->
		<?php endif; ?>

	</section>
	<!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php

get_footer();
