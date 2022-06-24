<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'inspiry-hero-widget';
	}

	public function get_title() {
		return esc_html__( 'Hero Widget', 'realhomes-rhea-hero-widget-addon' );
	}

	public function get_icon() {
		return 'eicon-star';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		// Title & Description
		$this->start_controls_section(
			'title_and_description',
			[
				'label' => esc_html__( 'Title and Description', 'realhomes-rhea-hero-widget-addon' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label'       => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'section_description',
			[
				'label'       => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => '7',
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing. ullamcorper mattis, pulvinar dapibus.', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// Contact Form
		$this->start_controls_section(
			'contact_form',
			[
				'label' => esc_html__( 'Form', 'realhomes-rhea-hero-widget-addon' ),
			]
		);

		$this->add_control(
			'form_title',
			[
				'label'       => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'location_field_label',
			[
				'label'       => esc_html__( 'Location Field Label', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Location', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'location_field_placeholder',
			[
				'label'       => esc_html__( 'Location Field Placeholder Text', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Select Location', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'type_field_label',
			[
				'label'       => esc_html__( 'Type Field Label', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Type', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'type_field_placeholder',
			[
				'label'       => esc_html__( 'Type Field Placeholder Text', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Select Type', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'guest_field_label',
			[
				'label'       => esc_html__( 'Guest Field Label', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Guests Capacity', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'guest_field_placeholder',
			[
				'label'       => esc_html__( 'Guest Field Placeholder Text', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Number of guests', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'submit_button_text',
			[
				'label'       => esc_html__( 'Submit Button Text', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Submit', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// Testimonial
		$this->start_controls_section(
			'section_testimonial',
			[
				'label' => esc_html__( 'Testimonial', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'testimonial_content',
			[
				'label'   => esc_html__( 'Content', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => '7',
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing. ullamcorper mattis, pulvinar dapibus.', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'testimonial_name',
			[
				'label'   => esc_html__( 'Author Name', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => ' - John Doe',
			]
		);

		$this->add_control(
			'testimonial_image',
			[
				'label'   => esc_html__( 'Choose Image', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended image size is 150x150.', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		// Image
		$this->start_controls_section(
			'section_column_image',
			[
				'label' => esc_html__( 'Image', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'column_image',
			[
				'label'   => esc_html__( 'Choose Image', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended image size is 600x600.', 'realhomes-elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'column_image',
				'default'   => 'partners-logo',
				'separator' => 'none',
			]
		);

		$this->end_controls_section();

		// Container Styles
		$this->start_controls_section(
			'container_style',
			[
				'label' => esc_html__( 'Container', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-hero-widget-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'container_bg',
			[
				'label'     => esc_html__( 'Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-bg-placeholder' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'container_bg_width',
			[
				'label'     => esc_html__( 'Background Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
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
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-bg-placeholder' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'container_bg_height',
			[
				'label'     => esc_html__( 'Background Height', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
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
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-bg-placeholder' => 'height: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'inner_wrapper_width',
			[
				'label'     => esc_html__( 'Inner Wrapper Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-inner-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_left_column_width',
			[
				'label'     => esc_html__( 'Left Column Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'before',
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
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-col-left' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'container_left_column_padding',
			[
				'label'      => esc_html__( 'Left Column Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-hero-widget-col-left' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_right_column_width',
			[
				'label'     => esc_html__( 'Right Column Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'before',
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
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-col-right' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'container_right_column_padding',
			[
				'label'      => esc_html__( 'Right Column Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-hero-widget-col-right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Title and Description Styles
		$this->start_controls_section(
			'title_and_description_style',
			[
				'label' => esc_html__( 'Title and Description', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-hero-widget-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-title' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'title_bottom_margin',
			[
				'label'     => esc_html__( 'Title Bottom Margin', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-title-divider' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'divider_bottom_margin',
			[
				'label'     => esc_html__( 'Divider Bottom Margin', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'after',
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-title-divider' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Description Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-hero-widget-description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-description' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'description_bottom_margin',
			[
				'label'     => esc_html__( 'Description Bottom Margin', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Form Styles
		$this->start_controls_section(
			'form_style',
			[
				'label' => esc_html__( 'Form', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_title_typography',
				'label'    => esc_html__( 'Title Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-hero-widget-form-title',
			]
		);

		$this->add_control(
			'form_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form-title' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'form_title_bottom_margin',
			[
				'label'     => esc_html__( 'Title Bottom Margin', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_width',
			[
				'label'           => esc_html__( 'Form Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'separator'       => 'before',
				'devices'         => [ 'desktop', 'tablet' ],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-hero-widget-form' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_bottom_margin',
			[
				'label'     => esc_html__( 'Form Bottom Margin', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_bg_color',
			[
				'label'     => esc_html__( 'Form Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'form_label_typography',
				'label'     => esc_html__( 'Labels Typography', 'realhomes-elementor-addon' ),
				'separator' => 'before',
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .rhea-hero-widget-form label',
			]
		);

		$this->add_control(
			'form_label_color',
			[
				'label'     => esc_html__( 'Labels Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form label' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'form_input_and_select_color',
			[
				'label'     => esc_html__( 'Input and Select Fields Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form .bootstrap-select.rhea_multi_select_picker > .dropdown-toggle, {{WRAPPER}} .rhea-hero-widget-form input[type="text"], {{WRAPPER}}  .rhea-hero-widget-form select' => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-hero-widget-form ::-webkit-input-placeholder'                                                                                                                                      => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-hero-widget-form ::-moz-placeholder'                                                                                                                                               => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-hero-widget-form :-ms-input-placeholder'                                                                                                                                           => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-hero-widget-form :-moz-placeholder'                                                                                                                                                => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'form_select_dropdown_item_hover_background',
			[
				'label'     => esc_html__( 'Select Dropdown Items Hover Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-menu li:hover' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'form_select_dropdown_hover_color',
			[
				'label'     => esc_html__( 'Select Dropdown Items Text Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-menu li:hover a' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'form_submit_button_width',
			[
				'label'     => esc_html__( 'Submit Button Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'before',
				'devices'   => [ 'desktop' ],
				'size_units' => [ '%' ],
				'range'     => [
					'%' => [
						'min' => 19,
						'max' => 35,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form-field-submit' => 'flex-basis: {{SIZE}}{{unit}}; max-width: {{SIZE}}{{unit}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_submit_button_typography',
				'label'    => esc_html__( 'Submit Button Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-hero-widget-form .rhea-hero-widget-form-field-submit-button',
			]
		);

		$this->add_control(
			'form_submit_button_color',
			[
				'label'     => esc_html__( 'Submit Button Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form .rhea-hero-widget-form-field-submit-button' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'form_submit_button_hover_color',
			[
				'label'     => esc_html__( 'Submit Button Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form .rhea-hero-widget-form-field-submit-button:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'form_submit_button_background',
			[
				'label'     => esc_html__( 'Submit Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form .rhea-hero-widget-form-field-submit-button' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'form_submit_button_hover_background',
			[
				'label'     => esc_html__( 'Submit Button Hover Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-form .rhea-hero-widget-form-field-submit-button:hover' => 'background: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		// Testimonial Styles
		$this->start_controls_section(
			'testimonial_style',
			[
				'label' => esc_html__( 'Testimonial', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonial_text_typography',
				'label'    => esc_html__( 'Text Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-hero-widget-testimonial-content',
			]
		);

		$this->add_control(
			'testimonial_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-testimonial-content' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonial_author_typography',
				'label'    => esc_html__( 'Author Name Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-hero-widget-testimonial-content cite',
			]
		);

		$this->add_control(
			'testimonial_author_color',
			[
				'label'     => esc_html__( 'Author Name Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-testimonial-content cite' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'testimonial_author_image_size',
			[
				'label'     => esc_html__( 'Author Image Size', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 50,
						'max' => 160,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-testimonial-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-hero-widget-testimonial-content'   => 'width: calc( 100% - {{SIZE}}{{UNIT}} - 12px );',
				],
			]
		);

		$this->add_responsive_control(
			'testimonial_author_image_border_size',
			[
				'label'     => esc_html__( 'Author Image Border Size', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-hero-widget-testimonial-image img' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = 'rhea-hero-widget-' . $this->get_id();
		?>
        <div id="<?php echo esc_attr( $widget_id ); ?>" class="rhea-hero-widget-wrapper">
            <div class="rhea-hero-widget-bg-placeholder"></div>
            <div class="rhea-hero-widget-inner-wrapper">
                <div class="rhea-hero-widget-col-left">
					<?php if ( isset( $settings['section_title'] ) || isset( $settings['section_description'] ) ) : ?>
                        <div class="rhea-hero-widget-title-and-description">
							<?php if ( ! empty( $settings['section_title'] ) ) : ?>
                                <h2 class="rhea-hero-widget-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
                                <span class="rhea-hero-widget-title-divider"></span>
							<?php
							endif;

							if ( ! empty( $settings['section_description'] ) ) : ?>
                                <p class="rhea-hero-widget-description"><?php echo esc_html( $settings['section_description'] ); ?></p>
							<?php endif; ?>
                        </div>
					<?php endif; ?>

					<?php
					if ( function_exists( 'realhomes_get_dashboard_page_url' ) && function_exists( 'inspiry_is_rvr_enabled' ) && inspiry_is_rvr_enabled() ) :
						?>
                        <div class="rhea-hero-widget-form-wrapper">
							<?php if ( ! empty( $settings['form_title'] ) ) : ?>
                                <h3 class="rhea-hero-widget-form-title"><?php echo esc_html( $settings['form_title'] ); ?></h3>
							<?php endif; ?>
                            <form id="<?php echo esc_attr( $widget_id ); ?>-form" class="rhea-hero-widget-form"
                                  method="get"
                                  action="<?php echo esc_url( realhomes_get_dashboard_page_url() ); ?>">
                                <input type="hidden" name="module" value="properties">
                                <input type="hidden" name="submodule" value="submit-property">
								<?php
								if ( ! is_user_logged_in() && function_exists( 'inspiry_guest_submission_enabled' ) && ! inspiry_guest_submission_enabled() ) : ?>
                                    <input type="hidden" name="ask-for-login" value="true">
								<?php
								endif;
								?>
                                <div class="rhea-hero-widget-form-fields-wrapper">

                                    <div class="rhea-hero-widget-form-fields">

                                        <div class="rhea-hero-widget-form-field">
                                            <label for="<?php echo esc_attr( $widget_id ); ?>-select-location"
                                                   class="rhea-hero-widget-contact-form-label">
												<?php
												if ( ! empty( $settings['location_field_label'] ) ) {
													echo esc_html( $settings['location_field_label'] );
												} else {
													esc_html_e( 'Location', 'realhomes-elementor-addon' );
												}
												?>
                                            </label>
                                            <select name="location"
                                                    id="<?php echo esc_attr( $widget_id ); ?>-select-location"
                                                    class="rhea_multi_select_picker">
                                                <option value="" selected="selected">
													<?php
													if ( ! empty( $settings['location_field_placeholder'] ) ) {
														echo esc_html( $settings['location_field_placeholder'] );
													} else {
														esc_html_e( 'None', 'realhomes-elementor-addon' );
													}
													?>
                                                </option>
												<?php
												if ( function_exists( 'realhomes_hierarchical_options' ) ) {
													realhomes_hierarchical_options( 'property-city' );
												}
												?>
                                            </select>
                                        </div>

                                        <div class="rhea-hero-widget-form-field">
                                            <label for="<?php echo esc_attr( $widget_id ); ?>-select-type"
                                                   class="rhea-hero-widget-contact-form-label">
												<?php
												if ( ! empty( $settings['type_field_label'] ) ) {
													echo esc_html( $settings['type_field_label'] );
												} else {
													esc_html_e( 'Type', 'realhomes-elementor-addon' );
												}
												?>
                                            </label>
                                            <select name="type" id="<?php echo esc_attr( $widget_id ); ?>-select-type"
                                                    class="rhea_multi_select_picker">
                                                <option value="" selected="selected"><?php
													if ( ! empty( $settings['type_field_placeholder'] ) ) {
														echo esc_html( $settings['type_field_placeholder'] );
													} else {
														esc_html_e( 'None', 'realhomes-elementor-addon' );
													}
													?></option>
												<?php
												if ( class_exists( 'ERE_Data') && function_exists( 'realhomes_id_based_hierarchical_options' ) ) {
													realhomes_id_based_hierarchical_options( ERE_Data::get_hierarchical_property_types(), - 1 );
												}
												?>
                                            </select>
                                        </div>

                                        <div class="rhea-hero-widget-form-field rhea-hero-widget-form-placeholder-field">
                                            <label for="<?php echo esc_attr( $widget_id ); ?>-guests-capacity"
                                                   class="rhea-hero-widget-contact-form-label">
												<?php
												if ( ! empty( $settings['guest_field_label'] ) ) {
													echo esc_html( $settings['guest_field_label'] );
												} else {
													esc_html_e( 'Guests Capacity', 'realhomes-elementor-addon' );
												}
												?>
                                            </label>
                                            <input id="<?php echo esc_attr( $widget_id ); ?>-guests-capacity"
                                                   type="text" name="rvr_guests_capacity"
                                                   placeholder="<?php echo esc_attr( $settings['guest_field_placeholder'] ); ?>"
                                                   autocomplete="off">
                                        </div>

                                    </div><!-- .rhea-hero-widget-form-fields -->

                                    <div class="rhea-hero-widget-form-field-submit">
										<?php
										$submit_button_text = esc_html__( 'Submit', 'realhomes-elementor-addon' );
										if ( ! empty( $settings['submit_button_text'] ) ) {
											$submit_button_text = $settings['submit_button_text'];
										}
										?>
                                        <input type="submit" value="<?php echo esc_attr( $submit_button_text ); ?>"
                                               class="rhea-hero-widget-form-field-submit-button">
                                    </div>
                                </div><!-- .rhea-hero-widget-form-fields-wrapper -->
                            </form><!-- .rhea-hero-widget-form -->
                        </div><!-- .rhea-hero-widget-form-wrapper -->
					<?php endif; ?>

					<?php if ( ! empty( $settings['testimonial_content'] ) ) : ?>
                        <div class="rhea-hero-widget-testimonial-wrapper">
							<?php if ( ! empty( $settings['testimonial_image'] ) ) : ?>
                                <div class="rhea-hero-widget-testimonial-image">
									<?php echo wp_get_attachment_image( $settings['testimonial_image']['id'] ); ?>
                                </div>
							<?php endif; ?>
                            <blockquote class="rhea-hero-widget-testimonial-content"><?php
								echo esc_html( $settings['testimonial_content'] );

								if ( ! empty( $settings['testimonial_name'] ) ) :
									?><cite
                                        class="rhea-hero-widget-testimonial-name"><?php echo esc_html( $settings['testimonial_name'] ); ?></cite><?php
								endif;
								?>
                            </blockquote>
                        </div><!-- .rhea-hero-widget-testimonial-wrapper -->
					<?php endif; ?>
                </div><!-- .rhea-hero-widget-col-left -->

				<?php if ( ! empty( $settings['column_image'] ) ) : ?>
                    <div class="rhea-hero-widget-col-right">
                        <div class="rhea-hero-widget-image">
							<?php
							echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'column_image' );
							?>
                        </div>
                    </div><!-- .rhea-hero-widget-col-right -->
				<?php endif; ?>
            </div><!-- .rhea-hero-widget-inner-wrapper -->
        </div><!-- .rhea-hero-widget-wrapper -->
        <script>
            (function ($) {
                'use strict';
                $(document).ready(function () {
                    rheaSelectPicker("#<?php echo esc_html( $widget_id ); ?> select");
                });
            })(jQuery);
        </script>
		<?php
	}
}