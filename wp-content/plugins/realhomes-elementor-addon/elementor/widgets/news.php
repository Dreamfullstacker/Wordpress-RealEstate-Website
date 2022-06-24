<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_News_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-news-widget-home';
	}

	public function get_title() {
		return esc_html__( 'News Grid', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'real-homes' ];
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
		unset( $prop_grid_size_array['post-featured-image'] );

		if ( INSPIRY_DESIGN_VARIATION == 'modern' ) {
			$default_prop_grid_size = 'modern-property-child-slider';
		} else {
			$default_prop_grid_size = 'gallery-two-column-image';
		}


		$this->start_controls_section(
			'ere_news_section',
			[
				'label' => esc_html__( 'News', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_news_grid_thumb_sizes',
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
				                 __( '* To apply this, make sure "Style -> News Width" field is empty.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => '33.333%',
				'options'     => array(
					'25%'     => esc_html__( '4 Columns *Full Width Content', 'realhomes-elementor-addon' ),
					'33.333%' => esc_html__( '3 Columns', 'realhomes-elementor-addon' ),
					'50%'     => esc_html__( '2 Columns', 'realhomes-elementor-addon' ),
					'100%'    => esc_html__( '1 Column', 'realhomes-elementor-addon' ),
				),
				'selectors'   => [
					'{{WRAPPER}} .rh_section__news_elementor article' => 'width: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Posts', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
				'default' => 3,
			]
		);

		// Select controls for Custom Taxonomies related to Property
		$property_taxonomies = get_object_taxonomies( 'post', 'objects' );
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
			'rhea_show_pagination',
			[
				'label'        => esc_html__( 'Show Pagination', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => esc_html__( 'Offset or Skip From Start', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '0'
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'        => esc_html__( 'Show Date', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'        => esc_html__( 'Show Category', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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
			'excerpt-length',
			[
				'label'   => esc_html__( 'Excerpt Length (Words)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 5,
				'max'     => 100,
				'default' => 18,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'        => esc_html__( 'Show Author Name', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_labels',
			[
				'label' => esc_html__( 'Labels', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_news_in_label',
			[
				'label'   => esc_html__( 'In', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'In', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_news_by_label',
			[
				'label'   => esc_html__( 'By', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'By', 'realhomes-elementor-addon' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_heading_typography',
				'label'    => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor h3 a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_date_typography',
				'label'    => esc_html__( 'Date', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .date',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_category_in_typography',
				'label'    => esc_html__( 'In', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .categories .category_in',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_category_typography',
				'label'    => esc_html__( 'Category', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .categories a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_excerpt_typography',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor p',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_by_author_typography',
				'label'    => esc_html__( 'By', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .by-author',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'news_author_typography',
				'label'    => esc_html__( 'Author', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_section__news_elementor .author-link',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_spacing_size',
			[
				'label' => esc_html__( 'Size', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'ere_news_single_sizes',
			[
				'label'       => esc_html__( 'News Width (%)', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'This will over-ride the width of "Content -> Layout"', 'realhomes-elementor-addon' ),

				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%','px' ],
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
					'{{WRAPPER}} .rh_section__news_elementor article' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_news_content_padding',
			[
				'label'      => esc_html__( 'Content Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rh-wrapper-post-contents_elementor' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_spacing_section',
			[
				'label' => esc_html__( 'Spacings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_news_vertical_spacings',
			[
				'label'           => esc_html__( 'News Bottom Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__news_elementor article' => 'padding-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_news_date_spacings',
			[
				'label'           => esc_html__( 'Date & Category Bottom Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__news_elementor .post_meta_elementor' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_news_title_spacings',
			[
				'label'           => esc_html__( 'Title Bottom Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__news_elementor h3.post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_news_excerpt_spacings',
			[
				'label'           => esc_html__( 'Excerpt Bottom Space (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__news_elementor p' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_colors_section',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ere_news_bg_color',
			[
				'label'     => esc_html__( 'News Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh-wrapper-post-contents_elementor' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_date_color',
			[
				'label'     => esc_html__( 'Date', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .date' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_category_in_color',
			[
				'label'     => esc_html__( 'In', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .categories .category_in' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_category_color',
			[
				'label'     => esc_html__( 'Category', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .categories a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_category_hover_color',
			[
				'label'     => esc_html__( 'Category Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .categories a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_heading_color',
			[
				'label'     => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor h3 a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_news_heading_hover_color',
			[
				'label'     => esc_html__( 'Heading Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor h3 a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_by_color',
			[
				'label'     => esc_html__( 'By', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .by-author' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_author_color',
			[
				'label'     => esc_html__( 'Author', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__news_elementor .author-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_news_gallery_circle_color',
			[
				'label'     => esc_html__( 'Gallery Arrows Circle', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .cls-1' => 'fill: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'ere_news_gallery_arrow_color',
			[
				'label'     => esc_html__( 'Gallery Arrows', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .cls-2' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_news_box_shadow',
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
				'selector' => '{{WRAPPER}} .rh_section__news_elementor article .rh_news_module_inner',
			]
		);

		$this->add_responsive_control(
			'news_border_radius',
			[
				'label'      => __( 'Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rh_section__news_elementor .flex-viewport img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0',
					'{{WRAPPER}} .rh_section__news_elementor article .rh_news_module_inner' => 'overflow: hidden; border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
				'label'      => esc_html__( 'Pagination Container Margin', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'rhea_pagination_link_padding',
			[
				'label'      => esc_html__( 'Pagination Links Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a' => 'border-radius: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_pagination_typography',
				'label'    => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_latest_properties_ajax .pagination a',
			]
		);

		$this->add_control(
			'rhea_pagination_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_pagination_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Hover/Current Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#d22d3e',
				'selectors' => [
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a:hover'   => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a.current' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_pagination_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#808080',
				'selectors' => [
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a:hover'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a.current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pagination_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea_latest_properties_ajax .pagination a',
			]
		);


		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();


		global $news_grid_size;
		$news_grid_size = $settings['ere_news_grid_thumb_sizes'];

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		if ( $settings['offset'] ) {
			$offset = $settings['offset'] + ( $paged - 1 ) * $settings['posts_per_page'];
		} else {
			$offset = '';
		}

		$news_args = array(
			'post_type'           => 'post',
			'posts_per_page'      => $settings['posts_per_page'],
			'ignore_sticky_posts' => 1,
			'order'               => $settings['order'],
			'orderby'             => $settings['orderby'],
			'offset'              => $offset,
			'paged'               => $paged,
			'meta_query'          => array(
				'relation' => 'OR',
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS'
				),
				array(
					'key'     => 'REAL_HOMES_embed_code',
					'compare' => 'EXISTS'
				),
				array(
					'key'     => 'REAL_HOMES_gallery',
					'compare' => 'EXISTS'
				)
			)
		);

		$news_args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field'    => 'slug',
				'terms'    => array( 'post-format-quote', 'post-format-link', 'post-format-audio' ),
				'operator' => 'NOT IN'
			)
		);

		// Filter based on taxonomies
		$post_taxonomies = get_object_taxonomies( 'post', 'objects' );
		if ( ! empty( $post_taxonomies ) && ! is_wp_error( $post_taxonomies ) ) {
			foreach ( $post_taxonomies as $single_tax ) {
				$setting_key = $single_tax->name;
				if ( ! empty( $settings[ $setting_key ] ) ) {
					$news_args['tax_query'][] = [
						'taxonomy' => $setting_key,
						'field'    => 'slug',
						'terms'    => $settings[ $setting_key ],
					];
				}
			}
			if ( isset( $news_args['tax_query'] ) && count( $news_args['tax_query'] ) > 1 ) {
				$news_args['tax_query']['relation'] = 'AND';
			}
		}

		$news_query = new WP_Query( apply_filters( 'rhea_modern_news_widget', $news_args ) );

		if ( $news_query->have_posts() ) {
			?>
            <section id="rh-<?php echo $this->get_id(); ?>"
                     class="rhea_ele_property_ajax_target rhea_latest_properties_ajax rh_elementor_widget rh_wrapper__news_elementor">
                <div class="home-properties-section-inner-target">
                    <div class="rh_properties_pagination_append rh_section__news_elementor">
						<?php
						while ( $news_query->have_posts() ) {

							$news_query->the_post();

							$format = get_post_format( get_the_ID() );

							if ( false === $format ) {
								$format = 'standard';
							}
							?>
                            <article <?php post_class(); ?>>

                                <div class="rh_news_module_inner">
                                    <div class="rh-wrapper-post-media">
										<?php rhea_get_template_part( "assets/partials/post-formats/modern/$format" ); ?>
                                    </div>

                                    <div class="rh-wrapper-post-contents_elementor">
										<?php
										if ( 'yes' == $settings['show_date'] || 'yes' == $settings['show_category'] ) {

											?>
                                            <div class="post_meta_elementor">
												<?php if ( 'yes' == $settings['show_date'] ) { ?>
                                                    <span class="date"> <?php the_time( get_option( 'date_format' ) ); ?></span>
													<?php
												}
												if ( 'yes' == $settings['show_category'] ) {
													$get_categories = get_the_category();
													if ( is_array( $get_categories ) && ! empty( $get_categories ) ) {
														?>
                                                        <span class="categories">
                                                <span class="category_in">
												<?php
												echo esc_html( $settings['ere_news_in_label'] );
												foreach ( $get_categories

												as $category ) {
												?>
                                                    </span>
                                                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_attr( $category->name ); ?></a><?php
															}
															?>
											</span>
														<?php
													}
												}
												?>
                                            </div>
											<?php
										}
										?>

                                        <h3 class="post-title"><a
                                                    href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

										<?php if ( 'yes' == $settings['show_excerpt'] ) { ?>
                                            <p><?php rhea_framework_excerpt( $settings['excerpt-length'] ); ?></p>
											<?php
										}
										if ( 'yes' == $settings['show_author'] ) {
											?>

                                            <span class="by-author"><span
                                                        class="rhea_by"><?php echo esc_html( $settings['ere_news_by_label'] ); ?></span><span
                                                        class="author-link"><?php the_author() ?></span></span>

										<?php } ?>
                                    </div>
                                </div>
                            </article>
							<?php
						}

						wp_reset_postdata();
						?>
                    </div>
					<?php
					if ( 'yes' == $settings['rhea_show_pagination'] ) {
						?>

                        <div class="rhea_svg_loader">
							<?php include RHEA_ASSETS_DIR . '/icons/loading-bars.svg'; ?>
                        </div>
						<?php

						RHEA_ajax_pagination( $news_query->max_num_pages );
					}
					?>
                </div>
            </section>
            <script type="application/javascript">

                function EREloadNewsSlider() {
                    if (jQuery().flexslider) {
                        jQuery('.listing-slider_elementor').each(function () {
                            jQuery(this).flexslider({
                                animation: "slide",
                                slideshow: false,
                                controlNav: false,

                                customDirectionNav: jQuery(this).next('.rh_flexslider__nav_main_gallery').find('.nav-mod'),
                            });
                        });
                    }
                }

                EREloadNewsSlider();

                jQuery(document).on('ready', EREloadNewsSlider);

            </script>
			<?php
		}

	}

}