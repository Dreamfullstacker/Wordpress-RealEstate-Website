<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Testimonial_Widget_Four extends \Elementor\Widget_Base {
	public function get_name() {
		return 'inspiry-testimonial-four-widget';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Four', 'realhomes-elementor-addon' );
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
				'label'       => esc_html__( 'Author Thumbnail', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended Image Size 150x150 (small thumbnail)', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => [
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
				'selector' => '{{WRAPPER}} .rhea_testimonials_4_widget p',
			]
		);

		$this->add_responsive_control(
			'rhea_text_margin_bottom',
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
					'{{WRAPPER}} .rhea_testimonials_4_widget p' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'label'    => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_testimonials_4_widget .rhea_testimonials_4_widget_name',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'designation_typography',
				'label'    => esc_html__( 'Author Designation', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_testimonials_4_widget .rhea_testimonials_4_widget_job',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'settings',
			[
				'label' => esc_html__( 'Slider Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_quotation_mark',
			[
				'label'     => esc_html__( 'Show Quotation Mark?', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Show', 'realhomes-elementor-addon' ),
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
			'reverse_direction',
			[
				'label'     => esc_html__( 'Reverse Direction ?', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'auto_slide',
			[
				'label'   => esc_html__( 'Slide Show ?', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'slideshow_speed',
			[
				'label'   => esc_html__( 'Slide Show Speed (ms)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 10000,
				'step'    => 100,
				'default' => 5000,
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
				'label'     => esc_html__( 'Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_author_color',
			[
				'label'     => esc_html__( 'Author', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget .rhea_testimonials_4_widget_name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_author_designation_color',
			[
				'label'     => esc_html__( 'Designation', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget .rhea_testimonials_4_widget_job' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_quote_icon',
			[
				'label'     => esc_html__( 'Quote Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget_quotation_mark svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_nav_button',
			[
				'label'     => esc_html__( 'Navigation Button', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget_navigation a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_nav_button_hover',
			[
				'label'     => esc_html__( 'Navigation Button Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget_navigation a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_nav_icon',
			[
				'label'     => esc_html__( 'Navigation Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget_navigation a svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_nav_icon_hover',
			[
				'label'     => esc_html__( 'Navigation Icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget_navigation a:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_testimonials_4_widget_bg',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_testimonials_4_widget_flexslider' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rhea_testimonials_4_widget_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .rhea_testimonials_4_widget_flexslider',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$repeater_testimonials = $settings['rhea_testimonials'];

		if ( $repeater_testimonials ) {
			?>
                <div class="rhea_testimonials_4_widget">

					<?php if ( 'yes' == $settings['show_quotation_mark'] ) : ?>
                        <div class="rhea_testimonials_4_widget_quotation_mark"><?php include RHEA_ASSETS_DIR . '/icons/quotes-3.svg'; ?></div>
					<?php endif; ?>

                    <div id="rhea_testimonials_4_widget_<?php echo esc_attr( $this->get_id() ); ?>" class="rhea_testimonials_4_widget_flexslider flexslider">
                        <ul class="slides">
							<?php
							foreach ( $repeater_testimonials as $testimonial ) {
								?>
                                <li class="rhea_testimonials_4_widget_slide">

                                    <p><?php echo esc_html( $testimonial['rhea_testimonial_text'] ); ?></p>

                                    <div class="rhea_testimonials_4_widget_meta">

	                                    <?php
	                                    if ( ! empty( $testimonial['rhea_testimonial_author_thumb'] ) ) : ?>
                                            <div class="rhea_testimonials_4_widget_image">
                                                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $testimonial, 'rhea_testimonial_author_thumb' ); ?>
                                            </div>
	                                    <?php
	                                    endif;

	                                    if ( ! empty( $testimonial['rhea_testimonial_author'] ) || ! empty( $testimonial['rhea_testimonial_author_designation'] ) ) : ?>
                                            <div class="rhea_testimonials_4_widget_details">
			                                    <?php
			                                    if ( ! empty( $testimonial['rhea_testimonial_author'] ) ) : ?>
                                                    <h3 class="rhea_testimonials_4_widget_name"><?php echo esc_html( $testimonial['rhea_testimonial_author'] ); ?></h3><?php
			                                    endif;

			                                    if ( ! empty( $testimonial['rhea_testimonial_author_designation'] ) ) : ?>
                                                    <span class="rhea_testimonials_4_widget_job"><?php echo esc_html( $testimonial['rhea_testimonial_author_designation'] ); ?></span><?php
			                                    endif;
			                                    ?>
                                            </div>
	                                    <?php
	                                    endif;
	                                    ?>
                                    </div>
                                </li>
							<?php } ?>
                        </ul>
                    </div>

                    <div id="rhea_testimonials_4_widget_navigation_<?php echo esc_attr( $this->get_id() ); ?>" class="rhea_testimonials_4_widget_navigation">
                        <a href="prev"><?php include RHEA_ASSETS_DIR . '/icons/icon-left.svg'; ?></a>
                        <a href="next"><?php include RHEA_ASSETS_DIR . '/icons/icon-right.svg'; ?></a>
                    </div>
                </div>

			<?php
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				?>
                <script type="application/javascript">
                    rheaTestimonialsFourCarousel(
                        '#rhea_testimonials_4_widget_<?php echo esc_attr( $this->get_id() ); ?>',
                        '#rhea_testimonials_4_widget_navigation_<?php echo esc_attr( $this->get_id() ); ?> a',
                        '<?php echo $settings['slide_animation']?>',
                        '<?php echo $settings['animation_speed']?>',
                        '<?php echo 'yes' == $settings['reverse_direction'] ? false : true ?>',
                        '<?php echo 'yes' == $settings['auto_slide'] ? true : false ?>',
                        '<?php echo $settings['slideshow_speed']?>',
                    );

                    jQuery(document).ready( function () {
                        rheaTestimonialsFourCarousel(
                            '#rhea_testimonials_4_widget_<?php echo esc_attr( $this->get_id() ); ?>',
                            '#rhea_testimonials_4_widget_navigation_<?php echo esc_attr( $this->get_id() ); ?> a',
                            '<?php echo $settings['slide_animation']?>',
                            '<?php echo $settings['animation_speed']?>',
                            '<?php echo 'yes' == $settings['reverse_direction'] ? false : true ?>',
                            '<?php echo 'yes' == $settings['auto_slide'] ? true : false ?>',
                            '<?php echo $settings['slideshow_speed']?>',
                        );
                    });
                </script>
				<?php
			} else {
				?>
                <script type="application/javascript">
                    jQuery(document).ready( function () {
                        rheaTestimonialsFourCarousel(
                            '#rhea_testimonials_4_widget_<?php echo esc_attr( $this->get_id() ); ?>',
                            '#rhea_testimonials_4_widget_navigation_<?php echo esc_attr( $this->get_id() ); ?> a',
                            '<?php echo $settings['slide_animation']?>',
                            '<?php echo $settings['animation_speed']?>',
                            '<?php echo 'yes' == $settings['reverse_direction'] ? false : true ?>',
                            '<?php echo 'yes' == $settings['auto_slide'] ? true : false ?>',
                            '<?php echo $settings['slideshow_speed']?>',
                        );
                    });
                </script>
				<?php
			}
		}
	}
}