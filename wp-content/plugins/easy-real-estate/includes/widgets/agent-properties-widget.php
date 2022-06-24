<?php
/**
 * Widget: Agent Related Properties
 *
 */

if ( ! class_exists( 'Agent_Properties_Widget' ) ) {

	/**
	 * Class: Widget class for Agent Related Properties
	 *
	 */
	class Agent_Properties_Widget extends WP_Widget {

		/**
		 * Method: Constructor
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$widget_ops = array(
				'classname'                   => 'Agent_Properties_Widget',
				'description'                 => esc_html__( 'Displays random, recent or featured properties based on selected agent.', 'easy-real-estate' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'Agent_Properties_Widget', esc_html__( 'RealHomes - Agent Related Properties', 'easy-real-estate' ), $widget_ops );
		}

		/**
		 * Method: Widget's Display
		 *
		 * @param array $args - Array of arguments.
		 * @param array $instance - Array of widget arguments.
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

			// Agent
			$agent = 0;
			if ( isset( $instance['agent'] ) ) {
				$agent = $instance['agent'];
			}

			$featured = isset( $instance['featured'] ) ? (bool) $instance['featured'] : false;

			$agent_properties_args = array(
				'post_type'      => 'property',
				'posts_per_page' => $count,
				'meta_query'     => array(
					array(
						'key'     => 'REAL_HOMES_agents',
						'value'   => $agent,
						'compare' => '=',
					),
				),
			);

			// If show only Featured Properties.
			if ( $featured ) {
				$agent_properties_args['meta_query'][] = array(
					'key'     => 'REAL_HOMES_featured',
					'value'   => 1,
					'compare' => '=',
					'type'    => 'NUMERIC',
				);
			}

			// Order by
			$sort_by = 'recent';
			if ( isset( $instance['sort_by'] ) ) {
				$sort_by = $instance['sort_by'];
			}
			if ( 'random' == $sort_by ) :
				$agent_properties_args['orderby'] = 'rand';
			else :
				$agent_properties_args['orderby'] = 'date';
			endif;

			$agent_properties_query = new WP_Query( apply_filters( 'ere_agent_properties_widget', $agent_properties_args )  );

			echo $before_widget;

			if ( $title ) :
				echo $before_title;
				echo $title;
				echo $after_title;
			endif;

			if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {

				if ( $agent_properties_query->have_posts() ) :
					?>
                    <ul class="featured-properties">
						<?php
						while ( $agent_properties_query->have_posts() ) :
							$agent_properties_query->the_post();
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
									echo '<span class="price">' . $price . '</span>';
								}
								?>

                            </li>
						<?php
						endwhile;
						?>
                    </ul>
					<?php
					wp_reset_postdata();
				else :
					?>
                    <ul class="featured-properties">
						<?php
						echo '<li>';
						esc_html_e( 'No Property Found Under Selected Agent!', 'easy-real-estate' );
						echo '</li>';
						?>
                    </ul>
				<?php
				endif;

			} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				if ( $agent_properties_query->have_posts() ) :
					if ( isset( $instance['card_design'])  && 'default' != $instance['card_design']  ) {
						$property_card_variation = $instance['card_design'];
					}else {
						$inspiry_property_card_variation = get_option( 'inspiry_property_card_variation', '1' );
						$property_card_variation = $inspiry_property_card_variation;
					}
					while ( $agent_properties_query->have_posts() ) :
						$agent_properties_query->the_post();
						ere_get_template_part('includes/widgets/grid-cards/grid-card-'.$property_card_variation);

					?>
                        <!-- /.rh_prop_card -->
					<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
                    <div class="rh_alert-wrapper rh_alert__widget">
                        <h4 class="no-results"><?php esc_html_e( 'No Property Found Under Selected Agent!', 'easy-real-estate' ); ?></h4>
                    </div>
				<?php
				endif;
			}

			echo $after_widget;
		}

		/**
		 * Method: Update Widget Options
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
					'title'   => 'Agent Related Properties',
					'count'   => 1,
					'sort_by' => 'random',
					'view_property'  => $label_property,
				)
			);
			$view_property  = esc_attr( $instance['view_property'] );
			$title = esc_attr( $instance['title'] );
			$agent = null;
			if ( isset( $instance['agent'] ) ) {
				$agent = $instance['agent'];
			}
			$sort_by     = $instance['sort_by'];
			$card_design = isset( $instance['card_design'] ) ? $instance['card_design'] : 'default';
			$count       = $instance['count'];
			$featured    = isset( $instance['featured'] ) ? (bool) $instance['featured'] : false;

			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'easy-real-estate' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
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
                <label for="<?php echo esc_attr( $this->get_field_id( 'agent' ) ); ?>"><?php esc_html_e( 'Select an Agent:', 'easy-real-estate' ); ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'agent' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'agent' ) ); ?>" class="widefat">
					<?php ere_generate_posts_list( 'agent', $agent ); ?>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>"><?php esc_html_e( 'Sort By:', 'easy-real-estate' ); ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'sort_by' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>" class="widefat">
                    <option value="recent"<?php selected( $sort_by, 'recent' ); ?>><?php esc_html_e( 'Most Recent', 'easy-real-estate' ); ?></option>
                    <option value="random"<?php selected( $sort_by, 'random' ); ?>><?php esc_html_e( 'Random', 'easy-real-estate' ); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Properties', 'easy-real-estate' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3"/>
            </p>
            <p>
                <input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'featured' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featured' ) ); ?>" type="checkbox" <?php checked( $featured ); ?>/>
                <label for="<?php echo esc_attr( $this->get_field_id( 'featured' ) ); ?>"><?php esc_html_e( 'Show only Featured Properties.', 'easy-real-estate' ); ?></label>
            </p>
            <p>
				<?php
				if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
					?>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>"><?php _e( 'View Property', 'easy-real-estate' ); ?></label>
					<?php
				} elseif ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
					?>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>"><?php _e( 'Read More', 'easy-real-estate' ); ?></label>
					<?php
				}
				?>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_property' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'view_property' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $view_property ); ?>"/>
            </p>
			<?php
		}

		/**
		 * Method: Update Widget Options
		 *
		 * @param array $new_instance - New instance.
		 * @param array $old_instance - Old instance.
		 *
		 * @return array
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']         = strip_tags( isset( $new_instance['title'] ) ? $new_instance['title'] : '' );
			$instance['view_property'] = strip_tags( isset( $new_instance['view_property'] ) ? $new_instance['view_property'] : '' );
			$instance['agent']         = isset( $new_instance['agent'] ) ? $new_instance['agent'] : '';
			$instance['sort_by']       = isset( $new_instance['sort_by'] ) ? $new_instance['sort_by'] : '';
			$instance['card_design']   = isset( $new_instance['card_design'] ) ? $new_instance['card_design'] : '';
			$instance['count']         = isset( $new_instance['count'] ) ? $new_instance['count'] : 1;
			$instance['featured']      = isset( $new_instance['featured'] ) ? (bool) $new_instance['featured'] : false;

			return $instance;
		}

	}
}

if ( ! function_exists( 'register_agent_properties_widget' ) ) {
	function register_agent_properties_widget() {
		register_widget( 'Agent_Properties_Widget' );
	}

	add_action( 'widgets_init', 'register_agent_properties_widget' );
}