<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Testimonial_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'inspiry-testimonial-widget';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Two', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {


		$this->start_controls_section(
			'settings',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_testimonials_type',
			[
				'label'   => esc_html__( 'Layout Type', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'slider',
				'options' => array(
					'slider' => esc_html__( 'Slider', 'realhomes-elementor-addon' ),
					'grid'   => esc_html__( 'Grid', 'realhomes-elementor-addon' ),
				)
			]
		);

		$this->add_control(
			'show_ratings',
			[
				'label'        => esc_html__( 'Show Rating Stars?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		$this->add_control(
			'show_dots',
			[
				'label'        => esc_html__( 'Show Nav Dots', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		$this->add_control(
			'slides_count_heading',
			[
				'label'     => esc_html__( 'Slides To Show On', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'slides_to_show_fluid',
			[
				'label'   => esc_html__( 'Fluid Width 1440px or Greater', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 6,
				'step'    => 1,
				'default' => 3,
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'slides_to_show',
			[
				'label'   => esc_html__( 'Desktop < 1440px', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 6,
				'step'    => 1,
				'default' => 3,
			]
		);

		$this->add_control(
			'slides_to_show_tab',
			[
				'label'   => esc_html__( 'Tab < 1024px', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 6,
				'step'    => 1,
				'default' => 2,
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'slides_to_show_mobile',
			[
				'label'   => esc_html__( 'Mobile < 767px', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 6,
				'step'    => 1,
				'default' => 1,
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Add Testimonials', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$testimonial_repeater = new \Elementor\Repeater();

		$testimonial_repeater->add_control(
			'rhea_testimonial_author',
			[
				'label' => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$testimonial_repeater->add_control(
			'rhea_testimonial_author_designation',
			[
				'label'       => esc_html__( 'Author Designation', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'For example: Director of Automatic', 'realhomes-elementor-addon' ),

			]
		);

		$testimonial_repeater->add_control(
			'rhea_testimonial_author_thumb',
			[
				'label'   => esc_html__( 'Author thumbnail', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$testimonial_repeater->add_control(
			'rhea_testimonial_text',
			[
				'label' => esc_html__( 'Testimonial Text', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			]
		);

		$testimonial_repeater->add_control(
			'rhea_testimonial_rating',
			[
				'label'   => esc_html__( 'Rating Stars', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'step'    => '',
				'default' => 5,
			]
		);

		$this->add_control(
			'rhea_testimonials',
			[
				'label'       => esc_html__( 'Add Testimonials', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $testimonial_repeater->get_controls(),
				'title_field' => ' {{{ rhea_testimonial_author }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_testimonials_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonials_typography',
				'label'    => esc_html__( 'Testimonials Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_testimonial_2_text p',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'label'    => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_testimonial_2_author .rhea_testimonial_2_name h3',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'designation_typography',
				'label'    => esc_html__( 'Author Designation', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_testimonial_2_author .rhea_testimonial_2_name span',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_spaces',
			[
				'label' => esc_html__( 'Sizes & Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_testimonials_content_padding',
			[
				'label'      => esc_html__( 'Text Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_testimonial_2_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_gap',
			[
				'label'           => esc_html__( 'Space Between Slides', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],

			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Grid Gap', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_testimonials_grid' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_testimonial_2_card' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'rhea_testimonials_type' => 'grid',
				],
			]
		);

		$this->add_responsive_control(
			'grid_items_margin_bottom',
			[
				'label' => esc_html__( 'Grid Items Margin Bottom', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_testimonial_2_card' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'rhea_testimonials_type' => 'grid',
				],
			]
		);

		$this->add_responsive_control(
			'stars_margin_top',
			[
				'label' => esc_html__( 'Rating Stars Margin Top', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rating-stars' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'author_margin_bottom',
			[
				'label' => esc_html__( 'Author Name Margin Bottom', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_testimonial_2_author .rhea_testimonial_2_name h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dota_margin_top',
			[
				'label' => esc_html__( 'Nav Dots Margin Top', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => 30,
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => 30,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);

		$this->add_responsive_control(
			'dota_margin_left_right',
			[
				'label' => esc_html__( 'Space Between Nav Dots ', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .owl-theme .owl-dots .owl-dot span' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);

		$this->add_responsive_control(
			'dots_size_width',
			[
				'label' => esc_html__( 'Nav Dots Width', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => 10,
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .owl-theme .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);
		$this->add_responsive_control(
			'dots_size_height',
			[
				'label' => esc_html__( 'Nav Dots Height', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => 10,
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .owl-theme .owl-dots .owl-dot span' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);

		$this->add_responsive_control(
			'dots_size_border_radius',
			[
				'label' => esc_html__( 'Nav Dots Border Radius', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => 10,
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .owl-theme .owl-dots .owl-dot span' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rhea_testimonials_text_bg',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonial_2_text'       => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_testimonial_2_text:after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_text',
			[
				'label'     => esc_html__( 'Testimonials Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonial_2_text p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_ratings',
			[
				'label'     => esc_html__( 'Rating Stars', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rating-stars i.rated' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rating-stars i'       => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_author',
			[
				'label'     => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonial_2_name h3' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_testimonials_author_designation',
			[
				'label'     => esc_html__( 'Author Designation', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonial_2_name span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_dots_color',
			[
				'label'     => esc_html__( 'Dots Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .owl-theme .owl-dots .owl-dot span' => 'background: {{VALUE}}',
				],
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);
		$this->add_control(
			'rhea_dots_color_hover',
			[
				'label'     => esc_html__( 'Dots Background Hover/Active', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .owl-theme .owl-dots .owl-dot.active span' => 'background: {{VALUE}}',
					'{{WRAPPER}} .owl-theme .owl-dots .owl-dot:hover span'  => 'background: {{VALUE}}',
				],
				'condition' => [
					'rhea_testimonials_type' => 'slider',
				],
			]
		);


		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$repeater_testimonials = $settings['rhea_testimonials'];

		if ( 'slider' == $settings['rhea_testimonials_type'] ) {
			$rhea_classes = 'owl-carousel owl-theme';
		} else {
			$rhea_classes = 'rhea_testimonials_grid';

		}

		if ( $repeater_testimonials ) {
			?>
            <div class="rhea_testimonial_2_wrapper">
                <div id="rhea_testimonials_<?php echo esc_attr( $this->get_id() ); ?>"
                     class="rhea_testimonials_slider <?php echo esc_attr( $rhea_classes ); ?>">
					<?php foreach ( $repeater_testimonials as $testimonial ) { ?>
                        <div <?php if ( 'grid' == $settings['rhea_testimonials_type'] ) { ?>
                                style="max-width: <?php echo (100/$settings['slides_to_show']).'%'; ?>"
                                <?php } ?>
                                class="rhea_testimonial_2_card">
							<?php
							if ( ! empty( $testimonial['rhea_testimonial_text'] ) ) {
								?>

                                <div class="rhea_testimonial_2_text">
                                    <p>
										<?php echo esc_html( $testimonial['rhea_testimonial_text'] ); ?>
                                    </p>


									<?php
									if ( 'yes' == $settings['show_ratings'] && ! empty( $testimonial['rhea_testimonial_rating'] ) ) {
										echo rhea_rating_stars( $testimonial['rhea_testimonial_rating'] );
									}
									?>

                                </div>

                                <div class="rhea_testimonial_2_author">
									<?php
									if ( ! empty( $testimonial['rhea_testimonial_author_thumb']['id'] ) ) {
										?>
                                        <div class="rhea_testimonial_2_thumb">
											<?php echo wp_get_attachment_image( $testimonial['rhea_testimonial_author_thumb']['id'], 'small' ); ?>
                                        </div>
										<?php
									}
									?>
                                    <div class="rhea_testimonial_2_name">
										<?php
										if ( ! empty( $testimonial['rhea_testimonial_author'] ) ) {
											?>
                                            <h3><?php echo esc_html( $testimonial['rhea_testimonial_author'] ); ?></h3>
											<?php
										}
										if ( ! empty( $testimonial['rhea_testimonial_author_designation'] ) ) {
											?>
                                            <span><?php echo esc_html( $testimonial['rhea_testimonial_author_designation'] ) ?></span>
											<?php
										}
										?>
                                    </div>
                                </div>

								<?php
							}
							?>
                        </div>
						<?php
					}
					?>
                </div>
            </div>

			<?php


				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					if ( 'slider' == $settings['rhea_testimonials_type'] ) {
						?>
                        <script type="application/javascript">
                                rheaTestimonialsTwoCarousel(
                                    '#rhea_testimonials_<?php echo esc_attr( $this->get_id() ); ?>',
									<?php echo esc_html( $settings['slides_to_show_fluid'] )?>,
									<?php echo esc_html( $settings['slides_to_show'] )?>,
									<?php echo esc_html( $settings['slides_to_show_tab'] )?>,
									<?php echo esc_html( $settings['slides_to_show_mobile'] )?>,
	                                <?php echo ! empty( $settings['slider_gap']['size'] ) ? esc_html( $settings['slider_gap']['size'] ) : 30 ?>,
									<?php if ( 'yes' == $settings['show_dots'] ) {
										echo 'true';
									} else {
										echo 'false';
									}?>,
									<?php
									$classes = get_body_class();
									if ( in_array( 'rtl', $classes ) ) {
										echo 'true';
									} else {
										echo 'false';
									}

									?>

                                )
                        </script>
						<?php
					}
				} else {
					if ( 'slider' == $settings['rhea_testimonials_type'] ) {
					?>
                    <script type="application/javascript">
                        jQuery(document).on('ready', function () {
                            rheaTestimonialsTwoCarousel(
                                '#rhea_testimonials_<?php echo esc_attr( $this->get_id() ); ?>',
								<?php echo esc_html( $settings['slides_to_show_fluid'] )?>,
								<?php echo esc_html( $settings['slides_to_show'] )?>,
								<?php echo esc_html( $settings['slides_to_show_tab'] )?>,
								<?php echo esc_html( $settings['slides_to_show_mobile'] )?>,
	                            <?php echo ! empty( $settings['slider_gap']['size'] ) ? esc_html( $settings['slider_gap']['size'] ) : 30 ?>,
								<?php if ( 'yes' == $settings['show_dots'] ) {
									echo 'true';
								} else {
									echo 'false';
								}?>,
								<?php
								$classes = get_body_class();
								if ( in_array( 'rtl', $classes ) ) {
									echo 'true';
								} else {
									echo 'false';
								}

								?>

                            )
                        });
                    </script>
					<?php
				}
			}
		}
	}

}