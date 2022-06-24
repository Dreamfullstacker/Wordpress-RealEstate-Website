<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Properties_Widget_Four extends \Elementor\Widget_Base {
	public function get_name() {
		return 'rhea-properties-widget-4';
	}

	public function get_title() {
		return esc_html__( 'Properties Grid Four', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		// More classes for icons can be found at https://pojome.github.io/elementor-icons/
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
		unset( $prop_grid_size_array['gallery-two-column-image'] );
		unset( $prop_grid_size_array['post-featured-image'] );

		$default_prop_grid_size = 'property-thumb-image';


		$allowed_html = array(
			'a'      => array(
				'href'  => array(),
				'title' => array()
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
		);

		$this->start_controls_section(
			'ere_properties_section',
			[
				'label' => esc_html__( 'Properties', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'grid-style',
			[
				'label'   => esc_html__( 'Grid Style', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( 'Default', 'realhomes-elementor-addon' ),
					'2' => esc_html__( 'Two Column', 'realhomes-elementor-addon' ),
					'3' => esc_html__( 'Three Column', 'realhomes-elementor-addon' ),
				],
				'default' => '1',
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
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Properties', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 60,
				'step'    => 1,
				'default' => 5,
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
			'rhea_show_pagination',
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

		$this->add_control(
			'ere_show_property_media_count',
			[
				'label'        => esc_html__( 'Show Property Media Count', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'ere_show_featured_tag',
			[
				'label'        => esc_html__( 'Show Featured Tag', 'realhomes-elementor-addon' ),
				'description'  => wp_kses( __( 'Show if property is set to featured', 'realhomes-elementor-addon' ), $allowed_html ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'ere_show_label_tags',
			[
				'label'        => esc_html__( 'Show Property Label Tag', 'realhomes-elementor-addon' ),
				'description'  => wp_kses( __( 'Show if property label text is set', 'realhomes-elementor-addon' ), $allowed_html ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		$this->add_control(
			'ere_show_property_status',
			[
				'label'        => esc_html__( 'Show Property Status', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		$this->add_control(
			'ere_enable_fav_properties',
			[
				'label'        => esc_html__( 'Show Add To Favourite Button', 'realhomes-elementor-addon' ),
				'description'  => wp_kses( __( '<strong>Important:</strong> Make sure to select <strong>Show</strong> in Customizer <strong>Favorites</strong> settings. ', 'realhomes-elementor-addon' ), $allowed_html ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'ere_enable_compare_properties',
			[
				'label'        => esc_html__( 'Show Add To Compare Button  ', 'realhomes-elementor-addon' ),
				'description'  => wp_kses( __( '<strong>Important:</strong> Make sure <strong>Compare Properties</strong> is <strong>enabled</strong> in Customizer settings. ', 'realhomes-elementor-addon' ), $allowed_html ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);


		if ( inspiry_is_rvr_enabled() ) {
			$this->add_control(
				'rhea_rating_enable',
				[
					'label'        => esc_html__( 'Show Ratings?', 'realhomes-elementor-addon' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
					'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
		}


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
				'name'      => 'property_top_heading_typography',
				'label'     => esc_html__( 'Top Column Heading', 'realhomes-elementor-addon' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'condition' => [
					'grid-style' => '1',
				],
				'selector'  => '{{WRAPPER}} .rhea_latest_properties_4.rhea_grid_style_1 .rhea_property_grid_4:nth-of-type(5n+1) .rhea_heading_stylish a,
			            	{{WRAPPER}} .rhea_latest_properties_4.rhea_grid_style_1 .rhea_property_grid_4:nth-of-type(5n+2) .rhea_heading_stylish a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_heading_typography',
				'label'    => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} h3.rhea_heading_stylish a',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_meta_labels_typography',
				'label'    => esc_html__( 'Meta Labels', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta .rhea_meta_titles',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_meta_figures_typography',
				'label'    => esc_html__( 'Figures', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta .figure',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_meta_postfix_typography',
				'label'    => esc_html__( 'Figure Postfix', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta .label',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_status_typography',
				'label'    => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__priceLabel_sty span.rh_prop_card__status_sty',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'property_top_price_typography',
				'label'     => esc_html__( 'Two Column Price', 'realhomes-elementor-addon' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'condition' => [
					'grid-style' => '1',
				],
				'selector'  => '{{WRAPPER}} .rhea_latest_properties_4.rhea_grid_style_1 .rhea_property_grid_4:nth-of-type(5n+1) .rh_prop_card__price_sty ,
			            	{{WRAPPER}} .rhea_latest_properties_4.rhea_grid_style_1 .rhea_property_grid_4:nth-of-type(5n+2) .rh_prop_card__price_sty',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_price_typography',
				'label'    => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__priceLabel_sty .rh_prop_card__price_sty',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_postfix_typography',
				'label'    => esc_html__( 'Price Postfix', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__priceLabel_sty .rh_prop_card__price_sty span',
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'ere_properties_labels',
			[
				'label' => esc_html__( 'Property Labels', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_property_featured_label',
			[
				'label'   => esc_html__( 'Featured', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Featured', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_property_fav_label',
			[
				'label'   => esc_html__( 'Add To Favourite', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Add To Favourite', 'realhomes-elementor-addon' ),
			]
		);
		$this->add_control(
			'ere_property_fav_added_label',
			[
				'label'   => esc_html__( 'Added To Favourite', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Added To Favourite', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_property_compare_label',
			[
				'label'   => esc_html__( 'Add To Compare', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Add To Compare', 'realhomes-elementor-addon' ),
			]
		);
		$this->add_control(
			'ere_property_compare_added_label',
			[
				'label'   => esc_html__( 'Added To Compare', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Added To Compare', 'realhomes-elementor-addon' ),
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_properties_meta_settings',
			[
				'label' => esc_html__( 'Meta Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$get_meta = array(
			'bedrooms'   => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
			'bathrooms'  => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
			'area'       => esc_html__( 'Area', 'realhomes-elementor-addon' ),
			'garage'     => esc_html__( 'Garages/Parking', 'realhomes-elementor-addon' ),
			'year-built' => esc_html__( 'Year Built', 'realhomes-elementor-addon' ),
			'lot-size'   => esc_html__( 'Lot Size', 'realhomes-elementor-addon' ),
		);

		$meta_defaults = array(
			array(
				'rhea_property_meta_display' => 'bedrooms',
				'rhea_meta_repeater_label'   => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
			),
			array(
				'rhea_property_meta_display' => 'bathrooms',
				'rhea_meta_repeater_label'   => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
			),
			array(
				'rhea_property_meta_display' => 'area',
				'rhea_meta_repeater_label'   => esc_html__( 'Area', 'realhomes-elementor-addon' ),
			),
		);

		if ( inspiry_is_rvr_enabled() ) {
			$get_meta = array(
				'bedrooms'   => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
				'bathrooms'  => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
				'area'       => esc_html__( 'Area', 'realhomes-elementor-addon' ),
				'garage'     => esc_html__( 'Garages/Parking', 'realhomes-elementor-addon' ),
				'year-built' => esc_html__( 'Year Built', 'realhomes-elementor-addon' ),
				'lot-size'   => esc_html__( 'Lot Size', 'realhomes-elementor-addon' ),
				'guests'     => esc_html__( 'Guests Capacity', 'realhomes-elementor-addon' ),
				'min-stay'   => esc_html__( 'Min Stay', 'realhomes-elementor-addon' ),
			);

			$meta_defaults = array(
				array(
					'rhea_property_meta_display' => 'bedrooms',
					'rhea_meta_repeater_label'   => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
				),
				array(
					'rhea_property_meta_display' => 'bathrooms',
					'rhea_meta_repeater_label'   => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
				),
				array(
					'rhea_property_meta_display' => 'guests',
					'rhea_meta_repeater_label'   => esc_html__( 'Guests', 'realhomes-elementor-addon' ),
				),
				array(
					'rhea_property_meta_display' => 'area',
					'rhea_meta_repeater_label'   => esc_html__( 'Area', 'realhomes-elementor-addon' ),
				),
			);

		}


		$meta_repeater = new \Elementor\Repeater();


		$meta_repeater->add_control(
			'rhea_property_meta_display',
			[
				'label'   => esc_html__( 'Select Meta', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $get_meta,
			]
		);

		$meta_repeater->add_control(
			'rhea_meta_repeater_label',
			[
				'label'   => esc_html__( 'Meta Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Add Label', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_control(
			'rhea_add_meta_select',
			[
				'label'       => esc_html__( 'Add Meta', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $meta_repeater->get_controls(),
				'default'     => $meta_defaults,
				'title_field' => ' {{{ rhea_meta_repeater_label }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_property_sizes',
			[
				'label' => esc_html__( 'Sizes & Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'ere_top_property_content_padding',
			[
				'label'      => esc_html__( 'Two Column Content Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_latest_properties_4.rhea_grid_style_1 .rhea_property_grid_4:nth-of-type(5n+1) .rhea_meta_wrapper_4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rhea_latest_properties_4.rhea_grid_style_1 .rhea_property_grid_4:nth-of-type(5n+2) .rhea_meta_wrapper_4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'grid-style' => '1',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_content_padding',
			[
				'label'      => esc_html__( 'Content Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_meta_wrapper_4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_title_margin_bottom',
			[
				'label'           => esc_html__( 'Title Margin Top (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} h3.rhea_heading_stylish a' => 'margin-top: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_prop_card_meta_icon_size',
			[
				'label' => esc_html__( 'Meta Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_top_prop_status_margin_bottom',
			[
				'label' => esc_html__( 'Two Column Status Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_latest_properties_4.rhea_grid_style_1 .rhea_property_grid_4:nth-of-type(5n+1) .rhea_price_box_4 span.rh_prop_card__status_sty' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_latest_properties_4.rhea_grid_style_1 .rhea_property_grid_4:nth-of-type(5n+2) .rhea_price_box_4 span.rh_prop_card__status_sty' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'       => [
					'grid-style' => '1',
				],
			]
		);

		$this->add_responsive_control(
			'ere_prop_status_margin_bottom',
			[
				'label' => esc_html__( 'Status Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__priceLabel_sty span.rh_prop_card__status_sty' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'properties_grid_border_radius',
			[
				'label' => esc_html__( 'Property Card Border Radius (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_property_grid_inner_4' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_thumbnail_bg_4 .rhea_thumbnail_bg_4_inner' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_latest_properties_4 .rhea_top_tags_box' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_property_color',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rhea_property_background_color',
			[
				'label'     => esc_html__( 'Property Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_top_meta_bg',
			[
				'label'     => esc_html__( 'Top Meta Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_top_tags_box' => 'background: linear-gradient( {{VALUE}}, rgba(255,255,255,0))',
				],
			]
		);


		$this->add_control(
			'rhea_media_count_bg_color',
			[
				'label'     => esc_html__( 'Media Count Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_media' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_media_count_bg_hover_color',
			[
				'label'     => esc_html__( 'Media Count Background Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_media:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_media_count_color',
			[
				'label'     => esc_html__( 'Media Count Icon/Number Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_media'     => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_media svg' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_media_count_hover_color',
			[
				'label'     => esc_html__( 'Media Count Icon/Number Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_media:hover'     => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_media:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_tag_feature_bg',
			[
				'label'     => esc_html__( 'Featured Tag Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_featured:before' => 'border-left-color: {{VALUE}};border-right-color: {{VALUE}};border-top-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_tag_feature_icon',
			[
				'label'     => esc_html__( 'Featured Tag Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_featured svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_tag_label_bg',
			[
				'label'     => esc_html__( 'Label Tag Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_hot:before' => 'border-left-color: {{VALUE}};border-right-color: {{VALUE}};border-top-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_tag_label_icon',
			[
				'label'     => esc_html__( 'Label Tag Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_hot svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_tag_tooltip',
			[
				'label'     => esc_html__( 'Tag Tooltip Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-tags .rhea_tags_tooltip_inner' => 'background: {{VALUE}};',
					'{{WRAPPER}} .rhea-tags .rhea_tags_tooltip:after' => 'border-top-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_tag_tooltip_text',
			[
				'label'     => esc_html__( 'Tag Tooltip Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-tags .rhea_tags_tooltip_inner' => 'color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'rhea_agent_area_bg',
			[
				'label'     => esc_html__( 'Type/Status Bar Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_grid_inner_4 .rhea_title_btn_wrapper_4' => 'background: linear-gradient(rgba(255,255,255,0), {{VALUE}} )',
				],
			]
		);


		$this->add_control(
			'rhea_property_title_color',
			[
				'label'     => esc_html__( 'Property Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} h3.rhea_heading_stylish a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_property_title_color_hover',
			[
				'label'     => esc_html__( 'Property Title Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} h3.rhea_heading_stylish a:hover' => 'color: {{VALUE}};',
				],
			]
		);


		if ( inspiry_is_rvr_enabled() ) {
			$this->add_control(
				'rhea_property_rating_stars',
				[
					'label'     => esc_html__( 'Rating Stars', 'realhomes-elementor-addon' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .rhea_rvr_ratings_wrapper_stylish .rating-stars i'                                        => 'color: {{VALUE}};',
						'{{WRAPPER}} .rhea_stars_avg_rating .rhea_rating_percentage .rhea_rating_line .rhea_rating_line_inner' => 'background: {{VALUE}};',
						'{{WRAPPER}} .rating-stars i.rated'                                                                    => 'color: {{VALUE}};',
					],
				]
			);
		}


		$this->add_control(
			'rhea_property_meta_label',
			[
				'label'     => esc_html__( 'Meta Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta .rhea_meta_titles' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_property_meta_icon',
			[
				'label'     => esc_html__( 'Meta Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta svg'          => 'fill: {{VALUE}};',
					'{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta .rhea_guests' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_property_meta_figure',
			[
				'label'     => esc_html__( 'Meta Figure', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta .figure' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_property_meta_area_post_fix',
			[
				'label'     => esc_html__( 'Figure Postfix', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card_meta_wrap_stylish .rh_prop_card__meta .label' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'rhea_property_status_color',
			[
				'label'     => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card__priceLabel_sty span.rh_prop_card__status_sty' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_property_price_color',
			[
				'label'     => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card__priceLabel_sty .rh_prop_card__price_sty' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'rhea_property_fav_icon_color',
			[
				'label'     => esc_html__( 'Favourite Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .add-to-favorite .rh_svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_property_fav_icon_hover_color',
			[
				'label'     => esc_html__( 'Favourite Icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .add-to-favorite:hover .rh_svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .highlight__red .rh_svg'        => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_property_icon_tooltips',
			[
				'label'     => esc_html__( 'Favourite Tooltip Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .add-to-favorite:before'      => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .favorite-placeholder:before' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .add-to-favorite:after'       => 'background: {{VALUE}};',
					'{{WRAPPER}} .favorite-placeholder:after'  => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_property_icon_tooltips_text',
			[
				'label'     => esc_html__( 'Favourite Tooltip Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .add-to-favorite:after'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .favorite-placeholder:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_property_compare_icon_color',
			[
				'label'     => esc_html__( 'Compare Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_add_to_compare svg path' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_property_compare_icon_color:hover',
			[
				'label'     => esc_html__( 'Compare Icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_add_to_compare:hover svg path' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .highlight svg path'                 => 'fill: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'rhea_property_compare_icon_tooltips',
			[
				'label'     => esc_html__( 'Compare Tooltip Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .add-to-compare-span [data-tooltip]:not([flow]):hover::before' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .add-to-compare-span [data-tooltip]:not([flow]):hover::after'  => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'rhea_property_compare_icon_tooltips_text',
			[
				'label'     => esc_html__( 'Compare Tooltip Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .add-to-compare-span [data-tooltip]:not([flow]):hover::after' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .rhea_property_grid_inner_4',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'rhea_properties_status_colors',
			[
				'label' => esc_html__( 'Status Over Image', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'rhea_property_status_padding',
			[
				'label'      => esc_html__( 'Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [],
				'selectors'  => [
					'{{WRAPPER}} .rhea_prop_status_sty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'property_status_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_prop_status_sty' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'rhea_property_status_typography',
				'label'    => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_prop_status_sty',
			]
		);

		$rhea_status_terms = get_terms( array(
			'taxonomy' => 'property-status',
		) );
		$get_status_terms  = array();
		foreach ( $rhea_status_terms as $rhea_term ) {
			$get_status_terms[ $rhea_term->slug ] = $rhea_term->name;
		}

		$status_repeater = new \Elementor\Repeater();
		$status_repeater->add_control(
			'rhea_property_status_select_section',
			[
				'label'   => esc_html__( 'Select Status', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $get_status_terms,
			]
		);
		$status_repeater->add_control(
			'rhea_get_terms_bg',
			[
				'label'   => esc_html__( 'Status Background Color', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '',

			]
		);
		$status_repeater->add_control(
			'rhea_get_terms_colors',
			[
				'label'   => esc_html__( 'Status Text Color', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '',

			]
		);
		$this->add_control(
			'rhea_property_status_select',
			[
				'label'       => esc_html__( 'Change Status Colors', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $status_repeater->get_controls(),
				'title_field' => ' {{{ rhea_property_status_select_section }}}',
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
				'default'   => '',
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
				'default'   => '',
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
				'default'   => '',
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
				'default'   => '',
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
		global $settings;
		global $properties_query;
		global $widget_id;

		$widget_id = $this->get_id();
		$settings = $this->get_settings_for_display();


		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		if ( $settings['offset'] ) {
			$offset = $settings['offset'] + ( $paged - 1 ) * $settings['posts_per_page']; // This fix the contradiction between offset and pagination
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

		if ( $settings['skip_sticky_properties'] !== 'yes' ) {
			$properties_args['meta_key']  = 'REAL_HOMES_sticky';
		}

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


		$properties_query = new WP_Query( apply_filters( 'rhea_modern_properties_widget', $properties_args ) );

		?>
        <section id="rh-<?php echo $this->get_id(); ?>"
                 class="rh_elementor_widget rhea_ele_property_ajax_target rhea_latest_properties_ajax rhea_has_tooltip">


			<?php
			if ( $properties_query->have_posts() ) {
				?>
                <div class="home-properties-section-inner-target">
                    <div class="rh_properties_pagination_append rhea_latest_properties_4 rhea_grid_style_<?php echo esc_attr( $settings['grid-style'] ) ?>">
						<?php

						$ere_property_grid_image = $settings['ere_property_grid_thumb_sizes'];
                        
						while ( $properties_query->have_posts() ) {
							$properties_query->the_post();

							if ( has_post_thumbnail( get_the_ID() ) ) {
								$thumb_url = get_the_post_thumbnail_url( get_the_ID(), $ere_property_grid_image );
							} else {
								$thumb_url = inspiry_get_raw_placeholder_url( $ere_property_grid_image );
							}
							?>
                            <div class="rhea_property_grid_4">
                                <div class="rhea_property_grid_inner_4">
                                    <div class="rhea_thumbnail_bg_4">
                                        <div class="rhea_thumbnail_bg_4_inner">
                                            <a href="<?php the_permalink(); ?>"
                                               style='background-image: url("<?php echo $thumb_url ?>")'></a>
                                        </div>
                                        <div class="rhea_top_tags_box">
											<?php
											if ( $settings['ere_show_property_media_count'] == 'yes' ) {
												rhea_get_template_part( 'assets/partials/stylish/media-count' );
											}
											rhea_get_template_part( 'assets/partials/stylish/tags' );
											?>
                                        </div>
                                        <div class="rhea_title_btn_wrapper_4">
                                            <div class="rhea_title_box_4">
												<?php
												if ( inspiry_is_rvr_enabled() && 'yes' == $settings['rhea_rating_enable'] ) {
													?>
                                                    <div class="rhea_rvr_ratings_wrapper_stylish rvr_rating_left">
														<?php
														rhea_rvr_rating_average();
														?>
                                                    </div>
													<?php
												} elseif ( $settings['ere_show_property_status'] == 'yes' ) {
													rhea_get_template_part( 'assets/partials/stylish/status' );
												}
												?>
                                                <h3 class="rhea_heading_stylish"><a
                                                            href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h3>
                                            </div>
                                            <div class="rhea_compare_fav_box_4">
                                                <div class="rhea_fav_icon_box rhea_parent_fav_button">

													<?php
													if ( 'yes' === $settings['ere_enable_fav_properties'] ) {
														if ( function_exists( 'inspiry_favorite_button' ) ) {
															inspiry_favorite_button( get_the_ID(), null, $settings['ere_property_fav_label'], $settings['ere_property_fav_added_label'] );
														}
													}
													rhea_get_template_part( 'assets/partials/stylish/compare' );
													?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rhea_meta_wrapper_4">

										<?php
										// Get price prefix & postfix.
										$price_prefix  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_price_prefix', true );
										$price_postfix = get_post_meta( get_the_ID(), 'REAL_HOMES_property_price_postfix', true );
										?>

                                        <div class="rhea_price_box_4">
                                            <div class="rh_prop_card__priceLabel_sty">
                                                <span class="rh_prop_card__status_sty">
                                                              <?php
                                                              if ( inspiry_is_rvr_enabled() ) {
	                                                              echo esc_html( $price_postfix );
                                                              } elseif ( function_exists( 'ere_get_property_statuses' ) ) {
	                                                              echo esc_html( ere_get_property_statuses( get_the_ID() ) );
                                                              }
                                                              ?>
                                                </span>
                                                <p class="rh_prop_card__price_sty">
													<?php
													if ( inspiry_is_rvr_enabled() ) {
														echo esc_html( $price_prefix ) . ' ' . esc_html( ere_get_property_price_plain() );
													} elseif ( function_exists( 'ere_property_price' ) ) {
														ere_property_price();
													}
													?>
                                                </p>
                                            </div>

                                        </div>
                                        <div class="rhea_meta_box_4">
											<?php
											rhea_get_template_part( 'assets/partials/stylish/grid-card-meta-smart' );
											?>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php
						}
						?>
                    </div>

					<?php
					if ( 'yes' == $settings['rhea_show_pagination'] ) {
						?>

                        <div class="rhea_svg_loader">
							<?php include RHEA_ASSETS_DIR . '/icons/loading-bars.svg'; ?>
                        </div>
						<?php

						RHEA_ajax_pagination( $properties_query->max_num_pages );
					}
					?>

                </div>
				<?php
				wp_reset_postdata();
			}


			?>
        </section>
		<?php
	}

}

?>