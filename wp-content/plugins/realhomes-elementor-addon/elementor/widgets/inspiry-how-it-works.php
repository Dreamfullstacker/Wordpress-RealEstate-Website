<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_How_It_Works_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rhea-how-it-works-widget';
	}

	public function get_title() {
		return esc_html__( 'How It Works', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-preview-thin';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		// Items
		$this->start_controls_section(
			'rhea_hiw_items',
			[
				'label' => esc_html__( 'Add Items', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'rhea_hiw_widget_item_icon_type',
			[
				'label'   => esc_html__( 'Select Icon Type', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'image',
				'options' => array(
					'image' => esc_html__( 'Image', 'realhomes-elementor-addon' ),
					'icon'  => esc_html__( 'Icon', 'realhomes-elementor-addon' ),
				),
			]
		);

		$repeater->add_control(
			'section_image',
			[
				'label'     => esc_html__( 'Choose Image', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'rhea_hiw_widget_item_icon_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'rhea_hiw_widget_item_icon_type' => 'icon',
				],
			]
		);

		$repeater->add_responsive_control(
			'rhea_icon_size',
			[
				'label'           => esc_html__( 'Icon Size', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-hiw-widget-item-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-hiw-widget-item-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'       => [
					'rhea_hiw_widget_item_icon_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'rhea_hiw_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .rhea-hiw-widget-item-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .rhea-hiw-widget-item-icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'rhea_hiw_widget_item_icon_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'section_title',
			[
				'label'       => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Section Title', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'section_description',
			[
				'label'       => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Default description', 'realhomes-elementor-addon' ),
				'placeholder' => esc_html__( 'Type your description here', 'realhomes-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'show_item_divider',
			[
				'label'        => esc_html__( 'Step Divider', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'hide',
				'label_on'     => 'Hide',
				'label_off'    => 'Show',
				'return_value' => 'show',
			]
		);

		$repeater->add_control(
			'invert_item_divider',
			[
				'label'        => esc_html__( 'Invert Divider', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => 'No',
				'label_off'    => 'Yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'rhea_hiw_section',
			[
				'label'       => '',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => ' {{{ section_title }}}',
			]
		);

		$this->end_controls_section();

		// Settings
		$this->start_controls_section(
			'rhea_hiw_widget_settings',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_widget_item_width',
			[
				'label'           => esc_html__( 'Items Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'     => [
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
					'{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'modern-property-child-slider',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Image Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_divider_width',
			[
				'label'           => __( 'Divider Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices'         => [ 'desktop', 'tablet' ],
				'separator' => 'before',
				'selectors'       => [
					'{{WRAPPER}} .rhea-hiw-widget-item-divider-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_divider_circle_position',
			[
				'label'           => __( 'Divider Top Position', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-hiw-widget-item-divider-wrapper ' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_divider_circle_position_inverted',
			[
				'label'           => __( 'Divider Top Position Inverted', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-hiw-widget-item-divider-wrapper.inverted' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Typography
		$this->start_controls_section(
			'rhea_hiw_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_hiw_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_hiw_title_desc',
				'label'    => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-hiw-widget-item-desc',
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_section_align',
			[
				'label'     => esc_html__( 'Alignment', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => is_rtl() ? 'right' : 'left',
				'selectors' => [
					'{{WRAPPER}} .rhea-hiw-widget-item' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Colors
		$this->start_controls_section(
			'rhea_hiw_colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rhea_hiw_section_color',
			[
				'label'     => esc_html__( 'Items Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-hiw-widget-item' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_hiw_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_hiw_desc_color',
			[
				'label'     => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_hiw_divider_circle_color',
			[
				'label'     => esc_html__( 'Divider Circle', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-how-it-works-widget rhea-hiw-widget-item-divider-wrapper .rhea-hiw-widget-item-divider' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_hiw_divider_circle_icon_color',
			[
				'label'     => esc_html__( 'Divider Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-how-it-works-widget rhea-hiw-widget-item-divider-wrapper .rhea-hiw-widget-item-divider i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_hiw_divider_curve_color',
			[
				'label'     => esc_html__( 'Divider Curve', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-hiw-widget-item-divider-wrapper svg path' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Spaces
		$this->start_controls_section(
			'rhea_hiw_spaces',
			[
				'label' => esc_html__( 'Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_content_margin',
			[
				'label'      => esc_html__( 'Items Margin', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_content_padding',
			[
				'label'      => esc_html__( 'Items Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_icon_margin_bottom',
			[
				'label'           => esc_html__( 'Image/Icon Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_hiw_title_margin_bottom',
			[
				'label'           => esc_html__( 'Title Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->end_controls_section();

		// Box Shadow
		$this->start_controls_section(
			'rhea_hiw_box_shadow',
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
				'selector' => '{{WRAPPER}} .rhea-how-it-works-widget .rhea-hiw-widget-item',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$thumbnail_size = $settings['thumbnail_size'];
		if ( $settings['thumbnail_custom_dimension'] ) {
			$thumbnail_size = array(
				$settings['thumbnail_custom_dimension']['width'],
				$settings['thumbnail_custom_dimension']['height'],
			);
		}

		if ( $settings['rhea_hiw_section'] ) :
			?>
            <div class="rhea-how-it-works-widget">
				<?php
				foreach ( $settings['rhea_hiw_section'] as $item ) :
					?>
                    <div class="rhea-hiw-widget-item">
						<?php
						if ( 'image' == $item['rhea_hiw_widget_item_icon_type'] ) {
							if ( $item['section_image'] ) {
								?>
                                <div class="rhea-hiw-widget-item-thumb rhea-hiw-widget-item-image">
									<?php echo wp_get_attachment_image(
										$item['section_image']['id'],
										$thumbnail_size,
										'',
										array(
											'alt' => $item['section_title'],
										)
									); ?>
                                </div>
								<?php
							}
						} elseif ( 'icon' == $item['rhea_hiw_widget_item_icon_type'] ) {
							?>
                            <div class="rhea-hiw-widget-item-thumb rhea-hiw-widget-item-icon">
								<?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </div>
							<?php
						}
						if ( $item['section_title'] ) {
							?>
                            <h3 class="rhea-hiw-widget-item-title"><?php echo esc_html( $item['section_title'] ) ?></h3>
							<?php
						}
						if ( $item['section_description'] ) :
							?>
                            <div class="rhea-hiw-widget-item-content">
                                <p class="rhea-hiw-widget-item-desc">
									<?php echo esc_html( $item['section_description'] ); ?>
                                </p>
                            </div>
						<?php
						endif;
						?>
                    </div>
					<?php
					if ( 'show' == $item['show_item_divider'] ) :
						$container_class = '';
						$curve_y_position = '-32';

						if ( 'yes' == $item['invert_item_divider'] ) {
							$container_class  = ' inverted';
							$curve_y_position = '32';
						}
						?>
                        <div class="rhea-hiw-widget-item-divider-wrapper<?php echo esc_attr( $container_class ); ?>">
                            <svg width="150" height="100" viewBox="0 0 150 100">
                                <path d="M 0 75 q 75 <?php echo esc_attr( $curve_y_position ); ?> 150 0" stroke-dasharray="4,6" stroke="#d5d5d5" stroke-width="2" fill="none"/>
                            </svg>
                            <span class="rhea-hiw-widget-item-divider"><i aria-hidden="true"
                                                                          class="fas fa-angle-right"></i></span>
                        </div>
					<?php endif; ?>
				<?php endforeach; ?>
            </div>
		<?php
		endif;
	}
}