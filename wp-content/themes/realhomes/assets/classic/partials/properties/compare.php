<?php
/**
 * Property Compare Template
 *
 * Template of properties compare.
 *
 * @since    2.7.0
 * @package realhomes/classic
 */

get_header();

// Page Head.
get_template_part( 'assets/classic/partials/banners/default' );

if ( isset( $_GET['id'] ) ) {
	$compare_list_items = sanitize_text_field( $_GET['id'] );
	$compare_list_items = explode( ',', $compare_list_items );
}

$count = 0;

if ( ! empty( $compare_list_items ) ) {

	foreach ( $compare_list_items as $compare_list_item ) {

		if ( 4 > $count ) {

			$compare_property = get_post( $compare_list_item );

			if ( isset( $compare_property->ID ) ) {
				$thumbnail_id = get_post_thumbnail_id( $compare_property->ID );
				if ( isset( $thumbnail_id ) && ! empty( $thumbnail_id ) ) {
					$compare_property_img = wp_get_attachment_image_src(
						get_post_meta( $compare_property->ID, '_thumbnail_id', true ), 'property-thumb-image'
					);
				} else {
					$compare_property_img[0] = get_inspiry_image_placeholder_url( 'property-thumb-image' );
				}
				$compare_property_permalink = get_permalink( $compare_property->ID );
				$compare_properties[]       = array(
					'ID'        => $compare_property->ID,
					'title'     => $compare_property->post_title,
					'img'       => $compare_property_img,
					'permalink' => $compare_property_permalink,
				);
			}
		} else {
			break;
		}

		$count ++;

	}
}

