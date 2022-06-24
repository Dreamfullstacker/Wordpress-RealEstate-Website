<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Testimonial_Widget_Three extends \Elementor\Widget_Base {
	public function get_name() {
		return 'inspiry-testimonial-three-widget';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Three', 'realhomes-elementor-addon' );
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
			'animation_speed',
			[
				'label'   => esc_html__( 'Animation Speed (ms)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 5000,
				'step'    => 100,
				'default' => 600,
			]
		);

		$this->add_control(
			'auto_slide',
			[
				'label'   => esc_html__( 'Slide Auto Show ?', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => array(
					'false' => esc_html__( 'No', 'realhomes-elementor-addon' ),
					'true'  => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				)
			]
		);

		$this->add_control(
			'slideshow_speed',
			[
				'label'     => esc_html__( 'Slide Show Speed (ms)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 10000,
				'step'      => 100,
				'default'   => 5000,
			]
		);


		$this->add_control(
			'slides_thumb_settings',
			[
				'label'     => esc_html__( 'Thumbnail Slider Settings', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_thumbnail_slider',
			[
				'label'        => esc_html__( 'Show Thumbnail Slider?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'slide_animation',
			[
				'label'     => esc_html__( 'Slide Animation', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => array(
					'fade'  => esc_html__( 'Fade', 'realhomes-elementor-addon' ),
					'slide' => esc_html__( 'Slide', 'realhomes-elementor-addon' ),
				),
				'condition' => [
					'show_thumbnail_slider' => 'yes',
				],
			]
		);


		$this->add_control(
			'reverse_direction',
			[
				'label'     => esc_html__( 'Reverse Direction ?', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'false',
				'options'   => array(
					'false' => esc_html__( 'No', 'realhomes-elementor-addon' ),
					'true'  => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				),
				'condition' => [
					'show_thumbnail_slider' => 'yes',
				],
			]
		);


		$this->add_control(
			'slides_text_settings',
			[
				'label'     => esc_html__( 'Text Slider Settings', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'slide_animation_text',
			[
				'label'   => esc_html__( 'Slide Animation', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => array(
					'fade'  => esc_html__( 'Fade', 'realhomes-elementor-addon' ),
					'slide' => esc_html__( 'Slide', 'realhomes-elementor-addon' ),
				)
			]
		);

		$this->add_control(
			'reverse_direction_text',
			[
				'label'   => esc_html__( 'Reverse Direction ?', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'false',
				'options' => array(
					'false' => esc_html__( 'No', 'realhomes-elementor-addon' ),
					'true'  => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				)
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
				'description'   => esc_html__( 'Recommended Image Size 150x150 (small thumbnail)', 'realhomes-elementor-addon' ),
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
				'name'     => 'testimonials_typography',
				'label'    => esc_html__( 'Testimonials Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_testimonials_text_3_box p',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'label'    => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_testimonials_text_3_box .rhea_testimonial_3_name h3',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'designation_typography',
				'label'    => esc_html__( 'Author Designation', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_testimonials_text_3_box .rhea_testimonial_3_name span',
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
			'rhea_text_margin_bottom',
			[
				'label'           => esc_html__( 'Text Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],

				'selectors'       => [
					'{{WRAPPER}} .rhea_testimonials_text_3_box p' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_author_margin_bottom',
			[
				'label'           => esc_html__( 'Author Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_testimonials_text_3_box .rhea_testimonial_3_name h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_nav_position',
			[
				'label'           => esc_html__( 'Navigation Buttons Horizontal Position (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-testimonials-navigation .rhea_flex_prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-testimonials-navigation .rhea_flex_next' => 'right: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_nav_vertical_position',
			[
				'label'           => esc_html__( 'Navigation Buttons Vertical Position (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%','px' ],
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-testimonials-navigation a' => 'top: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'thumb-border-radius',
			[
				'label'      => esc_html__( 'Thumb Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_icon_frame' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rhea_thumb_frame' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'rhea_testimonials_text_color',
			[
				'label'     => esc_html__( 'Testimonials Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_text_3_box p' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'rhea_testimonials_author_color',
			[
				'label'     => esc_html__( 'Testimonials Author', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_text_3_box .rhea_testimonial_3_name h3' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'rhea_testimonials_author_designation_color',
			[
				'label'     => esc_html__( 'Author Designation', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_text_3_box .rhea_testimonial_3_name span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_quote_box',
			[
				'label'     => esc_html__( 'Quote Box Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_thumb_3_box .rhea_icon_frame' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_quote_icon',
			[
				'label'     => esc_html__( 'Quote Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_quote_icon_box svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_nav_icon',
			[
				'label'     => esc_html__( 'Directional Nav Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-navigation a svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_nav_icon_hover',
			[
				'label'     => esc_html__( 'Directional Nav Icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-testimonials-navigation a:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$repeater_testimonials = $settings['rhea_testimonials'];

		if ( $repeater_testimonials ) {
			?>

            <div class="rhea_testimonials_three_wrapper">
                <div class="rhea_testimonials_three">

					<?php
					if ( 'yes' == $settings['show_thumbnail_slider'] ) {
						?>
                        <div class="rhea_testimonials_thumb_3_box">
                            <div class="rhea_icon_frame">
                            </div>
                            <div class="rhea_quote_icon_box">
								<?php include RHEA_ASSETS_DIR . '/icons/quotes-3.svg'; ?>
                            </div>
                            <div id="rhea_1_<?php echo esc_attr( $this->get_id() ); ?>"
                                 class="rhea_testimonials_thumb_3 flexslider">
                                <ul class="slides">
									<?php
									foreach ( $repeater_testimonials as $testimonial ) {

										?>
                                        <li class="rhea_testimonial_3_thumb">
                                            <div class="rhea_thumb_frame" style='background-image: url(" <?php
											if ( ! empty( $testimonial['rhea_testimonial_author_thumb']['id'] ) ) {
												echo wp_get_attachment_image_url( $testimonial['rhea_testimonial_author_thumb']['id'], 'small' );
											} else {
												echo inspiry_get_raw_placeholder_url( 'thumbnail' );
											}
											?>")'>
                                            </div>
                                        </li>
									<?php } ?>
                                </ul>
                            </div>
                        </div>
					<?php } ?>
                    <div class="rhea_testimonials_text_3_box">
                        <div id="rhea_2_<?php echo esc_attr( $this->get_id() ); ?>"
                             class="rhea_testimonials_text_3 flexslider">
                            <ul class="slides">
								<?php
								foreach ( $repeater_testimonials as $testimonial ) {
									?>
                                    <li class="rhea_testimonials_text_slide">
                                        <p>
											<?php echo esc_html( $testimonial['rhea_testimonial_text'] ); ?>
                                        </p>

                                        <div class="rhea_testimonial_3_name">
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
                                    </li>
								<?php } ?>
                            </ul>
                        </div>
                    </div>
					<?php
					?>

                    <div class="rhea-testimonials-navigation rhea_nav_<?php echo esc_attr( $this->get_id() ); ?>">
                        <a href="#"
                           class="rhea_flex_prev flex-prev"><?php include RHEA_ASSETS_DIR . '/icons/icon-left.svg'; ?></a>
                        <a href="#"
                           class="rhea_flex_next flex-next"><?php include RHEA_ASSETS_DIR . '/icons/icon-right.svg'; ?></a>
                    </div>

                </div>
            </div>

			<?php

			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {

				?>
                <script type="application/javascript">
                    rheaTestimonialsThreeCarousel(
                        '#rhea_1_<?php echo esc_attr( $this->get_id() ); ?>',
                        '#rhea_2_<?php echo esc_attr( $this->get_id() ); ?>',
                        '.rhea_nav_<?php echo esc_attr( $this->get_id() ); ?> a',
                        '<?php echo $settings['animation_speed']?>',
                        '<?php echo $settings['slideshow_speed']?>',
                        '<?php echo 'true' == $settings['auto_slide'] ? true : false ?>',
                        'horizontal',
                        '<?php echo $settings['slide_animation']?>',
                        '<?php echo 'true' == $settings['reverse_direction'] ? true : false ?>',
                        '<?php echo $settings['slide_animation_text']?>',
                        '<?php echo 'true' == $settings['reverse_direction_text'] ? true : false ?>',
                    );

                    jQuery(document).on('ready', function () {
                        rheaTestimonialsThreeCarousel(
                            '#rhea_1_<?php echo esc_attr( $this->get_id() ); ?>',
                            '#rhea_2_<?php echo esc_attr( $this->get_id() ); ?>',
                            '.rhea_nav_<?php echo esc_attr( $this->get_id() ); ?> a',
                            '<?php echo $settings['animation_speed']?>',
                            '<?php echo $settings['slideshow_speed']?>',
                            '<?php echo 'true' == $settings['auto_slide'] ? true : false ?>',
                            'horizontal',
                            '<?php echo $settings['slide_animation']?>',
                            '<?php echo 'true' == $settings['reverse_direction'] ? true : false ?>',
                            '<?php echo $settings['slide_animation_text']?>',
                            '<?php echo 'true' == $settings['reverse_direction_text'] ? true : false ?>',
                        );

                    });

                </script>
				<?php

			} else {
				?>
                <script type="application/javascript">
                    jQuery(document).on('ready', function () {
                        rheaTestimonialsThreeCarousel(
                            '#rhea_1_<?php echo esc_attr( $this->get_id() ); ?>',
                            '#rhea_2_<?php echo esc_attr( $this->get_id() ); ?>',
                            '.rhea_nav_<?php echo esc_attr( $this->get_id() ); ?> a',
                            '<?php echo $settings['animation_speed']?>',
                            '<?php echo $settings['slideshow_speed']?>',
                            '<?php echo 'true' == $settings['auto_slide'] ? true : false ?>',
                            'horizontal',
                            '<?php echo $settings['slide_animation']?>',
                            '<?php echo 'true' == $settings['reverse_direction'] ? true : false ?>',
                            '<?php echo $settings['slide_animation_text']?>',
                            '<?php echo 'true' == $settings['reverse_direction_text'] ? true : false ?>',
                        );

                    });
                </script>
				<?php
			}

		}

	}

}