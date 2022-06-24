<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agents_Two_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-agents-widget-2';
	}

	public function get_title() {
		return esc_html__( 'Agents Grid Two', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {


		$this->start_controls_section(
			'ere_agents_section',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'rhea_property_grid_layout',
			[
				'label'       => esc_html__( 'Layout', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Number of columns will be reduced automatically if parent container has insufficient width.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'rhea_col_3',
				'options'     => array(
					'rhea_col_5' => esc_html__( '5 Columns', 'realhomes-elementor-addon' ),
					'rhea_col_4' => esc_html__( '4 Columns', 'realhomes-elementor-addon' ),
					'rhea_col_3' => esc_html__( '3 Columns', 'realhomes-elementor-addon' ),
					'rhea_col_2' => esc_html__( '2 Columns', 'realhomes-elementor-addon' ),
					'rhea_col_1' => esc_html__( '1 Column', 'realhomes-elementor-addon' ),
				),
			]
		);


		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_add_agents_section',
			[
				'label' => esc_html__( 'Add Agents', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$all_post_ids = get_posts( array(
			'fields'         => 'ids',
			'posts_per_page' => -1,
			'post_type'      => 'agent'
		) );

		$get_agents = array();
		foreach ( $all_post_ids as $rhea_id ) {
			$get_agents["$rhea_id"] = get_the_title( $rhea_id );
		}


		$agents_repeater = new \Elementor\Repeater();

		$agents_repeater->add_control(
			'rhea_select_cpt',
			[
				'label'   => esc_html__( 'Add Agent Through', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'cpt',
				'options' => array(
					'cpt'    => esc_html__( 'Agent Post Type', 'realhomes-elementor-addon' ),
					'custom' => esc_html__( 'Custom Info', 'realhomes-elementor-addon' ),
				),
			]
		);


		$agents_repeater->add_control(
			'rhea_select_agent',
			[
				'label'     => esc_html__( 'Select Agent', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'options'   => $get_agents,
				'condition' => [
					'rhea_select_cpt' => 'cpt',
				],
			]
		);

		$agents_repeater->add_control(
			'rhea_agent_image',
			[
				'label'       => __( 'Choose Agent Image', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended Image Size (210 x 210) " ', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition'   => [
					'rhea_select_cpt' => 'custom',
				],
			]
		);

		$agents_repeater->add_control(
			'rhea_agent_title',
			[
				'label'       => esc_html__( 'Agent Title', 'realhomes-elementor-addon' ),
				'placeholder' => esc_html__( 'Agent Title', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'It is recommended to add an agent title. If agent is being added through "Agent Post Type, Agent Title will be displayed only as sorting control label " ', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
			]

		);

		$agents_repeater->add_control(
			'rhea_agent_url',
			[
				'label'         => esc_html__( 'URL For Agent Image And Title', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-agent-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'condition'     => [
					'rhea_select_cpt' => 'custom',
				],
			]
		);

		$agents_repeater->add_control(
			'rhea_agent_sub_title',
			[
				'label'   => esc_html__( 'Agent Subtitle', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Real Estate Agent', 'realhomes-elementor-addon' ),
			]
		);


		$agents_repeater->add_control(
			'rhea_agent_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'You can also override excerpt text if Agent is added through "Agent Post Type" " ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXTAREA,

			]
		);


		$agents_repeater->add_control(
			'rhea_agent_phone',
			[
				'label'     => esc_html__( 'Agent Phone', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( '987-654-3210', 'realhomes-elementor-addon' ),
				'condition' => [
					'rhea_select_cpt' => 'custom',
				],
			]
		);

		$agents_repeater->add_control(
			'rhea_agent_email',
			[
				'label'     => esc_html__( 'Agent Email', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'info@example.com', 'realhomes-elementor-addon' ),
				'condition' => [
					'rhea_select_cpt' => 'custom',
				],
			]
		);


		$agents_repeater->add_control(
			'show_social_icons',
			[
				'label'        => esc_html__( 'Show Social Icons', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'rhea_select_cpt' => 'cpt',
				],
			]
		);

		$agents_repeater->add_control(
			'show_excerpt',
			[
				'label'        => esc_html__( 'Show Excerpt', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'rhea_select_cpt' => 'cpt',
				],
			]
		);
		$agents_repeater->add_control(
			'excerpt_length',
			[
				'label'        => esc_html__( 'Excerpt Length', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'For Agent Post Type Only', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'      => 15,
				'condition'    => [
					'rhea_select_cpt' => 'cpt',
					'show_excerpt' => 'yes',
				],
			]
		);

		$agents_repeater->add_control(
			'show_phone_number',
			[
				'label'        => esc_html__( 'Display Phone Number', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'rhea_select_cpt' => 'cpt',
				],
			]
		);

		$agents_repeater->add_control(
			'show_email_id',
			[
				'label'        => esc_html__( 'Display Email Address', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'rhea_select_cpt' => 'cpt',
				],
			]
		);


		$agents_repeater->add_control(
			'rhea_agent_facebook',
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
					'rhea_select_cpt' => 'custom',
				],
			]
		);
		$agents_repeater->add_control(
			'rhea_agent_twitter',
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
					'rhea_select_cpt' => 'custom',
				],
			]
		);

		$agents_repeater->add_control(
			'rhea_agent_linkedin',
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
					'rhea_select_cpt' => 'custom',
				],
			]
		);
		$agents_repeater->add_control(
			'rhea_agent_instagram',
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
					'rhea_select_cpt' => 'custom',
				],
			]
		);
		$agents_repeater->add_control(
			'rhea_agent_pinterest',
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
					'rhea_select_cpt' => 'custom',
				],
			]
		);
		$agents_repeater->add_control(
			'rhea_agent_youtube',
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
					'rhea_select_cpt' => 'custom',
				],
			]
		);


		$this->add_control(
			'rhea_agent',
			[
				'label'       => esc_html__( 'Add Agent', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $agents_repeater->get_controls(),
				'title_field' => ' {{{rhea_agent_title}}}',

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
				'name'     => 'agent_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_title a,{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_title span',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_sub_title_typography',
				'label'    => esc_html__( 'Sub Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_agent_designation',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_excerpt_typography',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_excerpt',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_phone_typography',
				'label'    => esc_html__( 'Phone Number', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhe_agent_two_phone a',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_email_typography',
				'label'    => esc_html__( 'Email Address', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_agent_two_email a',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'ere_agent_styles_sizes',
			[
				'label' => esc_html__( 'Sizes And Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'ere_agent_card_padding',
			[
				'label'      => esc_html__( 'Agent Card Inner Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_thumb_size',
			[
				'label'           => esc_html__( 'Thumbnail Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_thumbnail span' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_thumbnail a'    => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_thumb_radius',
			[
				'label'      => esc_html__( 'Thumbnail Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_thumbnail span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_thumbnail a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_agent_thumb_margin_bottom',
			[
				'label'           => esc_html__( 'Thumbnail Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_thumbnail span' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_thumbnail a'    => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_title_spacings_bottom',
			[
				'label'           => esc_html__( 'Title Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],

				'selectors'       => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_subtitle_spacings',
			[
				'label'           => esc_html__( 'Subtitle Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],

				'selectors'       => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_designation' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_socials_spacings',
			[
				'label'           => esc_html__( 'Social Icons Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],

				'selectors'       => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_socials' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_horizontal_socials_spacings',
			[
				'label'           => esc_html__( 'Social Icons Horizontal Margin (px)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'This will apply margin-left and margin-right to each icon', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 15,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_socials li' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_agent_excerpt_margin_bottom',
			[
				'label'           => esc_html__( 'Excerpt Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'ere_agent_phone_margin_bottom',
			[
				'label'           => esc_html__( 'Phone Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhe_agent_two_phone' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'ere_agent_styles',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'ere_agent_bg_color',
			[
				'label'     => esc_html__( 'Agent Card Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_wrap' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_bg_color_hover',
			[
				'label'     => esc_html__( 'Agent Card Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_wrap:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_title span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_title a'    => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_agent_title_color_hover',
			[
				'label'     => esc_html__( 'Title Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_agent_sub_title_color',
			[
				'label'     => esc_html__( 'Subtitle', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_designation' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_agent_socials_color',
			[
				'label'     => esc_html__( 'Social Icons', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_socials li a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_agent_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two .rhea_agent_two_excerpt' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_agent_phone_icon',
			[
				'label'     => esc_html__( 'Phone Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhe_agent_two_phone i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_phone_number',
			[
				'label'     => esc_html__( 'Phone Number', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhe_agent_two_phone a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_agent_phone_number_hover',
			[
				'label'     => esc_html__( 'Phone Number Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhe_agent_two_phone a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_email_icon',
			[
				'label'     => esc_html__( 'Email Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_agent_two_email i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_email_id',
			[
				'label'     => esc_html__( 'Email ID', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_agent_two_email a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_agent_email_id_hover',
			[
				'label'     => esc_html__( 'Email ID Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_agent_two_email a:hover' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_agent_box_shadow',
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
				'selector' => '{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_wrap',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow_hover',
				'label'    => esc_html__( 'Box Shadow On Hover', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea_section__agents_two .rhea_agent_two_wrap:hover',
			]
		);


		$this->end_controls_section();

	}

	protected function render() {
		global $settings;
		$settings = $this->get_settings_for_display();

		$repeater_agents = $settings['rhea_agent'];

		if ( $repeater_agents ) {


			?>
            <div class="rhea_wrapper_agents_two">

                <div class="rhea_section__agents_two <?php echo esc_attr( $settings['rhea_property_grid_layout'] ) ?>">
					<?php
					foreach ( $repeater_agents as $agents ) {
						global $agent;
						$agent = $agents;
						if ( 'cpt' == $agent['rhea_select_cpt'] ) {
							rhea_get_template_part( 'assets/partials/Agent-2/agent-card-cpt' );
						} else {
							rhea_get_template_part( 'assets/partials/Agent-2/agent-card-custom' );
						}
					}
					?>
                </div>


            </div>
			<?php
		}

	}

}