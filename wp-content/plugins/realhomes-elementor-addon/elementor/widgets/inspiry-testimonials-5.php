<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Testimonial_Widget_Five extends \Elementor\Widget_Base {
	public function get_name() {
		return 'inspiry-testimonial-five-widget';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Five', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Testimonials', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_testimonial_section_subtitle',
			[
				'label'       => esc_html__( 'Section Sub Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'rhea_testimonial_section_title',
			[
				'label'       => esc_html__( 'Section Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$testimonials_defaults = array(
			array(
				'rhea_testimonial_author' => esc_html__( 'Author Name' ),
				'rhea_testimonial_text'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.', 'realhomes-elementor-addon' ),
			),
			array(
				'rhea_testimonial_author' => esc_html__( 'Author Name' ),
				'rhea_testimonial_text'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.', 'realhomes-elementor-addon' ),
			),
		);

		$testimonial_repeater = new \Elementor\Repeater();

		$testimonial_repeater->add_control(
			'rhea_testimonial_text',
			[
				'label' => esc_html__( 'Testimonial Text', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			]
		);

		$testimonial_repeater->add_control(
			'rhea_testimonial_author',
			[
				'label'       => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$testimonial_repeater->add_control(
			'rhea_testimonial_author_thumb',
			[
				'label'       => esc_html__( 'Author Thumbnail', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended Image Size 340x315.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'rhea_testimonials',
			[
				'label'       => esc_html__( 'Add Testimonials', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $testimonial_repeater->get_controls(),
				'default'     => $testimonials_defaults,
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
				'name'     => 'testimonial_section_subtitle_typography',
				'label'    => esc_html__( 'Section Sub Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-testimonials-5-widget-section-head-subtitle',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonial_section_title_typography',
				'label'    => esc_html__( 'Section Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-testimonials-5-widget-section-head-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonials_typography',
				'label'    => esc_html__( 'Testimonials Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-testimonials-5-widget p',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'label'    => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-testimonials-5-widget .rhea-testimonials-5-widget-name',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slideAnimation',
			[
				'label'   => esc_html__( 'Animation', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => array(
					'fade'  => esc_html__( 'Fade', 'realhomes-elementor-addon' ),
					'slide' => esc_html__( 'Slide', 'realhomes-elementor-addon' ),
				),
			]
		);

		$this->add_control(
			'animationSpeed',
			[
				'label'   => esc_html__( 'Animation Speed (ms)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 5000,
				'step'    => 100,
				'default' => 1000,
			]
		);

		$this->add_control(
			'loop',
			[
				'label'        => esc_html__( 'Loop', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'autoplaySpeed',
			[
				'label'   => esc_html__( 'Autoplay Speed (ms)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 10000,
				'step'    => 100,
				'default' => 5000,
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'spaces_section',
			[
				'label' => esc_html__( 'Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'testimonials-bg-placeholder',
			[
				'label'           => esc_html__( 'Background Placeholder Column Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-bg-placeholder' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'testimonials-col-gap',
			[
				'label'      => esc_html__( 'Thumbnail Margin', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-left-col' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'testimonials-thumbnail-border-radius',
			[
				'label'      => esc_html__( 'Thumbnail Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-item-inner .rhea-testimonials-5-widget-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_sub_title_margin_bottom',
			[
				'label'           => esc_html__( 'Section Sub Title Bottom Margin', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-section-head-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_title_margin_bottom',
			[
				'label'           => esc_html__( 'Section Title Bottom Margin', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-section-head-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin_bottom',
			[
				'label'           => esc_html__( 'Text Bottom Margin', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-testimonials-5-widget p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_size',
			[
				'label'           => esc_html__( 'Dots Size', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-carousel-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'dots-border-radius',
			[
				'label'      => esc_html__( 'Dots Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-carousel-dots .owl-dot span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'rhea_testimonials_left_col_color',
			[
				'label'     => esc_html__( 'Left Column Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-bg-placeholder' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_section_sub_title_color',
			[
				'label'     => esc_html__( 'Section Sub Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-section-head-subtitle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_section_title_color',
			[
				'label'     => esc_html__( 'Section Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-section-head-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_text_color',
			[
				'label'     => esc_html__( 'Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-5-widget p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_line_color',
			[
				'label'     => esc_html__( 'Line', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-name:before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_author_color',
			[
				'label'     => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_nav_dots_color',
			[
				'label'     => esc_html__( 'Dots', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-carousel-dots .owl-dot span' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_nav_dots_hover_color',
			[
				'label'     => esc_html__( 'Dots Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-5-widget-carousel-dots .owl-dot.active span' => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea-testimonials-5-widget-carousel-dots .owl-dot:hover span' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = $this->get_id();

		$repeater_testimonials = $settings['rhea_testimonials'];
		if ( $repeater_testimonials ) :
			?>
            <div id="rhea-testimonials-5-widget-<?php echo esc_attr( $widget_id ); ?>"
                 class="rhea-testimonials-5-widget">
                <div class="rhea-testimonials-5-widget-bg-placeholder"></div>
                <div class="rhea-testimonials-5-widget-inner-wrapper">
                    <div id="rhea-testimonials-5-widget-carousel-<?php echo esc_attr( $widget_id ); ?>"
                         class="rhea-testimonials-5-widget-carousel owl-carousel owl-theme">
						<?php foreach ( $repeater_testimonials as $testimonial ) :
							if ( empty( $testimonial['rhea_testimonial_text'] ) ) {
								continue;
							}
							?>
                            <div class="rhea-testimonials-5-widget-item">
                                <div class="rhea-testimonials-5-widget-item-inner">
									<?php if ( ! empty( $testimonial['rhea_testimonial_author_thumb'] ) ) : ?>
                                        <div class="rhea-testimonials-5-widget-left-col rhea-testimonials-5-widget-image">
                                            <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'rhea_testimonial_author_thumb' ); ?>
                                        </div><!-- .rhea-testimonials-5-widget-left-col -->
									<?php endif; ?>
                                    <div class="rhea-testimonials-5-widget-right-col">
                                        <div class="rhea-testimonials-5-widget-content">
											<?php
											if ( ! empty( $settings['rhea_testimonial_section_subtitle'] ) || ! empty( $settings['rhea_testimonial_section_title'] ) ) :
												?>
                                                <div class="rhea-testimonials-5-widget-section-head">
													<?php
													if ( ! empty( $settings['rhea_testimonial_section_subtitle'] ) ) :
														?>
                                                        <span class="rhea-testimonials-5-widget-section-head-subtitle">
                                                            <?php echo esc_html( $settings['rhea_testimonial_section_subtitle'] ); ?>
                                                        </span>
													<?php
													endif;

													if ( ! empty( $settings['rhea_testimonial_section_title'] ) ) :
														?>
                                                        <h2 class="rhea-testimonials-5-widget-section-head-title">
															<?php echo esc_html( $settings['rhea_testimonial_section_title'] ); ?>
                                                        </h2>
													<?php
													endif;
													?>
                                                </div>
											<?php
											endif;
											?>
                                            <p><?php echo esc_html( $testimonial['rhea_testimonial_text'] ); ?></p>
											<?php
											if ( ! empty( $testimonial['rhea_testimonial_author'] ) ) :
												?>
                                                <h3 class="rhea-testimonials-5-widget-name"><?php echo esc_html( $testimonial['rhea_testimonial_author'] ); ?></h3>
											<?php
											endif;
											?>
                                        </div><!-- .rhea-testimonials-5-widget-content -->
                                    </div><!-- .rhea-testimonials-5-widget-right-col -->
                                </div><!-- .rhea-testimonials-5-widget-item-inner -->
                            </div>
						<?php endforeach; ?>
                    </div><!-- .rhea-testimonials-5-widget-carousel -->
                    <div id="rhea-testimonials-5-widget-carousel-dots-<?php echo esc_attr( $widget_id ); ?>"
                         class="rhea-testimonials-5-widget-carousel-dots"></div>
                </div><!-- .rhea-testimonials-5-widget-inner-wrapper -->
            </div><!-- .rhea-testimonials-5-widget -->
			<?php
			$testimonials_carousel_options                    = array();
			$testimonials_carousel_options['id']              = '#rhea-testimonials-5-widget-carousel-' . esc_html( $widget_id );
			$testimonials_carousel_options['dots']            = '#rhea-testimonials-5-widget-carousel-dots-' . esc_html( $widget_id );
			$testimonials_carousel_options['slideAnimation']  = $settings['slideAnimation'];
			$testimonials_carousel_options['animationSpeed']  = $settings['animationSpeed'];
			$testimonials_carousel_options['autoplay']        = 'yes' === $settings['autoplay'];
			$testimonials_carousel_options['autoplaySpeed']   = $settings['autoplaySpeed'];
			$testimonials_carousel_options['loop']            = 'yes' === $settings['loop'];;
			?>
            <script type="application/javascript">
                (function ($) {
                    'use strict';
                    $(document).ready(function () {
                        rheaTestimonialsFiveCarousel(<?php echo wp_json_encode( $testimonials_carousel_options ); ?>);
                    });
                })(jQuery);
            </script>
		<?php
		endif;
	}
}