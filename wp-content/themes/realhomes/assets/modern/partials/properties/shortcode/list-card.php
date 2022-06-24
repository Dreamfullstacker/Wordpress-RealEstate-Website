<?php
/**
 * Property card for list layout in properties shortcode.
 *
 * @package    realhomes
 * @subpackage modern
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
				</div>
				<!-- /.rh_label -->
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
					<?php $post_thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'property-thumb-image' ); ?>
					<div class="post_thumbnail" style="background: url('<?php echo esc_url( $post_thumbnail_url ); ?>') 50% 50% no-repeat; background-size: cover;"></div>
					<!-- /.post_thumbnail -->
				<?php else : ?>
					<?php $post_thumbnail_url = get_inspiry_image_placeholder_url( 'modern-property-child-slider' ); ?>
					<div class="post_thumbnail" style="background: url('<?php echo esc_url( $post_thumbnail_url ); ?>') 50% 50% no-repeat; background-size: cover;"></div>
					<!-- /.post_thumbnail -->
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
				<p class="rh_list_card__excerpt"><?php framework_excerpt( 5 ); ?></p>
				<!-- /.rh_list_card__excerpt -->

				<div class="rh_list_card__meta_wrap">

					<?php if ( ! empty( $property_bedrooms ) ) : ?>
						<div class="rh_list_card__meta">
							<h4><?php esc_html_e( 'Bedrooms', 'framework' ); ?></h4>
							<div>
								<?php inspiry_safe_include_svg( '/images/icons/icon-bed.svg' ); ?>
								<span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
							</div>
						</div>
						<!-- /.rh_list_card__meta -->
					<?php endif; ?>

					<?php if ( ! empty( $property_bathrooms ) ) : ?>
						<div class="rh_list_card__meta">
							<h4><?php esc_html_e( 'Bathrooms', 'framework' ); ?></h4>
							<div>
								<?php inspiry_safe_include_svg( '/images/icons/icon-shower.svg' ); ?>
								<span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
							</div>
						</div>
						<!-- /.rh_list_card__meta -->
					<?php endif; ?>

					<?php if ( ! empty( $property_size ) ) : ?>
						<div class="rh_list_card__meta">
							<h4><?php esc_html_e( 'Area', 'framework' ); ?></h4>
							<div>
								<?php inspiry_safe_include_svg( '/images/icons/icon-area.svg' ); ?>
								<span class="figure">
									<?php echo esc_html( $property_size ); ?>
								</span>
								<?php if ( ! empty( $size_postfix ) ) : ?>
									<span class="label">
										<?php echo esc_html( $size_postfix ); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>
						<!-- /.rh_list_card__meta -->
					<?php endif; ?>

				</div>
				<!-- /.rh_list_card__meta_wrap -->

			</div>
			<!-- /.rh_list_card__details -->

			<div class="rh_list_card__priceLabel">

				<div class="rh_list_card__price">
					<h4 class="status">
						<?php echo esc_html( display_property_status( get_the_ID() ) ); ?>
					</h4>
					<!-- /.rh_prop_card__type -->

					<p class="price">
						<?php
						if ( function_exists( 'ere_property_price' ) ) {
							ere_property_price();
						}
                        ?>
					</p>
					<!-- /.price -->
				</div>
				<!-- /.rh_list_card__price -->

				<p class="rh_list_card__author">
					<?php esc_html_e( 'By', 'framework' ); ?>
					<span class="author">
						<?php
						// todo: replace author with agent.
						the_author();
						?>
					</span>
					<!-- /.name -->
				</p>
				<!-- /.rh_list_card__author -->

			</div>
			<!-- /.rh_list_card__priceLabel -->

		</div>
		<!-- /.rh_list_card__details_wrap -->

	</div>
	<!-- /.rh_list_card__wrap -->

</article>
<!-- /.rh_list_card -->
