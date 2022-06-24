<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Inquiry_Form_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'rhea-inquiry-form';
	}

	public function get_title() {
		return esc_html__( 'Inquiry Form', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'rhea_inquiry_form_section',
			[
				'label' => esc_html__( 'Fields', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$options = array(
			'prefix'     => esc_html__( 'Name Prefix', 'realhomes-elementor-addon' ),
			'name'       => esc_html__( 'Full Name', 'realhomes-elementor-addon' ),
			'email'      => esc_html__( 'Email', 'realhomes-elementor-addon' ),
			'number'     => esc_html__( 'Mobile Number', 'realhomes-elementor-addon' ),
			'home'       => esc_html__( 'Home Number', 'realhomes-elementor-addon' ),
			'work'       => esc_html__( 'Work Number', 'realhomes-elementor-addon' ),
			'country'    => esc_html__( 'Country', 'realhomes-elementor-addon' ),
			'address'    => esc_html__( 'Address', 'realhomes-elementor-addon' ),
			'city'       => esc_html__( 'City', 'realhomes-elementor-addon' ),
			'state'      => esc_html__( 'State/Province', 'realhomes-elementor-addon' ),
			'zip'        => esc_html__( 'Zip/Postal', 'realhomes-elementor-addon' ),
			'source'     => esc_html__( 'Source', 'realhomes-elementor-addon' ),
			'agent-name' => esc_html__( 'Agent or Negotiator', 'realhomes-elementor-addon' ),
			'message'    => esc_html__( 'Message', 'realhomes-elementor-addon' ),
			'custom'     => esc_html__( 'Custom', 'realhomes-elementor-addon' ),
		);


		$fields_repeater = new \Elementor\Repeater();


		$fields_repeater->add_control(
			'rhea_select_field_type',
			[
				'label'   => esc_html__( 'Select Field', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $options,
			]
		);

		$custom_field_type = array(
			'text'     => esc_html__( 'Text', 'realhomes-elementor-addon' ),
			'select'   => esc_html__( 'Select', 'realhomes-elementor-addon' ),
			'checkbox' => esc_html__( 'Checkbox', 'realhomes-elementor-addon' ),
			'radio'    => esc_html__( 'Radio', 'realhomes-elementor-addon' ),
			'date'     => esc_html__( 'Date', 'realhomes-elementor-addon' ),
		);

		$fields_repeater->add_responsive_control(
			'rhea_custom_fields_type',
			[
				'label'     => esc_html__( 'Field Type', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'text',
				'options'   => $custom_field_type,
				'condition' => [
					'rhea_select_field_type' => 'custom',
				],
			]
		);

		$fields_repeater->add_control(
			'rhea_field_label',
			[
				'label' => esc_html__( 'Label', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);
		$fields_repeater->add_control(
			'rhea_field_placeholder',
			[
				'label'      => esc_html__( 'Placeholder', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::TEXT,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'rhea_select_field_type',
							'operator' => '!==',
							'value'    => 'source'
						],
						[
							'name'     => 'rhea_select_field_type',
							'operator' => '!==',
							'value'    => 'agent-name'
						],
						[
							'name'     => 'rhea_custom_fields_type',
							'operator' => '!==',
							'value'    => 'date'
						],
                        [
							'name'     => 'rhea_custom_fields_type',
							'operator' => '!==',
							'value'    => 'checkbox'
						],
                        [
							'name'     => 'rhea_custom_fields_type',
							'operator' => '!==',
							'value'    => 'radio'
						],
                        [
							'name'     => 'rhea_custom_fields_type',
							'operator' => '!==',
							'value'    => 'select'
						],
					]
				],
			]
		);

		$fields_repeater->add_control(
			'rhea_custom_select_options',
			[
				'label'       => esc_html__( 'Select Options (Comma Separated)', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'If this field is empty, default select options from Dashboard -> Real Estate CRM -> Settings will be displayed', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'conditions'  => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'rhea_select_field_type',
							'operator' => '==',
							'value'    => 'prefix'
						],
						[
							'name'     => 'rhea_select_field_type',
							'operator' => '==',
							'value'    => 'source'
						],
					],
				],
			]
		);

		$fields_repeater->add_control(
			'rhea_custom_select_option',
			[
				'label'       => esc_html__( 'Options For Field ', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Add comma separated options (I.e Office,Shop,Villa) ', 'realhomes-elementor-addon' ),
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'rhea_custom_fields_type',
							'operator' => '!==',
							'value'    => 'text'
						],
						[
							'name'     => 'rhea_custom_fields_type',
							'operator' => '!==',
							'value'    => 'date'
						],
						[
							'name'     => 'rhea_select_field_type',
							'operator' => '==',
							'value'    => 'custom'
						],
					],

				],
			]
		);


		$fields_repeater->add_responsive_control(
			'rhea_field_size',
			[
				'label'   => esc_html__( 'Field Size', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '100%',
				'options' => array(
					'auto' => esc_html__( 'Custom', 'realhomes-elementor-addon' ),
					'10%'    => esc_html__( '10%', 'realhomes-elementor-addon' ),
					'20%'    => esc_html__( '20%', 'realhomes-elementor-addon' ),
					'25%'    => esc_html__( '25%', 'realhomes-elementor-addon' ),
					'33.33%' => esc_html__( '33%', 'realhomes-elementor-addon' ),
					'50%'    => esc_html__( '50%', 'realhomes-elementor-addon' ),
					'66.66%' => esc_html__( '66%', 'realhomes-elementor-addon' ),
					'75%'    => esc_html__( '75%', 'realhomes-elementor-addon' ),
					'80%'    => esc_html__( '80%', 'realhomes-elementor-addon' ),
					'100%'   => esc_html__( '100%', 'realhomes-elementor-addon' ),
				),
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'max-width: {{VALUE}};',
				],
			]
		);

		$fields_repeater->add_responsive_control(
			'rhea_field_custom_size',
			[
				'label'     => esc_html__( 'Custom Field Size', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'rhea_field_size' => 'auto',
				],
			]
		);

		$fields_repeater->add_control(
			'show_label',
			[
				'label'        => esc_html__( 'Show Label?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$fields_repeater->add_control(
			'rhea_required_field',
			[
				'label'        => esc_html__( 'Required', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$fields_repeater->add_control(
			'rhea_error_message',
			[
				'label'       => esc_html__( 'Error Message', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Show text if the required field is empty or invalid (i.e Email field is required)', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => [
					'rhea_required_field' => 'yes',
				],
			]
		);

		$fields_repeater->add_control(
			'add_break_after',
			[
				'label'        => esc_html__( 'Add Break After This Field?', 'realhomes-elementor-addon' ),
				'description'  => esc_html__( 'It will display next field from new row', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$fields_repeater->add_control(
			'add_separator',
			[
				'label'        => esc_html__( 'Add Separator At Bottom ?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition' => [
					'add_break_after' => 'yes',
				],
			]
		);


		$fields_repeater->add_control(
			'rhea_email_body_label',
			[
				'label'       => esc_html__( 'Field Label In Email Content', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'This text will be shown as label in email content ("Label" field text will be shown if this field is empty)', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'rhea_select_field_type' => 'custom',
				],
			]
		);



		$this->add_control(
			'rhea_add_field_select',
			[
				'label'       => esc_html__( 'Add Field', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $fields_repeater->get_controls(),
				'title_field' => ' {{{ rhea_field_label }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_inquiry_form_settings',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'rhea_submit_text',
			[
				'label'   => esc_html__( 'Submit Button Text', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Submit', 'realhomes-elementor-addon' ),
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
			'rhea_target_email',
			[
				'label'       => esc_html__( 'Target Email', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Target email on which the message will be sent', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_target_email_cc',
			[
				'label'       => esc_html__( 'Target Email CC', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Target CC emails with coma separated', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_target_email_bcc',
			[
				'label'       => esc_html__( 'Target Email BCC', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Target BCC emails with coma separated', 'realhomes-elementor-addon' ),
			]
		);;


		$this->end_controls_section();

		$this->start_controls_section(
			'inquiry_form_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'label'    => esc_html__( 'Labels', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-inquiry-form-inner .rhea-inquiry-field label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'fields_typography',
				'label'    => esc_html__( 'Fields Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-inquiry-form-field',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'checkbox_radio_typography',
				'label'    => esc_html__( 'Checkbox/Radio Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-custom-checkbox-label',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'submit_typography',
				'label'    => esc_html__( 'Submit Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-inquiry-form-field',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'gdpr_required_typography',
				'label'    => esc_html__( 'GDPR Required Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .gdpr-checkbox-label',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'gdpr_text_typography',
				'label'    => esc_html__( 'GDPR Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_inspiry_gdpr label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'submit_message_text_typography',
				'label'       => esc_html__( 'Message After Submit Form', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Message appears when form is being submitted', 'realhomes-elementor-addon' ),
				'scheme'      => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector'    => '{{WRAPPER}} .rhea-message-container',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'        => 'error_message_text_typography',
				'label'       => esc_html__( 'Invalid/Required Fields Text', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Message appears when there are invalid or empty required fields', 'realhomes-elementor-addon' ),
				'scheme'      => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector'    => '{{WRAPPER}} .rhea-error-container .error',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'basic-styles',
			[
				'label' => esc_html__( 'Basic', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'field-height',
			[
				'label'     => esc_html__( 'Field Height (px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-field:not(textarea)' => 'height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'textarea-height',
			[
				'label'     => esc_html__( 'Textarea Height (px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} textarea.rhea-inquiry-form-field' => 'height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'label-margin-bottom',
			[
				'label'     => esc_html__( 'Label Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-field label' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'field-margin-bottom',
			[
				'label'     => esc_html__( 'Field Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-field'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_inspiry_gdpr'           => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .inspiry-recaptcha-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field-between-space',
			[
				'label'     => esc_html__( 'Horizontal Space In Fields (px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-inner .rhea-inquiry-field'          => 'padding-right: {{SIZE}}{{UNIT}};padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-inquiry-form-inner'                              => 'margin-right: -{{SIZE}}{{UNIT}};margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-inquiry-form-inner .rhea-inquiry-submit-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-inquiry-gdpr-and-recaptcha'                      => 'margin-right: {{SIZE}}{{UNIT}};margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-error-container'                                 => 'margin-right: {{SIZE}}{{UNIT}};margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea-message-container'                               => 'margin-right: {{SIZE}}{{UNIT}};margin-left: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->add_responsive_control(
			'fields-padding',
			[
				'label'      => esc_html__( 'Fields Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-inquiry-form-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea-submit-button-size',
			[
				'label'      => esc_html__( 'Submit Button Size (%)', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-inquiry-submit' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'submit-button-padding',
			[
				'label'      => esc_html__( 'Submit Button Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-inquiry-form-inner .rhea-inquiry-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rhea_submit_align',
			[
				'label'     => esc_html__( 'Submit Button Alignment', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => '',
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-submit-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'separator_height',
			[
				'label'     => esc_html__( 'Separator Height (px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-separator' => 'height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'separator_width',
			[
				'label'     => esc_html__( 'Separator Width (%)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-separator' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'separator_top_margin',
			[
				'label'     => esc_html__( 'Separator Top Margin (px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-separator' => 'margin-top: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'separator_bottom_margin',
			[
				'label'     => esc_html__( 'Separator Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-separator' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->add_control(
			'separator_padding_color',
			[
				'label'     => esc_html__( 'Separator Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-separator' => 'background: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'inquiry-colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'field-label',
			[
				'label'     => esc_html__( 'Label Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-field label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'field-color',
			[
				'label'     => esc_html__( 'Field Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-field' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'field-placeholder-color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-inner ::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea-inquiry-form-inner ::-moz-placeholder'          => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea-inquiry-form-inner :-ms-input-placeholder'      => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea-inquiry-form-inner :-moz-placeholder'           => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'field-background',
			[
				'label'     => esc_html__( 'Field Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-field' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'checkbox-text-color',
			[
				'label'     => esc_html__( 'Checkbox/Radio Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-custom-checkbox-label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'submit-button-text-color',
			[
				'label'     => esc_html__( 'Submit Button Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-submit' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'submit-button-text-hover-color',
			[
				'label'     => esc_html__( 'Submit Button Text Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-submit:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'submit-button-bg-color',
			[
				'label'     => esc_html__( 'Submit Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-submit' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'submit-button-bg-hover-color',
			[
				'label'     => esc_html__( 'Submit Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-submit:hover' => 'background: {{VALUE}}',
				],
				'condition' => [
					'rhea_button_animate' => '',
				],
			]
		);
		$this->add_control(
			'submit-button-animate-hover-color',
			[
				'label'     => esc_html__( 'Submit Button Animate Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-btn-primary:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'rhea_button_animate' => 'yes',
				],
			]
		);

		$this->add_control(
			'gdpr-required-label',
			[
				'label'     => esc_html__( 'GDPR Required Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gdpr-checkbox-label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'gdpr-text-color',
			[
				'label'     => esc_html__( 'GDPR Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rh_inspiry_gdpr label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'message-container-color',
			[
				'label'     => esc_html__( 'Message After Submit Form', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-message-container' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'error-message-color',
			[
				'label'     => esc_html__( 'Invalid/Required Fields Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-error-container .error' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'inquiry-border-settings',
			[
				'label' => esc_html__( 'Border Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'fields-heading',
			[
				'label'     => esc_html__( 'Fields Border', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => '',
			]
		);


		$this->add_responsive_control(
			'fields_border_radius',
			[
				'label' => esc_html__( 'Fields Border Radius', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-form-field' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'field-border',
				'label'    => esc_html__( 'Fields Border', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea-inquiry-form-field',
			]
		);

		$this->add_control(
			'border-color-error',
			[
				'label'     => esc_html__( 'Invalid Required Field Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'selector' => '{{WRAPPER}} .rhea-inquiry-form-field.error',
				],
			]
		);

		$this->add_control(
			'submit-heading',
			[
				'label'     => esc_html__( 'Submit Button', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_responsive_control(
			'submit_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-submit' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'submit-field-border',
				'label'    => esc_html__( 'Submit Button Border', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea-inquiry-submit',
			]
		);


		$this->add_responsive_control(
			'submit_border_radius_hover',
			[
				'label'     => esc_html__( 'Border Radius On Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-inquiry-submit:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'submit-field-border-hover',
				'label'    => esc_html__( 'Submit Button Border Hover', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea-inquiry-submit:hover',
			]
		);


		$this->end_controls_section();

	}

	public function field_types( $field_type, $id, $required, $error_message, $placeholder = '',$custom_options = '' ) {

		$type = $field_type;

		$ph = '';
		if ( ! empty( $placeholder ) ) {
			$ph = $placeholder;
		}

		$required_fields = '';
		if ( 'yes' == $required ) {
			$required_fields = ' required ';
		}

		$error = '';
		if ( ! empty( $error_message ) ) {
			$error = $error_message;
		}

		switch ( $type ) {
			case 'prefix' :

			    if ( ! empty( $custom_options ) ) {
				    $contact_prefix = $custom_options;
			    } else {
				    $contact_prefix = get_option( 'recrm_settings' )['recrm_contact_prefixes_settings'];
			    }
				$option_array = explode( ',', $contact_prefix );

				?>
                <select class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                        name="<?php echo esc_attr( $type ) ?>" id="<?php echo esc_attr( $id ) ?>"
                        title="<?php echo esc_attr( $error ) ?>">

					<?php
					if ( is_array( $option_array ) && ! empty( $option_array ) ) {
						foreach ( $option_array as $single ) {
							?>
                            <option value="<?php echo esc_attr( $single ) ?>"><?php echo esc_html( $single ) ?></option>

							<?php
						}

					}
					?>

                </select>
				<?php
				break;

			case 'source' :

				if ( ! empty( $custom_options ) ) {
					$inquiry_sources = $custom_options;
				} else {
					$inquiry_sources = get_option( 'recrm_settings' )['recrm_contact_source_settings'];
				}
				$option_array = explode( ',', $inquiry_sources );

				?>
                <select class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                        name="<?php echo esc_attr( $type ) ?>" id="<?php echo esc_attr( $id ) ?>"
                        title="<?php echo esc_attr( $error ) ?>">

					<?php
					if ( is_array( $option_array ) && ! empty( $option_array ) ) {
						foreach ( $option_array as $single ) {
							?>
                            <option value="<?php echo esc_attr( $single ) ?>"><?php echo esc_html( $single ) ?></option>

							<?php
						}

					}
					?>

                </select>
				<?php
				break;

			case 'agent-name' :

				$ere_get_agents_array = ere_get_agents_array();
				?>
                <select class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                        name="<?php echo esc_attr( $type ) ?>" id="<?php echo esc_attr( $id ) ?>"
                        title="<?php echo esc_attr( $error ) ?>">
					<?php
					if ( is_array( $ere_get_agents_array ) && ! empty( $ere_get_agents_array ) ) {
						foreach ( $ere_get_agents_array as $agent ) {
							?>
                            <option value="<?php echo esc_attr( $agent ) ?>"><?php echo esc_html( $agent ) ?></option>
							<?php
						}

					}
					?>
                </select>
				<?php
				break;

			case 'name' :
			case 'number' :
			case 'home' :
			case 'work' :
			case 'country' :
			case 'address' :
			case 'city' :
			case 'state' :
			case 'zip' :
				?>
                <input class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                       name="<?php echo esc_attr( $type ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text"
                       placeholder="<?php echo esc_attr( $ph ) ?>" title="<?php echo esc_attr( $error ) ?>">
				<?php
				break;

			case 'email' :
				if ( ! empty( $error ) ) {
					$invalid_email = $error;
				} else {
					$invalid_email = esc_html__( 'Provide a valid email address', 'realhomes-elementor-addon' );
				}
				?>
                <input class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                       name="<?php echo esc_attr( $type ) ?>" id="<?php echo esc_attr( $id ) ?>" type="email"
                       placeholder="<?php echo esc_attr( $ph ) ?>" title="<?php echo esc_attr( $invalid_email ) ?>">
				<?php
				break;
			case 'message' :
				?>
                <textarea class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                          name="<?php echo esc_attr( $type ) ?>" id="<?php echo esc_attr( $id ) ?>"
                          placeholder="<?php echo esc_attr( $ph ); ?>" cols="30" rows="4"
                          title="<?php echo esc_attr( $error ) ?>"></textarea>
				<?php
				break;


		}

	}

	public function custom_field_types( $field_type, $id, $required, $error_message, $select_options, $label, $placeholder = '' ) {
		$type = $field_type;

		$ph = '';
		if ( ! empty( $placeholder ) ) {
			$ph = $placeholder;
		}

		$required_fields = '';
		if ( 'yes' == $required ) {
			$required_fields = ' required ';
		}

		$error = '';
		if ( ! empty( $error_message ) ) {
			$error = $error_message;
		}
		switch ( $type ) {
			case 'date' :
				?>
                <input type="hidden" name="rhea_custom_label[]" value="<?php echo esc_attr( $label ) ?>">
                <input class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                       name="rhea_custom_field[]" id="<?php echo esc_attr( $id ) ?>" type="date"
                       placeholder="<?php echo esc_attr( $ph ) ?>" title="<?php echo esc_attr( $error ) ?>">
				<?php
				break;
			case 'text' :
				?>
                <input type="hidden" name="rhea_custom_label[]" value="<?php echo esc_attr( $label ) ?>">
                <input class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                       name="rhea_custom_field[]" id="<?php echo esc_attr( $id ) ?>" type="text"
                       placeholder="<?php echo esc_attr( $ph ) ?>" title="<?php echo esc_attr( $error ) ?>">
				<?php
				break;

			case 'select' :

				if ( ! empty( $select_options ) ) {
					$option_array = explode( ',', $select_options );
					?>
                    <input type="hidden" name="rhea_custom_label[]" value="<?php echo esc_attr( $label ) ?>">
                    <select class="rhea-inquiry-form-field <?php echo esc_attr( $required_fields ); ?>"
                            name="rhea_custom_field[]" id="<?php echo esc_attr( $id ) ?>"
                            title="<?php echo esc_attr( $error ) ?>">
						<?php
						if ( is_array( $option_array ) && ! empty( $option_array ) ) {
							foreach ( $option_array as $option ) {
								?>
                                <option value="<?php echo esc_attr( $option ) ?>"><?php echo esc_html( $option ) ?></option>
								<?php
							}

						}
						?>
                    </select>
					<?php
				}
				break;
			case 'checkbox' :
				if ( ! empty( $select_options ) ) {
					$option_array = explode( ',', $select_options );

					?>
                    <input type="hidden" name="rhea_custom_label[]" value="<?php echo esc_attr( $label ) ?>">
					<?php
					if ( is_array( $option_array ) && ! empty( $option_array ) ) {
						?>
                        <div class="rhea-radio-checkbox-fields">
							<?php
							$i = 1;
							foreach ( $option_array as $option ) {
								?>
                                <label>
                                    <input type="checkbox" name="rhea_custom_field[<?php echo esc_attr( $id ) ?>][]"
                                           id="<?php echo esc_attr( $id ) ?>"
                                           title="<?php echo esc_attr( $error ) ?>"
                                           value="<?php echo esc_attr( $option ) ?>">
                                    <span class="rhea-custom-checkbox-label"><?php echo esc_html( $option ) ?></span>
                                </label>
								<?php
								$i ++;
							}
							?>
                        </div>
						<?php
					}
					?>

					<?php
				}
				break;
			case 'radio' :
				if ( ! empty( $select_options ) ) {
					$option_array = explode( ',', $select_options );

					?>
                    <input type="hidden" name="rhea_custom_label[]" value="<?php echo esc_attr( $label ) ?>">
					<?php
					if ( is_array( $option_array ) && ! empty( $option_array ) ) {
						?>
                        <div class="rhea-radio-checkbox-fields">
							<?php
							$i = 1;
							foreach ( $option_array as $option ) {
								?>
                                <label class="rhea-radio-checkbox-fields">
                                    <input type="radio" name="rhea_custom_field[<?php echo esc_attr( $id ) ?>][]"
                                           id="<?php echo esc_attr( $id ) ?>"
                                           title="<?php echo esc_attr( $error ) ?>"
                                           value="<?php echo esc_attr( $option ) ?>">
                                    <span class="rhea-custom-checkbox-label"><?php echo esc_html( $option ) ?></span>
                                </label>
								<?php
								$i ++;
							}
							?>
                        </div>
						<?php
					}
					?>

					<?php
				}
				break;

		}
	}


	protected function render() {
		$settings       = $this->get_settings_for_display();
		$inquiry_fields = $settings['rhea_add_field_select'];


		if ( $inquiry_fields ) {
			?>
            <div class="rhea-inquiry-form-wrapper">
                <form class="rhea-inquiry-form" id="inquiry_<?php echo esc_attr( $this->get_id() ); ?>"
                      action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
                      method="post">
                    <div class="rhea-inquiry-form-inner">
						<?php
						foreach ( $inquiry_fields as $fields ) {
							?>
                            <div
                                 class="rhea-inquiry-field rhea-field-type-<?php echo esc_attr( $fields['rhea_select_field_type'] ) ?> elementor-repeater-item-<?php echo esc_attr( $fields['_id'] ) ?>">
								<?php
								if ( 'yes' === $fields['show_label'] && ! empty( $fields['rhea_field_label'] ) ) {
									?>
                                    <label for="<?php echo esc_attr( $fields['_id'] ) ?>"><?php echo esc_html( $fields['rhea_field_label'] ) ?></label>
									<?php
								}
								if ( 'custom' !== $fields['rhea_select_field_type'] ) {
									$this->field_types( $fields['rhea_select_field_type'], $fields['_id'], $fields['rhea_required_field'], $fields['rhea_error_message'], $fields['rhea_field_placeholder'],$fields['rhea_custom_select_options'] );
								} else {
									if ( ! empty( $fields['rhea_email_body_label'] ) ) {
										$custom_field_label = $fields['rhea_email_body_label'];

									} else {
										$custom_field_label = $fields['rhea_field_label'];
									}
									$this->custom_field_types( $fields['rhea_custom_fields_type'], $fields['_id'], $fields['rhea_required_field'], $fields['rhea_error_message'], $fields['rhea_custom_select_option'], $custom_field_label, $fields['rhea_field_placeholder'] );
								}
								?>
                            </div>
							<?php
							if ( 'yes' == $fields['add_break_after'] ) {
								?>
                                <div class="rhea-inquiry-field-break">
	                                <?php
                                    if('yes' == $fields['add_separator']){
                                    ?>
                                    <div class="rhea-inquiry-form-separator"></div>
	                                    <?php
                                    }
                                    ?>
                                </div>
								<?php
							}
						}
						?>
                        <input type="hidden" name="nonce"
                               value="<?php echo esc_attr( wp_create_nonce( 'rhea_inquiry_form' ) ); ?>"/>
                        <input type="hidden" name="target-email"
                               value="<?php echo antispambot( $settings['rhea_target_email'] ) ?>"/>
                        <input type="hidden" name="target-email-cc"
                               value="<?php echo antispambot( $settings['rhea_target_email_cc'] ) ?>"/>
                        <input type="hidden" name="target-email-bcc"
                               value="<?php echo antispambot( $settings['rhea_target_email_bcc'] ) ?>"/>
                        <input type="hidden" name="action" value="rhea_inquiry_send_message"/>

						<?php
						if ( ere_is_gdpr_enabled() || ere_is_reCAPTCHA_configured() ) {
							?>
                            <div class="rhea-inquiry-gdpr-and-recaptcha">
								<?php
								if ( function_exists( 'ere_gdpr_agreement' ) ) {
									ere_gdpr_agreement( array(
										'id'              => 'rh_inspiry_gdpr',
										'container_class' => 'rh_inspiry_gdpr',
										'title_class'     => 'gdpr-checkbox-label'
									) );
								}
								if ( class_exists( 'Easy_Real_Estate' ) ) {
									if ( ere_is_reCAPTCHA_configured() ) {
										$recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
										?>
                                        <div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
                                            <div class="inspiry-google-recaptcha"></div>
                                        </div>
										<?php
									}
								}
								?>
                            </div>
							<?php
						}
						?>
                        <div class="rhea-inquiry-form-break"></div>
                        <div class="rhea-message-container"></div>
                        <div class="rhea-error-container"></div>

                        <div class="rhea-inquiry-submit-wrapper">
	                        <?php
	                        $animate_search_button = '';
	                        if('yes' == $settings['rhea_button_animate']){
		                        $animate_search_button = ' rhea-btn-primary ';
	                        }
                            ?>
                            <button class="rhea-inquiry-submit <?php echo esc_attr($animate_search_button)?>" type="submit" name="submit"
                                    id="inquiry-submit-<?php echo esc_attr( $this->get_id() ); ?>">
                                <span class="rhea-inquiry-button-text"><?php echo esc_html( $settings['rhea_submit_text'] ); ?></span>
                                <div class="rhea-ajax-loader">
                                    <span class="rhea_loader_box"><?php rhea_safe_include_svg( 'icons/loader.svg' ); ?></span>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <script type="application/javascript">
                jQuery(document).on('ready', function () {
                    rheaSubmitContactForm("#inquiry_<?php echo esc_attr( $this->get_id() );?>", "#inquiry-submit-<?php echo esc_attr( $this->get_id() );?>");
                });
            </script>
			<?php
		}
	}

}