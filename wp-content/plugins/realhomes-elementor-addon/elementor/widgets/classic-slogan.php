<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_Slogan_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-classic-slogan-widget';
	}

	public function get_title() {
		return esc_html__( 'Classic Slogan', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-post-title';
	}

	public function get_categories() {
		return [ 'classic-real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'ere_section_title',
			[
				'label' => esc_html__( 'Slogan', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
			'ere_section_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'section_main_title_typography',
				'label'    => esc_html__( 'Main Title ', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_classic_section__title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'section_description_typography',
				'label'    => esc_html__( 'Description ', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_classic_section__desc',
			]
		);

		$this->add_responsive_control(
			'ere_section_align',
			[
				'label' => esc_html__( 'Alignment', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_section_head_elementor' => 'text-align: {{VALUE}};',
				],
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
			'ere_section_main_title_color',
			[
				'label'     => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_section_head_elementor .rh_classic_section__title' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .rhea_classic_section_head_elementor .rh_classic_section__desc' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'ere_section_titles_margins',
			[
				'label' => esc_html__( 'Spacings & Sizes', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_section_content_max_width',
			[
				'label' => esc_html__( 'Content Max Width', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_section_head_elementor' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_main_title_spacing',
			[
				'label' => esc_html__( 'Main Title Bottom Margin', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rh_classic_section__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_section_margin_bottom',
			[
				'label' => esc_html__( 'Section Bottom Margin', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 70,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 50,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_section_head_elementor' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( $settings['ere_main_title'] || $settings['ere_description'] ) {
			?>
			<div class="rh_elementor_widget rhea_classic_section_head_elementor">
				<?php if ( $settings['ere_main_title'] ) { ?>
					<h2 class="rh_classic_section__title"><?php echo esc_html( $settings['ere_main_title'] ); ?></h2>
				<?php } ?>

				<?php if ( $settings['ere_description'] ) { ?>
					<p class="rh_classic_section__desc"><?php echo esc_html( $settings['ere_description'] ); ?></p>
				<?php } ?>
			</div>
			<?php
		}
	}

}