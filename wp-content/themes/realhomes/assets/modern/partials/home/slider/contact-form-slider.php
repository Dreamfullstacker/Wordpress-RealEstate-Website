<?php
/**
 * Homepage Property Slider
 *
 * @package    realhomes
 * @subpackage modern
 */

$number_of_slides = intval( get_post_meta( get_the_ID(), 'theme_number_of_slides_cfos', true ) );
if ( ! $number_of_slides ) {
	$number_of_slides = - 1;
}

$theme_cpt_cfoss = get_post_meta(get_the_ID(),'theme_cpt_cfoss',true);

if( $theme_cpt_cfoss == 'slide'){
	$slider_args = array(
		'post_type'      => 'slide',
		'posts_per_page' => $number_of_slides,
    );
}else{
	$slider_args = array(
		'post_type'      => 'property',
		'posts_per_page' => $number_of_slides,
		'meta_query'     => array(
			array(
				'key'     => 'REAL_HOMES_add_in_slider',
				'value'   => 'yes',
				'compare' => 'LIKE',
			),
		),
	);
}



$slider_query         = new WP_Query( $slider_args );

$cfos_post_count = $slider_query->post_count;

if ( $slider_query->have_posts() ) :
	?>
    <!-- Slider -->
        <section id="rh_slider__home" class="rh_slider rh_cfos_slider rh_slider_mod clearfix">
            <?php
            $theme_cfos_rev_alias = get_post_meta(get_the_ID(), 'theme_cfos_rev_alias' );

            if ( function_exists( 'putRevSlider' ) && ( ! empty( $theme_cfos_rev_alias ) ) ) {
	            putRevSlider( $theme_cfos_rev_alias );
            } else {
            ?>
            <div class="cfos_inner_container">
                <div class="flexslider loading rh_home_load_height">

                    <?php
                    if( $theme_cpt_cfoss == 'slide'){
	                    ?>
                        <ul class="slides">
		                    <?php
		                    while ( $slider_query->have_posts() ) :
			                    $slider_query->the_post();
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

                                        <div class="rh_slide__desc cfos_slide_visible_sm">

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
										                    <?php esc_html_e( 'Read More', 'framework' ); ?>
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
                        <?php
                    }else{
	                    ?>
                        <ul class="slides">
		                    <?php
		                    while ( $slider_query->have_posts() ) :
			                    $slider_query->the_post();
			                    $slide_id           = get_the_ID();
			                    $slider_image_id    = get_post_meta( $slide_id, 'REAL_HOMES_slider_image', true );
			                    $property_size      = get_post_meta( $slide_id, 'REAL_HOMES_property_size', true );
			                    $size_postfix       = get_post_meta( $slide_id, 'REAL_HOMES_property_size_postfix', true );
			                    $property_bedrooms  = get_post_meta( $slide_id, 'REAL_HOMES_property_bedrooms', true );
			                    $property_bathrooms = get_post_meta( $slide_id, 'REAL_HOMES_property_bathrooms', true );
			                    $property_address   = get_post_meta( $slide_id, 'REAL_HOMES_property_address', true );
			                    $is_featured        = get_post_meta( $slide_id, 'REAL_HOMES_featured', true );
			                    if ( $slider_image_id ) {
				                    $slider_image_url = wp_get_attachment_url( $slider_image_id ); ?>
                                    <li>

                                        <a class="slide" href="<?php the_permalink(); ?>"
                                           style="background: url('<?php echo esc_url( $slider_image_url ); ?>') 50% 50% no-repeat;
                                                   background-size: cover;">
                                        </a>
                                        <div class="rh_slide__desc cfos_slide_visible_sm">

                                            <div class="rh_slide__desc_wrap">

			                                    <?php if ( ! empty( $is_featured ) ) : ?>
                                                    <div class="rh_label rh_label__slide">
                                                        <div class="rh_label__wrap">
						                                    <?php esc_html_e( 'Featured', 'framework' ); ?>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <!-- /.rh_label -->
			                                    <?php endif; ?>

                                                <h3>
                                                    <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                                                </h3>

			                                    <?php if ( ! empty( $property_address ) ) : ?>
                                                    <p><?php echo esc_html( $property_address ); ?></p>
			                                    <?php endif; ?>

                                                <div class="rh_slide__meta_wrap">

				                                    <?php if ( ! empty( $property_bedrooms ) ) : ?>
                                                        <div class="rh_slide__prop_meta">
												<span class="rh_meta_titles">
                                                    <?php
                                                    $bedrooms_label = get_option( 'inspiry_bedrooms_field_label' );
                                                    if(!empty($bedrooms_label)){
	                                                    echo esc_html($bedrooms_label);
                                                    }else{
	                                                    esc_html_e( 'Bedrooms', 'framework' );
                                                    }
                                                    ?>
                                                </span>
                                                            <div>
							                                    <?php inspiry_safe_include_svg( '/images/icons/icon-bed.svg' ); ?>
                                                                <span class="figure"><?php echo esc_html( $property_bedrooms ); ?></span>
                                                            </div>
                                                        </div>
                                                        <!-- /.rh_slide__prop_meta -->
				                                    <?php endif; ?>

				                                    <?php if ( ! empty( $property_bathrooms ) ) : ?>
                                                        <div class="rh_slide__prop_meta">
												<span class="rh_meta_titles">
                                                    <?php
                                                    $bathrooms_label = get_option( 'inspiry_bathrooms_field_label' );

                                                    if(!empty($bathrooms_label)){
	                                                    echo esc_html($bathrooms_label);
                                                    }else{
	                                                    esc_html_e( 'Bathrooms', 'framework' );
                                                    }

                                                    ?>
                                                </span>
                                                            <div>
							                                    <?php inspiry_safe_include_svg( '/images/icons/icon-shower.svg' ); ?>
                                                                <span class="figure"><?php echo esc_html( $property_bathrooms ); ?></span>
                                                            </div>
                                                        </div>
                                                        <!-- /.rh_slide__prop_meta -->
				                                    <?php endif; ?>

				                                    <?php if ( ! empty( $property_size ) ) : ?>
                                                        <div class="rh_slide__prop_meta">
												<span class="rh_meta_titles">
                                                   	<?php
                                                    $area_label = get_option( 'inspiry_area_field_label' );
                                                    if(!empty($area_label)){
	                                                    echo esc_html($area_label);
                                                    }else{
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
                                                        <!-- /.rh_slide__prop_meta -->
				                                    <?php endif; ?>

                                                </div>
                                                <!-- /.rh_slide__meta_wrap -->

                                                <div class="rh_slide_prop_price">
				                                    <?php
				                                    $price = null;

				                                    if ( function_exists('ere_get_property_price') ) {
					                                    $price = ere_get_property_price();
				                                    }

				                                    if ( $price ) {

					                                    $statuses = get_the_terms( get_the_ID(), 'property-status' );
					                                    if ( ! empty( $statuses ) && ! is_wp_error( $statuses ) ) {
						                                    $statuses_names        = wp_list_pluck( $statuses, 'name' );
						                                    $statuses_names_joined = implode( ', ', $statuses_names );
						                                    echo '<div class="rh_price_sym">' . esc_html( $statuses_names_joined ) . '</div>';
					                                    }

					                                    echo '<span>' . esc_html( $price ) . '</span>';
				                                    }
				                                    ?>
                                                </div>
                                                <!-- /.rh_slide_prop_price -->
                                            </div>
                                            <!-- /.rh_slide__desc_wrap -->

                                        </div>

                                    </li>
				                    <?php
			                    }
		                    endwhile;
		                    wp_reset_postdata();
		                    ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
	            <?php
                if ( $cfos_post_count > 1 ) {
		            ?>
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
		            <?php

	            }
	            ?>
            </div>
	            <?php
            }
            get_template_part( 'assets/modern/partials/home/slider/cfos' );
            ?>
        </section><!-- End Slider -->
<?php
else :
	$slider_image_url = 'https://via.placeholder.com/2000x800&text=' . rawurlencode( esc_html__( 'No property is assigned to homepage slider!', 'framework' ) );
	?>
    <!-- Slider Placeholder -->
    <section id="rh_slider__home" class="rh_slider rh_slider_mod clearfix">
        <div class="flexslider loading rh_home_load_height">
            <ul class="slides">
                <li>
                    <a class="slide" href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       style="background: url('<?php echo esc_url( $slider_image_url ); ?>') 50% 50% no-repeat; background-size: cover;"></a>
                </li>
            </ul>
        </div>
		<?php get_template_part( 'assets/modern/partials/home/slider/cfos' ); ?>
    </section><!-- End Slider Placeholder -->
<?php
endif;
