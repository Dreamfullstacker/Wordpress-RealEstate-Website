<?php
/**
 * Property: Compare Properties Template
 *
 * Page template for compare properties.
 *
 * @since    3.0.0
 * @package realhomes/modern
 */

get_header();

$header_variation = get_option( 'inspiry_member_pages_header_variation','banner' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

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

    <section class="rh_section rh_wrap rh_wrap--padding rh_wrap--topPadding">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
        <div class="rh_page">

			<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
                <div class="rh_page__head">

                    <h2 class="rh_page__title">
						<?php
						$page_title = get_the_title( get_the_ID() );
						echo inspiry_get_exploded_heading( $page_title );
						?>
                    </h2>
                    <!-- /.rh_page__title -->

                </div>
                <!-- /.rh_page__head -->
			<?php

			endif;

			$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer', true );

			if ( $get_content_position !== '1' ) {

				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						?>
                        <div class="rh_content <?php if ( get_the_content() ) {
							echo esc_attr( 'rh_page__content' );
						} ?>">
							<?php the_content(); ?>
                        </div>
                        <!-- /.rh_content -->
						<?php

					}
				}
			}
			?>

            <div class="rh_prop_compare">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" class="rh_prop_compare__wrap">

							<?php if ( ! empty( $compare_list_items ) ) : ?>

								<?php if ( ! empty( $compare_properties ) ) : ?>

                                    <div class="rh_prop_compare__row clearfix rh_prop_compare__details rh_prop_compare--height_fixed">

                                        <div class="rh_prop_compare__column heading">

                                            <div class="property-thumbnail">
                                            </div>
                                            <!-- /.property-thumbnail -->

                                            <p><?php esc_html_e( 'Type', 'framework' ); ?></p>

                                            <p><?php esc_html_e( 'Location', 'framework' ); ?></p>

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
		                                        if ( ! empty( get_option( 'inspiry_prop_id_field_label' ) ) ) {
			                                        echo esc_html( get_option( 'inspiry_prop_id_field_label' ) );
		                                        } else {
			                                        esc_html_e( 'Property ID', 'framework' );
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

                                        </div>
                                        <!-- /.rh_prop_compare__column -->

										<?php foreach ( $compare_properties as $compare_property ) : ?>

                                            <div class="rh_prop_compare__column details">

                                                <div class="property-thumbnail">

													<?php if ( ! empty( $compare_property['img'] ) ) : ?>
                                                        <a class="thumbnail" href="<?php echo esc_attr( $compare_property['permalink'] ); ?>">
                                                            <img
                                                                    src="<?php echo esc_attr( $compare_property['img'][0] ); ?>"
                                                                    width="<?php echo isset( $compare_property['img'][1] ) ? esc_attr( $compare_property['img'][1] ) : '100%'; ?>"
                                                                    height="<?php echo isset( $compare_property['img'][2] ) ? esc_attr( $compare_property['img'][2] ) : 'auto'; ?>"
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

                                                    <h5 class="property-status">
														<?php echo esc_html( display_property_status( $compare_property['ID'] ) ); ?>
                                                    </h5>
                                                    <!-- /.property-status -->

                                                    <div class="property-price">
                                                        <p>
															<?php
															if ( function_exists( 'ere_get_property_price' ) ) {
																echo esc_html( ere_get_property_price( $compare_property['ID'] ) );
															}
															?>
                                                        </p>
                                                    </div>
                                                    <!-- Property Price -->

                                                </div>
                                                <!-- /.property-thumbnail -->

                                                <p class="property-type">
													<?php
													$compare_property_types = get_the_term_list( $compare_property['ID'], 'property-type', '', ',', '' );
													if ( ! empty( $compare_property_types ) && ! is_wp_error( $compare_property_types ) ) {
														$compare_property_types = strip_tags( $compare_property_types );
														echo esc_html( $compare_property_types );
													} else {
														inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
													}
													?>
                                                </p>
                                                <!-- Property Type -->
                                                <p>
													<?php
													$compare_property_cities = wp_get_object_terms(
														$compare_property['ID'], 'property-city'
													);
													if ( empty( $compare_property_cities ) || is_wp_error( $compare_property_cities ) ) {
														inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
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
                                                <!-- Property Location -->

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
														inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
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
														inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
													}
													?>
                                                </p>
                                                <!-- Property Size -->

                                                <p>
													<?php
													if ( ! empty( $post_meta_data['REAL_HOMES_property_id'][0] ) ) {
														$prop_id = $post_meta_data['REAL_HOMES_property_id'][0];
														echo esc_html( $prop_id );
													} else {
														inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
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
			                                            inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
		                                            }
		                                            ?>
                                                </p>

                                                <p>
													<?php
													if ( ! empty( $post_meta_data['REAL_HOMES_property_bedrooms'][0] ) ) {
														$prop_bedrooms = floatval( $post_meta_data['REAL_HOMES_property_bedrooms'][0] );
														echo esc_html( $prop_bedrooms );
													} else {
														inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
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
														inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
													}
													?>
                                                </p>

                                                <p>
		                                            <?php
		                                            if ( ! empty( $post_meta_data['REAL_HOMES_property_garage'][0] ) ) {
			                                            $prop_garages = floatval( $post_meta_data['REAL_HOMES_property_garage'][0] );
			                                            echo esc_html( $prop_garages );
		                                            } else {
			                                            inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
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
												if ( class_exists('ERE_Data')) {
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

														if ( $property_features[ $index ] == $feature_names[ $index ] ) {

															echo '<p>';
															inspiry_safe_include_svg( '/images/icons/icon-check.svg' );
															echo '</p>';

														} else {

															/**
															 * If feature doesn't match then add a 0 at that
															 * index of property_features array.
															 */
															array_splice( $property_features, $index, 0, array( 0 ) );
															echo '<p>';
															inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
															echo '</p>';
														}
													} else {
														echo '<p>';
														inspiry_safe_include_svg( '/images/icons/icon-cross.svg' );
														echo '</p>';
													}
												}
												?>

                                            </div>
                                            <!-- /.rh_prop_compare__column -->

										<?php endforeach; ?>

                                    </div>
                                    <!-- /.rh_prop_compare__row -->

								<?php endif; ?>

							<?php else : ?>

                                <p class="nothing-found"><?php esc_html_e( 'No Properties Found!', 'framework' ); ?></p>

							<?php endif; ?>

                        </article>
                        <!-- /.rh_prop_compare__wrap -->

					<?php endwhile; ?>

				<?php endif; ?>

            </div>
            <!-- /.rh_prop_compare -->

        </div>
        <!-- /.rh_page -->

    </section>

<?php
if ( '1' === $get_content_position ) {

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
            <div class="rh_content <?php if ( get_the_content() ) {
				echo esc_attr( 'rh_page__content' );
			} ?>">
				<?php the_content(); ?>
            </div>
            <!-- /.rh_content -->
			<?php

		}
	}
}
?>
    <!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php
get_footer();
