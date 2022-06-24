<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Single_Property_Slider_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'rhea-single-property-slider-widget';
	}

	public function get_title() {
		return esc_html__( 'Single Property Slider', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'slider_section',
			[
				'label' => esc_html__( 'Add Slides', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slider_images',
			[
				'label' => esc_html__( 'Add Images', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::GALLERY,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude'   => [ 'custom' ],
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'slider_full_screen',
			[
				'label' => __( 'Slider Full Screen', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'realhomes-elementor-addon' ),
				'label_off' => __( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'property_video_section',
			[
				'label' => esc_html__( 'Property Video', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'video_horizontal_align',
			[
				'label'   => esc_html__( 'Horizontal Align', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
					'right'   => esc_html__( 'Right', 'realhomes-elementor-addon' ),
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'property_video_sub_heading',
			[
				'label'       => esc_html__( 'Sub Heading', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Watch', 'realhomes-elementor-addon' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'property_video_heading',
			[
				'label'       => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Property Video', 'realhomes-elementor-addon' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'property_video_url',
			[
				'label'       => esc_html__( 'Video URL', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'property_details_section',
			[
				'label' => esc_html__( 'Property Details', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'vertical_align',
			[
				'label'   => esc_html__( 'Vertical Align', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-end',
				'options' => [
					'flex-start' => esc_html__( 'Top', 'realhomes-elementor-addon' ),
					'center'     => esc_html__( 'Middle', 'realhomes-elementor-addon' ),
					'flex-end'   => esc_html__( 'Bottom', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'horizontal_align',
			[
				'label'   => esc_html__( 'Horizontal Align', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-end',
				'options' => [
					'flex-start' => esc_html__( 'Start', 'realhomes-elementor-addon' ),
					'center'     => esc_html__( 'Center', 'realhomes-elementor-addon' ),
					'flex-end'   => esc_html__( 'End', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_responsive_control(
			'border-radius-value',
			[
				'label'     => esc_html__( 'Border Radius Value', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
					'size' => 10,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--rhea-single-property-content-border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'property_title',
			[
				'label'       => esc_html__( 'Property Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Anastasia Avenue, Coral Gables',
				'label_block' => true
			]
		);

		$this->add_control(
			'property_description',
			[
				'label'   => esc_html__( 'Property Description', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
			]
		);

		$this->add_control(
			'property_price',
			[
				'label'   => esc_html__( 'Property Price', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '$625,000',
			]
		);

		$this->add_control(
			'property_status',
			[
				'label'   => esc_html__( 'Property Status', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'for-sale',
				'options' => [
					'for-sale'    => esc_html__( 'For Sale', 'realhomes-elementor-addon' ),
					'for-rent'    => esc_html__( 'For Rent', 'realhomes-elementor-addon' ),
					'custom-icon' => esc_html__( 'Custom Icon', 'realhomes-elementor-addon' ),
					'custom-text' => esc_html__( 'Custom Text', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label'   => esc_html__( 'Select Icon Type', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => array(
					'icon'  => esc_html__( 'SVG', 'realhomes-elementor-addon' ),
					'image' => esc_html__( 'Image', 'realhomes-elementor-addon' ),
				),
				'condition' => [
					'property_status' => 'custom-icon',
				],
			]
		);

		$this->add_control(
			'property_status_custom_icon',
			[
				'label'     => esc_html__( 'Status Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'skin'      => 'inline',
				'exclude_inline_options' => ['icon'],
				'condition' => [
					'property_status' => 'custom-icon',
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'property_status_custom_image',
			[
				'label'     => esc_html__( 'Choose Image', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'property_status' => 'custom-icon',
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'custom_dimension',
			[
				'label'       => esc_html__( 'Image Dimension', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
				'description' => __( 'Crop the original image to any custom size. Set custom width or height to keep the original size ratio.', 'realhomes-elementor-addon' ),
				'default'     => [
					'width'  => '100',
					'height' => '100',
				],
				'condition'   => [
					'property_status' => 'custom-icon',
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'property_status_custom_text',
			[
				'label'     => esc_html__( 'Status Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'property_status' => 'custom-text',
				],
			]
		);

		$this->add_control(
			'property_address',
			[
				'label'   => esc_html__( 'Property Address', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Merrick Way, Miami, FL 33134, USA',
			]
		);

		$this->add_control(
			'cta_button_text',
			[
				'label'       => esc_html__( 'Call To Action Button Text', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Schedule a Tour',
			]
		);

		$this->add_control(
			'cta_url',
			[
				'label'         => esc_html__( 'Call To Action Button URL', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => 'https://your-link.com',
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'property_meta_info_section',
			[
				'label' => esc_html__( 'Property Meta', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_property_meta',
			[
				'label' => __( 'Show', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'realhomes-elementor-addon' ),
				'label_off' => __( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'bedrooms_label',
			[
				'label'   => esc_html__( 'Label for Bedrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'bedrooms',
			[
				'label'   => esc_html__( 'Number of Bedrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '4',
			]
		);

		$this->add_control(
			'bathrooms_label',
			[
				'label'   => esc_html__( 'Label for Bathrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'bathrooms',
			[
				'label'   => esc_html__( 'Number of Bathrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '2',
			]
		);

		$this->add_control(
			'area_label',
			[
				'label'   => esc_html__( 'Label for Area', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Area', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'area',
			[
				'label'   => esc_html__( 'Property Area', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '1800',
			]
		);

		$this->add_control(
			'area_unit',
			[
				'label'   => esc_html__( 'Area Unit', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Sq ft',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'property_typography_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_video_heading_typography',
				'label'    => esc_html__( 'Video Heading', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-video-heading',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_video_sub_heading_typography',
				'label'    => esc_html__( 'Video Sub Heading', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-video-sub-heading',
			]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_status_typography',
				'label'    => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-status span',
				'condition' => [
					'property_status' => 'custom',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_address_typography',
				'label'    => esc_html__( 'Address', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-address-text',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_description_typography',
				'label'    => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-description',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_price_typography',
				'label'    => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-price',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_cta_button_typography',
				'label'    => esc_html__( 'Call to Action Button', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-cta-button',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_meta_value_typography',
				'label'    => esc_html__( 'Meta Value', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-meta-value',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_area_postfix_typography',
				'label'    => esc_html__( 'Area Unit', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-meta-item .label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'spaces_section',
			[
				'label' => esc_html__( 'Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_area_padding',
			[
				'label'      => esc_html__( 'Content Box Padding', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rhea-single-property-content' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'address_margin_bottom',
			[
				'label'           => esc_html__( 'Address Margin Bottom', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-single-property-address' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'title_margin_bottom',
			[
				'label'           => esc_html__( 'Title Margin Bottom', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-single-property-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'description_margin_bottom',
			[
				'label'           => esc_html__( 'Description Margin Bottom', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-single-property-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'property_status_top_position',
			[
				'label'           => esc_html__( 'Status Top Position', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-single-property-status' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$side = ( is_rtl() ? 'left' : 'right' );
		$this->add_responsive_control(
			'property_status_side_position',
			[
				'label'           => esc_html__( 'Status Side Position', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-single-property-status' => $side .': {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-single-property-content-inner' => 'padding-' . $side . ': calc( {{SIZE}}{{UNIT}} + 45px );',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'colors_section',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'slider_nav_button_color',
			[
				'label'     => esc_html__( 'Slider Nav Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-slider-nav a svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slider_nav_button_hover_color',
			[
				'label'     => esc_html__( 'Slider Nav Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-slider-nav a:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slider_nav_button_bg',
			[
				'label'     => esc_html__( 'Slider Nav Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-slider-nav a' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slider_nav_button_hover_bg',
			[
				'label'     => esc_html__( 'Slider Nav Hover Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-slider-nav a:hover' => 'background-color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);


		$this->add_control(
			'video_heading_color',
			[
				'label'     => esc_html__( 'Video Heading', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-video-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'video_sub_heading_color',
			[
				'label'     => esc_html__( 'Video Sub Heading', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-video-sub-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'video_play_color',
			[
				'label'     => esc_html__( 'Video Play Button', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-slider-video-icon path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'video_play_hover_color',
			[
				'label'     => esc_html__( 'Video Play Button Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-slider-video-icon:hover path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_wrapper_background',
			[
				'label'     => esc_html__( 'Content Wrapper Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-content-wrap' => 'background-color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'property_status_color',
			[
				'label'     => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-status svg'  => 'fill: {{VALUE}}',
					'{{WRAPPER}} .rhea-single-property-status span'  => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_status_bg_color',
			[
				'label'     => esc_html__( 'Status Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-status span'  => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'property_status' => 'custom-text',
				],
			]
		);

		$this->add_control(
			'property_address_color',
			[
				'label'     => esc_html__( 'Address', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-address-text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea-single-property-address svg'  => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_description_color',
			[
				'label'     => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_price_color',
			[
				'label'     => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_cta_button_color',
			[
				'label'     => esc_html__( 'CTA Button Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-cta-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_cta_button_hover_color',
			[
				'label'     => esc_html__( 'CTA Button Text Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-cta-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_cta_button_bg',
			[
				'label'     => esc_html__( 'CTA Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-cta-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_cta_button_hover_bg',
			[
				'label'     => esc_html__( 'CTA Button Hover Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-cta-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_meta_border_color',
			[
				'label'     => esc_html__( 'Meta Wrapper Border', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-meta'      => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .rhea-single-property-meta-item' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'property_meta_icon_color',
			[
				'label'     => esc_html__( 'Meta Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-meta-item svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_meta_icon_hover_color',
			[
				'label'     => esc_html__( 'Meta Icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-meta-item:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_meta_title_color',
			[
				'label'     => esc_html__( 'Meta Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-meta-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_meta_title_bg_color',
			[
				'label'     => esc_html__( 'Meta Title Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-meta-title:before' => 'border-left-color: {{VALUE}};',
					'{{WRAPPER}} .rhea-single-property-meta-title'        => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_meta_value_color',
			[
				'label'     => esc_html__( 'Meta Value', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-meta-value' => 'color: {{VALUE}};',
					'[data-elementor-device-mode="mobile"] {{WRAPPER}} .rhea-single-property-meta-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_meta_value_label_color',
			[
				'label'     => esc_html__( 'Area Unit', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-meta-item .label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = $this->get_id();
		$slides_container_class = 'rhea-single-property-slide';

		if( 'yes' === $settings['slider_full_screen'] ){
			$slides_container_class .= ' rhea-single-property-full-screen';
        }
		?>
        <section id="rhea-single-property-slider-wrapper-<?php echo esc_attr( $widget_id ); ?>" class="rhea-single-property-slider-wrapper">

            <div id="rhea-single-property-slider-<?php echo esc_attr( $widget_id ); ?>" class="rhea-single-property-slider flexslider loading">
                <ul class="slides">
					<?php
					foreach ( $settings['slider_images'] as $slider_image ) {
						$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $slider_image['id'], 'thumbnail', $settings );
						echo '<li><div class="' . esc_html( $slides_container_class ) . '" style="background-image: url(' . esc_url( $image_url ) . ');"></div></li>';
					}
					?>
                </ul>
            </div>

            <div id="rhea-single-property-slider-nav-<?php echo esc_attr( $widget_id ); ?>" class="rhea-single-property-slider-nav">
                <a href="#" class="flex-prev nav-buttons"><?php rhea_safe_include_svg( 'icons/thin-arrow.svg' ); ?></a>
                <a href="#" class="flex-next nav-buttons"><?php rhea_safe_include_svg( 'icons/thin-arrow.svg' ); ?></a>
            </div>

            <?php
            $content_box_classes = array( 'rhea-single-property-slider-inner-wrapper' );

            // Vertical alignment class.
            if ( 'flex-start' === $settings['vertical_align'] ) {
	            $content_box_classes[] = 'rhea-justify-content-top';
            } elseif ( 'center' === $settings['vertical_align'] ) {
	            $content_box_classes[] = 'rhea-justify-content-center';
            } else {
	            $content_box_classes[] = 'rhea-justify-content-bottom';
            }

            // Horizontal alignment class.
            if ( 'flex-start' === $settings['horizontal_align'] ) {
	            $content_box_classes[] = 'rhea-align-items-left';
            } elseif ( 'center' === $settings['horizontal_align'] ) {
	            $content_box_classes[] = 'rhea-align-items-center';
            } else {
	            $content_box_classes[] = 'rhea-align-items-right';
            }

            // Video horizontal alignment class.
            if ( 'right' === $settings['video_horizontal_align'] ) {
	            $content_box_classes[] = 'rhea-video-align-right';
            } else {
	            $content_box_classes[] = 'rhea-video-align-left';
            }
            ?>
            <div class="<?php echo join( ' ', $content_box_classes ); ?>">
				<?php
				if ( $settings['property_video_url'] ) {
					?>
                    <div class="rhea-single-property-slider-video">
                        <div class="rhea-single-property-slider-video-icon">
                            <a class="rhea-single-property-slider-play-video" data-fancybox href="<?php echo esc_url( $settings['property_video_url'] ); ?>"><?php
                                rhea_safe_include_svg( 'icons/play-button.svg' );
                            ?></a>
                        </div>
						<?php
						if ( $settings['property_video_sub_heading'] || $settings['property_video_heading'] ) {
							?>
                            <div class="rhea-single-property-video-headings-wrapper">
								<?php
								if ( $settings['property_video_sub_heading'] ) {
									?>
                                    <h5 class="rhea-single-property-video-sub-heading"><?php echo esc_html( $settings['property_video_sub_heading'] ); ?></h5>
									<?php
								}

								if ( $settings['property_video_heading'] ) {
									?>
                                    <h4 class="rhea-single-property-video-heading"><?php echo esc_html( $settings['property_video_heading'] ); ?></h4>
									<?php
								}
								?>
                            </div>
							<?php
						}
						?>
                    </div>
					<?php
				}
				?>
                <div class="rhea-single-property-content-wrap">
                    <?php
                    if ( 'yes' === $settings['show_property_meta'] ) {
	                    ?>
                        <div class="rhea-single-property-meta">
		                    <?php
		                    if ( $settings['bedrooms'] ) {
			                    ?>
                                <div class="rhea-single-property-meta-item">
				                    <?php
				                    if ( $settings['bedrooms_label'] ) {
					                    ?>
                                        <span class="rhea-single-property-meta-title"><?php echo esc_html( $settings['bedrooms_label'] ); ?></span>
					                    <?php
				                    }
				                    ?>
				                    <?php rhea_safe_include_svg( 'icons/bed.svg' ); ?>
                                    <span class="rhea-single-property-meta-value"><?php echo esc_html( $settings['bedrooms'] ); ?></span>
                                </div>
			                    <?php
		                    }

		                    if ( $settings['bathrooms'] ) {
			                    ?>
                                <div class="rhea-single-property-meta-item">
				                    <?php
				                    if ( $settings['bathrooms_label'] ) {
					                    ?>
                                        <span class="rhea-single-property-meta-title"><?php echo esc_html( $settings['bathrooms_label'] ); ?></span>
					                    <?php
				                    }
				                    ?>
				                    <?php rhea_safe_include_svg( 'icons/shower.svg' ); ?>
                                    <span class="rhea-single-property-meta-value"><?php echo esc_html( $settings['bathrooms'] ); ?></span>
                                </div>
			                    <?php
		                    }

		                    if ( $settings['area'] ) {
			                    ?>
                                <div class="rhea-single-property-meta-item">
				                    <?php
				                    if ( $settings['area_label'] ) {
					                    ?>
                                        <span class="rhea-single-property-meta-title"><?php echo esc_html( $settings['area_label'] ); ?></span>
					                    <?php
				                    }
				                    ?>
				                    <?php rhea_safe_include_svg( 'icons/area.svg' ); ?>
                                    <span class="rhea-single-property-meta-value"><?php echo esc_html( $settings['area'] ); ?></span>
				                    <?php if ( $settings['area_unit'] ) { ?>
                                        <span class="label"><?php echo esc_html( $settings['area_unit'] ); ?></span>
				                    <?php } ?>
                                </div>
			                    <?php
		                    }
		                    ?>
                        </div>
	                    <?php
                    }
                    ?>
                    <div class="rhea-single-property-content">
                        <div class="rhea-single-property-status rhea-single-property-status-<?php echo esc_attr( $settings['property_status'] ); ?>">
							<?php
							if ( 'for-rent' === $settings['property_status'] ) {
								?>
                                <svg viewBox="0 0 100 100" width="100" height="100" xmlns="http://www.w3.org/2000/svg"><path d="m22.1 47.4-.2 1.8-9.3-1.1.7-6.1 1.6.2-.5 4.3 2.5.3.4-3.6 1.5.2-.4 3.6zm2.7-8.9c-1.2 2.5-3 3.1-6.1 1.6-3.1-1.4-4-3.2-2.8-5.7 1.2-2.6 3-3.1 6.2-1.6 3 1.4 3.8 3.1 2.7 5.7zm-3.6-4c-2.2-1-3.3-.8-3.9.6-.6 1.3-.1 2.3 2.1 3.3s3.2.8 3.9-.6c.6-1.4.1-2.3-2.1-3.3zm11.4-6.8-1.4 1.4-3.2-1.1c-.1.1-.3.3-.4.4l-1.2 1.2 2.2 2.2-1.3 1.3-6.7-6.5 2.5-2.6c1.9-2 3.2-2.4 5-.6 1.2 1.1 1.4 2.1.9 3.1zm-5.8-2.9c-1-1-1.7-.5-2.6.5l-1.1 1.1 2.2 2.2 1.1-1.1c1-1.1 1.4-1.8.4-2.7zm18-2.6-1.9.6-2.3-2.5c-.2.1-.4.1-.6.2l-1.6.5 1 2.9-1.7.6-3-8.9 3.4-1.2c2.6-.9 3.9-.6 4.7 1.7.5 1.6.3 2.5-.6 3.2zm-3.9-5.3c-.5-1.3-1.2-1.2-2.6-.8l-1.5.5 1 3 1.5-.5c1.4-.4 2-.8 1.6-2.2zm12.3 3.5v1.6h-6.3l-.2-9.3 6.3-.1v1.6l-4.4.1v2.2l3.8-.1v1.5l-3.8.1v2.5zm9.7 4.4-2-.7-1.5-8.1-2.3 6.8-1.6-.6 3.1-8.8 2 .7 1.5 8 2.2-6.7 1.6.6zm12.3-.3-2.1-1.7-4.8 6-1.4-1.2 4.8-5.9-2.2-1.7 1-1.3 5.7 4.6zm12 30h-1.6l.1-4.3-2.5-.1-.1 3.6h-1.5l.1-3.6-3.7-.2.1-1.8 9.3.3zm-1.7 7.8c-.9 2.7-2.7 3.3-6 2.2s-4.2-2.8-3.3-5.4 2.7-3.3 5.9-2.2c3.3 1.1 4.3 2.8 3.4 5.4zm-3.9-3.6c-2.3-.8-3.3-.5-3.8.9s.1 2.3 2.4 3.1 3.3.5 3.8-.9-.2-2.3-2.4-3.1zm-2.4 14.6c-1.7 2.2-2.9 2.6-4.9 1.1-1.3-1-1.6-1.9-1.2-3l-3.7-.8 1.2-1.6 3.3.9c.1-.2.2-.3.4-.5l1.1-1.3-2.4-2 1.2-1.4 7.3 5.8zm-2.6-4.3-1 1.2c-.9 1.1-1.2 1.8-.1 2.7s1.7.4 2.6-.7l1-1.2zm-11.3 15.1c-2.5 1.1-3.8 1-4.8-1.3-.7-1.5-.6-2.4.3-3.3l-2.9-2.4 1.8-.8 2.6 2.3c.2-.1.4-.2.6-.3l1.5-.7-1.4-2.8 1.7-.8 3.8 8.5zm-1.8-4.4c-1.3.6-1.9 1-1.3 2.3s1.3 1.1 2.6.5l1.4-.6-1.2-2.8zm-13 7.8-.2-1.6 4.4-.5-.2-2.2-3.7.4-.1-1.5 3.7-.4-.3-2.5-4.5.5-.2-1.6 6.3-.6 1 9.3zm-5.6-.3-2-.5-2.3-7.8-1.6 6.9-1.7-.4 2.2-9.1 2.1.5 2.2 7.9 1.6-7 1.7.4zm-13.8-6.9 2.3 1.5-.9 1.4-6.1-4 .9-1.4 2.3 1.5 4.2-6.4 1.5 1zm18.9-13.7c9.2 0 16.6-7.4 16.6-16.6s-7.4-16.6-16.6-16.6-16.6 7.4-16.6 16.6 7.4 16.6 16.6 16.6m0 .4c-9.4 0-17-7.6-17-17s7.6-17 17-17 17 7.6 17 17-7.6 17-17 17zm0 2.6c10.8 0 19.6-8.8 19.6-19.6s-8.8-19.6-19.6-19.6-19.6 8.8-19.6 19.6 8.8 19.6 19.6 19.6m0 .4c-11 0-20-9-20-20s9-20 20-20 20 9 20 20-9 20-20 20zm0 25.6c25.1 0 45.6-20.5 45.6-45.6s-20.5-45.6-45.6-45.6-45.6 20.5-45.6 45.6 20.5 45.6 45.6 45.6m0 .4c-25.4 0-46-20.6-46-46s20.6-46 46-46 46 20.6 46 46-20.6 46-46 46zm0 2.6c26.8 0 48.6-21.8 48.6-48.6s-21.8-48.6-48.6-48.6-48.6 21.8-48.6 48.6 21.8 48.6 48.6 48.6m0 .4c-27.1 0-49-21.9-49-49s21.9-49 49-49 49 21.9 49 49-21.9 49-49 49z"/></svg>
								<?php
							} elseif ( 'for-sale' === $settings['property_status'] ) {
								?>
                                <svg viewBox="0 0 100 100" width="100" height="100" xmlns="http://www.w3.org/2000/svg"><path d="m22 47.4-.2 1.8-9.3-1.1.7-6.1 1.6.2-.5 4.3 2.5.3.4-3.6 1.5.2-.4 3.6zm2.6-8.9c-1.2 2.5-3 3.1-6.1 1.6-3.1-1.4-4-3.2-2.8-5.7 1.2-2.6 3-3.1 6.2-1.6 3.1 1.4 3.9 3.1 2.7 5.7zm-3.5-4c-2.2-1-3.3-.8-3.9.6-.6 1.3-.1 2.3 2.1 3.3s3.2.8 3.9-.6c.6-1.4.1-2.3-2.1-3.3zm11.4-6.8-1.4 1.4-3.2-1.2c-.1.1-.3.3-.4.4l-1.2 1.2 2.2 2.2-1.3 1.3-6.7-6.5 2.5-2.5c1.9-2 3.2-2.4 5-.6 1.2 1.1 1.4 2.1.9 3.1zm-5.8-2.9c-1-1-1.7-.5-2.6.5l-1.1 1.1 2.2 2.2 1.1-1.1c1-1.1 1.4-1.8.4-2.7zm14-1c-2.3.8-3.9.2-4.6-1.9l1.7-.6c.4 1.1 1.2 1.4 2.4 1 1-.4 1.6-.9 1.3-1.7-.7-1.9-5.4 1.1-6.6-2.2-.5-1.6.1-3 2.4-3.8 2.5-.9 3.8-.1 4.4 1.8l-1.7.6c-.3-.7-.8-1.4-2.2-.9-1.2.4-1.5 1.1-1.2 1.7.7 1.9 5.4-1.2 6.6 2.2.7 1.7-.1 3-2.5 3.8zm11.1-1.8-.6-1.8-3.7.1-.6 1.7h-2l3.2-9.4h2.1l3.5 9.3zm-2.6-7.6-1.3 4.3 2.7-.1zm12.1 8-.5 1.6-5.4-1.6 2.6-9 1.8.5-2.1 7.3zm10.9-.6-3.7-2.4-1.2 1.9 3.2 2.1-.8 1.2-3.2-2.1-1.3 2.1 3.8 2.4-1 1.4-5.3-3.5 5.1-7.8 5.3 3.4zm13.5 30.1-.2-4.3-2.5.1.2 3.6-1.5.1-.2-3.6-3.7.2-.1-1.8 9.3-.4.3 6.1zm.5 7.9c-.7 2.7-2.5 3.5-5.8 2.6s-4.4-2.5-3.7-5.2 2.4-3.5 5.8-2.6c3.3.9 4.4 2.5 3.7 5.2zm-4.2-3.4c-2.3-.6-3.3-.2-3.7 1.2s.3 2.3 2.6 2.9 3.3.2 3.7-1.2-.3-2.2-2.6-2.9zm-1.4 14.8c-1.6 2.3-2.7 2.8-4.8 1.4-1.3-.9-1.8-1.8-1.4-2.9l-3.7-.5 1.1-1.6 3.4.6c.1-.2.2-.3.3-.5l1-1.4-2.6-1.8 1-1.5 7.7 5.3zm-2.8-4.1-.9 1.3c-.8 1.2-1.1 1.9.1 2.7s1.7.3 2.5-.9l.9-1.3zm-9.8 15.8c-2.4 1.3-3.7.7-4.7-1l1.6-.9c.4.7 1 1.2 2.3.5 1.2-.6 1.3-1.3.9-1.9-1-1.8-5.2 2-6.9-1.1-.9-1.6-.3-3.1 1.9-4.3 2.1-1.2 3.8-.8 4.8 1.1l-1.6.9c-.6-1-1.4-1.2-2.6-.6-1 .5-1.4 1.2-1 1.9 1 1.8 5.2-2 6.9 1.1 1 1.7.6 3.2-1.6 4.3zm-10.2 3.6-2.1.4-5-8.6 2-.4.9 1.7 3.6-.7.2-1.9 1.9-.4zm-3.5-5.5 2.1 4 .6-4.5zm-6.5 6.3-1.8-.2.9-7.6-3.7-.4.2-1.7 5.6.7zm-10.2-1.9-5.7-2.5.6-1.4 4.1 1.8.9-2-3.5-1.7.6-1.3 3.5 1.5 1-2.3-4.1-1.8.6-1.4 5.8 2.5zm12.3-18.8c9.2 0 16.6-7.4 16.6-16.6s-7.4-16.6-16.6-16.6-16.6 7.4-16.6 16.6 7.4 16.6 16.6 16.6m0 .4c-9.4 0-17-7.6-17-17s7.6-17 17-17 17 7.6 17 17-7.6 17-17 17zm0 2.6c10.8 0 19.6-8.8 19.6-19.6s-8.8-19.6-19.6-19.6-19.6 8.8-19.6 19.6 8.8 19.6 19.6 19.6m0 .4c-11 0-20-9-20-20s9-20 20-20 20 9 20 20-9 20-20 20zm0 25.6c25.1 0 45.6-20.5 45.6-45.6s-20.5-45.6-45.6-45.6c-25.2 0-45.6 20.5-45.6 45.6s20.4 45.6 45.6 45.6m0 .4c-25.4 0-46-20.6-46-46s20.6-46 46-46 46 20.6 46 46-20.6 46-46 46zm0 2.6c26.8 0 48.6-21.8 48.6-48.6s-21.8-48.6-48.6-48.6c-26.8 0-48.6 21.8-48.6 48.6s21.8 48.6 48.6 48.6m0 .4c-27.1 0-49-21.9-49-49s21.9-49 49-49 49 21.9 49 49-21.9 49-49 49z"/></svg>
								<?php
							} elseif ( 'custom-icon' === $settings['property_status'] ) {

								if ( 'image' == $settings['icon_type'] ) {
									if ( $settings['property_status_custom_image'] ) { ?>
                                        <div class="rhea-single-property-status-custom-image">
											<?php
											echo wp_get_attachment_image(
												$settings['property_status_custom_image']['id'],
												array(
													$settings['custom_dimension']['width'],
													$settings['custom_dimension']['height'],
												)
											);
											?>
                                        </div>
										<?php
									}
								} elseif ( 'icon' == $settings['icon_type'] ) {
									if ( $settings['property_status_custom_icon'] ) {
										\Elementor\Icons_Manager::render_icon( $settings['property_status_custom_icon'], [ 'aria-hidden' => 'true' ] );
									}
								}

							} elseif ( 'custom-text' === $settings['property_status'] ) {
								if ( $settings['property_status_custom_text'] ) {
									?>
                                    <span><?php echo esc_html( $settings['property_status_custom_text'] ); ?></span>
									<?php
								}
							}
							?>
                        </div>
                        <div class="rhea-single-property-content-inner">
							<?php
							if ( $settings['property_address'] ) { ?>
                                <address class="rhea-single-property-address">
                                    <span class="rhea-single-property-address-pin"><?php rhea_safe_include_svg( 'icons/pin.svg' ); ?></span>
                                    <span class="rhea-single-property-address-text"><?php echo esc_html( $settings['property_address'] ); ?></span>
                                </address>
								<?php
							}

							if ( $settings['property_title'] ) { ?>
                                <h3 class="rhea-single-property-title"><?php echo esc_html( $settings['property_title'] ); ?></h3>
								<?php
							}

							if ( $settings['property_description'] ) { ?>
                                <p class="rhea-single-property-description"><?php echo esc_html( $settings['property_description'] ); ?></p>
								<?php
							}
							?>
                        </div>
                        <div class="rhea-single-property-price-and-button">
							<?php
							if ( $settings['property_price'] ) { ?>
                                <p class="rhea-single-property-price"><?php echo esc_html( $settings['property_price'] ); ?></p>
								<?php
							}

							if ( $settings['cta_url']['url'] ) {
								$target   = $settings['cta_url']['is_external'] ? ' target="_blank"' : '';
								$nofollow = $settings['cta_url']['nofollow'] ? ' rel="nofollow"' : '';
								?>
                                <a class="rhea-single-property-cta-button"
                                   href="<?php echo esc_url( $settings['cta_url']['url'] ); ?>"<?php echo $target . $nofollow; ?>>
									<?php echo esc_html( $settings['cta_button_text'] ); ?>
                                </a>
								<?php
							}
							?>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <script type="application/javascript">
            (function ($) {
                'use strict';
                $(document).ready(function () {
                    if ($().flexslider) {
                        $('#rhea-single-property-slider-<?php echo esc_attr( $this->get_id() );?>').flexslider({
                            animation: "fade",
                            slideshowSpeed: 7000,
                            animationSpeed: 1500,
                            slideshow: true,
                            controlNav: false,
                            keyboardNav: true,
                            directionNav: true,
                            customDirectionNav: $('#rhea-single-property-slider-nav-<?php echo esc_attr( $widget_id ); ?> .nav-buttons'),
                            start: function (slider) {
                                slider.removeClass('loading');
                            }
                        });
                    }

                    const $sliderWrapper = $('#rhea-single-property-slider-wrapper-<?php echo esc_attr( $this->get_id() );?>');
                    const $contentWrapper = $sliderWrapper.find('.rhea-single-property-content-wrap');

                    // Toggles class on first item on hover.
                    $sliderWrapper.find('.rhea-single-property-meta-item').first().hover(
                        function () {
                            $contentWrapper.addClass('disable-border-radius disable-first-border-radius');
                        }, function () {
                            $contentWrapper.removeClass('disable-border-radius disable-first-border-radius');
                        }
                    );

                    if( $sliderWrapper.find('.rhea-single-property-meta-item').length > 2 ){
                        // Toggles class on last item on hover.
                        $sliderWrapper.find('.rhea-single-property-meta-item').last().hover(
                            function () {
                                $contentWrapper.addClass('disable-border-radius disable-last-border-radius');
                            }, function () {
                                $contentWrapper.removeClass('disable-border-radius disable-last-border-radius');
                            }
                        );
                    }
                });
            })(jQuery);
        </script>
		<?php
	}
}