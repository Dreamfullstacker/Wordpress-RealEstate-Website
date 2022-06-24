<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_Featured_Properties_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-classic-featured-properties-widget';
	}

	public function get_title() {
		return esc_html__( 'Classic Featured Properties Carousel', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'classic-real-homes' ];
	}

	protected function register_controls() {

		$grid_size_array = wp_get_additional_image_sizes();

		$prop_grid_size_array = array();
		foreach ( $grid_size_array as $key => $value ) {
			$str_rpl_key = ucwords( str_replace( "-", " ", $key ) );

			$prop_grid_size_array[ $key ] = $str_rpl_key . ' - ' . $value['width'] . 'x' . $value['height'];
		}

		unset( $prop_grid_size_array['partners-logo'] );
		unset( $prop_grid_size_array['property-detail-slider-thumb'] );
		unset( $prop_grid_size_array['post-thumbnail'] );
		unset( $prop_grid_size_array['agent-image'] );
		unset( $prop_grid_size_array['gallery-two-column-image'] );
		unset( $prop_grid_size_array['post-featured-image'] );

		if ( INSPIRY_DESIGN_VARIATION == 'modern' ) {
			$default_prop_grid_size = 'post-featured-image';
		} else {
			$default_prop_grid_size = 'property-detail-slider-image-two';
		}


		$this->start_controls_section(
			'ere_featured_properties_section',
			[
				'label' => esc_html__( 'Featured Properties Carousel', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_property_grid_thumb_sizes',
			[
				'label'   => esc_html__( 'Thumbnail Size', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $default_prop_grid_size,
				'options' => $prop_grid_size_array
			]
		);

		$this->add_control(
			'number_of_properties',
			[
				'label'   => esc_html__( 'Number of Properties', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
				'default' => 5,
			]
		);

		$this->add_control(
			'featured_excerpt_length',
			[
				'label'   => esc_html__( 'Excerpt Length (Words)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 5,
				'max'     => 100,
				'default' => 15,
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_featured_properties_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_detail_side_inner h4 a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_price_typography',
				'label'    => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_price_side .price',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_type_typography',
				'label'    => esc_html__( 'Type', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_price_side .type small',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_button_more',
				'label'    => esc_html__( 'More Details Button', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_photos_count',
				'label'    => esc_html__( 'Photos Tag', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side .photos',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_excerpt',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_excerpt_wrapper p',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_meta_number',
				'label'    => esc_html__( 'Meta Figure', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_featured_meta_container .number',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_meta_label',
				'label'    => esc_html__( 'Meta Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_featured_meta_container .meta_label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_status_tag',
				'label'    => esc_html__( 'Status Tag', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_thumb_side_inner .statuses',
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'ere_featured_properties_Labels',
			[
				'label' => esc_html__( 'Labels', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_featured_more_detail_label',
			[
				'label'   => esc_html__( 'More Details', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'More Details', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_featured_photos_label',
			[
				'label'   => esc_html__( 'Photos', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Photos', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_featured_photo_singular_label',
			[
				'label'   => esc_html__( 'Photo Singular', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Photo', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_featured_area_postfix_label',
			[
				'label'   => esc_html__( 'Area Postfix', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Sq Ft', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_featured_bedrooms_label',
			[
				'label'   => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_featured_bedroom_singular_label',
			[
				'label'   => esc_html__( 'Bedroom Singular', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bedroom', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_featured_bathrooms_label',
			[
				'label'   => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_featured_bathroom_singular_label',
			[
				'label'   => esc_html__( 'Bathroom Singular', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bathroom', 'realhomes-elementor-addon' ),
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_featured_properties_sizes',
			[
				'label' => esc_html__( 'Sizes & Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_slide_padding',
			[
				'label'      => esc_html__( 'Slide Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_slide_inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_thumb_detail_ratio',
			[
				'label'           => esc_html__( 'Thumb/Detail Ratio (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'           => [
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
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_thumb_side'  => 'flex: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_detail_side' => 'flex: calc(100% - {{SIZE}}{{UNIT}});',

				],
			]
		);

		$this->add_responsive_control(
			'ere_thumb_detail_space',
			[
				'label'           => esc_html__( 'Space Between Thumb/Detail (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_slide_inner' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_thumb_side'  => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_detail_side' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_title_bottom_margin',
			[
				'label'           => esc_html__( 'Title Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_detail_side_inner h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_price_margin_bottom',
			[
				'label'           => esc_html__( 'Price Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_price_and_button_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_excerpt_margin_bottom',
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
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_excerpt_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_separator_width',
			[
				'label'           => esc_html__( 'Separator Width (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'           => [
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
				'desktop_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_meta_separator' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_separator_height',
			[
				'label'           => esc_html__( 'Separator Height (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_meta_separator' => 'height: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'ere_separator_margin_bottom',
			[
				'label'           => esc_html__( 'Separator Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'           => [
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
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_meta_separator' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_meta_margin_bottom',
			[
				'label'           => esc_html__( 'Meta Info Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_featured_meta_container .rhea_featured_meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_featured_control_nav',
			[
				'label' => esc_html__( 'Slide Options', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ere_show_featured_slide_show',
			[
				'label'        => esc_html__( 'Slide Show', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'ere_featured_animation_type',
			[
				'label'     => esc_html__( 'Animation Type', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => [
					'fade'  => esc_html__( 'Fade', 'realhomes-elementor-addon' ),
					'slide' => esc_html__( 'Slide', 'realhomes-elementor-addon' ),
				],
				'default'   => 'fade',
				'condition' => [
					'ere_show_featured_slide_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'ere_featured_animation_speed',
			[
				'label'     => esc_html__( 'Animation Speed (ms)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 100,
				'max'       => 10000,
				'step'      => 100,
				'default'   => 500,
				'condition' => [
					'ere_show_featured_slide_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'ere_featured_slideshow_speed',
			[
				'label'     => esc_html__( 'Slide Show Speed (ms)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 10000,
				'step'      => 1000,
				'default'   => 7000,
				'condition' => [
					'ere_show_featured_slide_show' => 'yes',
				],
			]
		);


		$this->add_control(
			'ere_show_featured_nav_buttons',
			[
				'label'        => esc_html__( 'Show Slider Control', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'ere_control_nav_width',
			[
				'label'           => esc_html__( 'Control Nav Bullet Width (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .flex-control-nav li a' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_control_nav_height',
			[
				'label'           => esc_html__( 'Control Nav Bullet height (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .flex-control-nav li a' => 'height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_control_nav_space',
			[
				'label'           => esc_html__( 'Control Nav Bullet Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .flex-control-nav li' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_control_nav_position',
			[
				'label'           => esc_html__( 'Control Nav Bottom Position (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => - 200,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .flex-control-nav' => 'bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_control(
			'ere_featured_property_control_nav_color',
			[
				'label'     => esc_html__( 'Bullet Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .flex-control-nav li a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_control_nav_hover_color',
			[
				'label'     => esc_html__( 'Bullet Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .flex-control-nav li a:hover'      => 'background: {{VALUE}};',
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .flex-control-nav li .flex-active' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_control_nav_active_color',
			[
				'label'     => esc_html__( 'Bullet Active Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .flex-control-nav li a.flex-active' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_featured_colors_nav',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'ere_featured_property_bg_color',
			[
				'label'     => esc_html__( 'Property Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_status_color',
			[
				'label'     => esc_html__( 'Status Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_thumb_side_inner .statuses' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_status_text_color',
			[
				'label'     => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_thumb_side_inner .statuses' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_detail_side_inner h4 a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_title_hover_color',
			[
				'label'     => esc_html__( 'Title Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_detail_side_inner h4 a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_price_color',
			[
				'label'     => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_price_side .price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_type_color',
			[
				'label'     => esc_html__( 'Type', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_price_side .type small' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_more_detail_bg_color',
			[
				'label'     => esc_html__( 'More Details Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side a' => 'background: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_more_detail_bg_hover_color',
			[
				'label'     => esc_html__( 'More Details Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side a:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_more_detail_text:hover_color',
			[
				'label'     => esc_html__( 'More Details', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_more_detail_text_color',
			[
				'label'     => esc_html__( 'More Details Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_photo_bg_color',
			[
				'label'     => esc_html__( 'Photos Tag Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side .photos' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_photo_border_color',
			[
				'label'     => esc_html__( 'Photos Tag Border', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side .photos' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_photo_text_color',
			[
				'label'     => esc_html__( 'Photos Tag Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side .photos' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_photo_icon_color',
			[
				'label'     => esc_html__( 'Photos Tag Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_button_side .photos .fa' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_photo_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_excerpt_wrapper' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'ere_featured_property_separator_color',
			[
				'label'     => esc_html__( 'Separator', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_meta_separator' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_meta_icon_color',
			[
				'label'     => esc_html__( 'Meta Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_featured_meta_container .rhea_featured_meta svg' => 'fill: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'ere_featured_property_meta_figure_color',
			[
				'label'     => esc_html__( 'Meta Figure', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_featured_meta_container .rhea_featured_figure' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ere_featured_property_meta_label_color',
			[
				'label'     => esc_html__( 'Meta Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_featured_properties_elementor .rhea_featured_meta_container .meta_label' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['number_of_properties'] ) {
			$settings['number_of_properties'] = 5;
		}

		if ( ! $settings['featured_excerpt_length'] ) {
			$settings['featured_excerpt_length'] = 15;
		}


		$classic_featured_properties_args = array(
			'post_type'      => 'property',
			'post_status'    => 'publish',
			'posts_per_page' => $settings['number_of_properties'],
			'meta_query'     => array(
				array(
					'key'     => 'REAL_HOMES_featured',
					'value'   => 1,
					'compare' => '=',
					'type'    => 'NUMERIC',
				),
			),
		);

		$featured_properties = new WP_Query( apply_filters( 'rhea_classic_featured_properties_widget', $classic_featured_properties_args ) );

		?>
        <div class="rh_elementor_widget rhea_classic_featured_properties_elementor">
			<?php
			if ( $featured_properties->have_posts() ) {
				?>
                <div class="rhea_classic_featured_properties">
                    <ul class="rhea_classic_featured_flex_slider slides">
						<?php
						while ( $featured_properties->have_posts() ) {

							$featured_properties->the_post();
							?>
                            <li class="rhea_featured_slide">
                                <div class="rhea_slide_inner">
                                    <div class="rhea_thumb_side">
                                        <div class="rhea_thumb_side_inner">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
												<?php
												if ( has_post_thumbnail() ) {
													the_post_thumbnail( $settings['ere_property_grid_thumb_sizes'] );
												} else {
													inspiry_image_placeholder( $settings['ere_property_grid_thumb_sizes'] );
												}

												?>
                                            </a>

	                                        <?php
	                                        if ( function_exists( 'ere_get_property_statuses' ) ) {
		                                        $statuses = ere_get_property_statuses( get_the_ID() );
		                                        if ( ! empty( $statuses ) ) {
			                                        ?>
                                                    <div class="statuses">
				                                        <?php echo esc_html( $statuses ); //should not be escaped as it contains anchor tag
				                                        ?>
                                                    </div>
                                                    <!-- /.statuses -->
			                                        <?php
		                                        }
	                                        }
	                                        ?>
                                        </div>
                                    </div>
                                    <div class="rhea_detail_side">
                                        <div class="rhea_detail_side_inner">
                                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                                            <div class="rhea_price_and_button_wrapper">
                                                <div class="rhea_price_side">
                                                    <p class="price">
														<?php
														if ( function_exists( 'ere_property_price' ) ) {
															ere_property_price();
														}
														?>
                                                    </p>
                                                    <p class="type">
	                                                    <?php
	                                                    if ( function_exists( 'ere_get_property_types' ) ) {
		                                                    echo ere_get_property_types( get_the_id() );
	                                                    }
	                                                    ?>
                                                    </p>
                                                </div>
                                                <div class="rhea_button_side">
                                                    <a href="<?php the_permalink() ?>"><?php echo ( $settings['ere_featured_more_detail_label'] ) ? esc_html( $settings['ere_featured_more_detail_label'] ) : esc_html__( 'More Details', 'realhomes-elementor-addon' ); ?></a>
													<?php
													$images_count = inspiry_get_number_of_photos( get_the_id() );
													$images_count = ( ! empty( $images_count ) ) ? intval( $images_count ) : false;
													$images_str   = ( 1 < $images_count ) ? ( $settings['ere_featured_photos_label'] ? esc_html( $settings['ere_featured_photos_label'] ) : esc_html__( 'Photos', 'realhomes-elementor-addon' ) ) : ( $settings['ere_featured_photo_singular_label'] ? esc_html( $settings['ere_featured_photo_singular_label'] ) : esc_html__( 'Photo', 'realhomes-elementor-addon' ) );
													?>

													<?php if ( ! empty( $images_count ) ) : ?>
                                                        <p class="photos">
                                                            <span class="fa fa-camera"></span>
                                                            <span><?php echo esc_html( $images_count . ' ' . $images_str ); ?></span>
                                                        </p>
													<?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="rhea_excerpt_wrapper">
                                                <p><?php rhea_framework_excerpt( esc_html( $settings['featured_excerpt_length'] ) ); ?></p>
                                            </div>

                                            <div class="rhea_meta_separator"></div>

                                            <div class="rhea_featured_meta_container">
												<?php
												$post_meta_data = get_post_custom( get_the_id() ); // Get post meta
												$prop_size      = ( isset( $post_meta_data['REAL_HOMES_property_size'][0] ) ) ? $post_meta_data['REAL_HOMES_property_size'][0] : false; // Property Size
												$prop_bedrooms  = ( isset( $post_meta_data['REAL_HOMES_property_bedrooms'][0] ) ) ? $post_meta_data['REAL_HOMES_property_bedrooms'][0] : false; // Property Bedrooms
												$prop_bathrooms = ( isset( $post_meta_data['REAL_HOMES_property_bathrooms'][0] ) ) ? $post_meta_data['REAL_HOMES_property_bathrooms'][0] : false; // Property Bathrooms

												$prop_size      = ( ! empty( $prop_size ) ) ? floatval( $prop_size ) : false;
												$prop_bedrooms  = ( ! empty( $prop_bedrooms ) ) ? floatval( $prop_bedrooms ) : false;
												$prop_bathrooms = ( ! empty( $prop_bathrooms ) ) ? floatval( $prop_bathrooms ) : false;
												?>

												<?php if ( ! empty( $prop_size ) ) { ?>
                                                    <div class="rhea_featured_meta">
                                                        <div class="rhea_featured_svg_icon">
															<?php include RHEA_ASSETS_DIR . '/icons/classic-icon-area.svg'; ?>
                                                        </div>
                                                        <div class="rhea_featured_figure">
                                                            <p class="number"> <?php echo esc_html( $prop_size ); ?> </p>
															<?php
															if ( ! empty( $settings['ere_featured_area_postfix_label'] ) ) {
																?>
                                                                <p class="meta_label">
																	<?php
																	echo esc_html( $settings['ere_featured_area_postfix_label'] );
																	?>
                                                                </p>
																<?php
															}
															?>
                                                        </div>
                                                    </div>
													<?php
												}

												if ( ! empty( $prop_bedrooms ) ) {
													?>
                                                    <div class="rhea_featured_meta">
                                                        <div class="rhea_featured_svg_icon">
															<?php include RHEA_ASSETS_DIR . '/icons/classic-icon-bed.svg'; ?>
                                                        </div>

                                                        <div class="rhea_featured_figure">
                                                            <p class="number"> <?php echo esc_html( $prop_bedrooms ); ?> </p>
                                                            <p class="meta_label">
																<?php echo ( $prop_bedrooms > 1 ) ? ( $settings['ere_featured_bedrooms_label'] ? esc_html( $settings['ere_featured_bedrooms_label'] ) : esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ) ) : ( $settings['ere_featured_bedroom_singular_label'] ? esc_html( $settings['ere_featured_bedroom_singular_label'] ) : esc_html__( 'Bedroom', 'realhomes-elementor-addon' ) ); ?>
                                                            </p>
                                                        </div>

                                                    </div>
													<?php
												}


												if ( ! empty( $prop_bathrooms ) ) {
													?>
                                                    <div class="rhea_featured_meta">
                                                        <div class="rhea_featured_svg_icon">
															<?php include RHEA_ASSETS_DIR . '/icons/classic-icon-bath.svg'; ?>
                                                        </div>

                                                        <div class="rhea_featured_figure">
                                                            <p class="number"> <?php echo esc_html( $prop_bathrooms ); ?> </p>
                                                            <p class="meta_label">
																<?php echo ( $prop_bathrooms > 1 ) ? ( $settings['ere_featured_bathrooms_label'] ? esc_html( $settings['ere_featured_bathrooms_label'] ) : esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ) ) : ( $settings['ere_featured_bathroom_singular_label'] ? esc_html( $settings['ere_featured_bathroom_singular_label'] ) : esc_html__( 'Bathroom', 'realhomes-elementor-addon' ) ); ?>

                                                            </p>
                                                        </div>

                                                    </div>
													<?php
												}
												?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>
							<?php
						}
						wp_reset_postdata();
						?>
                    </ul>
                </div>
				<?php
			}
			?>
        </div>

        <script type="application/javascript">
            function RHEAloadClassicFeaturedProperties() {
                if (jQuery().flexslider) {
                    jQuery('.rhea_classic_featured_properties').each(function () {
                        jQuery(this).flexslider({
                            animation: "<?php echo $settings['ere_featured_animation_type'];?>",
                            slideshowSpeed: <?php echo( $settings['ere_featured_slideshow_speed'] ? $settings['ere_featured_slideshow_speed'] : 7000 );?>,
                            animationSpeed: <?php echo( $settings['ere_featured_animation_speed'] ? $settings['ere_featured_animation_speed'] : 500 );?>,
                            slideshow: true,
                            directionNav: false,
                            controlNav: "<?php echo $settings['ere_show_featured_nav_buttons'] == 'yes' ? true : false; ?>",
                            keyboardNav: true,

                        });
                    });
                }
            }

            RHEAloadClassicFeaturedProperties();
            jQuery(document).on('ready', RHEAloadClassicFeaturedProperties);
        </script>
		<?php

	}

}