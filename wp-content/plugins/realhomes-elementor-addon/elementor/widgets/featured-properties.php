<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Featured_Properties_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-featured-properties-widget';
	}

	public function get_title() {
		return esc_html__( 'Featured Properties Carousel', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		);

		$this->start_controls_section(
			'ere_featured_properties_section',
			[
				'label' => esc_html__( 'Featured Properties Carousel', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
			'featured_excerpt_length',
			[
				'label'   => esc_html__( 'Excerpt Length (Words)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 5,
				'max'     => 100,
				'default' => 15,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);



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
			'ere_show_property_media_count',
			[
				'label'        => esc_html__( 'Show Property Media Count', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
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

		$this->add_control(
			'show_date',
			[
				'label'        => esc_html__( 'Show Date', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'ere_choose_post_time_formats',
			[
				'label'     => esc_html__( 'Post Date Format', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => [
					'default' => esc_html__( 'Default', 'realhomes-elementor-addon' ),
					'human'   => esc_html__( 'Human Readable', 'realhomes-elementor-addon' ),
				],
				'default'   => 'default',
				'condition' => [
					'show_date' => 'yes',
				],

			]
		);

		$this->add_control(
			'ere_choose_post_time_format_option',
			[
				'label'      => esc_html__( 'Post Date Format Options', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SELECT,
				'options'    => [
					'F j, Y'           => esc_html__( 'November 6, 2010', 'realhomes-elementor-addon' ),
					'F j, Y g:i a'     => esc_html__( 'November 6, 2010 12:50 am', 'realhomes-elementor-addon' ),
					'F, Y'             => esc_html__( 'November, 2010', 'realhomes-elementor-addon' ),
					'g:i a'            => esc_html__( '12:50 am', 'realhomes-elementor-addon' ),
					'l, F jS, Y'       => esc_html__( 'Saturday, November 6th, 20', 'realhomes-elementor-addon' ),
					'M j, Y @ G:i'     => esc_html__( 'Nov 6, 2010 @ 0:50', 'realhomes-elementor-addon' ),
					'Y/m/d \a\t g:i A' => esc_html__( '2010/11/06 at 12:50 AM', 'realhomes-elementor-addon' ),
					'Y/m/d \a\t g:ia'  => esc_html__( '2010/11/06 at 12:50am', 'realhomes-elementor-addon' ),
					'Y/m/d g:i:s A'    => esc_html__( '2010/11/06 12:50:48 AM', 'realhomes-elementor-addon' ),
					'Y/m/d'            => esc_html__( ' 2010/11/06', 'realhomes-elementor-addon' ),
				],
				'default'    => 'F j, Y',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_date',
							'operator' => '==',
							'value'    => 'yes'
						],
						[
							'name'     => 'ere_choose_post_time_formats',
							'operator' => '==',
							'value'    => 'default'
						],
					]
				],
			]
		);


		$this->add_control(
			'ere_enable_fav_properties',
			[
				'label'        => esc_html__( 'Show Add To Favourite Button', 'realhomes-elementor-addon' ),
				'description'  => wp_kses(__('<strong>Important:</strong> Make sure to select <strong>Show</strong> in Customizer <strong>Favorites</strong> settings. ','realhomes-elementor-addon'),$allowed_html),
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
				'description'  => wp_kses(__('<strong>Important:</strong> Make sure <strong>Compare Properties</strong> is <strong>enabled</strong> in Customizer settings. ','realhomes-elementor-addon'),$allowed_html),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'ere_featured_typo_section',
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
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor h3 a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_excerpt_typography',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__excerpt',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_added_typography',
				'label'    => esc_html__( 'Added', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_added_sty span',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_added_date_typography',
				'label'    => esc_html__( 'Date', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_added_sty',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_label_typography',
				'label'    => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_meta_titles',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_figure_typography',
				'label'    => esc_html__( 'Figure', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta .figure',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_area_postfix_typography',
				'label'    => esc_html__( 'Figure Postfix', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta .label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_status_typography',
				'label'    => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__status',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_price_typography',
				'label'    => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__price',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'ere_featured_properties_labels',
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
			'ere_property_added_label',
			[
				'label'   => esc_html__( 'Date Prefix', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Added:', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_property_added_ago_label',
			[
				'label'     => esc_html__( 'Date Postfix', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'ago', 'realhomes-elementor-addon' ),
				'condition' => [
					'ere_choose_post_time_formats' => 'human',
				],
			]
		);

		$this->add_control(
			'ere_property_fav_label',
			[
				'label' => esc_html__( 'Add To Favourite', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Add To Favourite', 'realhomes-elementor-addon' ),
			]
		);
		$this->add_control(
			'ere_property_fav_added_label',
			[
				'label' => esc_html__( 'Added To Favourite', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
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
			'ere_feature_properties_sizes',
			[
				'label' => esc_html__( 'Slider Sizes', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_featured_slider_width',
			[
				'label'           => esc_html__( 'Slider width (%)', 'realhomes-elementor-addon' ),
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
					'size' => 52,
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor' => 'max-width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_slide_content_width',
			[
				'label'           => esc_html__( 'Slide Contents Width (%)', 'realhomes-elementor-addon' ),
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
					'size' => 82,
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_wrapper--featured_elementor .rh_prop_card__featured' => 'max-width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_property_content_padding',
			[
				'label'      => esc_html__( 'Content Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_prop_card__featured' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_featured_slide_content_position',
			[
				'label'           => esc_html__( 'Slide Contents Position (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => - 150,
						'max' => 0,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => - 70,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_wrapper--featured_elementor .rh_prop_card__featured' => 'margin-top: {{SIZE}}{{UNIT}};',

				],
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
				'label'       => esc_html__( 'Meta Label', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Add Label', 'realhomes-elementor-addon' ),
			]
		);



		$this->add_control(
			'rhea_add_meta_select',
			[
				'label'       => esc_html__( 'Add Meta', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $meta_repeater->get_controls(),
				'default' => $meta_defaults,
				'title_field' => ' {{{ rhea_meta_repeater_label }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_feature_properties_nav_button',
			[
				'label' => esc_html__( 'Slider Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ere_featured_properties_one_enable_slideshow',
			[
				'label'        => esc_html__( 'Slideshow', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'ere_featured_one_properties_slideshow_speed',
			[
				'label'   => esc_html__( 'Slideshow Speed (ms)', 'realhomes-elementor-addon' ),
				'condition'       => [
					'ere_featured_properties_one_enable_slideshow' => 'yes',
				],
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1000,
				'max'     => 20000,
				'step'    => 1000,
				'default' => 4000,
			]
		);

		$this->add_control(
			'ere_featured_one_properties_animation_speed',
			[
				'label'   => esc_html__( 'Animation Speed (ms)', 'realhomes-elementor-addon' ),
				'condition'       => [
					'ere_featured_properties_one_enable_slideshow' => 'yes',
				],
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 10000,
				'step'    => 100,
				'default' => 2000,
			]
		);

		$this->add_control(
			'ere_featured_one_properties_animation_type',
			[
				'label'     => esc_html__( 'Animation Type', 'realhomes-elementor-addon' ),
				'condition' => [
					'ere_featured_properties_one_enable_slideshow' => 'yes',
				],
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => [
					'fade'  => esc_html__( 'Fade', 'realhomes-elementor-addon' ),
					'slide' => esc_html__( 'Slide', 'realhomes-elementor-addon' ),
				],
				'default'   => 'fade',
			]
		);

		$this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'ere_show_featured_nav_buttons',
			[
				'label'        => esc_html__( 'Show Slider Nav Buttons', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'ere_featured_nav_position_horizontal',
			[
				'label'           => esc_html__( 'Nav Button Horizontal Position (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'size_units' => [ '%', 'px' ],
				'range'           => [
					'%' => [
						'min' => - 200,
						'max' => 200,
					],
                    'px' => [
						'min' => - 2000,
						'max' => 2000,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => - 22,
					'unit' => '%',
				],
				'tablet_default'  => [
					'size' => -8,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor .rh_flexslider__prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor .rh_flexslider__next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_nav_position_vertical',
			[
				'label'           => esc_html__( 'Nav Buttons Vertical Position (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
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
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor a' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_nav_button_size',
			[
				'label'           => esc_html__( 'Nav Buttons Size (px)', 'realhomes-elementor-addon' ),
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
				'desktop_default' => [
					'size' => 73,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_nav_button_arrow_size',
			[
				'label'           => esc_html__( 'Nav Buttons Arrow Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'ere_show_featured_nav_buttons' => 'yes',
				],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rh_section__featured_elementor .rh_flexslider__nav_elementor a svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_feature_properties_spaces',
			[
				'label' => esc_html__( 'Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_featured_main_title_margin',
			[
				'label' => esc_html__( 'Title Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_excerpt_margin',
			[
				'label' => esc_html__( 'Excerpt Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_date_margin_bottom',
			[
				'label'           => esc_html__( 'Date Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_added_sty'                                     => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_rvr_ratings_wrapper_stylish .rhea_rvr_ratings' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_meta_margin',
			[
				'label' => esc_html__( 'Meta Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__meta_wrap_elementor' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_featured_status_margin',
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
					'{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__status' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'ere_feature_properties_styles',
			[
				'label' => esc_html__( 'Property Colors', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .rhea_media' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .rhea_media:hover' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .rhea_media'     => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_media svg' => 'fill: {{VALUE}}',
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
					'{{WRAPPER}} .rhea_media:hover'     => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_media:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_featured_label_bg_color',
			[
				'label'     => esc_html__( 'Feature Tag Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_label_elementor'      => 'background: {{VALUE}}',
					'{{WRAPPER}} .rh_label_elementor span' => 'border-left-color: {{VALUE}}; border-right-color: {{VALUE}};',
					'{{WRAPPER}} [data-tooltip]::after'    => 'background: {{VALUE}}',
					'{{WRAPPER}} [data-tooltip]::before'   => 'border-top-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_featured_label_text_color',
			[
				'label'     => esc_html__( 'Feature Tag Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_label_elementor .rh_label__wrap_elementor' => 'color: {{VALUE}}',
					'{{WRAPPER}} [data-tooltip]::after'                         => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_heading_color',
			[
				'label'     => esc_html__( 'Property Heading', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor h3 a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_heading_hover_color',
			[
				'label'     => esc_html__( 'Property Heading Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor h3 a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_excerpt_color',
			[
				'label'     => esc_html__( 'Property Excerpt', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__excerpt' => 'color: {{VALUE}}',
				],
			]
		);



		$this->add_control(
			'rhea_property_added',
			[
				'label'     => esc_html__( 'Date Added', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_added_sty span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_property_added_date',
			[
				'label'     => esc_html__( 'Date', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_added_sty' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'ere_property_meta_label_color',
			[
				'label'     => esc_html__( 'Meta Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_meta_titles' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_meta_svg_color',
			[
				'label'     => esc_html__( 'SVG Meta Icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_guests' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_property_meta_figure_color',
			[
				'label'     => esc_html__( 'Meta Figure', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta .figure' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__meta .label'  => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_property_status_color',
			[
				'label'     => esc_html__( 'Status', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__status' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .rh_prop_card .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__price' => 'color: {{VALUE}}',
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
						'{{WRAPPER}} .rh_rvr_price_rating_wrapper .rating-stars i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .rhea_stars_avg_rating .rhea_rating_percentage .rhea_rating_line .rhea_rating_line_inner' => 'background: {{VALUE}};',
						'{{WRAPPER}} .rating-stars i.rated' => 'color: {{VALUE}};',
					],
				]
			);
		}

		$this->add_control(
			'ere_nav_button_color',
			[
				'label'     => esc_html__( 'Slider Nav Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_flexslider__nav_elementor a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_nav_button_hover_color',
			[
				'label'     => esc_html__( 'Slider Nav Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_flexslider__nav_elementor a:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_nav_button_arrow_color',
			[
				'label'     => esc_html__( 'Slider Nav Button Arrow', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_flexslider__nav_elementor a svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_nav_button_arrow_hover_color',
			[
				'label'     => esc_html__( 'Slider Nav Button Arrow Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_flexslider__nav_elementor a:hover svg' => 'fill: {{VALUE}}',
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
					'{{WRAPPER}} .rhea_add_to_compare svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .rhea_add_to_compare:hover svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .highlight svg path'            => 'fill: {{VALUE}};',
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
			'ere_featured_properties_box_shadow',
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
				'selector' => '{{WRAPPER}} .rh_section__featured_elementor .rh_prop_card__featured',
			]
		);


		$this->end_controls_section();


	}

	protected function render() {
		global $settings;
		global $widget_id;

		$widget_id = $this->get_id();
		$settings = $this->get_settings_for_display();

		// Number of Properties
		if ( ! $settings['number_of_properties'] ) {
			$settings['number_of_properties'] = 5;
		}


		// Featured Properties Query Arguments.
		$featured_properties_args = array(
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

		if ( 'price' === $settings['orderby'] ) {
			$featured_properties_args['orderby']  = 'meta_value_num';
			$featured_properties_args['meta_key'] = 'REAL_HOMES_property_price';
		} else {
			// for date, title, menu_order and rand
			$featured_properties_args['orderby'] = $settings['orderby'];
		}


		$featured_properties_query = new WP_Query( apply_filters( 'rhea_modern_featured_properties_widget', $featured_properties_args ) );

		if ( $featured_properties_query->have_posts() ) {

			?>
            <section class="rh_elementor_widget rh_wrapper--featured_elementor">
				<?php


				if ( $featured_properties_query->have_posts() ) {
					?>
                    <div class="rh_section__featured rh_section__featured_elementor clearfix" id="rh-<?php echo esc_attr( $this->get_id() ); ?>">
                        <div class="flexslider loading">
                            <ul class="slides">
								<?php
								while ( $featured_properties_query->have_posts() ) {
									$featured_properties_query->the_post();
									rhea_get_template_part( 'assets/partials/home-featured-property' );
								}
								wp_reset_postdata();
								?>
                            </ul>
                        </div>

						<?php
						if ( $settings['ere_show_featured_nav_buttons'] == 'yes' ) {
							?>

                            <div class="rh_flexslider__nav_elementor">
                                <a href="#" class="flex-prev rh_flexslider__prev nav-mod">
									<?php include RHEA_ASSETS_DIR . '/icons/left.svg'; ?>
                                </a>
                                <a href="#" class="flex-next rh_flexslider__next nav-mod">
									<?php include RHEA_ASSETS_DIR . '/icons/right.svg'; ?>
                                </a>
                            </div>
							<?php
						}
						?>

                    </div>
					<?php
				}
				?>

            </section>

            <?php
            /**
            * Featured Properties Slider Settings
            */
            $slideshow = ( 'yes' === $settings['ere_featured_properties_one_enable_slideshow'] ) ? 'true' : 'false';
            $slideshow_speed = ( ! empty( $settings['ere_featured_one_properties_slideshow_speed'] ) ) ? $settings['ere_featured_one_properties_slideshow_speed'] : 4000;
            $slideshow_animation_speed = ( ! empty( $settings['ere_featured_one_properties_animation_speed'] ) ) ? $settings['ere_featured_one_properties_animation_speed'] : 2000;
            $slideshow_animation_type = ( ! empty( $settings['ere_featured_one_properties_animation_type'] ) ) ? $settings['ere_featured_one_properties_animation_type'] : "fade";
            ?>

            <script type="application/javascript">
                function RHEAloadFeaturedProperties() {
                    if (jQuery().flexslider) {
                        jQuery('#rh-<?php echo esc_attr( $this->get_id() );?> .flexslider').each(function () {
                            jQuery(this).flexslider({
                                slideshow: <?php echo $slideshow; ?>,
                                slideshowSpeed: <?php echo $slideshow_speed; ?>,
                                animationSpeed: <?php echo $slideshow_animation_speed; ?>,
                                animation: "<?php echo $slideshow_animation_type; ?>",
                                pauseOnHover: true,
                                directionNav: true,
                                controlNav: false,
                                keyboardNav: true,
                                // directionNav: false,
                                // customDirectionNav: $(".rh_flexslider__nav_main_gallery .nav-mod"),
                                customDirectionNav: jQuery(this).next('.rh_flexslider__nav_elementor').find('.nav-mod'),
                                start: function (slider) {
                                    slider.removeClass('loading');
                                }
                            });
                        });
                    }
                }

                RHEAloadFeaturedProperties();
                jQuery(document).on('ready', RHEAloadFeaturedProperties);


            </script>
			<?php
		}

	}

}

?>