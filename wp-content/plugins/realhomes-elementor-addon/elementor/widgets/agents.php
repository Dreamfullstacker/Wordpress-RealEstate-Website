<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agents_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-agents-widget';
	}

	public function get_title() {
		return esc_html__( 'Agents Grid', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {


		$this->start_controls_section(
			'ere_agents_section',
			[
				'label' => esc_html__( 'Agents', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_agent_variations',
			array(
				'label'   => esc_html__( 'Designs', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'default' => array(
						'title' => esc_html__( 'Default', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-gallery-grid',
					),
					'style-two' => array(
						'title' => esc_html__( 'Style Two', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-column',
					),
				),
				'default' => 'default',
				'toggle'  => false,
			)
		);

		$this->add_responsive_control(
			'ere_property_grid_layout',
			[
				'label'       => __( 'Layout', 'realhomes-elementor-addon' ),
				'description' => __( 'Number of columns will be reduced automatically if parent container has insufficient width.', 'realhomes-elementor-addon' ) . '<br>' .
				                 __( '* Make sure "Style -> Agent Width" field is empty.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => '25%',
				'options'     => array(
					'25%'     => esc_html__( '4 Columns', 'realhomes-elementor-addon' ),
					'33.333%' => esc_html__( '3 Columns', 'realhomes-elementor-addon' ),
					'50%'     => esc_html__( '2 Columns', 'realhomes-elementor-addon' ),
					'100%'    => esc_html__( '1 Column', 'realhomes-elementor-addon' ),
				),
				'selectors'   => [
					'{{WRAPPER}} .rh_agent_elementor' => 'width: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'number_of_agents',
			[
				'label'   => esc_html__( 'Number of Agents', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
				'default' => 4,
			]
		);


		$this->add_control(
			'properties_count',
			[
				'label'        => esc_html__( 'Properties Count', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => __( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'display_arrow',
			[
				'label'        => esc_html__( 'Animation Arrow on Hover', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => __( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_agents_section_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_agent_elementor .rh_agent__details h3 a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_number_typography',
				'label'    => esc_html__( 'Number', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__phone a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_email_typography',
				'label'    => esc_html__( 'Email', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__email',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_figure_typography',
				'label'    => esc_html__( 'Listed Figure', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__listed .figure',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_label_typography',
				'label'    => esc_html__( 'Listed Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__listed .heading',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'ere_agent_styles_sizes',
			[
				'label' => esc_html__( 'Size And Position', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_agent_width',
			[
				'label'           => esc_html__( 'Agent Width (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'This will over-ride the width of "Content -> Layout"', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_agent_elementor' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_thumb_position',
			[
				'label'           => esc_html__( 'Thumbnail Vertical Position (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 160,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__thumbnail' => 'margin-top: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_agent'                                => 'padding-top: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'ere_agents_spacing_section',
			[
				'label' => esc_html__( 'Spacings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_agent_card_padding',
			[
				'label'      => esc_html__( 'Agent Card Inner Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rh_agent__wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_agent_vertical_spacings',
			[
				'label'           => esc_html__( 'Vertical Space between Agents (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__agents_elementor .rh_agent_elementor' => 'padding-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_title_spacings_top',
			[
				'label'           => esc_html__( 'Agent Title Margin Top (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_agent__details h3' => 'margin-top: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_title_spacings_bottom',
			[
				'label'           => esc_html__( 'Agent Title Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_agent__details h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_number_spacings',
			[
				'label'           => esc_html__( 'Agent Phone Number Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_agent__phone' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_email_spacings',
			[
				'label'           => esc_html__( 'Agent Email Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_agent__email' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_figure_spacings',
			[
				'label'           => esc_html__( 'Listed Figure Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_agent__listed .figure' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_listed_properties_spacings',
			[
				'label'           => esc_html__( 'Listed Properties Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_agent__listed .heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'ere_agent_styles',
			[
				'label' => esc_html__( 'Agent Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'ere_agent_bg_color',
			[
				'label'     => esc_html__( 'Agent Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__wrap' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_agent_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__details h3 a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_title_hvoer_color',
			[
				'label'     => esc_html__( 'Title Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__details h3 a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_phone_color',
			[
				'label'     => esc_html__( 'Phone', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__phone a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_agent_phone_hover_color',
			[
				'label'     => esc_html__( 'Phone Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__phone a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_email_color',
			[
				'label'     => esc_html__( 'Email', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__email' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_figure_color',
			[
				'label'     => esc_html__( 'Listed Figure', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__listed .figure' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_listed_figure_color',
			[
				'label'     => esc_html__( 'Listed Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__details .rh_agent__listed .heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_arrow_circle',
			[
				'label'     => esc_html__( 'Arrow Circle Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__arrow .cls-1' => 'fill: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'ere_agent_arrow',
			[
				'label'     => esc_html__( 'Arrow Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_agent_elementor .rh_agent__arrow .cls-2' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_agent_box_shadow',
			[
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rh_section__agents_elementor .rh_agent_elementor .rh_agent__wrap',
			]
		);


		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

//		$agent_thumb_size = ;


		// Number of agents
		if ( ! $settings['number_of_agents'] ) {
			$settings['number_of_agents'] = 4;
		}

		$agents_args = array(
			'post_type'      => 'agent',
			'posts_per_page' => $settings['number_of_agents'],
		);

		$agents_query = new WP_Query( apply_filters( 'rhea_modern_agents_widget', $agents_args ) );

		if ( $agents_query->have_posts() ) {
			?>
            <div class="rh_elementor_widget rh_wrapper__agents_elementor <?php echo esc_attr( $settings['rhea_agent_variations'] ); ?>">

                <div class="rh_section__agents_elementor">
					<?php
					while ( $agents_query->have_posts() ) {

						$agents_query->the_post();

						$agent_mobile      = get_post_meta( get_the_ID(), 'REAL_HOMES_mobile_number', true );
						$agent_email       = get_post_meta( get_the_ID(), 'REAL_HOMES_agent_email', true );
						$listed_properties = ere_get_agent_properties_count( get_the_ID() );

						?>
                        <article <?php post_class( 'rh_agent_elementor' ); ?>>
                            <div class="rh_agent__wrap">
                                <div class="rh_agent__thumbnail">
                                    <a href="<?php the_permalink(); ?>">
										<?php
										if ( has_post_thumbnail() ) {
											if ( ! empty( $settings['ere_agent_thumb_sizes_select'] ) ) {
												the_post_thumbnail( $settings['ere_agent_thumb_sizes_select'] );
											} else {
												the_post_thumbnail( 'agent-image' );
											}
										}
										?>
                                    </a>
                                </div>

                                <div class="rh_agent__details">

                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<?php if ( ! empty( $agent_mobile ) ) { ?>
                                        <p class="rh_agent__phone"><a
                                                    href="tel:<?php echo esc_html( $agent_mobile ); ?>"><?php echo esc_html( $agent_mobile ); ?></a>
                                        </p>
									<?php } ?>

									<?php if ( ! empty( $agent_email ) ) { ?>
                                        <a href="mailto:<?php echo esc_attr( antispambot( $agent_email ) ); ?>"
                                           class="rh_agent__email">
											<?php echo esc_html( antispambot( $agent_email ) ); ?>
                                        </a>
									<?php } ?>

									<?php if ( $settings['properties_count'] === 'yes' ) { ?>
                                        <div class="rh_agent__listed">
                                            <p class="figure"><?php echo ( ! empty( $listed_properties ) ) ? esc_html( $listed_properties ) : 0; ?></p>
                                            <p class="heading"><?php echo ( 1 === $listed_properties ) ? esc_html__( 'Listed Property', 'realhomes-elementor-addon' ) : esc_html__( 'Listed Properties', 'realhomes-elementor-addon' ); ?></p>
                                        </div>
									<?php
									}
									if('yes' == $settings['display_arrow']){
									?>

                                    <span class="rh_agent__arrow">
											<a href="<?php the_permalink(); ?>"><?php include( RHEA_ASSETS_DIR . '/icons/arrow-right.svg' ); ?></a>
										</span>
										<?php
									}
									?>
                                </div>
                            </div>
                        </article>
						<?php
					}
					wp_reset_postdata();
					?>
                </div>


            </div>
			<?php
		}

	}

}