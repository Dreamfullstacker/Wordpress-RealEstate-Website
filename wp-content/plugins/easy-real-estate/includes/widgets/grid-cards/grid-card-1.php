<?php
$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$is_featured        = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );

global $featured_text;
?>

<article class="rh_prop_card rh_prop_card--block">

	<div class="rh_prop_card__wrap">

		<?php if ( $is_featured ) : ?>
			<div class="rh_label rh_label__featured_widget">
				<div class="rh_label__wrap">
					<?php
					if ( ! empty( $featured_text ) ) {
						echo esc_html( $featured_text );
					} else {
						esc_html_e( 'Featured', 'easy-real-estate' );
					}
					?>
					<span></span>
				</div>
			</div>
			<!-- /.rh_label -->
		<?php endif; ?>

		<figure class="rh_prop_card__thumbnail">
			<div class="rh_figure_property_one">
                <a href="<?php the_permalink(); ?>">
					<?php
					if ( has_post_thumbnail( get_the_ID() ) ) {
						the_post_thumbnail( 'modern-property-child-slider' );
					} else {
						if ( function_exists( 'inspiry_image_placeholder' ) ) {
							inspiry_image_placeholder( 'modern-property-child-slider' );
						}
					}
					?>
                </a>


				<div class="rh_overlay"></div>
				<div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
					<?php if ( isset( $view_property ) && ! empty( $view_property ) ) { ?>
						<a href="<?php the_permalink(); ?>"><?php echo esc_html( $view_property ); ?></a>
						<?php
					} else {
						?>
						<a href="<?php the_permalink(); ?>"><?php esc_html_e( 'View Property', 'easy-real-estate' ); ?></a>
						<?php
					}
					?>
				</div>
				<?php ere_display_property_label( get_the_ID() ); ?>
			</div>
			<!-- /.rh_overlay__contents -->

			<div class="rh_prop_card__btns">
				<?php
				// Display add to favorite button.
				if ( function_exists( 'inspiry_favorite_button' ) ) {
					inspiry_favorite_button();
				}

				// Display add to compare button.
				if ( function_exists( 'inspiry_add_to_compare_button' ) ) {
					inspiry_add_to_compare_button();
				}
				?>
			</div>
			<!-- /.rh_prop_card__btns -->
		</figure>
		<!-- /.rh_prop_card__thumbnail -->

		<div class="rh_prop_card__details">

			<h3>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<p class="rh_prop_card__excerpt"><?php ere_framework_excerpt( 10 ); ?></p>
			<!-- /.rh_prop_card__excerpt -->

			<div class="rh_prop_card__meta_wrap">

				<?php if ( ! empty( $property_bedrooms ) ) : ?>
					<div class="rh_prop_card__meta">
                                                    <span class="rh_meta_titles">
                                                           <?php
                                                           $bedrooms_label = get_option( 'inspiry_bedrooms_field_label' );
                                                           if ( ! empty( $bedrooms_label ) && ( $bedrooms_label ) ) {
	                                                           echo esc_html( $bedrooms_label );
                                                           } else {
	                                                           esc_html_e( 'Bedrooms', 'easy-real-estate' );
                                                           }
                                                           ?>
                                                    </span>
						<div>
							<?php ere_safe_include_svg( '/images/icons/icon-bed.svg' ); ?>
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

                                                            if ( ! empty( $bathrooms_label ) && ( $bathrooms_label ) ) {
	                                                            echo esc_html( $bathrooms_label );
                                                            } else {
	                                                            esc_html_e( 'Bathrooms', 'easy-real-estate' );
                                                            }

                                                            ?>
                                                    </span>
						<div>
							<?php ere_safe_include_svg( '/images/icons/icon-shower.svg' ); ?>
							<span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
						</div>
					</div>
					<!-- /.rh_prop_card__meta -->
				<?php endif; ?>

				<?php
				if ( inspiry_is_rvr_enabled() ) {
					$post_meta_guests = get_post_meta( get_the_ID(), 'rvr_guests_capacity', true );
					if ( ! empty( $post_meta_guests ) ) : ?>
						<div class="rh_prop_card__meta">
                                                        <span class="rh_meta_titles">
                                                            <?php
                                                            $inspiry_rvr_guests_field_label = get_option( 'inspiry_rvr_guests_field_label' );
                                                            if ( ! empty( $inspiry_rvr_guests_field_label ) ) {
	                                                            echo esc_html( $inspiry_rvr_guests_field_label );
                                                            } else {
	                                                            esc_html_e( 'Guests', 'easy-real-estate' );
                                                            }
                                                            ?>
                                                        </span>
							<div>
								<?php ere_safe_include_svg( '/images/icons/guests-icons.svg' ); ?>
								<span class="figure"><?php echo esc_html( $post_meta_guests ); ?></span>
							</div>
						</div>
						<!-- /.rh_property__meta -->
					<?php endif;
				}
				?>

				<?php if ( ! empty( $property_size ) ) : ?>
					<div class="rh_prop_card__meta">
                                                    <span class="rh_meta_titles">
                                                             	<?php
                                                                $area_label = get_option( 'inspiry_area_field_label' );
                                                                if ( ! empty( $area_label ) && ( $area_label ) ) {
	                                                                echo esc_html( $area_label );
                                                                } else {
	                                                                esc_html_e( 'Area', 'easy-real-estate' );
                                                                }
                                                                ?>
                                                    </span>
						<div>
							<?php ere_safe_include_svg( '/images/icons/icon-area.svg' ); ?>
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

			<div class="rh_prop_card__priceLabel rh_prop_card__priceLabel_box">
				<div class="rh_rvr_price_status_box">
											<span class="rh_prop_card__status">
					<?php echo esc_html( ere_get_property_statuses( get_the_ID() ) ); ?>
											</span>
					<!-- /.rh_prop_card__type -->
					<p class="rh_prop_card__price">
						<?php ere_property_price(); ?>
					</p>
					<!-- /.rh_prop_card__price -->
				</div>

				<?php
				if ( inspiry_is_rvr_enabled() ) {
					global $post;
					?>
					<div class="inspiry_rating_right">
						<?php
						if ( 'property' === $post->post_type && 'true' === get_option( 'inspiry_property_ratings', 'false' ) ) {
							inspiry_rating_average_plain();
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
			<!-- /.rh_prop_card__priceLabel -->

		</div>
		<!-- /.rh_prop_card__details -->

	</div>
	<!-- /.rh_prop_card__wrap -->

</article>