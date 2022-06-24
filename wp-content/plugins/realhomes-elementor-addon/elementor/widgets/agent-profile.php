<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agent_Profile_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'rhea-agent-profile-widget';
	}

	public function get_title() {
		return esc_html__( 'Agent Profile', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {


		$this->start_controls_section(
			'rhea_add_content',
			[
				'label' => esc_html__( 'Profile Content', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label'       => esc_html__( 'Choose Image', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended Image Size 540 x 540 (Image must be of equal Width and Height).', 'realhomes-elementor-addon' ) . '</br>' .
				                 esc_html__( 'You can crop the image by selecting "Custom" option from &#8681; Image Size. ', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
				'exclude'   => [
					'2048x2048',
					'thumbnail',
					'medium_large',
					'modern-property-child-slider',
					'property-thumb-image',
					'property-detail-video-image',
					'partners-logo',
					'post-featured-image',
					'post-thumbnail'
				],
			]
		);
		$this->add_control(
			'rhea_sa_pre_title',
			[
				'label'   => esc_html__( 'Pre Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Real Estate Agent', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_sa_title',
			[
				'label'   => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Draco Freeman', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_sa_title_url',
			[
				'label'       => esc_html__( 'Title URL', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'rhea_sa_sub_title',
			[
				'label'   => esc_html__( 'Sub Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_sa_detail',
			[
				'label'   => esc_html__( 'Details', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Risus commodo viverra maecenas accumsan lacus
                    vel facilisis dummy contents over here. Sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Risus
                    commodo viverra maecenas.', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_sa_phone_label',
			[
				'label'   => esc_html__( 'Phone Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Phone', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_sa_phone',
			[
				'label'   => esc_html__( 'Phone Number', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '987 654 3210', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_control(
			'rhea_sa_email_label',
			[
				'label'   => esc_html__( 'Email Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Email', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_sa_email',
			[
				'label'   => esc_html__( 'Email ID', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'info@example.com', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_sa_button_text',
			[
				'label'   => esc_html__( 'Button Text', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Schedule an appointment', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_sa_button_url',
			[
				'label'       => esc_html__( 'Button URL', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_agents_section_settings',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'invert_columns',
			[
				'label'        => esc_html__( 'Invert Columns ? ', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);


		$this->add_control(
			'invert_mask_design',
			[
				'label'        => esc_html__( 'Invert Mask Design ? ', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'rhea_sa_align',
			[
				'label'   => esc_html__( 'Text Align', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'initial' => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'initial',
				'toggle'  => true,
			]
		);

		$this->add_control(
			'show_phone_email_icons',
			[
				'label'        => esc_html__( 'Show Phone/Email Icons', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'rhea_sa_icon_align',
			[
				'label'     => esc_html__( 'Invert Icon Position', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'left',
				'toggle'    => true,
				'condition' => [
					'show_phone_email_icons' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_image_mask',
			[
				'label'        => esc_html__( 'Show Image Mask', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'image_mask_design',
			[
				'label'     => esc_html__( 'Select Image Mask Design', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'1' => esc_html__( 'One', 'realhomes-elementor-addon' ),
					'2' => esc_html__( 'Two', 'realhomes-elementor-addon' ),
					'3' => esc_html__( 'Three', 'realhomes-elementor-addon' ),
				],
				'condition' => [
					'show_image_mask' => 'yes',
				],
			]
		);

		$this->add_control(
			'ere_agent_mask_color',
			[
				'label'       => esc_html__( 'Image Mask Color', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Mask color should be same as the container background color for proper mask effect', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .rhea_mask' => 'fill: {{VALUE}}',
				],
				'condition'   => [
					'show_image_mask' => 'yes',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_agents_section_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_pre_title_typography',
				'label'    => esc_html__( 'Pre Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_designation',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_title',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_sub_title_typography',
				'label'    => esc_html__( 'Sub Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_sub_title',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_phone_email_label_typography',
				'label'    => esc_html__( 'Phone/Email Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_label',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_phone_email_text_typography',
				'label'    => esc_html__( 'Phone/Email Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_contact',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_appointment_btn_typography',
				'label'    => esc_html__( 'Button Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_sa_button',
			]
		);

		$this->add_control(
			'important_note',
			[
				'label' => '',
				'type'  => \Elementor\Controls_Manager::RAW_HTML,
				'raw'   => __( 'Note: You can set typography of the Agent Detail paragraph from "Profile Content > Detail" WYSIWYG control. ', 'realhomes-elementor-addon' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_agents_sizes_spaces',
			[
				'label' => esc_html__( 'Sizes & Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_agent_thumb_size',
			[
				'label'       => esc_html__( 'Image Size (% for desktop , px for tablet/mobile)', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Text side will be increased/decreased with respect to image size', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],

				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '50',
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => '240',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '210',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_thumbnail_wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'agent_pre_title_margin_bottom',
			[
				'label'           => esc_html__( 'Pre Title Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_designation' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'agent_title_margin_bottom',
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
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'agent_sub_title_margin_bottom',
			[
				'label'           => esc_html__( 'Sub Title Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_sub_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'agent_detail_margin_bottom',
			[
				'label'           => esc_html__( 'Detail Container Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_detail' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'agent_phone_box_margin_bottom',
			[
				'label'           => esc_html__( 'Phone/Email Container Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_sa_phone_email_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'agent_phone_email_box_size',
			[
				'label'           => esc_html__( 'Phone/Email Icon Box Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '50',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '50',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '50',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'agent_phone_email_icon_size',
			[
				'label'           => esc_html__( 'Phone/Email Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '20',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '20',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '20',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_icon' => 'font-size: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();
		$this->start_controls_section(
			'ere_agents_colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'agent_pre_title',
			[
				'label'     => esc_html__( 'Pre Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_designation' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_title',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_title_hover',
			[
				'label'     => esc_html__( 'Title Hover', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'If "Title URL" is not empty in "Content" tab', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_title:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_sub_title',
			[
				'label'     => esc_html__( 'Sub Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_wrapper .rhea_sa_sub_title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_phone_email_icon_border_color',
			[
				'label'     => esc_html__( 'Icon Border ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_icon' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_phone_email_icon_color',
			[
				'label'     => esc_html__( 'Icon ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_phone_email_label_color',
			[
				'label'     => esc_html__( 'Phone/Email Label ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_phone_email_color',
			[
				'label'     => esc_html__( 'Phone/Email Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_contact' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_phone_email_hover_color',
			[
				'label'     => esc_html__( 'Phone/Email Text Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_phone_email_wrapper .rhea_sa_contact:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_button_color',
			[
				'label'     => esc_html__( 'Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_button_color_hover',
			[
				'label'     => esc_html__( 'Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_button:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_button_text_color',
			[
				'label'     => esc_html__( 'Button Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_button_text_color_hover',
			[
				'label'     => esc_html__( 'Button Text Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_sa_button:hover' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();


	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$agent_target            = ' ';
		$agent_nofollow          = ' ';
		$agent_custom_attributes = ' ';
		if ( ! empty( $settings['rhea_sa_button_url']['url'] ) && ! empty( $settings['rhea_sa_button_text'] ) ) {
			$agent_target            = $settings['rhea_sa_button_url']['is_external'] ? ' target="_blank"' : '';
			$agent_nofollow          = $settings['rhea_sa_button_url']['nofollow'] ? ' rel="nofollow"' : '';
			$agent_custom_attributes = $settings['rhea_sa_button_url']['custom_attributes'] ? $settings['rhea_sa_button_url']['custom_attributes'] : ' ';
		}

		$invert_column = '';
		if ( 'yes' == $settings['invert_columns'] ) {
			$invert_column = 'rhea_sa_invert_column';
		}
		$invert_mask_design = '';
		if ( 'yes' == $settings['invert_mask_design'] ) {
			$invert_mask_design = 'rhea_sa_invert_mask';
		}
		?>
        <div class="rhea_sa_wrapper <?php echo esc_attr( $invert_column ) . ' rhea_text_align_' . esc_attr( $settings['rhea_sa_align'] ); ?>">
            <div class="rhea_sa_thumbnail_wrapper">
                <div class="rhea_sa_thumbnail_box">
					<?php
					$html = '';
					if ( ! empty( $settings['image']['url'] ) ) {
						$this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
						$this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image'] ) );
						$this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $settings['image'] ) );
						$image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
						$html       .= '<div class="rhea_agent_figure">' . $image_html . '</div>';
						echo $html;
					}
					if(!empty($settings['image_mask_design'])) {
						?>
                        <div class="rhea_sa_svg_box <?php echo esc_attr( $invert_mask_design ); ?>">
							<?php include RHEA_ASSETS_DIR . '/images/agent-profile-mask-' . $settings['image_mask_design'] . '.svg'; ?>
                        </div>
						<?php
					}
                        ?>
                </div>
            </div>
            <div class="rhea_sa_detail_wrapper">
				<?php
				if ( ! empty( $settings['rhea_sa_pre_title'] ) ) {
					?>
                    <span class="rhea_sa_designation"><?php echo esc_html( $settings['rhea_sa_pre_title'] ) ?></span>
					<?php
				}
				if ( ! empty( $settings['rhea_sa_title'] ) ) {

					if ( ! empty( $settings['rhea_sa_title_url']['url'] ) && ! empty( $settings['rhea_sa_title_url'] ) ) {

						$agent_target            = $settings['rhea_sa_title_url']['is_external'] ? ' target="_blank"' : '';
						$agent_nofollow          = $settings['rhea_sa_title_url']['nofollow'] ? ' rel="nofollow"' : '';
						$agent_custom_attributes = $settings['rhea_sa_title_url']['custom_attributes'] ? $settings['rhea_sa_title_url']['custom_attributes'] : ' ';

						?>
                        <a class="rhea_sa_title" href="<?php echo esc_url( $settings['rhea_sa_title_url']['url'] ); ?>"
							<?php echo esc_attr( $agent_target ) . ' ' . esc_attr( $agent_nofollow ) . ' ' . esc_attr( $agent_custom_attributes ); ?>>
							<?php echo esc_html( $settings['rhea_sa_title'] ) ?>
                        </a>
						<?php
					} else {
						?>
                        <h3 class="rhea_sa_title">
							<?php
							echo esc_html( $settings['rhea_sa_title'] );
							?>
                        </h3>

						<?php

					}

				}
				if ( ! empty( $settings['rhea_sa_sub_title'] ) ) {
					?>
                    <p class="rhea_sa_sub_title"><?php echo esc_html( $settings['rhea_sa_sub_title'] ) ?></p>
					<?php
				}
				?>
                <div class="rhea_sa_detail_wrapper_lg_devices">
					<?php
					if ( ! empty( $settings['rhea_sa_detail'] ) ) {
						?>
                        <div class="rhea_sa_detail"><?php echo $settings['rhea_sa_detail']; ?></div>
						<?php
					}
					if ( ! empty( $settings['rhea_sa_phone'] ) || ! empty( $settings['rhea_sa_email'] ) ) {
						?>
                        <div class="rhea_sa_phone_email_wrapper rhea_sa_icon_align_<?php echo esc_attr( $settings['rhea_sa_icon_align'] ) ?>">

							<?php
							if ( ! empty( $settings['rhea_sa_phone'] ) ) {
								?>
                                <div class="rhea_sa_phone_box">
									<?php
									if ( 'yes' == $settings['show_phone_email_icons'] ) {
										?>
                                        <i class="rhea_sa_icon rhea_sa_phone fas fa-phone-alt"></i>
										<?php
									}
									?>
                                    <span class="rhea_sa_contact_wrapper rhea_sa_wrapper_phone">
                            <?php
                            if ( ! empty( $settings['rhea_sa_phone_label'] ) ) {
	                            ?>
                                <span class="rhea_sa_label rhea_sa_phone_label"><?php echo esc_html( $settings['rhea_sa_phone_label'] ) ?></span>
	                            <?php
                            }
                            ?>
                                        <a href="tel:<?php echo esc_html( $settings['rhea_sa_phone'] ); ?>"
                                           class="rhea_sa_contact rhea_sa_phone_number">
                                    <?php echo esc_html( $settings['rhea_sa_phone'] ) ?>
                                </a>
                        </span>
                                </div>
								<?php
							}
							if ( ! empty( $settings['rhea_sa_email'] ) ) {
								?>

                                <div class="rhea_sa_email_box">
									<?php
									if ( 'yes' == $settings['show_phone_email_icons'] ) {
										?>
                                        <i class="rhea_sa_icon rhea_sa_email fas fa-envelope"></i>
										<?php
									}
									?>
                                    <span class="rhea_sa_contact_wrapper rhea_sa_wrapper_email">
						<?php
						if ( ! empty( $settings['rhea_sa_email_label'] ) ) {
							?>
                            <span class="rhea_sa_label rhea_sa_email_label"><?php echo esc_html( $settings['rhea_sa_email_label'] ); ?></span>
							<?php
						}
						?>
                                        <a href="mailto:<?php echo esc_attr( antispambot( $settings['rhea_sa_email'] ) ); ?>"
                                           class="rhea_sa_contact rhea_sa_email_id">
                                <?php echo esc_html( antispambot( $settings['rhea_sa_email'] ) ) ?>
                                </a>
                             </span>
                                </div>
								<?php
							}
							?>

                        </div>
						<?php
					}
					if ( ! empty( $settings['rhea_sa_button_url']['url'] ) && ! empty( $settings['rhea_sa_button_text'] ) ) {
						?>
                        <a class="rhea_sa_button"
                           href="<?php echo esc_url( $settings['rhea_sa_button_url']['url'] ); ?>"
							<?php echo esc_attr( $agent_target ) . ' ' . esc_attr( $agent_nofollow ) . ' ' . esc_attr( $agent_custom_attributes ); ?>>
							<?php echo esc_html( $settings['rhea_sa_button_text'] ) ?>
                        </a>
						<?php
					}
					?>
                </div>
            </div>

            <div class="rhea_sa_detail_wrapper_sm_devices">
				<?php
				if ( ! empty( $settings['rhea_sa_detail'] ) ) {
					?>
                    <div class="rhea_sa_detail"><?php echo $settings['rhea_sa_detail']; ?></div>
					<?php
				}

				if ( ! empty( $settings['rhea_sa_phone'] ) || ! empty( $settings['rhea_sa_email'] ) ) {
					?>
                    <div class="rhea_sa_phone_email_wrapper rhea_sa_icon_align_<?php echo esc_attr( $settings['rhea_sa_icon_align'] ) ?>">

						<?php
						if ( ! empty( $settings['rhea_sa_phone'] ) ) {
							?>
                            <div class="rhea_sa_phone_box">
								<?php
								if ( 'yes' == $settings['show_phone_email_icons'] ) {
									?>
                                    <i class="rhea_sa_icon rhea_sa_phone fas fa-phone-alt"></i>
									<?php
								}
								?>
                                <span class="rhea_sa_contact_wrapper rhea_sa_wrapper_phone">
                            <?php
                            if ( ! empty( $settings['rhea_sa_phone_label'] ) ) {
	                            ?>
                                <span class="rhea_sa_label rhea_sa_phone_label"><?php echo esc_html( $settings['rhea_sa_phone_label'] ) ?></span>
	                            <?php
                            }
                            ?>
                                    <a href="tel:<?php echo esc_html( $settings['rhea_sa_phone'] ); ?>"
                                       class="rhea_sa_contact rhea_sa_phone_number">
                                    <?php echo esc_html( $settings['rhea_sa_phone'] ) ?>
                                </a>
                        </span>
                            </div>
							<?php
						}
						if ( ! empty( $settings['rhea_sa_email'] ) ) {
							?>

                            <div class="rhea_sa_email_box">
								<?php
								if ( 'yes' == $settings['show_phone_email_icons'] ) {
									?>
                                    <i class="rhea_sa_icon rhea_sa_email fas fa-envelope"></i>
									<?php
								}
								?>
                                <span class="rhea_sa_contact_wrapper rhea_sa_wrapper_email">
						<?php
						if ( ! empty( $settings['rhea_sa_email_label'] ) ) {
							?>
                            <span class="rhea_sa_label rhea_sa_email_label"><?php echo esc_html( $settings['rhea_sa_email_label'] ); ?></span>
							<?php
						}
						?>
                                    <a href="mailto:<?php echo esc_attr( antispambot( $settings['rhea_sa_email'] ) ); ?>"
                                       class="rhea_sa_contact rhea_sa_email_id">
                                <?php echo esc_html( antispambot( $settings['rhea_sa_email'] ) ) ?>
                                </a>
                             </span>
                            </div>
							<?php
						}
						?>

                    </div>
					<?php
				}

				if ( ! empty( $settings['rhea_sa_button_url']['url'] ) && ! empty( $settings['rhea_sa_button_text'] ) ) {
					?>
                    <a class="rhea_sa_button" href="<?php echo esc_url( $settings['rhea_sa_button_url']['url'] ); ?>"
						<?php echo esc_attr( $agent_target ) . ' ' . esc_attr( $agent_nofollow ) . ' ' . esc_attr( $agent_custom_attributes ); ?>>
						<?php echo esc_html( $settings['rhea_sa_button_text'] ) ?>
                    </a>
					<?php
				}

				?>
            </div>
        </div>
		<?php
	}
}