<?php
/**
 * Footer Section: Partners
 *
 * @package    realhomes
 * @subpackage classic
 */

$show_partners = get_option( 'theme_show_partners' );  // Display or hide this section.
if ( 'true' == $show_partners ) {

	$partners_variation = get_option( 'inpsiry_partners_variation' );   // Variation to display.

	/* For demo purpose only */
	if ( isset( $_GET['partners_variation'] ) ) {
		$partners_variation = $_GET['partners_variation'];
	}

	$partners_variation = ( ! empty( $partners_variation ) ) ? $partners_variation : 'carousel';

	if ( 'simple' == $partners_variation ) {
		?>
		<div class="rh_partners">

			<div class="rh_partners__wrapper container">

				<div class="row">
					<?php
                    $number_footer_partners = get_option('inspiry_footer_partners_to_show');
					$partners_args = array(
						'post_type'      => 'partners',
						'posts_per_page' => empty($number_footer_partners) ? 20 : intval( $number_footer_partners),
					);

					$partners = new WP_Query( $partners_args );

					if ( $partners->have_posts() ) {

						while ( $partners->have_posts() ) {

							$partners->the_post();

							$post_meta_data = get_post_custom( get_the_ID() );
							$partner_url    = '';
							if ( ! empty( $post_meta_data['REAL_HOMES_partner_url'][0] ) ) {
								$partner_url = $post_meta_data['REAL_HOMES_partner_url'][0];
							}
							?>
							<div class="rh_partners__single">
								<a target="_blank" href="<?php echo esc_url( $partner_url ); ?>" title="<?php the_title_attribute(); ?>">
									<?php
									$thumb_title = trim( strip_tags( get_the_title( get_the_ID() ) ) );
									the_post_thumbnail( 'partners-logo', array(
										'alt'   => $thumb_title,
										'title' => $thumb_title,
									) );
									?>
								</a>
							</div>
							<!-- /.rh_partners__single -->
							<?php
						}

						wp_reset_postdata();
					}
					?>
				</div>
				<!-- /.row -->
			</div>
			<!-- /.rh_partners__wrapper -->
		</div>
		<!-- /.rh_partners -->
		<?php
	} else {
		?>
		<div class="container page-carousel">
			<div class="row">
				<div class="span12">
					<section class="brands-carousel clearfix">
						<?php
						$partners_title = get_option( 'theme_partners_title' );
						if ( ! empty( $partners_title ) ) {
							?>
							<h3 class="brands-carousel-title"><span><?php echo esc_html( $partners_title ); ?></span></h3>
							<?php

						}

						$partners_query_args = array(
							'post_type'      => 'partners',
							'posts_per_page' => 100,
						);

						$partners_query = new WP_Query( $partners_query_args );
						if ( $partners_query->have_posts() ) {
							?>
							<div class="brands-owl-carousel owl-carousel clearfix">
								<?php
								while ( $partners_query->have_posts() ) {
									$partners_query->the_post();
									$post_meta_data = get_post_custom( get_the_ID() );
									$partner_url    = '';
									if ( ! empty( $post_meta_data['REAL_HOMES_partner_url'][0] ) ) {
										$partner_url = $post_meta_data['REAL_HOMES_partner_url'][0];
									}
									?>
									<div class="brands-carousel-item">
										<a target="_blank" href="<?php echo esc_url( $partner_url ); ?>" title="<?php the_title_attribute(); ?>">
											<?php
											$thumb_title = trim( strip_tags( get_the_title( get_the_ID() ) ) );
											the_post_thumbnail( 'partners-logo', array(
												'alt'   => $thumb_title,
												'title' => $thumb_title,
											) );
											?>
										</a>
									</div>
									<?php
								}
								?>
							</div>
							<?php
							wp_reset_postdata();
						}
						?>
					</section>
				</div>
			</div>
		</div>
		<?php
	}
}
