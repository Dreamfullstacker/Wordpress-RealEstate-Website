<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agent_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rhea-agent-widget';
	}

	public function get_title() {
		return esc_html__( 'Agent', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'agents_section',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$get_agents = array();
		$agent_ids  = get_posts( array(
			'fields'         => 'ids',
			'posts_per_page' => - 1,
			'post_type'      => 'agent'
		) );

		if ( ! empty( $agent_ids ) ) {
			foreach ( $agent_ids as $id ) {
				$get_agents["$id"] = get_the_title( $id );
			}
		}

		$this->add_control(
			'agent_info_type',
			[
				'label'   => esc_html__( 'Select Info Type', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'cpt',
				'options' => array(
					'cpt'    => esc_html__( 'Agent Post Type', 'realhomes-elementor-addon' ),
					'custom' => esc_html__( 'Custom Info', 'realhomes-elementor-addon' ),
				),
			]
		);

		$this->add_control(
			'select_agent',
			[
				'label'     => esc_html__( 'Select Agent', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'options'   => $get_agents,
				'condition' => [
					'agent_info_type' => 'cpt',
				],
			]
		);

		$this->add_control(
			'agent_image',
			[
				'label'       => __( 'Choose Agent Image', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended Image Size (600 x 600) " ', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition'   => [
					'agent_info_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'agent_title',
			[
				'label' => esc_html__( 'Agent Title', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'agent_url',
			[
				'label'         => esc_html__( 'Agent Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-agent-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'condition'     => [
					'agent_info_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'agent_designation',
			[
				'label'   => esc_html__( 'Designation', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Real Estate Agent', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'agent_excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length (Words)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 5,
				'max'       => 100,
				'default'   => 15,
				'condition' => [
					'agent_info_type' => 'cpt',
				],
			]
		);

		$this->add_control(
			'agent_excerpt',
			[
				'label' => esc_html__( 'Custom Excerpt', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'agent_phone',
			[
				'label'     => esc_html__( 'Agent Phone', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( '987-654-3210', 'realhomes-elementor-addon' ),
				'condition' => [
					'agent_info_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'agent_email',
			[
				'label'     => esc_html__( 'Agent Email', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'info@example.com', 'realhomes-elementor-addon' ),
				'condition' => [
					'agent_info_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'        => esc_html__( 'Show Excerpt', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_phone_number',
			[
				'label'        => esc_html__( 'Show Phone Number', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'agent_info_type' => 'cpt',
				],
			]
		);

		$this->add_control(
			'show_email_id',
			[
				'label'        => esc_html__( 'Show Email Address', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'agent_info_type' => 'cpt',
				],
			]
		);

		$this->add_control(
			'show_social_icons',
			[
				'label'        => esc_html__( 'Show Social Icons', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'agent_facebook',
			[
				'label'         => esc_html__( 'Facebook Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [
					'agent_info_type' => 'custom',
				],
			]
		);
		$this->add_control(
			'agent_twitter',
			[
				'label'         => esc_html__( 'Twitter Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [
					'agent_info_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'agent_linkedin',
			[
				'label'         => esc_html__( 'LinkedIn Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [
					'agent_info_type' => 'custom',
				],
			]
		);
		$this->add_control(
			'agent_instagram',
			[
				'label'         => esc_html__( 'Instagram Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [
					'agent_info_type' => 'custom',
				],
			]
		);
		$this->add_control(
			'agent_pinterest',
			[
				'label'         => esc_html__( 'Pinterest Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [
					'agent_info_type' => 'custom',
				],
			]
		);
		$this->add_control(
			'agent_youtube',
			[
				'label'         => esc_html__( 'Youtube Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [
					'agent_info_type' => 'custom',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'agent_styles_sizes',
			[
				'label' => esc_html__( 'Sizes And Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'widget_style',
			[
				'label'   => esc_html__( 'Preset Height Style', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => esc_html__( 'Style 1', 'realhomes-elementor-addon' ),
					'style-2' => esc_html__( 'Style 2 ', 'realhomes-elementor-addon' ),
					'style-3' => esc_html__( 'Style 3', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_responsive_control(
			'widget_height',
			[
				'label'     => esc_html__( 'Custom Height(px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 150,
						'max' => 600,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-agent-widget-wrapper' => 'height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'bg_agent_position',
			[
				'label'    => esc_html__( 'Background Position', 'realhomes-elementor-addon' ),
				'type'     => \Elementor\Controls_Manager::SELECT,
				'default'  => 'center center',
				'options'  => array(
					'center center' => esc_html__( 'Center Center', 'realhomes-elementor-addon' ),
					'center left'   => esc_html__( 'Center Left', 'realhomes-elementor-addon' ),
					'center right'  => esc_html__( 'Center Right', 'realhomes-elementor-addon' ),
					'top center'    => esc_html__( 'Top Center', 'realhomes-elementor-addon' ),
					'top left'      => esc_html__( 'Top Left', 'realhomes-elementor-addon' ),
					'top right'     => esc_html__( 'Top Right', 'realhomes-elementor-addon' ),
					'bottom center' => esc_html__( 'Bottom Center', 'realhomes-elementor-addon' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'realhomes-elementor-addon' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'realhomes-elementor-addon' ),
				),
				'selectors'  => [
					'{{WRAPPER}} .rhea-agent-widget-inner' => 'background-position: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'agent_title_padding',
			[
				'label'      => esc_html__( 'Title Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-agent-widget-head' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'agent_content_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-agent-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'agent_socials_padding',
			[
				'label'      => esc_html__( 'Social Icons Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-agent-socials' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);



		$this->add_responsive_control(
			'agent_title_spacings_bottom',
			[
				'label'   => esc_html__( 'Title Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],

				'selectors' => [
					'{{WRAPPER}} .rhea-agent-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);




		$this->add_responsive_control(
			'agent_horizontal_socials_spacings',
			[
				'label'       => esc_html__( 'Gap between Social Icons (px)', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'devices'     => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'   => [
					'{{WRAPPER}} .rhea-agent-socials' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'agent_social_icons_size',
			[
				'label'       => esc_html__( 'Social Icons Size (px)', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'     => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'   => [
					'{{WRAPPER}} .rhea-agent-socials li i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'agent_email_icon_size',
			[
				'label'       => esc_html__( 'Email Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'     => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'   => [
					'{{WRAPPER}} .rhea-agent-socials .rhea-agent-email i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'agent_phone_icon_size',
			[
				'label'       => esc_html__( 'Phone Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'     => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'   => [
					'{{WRAPPER}} .rhea-agent-socials .rhea-agent-phone i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);




		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-agent-title a, {{WRAPPER}} .rhea-agent-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_designation_typography',
				'label'    => esc_html__( 'Sub Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-agent-designation',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_excerpt_typography',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-agent-excerpt',
			]
		);



		$this->add_control(
			'agent_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-agent-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea-agent-title a'    => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_title_color_hover',
			[
				'label'     => esc_html__( 'Title Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-agent-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_designation_color',
			[
				'label'     => esc_html__( 'Subtitle', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-agent-designation' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_socials_color',
			[
				'label'     => esc_html__( 'Social Icons', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-agent-socials li a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_socials_hover_color',
			[
				'label'     => esc_html__( 'Social Icons Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-agent-socials li a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-agent-excerpt' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_phone_icon',
			[
				'label'     => esc_html__( 'Phone Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} li.rhea-agent-phone a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_phone_icon_hover',
			[
				'label'     => esc_html__( 'Phone Icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} li.rhea-agent-phone a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_email_icon',
			[
				'label'     => esc_html__( 'Email Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} li.rhea-agent-email a' => 'color: {{VALUE}}',
				],
			]
		);
				$this->add_control(
			'agent_email_icon_hover',
			[
				'label'     => esc_html__( 'Email Icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} li.rhea-agent-email a:hover' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'agent_title_bg_label',
			[
				'label' => esc_html__( 'Agent Title Background', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'agent_title_bg',
				'label' => esc_html__( 'Agent Title Background', 'realhomes-elementor-addon' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .rhea-agent-widget-head',
			]
		);

		$this->add_control(
			'agent_social_bg_label',
			[
				'label' => esc_html__( 'Social Icons Background', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'social_icons_bg',
				'label' => esc_html__( 'Social Icons Background', 'realhomes-elementor-addon' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .rhea-agent-socials',
			]
		);

		$this->add_control(
			'agent_overlay_label',
			[
				'label' => esc_html__( 'Overlay', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'agent_overlay_color',
				'label' => esc_html__( 'Overlay Color', 'realhomes-elementor-addon' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .rhea-agent-widget-overlay',
			]
		);

		$this->add_control(
			'agent_overlay_hover_label',
			[
				'label' => esc_html__( 'Overlay Hover', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'agent_overlay_hover_color',
				'label' => esc_html__( 'Overlay Hover Color', 'realhomes-elementor-addon' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .rhea-agent-widget-wrapper:hover .rhea-agent-widget-overlay',
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings          = $this->get_settings_for_display();
		$agent_title       = '';
		$agent_designation = $settings['agent_designation'];
		$agent_image       = '';
		$agent_link        = '';
		$agent_description = '';

		$widget_style = 'style-1';
		if ( isset( $settings['widget_style'] ) ) {
			$widget_style = $settings['widget_style'];
		}

		if ( 'cpt' == $settings['agent_info_type'] ) {
			$agent_id    = intval( $settings['select_agent'] );
			$agent_title = get_the_title( $agent_id );
			$agent_link  = get_the_permalink( $agent_id );

			if ( has_post_thumbnail( $agent_id ) ) {
				$agent_image = wp_get_attachment_image_url( get_post_thumbnail_id( $agent_id ), 'full' );
			}

			if ( ! empty( $settings['agent_excerpt'] ) ) {
				$agent_description = $settings['agent_excerpt'];
			} elseif ( ( $agent_id ) && ! empty( get_the_excerpt( $agent_id ) ) ) {
				$agent_description = rhea_get_framework_excerpt_by_id( $agent_id, $settings['agent_excerpt_length'] );
			}

		} else {
			if ( $settings['agent_title'] ) {
				$agent_title = $settings['agent_title'];
			}

			if ( $settings['agent_url']['url'] && ! empty( $settings['agent_url']['url'] ) ) {
				$agent_link              = $settings['agent_url']['url'];
				$agent_target            = $settings['agent_url']['is_external'] ? ' target="_blank"' : '';
				$agent_nofollow          = $settings['agent_url']['nofollow'] ? ' rel="nofollow"' : '';
				$agent_custom_attributes = $settings['agent_url']['custom_attributes'] ? $settings['agent_url']['custom_attributes'] : ' ';
				?>
                <a href="<?php echo esc_url( $agent_link ); ?>" <?php echo esc_attr( $agent_target ) . ' ' . esc_attr( $agent_nofollow ) . ' ' . esc_attr( $agent_custom_attributes ); ?>></a>
				<?php
			}

			if ( $settings['agent_image'] ) {
				$agent_image = wp_get_attachment_image_url( $settings['agent_image']['id'], 'full' );
			}

			if ( ! empty( $settings['agent_excerpt'] ) ) {
				$agent_description = $settings['agent_excerpt'];
			}
		}
		?>
        <div class="rhea-agent-widget-wrapper rhea-agent-style-1 rhea-agent-widget-<?php echo esc_attr( $widget_style ); ?>">
            <div class="rhea-agent-widget-inner" style="background-image: url('<?php echo esc_url( $agent_image ); ?>');">

            </div>
            <div class="rhea-agent-widget-overlay"></div>
                <div class="rhea-agent-widget-details">
                    <div class="rhea-agent-widget-head rhea-agent-content-padding">
		                <?php
		                if ( ! empty( $agent_title ) ) {
			                if ( ! empty( $agent_link ) ) {
				                ?>
                                <h3 class="rhea-agent-title"><a href="<?php echo esc_url( $agent_link ); ?>"><?php echo esc_html( $agent_title ); ?></a></h3>
				                <?php
			                } else {
				                ?>
                                <h3 class="rhea-agent-title"><?php echo esc_html( $agent_title ); ?></h3>
				                <?php
			                }
		                }

		                if ( ! empty( $agent_designation ) ) {
			                ?>
                            <span class="rhea-agent-designation"><?php echo esc_html( $agent_designation ); ?></span>
			                <?php
		                }
		                ?>
                    </div>
	                <?php
	                if ( ! empty( $agent_link ) ) {
		                ?>
                        <a class="rhea-agent-anchor-overlay" href="<?php echo esc_url( $agent_link ); ?>"></a>
		                <?php
	                }
	                ?>
                    <div class="rhea-agent-detail-social-box">
					<?php

					if ( 'yes' == $settings['show_excerpt'] && ! empty( $agent_description ) ) {
						?>
                        <p class="rhea-agent-excerpt rhea-agent-content-padding"><?php echo esc_html( $agent_description ); ?></p>
						<?php
					}

					if ( 'cpt' == $settings['agent_info_type'] ) {
						$this->agent_CPT( $settings );
					} else {
						$this->agent_custom( $settings );
					}
					?>
                    </div>
                </div>

        </div>

		<?php
	}

	protected function agent_CPT( $settings ) {



		if ( 'yes' !== $settings['show_social_icons'] && 'yes' !== $settings['show_phone_number'] && 'yes' !== $settings['show_email_id'] ) {
			return '';
		}

		$agent_id      = intval( $settings['select_agent'] );

		$facebook_url  = get_post_meta( $agent_id, 'REAL_HOMES_facebook_url', true );
		$twitter_url   = get_post_meta( $agent_id, 'REAL_HOMES_twitter_url', true );
		$linked_in_url = get_post_meta( $agent_id, 'REAL_HOMES_linked_in_url', true );
		$instagram_url = get_post_meta( $agent_id, 'inspiry_instagram_url', true );
		$pintrest_url  = get_post_meta( $agent_id, 'inspiry_pinterest_url', true );
		$youtube_url   = get_post_meta( $agent_id, 'inspiry_youtube_url', true );
		$agent_email   = get_post_meta( $agent_id, 'REAL_HOMES_agent_email', true );
		$agent_mobile  = get_post_meta( $agent_id, 'REAL_HOMES_mobile_number', true );

		?>
        <ul class="rhea-agent-socials rhea-agent-content-padding">
			<?php
			if ( 'yes' == $settings['show_social_icons']){

			if ( ! empty( $facebook_url ) ) {
				?>
                <li class="rhea-agent-social-link-facebook"><a target="_blank"
                                                               href="<?php echo esc_url( $facebook_url ); ?>"><i
                                class="fab fa-facebook fa-lg"></i></a></li>
				<?php
			}
			if ( ! empty( $twitter_url ) ) {
				?>
                <li class="rhea-agent-social-link-twitter"><a target="_blank"
                                                              href="<?php echo esc_url( $twitter_url ); ?>"><i
                                class="fab fa-twitter fa-lg"></i></a></li>
				<?php
			}
			if ( ! empty( $linked_in_url ) ) {
				?>
                <li class="rhea-agent-social-link-linkedin"><a target="_blank"
                                                               href="<?php echo esc_url( $linked_in_url ); ?>"><i
                                class="fab fa-linkedin fa-lg"></i></a></li>
				<?php
			}
			if ( ! empty( $instagram_url ) ) {
				?>
                <li class="rhea-agent-social-link-instagram"><a target="_blank"
                                                                href="<?php echo esc_url( $instagram_url ); ?>"><i
                                class="fab fa-instagram fa-lg"></i></a></li>
				<?php
			}
			if ( ! empty( $pintrest_url ) ) {
				?>
                <li class="rhea-agent-social-link-pinterest"><a target="_blank"
                                                                href="<?php echo esc_url( $pintrest_url ); ?>"><i
                                class="fab fa-pinterest fa-lg"></i></a></li>
				<?php
			}
			if ( ! empty( $youtube_url ) ) {
				?>
                <li class="rhea-agent-social-link-youtube"><a target="_blank"
                                                              href="<?php echo esc_url( $youtube_url ); ?>"><i
                                class="fab fa-youtube fa-lg"></i></a></li>
				<?php
			}
			}


			if ( 'yes' == $settings['show_email_id'] ) {
				if ( ! empty( $agent_email ) ) {
					?>
                    <li class="rhea-agent-email">
                        <a href="mailto:<?php echo esc_attr( antispambot( $agent_email ) ); ?>">
                            <i class="fas fa-envelope fa-lg"></i>
                        </a>
                    </li>
					<?php
				}
			}

			if ( 'yes' == $settings['show_phone_number'] ) {
				if ( ! empty( $agent_mobile ) ) {
					?>
                    <li class="rhea-agent-phone">
                        <a href="tel:<?php echo esc_html( $agent_mobile ); ?>"><i class="fas fa-phone fa-lg"></i></a>
                    </li>
					<?php
				}
			}


			?>
        </ul>
		<?php
	}

	protected function agent_custom( $settings ) {

		if ( 'yes' !== $settings['show_social_icons'] && 'yes' !== $settings['show_phone_number'] && 'yes' !== $settings['show_email_id'] ) {
			return '';
		}

		?>
        <ul class="rhea-agent-socials">
			<?php

			if ( 'yes' == $settings['show_social_icons']){

			if ( $settings['agent_facebook']['url'] ) {
				$agent_fb_target            = $settings['agent_facebook']['is_external'] ? ' target="_blank"' : '';
				$agent_fb_nofollow          = $settings['agent_facebook']['nofollow'] ? ' rel="nofollow"' : '';
				$agent_fb_custom_attributes = $settings['agent_facebook']['custom_attributes'] ? $settings['agent_facebook']['custom_attributes'] : ' ';
				?>
                <li class="rhea-agent-social-link-facebook">
                    <a target="_blank"
                       href="<?php echo esc_url( $settings['agent_facebook']['url'] ); ?>"
						<?php echo esc_attr( $agent_fb_target ) . ' ' . esc_attr( $agent_fb_nofollow ) . ' ' . esc_attr( $agent_fb_custom_attributes ); ?>>
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                </li>
				<?php
			}
			if ( $settings['agent_twitter']['url'] ) {
				$agent_twitter_target            = $settings['agent_twitter']['is_external'] ? ' target="_blank"' : '';
				$agent_twitter_nofollow          = $settings['agent_twitter']['nofollow'] ? ' rel="nofollow"' : '';
				$agent_twitter_custom_attributes = $settings['agent_twitter']['custom_attributes'] ? $settings['agent_twitter']['custom_attributes'] : ' ';
				?>
                <li class="rhea-agent-social-link-twitter">
                    <a target="_blank"
                       href="<?php echo esc_url( $settings['agent_twitter']['url'] ); ?>"
						<?php echo esc_attr( $agent_twitter_target ) . ' ' . esc_attr( $agent_twitter_nofollow ) . ' ' . esc_attr( $agent_twitter_custom_attributes ); ?>>
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                </li>
				<?php
			}
			if ( $settings['agent_linkedin']['url'] ) {
				$agent_in_target            = $settings['agent_linkedin']['is_external'] ? ' target="_blank"' : '';
				$agent_in_nofollow          = $settings['agent_linkedin']['nofollow'] ? ' rel="nofollow"' : '';
				$agent_in_custom_attributes = $settings['agent_linkedin']['custom_attributes'] ? $settings['agent_linkedin']['custom_attributes'] : ' ';
				?>
                <li class="rhea-agent-social-link-linkedin">
                    <a target="_blank"
                       href="<?php echo esc_url( $settings['agent_linkedin']['url'] ); ?>"
						<?php echo esc_attr( $agent_in_target ) . ' ' . esc_attr( $agent_in_nofollow ) . ' ' . esc_attr( $agent_in_custom_attributes ); ?>>
                        <i class="fab fa-linkedin fa-lg"></i>
                    </a>
                </li>
				<?php
			}
			if ( $settings['agent_instagram']['url'] ) {
				$agent_insta_target            = $settings['agent_instagram']['is_external'] ? ' target="_blank"' : '';
				$agent_insta_nofollow          = $settings['agent_instagram']['nofollow'] ? ' rel="nofollow"' : '';
				$agent_insta_custom_attributes = $settings['agent_instagram']['custom_attributes'] ? $settings['agent_instagram']['custom_attributes'] : ' ';
				?>
                <li class="rhea-agent-social-link-instagram">
                    <a target="_blank"
                       href="<?php echo esc_url( $settings['agent_instagram']['url'] ); ?>"
						<?php echo esc_attr( $agent_insta_target ) . ' ' . esc_attr( $agent_insta_nofollow ) . ' ' . esc_attr( $agent_insta_custom_attributes ); ?>>
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                </li>
				<?php
			}
			if ( $settings['agent_pinterest']['url'] ) {
				$agent_pi_target            = $settings['agent_pinterest']['is_external'] ? ' target="_blank"' : '';
				$agent_pi_nofollow          = $settings['agent_pinterest']['nofollow'] ? ' rel="nofollow"' : '';
				$agent_pi_custom_attributes = $settings['agent_pinterest']['custom_attributes'] ? $settings['agent_pinterest']['custom_attributes'] : ' ';
				?>
                <li class="rhea-agent-social-link-pinterest">
                    <a target="_blank"
                       href="<?php echo esc_url( $settings['agent_pinterest']['url'] ); ?>"
						<?php echo esc_attr( $agent_pi_target ) . ' ' . esc_attr( $agent_pi_nofollow ) . ' ' . esc_attr( $agent_pi_custom_attributes ); ?>>
                        <i class="fab fa-pinterest fa-lg"></i>
                    </a>
                </li>
				<?php
			}
			if ( $settings['agent_youtube']['url'] ) {
				$agent_yt_target            = $settings['agent_youtube']['is_external'] ? ' target="_blank"' : '';
				$agent_yt_nofollow          = $settings['agent_youtube']['nofollow'] ? ' rel="nofollow"' : '';
				$agent_yt_custom_attributes = $settings['agent_youtube']['custom_attributes'] ? $settings['agent_youtube']['custom_attributes'] : ' ';
				?>
                <li class="rhea-agent-social-link-youtube">
                    <a target="_blank"
                       href="<?php echo esc_url( $settings['agent_youtube']['url'] ); ?>"
						<?php echo esc_attr( $agent_yt_target ) . ' ' . esc_attr( $agent_yt_nofollow ) . ' ' . esc_attr( $agent_yt_custom_attributes ); ?>>
                        <i class="fab fa-youtube fa-lg"></i>
                    </a>
                </li>
				<?php
			}
            }
			if ( ! empty( $settings['agent_email'] ) ) {
				?>
                <li class="rhea-agent-email">
                    <a href="mailto:<?php echo esc_attr( antispambot( $settings['agent_email'] ) ); ?>">
                        <i class="fas fa-envelope fa-lg"></i>
                    </a>
                </li>
				<?php
			}

			if ( ! empty( $settings['agent_phone'] ) ) {
				?>
                <li class="rhea-agent-phone">
                    <a href="tel:<?php echo esc_attr( $settings['agent_phone'] ); ?>">
                        <i class="fas fa-phone fa-lg"></i>
                    </a>
                </li>
				<?php
			}

			?>
        </ul>
		<?php
	}
}

?>