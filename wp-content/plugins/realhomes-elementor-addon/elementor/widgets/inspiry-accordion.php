<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Accordion_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'inspiry-accordion-widget';
	}

	public function get_title() {
		return esc_html__( 'Accordion :: RealHomes', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Accordion', 'realhomes-elementor-addon' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label'       => esc_html__( 'Title & Description', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Accordion Title', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content',
			[
				'label'      => esc_html__( 'Content', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::WYSIWYG,
				'default'    => esc_html__( 'Accordion Content', 'realhomes-elementor-addon' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'       => esc_html__( 'Accordion Items', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'tab_title'   => esc_html__( 'Accordion #1', 'realhomes-elementor-addon' ),
						'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut  et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo.', 'realhomes-elementor-addon' ),
					],
					[
						'tab_title'   => esc_html__( 'Accordion #2', 'realhomes-elementor-addon' ),
						'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut  et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo.', 'realhomes-elementor-addon' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'       => esc_html__( 'Icon', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'separator'   => 'before',
				'default'     => [
					'value'   => 'fas fa-plus',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid'   => [
						'chevron-down',
						'angle-down',
						'angle-double-down',
						'caret-down',
						'caret-square-down',
					],
					'fa-regular' => [
						'caret-square-down',
					],
				],
				'skin'        => 'inline',
				'label_block' => false,
			]
		);

		$this->add_control(
			'selected_active_icon',
			[
				'label'       => esc_html__( 'Active Icon', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-minus',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid'   => [
						'chevron-up',
						'angle-up',
						'angle-double-up',
						'caret-up',
						'caret-square-up',
					],
					'fa-regular' => [
						'caret-square-up',
					],
				],
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_title',
			[
				'label' => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'active_first_item',
			[
				'label'        => esc_html__( 'Active First?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .rhea-accordion .rhea-accordion-title',
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'tab_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title.rhea-accordion-active' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label'     => esc_html__( 'Border Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_content',
			[
				'label' => esc_html__( 'Content', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .rhea-accordion .rhea-accordion-content, {{WRAPPER}} .rhea-accordion .rhea-accordion-content p',
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-content' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'content_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-content' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'realhomes-elementor-addon' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'   => esc_html__( 'Alignment', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'  => [
						'title' => esc_html__( 'Start', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'End', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => is_rtl() ? 'left' : 'right',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title .rhea-accordion-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title .rhea-accordion-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title.rhea-accordion-active .rhea-accordion-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-title.rhea-accordion-active .rhea-accordion-icon svg'  => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label'     => esc_html__( 'Spacing', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-icon.rhea-accordion-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-accordion .rhea-accordion-icon.rhea-accordion-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = 'rhea-accordion-' . $this->get_id();
		?>
        <dl id="<?php echo esc_attr( $widget_id ); ?>" class="rhea-accordion">
			<?php
			foreach ( $settings['tabs'] as $index => $item ) :
				$tab_count = $index + 1;

				$current_class = '';
				if ( 'yes' == $settings['active_first_item'] && ( 1 === $tab_count ) ) {
					$current_class = ' rhea-accordion-active';
				}
				?>
                <dt class="rhea-accordion-title<?php echo esc_attr( $current_class ); ?>"><?php
					if ( ! empty( $settings['selected_icon']['value'] ) ) : ?>
                        <span class="rhea-accordion-icon rhea-accordion-icon-<?php echo esc_attr( $settings['icon_align'] ); ?>" aria-hidden="true">
                            <span class="rhea-accordion-icon-closed"><?php \Elementor\Icons_Manager::render_icon( $settings['selected_icon'] ); ?></span>
                            <span class="rhea-accordion-icon-opened"><?php \Elementor\Icons_Manager::render_icon( $settings['selected_active_icon'] ); ?></span>
                        </span>
					<?php
					endif;

					echo esc_html( $item['tab_title'] );
					?></dt>
                <dd class="rhea-accordion-content<?php echo esc_attr( $current_class ); ?>"><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></dd>
			<?php endforeach; ?>
        </dl>
        <script>
            (function ($) {
                'use strict';
                $(document).ready(function () {
                    rheaAccordion('<?php echo esc_attr( $widget_id ); ?>');
                });
            })(jQuery);
        </script>
		<?php
	}
}