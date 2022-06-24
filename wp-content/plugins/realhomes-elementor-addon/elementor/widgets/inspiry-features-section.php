<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Modern_Features_Section_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rhea-modern-features-section-widget';
	}

	public function get_title() {
		return esc_html__( 'Features Section', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'rhea_features_options',
			[
				'label' => esc_html__( 'Options', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'rhea_features_grid_layout',
			[
				'label'       => __( 'Layout', 'realhomes-elementor-addon' ),
				'description' => __( 'Number of columns will be reduced automatically if parent container has insufficient width.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => '33.333%',
				'options'     => array(
					'25%'     => esc_html__( '4 Columns', 'realhomes-elementor-addon' ),
					'33.333%' => esc_html__( '3 Columns', 'realhomes-elementor-addon' ),
					'50%'     => esc_html__( '2 Columns', 'realhomes-elementor-addon' ),
					'100%'    => esc_html__( '1 Column', 'realhomes-elementor-addon' ),
				),
				'selectors'   => [
					'{{WRAPPER}} .rhea_modern_feature_section' => 'width: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_features',
			[
				'label' => esc_html__( 'Add Features', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();


		$repeater->add_control(
			'rhea_select_icon_type',
			[
				'label'   => esc_html__( 'Select Feature Icon Type', 'realhomes-elementor-addon' ),
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
					'rhea_select_icon_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'custom_dimension',
			[
				'label'       => esc_html__( 'Image Dimension', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
				'description' => __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'realhomes-elementor-addon' ),
				'default'     => [
					'width'  => '64',
					'height' => '64',
				],
				'condition'   => [
					'rhea_select_icon_type' => 'image',
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
					'rhea_select_icon_type' => 'icon',
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
					'{{WRAPPER}} .rhea_modern_features_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_modern_features_icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'       => [
					'rhea_select_icon_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'rhea_feature_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .rhea_modern_features_icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .rhea_modern_features_icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'rhea_select_icon_type' => 'icon',
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


		$this->add_control(
			'rhea_section_feature',
			[
				'label'       => '',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => ' {{{ section_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_features_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_feature_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_modern_feature_title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_feature_title_desc',
				'label'    => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_modern_feature_desc',
			]
		);

		$this->add_responsive_control(
			'rhea_features_section_align',
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .rhea_modern_feature_section' => 'text-align: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_features_colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rhea_feature_section_color',
			[
				'label'     => esc_html__( 'Section Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_modern_feature_section_inner' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_feature_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_modern_feature_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_feature_desc_color',
			[
				'label'     => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_modern_feature_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_features_spaces',
			[
				'label' => esc_html__( 'Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'rhea_feature_content_margin',
			[
				'label'      => esc_html__( 'Features Margin', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_modern_feature_section_inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_feature_content_padding',
			[
				'label'      => esc_html__( 'Features Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_modern_feature_section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_feature_content_inner_padding',
			[
				'label'      => esc_html__( 'Features Inner Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_modern_feature_section_inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_feature_icon_margin_bottom',
			[
				'label'           => esc_html__( 'Icon Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_modern_feature_thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_feature_title_margin_bottom',
			[
				'label'           => esc_html__( 'title Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_modern_feature_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_feature_box_shadow',
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
				'selector' => '{{WRAPPER}} .rhea_modern_feature_section_inner',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( $settings['rhea_section_feature'] ) {
			?>
            <div class="rhea_modern_elementor_widget_wrapper">
				<?php
				foreach ( $settings['rhea_section_feature'] as $item ) {
					?>
                    <div class="rhea_modern_feature_section <?php echo esc_attr('elementor-repeater-item-' . $item['_id']); ?>">
                        <div class="rhea_modern_feature_section_inner">
							<?php
							if ( 'image' == $item['rhea_select_icon_type'] ) {
								if ( $item['section_image'] ) {
									?>
                                    <div class="rhea_modern_feature_thumb rhea_modern_features_image">
										<?php echo wp_get_attachment_image(
											$item['section_image']['id'],
											array(
												$item['custom_dimension']['width'],
												$item['custom_dimension']['height'],
											),
											'',
											array(
												'alt' => $item['section_title'],
											)
										); ?>
                                    </div>
									<?php
								}
							} elseif ( 'icon' == $item['rhea_select_icon_type'] ) {
								?>
                                <div class="rhea_modern_feature_thumb rhea_modern_features_icon">
									<?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </div>
								<?php
							}
							if ( $item['section_title'] ) {
								?>
                                <h3 class="rhea_modern_feature_title"><?php echo esc_html( $item['section_title'] ) ?></h3>
								<?php
							}
							if ( $item['section_description'] ) {
								?>
                                <div class="rhea_features_content_area">
                                    <p class="rhea_modern_feature_desc">
										<?php echo esc_html( $item['section_description'] ); ?>
                                    </p>
                                </div>


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


	}

}