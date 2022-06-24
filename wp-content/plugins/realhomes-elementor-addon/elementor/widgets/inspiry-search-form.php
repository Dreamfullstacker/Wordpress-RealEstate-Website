<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Search_Form_Widget extends \Elementor\Widget_Base {

	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );
		$this->rhea_ui_slider_enqueue_styles();
		$this->rhea_ui_slider_enqueue_scripts();
	}

	public function get_name() {
		return 'rhea-search-form-widget';
	}

	public function get_title() {
		return esc_html__( 'Search Form', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-search';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	public function rhea_ui_slider_enqueue_styles() {
		wp_enqueue_style( 'rhea-jquery-ui-css', RHEA_PLUGIN_URL . 'elementor/css/jquery-ui.css', array(), RHEA_VERSION, 'all' );
	}

	public function rhea_ui_slider_enqueue_scripts() {
		wp_enqueue_script( 'jquery-ui-slider' );
	}

	public function search_template_options() {
		if ( function_exists( 'inspiry_pages' ) ) {
			$search_pages_args = array(
				'meta_query' => array(
					'relation' => 'or',
					array(
						'key'   => '_wp_page_template',
						'value' => 'templates/properties-search.php',
					),
					array(
						'key'   => '_wp_page_template',
						'value' => 'templates/properties-search-half-map.php',
					),
					array(
						'key'   => '_wp_page_template',
						'value' => 'templates/properties-search-left-sidebar.php',
					),
					array(
						'key'   => '_wp_page_template',
						'value' => 'templates/properties-search-right-sidebar.php',
					),
				),
			);
			return inspiry_pages( $search_pages_args );
		}
	}

	protected function register_controls() {

		$this->start_controls_section(
			'rhea_search_basic_settings',
			[
				'label' => esc_html__( 'Basic Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_select_search_template',
			[
				'label'       => esc_html__( 'Select Search Template', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'If no search template is selected, "RealHomes > Customize Settings > Property Search > Properties Search Page" settings will be applied by default   ', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => $this->search_template_options(),
			]
		);

		$this->add_control(
			'rhea_top_field_count',
			[
				'label'       => esc_html__( 'Top Fields To Display', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Select number of fields to display in top bar' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => '3',
				'options'     => array(
					'1' => esc_html__( 'One', 'realhomes-elementor-addon' ),
					'2' => esc_html__( 'Two', 'realhomes-elementor-addon' ),
					'3' => esc_html__( 'Three', 'realhomes-elementor-addon' ),
					'4' => esc_html__( 'Four', 'realhomes-elementor-addon' ),
					'5' => esc_html__( 'Five', 'realhomes-elementor-addon' ),
					'6' => esc_html__( 'Six', 'realhomes-elementor-addon' ),
				),
			]
		);

		$this->add_control(
			'rhea_default_advance_state',
			[
				'label'   => esc_html__( 'Advance Fields Default State', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'collapsed',
				'options' => array(
					'collapsed' => esc_html__( 'Collapsed', 'realhomes-elementor-addon' ),
					'open'      => esc_html__( 'Open', 'realhomes-elementor-addon' ),
				),
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label'        => esc_html__( 'Show Labels', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_advance_fields',
			[
				'label'        => esc_html__( 'Show Advance Fields Button', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'search_button_label',
			[
				'label'   => esc_html__( 'Search Button', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Search', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_search_button_position',
			[
				'label'        => esc_html__( 'Search Button AT Bottom? ', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'rhea_button_animate',
			[
				'label'        => esc_html__( 'Animate Search Buttons? ', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'rhea_advance_button_animate',
			[
				'label'        => esc_html__( 'Animate Advance Search Buttons? ', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition' => [
					'show_advance_fields' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_advance_features',
			[
				'label'        => esc_html__( 'Show More Features ', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'advance_features_text',
			[
				'label'   => esc_html__( 'Advance Features Text', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Looking for certain features', 'realhomes-elementor-addon' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_search_fields_sorting',
			[
				'label' => esc_html__( 'Search Fields Sorting', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_search_select_sort',
			[
				'label' => __( 'Control Name', 'plugin-name' ),
				'type'  => 'rhea-select-unit-control',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_search_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'fields_typography',
				'label'    => esc_html__( 'Search Fields', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' =>
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-toggle, 
					{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location > .dropdown-toggle,
                    {{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option input[type="text"]',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'fields_dropdown_typography',
				'label'    => esc_html__( 'Search Fields Dropdown', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu li a,
				               {{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu li a',
			]
		);

		$this->add_responsive_control(
			'rhea_select_deselect_icon_size',
			[
				'label'           => esc_html__( 'Drop Down Select/Deselect All Icons Size', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_select_bs_buttons svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'fields_search_button_typography',
				'label'    => esc_html__( 'Search Button', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_search_form_wrapper .rhea_search_form_button',
			]
		);

		$this->add_responsive_control(
			'rhea_search_button_icon_size',
			[
				'label'           => esc_html__( ' Search Button Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper button svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_search_expander_icon_size',
			[
				'label'           => esc_html__( 'Advance Fields Button Icon Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_advanced_expander svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'more_features_button_typography',
				'label'    => esc_html__( 'More Feature Button', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_open_more_features',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'more_features_fields_typography',
				'label'    => esc_html__( 'More Feature Checkbox Fields', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-more-options-wrapper label',
			]
		);

		$this->add_responsive_control(
			'more_features_fields_checkbox_size',
			[
				'label'           => esc_html__( 'Feature Checkbox Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-more-options-wrapper label:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'more_features_checkbox_typography',
				'label'    => esc_html__( 'More Feature Checkbox Checked', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-more-options-wrapper label:before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'price_slider_text_typo',
				'label'    => esc_html__( 'Price Slider Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_price_slider_wrapper > .rhea_price_label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'price_slider_form_to_typo',
				'label'    => esc_html__( 'Price Slider From/To Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_price_slider_wrapper > .rhea_price_range',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'price_slider_price_typo',
				'label'    => esc_html__( 'Price Slider Min Max Range ', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_price_slider_wrapper .rhea_price_display',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'ajax_ph_input_typo',
				'label'    => esc_html__( 'Ajax based location field Input ', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bs-searchbox .form-control',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'ajax_no_result_typo',
				'label'    => esc_html__( 'Ajax no result text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bootstrap-select .no-results',
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'rhea_search_form_sizes',
			[
				'label' => esc_html__( 'Sizes & Spaces', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'rhea_search_outer_padding',
			[
				'label'      => esc_html__( 'Search Form Wrapper Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_search_form_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_fields_height',
			[
				'label'           => esc_html__( 'Fields Heights (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 30,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_advanced_expander'                      => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_search_form_button'                     => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-toggle'          => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location > .dropdown-toggle' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option input[type="text"]' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_fields_border_radius',
			[
				'label'           => esc_html__( 'Fields Border Radius (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_advanced_expander'                      => 'border-radius: {{SIZE}}{{UNIT}};',
//					'{{WRAPPER}} .rhea_price_slider_wrapper'                                             => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_search_form_button'                     => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-toggle'          => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location > .dropdown-toggle' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option input[type="text"]' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'rhea_advance_top_fields_width',
			[
				'label'           => esc_html__( 'Top Bar Fields Width (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set individually for default fields from Content tab', 'realhomes-elementor-addon' ),
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
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_top_search_box .rhea_prop_search__option' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_advance_fields_width',
			[
				'label'           => esc_html__( 'Collapsed Fields Width (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set individually for default fields from Content tab. (Note: These changes will not effect on Min Max Price Slider. For that go to Content > Min MAx Price)', 'realhomes-elementor-addon' ),
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
				'tablet_default'  => [
					'size' => 33.333,
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
//					'{{WRAPPER}} .rhea_collapsed_search_fields_inner .rhea_prop_search__option' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_collapsed_search_fields_inner .rhea_prop_search__option:not(.rhea_price_slider_field)' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_expander_button_padding',
			[
				'label'           => esc_html__( 'Advance Button Right/Left Padding (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'tablet_default'  => [
					'size' => 40,
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => 30,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_advanced_expander' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_search_button_padding',
			[
				'label'           => esc_html__( 'Search Button Right/Left Padding (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_search_form_button' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_search_button_width',
			[
				'label'           => esc_html__( 'Search Bottom Button width (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Search Button width (% Recommended when search button is set at bottom or on tablet/mobiles screens) ', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_buttons_bottom .rhea_search_form_button' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_dropdown_padding',
			[
				'label'      => esc_html__( 'Search Form Dropdown List Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu li a'          => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_fields_border_size',
			[
				'label'      => esc_html__( 'Fields Border Size', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-toggle'          => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location > .dropdown-toggle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option input[type="text"]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_select_deselect_box_height',
			[
				'label'           => esc_html__( 'Drop Down Select/Deselect Box Height', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu .btn-block button'          => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu .btn-block button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_select_deselect_box_border',
			[
				'label'      => esc_html__( 'Drop Down Select/Deselect Box Border', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu .btn-block'          => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu .btn-block' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_items_in',
			[
				'label'   => esc_html__( 'Drop Drown List Height', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 3,
				'max'     => 15,
				'step'    => .5,
				'default' => 5.5,
			]

		);

		$this->add_responsive_control(
			'rhea_horizontal_fields_spacings',
			[
				'label'           => esc_html__( 'Fields Horizontal Spacing (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option'   => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_search_button_wrapper' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_top_search_fields'     => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_collapsed_search_fields_inner'                   => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_search_button_gap',
			[
				'label'           => esc_html__( 'Search Buttons Gap (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_search_button_wrapper'   => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_labels_margin_bottom',
			[
				'label'           => esc_html__( 'Labels Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_fields_labels' => 'margin-bottom: {{SIZE}}{{UNIT}};'

				],
			]
		);

		$this->add_responsive_control(
			'rhea_vertical_fields_spacings',
			[
				'label'           => esc_html__( 'Fields Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_search_button_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_horizontal_features_spacings',
			[
				'label'           => esc_html__( 'More Features Horizontal Spacing (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-more-options-wrapper .rhea-option-bar' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-more-options-wrapper'                  => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_vertical_features_spacings',
			[
				'label'           => esc_html__( 'More Features Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-more-options-wrapper .rhea-option-bar' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_more_feature_text_margin_top',
			[
				'label'           => esc_html__( 'More Features Text Margin Top (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_open_more_features' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_search_form_colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]

		);

		$this->add_control(
			'rhea_search_form_bg',
			[
				'label'     => esc_html__( 'Search Form Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_wrapper' => 'background: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'rhea_search_button_bg',
			[
				'label'     => esc_html__( 'Search Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_button' => 'background: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'rhea_search_button_bg_hover',
			[
				'label'     => esc_html__( 'Search Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_button:hover' => 'background: {{VALUE}}',
				],
				'condition' => [
					'rhea_button_animate' => '',
				],
			]
		);

		$this->add_control(
			'rhea_search_button_animate_hover',
			[
				'label'     => esc_html__( 'Search Button Animate Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_button.rhea-btn-primary:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'rhea_button_animate' => 'yes',
				],
			]
		);

		$this->add_control(
			'rhea_search_button_text',
			[
				'label'     => esc_html__( 'Search Button Text/icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_button span'         => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_button .icon-search' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_search_button_text_hover',
			[
				'label'     => esc_html__( 'Search Button Text/icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_button:hover span'         => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_button:hover .icon-search' => 'stroke: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_advance_search_button_bg',
			[
				'label'     => esc_html__( 'Advance Search Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_advanced_expander' => 'background: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'rhea_advance_search_button_bg_hover',
			[
				'label'     => esc_html__( 'Advance Search Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_advanced_expander:hover' => 'background: {{VALUE}}',
				],
				'condition' => [
					'rhea_advance_button_animate' => '',
				],
			]
		);
		$this->add_control(
			'rhea_advance_search_button_animate_hover',
			[
				'label'     => esc_html__( 'Advance Search Button Animate Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_advanced_expander.rhea-btn-primary:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'rhea_advance_button_animate' => 'yes',
				],
			]
		);

		$this->add_control(
			'rhea_advance_search_button_icon',
			[
				'label'     => esc_html__( 'Advance Search Button icon', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_advanced_expander .icon-search-plus' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_search_button_icon_hover',
			[
				'label'     => esc_html__( 'Advance Search Button Icon Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_advanced_expander:hover .icon-search-plus' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_fields_border_color',
			[
				'label'     => esc_html__( 'Fields Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-toggle'          => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location > .dropdown-toggle' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option input[type="text"]' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_price_slider_wrapper'                                             => 'border-color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'rhea_fields_bg_color',
			[
				'label'     => esc_html__( 'Fields Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-toggle'          => 'background: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location > .dropdown-toggle' => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option input[type="text"]' => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_price_slider_wrapper'                                             => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_fields_text_color',
			[
				'label'     => esc_html__( 'Fields Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > .dropdown-toggle'                                                        => 'color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location > .dropdown-toggle'                                               => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option input[type="text"]'                                               => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper ::placeholder'                                                                              => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper ::-ms-input-placeholder'                                                                    => 'color: {{VALUE}}',
					'{{WRAPPER}} .bs-searchbox .form-control'                                                                                          => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper ::-webkit-input-placeholder'                                                                => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_prop_search__option .rhea_price_slider_wrapper .rhea_price_label'                     => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_price_slider_wrapper .rhea_price_range'                                                                         => 'color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker > 
					.dropdown-toggle .caret, .bootstrap-select.rhea_multi_select_picker_location > .dropdown-toggle .caret'        => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker.dropup > 
					.dropdown-toggle .caret, .bootstrap-select.rhea_multi_select_picker_location.dropup > .dropdown-toggle .caret' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_price_border_colors',
			[
				'label'     => esc_html__( 'Price Slider Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_price_slider_wrapper' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'show_select_fields' => '',
				],
			]
		);
		$this->add_control(
			'rhea_price_range_colors',
			[
				'label'     => esc_html__( 'Price Slider Range Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_price_slider_wrapper .rhea_price_display' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_select_fields' => '',
				],
			]
		);

		$this->add_control(
			'rhea_price_bg_color',
			[
				'label'     => esc_html__( 'Price Slider UI Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_wrapper .ui-widget.ui-widget-content' => 'background: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [
					'show_select_fields' => '',
				],
			]
		);

		$this->add_control(
			'rhea_price_slider_color',
			[
				'label'     => esc_html__( 'Price Slider UI Range', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_price_slider_wrapper .ui-slider .ui-slider-range' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_select_fields' => '',
				],
			]
		);

		$this->add_control(
			'rhea_price_darg_color',
			[
				'label'     => esc_html__( 'Price Slider UI Drag Button', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_wrapper .ui-widget-content .ui-state-default' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_select_fields' => '',
				],
			]
		);


		$this->add_control(
			'rhea_dropdown_bg_color',
			[
				'label'     => esc_html__( 'Dropdown Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu'          => 'background: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu' => 'background: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select .no-results'                                      => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_text_color',
			[
				'label'     => esc_html__( 'Dropdown Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu li a'          => 'color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu li a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select .no-results'                                           => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_text_selected_color',
			[
				'label'     => esc_html__( 'Dropdown Text Select/Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu li.selected a'          => 'color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu li.selected a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu li:hover a'             => 'color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu li:hover a'    => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_bg_selected_color',
			[
				'label'     => esc_html__( 'Dropdown Select/Hover Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu li.selected'          => 'background: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu li.selected' => 'background: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu li:hover'             => 'background: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu li:hover'    => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_select_deselect_border_color',
			[
				'label'     => esc_html__( 'Dropdown Select/Deselect Buttons and Ajax placeholder Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu .btn-block'          => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu .btn-block' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .bs-searchbox .form-control'                                                   => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_select_deselect_color',
			[
				'label'     => esc_html__( 'Dropdown Select/Deselect Buttons Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_select_bs_buttons.rhea_bs_select svg'         => 'fill: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper .rhea_select_bs_buttons.rhea_bs_deselect .rhea_des' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_select_deselect_bg_color',
			[
				'label'     => esc_html__( 'Dropdown Select/Deselect Buttons Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu .btn-block button'          => 'background: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu .btn-block button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_select_deselect_hover_color',
			[
				'label'     => esc_html__( 'Dropdown Select/Deselect Buttons Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_search_form_wrapper .actions-btn:hover .rhea_select_bs_buttons.rhea_bs_select svg'         => 'fill: {{VALUE}}',
					'{{WRAPPER}} .rhea_search_form_wrapper .actions-btn:hover .rhea_select_bs_buttons.rhea_bs_deselect .rhea_des' => 'stroke: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_select_deselect_hover_bg_color',
			[
				'label'     => esc_html__( 'Dropdown Select/Deselect Buttons Hover Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker .dropdown-menu .btn-block button:hover'          => 'background: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location .dropdown-menu .btn-block button:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_search_form_features',
			[
				'label'     => esc_html__( 'Search Form Features Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-more-options-mode-container' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_search_form_btn_features',
			[
				'label'     => esc_html__( 'More Features Button Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_open_more_features' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_search_form_btn_hover_features',
			[
				'label'     => esc_html__( 'More Features Button Open/Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_open_more_features:hover'              => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_open_more_features.rhea_features_open' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_search_form_features_color',
			[
				'label'     => esc_html__( 'Features Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-more-options-wrapper .rhea-option-bar' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_dropdown_scroll_section',
			[
				'label' => esc_html__( 'Dropdown List Scroll Styles', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'rhea_dropdown_scroll_size',
			[
				'label'           => esc_html__( 'Scroll Width (px)', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker.open .dropdown-menu ::-webkit-scrollbar'          => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location.open .dropdown-menu ::-webkit-scrollbar' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_scroll_thumb',
			[
				'label'     => esc_html__( 'Scroll Thumb Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker.open .dropdown-menu ::-webkit-scrollbar-thumb'          => 'background-color: {{VALUE}}; outline-color: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location.open .dropdown-menu ::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}}; outline-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_dropdown_scroll_track',
			[
				'label'     => esc_html__( 'Scroll Track Box Shadow', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker.open .dropdown-menu ::-webkit-scrollbar-track'          => 'box-shadow: {{VALUE}}; -webkit-box-shadow: {{VALUE}}',
					'{{WRAPPER}} .bootstrap-select.rhea_multi_select_picker_location.open .dropdown-menu ::-webkit-scrollbar-track' => 'box-shadow: {{VALUE}}; -webkit-box-shadow: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_property_location_section',
			[
				'label' => esc_html__( 'Property Locations', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_select_locations',
			[
				'label'       => esc_html__( 'Number of Location Select Boxes', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'In case of 1 location box, all locations will be listed in that select box. In case of 2 or more, Each select box will list parent locations of a level that matches its number and all the remaining children locations will be listed in last select box.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'default'     => '1',
				'label_block' => true,
				'options'     => array(
					'1' => esc_html__( '1', 'realhomes-elementor-addon' ),
					'2' => esc_html__( '2', 'realhomes-elementor-addon' ),
					'3' => esc_html__( '3', 'realhomes-elementor-addon' ),
					'4' => esc_html__( '4', 'realhomes-elementor-addon' ),
				),
			]
		);

		$this->add_control(
			'rhea_location_title_1',
			[
				'label'      => esc_html__( 'Main Location', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'default'    => esc_html__( 'Main Location', 'realhomes-elementor-addon' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '1'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '2'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '3'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '4'
						],
					]
				],
			]
		);
		$this->add_control(
			'rhea_location_ph_1',
			[
				'label'      => esc_html__( 'Main Location Placeholder', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'default'    => esc_html__( 'All Main Locations', 'realhomes-elementor-addon' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '1'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '2'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '3'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '4'
						],
					]
				],
			]
		);

		$this->add_control(
			'location_count_placeholder',
			[
				'label'       => esc_html__( 'Location Count Placeholder', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Placeholder text when more than 2 values are being selected', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Locations Selected', 'realhomes-elementor-addon' ),
				'condition'   => [
					'rhea_select_locations' => '1',
				]
			]
		);


		$this->add_control(
			'rhea_location_title_2',
			[
				'label'      => esc_html__( 'Child Location ', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'default'    => esc_html__( 'Child Location', 'realhomes-elementor-addon' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '2'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '3'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '4'
						],
					]
				],
			]
		);

		$this->add_control(
			'rhea_location_ph_2',
			[
				'label'      => esc_html__( 'Main Child Placeholder', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'default'    => esc_html__( 'All Child Locations', 'realhomes-elementor-addon' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '2'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '3'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '4'
						],
					]
				],
			]
		);

		$this->add_control(
			'rhea_location_title_3',
			[
				'label'      => esc_html__( 'Grand Child Location', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'default'    => esc_html__( 'Grand Child Location', 'realhomes-elementor-addon' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '3'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '4'
						],
					]
				],
			]
		);
		$this->add_control(
			'rhea_location_ph_3',
			[
				'label'      => esc_html__( 'Grand Child Placeholder', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'default'    => esc_html__( 'All Grand Child Locations', 'realhomes-elementor-addon' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '3'
						],
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '4'
						],
					]
				],
			]
		);
		$this->add_control(
			'rhea_location_title_4',
			[
				'label'      => esc_html__( 'Great Grand Child Location', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'default'    => esc_html__( 'Great Grand Child Location', 'realhomes-elementor-addon' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '4'
						],
					]
				],
			]
		);

		$this->add_control(
			'rhea_location_ph_4',
			[
				'label'      => esc_html__( 'Great Grand Child Placeholder', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'default'    => esc_html__( 'All Great Grand Child Locations', 'realhomes-elementor-addon' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_locations',
							'operator' => '==',
							'value'    => '4'
						],
					]
				],
			]
		);

		$this->add_control(
			'set_multiple_location',
			[
				'label'        => esc_html__( 'Enable Multi Select ?', 'realhomes-elementor-addon' ),
				'description'  => esc_html__( 'This will enable multi select if Number of Location Select Boxes is equal to 1.', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'rhea_select_locations' => '1',
				]
			]
		);

		$this->add_control(
			'set_ajax_location',
			[
				'label'        => esc_html__( 'Enable Ajax Based Locations ?', 'realhomes-elementor-addon' ),
				'description'  => esc_html__( 'This will enable ajax based locations if Number of Location Select Boxes is equal to 1.', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'rhea_select_locations' => '1',
				]
			]
		);

		$this->add_control(
			'rhea_ajax_input_placeholder',
			[
				'label'     => esc_html__( 'Live Search Placeholder', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Enter location name', 'realhomes-elementor-addon' ),
				'condition' => [
					'set_ajax_location' => 'yes',
				],
			]
		);

		$this->add_control(
			'rhea_no_result_matched',
			[
				'label'     => esc_html__( 'No Result Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'No Location Matched', 'realhomes-elementor-addon' ),
				'condition' => [
					'set_ajax_location' => 'yes',
				],
			]
		);

		$this->add_control(
			'hide_empty_location',
			[
				'label'        => esc_html__( 'Hide Empty Locations ?', 'realhomes-elementor-addon' ),
				'description'  => esc_html__( 'Optimize Locations by hiding the ones with zero property.', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'sort_location_alphabetically',
			[
				'label'        => esc_html__( 'Sort Locations Alphabetically ?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition' => [
					'set_ajax_location' => 'yes',
					'rhea_select_locations' => '1',
				],
			]
		);

		$this->add_responsive_control(
			'property_locations_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_prop_locations_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_property_status_section',
			[
				'label' => esc_html__( 'Property Status', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'property_status_label',
			[
				'label'   => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Property Status', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_control(
			'property_status_placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'All Status', 'realhomes-elementor-addon' ),
			]
		);

		$rhea_all_statuses = get_terms( array( 'taxonomy' => 'property-status' ) );
		$status_options    = array();

		if ( ! empty( $rhea_all_statuses ) && ! is_wp_error( $rhea_all_statuses ) ) {
			foreach ( $rhea_all_statuses as $status ) {
				$status_options[ $status->term_id ] = $status->name;
			}
		}

		$status_default = array();
		if ( ! empty( $rhea_all_statuses ) && ! is_wp_error( $rhea_all_statuses ) ) {
			foreach ( $rhea_all_statuses as $status ) {
				$status_default[ $status->slug ] = $status->name;
			}
		}

		$this->add_control(
			'status_count_placeholder',
			[
				'label'       => esc_html__( 'Count Placeholder', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Placeholder text when more than 2 values are being selected', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Status Selected', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'default_status_select',
			[
				'label'       => esc_html__( 'Default Selected Status', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => false,
				'label_block' => true,
				'options'     => $status_default,
			]
		);

		$this->add_control(
			'rhea_select_exclude_status',
			[
				'label'       => esc_html__( 'Exclude Status', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => $status_options,
			]
		);

		$this->add_responsive_control(
			'property_status_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_status_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_property_type_section',
			[
				'label' => esc_html__( 'Property Type', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'property_types_label',
			[
				'label'   => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Property Types', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_control(
			'property_types_placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'All Types', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'types_count_placeholder',
			[
				'label'       => esc_html__( 'Count Placeholder', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Placeholder text when more than 2 values are being selected', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Types Selected', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'show_types_select_all',
			[
				'label'        => esc_html__( 'Show Select/Deselect All?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'set_multiple_types',
			[
				'label'        => esc_html__( 'Enable Multi Select ?', 'realhomes-elementor-addon' ),
				'description'  => esc_html__( 'This will enable multi select.', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_responsive_control(
			'property_types_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_types_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_property_min_beds_section',
			[
				'label' => esc_html__( 'Bedrooms', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'min_bed_label',
			[
				'label'   => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bedroom', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'min_bed_placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'All Beds', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'min_bed_drop_down_value',
			[
				'label'       => esc_html__( 'Values In Drop Down', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Only provide comma separated numbers. Do not add decimal points, dashes and spaces.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '1,2,3,4,5,6,7,8,9,10', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_responsive_control(
			'min_bed_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_min_beds_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_property_min_baths_section',
			[
				'label' => esc_html__( 'Bathrooms', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'min_bath_label',
			[
				'label'   => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Bathroom', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'min_bath_placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'All Baths', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'min_bath_drop_down_value',
			[
				'label'       => esc_html__( 'Values In Drop Down', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Only provide comma separated numbers. Do not add decimal points, dashes and spaces.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '1,2,3,4,5,6,7,8,9,10', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_responsive_control(
			'min_bath_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_min_baths_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_property_min_max_price_section',
			[
				'label' => esc_html__( 'Min Max Price', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'show_select_fields',
			[
				'label'        => esc_html__( 'Switch To Select Fields', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);


		$this->add_control(
			'slider_range_label',
			[
				'label'     => esc_html__( 'Price Range Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Price Range', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_select_fields' => '',
				],
			]
		);

		$this->add_control(
			'slider_range_from',
			[
				'label'     => esc_html__( 'Price From Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'From', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_select_fields' => '',
				],
			]
		);
		$this->add_control(
			'slider_range_to',
			[
				'label'     => esc_html__( 'Price To Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'To', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_select_fields' => '',
				],
			]
		);

		$this->add_responsive_control(
			'slider_price_field_size',
			[
				'label'           => esc_html__( 'Price Slider Width (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'show_select_fields' => '',
				],
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
				'desktop_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_price_slider_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'slider_price_field_height',
			[
				'label'           => esc_html__( 'Price Slider Height (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'show_select_fields' => '',
				],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_price_slider_wrapper' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_price_slider_padding',
			[
				'label'      => esc_html__( 'Price Slider Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_price_slider_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'    => [
					'show_select_fields' => '',
				],
			]
		);

		$this->add_control(
			'price_range_on_top',
			[
				'label'        => esc_html__( 'Display Price Range On Top?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'show_select_fields' => '',
				],
			]
		);

		$this->add_control(
			'min_price_label',
			[
				'label'     => esc_html__( 'Min Price Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Min Price', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_select_fields' => 'yes',
				],
			]
		);

		$this->add_control(
			'min_price_placeholder',
			[
				'label'     => esc_html__( 'Min Price Placeholder', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Min Price', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_select_fields' => 'yes',
				],
			]
		);


		$this->add_responsive_control(
			'min_price_field_size',
			[
				'label'           => esc_html__( 'Min Price Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'show_select_fields' => 'yes',
				],
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
					'{{WRAPPER}} .rhea_min_price_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'max_price_label',
			[
				'label'     => esc_html__( 'Max Price Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Max Price', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_select_fields' => 'yes',
				],
			]
		);

		$this->add_control(
			'max_price_placeholder',
			[
				'label'     => esc_html__( 'Max Price Placeholder', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Max Price', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_select_fields' => 'yes',
				],
			]
		);


		$this->add_responsive_control(
			'max_price_field_size',
			[
				'label'           => esc_html__( 'Max Price Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'condition'       => [
					'show_select_fields' => 'yes',
				],
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
					'{{WRAPPER}} .rhea_max_price_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'min_price_drop_down_value',
			[
				'label'       => esc_html__( 'Min Price List', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Only provide comma separated numbers. Do not add decimal points, dashes, spaces and currency signs.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '1000,5000,10000,50000,100000,200000,300000,400000,500000,600000,700000,800000,900000,1000000,1500000,2000000,2500000,5000000', 'realhomes-elementor-addon' ),
				'condition'   => [
					'show_select_fields' => 'yes',
				],
			]
		);

		$this->add_control(
			'max_price_drop_down_value',
			[
				'label'       => esc_html__( 'Max Price List', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Only provide comma separated numbers. Do not add decimal points, dashes, spaces and currency signs.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '5000,10000,50000,100000,200000,300000,400000,500000,600000,700000,800000,900000,1000000,1500000,2000000,2500000,5000000,10000000', 'realhomes-elementor-addon' ),
				'condition'   => [
					'show_select_fields' => 'yes',
				],
			]
		);

		$this->add_control(
			'min_rent_price_drop_down_value',
			[
				'label'       => esc_html__( 'Min Price List For Rent', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Only provide comma separated numbers. Do not add decimal points, dashes, spaces and currency signs.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '500,1000,2000,3000,4000,5000,7500,10000,15000,20000,25000,30000,40000,50000,75000,100000', 'realhomes-elementor-addon' ),
				'condition'   => [
					'show_select_fields' => 'yes',
				],
			]
		);

		$this->add_control(
			'max_rent_price_drop_down_value',
			[
				'label'       => esc_html__( 'Max Price List For Rent', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Only provide comma separated numbers. Do not add decimal points, dashes, spaces and currency signs.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '1000,2000,3000,4000,5000,7500,10000,15000,20000,25000,30000,40000,50000,75000,100000,150000', 'realhomes-elementor-addon' ),
				'condition'   => [
					'show_select_fields' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_property_garages_section',
			[
				'label' => esc_html__( 'Garages', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'garages_label',
			[
				'label'   => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Garages', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'garages_placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'All Garages', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'garages_drop_down_value',
			[
				'label'       => esc_html__( 'Values In Drop Down', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Only provide comma separated numbers. Do not add decimal points, dashes and spaces.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '1,2,3,4,5,6,7,8,9,10', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_responsive_control(
			'garages_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_garages_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_property_agent_section',
			[
				'label' => esc_html__( 'Agents', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'agent_label',
			[
				'label'   => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Agent', 'realhomes-elementor-addon' ),
			]
		);
		$this->add_control(
			'agent_placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'All Agents', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'agent_count_placeholder',
			[
				'label'       => esc_html__( 'Count Placeholder', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Placeholder text when more than 2 values are being selected', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Agents Selected', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'show_select_all',
			[
				'label'        => esc_html__( 'Show Select/Deselect All?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'set_multiple_agents',
			[
				'label'        => esc_html__( 'Enable Multi Select ?', 'realhomes-elementor-addon' ),
				'description'  => esc_html__( 'This will enable multi select.', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);


		$this->add_responsive_control(
			'agent_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_agent_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_property_min_area_section',
			[
				'label' => esc_html__( 'Min Max Area', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'min_area_label',
			[
				'label'   => esc_html__( 'Min Area Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Min Area', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'min_area_placeholder',
			[
				'label'   => esc_html__( 'Min Area Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Min Area', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_responsive_control(
			'min_area_field_size',
			[
				'label'           => esc_html__( 'Min Area Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_min_area_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'max_area_label',
			[
				'label'   => esc_html__( 'Max Area Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Max Area', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'max_area_placeholder',
			[
				'label'   => esc_html__( 'Max Area Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Max Area', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_responsive_control(
			'max_area_field_size',
			[
				'label'           => esc_html__( 'Max Area Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_max_area_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);


		$this->add_control(
			'area_units_placeholder',
			[
				'label'   => esc_html__( 'Label Units', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '(sq ft)', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'area_units_title_attr',
			[
				'label'   => esc_html__( 'Title Attribute', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Only provide digits!', 'realhomes-elementor-addon' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_property_keyword_section',
			[
				'label' => esc_html__( 'Keyword', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'keyword_label',
			[
				'label'   => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Keyword', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'keyword_placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Keyword', 'realhomes-elementor-addon' ),
			]
		);
		$this->add_responsive_control(
			'keyword_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_keyword_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_property_property_id_section',
			[
				'label' => esc_html__( 'Property ID', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'property_id_label',
			[
				'label'   => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Property ID', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_control(
			'property_id_placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Property ID', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_responsive_control(
			'property_id_field_size',
			[
				'label'           => esc_html__( 'Field Size (%)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Width can be set globally for Collapsed/Advance fields from Style > Collapsed Fields Width', 'realhomes-elementor-addon' ),
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
					'{{WRAPPER}} .rhea_property_id_field' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_property_additional_fields',
			[
				'label' => esc_html__( 'Additional Fields', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea-important-note-control',
			[
				'label' => __( 'Note: You can add additional fields from Admin > Easy Real Estate > New Fields Builder ', 'plugin-name' ),
				'type'  => 'rhea-important-note',
			]
		);

		$this->add_control(
			'rhea_select_addition_placeholder',
			[
				'label'       => esc_html__( 'Select to display in placeholder', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'This is the first default item in select drop down list.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'default'     => 'name',
				'label_block' => true,
				'options'     => array(
					'name' => esc_html__( 'Field Name', 'realhomes-elementor-addon' ),
					'any'  => esc_html__( 'Any Text', 'realhomes-elementor-addon' ),
				),
			]
		);


		$this->add_control(
			'additional_field_any_text',
			[
				'label'       => esc_html__( 'Any Text PlaceHolder', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Placeholder will appear if labels are enabled from Basic Settings > Show Labels ', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Any', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_control(
			'prefix_placeholder',
			[
				'label'       => esc_html__( 'Placeholder Prefix', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Prefix for Select fields', 'realhomes-elementor-addon' ),
				'default'     => esc_html__( 'All', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => [
					'rhea_select_addition_placeholder' => 'name',
				],
			]
		);
		$this->add_control(
			'postfix_placeholder',
			[
				'label'       => esc_html__( 'Placeholder Postfix', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Postfix for Select fields', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => [
					'rhea_select_addition_placeholder' => 'name',
				],
			]
		);


		$this->end_controls_section();


	}

	public static function rhea_search_select_sort() {
		global $settings;

		$search_fields_to_display = array(
			'location',
			'status',
			'type',
			'min-max-price',
			'min-beds',
			'min-baths',
			'min-garages',
			'agent',
			'min-max-area',
			'keyword-search',
			'property-id',
		);;
		if ( isset( $settings['rhea_search_select_sort'] ) && ! empty( $settings['rhea_search_select_sort'] ) ) {
			$search_fields_to_display = explode( ',', $settings['rhea_search_select_sort'] );
		}

		return $search_fields_to_display;
	}


	public function query_parameter_locations() {
		$parameter_locations = array();

		if ( function_exists('inspiry_get_location_select_names')){
			$location_names = inspiry_get_location_select_names();
			if ( 0 < count( $location_names ) ) {
				foreach ( $location_names as $location ) {
					if ( isset( $_GET[ $location ] ) ) {
						$parameter_locations[ $location ] = $_GET[ $location ];
					}
				}
			}
        }

		return $parameter_locations;
	}


	protected function render() {
        // ERE_Data class is needed for operations below
		if ( ! class_exists('ERE_Data')) {
		    return;
		}

		global $sorting_settings;
		global $settings;
		global $the_widget_id;

		$settings = $this->get_settings_for_display();

		$sorting_settings = '';
		if ( isset( $settings['rhea_search_select_sort'] ) && ! empty( $settings['rhea_search_select_sort'] ) ) {
			$sorting_settings = $settings['rhea_search_select_sort'];
		}

		$the_widget_id = $this->get_id();

		$rhea_top_field_count = $settings['rhea_top_field_count'];

		?>

        <div class="rhea_search_form_wrapper" id="rhea-<?php echo esc_attr( $this->get_id() ); ?>">

            <form class="rhea_search_form advance-search-form"
                  action="<?php echo esc_url( rhea_get_search_page_url( $settings['rhea_select_search_template'] ) ); ?>"
                  method="get">
                <div class="rhea_top_search_fields">
                    <div class="rhea_top_search_box <?php echo esc_attr( 'rhea_top_fields_count_' . $rhea_top_field_count ) ?>"
                         id="top-<?php echo esc_attr( $this->get_id() ); ?>">
						<?php
						if ( 'yes' === $settings['set_ajax_location'] ) {
							rhea_get_template_part( 'elementor/widgets/search/fields/location-ajax' );
						} else {
							rhea_get_template_part( 'elementor/widgets/search/fields/location' );
						}

						rhea_get_template_part( 'elementor/widgets/search/fields/status' );
						rhea_get_template_part( 'elementor/widgets/search/fields/type' );
						if ( 'yes' == $settings['show_select_fields'] ) {
							rhea_get_template_part( 'elementor/widgets/search/fields/min-max-price' );
						} else {
							rhea_get_template_part( 'elementor/widgets/search/fields/price-slider' );
						}
						rhea_get_template_part( 'elementor/widgets/search/fields/min-beds' );
						rhea_get_template_part( 'elementor/widgets/search/fields/min-baths' );
						rhea_get_template_part( 'elementor/widgets/search/fields/min-garages' );
						rhea_get_template_part( 'elementor/widgets/search/fields/agent' );
						rhea_get_template_part( 'elementor/widgets/search/fields/min-max-area' );
						rhea_get_template_part( 'elementor/widgets/search/fields/keyword-search' );
						rhea_get_template_part( 'elementor/widgets/search/fields/property-id' );

						$additional_fields = get_option( 'inspiry_property_additional_fields' );

						if ( isset( $additional_fields ) && is_array( $additional_fields ) && ! empty( $additional_fields ) ) {


							foreach ( $additional_fields as $additional_field ) {
								foreach ( $additional_field as $value ) {
									if ( ! empty( $value['field_display'] ) && in_array( 'search', $value['field_display'] ) ) {

										$type = $value['field_type'];

										$name = $value['field_name'];


										if ( isset( $value['field_options'] ) ) {

											$options = explode( ',', $value['field_options'] );
										}

										$key = 'inspiry_' . strtolower( preg_replace( '/\s+/', '_', $value['field_name'] ) );

										$key_check = strtolower( str_replace( " ", "-", $value['field_name'] ) );


										if ( is_array( $this->rhea_search_select_sort() ) && in_array( $key_check, $this->rhea_search_select_sort() ) ) {

											$field_key = array_search( $key_check, $this->rhea_search_select_sort() );

											$field_key = intval( $field_key ) + 1;

											if ( 'name' === $settings['rhea_select_addition_placeholder'] ) {
												$set_placeholder = $name;
											} else {
												$set_placeholder = $settings['additional_field_any_text'];
											}

											if ( in_array( $type, array( 'text', 'textarea' ) ) ) {


												?>
                                                <div class="rhea_prop_search__option rhea_mod_text_field"
                                                     data-key-position="<?php echo esc_attr( $field_key ); ?>"
                                                     style="order: <?php echo esc_attr( $field_key ); ?>">
													<?php if ( 'yes' === $settings['show_labels'] ) { ?>
                                                        <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $name ); ?></label>
													<?php } ?>
                                                    <input type="<?php echo esc_attr( $type ); ?>"
                                                           name="<?php echo esc_attr( $key ); ?>"
                                                           id="<?php echo esc_attr( $key ); ?>"
                                                           value="<?php echo isset( $_GET[ $key ] ) ? esc_attr( $_GET[ $key ] ) : ''; ?>"
                                                           placeholder="<?php echo esc_attr( $set_placeholder ); ?>"/>
                                                </div>
												<?php
											} else {
												?>
                                                <div class="rhea_prop_search__option rhea_prop_search__select"
                                                     data-key-position="<?php echo esc_attr( $field_key ); ?>"
                                                     style="order: <?php echo esc_attr( $field_key ); ?>">
													<?php if ( 'yes' === $settings['show_labels'] ) { ?>
                                                        <label for="<?php echo esc_attr( $key . $this->get_id() ); ?>"><?php echo esc_html( $name ); ?></label>
													<?php } ?>
                                                    <span class="rhea_prop_search__selectwrap">
                                                                <select id="<?php echo $key . $this->get_id(); ?>"
                                                                        name="<?php echo esc_attr( $key ); ?>"
                                                                        class="rhea_multi_select_picker selectpicker show-tick">
                                                                    <?php


                                                                    // Display default select option
                                                                    $selected = empty( $_GET[ $key ] ) ? 'selected="selected"' : '';
                                                                    echo '<option value="' . rhea_any_value() . '" ' . $selected . '>' . esc_html( $settings['prefix_placeholder'] . ' ' . $set_placeholder . ' ' . $settings['postfix_placeholder'] ) . '</option>';

                                                                    // Display all available select options

                                                                    foreach ( $options as $option ) {
	                                                                    $selected = ( ! empty( $_GET[ $key ] ) && ( $_GET[ $key ] === $option ) ) ? 'selected="selected"' : '';
	                                                                    echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( $option ) . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </span>
                                                </div>
												<?php
											}
										}

									}
								}
							}


						}
						?>
                    </div>

					<?php
					rhea_get_template_part( 'elementor/widgets/search/fields/search-button-top' );
					?>
                </div>

                <div class="rhea_collapsed_search_fields  rhea_advance_fields_<?php echo esc_attr( $settings['rhea_default_advance_state'] ) ?>"
                     id="collapsed_wrapper_<?php echo esc_attr( $this->get_id() ); ?>">
                    <div class="rhea_collapsed_search_fields_inner"
                         id="collapsed-<?php echo esc_attr( $this->get_id() ); ?>">

                    </div>
					<?php
					rhea_get_template_part( 'elementor/widgets/search/fields/property-features' );
					?>
                </div>
				<?php
				rhea_get_template_part( 'elementor/widgets/search/fields/search-button-bottom' );
				?>
            </form>
        </div>


		<?php

		if ( function_exists( 'realhomes_currency_switcher_enabled' ) && realhomes_currency_switcher_enabled() ) {
			$get_currencies_data  = realhomes_get_currencies_data();
			$get_current_currency = realhomes_get_current_currency();
			$get_position         = ( $get_currencies_data[ $get_current_currency ]['position'] );

			$get_separator = $get_currencies_data[ $get_current_currency ]['thousands_sep'];

			$get_symbol = html_entity_decode( $get_currencies_data[ $get_current_currency ]['symbol'] );

		} else {

			$get_position = get_option( 'theme_currency_position', 'before' );

			$get_separator = get_option( 'theme_thousands_sep', ',' );

			$get_symbol = get_option( 'theme_currency_sign', '$' );

		}



        // check hide empty value based on setting
        $hide_empty = false;
        if ( 'yes' === $settings['hide_empty_location'] ) {
            $hide_empty = true;
        }

		// get hierarchical_locations
		$hierarchical_locations    = ERE_Data::get_hierarchical_locations( $hide_empty );
		$location_select_ids       = rhea_get_location_select_ids( $this->get_id() );
		$select_count              = rhea_get_locations_number( $settings['rhea_select_locations'], 'no' );
		$locations_place_holders   = rhea_location_placeholder(
			$settings['rhea_location_ph_1'],
			$settings['rhea_location_ph_2'],
			$settings['rhea_location_ph_3'],
			$settings['rhea_location_ph_4']
		);
		$query_parameter_locations = $this->query_parameter_locations();
		$any_value                 = rhea_any_value();

		$multi_select = '';
		if ( '1' == $settings['rhea_select_locations'] && 'yes' == $settings['set_multiple_location'] ) {
			$multi_select = 'multiple';
		}
		$rhea_searched_price_min='';
		if(isset($_GET['min-price'])){
		$rhea_searched_price_min = $_GET['min-price'];
		}
		$rhea_searched_price_max='';
		if(isset($_GET['max-price'])){
			$rhea_searched_price_max = $_GET['max-price'];
		}

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			?>
            <script type="application/javascript">
                rheaSearchFields("#rhea-<?php echo esc_attr( $this->get_id() ); ?>",<?php echo intval( $rhea_top_field_count );?>, "#top-<?php echo esc_attr( $this->get_id() ); ?>", "#collapsed-<?php echo esc_attr( $this->get_id() ); ?>");
                rheaSearchStatusChange("#rhea-<?php echo esc_attr( $this->get_id() ); ?>  .price-for-others", "#rhea-<?php echo esc_attr( $this->get_id() ); ?>  .price-for-rent", "#select-status-<?php echo esc_attr( $the_widget_id ); ?>");
                rheaPropertySlider(
                    "#rhea_slider_<?php echo esc_attr( $the_widget_id )?> .rhea_price_slider",
					<?php echo preg_replace('/[^0-9]/', '', ( rhea_get_plain_property_price( rhea_get_min_max_price( 'min' ) ) ));?>,
					<?php echo preg_replace('/[^0-9]/', '', ( rhea_get_plain_property_price( rhea_get_min_max_price( 'max' ) ) ));?>,
                    "<?php echo $get_position;?>",
                    "<?php echo $get_separator; ?>",
                    "<?php echo $get_symbol; ?>",
                    "<?php echo $rhea_searched_price_min?>",
                    "<?php echo $rhea_searched_price_max?>",
                );
                rheaSearchAdvanceState("#advance_button_<?php echo esc_attr( $this->get_id() ); ?>", "#collapsed_wrapper_<?php echo esc_attr( $this->get_id() ); ?>");
                rheaSearchAdvanceState("#advance_bottom_button_<?php echo esc_attr( $this->get_id() ); ?>", "#collapsed_wrapper_<?php echo esc_attr( $this->get_id() ); ?>");
                rheaFeaturesState("#rhea_features_<?php echo esc_attr( $the_widget_id );?> .rhea_open_more_features", "#rhea_features_<?php echo esc_attr( $the_widget_id );?> .rhea-more-options-wrapper");
                rheaLocationsHandler(<?php echo json_encode( $hierarchical_locations )?>,
	                <?php echo json_encode( $locations_place_holders )?>,
	                <?php echo json_encode( $location_select_ids )?>,
	                <?php echo json_encode( $query_parameter_locations )?>,
	                <?php echo json_encode( $select_count )?>,
	                <?php echo json_encode( $any_value )?>,
	                <?php echo json_encode( $multi_select )?>
                );
                rheaSelectPicker("<?php echo "#rhea-" . $this->get_id(); ?> .rhea_multi_select_picker");
                rheaSelectPicker("<?php echo "#rhea-" . $this->get_id(); ?> .rhea_multi_select_picker_location");
                minMaxPriceValidation("#select-min-price-<?php echo esc_attr( $the_widget_id ); ?>", "#select-max-price-<?php echo esc_attr( $the_widget_id ); ?>");
                minMaxRentPriceValidation("#select-min-price-for-rent-<?php echo esc_attr( $the_widget_id ); ?>", "#select-max-price-for-rent-<?php echo esc_attr( $the_widget_id ); ?>");
                minMaxAreaValidation("#min-area-<?php echo esc_attr( $the_widget_id ); ?>", "#max-area-<?php echo esc_attr( $the_widget_id ); ?>");

                jQuery("<?php echo "#rhea-" . $this->get_id(); ?> .rhea_multi_select_picker_location").on('change', function () {
                    jQuery("<?php echo "#rhea-" . $this->get_id(); ?> .rhea_multi_select_picker_location").selectpicker('refresh');

                });

                rheaAjaxSelect(".rhea_location_ajax_parent_<?php echo esc_attr( $the_widget_id )?>",
                    "#rhea_ajax_location_<?php echo $the_widget_id?>",
                    '<?php echo admin_url( 'admin-ajax.php' )?>',
                    '<?php echo $settings['hide_empty_location']?>',
                    '<?php echo $settings['sort_location_alphabetically']?>'
                );
            </script>
			<?php
		} else {
			?>

            <script type="application/javascript">
                jQuery(document).bind("ready", function () {
                    rheaSearchFields("#rhea-<?php echo esc_attr( $this->get_id() ); ?>",<?php echo intval( $rhea_top_field_count );?>, "#top-<?php echo esc_attr( $this->get_id() ); ?>", "#collapsed-<?php echo esc_attr( $this->get_id() ); ?>");
                    rheaSearchStatusChange("#rhea-<?php echo esc_attr( $this->get_id() ); ?>  .price-for-others", "#rhea-<?php echo esc_attr( $this->get_id() ); ?>  .price-for-rent", "#select-status-<?php echo esc_attr( $the_widget_id ); ?>");

                    rheaPropertySlider(
                        "#rhea_slider_<?php echo esc_attr( $the_widget_id )?> .rhea_price_slider",
	                    <?php echo preg_replace('/[^0-9]/', '', ( rhea_get_plain_property_price( rhea_get_min_max_price( 'min' ) ) ));?>,
	                    <?php echo preg_replace('/[^0-9]/', '', ( rhea_get_plain_property_price( rhea_get_min_max_price( 'max' ) ) ));?>,
                        "<?php echo $get_position;?>",
                        "<?php echo $get_separator; ?>",
                        "<?php echo $get_symbol; ?>",
                        "<?php echo $rhea_searched_price_min?>",
                        "<?php echo $rhea_searched_price_max?>",
                    );
                    rheaSearchAdvanceState("#advance_button_<?php echo esc_attr( $this->get_id() ); ?>", "#collapsed_wrapper_<?php echo esc_attr( $this->get_id() ); ?>");
                    rheaSearchAdvanceState("#advance_bottom_button_<?php echo esc_attr( $this->get_id() ); ?>", "#collapsed_wrapper_<?php echo esc_attr( $this->get_id() ); ?>");
                    rheaFeaturesState("#rhea_features_<?php echo esc_attr( $the_widget_id );?> .rhea_open_more_features", "#rhea_features_<?php echo esc_attr( $the_widget_id );?> .rhea-more-options-wrapper");
	                rheaLocationsHandler(<?php echo json_encode( $hierarchical_locations )?>,
		                <?php echo json_encode( $locations_place_holders )?>,
		                <?php echo json_encode( $location_select_ids )?>,
		                <?php echo json_encode( $query_parameter_locations )?>,
		                <?php echo json_encode( $select_count )?>,
		                <?php echo json_encode( $any_value )?>,
		                <?php echo json_encode( $multi_select )?>
	                );
                    rheaSelectPicker("<?php echo "#rhea-" . $this->get_id(); ?> select.rhea_multi_select_picker");
                    rheaSelectPicker("<?php echo "#rhea-" . $this->get_id(); ?> select.rhea_multi_select_picker_location");
                    minMaxPriceValidation("#select-min-price-<?php echo esc_attr( $the_widget_id ); ?>", "#select-max-price-<?php echo esc_attr( $the_widget_id ); ?>");
                    minMaxRentPriceValidation("#select-min-price-for-rent-<?php echo esc_attr( $the_widget_id ); ?>", "#select-max-price-for-rent-<?php echo esc_attr( $the_widget_id ); ?>");
                    minMaxAreaValidation("#min-area-<?php echo esc_attr( $the_widget_id ); ?>", "#max-area-<?php echo esc_attr( $the_widget_id ); ?>");

                    jQuery("<?php echo "#rhea-" . $this->get_id(); ?> .rhea_multi_select_picker_location").on('change', function () {
                        setTimeout(function () {
                            jQuery("<?php echo "#rhea-" . $this->get_id(); ?> .rhea_multi_select_picker_location").selectpicker('refresh');
                        },500);
                    });

                    rheaAjaxSelect(".rhea_location_ajax_parent_<?php echo esc_attr( $the_widget_id )?>",
                        "#rhea_ajax_location_<?php echo $the_widget_id?>",
                        '<?php echo admin_url( 'admin-ajax.php' )?>',
                        '<?php echo $settings['hide_empty_location'] == 'yes' ? $settings['hide_empty_location'] : 'no' ?>',
                        '<?php echo $settings['sort_location_alphabetically'] == 'yes' ? $settings['sort_location_alphabetically'] : 'no' ?>'
                    );

                });

            </script>
			<?php
		}

	}

}