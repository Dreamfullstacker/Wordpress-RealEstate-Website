<?php
/**
 * Widget: Agent Featured Properties Widget
 *
 */

if ( ! class_exists( 'Agent_Featured_Properties_Widget' ) ) {

	/**
	 * Agent_Featured_Properties_Widget.
	 *
	 * Widget of agent featured properties.
	 */
	class Agent_Featured_Properties_Widget extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'                   => 'Agent_Featured_Properties_Widget',
				'description'                 => esc_html__( 'Important: This widget is only for the Agent Sidebar.', 'easy-real-estate' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'Agent_Featured_Properties_Widget', esc_html__( 'RealHomes - Agent Featured Properties', 'easy-real-estate' ), $widget_ops );
		}

		function widget( $args, $instance ) {

			extract( $args );

			// Title
			if ( isset( $instance['title'] ) ) {
				$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
			}

			if ( isset( $instance['view_property'] ) ) {
				$view_property = apply_filters( 'view_property', $instance['view_property'], $instance, $this->id_base );
			}

			if ( isset( $instance['featured_text'] ) ) {
			    global $featured_text;
				$featured_text = apply_filters( 'featured_text', $instance['featured_text'], $instance, $this->id_base );
			}

			if ( empty( $title ) ) {
				$title = false;
			}

			// Count
			$count = 1;
			if ( isset( $instance['count'] ) ) {
				$count = intval( $instance['count'] );
			}

			$agent_featured_properties_args = array(
				'post_type'      => 'property',
				'posts_per_page' => $count,
				'meta_query'     => array(
					array(
						'key'     => 'REAL_HOMES_featured',     // Show only Featured Properties
						'value'   => 1,
						'compare' => '=',
						'type'    => 'NUMERIC',
					),
				),
			);

			// If author user author id otherwise if agent use agent id
			if ( is_author() ) {
				global $wp_query;
				$current_author                           = $wp_query->get_queried_object();
				$agent_featured_properties_args['author'] = $current_author->ID;
			} elseif ( is_singular( 'agent' ) ) {
				$agent_id                                                 = get_the_ID();
				$agent_featured_properties_args['meta_query'][]           = array(
					'key'     => 'REAL_HOMES_agents',
					'value'   => $agent_id,
					'compare' => '=',
				);
				$agent_featured_properties_args['meta_query']['relation'] = 'AND';
			}

			// Order by
			$sort_by = 'recent';
			if ( isset( $instance['sort_by'] ) ) {
				$sort_by = $instance['sort_by'];
			}

			if ( $sort_by == 'random' ) :
				$agent_featured_properties_args['orderby'] = 'rand';
			else :
				$agent_featured_properties_args['orderby'] = 'date';
			endif;

			$agent_featured_properties_query = new WP_Query( apply_filters( 'ere_agent_featured_properties_widget', $agent_featured_properties_args ) );

			if ( is_author() || is_singular( 'agent' ) ) {  // it only works on author page or agent single page

				echo $before_widget;

				if ( $title ) :
					echo $before_title;
					echo $title;
					echo $after_title;
				endif;

				if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {

					if ( $agent_featured_properties_query->have_posts() ) :
						?>
                        <ul class="featured-properties">
							<?php
							while ( $agent_featured_properties_query->have_posts() ) :
								$agent_featured_properties_query->the_post();
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
                                    <p><?php
										ere_framework_excerpt( 7 );
										if ( isset( $view_property ) && ! empty( $view_property ) ) {
											?><a
                                            href="<?php the_permalink(); ?>"><?php echo esc_html( $view_property ); ?></a><?php
										} else {
											?><a
                                            href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'easy-real-estate' ); ?></a><?php
										}
										?></p><?php
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
							esc_html_e( 'No featured property found for this agent.', 'easy-real-estate' );
							echo '</li>';
							?>
                        </ul>
					<?php
					endif;

				} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
					if ( $agent_featured_properties_query->have_posts() ) :
						if ( isset( $instance['card_design'])  && 'default' != $instance['card_design']  ) {
							$property_card_variation = $instance['card_design'];
						}else {
							$inspiry_property_card_variation = get_option( 'inspiry_property_card_variation', '1' );
							$property_card_variation = $inspiry_property_card_variation;
						}

						while ( $agent_featured_properties_query->have_posts() ) :
							$agent_featured_properties_query->the_post();

							ere_get_template_part('includes/widgets/grid-cards/grid-card-'.$property_card_variation);

						?>
                            <!-- /.rh_prop_card -->
						<?php
						endwhile;
						wp_reset_postdata();
					else :
						?>
                        <div class="rh_alert-wrapper rh_alert__widget">
                            <h4 class="no-results"><?php esc_html_e( 'No Featured Property Found For This Agent', 'easy-real-estate' ); ?></h4>
                        </div>
					<?php
					endif;
				}

				echo $after_widget;
			}
		}


		function form( $instance ) {
			// default for modern
			$label_property = esc_html__( 'View Property', 'easy-real-estate' );
			if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
				$label_property = esc_html__( 'Read More', 'easy-real-estate' );
			}
			$instance = wp_parse_args(
				(array) $instance,
				array(
					'title'         => esc_html__( 'Featured Properties', 'easy-real-estate' ),
					'count'         => 1,
					'sort_by'       => 'random',
					'view_property' => $label_property,
					'featured_text' => esc_html__( 'Featured', 'easy-real-estate' ),
				)
			);
			$title         = $instance['title'];
			$count         = $instance['count'];
			$sort_by       = $instance['sort_by'];
			$card_design   = isset( $instance['card_design'] ) ? $instance['card_design'] : 'default';
			$view_property = $instance['view_property'];
			$featured_text = $instance['featured_text'];
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'easy-real-estate' ); ?></label>
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
                <label for="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>"><?php _e( 'Sort By:', 'easy-real-estate' ); ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'sort_by' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>" class="widefat">
                    <option value="recent"<?php selected( $sort_by, 'recent' ); ?>><?php _e( 'Most Recent', 'easy-real-estate' ); ?></option>
                    <option value="random"<?php selected( $sort_by, 'random' ); ?>><?php _e( 'Random', 'easy-real-estate' ); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Number of Properties', 'easy-real-estate' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $count ); ?>" size="3"/>
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
			if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				?>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'featured_text' ) ); ?>"><?php _e( 'Featured Tag Text', 'easy-real-estate' ); ?></label>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'featured_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featured_text' ) ); ?>" type="text" value="<?php echo esc_attr( $featured_text ); ?>"/>
                </p>
				<?php
			}
			?>
			<?php
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']         = sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : '' );
			$instance['view_property'] = sanitize_text_field( isset( $new_instance['view_property'] ) ? $new_instance['view_property'] : '' );
			$instance['featured_text'] = sanitize_text_field( isset( $new_instance['featured_text'] ) ? $new_instance['featured_text'] : '' );
			$instance['sort_by']       = isset( $new_instance['sort_by'] ) ? $new_instance['sort_by'] : '';
			$instance['card_design']   = isset( $new_instance['card_design'] ) ? $new_instance['card_design'] : '';
			$instance['count']         = isset( $new_instance['count'] ) ? $new_instance['count'] : 1;

			return $instance;

		}

	}
}

if ( ! function_exists( 'register_agent_featured_properties_widget' ) ) {
	function register_agent_featured_properties_widget() {
		register_widget( 'Agent_Featured_Properties_Widget' );
	}

	add_action( 'widgets_init', 'register_agent_featured_properties_widget' );
}
