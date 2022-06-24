<?php

/**
 * Common functions for Easy Real Estate Elementor widgets.
 */
trait ERE_Elementor_Widgets_Common_Functions {

	/**
	 * To generate common title controls for modern widgets
	 */
	protected function title_controls() {

		$this->start_controls_section(
			'ere_section_title',
			[
				'label' => esc_html__( 'Section Titles', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_top_title',
			[
				'label' => esc_html__( 'Top Title', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'ere_main_title',
			[
				'label' => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'ere_description',
			[
				'label' => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 2,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_section_titles_styles',
			[
				'label' => esc_html__( 'Titles Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'ere_section_title_color',
			[
				'label'     => esc_html__( 'Top Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section .rh_section__head .rh_section__subtitle' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_section_main_title_color',
			[
				'label'     => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section .rh_section__head .rh_section__title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_section_description_color',
			[
				'label'     => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section .rh_section__head .rh_section__desc' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'ere_section_titles_margins',
			[
				'label' => esc_html__( 'Titles Spacing', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'ere_top_title_spacing',
			[
				'label' => esc_html__( 'Top Title', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section .rh_section__head .rh_section__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_main_title_spacing',
			[
				'label' => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section .rh_section__head .rh_section__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_description_spacing',
			[
				'label' => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section .rh_section__head .rh_section__desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


	}

	/**
	 * Render section title.
	 *
	 * @param $settings
	 */
	protected function render_section_title( $settings ) {
		if ( $settings['ere_top_title'] || $settings['ere_main_title'] || $settings['ere_description'] ) {
			?>
            <div class="rh_section__head re_section_head_elementor">
				<?php if ( $settings['ere_top_title'] ) { ?>
                    <span class="rh_section__subtitle"><?php echo esc_html( $settings['ere_top_title'] ); ?></span>
				<?php } ?>

				<?php if ( $settings['ere_main_title'] ) { ?>
                    <h2 class="rh_section__title"><?php echo esc_html( $settings['ere_main_title'] ); ?></h2>
				<?php } ?>

				<?php if ( $settings['ere_description'] ) { ?>
                    <p class="rh_section__desc"><?php echo esc_html( $settings['ere_description'] ); ?></p>
				<?php } ?>
            </div>
			<?php
		}
	}

}