<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_CTA_Two_Widget extends \Elementor\Widget_Base {
    
	public function get_name() {
		return 'ere-cta-two-widget';
	}

	public function get_title() {
		return esc_html__( 'Call to Action 2', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Call to Action', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'cta_top_title',
			[
				'label'   => esc_html__( 'Top Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Looking for More?', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'cta_main_title',
			[
				'label'   => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 10,
				'default' => esc_html__( 'Talk to our experts or Browse through more properties.', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'cta_first_btn_title',
			[
				'label'   => esc_html__( 'First Button Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Get In Touch', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'cta_first_btn_url',
			[
				'label'         => esc_html__( 'First Button URL', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'show_external' => true,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cta_second_btn_title',
			[
				'label'   => esc_html__( 'Second Button Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Browse Properties', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'cta_second_btn_url',
			[
				'label'         => esc_html__( 'Second Button URL', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => '',
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);


		$this->add_control(
			'ere_show_bg_image',
			[
				'label'        => esc_html__( 'Enable Background Image', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'cta_1_image',
			[
				'label'     => esc_html__( 'Background Image', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'ere_show_bg_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'ere_cta_1_image_bg_size',
			[
				'label'   => esc_html__( 'Background Size', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'auto',
				'condition' => [
					'ere_show_bg_image' => 'yes',
				],
				'options' => array(
					'cover'   => esc_html__( 'Cover', 'realhomes-elementor-addon' ),
					'contain' => esc_html__( 'Contain', 'realhomes-elementor-addon' ),
					'auto'    => esc_html__( 'Auto', 'realhomes-elementor-addon' ),
				)
			]
		);

		$this->add_control(
			'ere_enable_parallax_effect',
			[
				'label'        => esc_html__( 'Enable Parallax Effect', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'ere_show_bg_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'ere_enable_overlay',
			[
				'label'        => esc_html__( 'Enable Background Overlay', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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
				'name'     => 'cta_1_top_title_typography',
				'label'    => esc_html__( 'Top Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_cta__wrap_elementor .rh_cta__title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'cta_1_quote_typography',
				'label'    => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_cta__quote',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'cta_1_first_button_typography',
				'label'    => esc_html__( 'First Button', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cta_two_elementor_first_button',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'cta_1_second_button_typography',
				'label'    => esc_html__( 'Second Button', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cta_two_elementor_second_button',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_cta_1_spacing',
			[
				'label' => esc_html__( 'Spacings & Sizes', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]


		);

		$this->add_responsive_control(
			'ere_cta_1_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rh_section__cta_elementor_two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_1_content_max_width',
			[
				'label'           => esc_html__( 'CTA Text Max Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 2500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 950,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__cta_elementor_two .rh_cta__wrap_elementor' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_cta_1_top_title_bottom_margin',
			[
				'label'           => esc_html__( 'Top Title Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_cta__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_1_quote_main_title_margin',
			[
				'label'           => esc_html__( 'Main Title Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 25,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_cta__quote' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_first_button_padding',
			[
				'label'      => esc_html__( 'First Button Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .cta_two_elementor_first_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_second_button_padding',
			[
				'label'      => esc_html__( 'Second Button Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .cta_two_elementor_second_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_cta_1_quote_btn_horizontal_margin',
			[
				'label'           => esc_html__( 'Buttons Horizontal Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => - 2,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => -2,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .cta_two_elementor_button'   => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_cta__btns_elementor_two' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_1_quote_btn_vertical_margin',
			[
				'label'           => esc_html__( 'Buttons Vertical Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .cta_two_elementor_button' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_cta_border_tab',
			[
				'label' => esc_html__( 'Button Border', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]

		);

		$this->start_controls_tabs( 'tabs_cta_border' );

		$this->start_controls_tab(
			'cta_tab_border_normal',
			[
				'label' => esc_html__( 'Normal', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'cta_border_type',
				'label'    => esc_html__( 'Border', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .cta_two_elementor_button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cta_tab_border_hover',
			[
				'label' => esc_html__( 'Hover', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'cta_border_type_hover',
				'label'    => esc_html__( 'Border', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .cta_two_elementor_button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tab();


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_cta_1_styles_section',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ere_top_title_color',
			[
				'label'     => esc_html__( 'Top Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rh_cta__title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_main_title_color',
			[
				'label'     => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rh_cta__quote' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_first_button_color',
			[
				'label'     => esc_html__( 'First Button Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_two_elementor_first_button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_first_button_hover_color',
			[
				'label'     => esc_html__( 'First Button Text Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_two_elementor_first_button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_first_button_bg_color',
			[
				'label'     => esc_html__( 'First Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_two_elementor_first_button' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_first_button_bg_hover_color',
			[
				'label'     => esc_html__( 'First Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_two_elementor_first_button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_second_button_color',
			[
				'label'     => esc_html__( 'Second Button Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_two_elementor_second_button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_second_button_hover_color',
			[
				'label'     => esc_html__( 'Second Button Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_two_elementor_second_button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_second_button_bg_color',
			[
				'label'     => esc_html__( 'Second Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_two_elementor_second_button' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_second_button_bg_hover_color',
			[
				'label'     => esc_html__( 'Second Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_two_elementor_second_button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_cta_over_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor_overlay_cta_1' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		?>
        <section
                class="rh_elementor_widget rh_section__cta_elementor_two rh_cta--featured_elementor <?php if ( $settings['ere_enable_parallax_effect'] == 'yes' ) {
					echo esc_attr( 'ere_cta_parallax' );
				} ?>" style="background-size: <?php echo esc_attr($settings['ere_cta_1_image_bg_size']); ?>; background-image: url(<?php if ( $settings['ere_show_bg_image'] == 'yes' ) {
			if ( ! empty( $settings['cta_1_image']['id'] ) ) {
				echo esc_url( $settings['cta_1_image']['url'] );
			} else {
				echo plugins_url( 'assets/images/cta-above-footer.jpg', dirname( __DIR__ ) );
			}
		} ?> ) ">


			<?php if ( $settings['ere_enable_overlay'] == 'yes' ) { ?>
                <div class="elementor_overlay_cta_1"></div>
			<?php } ?>
            <div class="wrapper-section-contents_elementor">
                <div class="rh_cta__wrap_elementor">

					<?php if ( ! empty( $settings['cta_top_title'] ) ) { ?>
                        <p class="rh_cta__title"><?php echo esc_html( $settings['cta_top_title'] ); ?></p>
					<?php } ?>

					<?php if ( $settings['cta_main_title'] ) { ?>
                        <h3 class="rh_cta__quote"><?php echo esc_html( $settings['cta_main_title'] ); ?></h3>
					<?php } ?>

                    <div class="rh_cta__btns_elementor_two">

						<?php if ( $settings['cta_first_btn_title'] && $settings['cta_first_btn_url']['url'] ) {
							$target   = $settings['cta_first_btn_url']['is_external'] ? ' target="_blank"' : '';
							$nofollow = $settings['cta_first_btn_url']['nofollow'] ? ' rel="nofollow"' : '';
							?>
                            <a href="<?php echo esc_url( $settings['cta_first_btn_url']['url'] ); ?>"
                               class="cta_two_elementor_first_button cta_two_elementor_button"<?php echo $target . $nofollow; ?>><?php echo esc_html( $settings['cta_first_btn_title'] ); ?></a>
						<?php } ?>

						<?php if ( $settings['cta_second_btn_title'] && $settings['cta_second_btn_url']['url'] ) {
							$target   = $settings['cta_second_btn_url']['is_external'] ? ' target="_blank"' : '';
							$nofollow = $settings['cta_second_btn_url']['nofollow'] ? ' rel="nofollow"' : '';
							?>
                            <a href="<?php echo esc_url( $settings['cta_second_btn_url']['url'] ); ?>"
                               class="cta_two_elementor_second_button cta_two_elementor_button"<?php echo $target . $nofollow; ?>><?php echo esc_html( $settings['cta_second_btn_title'] ); ?></a>
						<?php } ?>

                    </div>

                </div>
            </div>

        </section>

		<?php

	}

}