?>

    <!-- Content -->
    <div class="container contents single">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
        <div class="row">

            <div class="span12 main-wrap">
                <!-- Main Content -->
                <div class="main">

                    <div class="inner-wrapper scroll-fix">
						<?php

						$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer', true );

						if ( $get_content_position !== '1' ) {

							if ( have_posts() ) {
								while ( have_posts() ) {
									the_post();
									?>
                                    <article id="content-post-<?php the_ID(); ?>" <?php post_class(); ?>>
										<?php the_content(); ?>
                                    </article>
									<?php
								}
							}
						}

						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<?php if ( ! empty( $compare_list_items ) ) : ?>
                                        <div class="remove-overflow">

                                            <div class="row compare-template">

                                                <div class="span2 compare-feature-column">

                                                    <div class="property-thumbnail"></div>

                                                    <p><?php esc_html_e( 'City', 'framework' ); ?></p>

                                                    <p>
		                                                <?php
		                                                if ( ! empty( get_option( 'inspiry_lot_size_field_label' ) ) ) {
			                                                echo esc_html( get_option( 'inspiry_lot_size_field_label' ) );
		                                                } else {
			                                                esc_html_e( 'Lot Size', 'framework' );
		                                                }
		                                                ?>
                                                    </p>

                                                    <p>
		                                                <?php
		                                                if ( ! empty( get_option( 'inspiry_area_field_label' ) ) ) {
			                                                echo esc_html( get_option( 'inspiry_area_field_label' ) );
		                                                } else {
			                                                esc_html_e( 'Property Size', 'framework' );
		                                                }
		                                                ?>
                                                    </p>

                                                    <p>
		                                                <?php
		                                                if ( ! empty( get_option( 'inspiry_year_built_field_label' ) ) ) {
			                                                echo esc_html( get_option( 'inspiry_year_built_field_label' ) );
		                                                } else {
			                                                esc_html_e( 'Year Built', 'framework' );
		                                                }
		                                                ?>
                                                    </p>
                                                    <p>
		                                                <?php
		                                                if ( ! empty( get_option( 'inspiry_bedrooms_field_label' ) ) ) {
			                                                echo esc_html( get_option( 'inspiry_bedrooms_field_label' ) );
		                                                } else {
			                                                esc_html_e( 'Bedrooms', 'framework' );
		                                                }
		                                                ?>
                                                    </p>

                                                    <p>
		                                                <?php
		                                                if ( ! empty( get_option( 'inspiry_bathrooms_field_label' ) ) ) {
			                                                echo esc_html( get_option( 'inspiry_bathrooms_field_label' ) );
		                                                } else {
			                                                esc_html_e( 'Bathrooms', 'framework' );
		                                                }
		                                                ?>
                                                    </p>

                                                    <p>
		                                                <?php
		                                                if ( ! empty( get_option( 'inspiry_garages_field_label' ) ) ) {
			                                                echo esc_html( get_option( 'inspiry_garages_field_label' ) );
		                                                } else {
			                                                esc_html_e( 'Garages', 'framework' );
		                                                }
		                                                ?>
                                                    </p>

													<?php
                                                    if ( class_exists( 'ERE_Data' ) ) {
                                                        $all_features = ERE_Data::get_features_slug_name();
                                                        if ( ! empty( $all_features ) ) {
                                                            foreach ( $all_features as $feature ) {
                                                                ?><p><?php echo esc_html( $feature ); ?></p><?php
                                                            }
                                                        }
                                                    }
													?>
                                                </div><!-- /.span2 -->

												<?php if ( ! empty( $compare_properties ) ) : ?>

													<?php foreach ( $compare_properties as $compare_property ) : ?>

                                                        <div class="span2 compare-properties-column">

                                                            <div class="property-thumbnail">

																<?php if ( ! empty( $compare_property['img'] ) ) : ?>
                                                                    <a href="<?php echo esc_attr( $compare_property['permalink'] ); ?>">
                                                                        <img
                                                                                src="<?php echo esc_attr( $compare_property['img'][0] ); ?>"
                                                                                width="<?php echo esc_attr( $compare_property['img'][1] ); ?>"
                                                                                height="<?php echo esc_attr( $compare_property['img'][2] ); ?>"
                                                                        >
                                                                    </a>
																<?php endif; ?>
                                                                <!-- Property Thumbnail -->

                                                                <h5 class="property-title">
                                                                    <a href="<?php echo esc_attr( $compare_property['permalink'] ); ?>">
																		<?php echo esc_html( $compare_property['title'] ); ?>
                                                                    </a>
                                                                </h5>
                                                                <!-- Property Title -->

                                                                <p class="property-price">
																	<?php
																	if ( function_exists( 'ere_get_property_price' ) ) {
																		echo esc_html( ere_get_property_price( $compare_property['ID'] ) );
																	}
																	?>
                                                                </p>
                                                                <!-- Property Price -->

                                                                <p class="property-type">
																	<?php
																	$compare_property_types = get_the_term_list( $compare_property['ID'], 'property-type', '', ',', '' );
																	$compare_property_types = strip_tags( $compare_property_types );
																	if ( ! empty( $compare_property_types ) && ! is_wp_error( $compare_property_types ) ) {
																		echo esc_html( $compare_property_types );
																	} else {
																		echo '<i class="fas fa-times"></i>';
																	}
																	?>
                                                                </p>
                                                                <!-- Property Type -->

                                                            </div>
                                                            <!-- /.property-thumbnail -->

                                                            <p>
																<?php
																$compare_property_cities = wp_get_object_terms(
																	$compare_property['ID'], 'property-city'
																);
																if ( empty( $compare_property_cities ) || is_wp_error( $compare_property_cities ) ) {
																	echo '<i class="fas fa-times"></i>';
																} else {
																	$compare_property_cities = array_reverse(
																		$compare_property_cities
																	);
																	foreach ( $compare_property_cities as $compare_property_city ) {
																		// Check if the location is city or not.
																		if ( 0 == $compare_property_city->parent ) {
																			$city = $compare_property_city->name;
																			echo esc_html( $city );
																		}
																	}
																}
																?>
                                                            </p>
                                                            <!-- Property City -->

                                                            <p>

																<?php
																$post_meta_data = get_post_custom( $compare_property['ID'] );
																if ( ! empty( $post_meta_data['REAL_HOMES_property_lot_size'][0] ) ) {
																	$prop_size = $post_meta_data['REAL_HOMES_property_lot_size'][0];
																	if ( ! empty( $post_meta_data['REAL_HOMES_property_lot_size_postfix'][0] ) ) {
																		$prop_size_postfix = $post_meta_data['REAL_HOMES_property_lot_size_postfix'][0];
																		echo esc_html( $prop_size . ' ' . $prop_size_postfix );
																	}
																} else {
																	echo '<i class="fas fa-times"></i>';
																}
																?>
                                                            </p>
                                                            <!-- Property Area -->

                                                            <p>
																<?php
																$post_meta_data = get_post_custom( $compare_property['ID'] );
																if ( ! empty( $post_meta_data['REAL_HOMES_property_size'][0] ) ) {
																	$prop_size = $post_meta_data['REAL_HOMES_property_size'][0];
																	if ( ! empty( $post_meta_data['REAL_HOMES_property_size_postfix'][0] ) ) {
																		$prop_size_postfix = $post_meta_data['REAL_HOMES_property_size_postfix'][0];
																		echo esc_html( $prop_size . ' ' . $prop_size_postfix );
																	}
																} else {
																	echo '<i class="fas fa-times"></i>';
																}
																?>
                                                            </p>
                                                            <!-- Property Size -->
                                                            <p>
		                                                        <?php
		                                                        if ( ! empty( $post_meta_data['REAL_HOMES_property_year_built'][0] ) ) {
			                                                        $prop_year_built = floatval( $post_meta_data['REAL_HOMES_property_year_built'][0] );
			                                                        echo esc_html( $prop_year_built );
		                                                        } else {
			                                                        echo '<i class="fas fa-times"></i>';
		                                                        }
		                                                        ?>
                                                            </p>
                                                            <p>
																<?php
																if ( ! empty( $post_meta_data['REAL_HOMES_property_bedrooms'][0] ) ) {
																	$prop_bedrooms = floatval( $post_meta_data['REAL_HOMES_property_bedrooms'][0] );
																	echo esc_html( $prop_bedrooms );
																} else {
																	echo '<i class="fas fa-times"></i>';
																}
																?>
                                                            </p>
                                                            <!-- Bedrooms -->

                                                            <p>
																<?php
																if ( ! empty( $post_meta_data['REAL_HOMES_property_bathrooms'][0] ) ) {
																	$prop_bathrooms = floatval( $post_meta_data['REAL_HOMES_property_bathrooms'][0] );
																	echo esc_html( $prop_bathrooms );
																} else {
																	echo '<i class="fas fa-times"></i>';
																}
																?>
                                                            </p>
                                                            <p>
		                                                        <?php
		                                                        if ( ! empty( $post_meta_data['REAL_HOMES_property_garage'][0] ) ) {
			                                                        $prop_garages = floatval( $post_meta_data['REAL_HOMES_property_garage'][0] );
			                                                        echo esc_html( $prop_garages );
		                                                        } else {
			                                                        echo '<i class="fas fa-times"></i>';
		                                                        }
		                                                        ?>
                                                            </p>
                                                            <!-- Bathrooms -->

															<?php
															$property_feature_terms = get_the_terms(
																$compare_property['ID'], 'property-feature'
															);

															$property_features = array();
															if ( is_array( $property_feature_terms ) && ! is_wp_error( $property_feature_terms ) ) {
																foreach ( $property_feature_terms as $property_feature_term ) {
																	$property_features[] = $property_feature_term->name;
																}
															}

															$feature_names           = array();

															if ( class_exists( 'ERE_Data' ) ) {
																$property_feature_values = ERE_Data::get_features_slug_name();
																if ( ! empty( $property_feature_values ) ) {
																	foreach ( $property_feature_values as $property_feature_value ) {
																		$feature_names[] = $property_feature_value;
																	}
																}
															}

												            $features_count = count( $feature_names );

															for ( $index = 0; $index < $features_count; $index ++ ) {

																if ( isset( $property_features[ $index ] ) && isset( $feature_names[ $index ] ) ) {

																	if ( $property_features[ $index ] == $feature_names [ $index ] ) {

																		echo '<p><i class="fas fa-check"></i></p>';

																	} else {

																		/**
																		 * If feature doesn't match then add a 0 at that
																		 * index of property_features array.
																		 */
																		array_splice( $property_features, $index, 0, array( 0 ) );
																		echo '<p><i class="fas fa-times"></i></p>';

																	}
																} else {
																	echo '<p><i class="fas fa-times"></i></p>';
																}
															}
															?>
                                                        </div>

													<?php endforeach; ?>

												<?php endif; ?>

                                            </div>
                                        </div><!-- .remove-overflow -->
									<?php else : ?>
                                        <p class="nothing-found"><?php esc_html_e( 'No Properties Found!', 'framework' ); ?></p>
									<?php endif; ?>
                                </article>
							<?php
							endwhile;
						endif;
						?>
                    </div>

                </div><!-- End Main Content -->

				<?php
				if ( '1' === $get_content_position ) {

					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							?>
                            <article id="content-post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php the_content(); ?>
                            </article>
							<?php
						}
					}
				}
				?>

            </div> <!-- End span9 -->

        </div><!-- End contents row -->

    </div><!-- End Content -->

<?php get_footer(); ?>