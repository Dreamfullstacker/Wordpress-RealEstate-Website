<?php
/**
 * Section: `Mortgage Calculator`
 * Panel:   `Property Detail Page`
 *
 * @since 3.10.1
 * @package realhomes/customizer
 */

if ( ! function_exists( 'inspiry_mortgage_calculator_customizer' ) ) :
	/**
	 * Add Property Mortgage Calculator customizer section options.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	function inspiry_mortgage_calculator_customizer( WP_Customize_Manager $wp_customize ) {

		if ( ! class_exists( 'ERE_Data' ) ) {
			return;
		}

		/**
		 * Property Mortgage Calculator Section.
		 */
		$wp_customize->add_section(
			'inspiry_mortgage_calculator',
			array(
				'title'    => esc_html__( 'Mortgage Calculator', 'framework' ),
				'panel'    => 'inspiry_property_panel',
				'priority' => 18
			)
		);

		// Show/Hide Mortgage Calculator.
		$wp_customize->add_setting(
			'inspiry_mc_display',
			array(
				'type'              => 'option',
				'default'           => 'false',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_display',
			array(
				'label'   => esc_html__( 'Mortgage Calculator', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_mortgage_calculator',
				'choices' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
			)
		);

		// Property statuses to display Mortgage Calculator for.
		$wp_customize->add_setting(
			'inspiry_mortgage_calculator_statuses',
			array(
				'type'              => 'option',
				'sanitize_callback' => 'inspiry_sanitize_multiple_checkboxes',
			)
		);
		$wp_customize->add_control(
			new Inspiry_Multiple_Checkbox_Customize_Control_sortable(
				$wp_customize,
				'inspiry_mortgage_calculator_statuses',
				array(
					'section' => 'inspiry_mortgage_calculator',
					'label'   => esc_html__( 'Select the property statuses you want to display Mortgage Calculator for ?', 'framework' ),
					'choices' => ERE_Data::get_statuses_slug_name(),
				)
			)
		);

		// Mortgage Calculator Title.
		$wp_customize->add_setting(
			'inspiry_mortgage_calculator_title',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Mortgage Calculator', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mortgage_calculator_title',
			array(
				'label'   => esc_html__( 'Mortgage Calculator Title', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Mortgage Calculator Terms.
		$wp_customize->add_setting(
			'inspiry_mc_terms',
			array(
				'type'              => 'option',
				'default'           => '30,20,15,10,5',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_terms',
			array(
				'label'       => esc_html__( 'Terms', 'framework' ),
				'description' => esc_html__( 'Provide the comma separated terms (only numbers) list. E.g: 30,20,15, 10, 5', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_mortgage_calculator',
			)
		);

		// Mortgage Calculator Default Term.
		$wp_customize->add_setting(
			'inspiry_mc_term_default',
			array(
				'type'              => 'option',
				'default'           => '30',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_term_default',
			array(
				'label'       => esc_html__( 'Default Term', 'framework' ),
				'description' => esc_html__( 'Set a term number to be selected by default. E.g: 15', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_mortgage_calculator',
			)
		);

		// Mortgage Calculator Default Interest Percentage.
		$wp_customize->add_setting(
			'inspiry_mc_interest_default',
			array(
				'type'              => 'option',
				'default'           => '3.5',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_interest_default',
			array(
				'label'       => esc_html__( 'Default Interest Percentage', 'framework' ),
				'description' => esc_html__( 'Provide an interest percentage (number only) to be set by default. E.g: 3.5', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_mortgage_calculator',
			)
		);

		// Mortgage Calculator Default House Price.
		$wp_customize->add_setting(
			'inspiry_mc_price_default',
			array(
				'type'              => 'option',
				'default'           => '0',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_price_default',
			array(
				'label'       => esc_html__( 'Default Home Price', 'framework' ),
				'description' => esc_html__( 'Provide an amount that will be set by default if the property price is not given.', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_mortgage_calculator',
			)
		);

		// Mortgage Calculator Default Down Payment Percentage.
		$wp_customize->add_setting(
			'inspiry_mc_downpayment_default',
			array(
				'type'              => 'option',
				'default'           => '10',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_downpayment_default',
			array(
				'label'       => esc_html__( 'Default Down Payment Percentage', 'framework' ),
				'description' => esc_html__( 'Provide a downpayment percentage (number only) to be set by default. E.g: 20', 'framework' ),
				'type'        => 'text',
				'section'     => 'inspiry_mortgage_calculator',
			)
		);

		// Select graph type.
		$wp_customize->add_setting(
			'inspiry_mc_graph_type',
			array(
				'type'              => 'option',
				'default'           => 'circle',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_graph_type',
			array(
				'label'   => esc_html__( 'Graph Type', 'framework' ),
				'type'    => 'select',
				'section' => 'inspiry_mortgage_calculator',
				'choices' => array(
					'bar'    => esc_html__( 'Bar', 'framework' ),
					'circle' => esc_html__( 'Circle', 'framework' ),
				),
			)
		);

		$wp_customize->add_setting(
			'inspiry_mc_fields_labels_separator',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_mc_fields_labels_separator',
				array(
					'section' => 'inspiry_mortgage_calculator',
				)
			)
		);

		// Term field label.
		$wp_customize->add_setting(
			'inspiry_mc_term_field_label',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Term', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_term_field_label',
			array(
				'label'   => esc_html__( 'Term Field Label', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Interest field label.
		$wp_customize->add_setting(
			'inspiry_mc_interest_field_label',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Interest', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_interest_field_label',
			array(
				'label'   => esc_html__( 'Interest Field Label', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Price field label.
		$wp_customize->add_setting(
			'inspiry_mc_price_field_label',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Home Price', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_price_field_label',
			array(
				'label'   => esc_html__( 'Price Field Label', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Down Payment field label.
		$wp_customize->add_setting(
			'inspiry_mc_downpayment_field_label',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Down Payment', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_downpayment_field_label',
			array(
				'label'   => esc_html__( 'Down Payment Field Label', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Principle and Interest label.
		$wp_customize->add_setting(
			'inspiry_mc_principle_field_label',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Principle and Interest', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_principle_field_label',
			array(
				'label'   => esc_html__( 'Principle and Interest Label', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Cost per month prefix.
		$wp_customize->add_setting(
			'inspiry_mc_cost_prefix',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'per month', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'inspiry_mc_cost_prefix',
			array(
				'label'   => esc_html__( 'Cost Per Month Prefix', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		$wp_customize->add_setting(
			'inspiry_mc_first_field_separator',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_mc_first_field_separator',
				array(
					'section' => 'inspiry_mortgage_calculator',
				)
			)
		);

		// Property metabox first field enable/disable.
		$wp_customize->add_setting(
			'inspiry_mc_first_field_display',
			array(
				'type'              => 'option',
				'default'           => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_first_field_display',
			array(
				'label'   => esc_html__( 'Property metabox first field', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_mortgage_calculator',
				'choices' => array(
					'true'  => esc_html__( 'Enable', 'framework' ),
					'false' => esc_html__( 'Disable', 'framework' ),
				),
			)
		);

		// Property metabox first field title.
		$wp_customize->add_setting(
			'inspiry_mc_first_field_title',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Property Taxes', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_first_field_title',
			array(
				'label'   => esc_html__( 'First field title', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Property metabox first field description.
		$wp_customize->add_setting(
			'inspiry_mc_first_field_desc',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Provide monthly property tax amount. It will be displayed only in the mortgage calculator.', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_first_field_desc',
			array(
				'label'   => esc_html__( 'First field description', 'framework' ),
				'type'    => 'textarea',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Property metabox first field default value.
		$wp_customize->add_setting(
			'inspiry_mc_first_field_value',
			array(
				'type'              => 'option',
				'default'           => '0',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'inspiry_mc_first_field_value',
			array(
				'label'   => esc_html__( 'First field default value', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		$wp_customize->add_setting(
			'inspiry_mc_second_field_separator',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new Inspiry_Separator_Control(
				$wp_customize,
				'inspiry_mc_second_field_separator',
				array(
					'section' => 'inspiry_mortgage_calculator',
				)
			)
		);

		// Property metabox second field enable/disable.
		$wp_customize->add_setting(
			'inspiry_mc_second_field_display',
			array(
				'type'              => 'option',
				'default'           => 'true',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);

		$wp_customize->add_control(
			'inspiry_mc_second_field_display',
			array(
				'label'   => esc_html__( 'Property metabox second field', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_mortgage_calculator',
				'choices' => array(
					'true'  => esc_html__( 'Enable', 'framework' ),
					'false' => esc_html__( 'Disable', 'framework' ),
				),
			)
		);

		// Property metabox second field title.
		$wp_customize->add_setting(
			'inspiry_mc_second_field_title',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Additional Fee', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'inspiry_mc_second_field_title',
			array(
				'label'   => esc_html__( 'Second field title', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Property metabox second field description.
		$wp_customize->add_setting(
			'inspiry_mc_second_field_desc',
			array(
				'type'              => 'option',
				'default'           => esc_html__( 'Provide monthly any additional fee. It will be displayed only in the mortgage calculator.', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'inspiry_mc_second_field_desc',
			array(
				'label'   => esc_html__( 'Second field description', 'framework' ),
				'type'    => 'textarea',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		// Property metabox second field default value.
		$wp_customize->add_setting(
			'inspiry_mc_second_field_value',
			array(
				'type'              => 'option',
				'default'           => '0',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'inspiry_mc_second_field_value',
			array(
				'label'   => esc_html__( 'Second field default value', 'framework' ),
				'type'    => 'text',
				'section' => 'inspiry_mortgage_calculator',
			)
		);

		$heading_selector = '.rh_property__mc_wrap .rh_property__heading';

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'inspiry_mortgage_calculator_title',
				array(
					'selector'            => $heading_selector,
					'container_inclusive' => false,
					'render_callback'     => 'inspiry_mortgage_calculator_title_render',
				)
			);
		}
	}

	add_action( 'customize_register', 'inspiry_mortgage_calculator_customizer' );
endif;

if ( ! function_exists( 'inspiry_mortgage_calculator_title_render' ) ) {
	/**
	 * Return mortgage calculator section title.
	 */
	function inspiry_mortgage_calculator_title_render() {
		if ( get_option( 'inspiry_mortgage_calculator_title' ) ) {
			echo esc_html( get_option( 'inspiry_mortgage_calculator_title' ) );
		}
	}
}
