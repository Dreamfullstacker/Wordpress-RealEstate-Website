<?php
/**
 * Featured Properties - Homepage
 *
 * @package realhomes/classic
 * @since   2.6.4
 */
$max_featured_properties = intval( get_post_meta( get_the_ID(), 'realhomes_max_featured_properties', true ) );
if ( ! $max_featured_properties ) {
	$max_featured_properties = 6;
}

$featured_properties_args = array(
	'post_type'      => 'property',
	'posts_per_page' => $max_featured_properties,
	'meta_query'     => array(
		array(
			'key'     => 'REAL_HOMES_featured',
			'value'   => 1,
			'compare' => '=',
			'type'    => 'NUMERIC',
		),
	)
);

// Excluding statuses
$all_statuses = get_post_meta( get_the_ID(), 'inspiry_featured_properties_exclude_status' );

if ( ! empty( $all_statuses ) ) {
	$featured_properties_args['tax_query'] = array(
		array(
			'taxonomy' => 'property-status',
			'field'    => 'slug',
			'terms'    => $all_statuses,
			'operator' => 'NOT IN'
		)
	);
}

$featured_properties_args  = apply_filters( 'inspiry_featured_properties_filter', $featured_properties_args );
$featured_properties_query = new WP_Query( $featured_properties_args );

$featured_properties_variation = get_post_meta( get_the_ID(), 'inspiry_featured_properties_variation', true );

/* For demo purpose only */
if ( isset( $_GET['featured_variation'] ) ) {
	$featured_properties_variation = $_GET['featured_variation'];
}

$featured_properties_variation = ( ! empty( $featured_properties_variation ) ) ? $featured_properties_variation : false;

