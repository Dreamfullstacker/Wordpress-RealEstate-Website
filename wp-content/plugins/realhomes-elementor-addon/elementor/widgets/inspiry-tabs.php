<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Tabs_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'inspiry-tabs-widget';
	}

	public function get_title() {
		return esc_html__( 'Tabs :: RealHomes', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_keywords() {
		return [ 'tabs', 'accordion', 'toggle' ];
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Tabs', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'tabs_nav_title',
			[
				'label'       => esc_html__( 'Tabs Section Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label'       => esc_html__( 'Tab Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tab Title', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content',
			[
				'label'      => esc_html__( 'Tab Content', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::WYSIWYG,
				'default'    => esc_html__( 'Tab Content', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'       => esc_html__( 'Tabs Items', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'tab_title'   => esc_html__( 'Tabs #1', 'realhomes-elementor-addon' ),
						'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut  et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo.', 'realhomes-elementor-addon' ),
					],
					[
						'tab_title'   => esc_html__( 'Tabs #2', 'realhomes-elementor-addon' ),
						'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut  et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo.', 'realhomes-elementor-addon' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tabs_style',
			[
				'label' => esc_html__( 'Tabs', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tabs_container_width',
			[
				'label'           => esc_html__( 'Container Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 1600,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-tabs-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_container_margin',
			[
				'label'      => esc_html__( 'Container Margin', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-tabs-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_container_border_radius',
			[
				'label'      => esc_html__( 'Container Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .rhea-tabs-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_tabs_section',
			[
				'label' => esc_html__( 'Tabs Section', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tabs_section_background',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_section_width',
			[
				'label'           => esc_html__( 'Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 50,
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-wrapper' => 'flex-basis: {{SIZE}}%; max-width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_section_padding',
			[
				'label'      => esc_html__( 'Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'heading_tabs_section_title',
			[
				'label' => esc_html__( 'Tabs Section Title', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tabs_section_title_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-section-title' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'name'     => 'tabs_section_title_typography',
				'selector' => '{{WRAPPER}} .rhea-tabs-container .rhea-tabs-section-title',
			]
		);

		$this->add_responsive_control(
			'tabs_section_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_tabs_nav',
			[
				'label' => esc_html__( 'Tabs Navigation', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tabs_nav_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list li' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'tabs_nav_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list li:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list li.rhea-tabs-active' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_nav_typography',
				'selector' => '{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list-item',
			]
		);

		$this->add_responsive_control(
			'tabs_nav_item_bottom_margin',
			[
				'label'           => esc_html__( 'Items Bottom Margin', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bullet_color',
			[
				'label'     => esc_html__( 'Bullet Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list li:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$tabs_nav_item_padding = is_rtl() ? 'padding-right' : 'padding-left';
		$this->add_responsive_control(
			'tabs_nav_item_padding',
			[
				'label'           => esc_html__( 'Bullet Space', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list li' => $tabs_nav_item_padding .': {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'bullet_width',
			[
				'label'           => esc_html__( 'Bullet Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list li:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'bullet_top_position',
			[
				'label'           => esc_html__( 'Bullet Top Position', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-list li:before' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_tabs_content',
			[
				'label' => esc_html__( 'Tabs Content', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-content-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-content ul li' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .rhea-tabs-container .rhea-accordion-content hr' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .rhea-tabs-container .rhea-tabs-content',
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'           => esc_html__( 'Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 50,
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => '',
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-content-wrapper' => 'flex-basis: {{SIZE}}%; max-width: {{SIZE}}%;',
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
					'{{WRAPPER}} .rhea-tabs-container .rhea-tabs-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = 'rhea-tabs-' . $this->get_id();
		?>
        <div id="<?php echo esc_attr( $widget_id ); ?>" class="rhea-tabs-container">
            <div class="rhea-tabs-wrapper">
	            <?php
	            if ( $settings['tabs_nav_title'] ) {
		            ?>
                    <h4 class="rhea-tabs-section-title"><?php echo esc_html( $settings['tabs_nav_title'] ); ?></h4>
		            <?php
	            }
	            ?>
                <div class="rhea-tabs">
                    <ul class="rhea-tabs-list">
	                    <?php
	                    foreach ( $settings['tabs'] as $index => $item ) :
		                    $tab_count = $index + 1;
		                    $current_class = '';
		                    if ( 1 === $tab_count ) {
			                    $current_class = ' rhea-tabs-active';
		                    }
		                    ?>
                            <li class="rhea-tabs-list-item<?php echo esc_attr( $current_class ); ?>"><?php echo esc_html( $item['tab_title'] ); ?></li>
	                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="rhea-tabs-content-wrapper">
	            <?php
	            foreach ( $settings['tabs'] as $index => $item ) :
		            $tab_count = $index + 1;
		            $current_class = '';
		            if ( 1 === $tab_count ) {
			            $current_class = ' rhea-tabs-active';
		            }
		            ?>
                    <div class="rhea-tabs-content<?php echo esc_attr( $current_class ); ?>"><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></div>
	            <?php endforeach; ?>
            </div>
        </div>
        <script>
            (function ($) {
                'use strict';
                $(document).ready(function () {
                    rheaTabs('<?php echo esc_attr( $widget_id ); ?>');
                });
            })(jQuery);
        </script>
		<?php
	}
}
