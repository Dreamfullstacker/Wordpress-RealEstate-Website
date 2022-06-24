<?php
/**
 * Widget: Inspiry Properties Widget
 *
 * @since 3.0.0
 * @package easy_real_estate
 */

if ( ! class_exists( 'Inspiry_Properties_Widget' ) ) {

	/**
	 * Inspiry_Properties_Widget.
	 *
	 * Widget of Properties.
	 *
	 * @since 4.0.0
	 */
	class Inspiry_Properties_Widget extends WP_Widget {

		/**
		 * Method: Constructor
		 *
		 * @since  1.0.0
		 */
		function __construct() {
			$widget_ops = array(
				'classname'                   => 'Inspiry_Properties_Widget',
				'description'                 => esc_html__( 'Displays Properties based on custom filters.', 'easy-real-estate' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct(
				'Inspiry_Properties_Widget',
				esc_html__( 'RealHomes - Properties', 'easy-real-estate' ),
				$widget_ops
			);
		}

		/**
		 * Method: Widget Front-End
		 *
		 * @param array $args - Arguments of the widget.
		 * @param array $instance - Instance of the widget.
		 */
		function widget( $args, $instance ) {

			extract( $args );

			// Title
			if ( isset( $instance['title'] ) ) {
				$title = apply_filters( 'widget_title', $instance['title'] );
			}

			if ( isset( $instance['view_property'] ) ) {
				$view_property = apply_filters( 'view_property', $instance['view_property'] );
			}

			if ( empty( $title ) ) {
				$title = false;
			}

			// Count
			$count = 1;
			if ( isset( $instance['count'] ) ) {
				$count = intval( $instance['count'] );
			}

			$prop_args = array(
				'post_type'      => 'property',
				'posts_per_page' => $count
			);

			// Property Location
            if ( isset( $instance['property_location'] ) ) {
	            $all_locations = $instance['property_location'];
	            if ( ! empty( $all_locations ) ) {
		            $tax_query[] = array(
			            'taxonomy' => 'property-city',
			            'field'    => 'slug',
			            'terms'    => $all_locations,
		            );
	            }
            }

			// Property Status
			if ( isset( $instance['property_status'] ) ) {
				$all_statuses = $instance['property_status'];
				if ( ! empty( $all_statuses ) ) {
					$tax_query[] = array(
						'taxonomy' => 'property-status',
						'field'    => 'slug',
						'terms'    => $all_statuses,
					);
				}
			}

			// Property Type
			if ( isset( $instance['property_type'] ) ) {
				$all_types = $instance['property_type'];
				if ( ! empty( $all_types ) ) {
					$tax_query[] = array(
						'taxonomy' => 'property-type',
						'field'    => 'slug',
						'terms'    => $all_types,
					);
				}
			}

			// Property Feature
			if ( isset( $instance['property_feature'] ) ) {
				$all_features = $instance['property_feature'];
				if ( ! empty( $all_features ) ) {
					$tax_query[] = array(
						'taxonomy' => 'property-feature',
						'field'    => 'slug',
						'terms'    => $all_features
					);
				}
			}

			if ( ! empty( $tax_query ) ) {
				$prop_args['tax_query'] = $tax_query;
			}

			// Order by
			$sort_by = 'recent';
			if ( isset( $instance['sort_by'] ) ) {
				$sort_by = $instance['sort_by'];
			}
			if ( 'random' == $sort_by ) :
				$prop_args['orderby'] = 'rand';
			else :
				$prop_args['orderby'] = 'date';
			endif;

			$prop_query = new WP_Query( apply_filters( 'ere_properties_widget', $prop_args ) );

			echo $before_widget;

			if ( $title ) :
				echo $before_title;
				echo $title;
				echo $after_title;
			endif;

			if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
				if ( $prop_query->have_posts() ) :
					?>
                    <ul class="featured-properties">
						<?php
						while ( $prop_query->have_posts() ) :
							$prop_query->the_post();
							?>
                            <li>
                                <figure>
                                    <a href="<?php the_permalink(); ?>">
										<?php
										if ( has_post_thumbnail() ) {
											the_post_thumbnail( 'property-thumb-image' );
										} else {
											if ( function_exists( 'inspiry_image_placeholder' ) ) {
												inspiry_image_placeholder( 'property-thumb-image' );
											}
										}
										?>
                                    </a>
                                </figure>

                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <p><?php ere_framework_excerpt( 7 ); ?>
		                            <?php if ( isset( $view_property ) && !empty($view_property) ) { ?>
                                        <a href="<?php the_permalink(); ?>"><?php echo esc_html( $view_property ); ?></a>
			                            <?php
		                            } else {
			                            ?>
                                        <a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'easy-real-estate' ); ?></a>
			                            <?php
		                            }
		                            ?>
                                </p>
								<?php
								$price = ere_get_property_price();
								if ( $price ) {
									echo '<span class="price">' . esc_html( $price ) . '</span>';
								}
								?>
                            </li>
						<?php
						endwhile;
						?>
                    </ul>
					<?php
					wp_reset_query();
				else :
					?>
                    <ul class="featured-properties">
						<?php
						echo '<li>';
						esc_html_e( 'No Property Found!', 'easy-real-estate' );
						echo '</li>';
						?>
                    </ul>
				<?php
				endif;

			} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {

				if ( $prop_query->have_posts() ) :
					if ( isset( $instance['card_design'])  && 'default' != $instance['card_design']  ) {
						$property_card_variation = $instance['card_design'];
					}else {
						$inspiry_property_card_variation = get_option( 'inspiry_property_card_variation', '1' );
						$property_card_variation = $inspiry_property_card_variation;
					}
					while ( $prop_query->have_posts() ) :
						$prop_query->the_post();

						ere_get_template_part('includes/widgets/grid-cards/grid-card-'.$property_card_variation);
						?>
                        <!-- /.rh_prop_card -->
					<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
                    <div class="rh_alert-wrapper rh_alert__widget">
                        <h4 class="no-results"><?php esc_html_e( 'No Property Found!', 'easy-real-estate' ); ?></h4>
                    </div>
				<?php
				endif;
			}

			echo $after_widget;
		}

		/**
		 * Method: Widget Backend Form
		 *
		 * @param array $instance - Instance of the widget.
		 *
		 * @return void
		 */
		function form( $instance ) {

			if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				$label_property = esc_html__('View Property','easy-real-estate');
			}elseif ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
				$label_property = esc_html__('Read More','easy-real-estate');
			}

			$instance = wp_parse_args(
				(array) $instance, array(
					'title'   => esc_html__( 'Properties', 'easy-real-estate' ),
					'count'   => 1,
					'sort_by' => 'random',
					'view_property'  => $label_property,
				)
			);
			$view_property = esc_attr( $instance['view_property'] );
			$title         = esc_attr( $instance['title'] );
			$count         = $instance['count'];
			$card_design   = isset( $instance['card_design'] ) ? $instance['card_design'] : 'default';
			$sort_by       = $instance['sort_by'];
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'easy-real-estate' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'card_design' ) ); ?>"><?php _e( 'Property Card Design', 'easy-real-estate' ); ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'card_design' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'card_design' ) ); ?>" class="widefat">
                    <option value="default"<?php selected( $card_design, 'default' ); ?>><?php _e( 'Default', 'easy-real-estate' ); ?></option>
                    <option value="1"<?php selected( $card_design, '1' ); ?>><?php _e( 'One', 'easy-real-estate' ); ?></option>
                    <option value="2"<?php selected( $card_design, '2' ); ?>><?php _e( 'Two', 'easy-real-estate' ); ?></option>
                    <option value="3"<?php selected( $card_design, '3' ); ?>><?php _e( 'Three', 'easy-real-estate' ); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Properties', 'easy-real-estate' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $count ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>"><?php esc_html_e( 'Sort By:', 'easy-real-estate' ); ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'sort_by' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>" class="widefat">
                    <option value="recent" <?php selected( $sort_by, 'recent' ); ?>><?php esc_html_e( 'Most Recent', 'easy-real-estate' ); ?></option>
                    <option value="random" <?php selected( $sort_by, 'random' ); ?>><?php esc_html_e( 'Random', 'easy-real-estate' ); ?></option>
                </select>
            </p>

            <p><?php
				if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
					?><label for="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>"><?php _e( 'View Property', 'easy-real-estate' ); ?></label><?php
				} elseif ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
					?><label for="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>"><?php _e( 'Read More', 'easy-real-estate' ); ?></label><?php
				}
				?>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_property' ) ); ?>" type="text" value="<?php echo esc_attr( $view_property ); ?>"/>
            </p>

            <?php
			// Property Locations
			$all_locations = ERE_Data::get_locations_slug_name();
			if ( ! empty( $all_locations ) ) {
				?>
                <p class="tax-option">
                    <label for="<?php echo esc_attr( $this->get_field_id( 'property_location' ) ); ?>">
                        <strong><?php esc_html_e( 'Property Location:', 'easy-real-estate' ); ?></strong>
                    </label><br/>
					<?php
					$selected_locations = '';
					if ( isset( $instance['property_location'] ) ) {
						$selected_locations = $instance['property_location'];
					}

					foreach ( $all_locations as $location_slug => $location_name ) {
						$checked = '';
						$location_name = str_replace('- ','',$location_name );  // remove prefixes from name
						if ( is_array( $selected_locations ) && ! empty( $selected_locations ) ) {
							if ( in_array( $location_slug, $selected_locations ) ) {
								$checked = 'checked';
							}
						}
						?>
                        <label><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'property_location' ) ); ?>[]"
                                      value="<?Php echo esc_attr( $location_slug ); ?>" <?php echo $checked; ?>> <?php echo esc_html( $location_name ); ?>
                        </label>
						<?php
					}
					?>
                </p>
				<?php
			}


			// Property Statuses
			$all_statuses = ERE_Data::get_statuses_slug_name();
			if ( ! empty( $all_statuses ) ) {
				?>
                <p class="tax-option">
                    <label for="<?php echo esc_attr( $this->get_field_id( 'property_status' ) ); ?>">
                        <strong><?php esc_html_e( 'Property Status:', 'easy-real-estate' ); ?></strong>
                    </label><br/>
					<?php
					$selected_statuses = '';
					if ( isset( $instance['property_status'] ) ) {
						$selected_statuses = $instance['property_status'];
					}

					foreach ( $all_statuses as $status_slug => $status_name ) {
						$checked = '';
						if ( is_array( $selected_statuses ) && ! empty( $selected_statuses ) ) {
							if ( in_array( $status_slug, $selected_statuses ) ) {
								$checked = 'checked';
							}
						}
						?>
                        <label><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'property_status' ) ); ?>[]"
                                      value="<?Php echo esc_attr( $status_slug ); ?>" <?php echo $checked; ?>> <?php echo esc_html( $status_name ); ?>
                        </label>
						<?php
					}
					?>
                </p>
				<?php
			}

			// Property Types
			$all_types = ERE_Data::get_types_slug_name();
			if ( ! empty( $all_types ) ) {
				?>
                <p class="tax-option">
                    <label for="<?php echo esc_attr( $this->get_field_id( 'property_type' ) ); ?>">
                        <strong><?php esc_html_e( 'Property Types:', 'easy-real-estate' ); ?></strong>
                    </label><br/>
					<?php
					$selected_types = '';
					if ( isset( $instance['property_type'] ) ) {
						$selected_types = $instance['property_type'];
					}

					foreach ( $all_types as $type_slug => $type_name ) {
						$checked = '';
						$type_name = str_replace('- ','',$type_name );  // remove prefixes from name
						if ( is_array( $selected_types ) && ! empty( $selected_types ) ) {
							if ( in_array( $type_slug, $selected_types ) ) {
								$checked = 'checked';
							}
						}
						?>
                        <label><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'property_type' ) ); ?>[]"
                                      value="<?php echo esc_attr( $type_slug ); ?>" <?php echo $checked; ?>> <?php echo esc_html( $type_name ); ?></label>
						<?php
					}
					?>
                </p>
				<?php
			}

			// Property Features
			$all_features = ERE_Data::get_features_slug_name();
			if ( ! empty( $all_features ) ) {
				?>

                <p class="tax-option">
                    <label for="<?php echo esc_attr( $this->get_field_id( 'property_feature' ) ); ?>"><strong><?php esc_html_e( 'Property Feature:', 'easy-real-estate' ); ?></strong></label><br>
					<?php
					$selected_features = '';
					if ( isset( $instance['property_feature'] ) ) {
						$selected_features = $instance['property_feature'];
					}

					foreach ( $all_features as $term_slug => $term_name ) {
						$checked = '';
						if ( is_array( $selected_features ) && ! empty( $selected_features ) ) {
							if ( in_array( $term_slug, $selected_features ) ) {
								$checked = 'checked';
								inspiry_log('checked - '.$term_slug);
							}
						}
						?>
                        <label><input type="checkbox"
                                      name="<?php echo esc_attr( $this->get_field_name( 'property_feature' ) ); ?>[]"
                                      value="<?Php echo $term_slug; ?>" <?php echo $checked; ?>> <?php echo $term_name; ?></label>
						<?php
					}
					?>
                </p>
				<?php
			}
		}

		/**
		 * Method: Widget Update Function
		 *
		 * @param array $new_instance - New instance of the widget.
		 * @param array $old_instance - Old instance of the widget.
		 *
		 * @return array
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']             = strip_tags( isset( $new_instance['title'] ) ? $new_instance['title'] : '' );
			$instance['view_property']     = strip_tags( isset( $new_instance['view_property'] ) ? $new_instance['view_property'] : '' );
			$instance['count']             = isset( $new_instance['count'] ) ? $new_instance['count'] : 1;
			$instance['sort_by']           = isset( $new_instance['sort_by'] ) ? $new_instance['sort_by'] : '';
			$instance['property_location'] = isset( $new_instance['property_location'] ) ? $new_instance['property_location'] : '';
			$instance['property_status']   = isset( $new_instance['property_status'] ) ? $new_instance['property_status'] : '';
			$instance['property_type']     = isset( $new_instance['property_type'] ) ? $new_instance['property_type'] : '';
			$instance['property_feature']  = isset( $new_instance['property_feature'] ) ? $new_instance['property_feature'] : '';
			$instance['card_design']       = isset( $new_instance['card_design'] ) ? $new_instance['card_design'] : '';

			return $instance;
		}

	}
}


if ( ! function_exists( 'inspiry_register_properties_widget' ) ) {
	function inspiry_register_properties_widget() {
		register_widget( 'Inspiry_Properties_Widget' );
	}

	add_action( 'widgets_init', 'inspiry_register_properties_widget' );
}