if ( $featured_properties_query->have_posts() ) : ?>
    <div class="container">
        <div class="row">
            <div class="span12">
				<?php if ( ! empty( $featured_properties_variation ) && 'one_property_slide' == $featured_properties_variation ) : ?>
                    <section id="rh_featured_properties" class="clearfix">
						<?php
						$featured_prop_title = get_post_meta( get_the_ID(), 'theme_featured_prop_title', true );
						$featured_prop_text  = get_post_meta( get_the_ID(), 'theme_featured_prop_text', true );

						if ( ! empty( $featured_prop_title ) ) {
							?>
                            <div class="narrative">
                                <h3><?php echo esc_html( $featured_prop_title ); ?></h3>
								<?php
								if ( ! empty( $featured_prop_text ) ) {
									?><p><?php echo esc_html( $featured_prop_text ); ?></p><?php
								}
								?>
                            </div>
							<?php
						}
						?>
                        <div class="rh_featured_properties__slider loading">
                            <ul class="slides">
								<?php
								while ( $featured_properties_query->have_posts() ) :
									$featured_properties_query->the_post();
									?>
                                    <li class="rh_featured_properties__slide">
                                        <div class="rh_slide__container clearfix">

                                            <figure class="span6 rh_slide__image">
                                                <div class="wrapper">
                                                    <a href="<?php the_permalink(); ?>"
                                                       title="<?php the_title_attribute(); ?>">
														<?php
														if ( has_post_thumbnail() ) {
															the_post_thumbnail( 'gallery-two-column-image' );
														} else {
															inspiry_image_placeholder( 'gallery-two-column-image' );
														}
														?>
                                                    </a>
													<?php
													$statuses = inspiry_get_property_status( get_the_ID() );
													if ( ! empty( $statuses ) ) {
														?>
                                                        <div class="statuses">
															<?php
															echo wp_kses( $statuses, array(
																'a' => array(
																	'href'  => array(),
																	'title' => array(),
																),
															) );
															?>
                                                        </div>
														<?php
													}
													?>
                                                </div>
                                            </figure>

                                            <div class="span5 rh_slide__details">
                                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                <div class="rh_prop_details clearfix">
                                                    <div class="rh_prop_details__price">
														<?php
														if ( function_exists( 'ere_get_property_price' ) ) {
															?>
                                                            <p class="price"><?php echo ere_get_property_price(); ?></p><?php
														}
														?>
                                                        <p class="type"><?php echo inspiry_get_property_types_string( get_the_id() ); ?></p>
                                                    </div>
                                                    <div class="rh_prop_details__buttons">
                                                        <a href="<?php the_permalink() ?>"><?php esc_html_e( 'More Details', 'framework' ); ?></a>
														<?php
														$images_count = inspiry_get_number_of_photos( get_the_id() );
														$images_count = ( ! empty( $images_count ) ) ? intval( $images_count ) : false;
														$images_str   = ( 1 < $images_count ) ? esc_html__( 'Photos', 'framework' ) : esc_html__( 'Photo', 'framework' );
														?>

														<?php if ( ! empty( $images_count ) ) : ?>
                                                            <p class="photos">
                                                                <span class="fas fa-camera"></span>
                                                                <span><?php echo esc_html( $images_count . ' ' . $images_str ); ?></span>
                                                            </p>
														<?php endif; ?>
                                                    </div>
                                                </div>

                                                <p class="excerpt"><?php framework_excerpt( 20 ); ?></p>

                                                <div class="rh_prop_meta">
													<?php
													$post_meta_data = get_post_custom( get_the_id() ); // Get post meta
													$prop_size      = ( isset( $post_meta_data['REAL_HOMES_property_size'][0] ) ) ? $post_meta_data['REAL_HOMES_property_size'][0] : false; // Property Size
													$prop_bedrooms  = ( isset( $post_meta_data['REAL_HOMES_property_bedrooms'][0] ) ) ? $post_meta_data['REAL_HOMES_property_bedrooms'][0] : false; // Property Bedrooms
													$prop_bathrooms = ( isset( $post_meta_data['REAL_HOMES_property_bathrooms'][0] ) ) ? $post_meta_data['REAL_HOMES_property_bathrooms'][0] : false; // Property Bathrooms

													$prop_size      = ( ! empty( $prop_size ) ) ? floatval( $prop_size ) : false;
													$prop_bedrooms  = ( ! empty( $prop_bedrooms ) ) ? floatval( $prop_bedrooms ) : false;
													$prop_bathrooms = ( ! empty( $prop_bathrooms ) ) ? floatval( $prop_bathrooms ) : false;
													?>
													<?php if ( ! empty( $prop_size ) ) : ?>
                                                        <div class="rh_prop_meta__single">
                                                            <span class="icon">
                                                                <?php inspiry_safe_include_svg( '/images/icon-area.svg' ); ?>
                                                            </span>
                                                            <p class="details">
                                                                <span class="number"> <?php echo esc_html( $prop_size ); ?> </span>
																<?php if ( ! empty( $post_meta_data['REAL_HOMES_property_size_postfix'][0] ) ) : ?>
                                                                    <span><?php echo esc_html( $post_meta_data['REAL_HOMES_property_size_postfix'][0] ); ?></span>
																<?php endif; ?>
                                                            </p>
                                                        </div>
													<?php endif; ?>

													<?php if ( ! empty( $prop_bedrooms ) ) : ?>
                                                        <div class="rh_prop_meta__single">
                                                            <span class="icon">
                                                                <?php inspiry_safe_include_svg( '/images/icon-bed.svg' ); ?>
                                                            </span>
                                                            <p class="details">
                                                                <span class="number"> <?php echo esc_html( $prop_bedrooms ); ?> </span>
                                                                <span><?php ( $prop_bedrooms > 1 ) ? esc_html_e( 'Bedrooms', 'framework' ) : esc_html_e( 'Bedroom', 'framework' ); ?></span>
                                                            </p>
                                                        </div>
													<?php endif; ?>

													<?php if ( ! empty( $prop_bathrooms ) ) : ?>
                                                        <div class="rh_prop_meta__single">
                                                            <span class="icon">
                                                                <?php inspiry_safe_include_svg( '/images/icon-bath.svg' ); ?>
                                                            </span>
                                                            <p class="details">
                                                                <span class="number"> <?php echo esc_html( $prop_bathrooms ); ?> </span>
                                                                <span><?php ( $prop_bathrooms > 1 ) ? esc_html_e( 'Bathrooms', 'framework' ) : esc_html_e( 'Bathroom', 'framework' ); ?></span>
                                                            </p>
                                                        </div>
													<?php endif; ?>
                                                </div>
                                                <!-- /.rh_prop_meta -->
                                            </div>
                                            <!-- /.rh_slide__details -->
                                        </div>
                                        <!-- /.rh_slide__container -->
                                    </li>
                                    <!-- /.rh_featured_properties__slide -->
								<?php endwhile; ?>
                            </ul><!-- /.slides -->
                        </div><!-- /.rh_featured_properties__slider loading -->
                    </section><!-- /#rh_featured_properties.clearfix -->
				<?php else : ?>
                    <div class="main">
                        <section class="featured-properties-carousel clearfix">
							<?php
							$featured_prop_title = get_post_meta( get_the_ID(), 'theme_featured_prop_title', true );
							$featured_prop_text  = get_post_meta( get_the_ID(), 'theme_featured_prop_text', true );

							if ( ! empty( $featured_prop_title ) ) {
								?>
                                <div class="narrative">
                                    <h3><?php echo esc_html( $featured_prop_title ); ?></h3>
									<?php
									if ( ! empty( $featured_prop_text ) ) {
										?>
                                        <p><?php echo wp_kses( $featured_prop_text, inspiry_allowed_html() ); ?></p><?php
									}
									?>
                                </div>
								<?php
							}

							?>
                            <div class="carousel es-carousel-wrapper">
                                <div class="es-carousel">
                                    <ul class="clearfix">
										<?php
										while ( $featured_properties_query->have_posts() ) :
											$featured_properties_query->the_post();
											?>
                                            <li>
                                                <figure>
                                                    <a href="<?php the_permalink(); ?>"
                                                       title="<?php the_title_attribute(); ?>"><?php
														if ( has_post_thumbnail() ) {
															the_post_thumbnail( 'property-thumb-image' );
														} else {
															inspiry_image_placeholder( 'property-thumb-image' );
														}
														?></a>
                                                </figure>
                                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                <p><?php
													framework_excerpt( 10 );
													$button_label = get_option( 'inspiry_string_know_more', esc_html__( 'Know More', 'framework' ) );
													?>
                                                    <a href="<?php the_permalink() ?>"> <?php echo esc_html( $button_label ); ?> </a>
                                                </p>
												<?php
												if ( function_exists( 'ere_get_property_price' ) ) {
													echo '<span class="price">' . ere_get_property_price() . '</span>';
												}
												?>
                                            </li>
										<?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div><!-- /.main -->
				<?php endif; ?>
            </div><!-- /.span12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
	<?php
	wp_reset_postdata();
endif;