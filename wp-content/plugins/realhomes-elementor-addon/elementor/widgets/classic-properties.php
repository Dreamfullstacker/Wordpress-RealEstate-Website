<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_Properties_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rhea-classic-properties-widget';
	}

	public function get_title() {
		return esc_html__( 'Classic Properties Grid', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		// More classes for icons can be found at https://pojome.github.io/elementor-icons/
		return 'eicon-posts-grid';
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

		$default_prop_grid_size = 'property-thumb-image';

		$this->start_controls_section(
			'ere_properties_section',
			[
				'label' => esc_html__( 'Properties', 'realhomes-elementor-addon' ),
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

		$this->add_responsive_control(
			'ere_property_grid_layout',
			[
				'label'       => __( 'Layout', 'realhomes-elementor-addon' ),
				'description' => __( 'Number of columns will be reduced automatically if parent container has insufficient width.', 'realhomes-elementor-addon' ) . '<br>' .
				                 __( '* To apply this, make sure "Style -> Property Width" field is empty.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => '50%',
				'options'     => array(
					'33.333%' => esc_html__( '3 Columns *Full Width Content', 'realhomes-elementor-addon' ),
					'50%'     => esc_html__( '2 Columns', 'realhomes-elementor-addon' ),
					'100%'    => esc_html__( '1 Column', 'realhomes-elementor-addon' ),
				),
				'selectors'   => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_wrapper' => 'width: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Properties', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 60,
				'step'    => 1,
				'default' => 6,
			]
		);


		// Select controls for Custom Taxonomies related to Property
		$property_taxonomies = get_object_taxonomies( 'property', 'objects' );
		if ( ! empty( $property_taxonomies ) && ! is_wp_error( $property_taxonomies ) ) {
			foreach ( $property_taxonomies as $single_tax ) {
				$options = [];
				$terms   = get_terms( $single_tax->name );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$options[ $term->slug ] = $term->name;
					}
				}

				$this->add_control(
					$single_tax->name,
					[
						'label'       => $single_tax->label,
						'type'        => \Elementor\Controls_Manager::SELECT2,
						'multiple'    => true,
						'label_block' => true,
						'options'     => $options,
					]
				);
			}
		}


		// Sorting Controls
		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date'       => esc_html__( 'Date', 'realhomes-elementor-addon' ),
					'price'      => esc_html__( 'Price', 'realhomes-elementor-addon' ),
					'title'      => esc_html__( 'Title', 'realhomes-elementor-addon' ),
					'menu_order' => esc_html__( 'Menu Order', 'realhomes-elementor-addon' ),
					'rand'       => esc_html__( 'Random', 'realhomes-elementor-addon' ),
				],
				'default' => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'asc'  => esc_html__( 'Ascending', 'realhomes-elementor-addon' ),
					'desc' => esc_html__( 'Descending', 'realhomes-elementor-addon' ),
				],
				'default' => 'desc',
			]
		);

		$this->add_control(
			'show_only_featured',
			[
				'label'        => esc_html__( 'Show Only Featured Properties', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'prop_excerpt_length',
			[
				'label'   => esc_html__( 'Excerpt Length (Words)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 5,
				'max'     => 100,
				'default' => 10,
			]
		);

		$this->add_control(
			'skip_sticky_properties',
			[
				'label'        => esc_html__( 'Skip Sticky Properties', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'        => esc_html__( 'Show Pagination', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => esc_html__( 'Offset or Skip From Start', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '0',

			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'ere_properties_labels',
			[
				'label' => esc_html__( 'Labels', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

//		$this->add_control(
//			'ere_property_featured_label',
//			[
//				'label'   => esc_html__( 'Featured Tag', 'realhomes-elementor-addon' ),
//				'type'    => \Elementor\Controls_Manager::TEXT,
//				'default' => esc_html__( 'Featured', 'realhomes-elementor-addon' ),
//			]
//		);

		$this->add_control(
			'ere_property_more_detail_label',
			[
				'label'   => esc_html__( 'More Details', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'More Details', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_property_bedrooms_label',
			[
				'label'   => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_property_bathroom_label',
			[
				'label'   => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_property_garage_label',
			[
				'label'   => esc_html__( 'Garages', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Garages', 'realhomes-elementor-addon' ),
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_property_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_heading_typography',
				'label'    => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_title a',
			]
		);

//		$this->add_group_control(
//			\Elementor\Group_Control_Typography::get_type(),
//			[
//				'name'     => 'property_featured_tag_typography',
//				'label'    => esc_html__( 'Featured Tag', 'realhomes-elementor-addon' ),
//				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
//				'selector' => '{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_is_featured',
//			]
//		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_label_typography',
				'label'    => esc_html__( 'Label Tag', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_status_typography',
				'label'    => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_status',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_price_typography',
				'label'    => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_prop_card__price .rhea_price',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_type_typography',
				'label'    => esc_html__( 'Type', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_prop_card__price small',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_excerpt_typography',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_excerpt',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_more_view_typography',
				'label'    => esc_html__( 'View More', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_more_details',
			]
		);


		$this->add_responsive_control(
			'property_more_view_caret_typography',
			[
				'label' => esc_html__( 'View More Caret Size (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_more_details i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_meta_figure_typography',
				'label'    => esc_html__( 'Meta Figure', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_meta_wrapper .figure',
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'ere_properties_sizes_spaces',
			[
				'label' => esc_html__( 'Sizes & Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_property_width',
			[
				'label'           => esc_html__( 'Property Width (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'This will over-ride the width of "Content -> Layout"', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_wrapper' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_property_thumbnail_ratio',
			[
				'label'           => esc_html__( 'Thumbnail/Excerpt Ratio ', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_thumb' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_property_container_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_hading_margin_bottom',
			[
				'label'           => esc_html__( 'Heading Margin Bottom (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_property_label_padding',
			[
				'label'      => esc_html__( 'Labels Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_label'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_status' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_property_price_bar',
			[
				'label'      => esc_html__( 'Price Bar Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_price_bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_excerpt_area',
			[
				'label'      => esc_html__( 'Excerpt Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_property_excerpt_margin_bottom',
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
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_excerpt p' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_property_meta_padding',
			[
				'label'      => esc_html__( 'Excerpt Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_meta_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_meta_icon_size',
			[
				'label'           => esc_html__( 'Meta Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_meta_wrapper svg' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'ere_properties_styles',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'ere_property_bg_color',
			[
				'label'     => esc_html__( 'Property Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_container'      => 'background: {{VALUE}}',
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_meta_container' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_bg_hover_color',
			[
				'label'     => esc_html__( 'Property Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_wrapper:hover .rhea_property_container'      => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_property_wrapper:hover .rhea_property_meta_container' => 'background: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'ere_property_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_title_hover_color',
			[
				'label'     => esc_html__( 'Title Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
//		$this->add_control(
//			'ere_property_featured_tag_bg_color',
//			[
//				'label'     => esc_html__( 'Featured Tag Background', 'realhomes-elementor-addon' ),
//				'type'      => \Elementor\Controls_Manager::COLOR,
//				'default'   => '',
//				'selectors' => [
//					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_is_featured' => 'background: {{VALUE}}',
//				],
//			]
//		);

//		$this->add_control(
//			'ere_property_featured_tag_text_color',
//			[
//				'label'     => esc_html__( 'Featured Tag Text', 'realhomes-elementor-addon' ),
//				'type'      => \Elementor\Controls_Manager::COLOR,
//				'default'   => '',
//				'selectors' => [
//					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_is_featured' => 'color: {{VALUE}}',
//				],
//			]
//		);
		$this->add_control(
			'ere_property_label_tag_bg_color',
			[
				'label'     => esc_html__( 'Label Tag Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_label' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_label_tag_text_color',
			[
				'label'     => esc_html__( 'Label Tag Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_status_tag_bg_color',
			[
				'label'     => esc_html__( 'Status Tag Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_status' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_status_tag_text_color',
			[
				'label'     => esc_html__( 'Status Tag Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_status' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_price_bar_bg_color',
			[
				'label'     => esc_html__( 'Price Bar Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_price_bar' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_price_color',
			[
				'label'     => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_prop_card__price .rhea_price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_type_color',
			[
				'label'     => esc_html__( 'Type', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_prop_card__price small' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_excerpt_area_bg_color',
			[
				'label'     => esc_html__( 'Excerpt Area Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_detail' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_excerpt p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_more_detail_link',
			[
				'label'     => esc_html__( 'More Detail Link', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_more_details' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_more_detail_link_hover',
			[
				'label'     => esc_html__( 'More Detail Link Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_more_details:hover' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'ere_property_meta_area',
			[
				'label'     => esc_html__( 'Meta Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_meta_container' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_meta_area_hover',
			[
				'label'     => esc_html__( 'Meta Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_meta_container:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_meta_icon',
			[
				'label'     => esc_html__( 'Meta Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_meta_wrapper svg .path' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_meta_wrapper .circle'   => 'fill: {{VALUE}}',
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_meta_wrapper .rect'     => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_meta_figure',
			[
				'label'     => esc_html__( 'Meta Figure', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_meta_wrapper .figure' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_border_color',
			[
				'label'     => esc_html__( 'Border', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_container'      => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_property_meta_container' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .classic_properties_elementor_wrapper .rhea_meta_wrapper'            => 'border-color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_properties_box_shadow',
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
				'selector' => '{{WRAPPER}} .rhea_classic_property_inner',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_pagination',
			[
				'label' => esc_html__( 'Pagination', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]

		);

		$this->add_responsive_control(
			'rhea_pagination_contianer_margin',
			[
				'label' => esc_html__( 'Pagination Container Margin', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_space_between_links',
			[
				'label'           => esc_html__( 'Space Between (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_pagination_size',
			[
				'label'           => esc_html__( 'Size(px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'rhea_pagination_border_radius',
			[
				'label'           => esc_html__( 'Border Radius(px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a' => 'border-radius: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_pagination_typography',
				'label'    => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a',
			]
		);

		$this->add_control(
			'rhea_pagination_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#dedede',
				'selectors' => [
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_pagination_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Hover/Current Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#e3712c',
				'selectors' => [
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a:hover' => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a.current' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_pagination_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#555',
				'selectors' => [
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_pagination_text_hover_color',
			[
				'label'     => esc_html__( 'Text Hover/Current Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a.current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pagination_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea_latest_properties_ajax_classic .pagination a',
			]
		);


		$this->end_controls_section();

	}


	protected function render() {

		global $settings;
        global $properties_query;
		$settings = $this->get_settings_for_display();

		// Remove sticky properties filter.
		if ( $settings['skip_sticky_properties'] == 'yes' ) {
			remove_filter( 'the_posts', 'inspiry_make_properties_stick_at_top', 10 );
		}

		$prop_excerpt_length = $settings['prop_excerpt_length'];
//		$property_featured_label       = $settings['ere_property_featured_label'];
		$property_more_detail_label    = $settings['ere_property_more_detail_label'];
		$ere_property_grid_thumb_sizes = $settings['ere_property_grid_thumb_sizes'];


		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}


		if ( $settings['offset'] ) {
			$offset = $settings['offset'] + ($paged - 1 ) * $settings['posts_per_page'];
		} else {
			$offset = '';
		}

		// Basic Query
		$properties_args = array(
			'post_type'      => 'property',
			'posts_per_page' => $settings['posts_per_page'],
			'order'          => $settings['order'],
			'offset'         => $offset,
			'post_status'    => 'publish',
			'paged'          => $paged,
		);

		// Sorting
		if ( 'price' === $settings['orderby'] ) {
			$properties_args['orderby']  = 'meta_value_num';
			$properties_args['meta_key'] = 'REAL_HOMES_property_price';
		} else {
			// for date, title, menu_order and rand
			$properties_args['orderby'] = $settings['orderby'];
		}

		// Filter based on custom taxonomies
		$property_taxonomies = get_object_taxonomies( 'property', 'objects' );
		if ( ! empty( $property_taxonomies ) && ! is_wp_error( $property_taxonomies ) ) {
			foreach ( $property_taxonomies as $single_tax ) {
				$setting_key = $single_tax->name;
				if ( ! empty( $settings[ $setting_key ] ) ) {
					$properties_args['tax_query'][] = [
						'taxonomy' => $setting_key,
						'field'    => 'slug',
						'terms'    => $settings[ $setting_key ],
					];
				}
			}

			if ( isset( $properties_args['tax_query'] ) && count( $properties_args['tax_query'] ) > 1 ) {
				$properties_args['tax_query']['relation'] = 'AND';
			}
		}

		$meta_query = array();
		if ( 'yes' === $settings['show_only_featured'] ) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_featured',
				'value'   => 1,
				'compare' => '=',
				'type'    => 'NUMERIC',
			);

			$properties_args['meta_query'] = $meta_query;
		}


		$properties_query = new WP_Query( apply_filters( 'rhea_classic_properties_widget', $properties_args ) );
		?>

        <div id="rh-<?php echo $this->get_id(); ?>" class="rh_elementor_widget rhea_properties_default_classic rhea_ele_property_ajax_target rhea_latest_properties_ajax_classic">

        <div class="home-properties-section-inner-target">
            <div class="classic_properties_elementor_wrapper rh_properties_pagination_append">

				<?php
				if ( $properties_query->have_posts() ) {

					while ( $properties_query->have_posts() ) {

						$properties_query->the_post();
						?>

                        <div class="rhea_property_wrapper">
                            <div class="rhea_classic_property_inner">
                                <div class="rhea_property_container">

                                    <h4 class="rhea_property_title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>

                                    <div class="rhea_property_detail_box">
                                        <div class="rhea_property_thumb">
                                            <div class="rhea_thumb_inner">
                                                <a href="<?php the_permalink() ?>">
													<?php
													if ( has_post_thumbnail( get_the_ID() ) ) {

														the_post_thumbnail( $ere_property_grid_thumb_sizes );
													} else {
														inspiry_image_placeholder( $ere_property_grid_thumb_sizes );
													}
													?>
                                                </a>
												<?php

												rhea_display_property_label( get_the_ID() );

												if ( ere_get_property_statuses( get_the_ID() ) ) {
													?>
                                                    <span class="rhea_property_status">
                                <?php
                                echo ere_get_property_statuses( get_the_ID() );
                                ?>
                                </span>
													<?php
												}
												?>
                                            </div>
                                        </div>
                                        <div class="rhea_property_detail">
                                            <div class="rhea_property_price_bar">
                                                <h5 class="rhea_prop_card__price">
                                                    <span class="rhea_price">
                                                        	<?php
	                                                        if ( function_exists( 'ere_property_price' ) ) {
		                                                        ere_property_price();
	                                                        }
	                                                        ?>
                                                    </span>
	                                                <?php
	                                                if ( function_exists( 'ere_get_property_types' ) ) {
		                                                echo ere_get_property_types( get_the_id() );
	                                                }
	                                                ?>
                                                </h5>
                                            </div>
                                            <div class="rhea_property_excerpt">
                                                <p class="rhea_prop_card__excerpt"><?php rhea_framework_excerpt( esc_html( $prop_excerpt_length ) ); ?></p>
                                                <a class="rhea_more_details" href="<?php the_permalink(); ?>">
													<?php
													if ( ! empty( $property_more_detail_label ) ) {
														echo esc_html( $property_more_detail_label );
													} else {
														esc_html_e( 'More Details ', 'realhomes-elementor-addon' );
													}
													?>
                                                    <i
                                                            class="fa fa-caret-right"></i></a>
                                                </a>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="rhea_property_meta_container">
									<?php
									rhea_get_template_part( 'assets/partials/classic-metas' );
									?>
                                </div>
                            </div>
                        </div>
						<?php
					}
					wp_reset_postdata();
				} else {
					?>
                    <div class="alert-wrapper">
                        <h4><?php esc_html_e( 'No Properties Found!', 'realhomes-elementor-addon' ) ?></h4>
                    </div>
					<?php
				}
				?>


            </div>
	        <?php
	        if('yes' == $settings['show_pagination']){
		        ?>

                <div class="rhea_svg_loader">
			        <?php include RHEA_ASSETS_DIR . '/icons/loading-bars.svg'; ?>
                </div>
		        <?php

		        RHEA_ajax_pagination( $properties_query->max_num_pages );
	        }
	        ?>
        </div>


        </div>


		<?php
	}
}