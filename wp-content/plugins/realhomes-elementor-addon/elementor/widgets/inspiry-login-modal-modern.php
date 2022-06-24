<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Login_modal_modern extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rhea-login-modal-modern';
	}

	public function get_title() {
		return esc_html__( 'Login Modal', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-lock-user';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'rhea_login_modal_section',
			[
				'label' => esc_html__( 'Login Modal', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_login_modal_show',
			[
				'label'       => esc_html__( 'Show Drop Down (For backend only)', 'realhomes-elementor-addon' ),
				'description' => __( 'Caution! - This option is for backend only to make widget customization easy. Please make sure this option is set to "No" when you finish and UPDATE widget ', 'realhomes-elementor-addon' ),

				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => array(
					'yes' => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
					'no'  => esc_html__( 'No', 'realhomes-elementor-addon' ),
				),
			]
		);

		$this->add_control(
			'show_login_modal_avatar',
			[
				'label'        => esc_html__( 'Show Drop Down Avatar', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_login_modal_user_name',
			[
				'label'        => esc_html__( 'Show Username', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_login_modal_profile',
			[
				'label'        => esc_html__( 'Show Profile Link', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_login_modal_properties',
			[
				'label'        => esc_html__( 'Show My Properties Link', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_login_modal_favorites',
			[
				'label'        => esc_html__( 'Show My Favorites Link', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_login_modal_compare',
			[
				'label'        => esc_html__( 'Show Compare Link', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'rhea_login_modal_labels',
			[
				'label' => esc_html__( 'Labels', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_login_avatar_replace',
			[
				'label'       => esc_html__( 'Replace Avatar With Text?', 'realhomes-elementor-addon' ),
				'description' => __( 'It will replace Login Modal avatar with text when user is not logged in', 'realhomes-elementor-addon' ),

				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => array(
					'yes' => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
					'no'  => esc_html__( 'No', 'realhomes-elementor-addon' ),
				),
			]
		);

		$this->add_control(
			'rhea_login_modal_avatar_text',
			[
				'label'     => esc_html__( 'Login/Register', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Login/Register', 'realhomes-elementor-addon' ),
				'condition' => [
					'rhea_login_avatar_replace' => 'yes',
				],
			]
		);


		$this->add_control(
			'rhea_login_welcome_label',
			[
				'label'   => esc_html__( 'Welcome', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Welcome', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_login_profile_label',
			[
				'label'   => esc_html__( 'Profile', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Profile', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_login_my_properties_label',
			[
				'label'   => esc_html__( 'My Properties', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'My Properties', 'realhomes-elementor-addon' ),
			]
		);
		$this->add_control(
			'rhea_login_favorites_label',
			[
				'label'   => esc_html__( 'Favorites', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Favorites', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_login_compare_label',
			[
				'label'   => esc_html__( 'Compare', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Compare', 'realhomes-elementor-addon' ),
			]
		);

		if ( function_exists( 'IMS_Helper_Functions' ) ) {
			$this->add_control(
				'rhea_login_membership_label',
				[
					'label'   => esc_html__( 'Membership', 'realhomes-elementor-addon' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Membership', 'realhomes-elementor-addon' ),
				]
			);
		}

		$this->add_control(
			'rhea_log_out_label',
			[
				'label'   => esc_html__( 'Log Out', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Log Out', 'realhomes-elementor-addon' ),
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_login_modal_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'rhea_login_text_typography',
				'label'     => esc_html__( 'Login/Register', 'realhomes-elementor-addon' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .rhea_login_register_text',
				'condition' => [
					'rhea_login_avatar_replace' => 'yes',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_login_welcome_typography',
				'label'    => esc_html__( 'Welcome', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_user .rhea_user__details p',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_login_user_typography',
				'label'    => esc_html__( 'Welcome', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_user .rhea_user__details h3',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_login_nav_links_typography',
				'label'    => esc_html__( 'Nav Links', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link span',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_login_nav_links_hover_typography',
				'label'    => esc_html__( 'Nav Links Hover', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link:hover span',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_logout_typography',
				'label'    => esc_html__( 'Log Out', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link .rhea_logout_text',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'rhea_login_modal_add_more',
			[
				'label' => esc_html__( 'Add More Links', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();


		$repeater->add_control(
			'rhea_link_icon',
			[
				'label'   => esc_html__( 'Select Icon', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
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
					'{{WRAPPER}} {{CURRENT_ITEM}} i'                                                                                 => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_login_extended_link{{CURRENT_ITEM}} svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'rhea_link_text',
			[
				'label'       => esc_html__( 'Link Text', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Link Text', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'rhea_page_url',
			[
				'label'         => esc_html__( 'Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);


		$this->add_control(
			'rhea_login_add_more_repeater',
			[
				'label'       => '',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => ' {{{ rhea_link_text }}}',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'rhea_login_modal_styles',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rhea_login_modal_svg_icon_color',
			[
				'label'       => esc_html__( 'Avatar Icon', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'when user is not logged in', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .rhea_offline_avatar svg' => 'fill: {{VALUE}}',
				],
				'condition'   => [
					'rhea_login_avatar_replace' => 'no',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_svg_icon_color_hover',
			[
				'label'       => esc_html__( 'Avatar Icon Hover', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'when user is not logged in', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .rhea_offline_avatar:hover svg' => 'fill: {{VALUE}}',
				],
				'condition'   => [
					'rhea_login_avatar_replace' => 'no',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_text_color',
			[
				'label'       => esc_html__( 'Login/Register Text', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'when user is not logged in', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .rhea_login_register_text' => 'color: {{VALUE}}',
				],
				'condition'   => [
					'rhea_login_avatar_replace' => 'yes',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_text_color_hover',
			[
				'label'       => esc_html__( 'Login/Register Text Hover', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'when user is not logged in', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .rhea_login_register_text:hover' => 'color: {{VALUE}}',
				],
				'condition'   => [
					'rhea_login_avatar_replace' => 'yes',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_bg_color',
			[
				'label'     => esc_html__( 'Drop Down Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap'                             => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_menu_position_right .rhea_modal .rhea_modal__corner' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_menu_position_left .rhea_modal .rhea_modal__corner'  => 'border-left-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_welcome_color',
			[
				'label'     => esc_html__( 'Welcome', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_user .rhea_user__details p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_admin_color',
			[
				'label'     => esc_html__( 'Admin', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_user .rhea_user__details h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_nav_link_color',
			[
				'label'     => esc_html__( 'User Nav Links', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_nav_link_hover_color',
			[
				'label'     => esc_html__( 'User Nav Links Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link:hover span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link i'   => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_login_modal_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color On Link Hover ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link:hover svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link:hover i'   => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_login_modal_sizes',
			[
				'label' => esc_html__( 'Sizes & Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'rhea_login_avatar_margin',
			[
				'label'      => esc_html__( 'Avatar Margin', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_menu__user_profile' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_login_avatar_size',
			[
				'label'           => esc_html__( 'Avatar Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_online_avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->add_responsive_control(
			'rhea_login_avatar_border_radius',
			[
				'label'           => esc_html__( 'Avatar Border Radius (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_online_avatar' => 'border-radius: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_login_dropdown_size',
			[
				'label'           => esc_html__( 'Drop Down Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_modal' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_login_dropdown_padding',
			[
				'label'      => esc_html__( 'Drop Down Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_login_dropdown_avatar_size',
			[
				'label'           => esc_html__( 'Drop Down Avatar Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_user .rhea_user__avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_login_dropdown_avatar_border-radius',
			[
				'label'           => esc_html__( 'Drop Down Avatar Border Radius (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_user .rhea_user__avatar' => 'border-radius: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_login_user_avatar_padding_bottom',
			[
				'label'           => esc_html__( 'Drop Down Avatar Padding Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_user' => 'padding-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_login_link_icons_width',
			[
				'label'           => esc_html__( 'Icon Width (px)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Note: Icon size for custom links will be set from Content -> Add More Links', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link svg' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_login_link_margin_bottom',
			[
				'label'           => esc_html__( 'Link Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link'              => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_modal .rhea_modal__wrap .rhea_modal__dashboard .rhea_modal__dash_link:last-of-type' => 'margin-bottom: 0;',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_login_modal_positions',
			[
				'label' => esc_html__( 'Drop Down Positions', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rhea_login_modal_position',
			[
				'label'   => esc_html__( 'Drop Down Position', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'right' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
					'left'  => esc_html__( 'Left', 'realhomes-elementor-addon' ),
				),
			]
		);

		$this->add_responsive_control(
			'rhea_dropdown_position_from_right',
			[
				'label'           => esc_html__( 'Position From Right', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_menu_position_right .rhea_modal' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition'       => [
					'rhea_login_modal_position' => 'right',
				],
			]
		);


		$this->add_responsive_control(
			'rhea_dropdown_position_from_left',
			[
				'label'           => esc_html__( 'Position From Left', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_menu_position_left .rhea_modal' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition'       => [
					'rhea_login_modal_position' => 'left',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_dropdown_position_from_top',
			[
				'label'           => esc_html__( 'Position From Top', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_menu__user_profile .rhea_modal' => 'top: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'rhea_dropdown_position_from_top_hover',
			[
				'label'           => esc_html__( 'Position From Top On Hover', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_menu__user_profile:hover .rhea_modal' => 'top: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_dropdown_box_shadow',
			[
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'rhea_avatar_box_shadow',
				'label'    => esc_html__( 'Avatar Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea_online_avatar',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'rhea_avatar_box_shadow_hover',
				'label'    => esc_html__( 'Avatar Box Shadow On Hover', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea_online_avatar:hover',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'rhea_drop_down_box_shadow',
				'label'    => esc_html__( 'Drop Down Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea_modal .rhea_modal__wrap',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		global $settings;
		$settings = $this->get_settings_for_display();

		$rhea_login_modal_show = '';
		if ( 'yes' == $settings['rhea_login_modal_show'] ) {
			$rhea_login_modal_show = ' rhea_login_modal_show ';
		}


		$enable_user_nav = get_option( 'theme_enable_user_nav' );

		if ( ! empty( $enable_user_nav ) && 'true' === $enable_user_nav ) {

			$theme_login_url   = inspiry_get_login_register_url(); // login and register page URL
			$prop_detail_login = inspiry_prop_detail_login();
			$skip_prop_single  = ( 'yes' == $prop_detail_login && ! is_user_logged_in() && is_singular( 'property' ) );

			if ( is_user_logged_in() ) {
				?>
                <div class="rhea_menu__user_profile rhea_menu_position_<?php echo esc_attr( $settings['rhea_login_modal_position'] . $rhea_login_modal_show ); ?>">
					<?php
					// Get user information.
					$current_user      = wp_get_current_user();
					$current_user_meta = get_user_meta( $current_user->ID );

					?>
                    <div class="rhea_online_avatar">
						<?php
						if ( isset( $current_user_meta['profile_image_id'][0] ) ) {
							echo wp_get_attachment_image( $current_user_meta['profile_image_id'][0], array(
								'38',
								'38'
							), "", array( "class" => "rh_user_profile_img" ) );
						} else {
							echo get_avatar(
								$current_user->user_email,
								'150',
								'gravatar_default',
								$current_user->display_name,
								array(
									'class' => 'user-icon',
								)
							);
						}

						?>
                    </div>
					<?php
					// modal login.
					rhea_get_template_part( 'assets/partials/modal' );

					?>
                </div><!-- /.rh_menu__user_profile -->
				<?php
			} elseif (
				empty( $theme_login_url ) &&
				( ! is_user_logged_in() ) &&
				! $skip_prop_single ) {
				?>
                <div class="rhea_menu__user_profile rhea_offline_avatar">
					<?php
					if ( 'yes' == $settings['rhea_login_avatar_replace'] && ! empty( $settings['rhea_login_modal_avatar_text'] ) ) {
						?>
                        <span class="rhea_login_register_text">
                        <?php echo esc_html( $settings['rhea_login_modal_avatar_text'] ); ?>
                        </span>
						<?php
					} else {
						include RHEA_ASSETS_DIR . '/icons/icon-profile.svg';
					}
					?>
                </div><!-- /.rh_menu__user_profile -->
				<?php
			} elseif ( ! empty( $theme_login_url ) && ( ! is_user_logged_in() ) ) {
				?>
                <a class="rhea_menu__user_profile rhea_offline_avatar"
                   href="<?php echo esc_url( $theme_login_url ); ?>">
					<?php
					if ( 'yes' == $settings['rhea_login_avatar_replace'] && ! empty( $settings['rhea_login_modal_avatar_text'] ) ) {
						?>
                        <span class="rhea_login_register_text">
                        <?php echo esc_html( $settings['rhea_login_modal_avatar_text'] ); ?>
                        </span>
						<?php
					} else {
						include RHEA_ASSETS_DIR . '/icons/icon-profile.svg';
					}
					?>
                </a><!-- /.rh_menu__user_profile -->
				<?php
			}

		}


	}

}