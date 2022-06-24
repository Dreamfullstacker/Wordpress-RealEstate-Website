<?php
/**
 * Similar property card.
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

<article class="rh_prop_card rh_prop_card--similar">

    <div class="rh_prop_card__wrap">

        <figure class="rh_prop_card__thumbnail">
            <div class="rh_figure_property_one">
            <a href="<?php the_permalink(); ?>">
				<?php
				if ( has_post_thumbnail( get_the_ID() ) ) {
					the_post_thumbnail( 'modern-property-child-slider' );
				} else {
					inspiry_image_placeholder( 'modern-property-child-slider' );
				}
				?>
            </a>

            <div class="rh_overlay"></div>
            <div class="rh_overlay__contents rh_overlay__fadeIn-bottom">
                <a href="<?php the_permalink(); ?>"><?php inspiry_property_detail_page_link_text(); ?></a>
            </div>
            <!-- /.rh_overlay__contents -->

			<?php inspiry_display_property_label( get_the_ID() ); ?>
            </div>

            <div class="rh_prop_card__btns">
				<?php
				inspiry_favorite_button(); // Display add to favorite button.
				inspiry_add_to_compare_button(); // Display add to compare button.
				?>
            </div>
            <!-- /.rh_prop_card__btns -->
        </figure>
        <!-- /.rh_prop_card__thumbnail -->

        <div class="rh_prop_card__details">

            <h3>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="rh_prop_card__excerpt"><?php framework_excerpt( 10 ); ?></p>
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
	                              esc_html_e( 'Bedrooms', 'framework' );
                              }
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

                               if ( ! empty( $bathrooms_label ) && ( $bathrooms_label ) ) {
	                               echo esc_html( $bathrooms_label );
                               } else {
	                               esc_html_e( 'Bathrooms', 'framework' );
                               }

                               ?>
                        </span>
                        <div>
							<?php inspiry_safe_include_svg( '/images/icons/icon-shower.svg' ); ?>
                            <span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
                        </div>
                    </div>
                    <!-- /.rh_prop_card__meta -->
				<?php endif; ?>

                <?php
                if ( inspiry_is_rvr_enabled() ) {
	                $post_meta_guests = get_post_meta( get_the_ID(),'rvr_guests_capacity',true );
	                if ( ! empty( $post_meta_guests ) ) : ?>
                        <div class="rh_prop_card__meta">
                            <span class="rh_meta_titles">
                                <?php
                                $inspiry_rvr_guests_field_label = get_option('inspiry_rvr_guests_field_label');
                                if(!empty($inspiry_rvr_guests_field_label)){
	                                echo esc_html($inspiry_rvr_guests_field_label);
                                }else{
	                                esc_html_e( 'Guests', 'framework' );
                                }
                                ?>
                            </span>
                            <div>
				                <?php
				                inspiry_safe_include_svg('images/guests-icons.svg','/common/');
                                ?>
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
	                                esc_html_e( 'Area', 'framework' );
                                }
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

            <div class="rh_prop_card__priceLabel rh_prop_card__priceLabel_box">
                <div class="rh_rvr_price_status_box">
											<span class="rh_prop_card__status">
					                             <?php echo esc_html( display_property_status( get_the_ID() ) ); ?>
											</span>
                    <!-- /.rh_prop_card__type -->
                    <p class="rh_prop_card__price">
				        <?php ere_property_price(); ?>
                    </p>
                    <!-- /.rh_prop_card__price -->
                </div>

		        <?php
		        if ( inspiry_is_rvr_enabled() ) {
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
<!-- /.rh_prop_card -->
