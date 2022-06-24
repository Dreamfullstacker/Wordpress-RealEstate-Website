<?php
/**
 * Featured Property Card
 *
 * Featured property card to be displayed on homepage.
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

?>

<li class="rh_prop_card">

	<figure class="rh_prop_card__thumbnail">
		<?php inspiry_display_property_label( get_the_ID() ); ?>
		<a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail( get_the_ID() ) ) {
				the_post_thumbnail( 'post-featured-image' );
			} else {
				inspiry_image_placeholder( 'post-featured-image' );
			}
			?>
		</a>
	</figure>
	<!-- /.rh_prop_card__thumbnail -->

	<div class="rh_prop_card__details rh_prop_card__featured">

		<div class="rh_label rh_label__featured">
			<div class="rh_label__wrap">
				<?php esc_html_e( 'Featured', 'framework' ); ?>
				<span></span>
			</div>
		</div>
		<!-- /.rh_label -->

		<h3>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<p class="rh_prop_card__excerpt"><?php framework_excerpt( 15 ); ?></p>
		<!-- /.rh_prop_card__excerpt -->

		<div class="rh_prop_card__meta_wrap">

			<?php if ( ! empty( $property_bedrooms ) ) : ?>
				<div class="rh_prop_card__meta">
					<span class="rh_meta_titles">
						<?php
							$bedrooms_label = get_option( 'inspiry_bedrooms_field_label' );
							echo ( empty ( $bedrooms_label ) ) ? esc_html__( 'Bedrooms', 'framework' ) : esc_html( $bedrooms_label );
						?>
					</span>
					<div>
						<?php inspiry_safe_include_svg( '/images/icons/icon-bed.svg' ); ?>
						<span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
					</div>
				</div>
				<!-- /.rh_prop_card__meta -->
			<?php endif; ?>

			<?php if ( ! empty( $property_bathrooms ) ) : ?>
				<div class="rh_prop_card__meta">
					<span class="rh_meta_titles">
						<?php
							$bathrooms_label = get_option( 'inspiry_bathrooms_field_label' );
							echo ( empty ( $bathrooms_label ) ) ? esc_html__( 'Bathrooms', 'framework' ) : esc_html( $bathrooms_label );
						?>
					</span>
					<div>
						<?php inspiry_safe_include_svg( '/images/icons/icon-shower.svg' ); ?>
						<span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
					</div>
				</div>
				<!-- /.rh_prop_card__meta -->
			<?php endif; ?>

			<?php if ( ! empty( $property_size ) ) : ?>
				<div class="rh_prop_card__meta">
					<span class="rh_meta_titles">
						<?php
							$area_label = get_option( 'inspiry_area_field_label' );
							echo ( empty ( $area_label ) ) ? esc_html__( 'Area', 'framework' ) : esc_html( $area_label );
						?>
					</span>
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
				<!-- /.rh_prop_card__meta -->
			<?php endif; ?>

		</div>
		<!-- /.rh_prop_card__meta_wrap -->

		<div class="rh_prop_card__priceLabel">

			<span class="rh_prop_card__status">
				<?php echo esc_html( display_property_status( get_the_ID() ) ); ?>
			</span>
			<!-- /.rh_prop_card__type -->
			<p class="rh_prop_card__price">
				<?php
				if ( function_exists( 'ere_property_price' ) ) {
					ere_property_price();
				}
                ?>
			</p>
			<!-- /.rh_prop_card__price -->

		</div>
		<!-- /.rh_prop_card__priceLabel -->

	</div>
	<!-- /.rh_prop_card__details -->

</li>
<!-- /.rh_prop_card -->
