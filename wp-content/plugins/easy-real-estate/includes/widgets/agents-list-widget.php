<?php
/**
 * Widget: Agents List
 *
 * @package easy_real_estate
 * @since 3.7.0
 */


if ( ! class_exists( 'Agents_List_Widget' ) ) {

	/**
	 * Class: Widget class for Agents List
	 */
	class Agents_List_Widget extends WP_Widget {

		/**
		 * Method: Constructor
		 */
		function __construct() {
			$widget_ops = array(
				'classname'                   => 'agents_list_widget',
				'description'                 => esc_html__( 'This widget displays agents list.', 'easy-real-estate' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'Agents_List_Widget', esc_html__( 'RealHomes - Agents', 'easy-real-estate' ), $widget_ops );
		}

		/**
		 * Method: Widget's Display
		 */
		function widget( $args, $instance ) {

			$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Agents', 'easy-real-estate' );

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			$agent_args = array(
				'post_type'      => 'agent',
				'posts_per_page' => ! empty( $instance['count'] ) ? intval( $instance['count'] ) : 3
			);

			$agents_query = new WP_Query( apply_filters( 'ere_agents_widget', $agent_args ) );

			echo $args['before_widget'];

			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( $agents_query->have_posts() ) : ?>
                <div class="agents-list-widget">
					<?php
					while ( $agents_query->have_posts() ) : $agents_query->the_post(); ?>
                        <article class="agent-list-item clearfix">
							<?php if ( has_post_thumbnail() ) : ?>
                                <figure class="agent-thumbnail">
                                    <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'agent-image' ); ?>
                                    </a>
                                </figure>
							<?php endif; ?>
                            <div class="agent-widget-content <?php echo has_post_thumbnail() ? '' : esc_attr('no-agent-thumbnail'); ?>">
                                <h4 class="agent-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
								<?php
								$agent_contact_number = null;
								$agent_email          = get_post_meta( get_the_ID(), 'REAL_HOMES_agent_email', true );
								$agent_mobile_number  = get_post_meta( get_the_ID(), 'REAL_HOMES_mobile_number', true );
								$agent_office_number  = get_post_meta( get_the_ID(), 'REAL_HOMES_office_number', true );

								if ( ! empty( $agent_mobile_number ) ) {
									$agent_contact_number = $agent_mobile_number;
								} elseif ( ! empty( $agent_office_number ) ) {
									$agent_contact_number = $agent_office_number;
								}

								if ( is_email( $agent_email ) ) {
									if ( 'ultra' === INSPIRY_DESIGN_VARIATION ) {
										?>
                                        <div class="rh-widget-agent-contact-item">
                                        <?php
                                        ere_safe_include_svg( '/images/icons/ultra/email.svg' );
                                        ?>
                                        <a class="agent-contact-email"
                                           href="mailto:<?php echo antispambot( $agent_email ); ?>"><?php echo antispambot( $agent_email ); ?></a>
                                        </div>
										<?php
									}else{
									?>
                                    <a class="agent-contact-email"
                                       href="mailto:<?php echo antispambot( $agent_email ); ?>"><?php echo antispambot( $agent_email ); ?></a>
									<?php
									}
								}

								if ( ! empty( $agent_contact_number ) ) {
									if ( 'ultra' === INSPIRY_DESIGN_VARIATION ) {
										?>
                                <div class="rh-widget-agent-contact-item">
                                        <?php
                                        ere_safe_include_svg( '/images/icons/ultra/phone.svg' );
                                        ?>
                                    <a href="tel://<?php echo esc_url( $agent_contact_number ); ?>"><?php echo esc_html( $agent_contact_number ); ?></a>
                                </div>
										<?php
									}else{
									?>
                                    <div class="agent-contact-number">
                                        <a href="tel://<?php echo esc_url( $agent_contact_number ); ?>"><?php echo esc_html( $agent_contact_number ); ?></a>
                                    </div>
									<?php
                                    }
								}
								?>
                            </div>
                        </article>
					<?php endwhile; ?>
                </div>
				<?php
				wp_reset_postdata();
			else :
				?>
                <div class="agents-list-widget">
                    <article class="agent-list-item">
					    <?php echo '<h4>' . esc_html__( 'No Agent Found!', 'easy-real-estate' ) .'</h4>'; ?>
                    </article>
                </div>
				<?php
			endif;

			echo $args['after_widget'];
		}

		/**
		 * Method: Update Widget Options
		 */
		function form( $instance ) {
			$instance = wp_parse_args(
				(array) $instance, array(
					'title' => esc_html__('Agents', 'easy-real-estate' ),
					'count' => 3
				)
			);

			$title = sanitize_text_field( $instance['title'] );
			$count = $instance['count'];
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'easy-real-estate' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $title ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of Agents', 'easy-real-estate' ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $count ); ?>" size="3"/>
            </p>
			<?php
		}

		/**
		 * Method: Update Widget Options
		 */
		function update( $new_instance, $old_instance ) {
			$instance          = $old_instance;
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
			$instance['count'] = $new_instance['count'];

			return $instance;
		}
	}
}

if ( ! function_exists( 'register_agents_list_widget' ) ) {
	function register_agents_list_widget() {
		register_widget( 'Agents_List_Widget' );
	}

	add_action( 'widgets_init', 'register_agents_list_widget' );
}