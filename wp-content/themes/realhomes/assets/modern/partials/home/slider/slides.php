<?php
/**
 * Slides custom post type based slider.
 *
 * @package    realhomes
 * @subpackage modern
 */

$number_of_slides = intval( get_post_meta( get_the_ID(), 'theme_number_custom_slides', true ) );
if ( ! $number_of_slides ) {
	$number_of_slides = 5;
}

$slides_arguments = array(
	'post_type'      => 'slide',
	'posts_per_page' => $number_of_slides,
);

$slides_query = new WP_Query( $slides_arguments );

if ( $slides_query->have_posts() ) : 

	$slides_button_text = esc_html__( 'Read More', 'framework' );
	$meta_slides_button_text = get_post_meta( get_the_ID(), 'theme_custom_slides_button_text', true );
	if( ! empty( $meta_slides_button_text ) ){
		$slides_button_text = $meta_slides_button_text;
	}
?>
	<!-- Slider -->
	<section id="rh_slider__home" class="rh_slider rh_slider_mod clearfix">
		<div class="flexslider loading rh_home_load_height">
			<ul class="slides">
				<?php
				while ( $slides_query->have_posts() ) :
					$slides_query->the_post();
					$slide_title    = get_the_title();
					$image_id       = get_post_thumbnail_id();
					$slide_sub_text = get_post_meta( get_the_ID(), 'slide_sub_text', true );
					$slide_url      = get_post_meta( get_the_ID(), 'slide_url', true );
					if ( $image_id ) {
						$slider_image_url = wp_get_attachment_url( $image_id );
						?>
						<li>

							<?php if ( ! empty( $slide_url ) ) : ?>
								<a class="slide" href="<?php echo ( ! empty( $slide_url ) ) ? esc_url( $slide_url ) : '#'; ?>"
								   style="background: url('<?php echo esc_url( $slider_image_url ); ?>') 50% 50% no-repeat; background-size: cover;">
								</a>
							<?php else : ?>
								<div class="slide"
									 style="background: url('<?php echo esc_url( $slider_image_url ); ?>') 50% 50% no-repeat; background-size: cover;">
								</div>
							<?php endif; ?>

							<div class="rh_slide__desc">

								<?php if ( ! empty( $slide_title ) || ! empty( $slide_sub_text ) ) : ?>

									<div class="rh_slide__desc_wrap">

										<?php if ( ! empty( $slide_url ) ) : ?>
											<h3>
												<a href="<?php echo esc_url( $slide_url ); ?>" class="title"><?php the_title(); ?></a>
											</h3>
										<?php else : ?>
											<?php the_title( '<h3>', '</h3>' ); ?>
										<?php endif; ?>

										<?php if ( ! empty( $slide_sub_text ) ) : ?>
											<p class="sub-text"><?php echo esc_html( $slide_sub_text ); ?></p>
										<?php endif; ?>

										<?php if ( ! empty( $slide_url ) ) : ?>
											<a href="<?php echo esc_url( $slide_url ); ?>" class="rh_btn rh_btn--primary read-more">
												<?php echo esc_html( $slides_button_text ); ?>
											</a>
										<?php endif; ?>

									</div>
									<!-- /.rh_slide__desc_wrap -->

								<?php endif; ?>

							</div>
							<!-- /.rh_slide__desc -->

						</li>
						<?php
					}
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
		</div>
		<div class="rh_flexslider__nav_main">
			<a href="#" class="flex-prev rh_flexslider__prev">
				<?php inspiry_safe_include_svg( '/images/icons/icon-arrow-right.svg' ); ?>
			</a>
			<!-- /.rh_flexslider__prev -->
			<a href="#" class="flex-next rh_flexslider__next">
				<?php inspiry_safe_include_svg( '/images/icons/icon-arrow-right.svg' ); ?>
			</a>
			<!-- /.rh_flexslider__next -->
		</div>
	</section><!-- End Slider -->
	<?php
else :
	$slider_image_url = 'https://via.placeholder.com/2000x800&text=' . rawurlencode( esc_html__( 'No custom slide is available to display!', 'framework' ) );
	?>
	<!-- Slider Placeholder -->
	<section id="rh_slider__home" class="rh_slider clearfix">
		<div class="flexslider loading rh_home_load_height">
			<ul class="slides">
				<li>
					<a class="slide" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="background: url('<?php echo esc_url( $slider_image_url ); ?>') 50% 50% no-repeat; background-size: cover;"></a>
				</li>
			</ul>
		</div>
	</section><!-- End Slider Placeholder -->
	<?php
endif;
