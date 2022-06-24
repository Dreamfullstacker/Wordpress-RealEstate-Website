<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Schedule_Tour_Form_Widget extends \Elementor\Widget_Base {

	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );

        wp_enqueue_style( 'flatpickr' );
        wp_enqueue_script( 'flatpickr' );
	}

	public function get_name() {
		return 'rhea-schedule-tour-form-widget';
	}

	public function get_title() {
		return esc_html__( 'Schedule Tour Form', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'section_subtitle',
			[
				'label'       => esc_html__( 'Sub Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'section_title',
			[
				'label'       => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'target_email',
			[
				'label'       => esc_html__( 'Target Email ( Required )', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'The message will be sent on this email address.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'your@email.com',
                'separator'   => 'before'
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Submit Button Text', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Schedule a Tour', 'realhomes-elementor-addon' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'contacts_list',
			[
				'label' => esc_html__( 'Contacts List', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_contacts_list',
			[
				'label' => __( 'Show', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'realhomes-elementor-addon' ),
				'label_off' => __( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'agent_thumb',
			[
				'label'       => esc_html__( 'Agent Photo', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended Image Size 150x150.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'agent_name',
			[
				'label'   => esc_html__( 'Agent Name', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Jonathan Doe',
			]
		);

		$this->add_control(
			'agent_designation',
			[
				'label'   => esc_html__( 'Designation', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Real Estate Agent', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'contact_number',
			[
				'label'   => esc_html__( 'Number', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '(223) 546 7594',
			]
		);

		$this->add_control(
			'contact_email_address',
			[
				'label'   => esc_html__( 'Email', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'contact@realhomes.io',
			]
		);

		$this->add_control(
			'contact_address',
			[
				'label'       => esc_html__( 'Address', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'HTML tags a, b, br, em and strong can be used in address.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '1130, Avenue Villa, Newyork, USA',
			]
		);

		$this->add_control(
			'contact_call_to_action',
			[
				'label'       => esc_html__( 'Call to Action Text', 'realhomes-elementor-addon' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Would you like to Visit the property?', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'contact_call_to_action_link_text',
			[
				'label'       => esc_html__( 'Call to Action Link Text', 'realhomes-elementor-addon' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Schedule a meeting', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'contact_call_to_action_url',
			[
				'label'         => esc_html__( 'Call to Action URL', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'container',
			[
				'label' => esc_html__( 'Container', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_wrapper_width',
			[
				'label'     => esc_html__( 'Content Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 600,
						'max' => 1600,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_wrapper_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'container_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-container-bg-color' => 'background: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'container_bg_width',
			[
				'label'     => esc_html__( 'Background Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-container-bg-color' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'container_bg_height',
			[
				'label'     => esc_html__( 'Background Height', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-container-bg-color' => 'height: {{SIZE}}%;',
				],
			]
		);

		$this->add_control(
			'container_bg_img',
			[
				'label'   => esc_html__( 'Background Image', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude'   => [ 'custom' ],
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_head_styles',
			[
				'label' => esc_html__( 'Content', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sub_title_color',
			[
				'label'     => esc_html__( 'Sub Title Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-section-head-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_title_typography',
				'label'    => esc_html__( 'Sub Title Typography', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea-stf-section-head-subtitle',
			]
		);

		$this->add_control(
			'main_title_color',
			[
				'label'     => esc_html__( 'Main Title Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-section-head-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'main_title_typography',
				'label'    => esc_html__( 'Main Title Typography', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea-stf-section-head-title',
			]
		);

		$this->add_control(
			'heading_form',
			[
				'label' => esc_html__( 'Form', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_responsive_control(
			'form_padding',
			[
				'label'      => esc_html__( 'Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-form' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_form_labels',
			[
				'label' => esc_html__( 'Labels', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'form_labels_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-form .rhea-stf-form-field label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_labels_typography',
				'selector' => '{{WRAPPER}} .rhea-stf-form .rhea-stf-form-field label',
			]
		);

		$this->add_control(
			'heading_form_fields',
			[
				'label' => esc_html__( 'Fields', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'form_fields_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form input[type="text"], {{WRAPPER}} .rhea-stf-form input[type="email"], {{WRAPPER}} .rhea-stf-form .flatpickr-mobile'  => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_fields_focus_color',
			[
				'label'     => esc_html__( 'Focus Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form input[type="text"]:focus, {{WRAPPER}} .rhea-stf-form input[type="email"]:focus, {{WRAPPER}} .rhea-stf-form .flatpickr-mobile:focus'  => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_fields_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form input[type="text"], {{WRAPPER}} .rhea-stf-form input[type="email"], {{WRAPPER}} .rhea-stf-form .flatpickr-mobile'  => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_fields_typography',
				'selector' => '{{WRAPPER}} .rhea-stf-form input[type="text"], {{WRAPPER}} .rhea-stf-form input[type="email"]',
			]
		);

		$this->add_control(
			'heading_submit_button',
			[
				'label' => esc_html__( 'Submit Button', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'form_submit_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form .rhea-stf-submit'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_submit_active_color',
			[
				'label'     => esc_html__( 'Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form .rhea-stf-submit:hover'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_submit_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form .rhea-stf-submit'  => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_submit_active_bg_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form .rhea-stf-submit:hover'  => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'form_submit_typography',
				'selector' => '{{WRAPPER}} .rhea-stf-form .rhea-stf-submit',
			]
		);

		$this->add_control(
			'form_loader_color',
			[
				'label'     => esc_html__( 'Loader Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .rhea-stf-form .rhea-stf-ajax-loader path'  => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_contacts_list_styles',
			[
				'label' => esc_html__( 'Contacts List', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'contact_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-contacts-item a, {{WRAPPER}} .rhea-stf-contacts-item span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'contact_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-contacts-item a:hover, {{WRAPPER}} .rhea-stf-contacts-call-to-action-item a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'contact_typography',
				'label'    => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea-stf-contacts-item a, {{WRAPPER}} .rhea-stf-contacts-item span',
			]
		);

		$this->add_control(
			'agent_name_color',
			[
				'label'     => esc_html__( 'Agent Name Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-contacts-item .rhea-stf-agent-name' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_name_typography',
				'label'    => esc_html__( 'Agent Name Typography', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea-stf-contacts-item .rhea-stf-agent-name',
			]
		);


		$this->add_control(
			'cta_text_color',
			[
				'label'     => esc_html__( 'Call To Action Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-contacts-call-to-action-item a, {{WRAPPER}} .rhea-stf-contacts-call-to-action-item span' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'cta_text_typography',
				'label'    => esc_html__( 'Call To Action Text Typography', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea-stf-contacts-call-to-action-item a, {{WRAPPER}} .rhea-stf-contacts-call-to-action-item span',
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label'     => esc_html__( 'Box Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-contacts-wrap:before' => 'background: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'box_width',
			[
				'label'     => esc_html__( 'Box Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-contacts-wrap:before' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'box_height',
			[
				'label'     => esc_html__( 'Box Height', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-stf-contacts-wrap:before' => 'height: {{SIZE}}%;',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = $this->get_id();
		?>
        <div id="rhea-stf-container-<?php echo esc_attr( $widget_id ); ?>" class="rhea-stf-container">

            <div class="rhea-stf-container-bg"
                 style="background-image: url('<?php echo esc_url( \Elementor\Group_Control_Image_Size::get_attachment_image_src( $settings['container_bg_img']['id'], 'thumbnail', $settings ) ); ?>')">
                <div class="rhea-stf-container-bg-color"></div>
            </div>

            <div class="rhea-stf-content">
				<?php
				if ( ! empty( $settings['section_subtitle'] ) || ! empty( $settings['section_title'] ) ) :
					?>
                    <div class="rhea-stf-section-head">
						<?php
						if ( ! empty( $settings['section_subtitle'] ) ) :
							?>
                            <span class="rhea-stf-section-head-subtitle">
                                <?php echo esc_html( $settings['section_subtitle'] ); ?>
                            </span>
						<?php
						endif;

						if ( ! empty( $settings['section_title'] ) ) :
							?>
                            <h2 class="rhea-stf-section-head-title">
								<?php echo esc_html( $settings['section_title'] ); ?>
                            </h2>
						<?php
						endif;
						?>
                    </div>
				<?php
				endif;
				?>

                <form class="rhea-stf-form" id="rhea-stf-form-<?php echo esc_attr( $widget_id ); ?>" method="post"
                      action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">

                    <div class="rhea-stf-form-fields">
                        <div class="rhea-stf-form-field rhea-stf-form-name-field">
                            <label for="name-<?php echo esc_attr( $widget_id ); ?>"><?php esc_html_e( 'Hey my name is', 'realhomes-elementor-addon' ) ?></label>
                            <input type="text" name="name" id="name-<?php echo esc_attr( $widget_id ); ?>"
                                   class="rhea-stf-field required" autocomplete="off"
                                   title="<?php esc_attr_e( '* Please provide your name.', 'realhomes-elementor-addon' ); ?>">
                        </div>

                        <div class="rhea-stf-form-field rhea-stf-form-email-field">
                            <label for="email-<?php echo esc_attr( $widget_id ); ?>"><?php esc_html_e( 'and my email id is', 'realhomes-elementor-addon' ) ?></label>
                            <input type="email" name="email" id="email-<?php echo esc_attr( $widget_id ); ?>"
                                   class="rhea-stf-field email required" autocomplete="off"
                                   title="<?php esc_attr_e( '* Please provide a valid email address.', 'realhomes-elementor-addon' ); ?>">
                        </div>

                        <div class="rhea-stf-form-field rhea-stf-form-date-field" id="date-field-<?php echo esc_attr( $widget_id ); ?>-wrapper">
                            <label for="date-<?php echo esc_attr( $widget_id ); ?>"><?php esc_html_e( 'I would like to schedule a tour at date and time', 'realhomes-elementor-addon' ) ?></label>
                            <input type="text" name="date" id="date-<?php echo esc_attr( $widget_id ); ?>"
                                   class="rhea-stf-field date required" autocomplete="off"
                                   title="<?php esc_attr_e( '* Please specify the date.', 'realhomes-elementor-addon' ); ?>">
                        </div>

                        <div class="rhea-stf-form-field rhea-stf-form-message-field">
                            <label for="message-<?php echo esc_attr( $widget_id ); ?>"><?php esc_html_e( 'I would like to discuss about', 'realhomes-elementor-addon' ) ?></label>
                            <input type="text" name="message" id="message-<?php echo esc_attr( $widget_id ); ?>" class="rhea-stf-field required" autocomplete="off" title="<?php esc_attr_e( '* Please provide your message.', 'realhomes-elementor-addon' ); ?>">
                        </div>
                    </div>

                    <input type="hidden" name="nonce"
                           value="<?php echo esc_attr( wp_create_nonce( 'schedule_tour_form_nonce' ) ); ?>"/>
                    <input type="hidden" name="target"
                           value="<?php echo esc_attr( antispambot( $settings['target_email'] ) ); ?>"/>
                    <input type="hidden" name="action" value="rhea_schedule_tour_form_mail"/>

                    <div class="rhea-stf-submit-wrapper">
						<?php
						$rhea_stf_button_text = esc_html__( 'Schedule a Tour', 'realhomes-elementor-addon' );
						if ( ! empty( $settings['button_text'] ) ) {
							$rhea_stf_button_text = $settings['button_text'];
						}
						?>
                        <input class="rhea-stf-submit" type="submit" name="submit"
                               value="<?php echo esc_attr( $rhea_stf_button_text ); ?>">

                        <div class="rhea-stf-ajax-loader"><?php rhea_safe_include_svg( 'icons/loader.svg' ); ?></div>
                    </div>

                    <div class="rhea-stf-error-container"></div>
                    <div class="rhea-stf-message-container"></div>
                </form>

	            <?php
	            if ( isset( $settings['show_contacts_list'] ) && 'yes' === $settings['show_contacts_list'] ) {
		            ?>
                    <div class="rhea-stf-contacts-wrap">
                        <div class="rhea-stf-contacts-item rhea-stf-agent-meta">
				            <?php
				            if ( ! empty( $settings['agent_thumb'] ) ) :
					            ?>
                                <div class="rhea-stf-agent-image">
						            <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'agent_thumb' ); ?>
                                </div>
				            <?php
				            endif;

				            if ( ! empty( $settings['agent_name'] ) || ! empty( $settings['rhea_testimonial_author_designation'] ) ) : ?>
                                <div class="rhea-stf-agent-details">
						            <?php
						            if ( ! empty( $settings['agent_name'] ) ) : ?>
                                        <h3 class="rhea-stf-agent-name"><?php echo esc_html( $settings['agent_name'] ); ?></h3><?php
						            endif;

						            if ( ! empty( $settings['agent_designation'] ) ) : ?>
                                        <span class="rhea-stf-agent-designation"><?php echo esc_html( $settings['agent_designation'] ); ?></span><?php
						            endif;
						            ?>
                                </div>
				            <?php
				            endif;
				            ?>
                        </div>
			            <?php
			            if ( ! empty( $settings['contact_number'] ) || ! empty( $settings['contact_email_address'] ) ) :
				            ?>
                            <div class="rhea-stf-contacts-item">
					            <?php
					            if ( ! empty( $settings['contact_email_address'] ) ) :?>
                                    <a href="mailto:<?php echo esc_attr( antispambot( $settings['contact_email_address'] ) ) ?>"
                                       class="rhea-stf-list-text"><?php echo esc_attr( antispambot( $settings['contact_email_address'] ) ) ?></a>
					            <?php
					            endif;

					            if ( ! empty( $settings['contact_number'] ) ) :?>
                                    <a href="tel:<?php echo esc_attr( $settings['contact_number'] ) ?>"
                                       class="rhea-stf-list-text"><?php echo esc_html( $settings['contact_number'] ) ?></a>
					            <?php
					            endif;
					            ?>
                            </div>
			            <?php
			            endif;

			            if ( ! empty( $settings['contact_address'] ) ) :
				            ?>
                            <div class="rhea-stf-contacts-item rhea-stf-contacts-address-item">
                                <span><?php echo wp_kses( $settings['contact_address'], inspiry_allowed_html() ); ?></span>
                            </div>
			            <?php
			            endif;

			            if ( ! empty( $settings['contact_call_to_action'] ) ) :
				            ?>
                            <div class="rhea-stf-contacts-item rhea-stf-contacts-call-to-action-item">
                                <span><?php echo esc_html( $settings['contact_call_to_action'] ); ?></span>
					            <?php
					            if ( $settings['contact_call_to_action_url']['url'] ) :
						            $target = $settings['contact_call_to_action_url']['is_external'] ? ' target="_blank"' : '';
						            $nofollow = $settings['contact_call_to_action_url']['nofollow'] ? ' rel="nofollow"' : '';
						            ?>
                                    <a href="<?php echo esc_url( $settings['contact_call_to_action_url']['url'] ); ?>"<?php echo $target . $nofollow; ?>>
							            <?php echo esc_html( $settings['contact_call_to_action_link_text'] ); ?>
                                    </a>
					            <?php
					            endif;
					            ?>
                            </div>
			            <?php
			            endif;
			            ?>
                    </div>
		            <?php
	            }
	            ?>
            </div>
        </div>
        <script type="application/javascript">
            (function ($) {
                'use strict';
                $(document).ready(function () {
                    flatpickr('#date-<?php echo esc_html( $widget_id ); ?>', {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                    });

                    var dateFieldWrapper = $('#date-field-<?php echo esc_attr( $widget_id ); ?>-wrapper');
                    dateFieldWrapper.find('.flatpickr-mobile').attr('title', dateFieldWrapper.find('#date-<?php echo esc_html( $widget_id ); ?>').attr('title'));

                    rheaScheduleTourForm('#rhea-stf-form-<?php echo esc_attr( $widget_id ); ?>');
                });
            })(jQuery);
        </script>
		<?php
	}
}