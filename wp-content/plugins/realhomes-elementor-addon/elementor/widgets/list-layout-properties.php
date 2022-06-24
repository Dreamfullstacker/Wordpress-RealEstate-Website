<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_List_layout_Properties_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rhea-list-layout-properties-widget';
	}

	public function get_title() {
		return esc_html__( 'Properties List Layout', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		// More classes for icons can be found at https://pojome.github.io/elementor-icons/
		return 'eicon-post-list';
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
			'ere_properties_section',
			[
				'label' => esc_html__( 'Properties', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
			'prop_excerpt_length',
			[
				'label' => esc_html__( 'Excerpt Length (Words)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'default' => 10,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_address',
			[
				'label'        => esc_html__( 'Show Address', 'realhomes-elementor-addon' ),
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
				'condition' => [
					'show_pagination' => '',
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
			'ere_properties_sizes_spaces',
			[
				'label' => esc_html__( 'Sizes & Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_property_content_padding',
			[
				'label' => esc_html__( 'Content Area Padding', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .rh_prop_card__details_elementor' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_excerpt_bottom_margin',
			[
				'label'           => esc_html__( 'Excerpt Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_address_margin_bottom',
			[
				'label'           => esc_html__( 'Address Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_address_sty' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_prop_card_meta_wrap_margin',
			[
				'label'           => esc_html__( 'Meta Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
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
				'label'           => esc_html__( 'Meta Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,

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
			'ere_prop_card_meta_status_margin',
			[
				'label'           => esc_html__( 'Status Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__status' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_view_button_padding',
			[
				'label' => esc_html__( 'View Property Button Padding', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elementor_property_card_parent .rh_overlay__contents a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);



		$this->end_controls_section();


		$this->start_controls_section(
			'ere_properties_styles',
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
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_image_overlay_color',
			[
				'label'     => esc_html__( 'Image Overlay', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor_properties_grid .rh_overlay' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_new_property_button',
			[
				'label'     => esc_html__( 'View Button Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor_properties_grid .rh_overlay__contents a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_featured_label_bg_color',
			[
				'label'     => esc_html__( 'Feature Tag Tooltip Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor_properties_grid .rh_label_elementor'             => 'background: {{VALUE}}',
					'{{WRAPPER}} .elementor_properties_grid .rh_label_elementor span'        => 'border-left-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_property_featured_label_text_color',
			[
				'label'     => esc_html__( 'Feature Tag Tooltip Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor_properties_grid .rh_label_elementor .rh_label__wrap' => 'color: {{VALUE}}',
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
			'ere_property_heading_color',
			[
				'label'     => esc_html__( 'Property Heading', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor h3 a' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor h3 a:hover' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor .rh_prop_card__excerpt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_property_address_color',
			[
				'label'     => esc_html__( 'Address', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_address_sty a'                     => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea_address_sty .rhea_address_pin svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rhea_property_address_color_hover',
			[
				'label'     => esc_html__( 'Address Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_address_sty:hover a'                     => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea_address_sty:hover .rhea_address_pin svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_meta_titles' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor .rh_prop_card__meta svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_guests' => 'fill: {{VALUE}}',
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
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor .rh_prop_card__meta .figure' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor .rh_prop_card__meta .label'  => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__status' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .elementor_properties_grid .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__price' => 'color: {{VALUE}}',
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
						'{{WRAPPER}} .rhea_rvr_ratings_wrapper .rating-stars i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .rhea_stars_avg_rating .rhea_rating_percentage .rhea_rating_line .rhea_rating_line_inner' => 'background: {{VALUE}};',
						'{{WRAPPER}} .rating-stars i.rated' => 'color: {{VALUE}};',
					],
				]
			);
		}
		$this->add_control(
			'ere_property_fav_icon_color',
			[
				'label'     => esc_html__( 'Favourite Icon Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} a.add-to-favorite svg path ' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_property_fav_icon_hover_color',
			[
				'label'     => esc_html__( 'Favourite Icon Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .add-to-favorite:hover svg path' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .favorite-placeholder svg path' => 'fill: {{VALUE}}',
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
					'{{WRAPPER}} .rh_prop_card__btns [data-tooltip]:not([flow]):hover::before' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .rh_prop_card__btns [data-tooltip]:not([flow]):hover::after'  => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .rh_prop_card__btns [data-tooltip]:not([flow]):hover::after' => 'color: {{VALUE}};',
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


		$this->add_control(
			'ere_property_label_bg_color',
			[
				'label'     => esc_html__( 'Property Label Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor_property_card_parent .rhea-property-label' => 'background: {{VALUE}} !important',
				],
			]
		);


		$this->add_control(
			'ere_property_label_text_color',
			[
				'label'     => esc_html__( 'Property Label Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor_property_card_parent .rhea-property-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_by_color',
			[
				'label'     => esc_html__( 'Agent Prefix (By)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_list_card__author .by' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_agent_name_color',
			[
				'label'     => esc_html__( 'Agent', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_list_card__author .author' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_separator_border_color',
			[
				'label'     => esc_html__( 'Separator Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-list-card-detail-box' => 'border-color: {{VALUE}}',
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
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .elementor_property_card_parent .rh_prop_card_elementor .rh_prop_card__wrap',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'ere_vew_prop_border_tab',
			[
				'label' => esc_html__( 'View Property Button Border', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]

		);

		$this->start_controls_tabs( 'tabs_vew_btn_border' );

		$this->start_controls_tab(
			'ere_new_prop_border_normal',
			[
				'label' => esc_html__( 'Normal', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'ere_border_type',
				'label' => esc_html__( 'Border', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .elementor_property_card_parent .rh_overlay__contents a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ere_view_prop_border_hover',
			[
				'label' => esc_html__( 'Hover', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'ere_border_type_hover',
				'label' => esc_html__( 'Border', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .elementor_property_card_parent .rh_overlay__contents a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tab();



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
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a:hover' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_latest_properties_ajax .pagination a.current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pagination_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea_latest_properties_ajax .pagination a',
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
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor h3 a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_excerpt_typography',
				'label'    => esc_html__( 'Excerpt', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__excerpt',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_address_typography',
				'label'    => esc_html__( 'Address', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_address_sty a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_label_typography',
				'label'    => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__meta .rhea_meta_titles',
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
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__status',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_price_typography',
				'label'    => esc_html__( 'Price', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_prop_card__details_elementor .rh_prop_card__priceLabel .rh_prop_card__price',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_agent_by_typography',
				'label'    => esc_html__( 'Agent Prefix (By)', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_properties_element .wrapper_properties_list_ele .by',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_agent_typography',
				'label'    => esc_html__( 'Agent', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_properties_element .wrapper_properties_list_ele .author',
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
				'label' => esc_html__( 'Featured', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Featured', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_property_view_prop_label',
			[
				'label' => esc_html__( 'View Property', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'View Property', 'realhomes-elementor-addon' ),
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

		$this->add_control(
			'ere_agent_prefix_text',
			[
				'label'   => esc_html__( 'Agent Prefix', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'By', 'realhomes-elementor-addon' ),
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




	}


	protected function render() {

	    global $settings;
	    global $properties_query;
	    global $widget_id;

		$widget_id = $this->get_id();
		$settings = $this->get_settings_for_display();


		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) { // if is static front page
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		if($settings['offset']){
		    $offset = $settings['offset'];
        }else{
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
//			 for date, title, menu_order and rand
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
                 class="rh_elementor_widget rh_latest-properties rhea_properties_default rhea_ele_property_ajax_target rhea_latest_properties_ajax elementor_properties_grid elementor_property_card_parent rhea_has_tooltip">

                                        <?php rhea_get_template_part( 'assets/partials/list-property-loop' ); ?>

        </section>
		<?php
	}
}