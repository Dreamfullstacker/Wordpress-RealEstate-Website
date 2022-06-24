<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agent_Contact_Form_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'rhea-agent-contact-form-widget';
	}

	public function get_title() {
		return esc_html__( 'Agent Contact Form', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rhea_add_content',
			[
				'label' => esc_html__( 'Thumbnail', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'rhea_acf_title',
			[
				'label'   => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Draco Freeman', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_acf_sub_title',
			[
				'label'   => esc_html__( 'Sub Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Real Estate Agent.', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_control(
			'image',
			[
				'label'       => esc_html__( 'Choose Image', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended Image Size 360 x 360 (Image must be of equal Width and Height).', 'realhomes-elementor-addon' ) . '</br>' .
				                 esc_html__( 'You can crop the image by selecting "Custom" option from &#8681; Image Size. ', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
				'exclude'   => [
					'2048x2048',
					'thumbnail',
					'medium_large',
					'modern-property-child-slider',
					'property-thumb-image',
					'property-detail-video-image',
					'partners-logo',
					'post-featured-image',
					'post-thumbnail'
				],
			]
		);

		$this->add_control(
			'rhea_acf_thumb_url',
			[
				'label'       => esc_html__( 'Thumbnail URL', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_add_form_content',
			[
				'label' => esc_html__( 'Contact Form', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_acf_source',
			[
				'label'   => esc_html__( 'Select Contact Form', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'   => esc_html__( 'Default', 'realhomes-elementor-addon' ),
					'shortcode' => esc_html__( 'Shortcode', 'realhomes-elementor-addon' ),
				)
			]
		);

		$this->add_control(
			'rhea_acf_target_shortcode',
			[
				'label'       => esc_html__( 'Shortcode For Contact Form', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Supported with Contact Form 7 and WPForms', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'condition'   => [
					'rhea_acf_source' => 'shortcode',
				],
			]
		);


		$this->add_control(
			'rhea_acf_target_email',
			[
				'label'       => esc_html__( 'Target Email ( Required )', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'The message will be sent on this email address', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'your@email.com', 'realhomes-elementor-addon' ),
				'condition'   => [
					'rhea_acf_source' => 'default',
				],

			]
		);

		$this->add_control(
			'rhea_acf_name_label',
			[
				'label'     => esc_html__( 'Name Field Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Full Name', 'realhomes-elementor-addon' ),
				'condition' => [
					'rhea_acf_source' => 'default',
				],
			]
		);

		$this->add_control(
			'rhea_acf_name_placeholder',
			[
				'label'     => esc_html__( 'Name Field Placeholder', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'rhea_acf_source' => 'default',
				],
			]
		);

		$this->add_control(
			'rhea_acf_email_label',
			[
				'label'     => esc_html__( 'Email Field Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Email', 'realhomes-elementor-addon' ),
				'condition' => [
					'rhea_acf_source' => 'default',
				],
			]
		);

		$this->add_control(
			'rhea_acf_email_placeholder',
			[
				'label'     => esc_html__( 'Email Field Placeholder', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'rhea_acf_source' => 'default',
				],
			]
		);

		$this->add_control(
			'rhea_acf_message_label',
			[
				'label'     => esc_html__( 'Message Area Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Your Message', 'realhomes-elementor-addon' ),
				'condition' => [
					'rhea_acf_source' => 'default',
				],
			]
		);

		$this->add_control(
			'rhea_acf_message_placeholder',
			[
				'label'     => esc_html__( 'Message Area Placeholder', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'rhea_acf_source' => 'default',
				],
			]
		);

		$this->add_control(
			'rhea_acf_button_text',
			[
				'label'     => esc_html__( 'Submit Button Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Submit', 'realhomes-elementor-addon' ),
				'condition' => [
					'rhea_acf_source' => 'default',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_add_contact_lists',
			[
				'label' => esc_html__( 'Contact Details', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'rhea_contact_phone_label',
			[
				'label'   => esc_html__( 'Phone Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Phone', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_contact_phone_number',
			[
				'label'   => esc_html__( 'Phone Number', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '987-654-3210', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_contact_whatsapp_label',
			[
				'label'   => esc_html__( 'WhatsApp Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'WhatsApp', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_contact_whatsapp_number',
			[
				'label'   => esc_html__( 'WhatsApp Number', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '987-654-3210', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_contact_email_label',
			[
				'label'   => esc_html__( 'Email Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Email', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_contact_email_id',
			[
				'label'   => esc_html__( 'Email ID', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'info@email.com', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_contact_office_label',
			[
				'label'   => esc_html__( 'Office Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Office', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_contact_office_address',
			[
				'label'       => esc_html__( 'Office Address', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'HTML tags ( a , b , br , div , em , strong ) can be used in Office Address', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( '3015 Grand Ave,Coconut Grove, Merrick Way,FL 12345', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_contact_socials_label',
			[
				'label'   => esc_html__( 'Socials Label', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Follow Me', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'rhea_agent_facebook',
			[
				'label'         => esc_html__( 'Facebook Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'rhea_agent_twitter',
			[
				'label'         => esc_html__( 'Twitter Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'rhea_agent_linkedin',
			[
				'label'         => esc_html__( 'LinkedIn Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'rhea_agent_instagram',
			[
				'label'         => esc_html__( 'Instagram Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'rhea_agent_pinterest',
			[
				'label'         => esc_html__( 'Pinterest Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'rhea_agent_youtube',
			[
				'label'         => esc_html__( 'Youtube Link', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_acf_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_title_typography',
				'label'    => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_acf_agent_thumbnail .rhea_acf_thumb_label h4',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_post_title_typography',
				'label'    => esc_html__( 'Post Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_acf_agent_thumbnail .rhea_acf_thumb_label span',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_form_label_typography',
				'label'    => esc_html__( 'Field Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_acf_form .rhea_acf_label,{{WRAPPER}} .rhea_acf_shortcode label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_form_fields_typography',
				'label'    => esc_html__( 'Input/Textarea Fields', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_acf_form .rhea_acf_text,
				{{WRAPPER}} .rhea_acf_shortcode input[type="text"],
				{{WRAPPER}} .rhea_acf_shortcode input[type="email"],
				{{WRAPPER}} .rhea_acf_shortcode input[type="tel"],
				{{WRAPPER}} .rhea_acf_shortcode input[type="number"],
				{{WRAPPER}} .rhea_acf_shortcode input[type="password"],
				{{WRAPPER}} .rhea_acf_shortcode textarea,
				{{WRAPPER}} .rhea_acf_form .rhea_acf_textarea',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_form_gdpr_typography',
				'label'    => esc_html__( 'GDPR label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_inspiry_gdpr .gdpr-checkbox-label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_form_gdpr_text_typography',
				'label'    => esc_html__( 'GDPR Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rh_inspiry_gdpr label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_form_submit_typography',
				'label'    => esc_html__( 'Submit Button', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_acf_form .rhea_acf_submit,{{WRAPPER}} .rhea_acf_shortcode .input[type="submit"],{{WRAPPER}} .rhea_acf_shortcode button',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_contact_labels_typography',
				'label'    => esc_html__( 'Contact Labels', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_acf_contact .rhea_acf_list_label',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'agent_contact_text_typography',
				'label'    => esc_html__( 'Contact Text', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_acf_contact a.rhea_acf_list_text,{{WRAPPER}} .rhea_acf_contact .rhea_acf_list_text',
			]
		);

		$this->add_responsive_control(
			'agent_contact_social_icons_size',
			[
				'label'           => esc_html__( 'Social Icons Size (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_socials li a i' => 'font-size: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_acf_settings',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_thumbnail_column',
			[
				'label'        => esc_html__( 'Show Thumbnail Column', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_contact_list_column',
			[
				'label'        => esc_html__( 'Show Contact List Column', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_contact_list_icons',
			[
				'label'        => esc_html__( 'Show Contact List Icons', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_acf_spaces_sizes',
			[
				'label' => esc_html__( 'Spaces & Sizes', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'rhea_agent_thumb_padding',
			[
				'label'      => esc_html__( 'Title/Subtitle Area Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_acf_agent_thumbnail .rhea_acf_thumb_label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'agent_title_margin_bottom',
			[
				'label'           => esc_html__( 'Title Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_agent_thumbnail .rhea_acf_thumb_label h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'thumbnail-max-height',
			[
				'label'           => esc_html__( 'Thumbnail Max Height (px)', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'Note: max height will not be reduced from image min ratio', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_thumb_wrapper' => 'max-height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'agent_form_label_margin_bottom',
			[
				'label'           => esc_html__( 'Field Label Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_label'        => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rh_inspiry_gdpr .gdpr-checkbox-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode label'             => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'agent_form_input_margin_bottom',
			[
				'label'           => esc_html__( 'Input Field Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_text'              => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_textarea'          => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_form .rh_inspiry_gdpr'            => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_form .inspiry-google-recaptcha'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="text"]'     => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="email"]'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="tel"]'      => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="number"]'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="password"]' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode textarea'               => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'agent_form_input_height',
			[
				'label'           => esc_html__( 'Input Field Height (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_text'              => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="text"]'     => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="email"]'    => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="tel"]'      => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="number"]'   => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="password"]' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'agent_form_textarea_height',
			[
				'label'           => esc_html__( 'Textarea Field Height (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_textarea' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode textarea'      => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_submit_button_padding',
			[
				'label'      => esc_html__( 'Submit Button Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_submit'          => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode button'               => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'agent_submit_btn_size',
			[
				'label'           => esc_html__( 'Submit Button Max Width (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 1500,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_shortcode button'               => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="submit"]' => 'max-width: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->add_responsive_control(
			'agent_contact_labels_bottom',
			[
				'label'           => esc_html__( 'Contact List Labels Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_list_label' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'agent_contact_item_bottom',
			[
				'label'           => esc_html__( 'Contact List Item Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_contact' => 'margin-bottom: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'rhea_social_links_margin',
			[
				'label'      => esc_html__( 'Social Link Margin', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_socials li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'agent_contact_icon_box_size',
			[
				'label'           => esc_html__( 'Contact Icon Box Size', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'agent_contact_icon_size',
			[
				'label'           => esc_html__( 'Contact Icon Size', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_icon' => 'font-size: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_acf_colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'agent_title_area_bg_color',
			[
				'label'     => esc_html__( 'Title Area Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_agent_thumbnail .rhea_acf_thumb_label' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_title_color',
			[
				'label'     => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_agent_thumbnail .rhea_acf_thumb_label h4' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_post_title_color',
			[
				'label'     => esc_html__( 'Post Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_agent_thumbnail .rhea_acf_thumb_label span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_form_labels_color',
			[
				'label'     => esc_html__( 'Contact Form Labels', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_label'                       => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_form .rh_inspiry_gdpr .gdpr-checkbox-label' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode label'                            => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_form_fields_bg_color',
			[
				'label'     => esc_html__( 'Fields Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_text'              => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_textarea'          => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="text"]'     => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="email"]'    => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="tel"]'      => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="number"]'   => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="password"]' => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode textarea'               => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_form_fields_border_color',
			[
				'label'     => esc_html__( 'Fields Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_text'              => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_textarea'          => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="text"]'     => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="email"]'    => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="tel"]'      => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="number"]'   => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="password"]' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode textarea'               => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_form_gdpr_color',
			[
				'label'     => esc_html__( 'GDPR Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_form .rh_inspiry_gdpr label' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_form .rh_inspiry_gdpr input' => 'box-shadow: 0px 0px 5px 1px {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_submit_bg_color',
			[
				'label'     => esc_html__( 'Submit Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_submit'          => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode button'               => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="submit"]' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_submit_bg_color_hover',
			[
				'label'     => esc_html__( 'Submit Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_submit:hover'          => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode button:hover'               => 'background: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="submit"]:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_submit_text_color',
			[
				'label'     => esc_html__( 'Submit Button Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_submit'          => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode button'               => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="submit"]' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_submit_text_color_hover',
			[
				'label'     => esc_html__( 'Submit Button Text Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_form .rhea_acf_submit:hover'          => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode button:hover'               => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_shortcode input[type="submit"]:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_contact_list_bg_color',
			[
				'label'     => esc_html__( 'Contact List Icon Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_icon' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_contact_list_border_color',
			[
				'label'     => esc_html__( 'Contact List Icon Border Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_icon' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_contact_list_color',
			[
				'label'     => esc_html__( 'Contact List Icon Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_contact_label_color',
			[
				'label'     => esc_html__( 'Contact List Label Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_list_label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_contact_text_color',
			[
				'label'     => esc_html__( 'Contact List Text Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_contact a.rhea_acf_list_text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_list_text'  => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_contact_text_color_hover',
			[
				'label'     => esc_html__( 'Contact List Text Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_contact a.rhea_acf_list_text:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'agent_social_icons_color',
			[
				'label'     => esc_html__( 'Social Icons Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_socials li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'agent_social_icons_color_hover',
			[
				'label'     => esc_html__( 'Social Icons Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_acf_contact .rhea_acf_socials li a:hover' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$show_thumbnail_column = '';
		if ( ! 'yes' == $settings['show_thumbnail_column'] ) {
			$show_thumbnail_column = ' acf_no_thumbnail_column ';
		}
		$show_contact_list_column = '';
		if ( ! 'yes' == $settings['show_contact_list_column'] ) {
			$show_contact_list_column = ' acf_no_contact_list_column ';
		}
		$show_contact_list_icons = '';
		if ( ! 'yes' == $settings['show_contact_list_icons'] ) {
			$show_contact_list_icons = ' acf_mo_contact_list_icons ';
		}

		$agent_target            = ' ';
		$agent_nofollow          = ' ';
		$agent_custom_attributes = ' ';
		if ( ! empty( $settings['rhea_acf_thumb_url']['url'] ) && ! empty( $settings['rhea_acf_thumb_url'] ) ) {
			$agent_target            = $settings['rhea_acf_thumb_url']['is_external'] ? ' target="_blank"' : '';
			$agent_nofollow          = $settings['rhea_acf_thumb_url']['nofollow'] ? ' rel="nofollow"' : '';
			$agent_custom_attributes = $settings['rhea_acf_thumb_url']['custom_attributes'] ? $settings['rhea_acf_thumb_url']['custom_attributes'] : ' ';
		}

		?>

        <div class="rhea_acf_wrapper <?php echo esc_attr( $show_thumbnail_column . $show_contact_list_column . $show_contact_list_icons ); ?>">
            <div class="rhea_acf_box">

                <div class="rhea_thumb_and_form">
                    <div class="rhea_thumb_and_form_inner">
						<?php
						if ( 'yes' == $settings['show_thumbnail_column'] ) {
							?>
                            <div class="rhea_acf_thumb_wrapper">
								<?php
								if ( ! empty( $settings['rhea_acf_thumb_url']['url'] ) ) {
								?>
                                <a href="<?php echo esc_url( $settings['rhea_acf_thumb_url']['url'] ); ?>"
                                   class="rhea_acf_agent_thumbnail " <?php echo esc_attr( $agent_target ) . ' ' . esc_attr( $agent_nofollow ) . ' ' . esc_attr( $agent_custom_attributes ); ?>>
									<?php
									} else {
										echo '<div class="rhea_acf_agent_thumbnail">';

									}
									if ( ! empty( $settings['rhea_acf_title'] ) ||
									     ! empty( $settings['rhea_acf_sub_title'] ) ) {

										?>
                                        <div class="rhea_acf_thumb_label">
											<?php
											if ( ! empty( $settings['rhea_acf_title'] ) ) {
												?>
                                                <h4><?php echo esc_html( $settings['rhea_acf_title'] ) ?></h4>
												<?php
											}
											if ( ! empty( $settings['rhea_acf_sub_title'] ) ) {
												?>
                                                <span><?php echo esc_html( $settings['rhea_acf_sub_title'] ) ?></span>
												<?php
											}
											?>
                                        </div>
										<?php
									}

									if ( ! empty( $settings['image']['id'] ) ) {
										?>
                                        <div class="rhea_acf_thumb_box"
                                             style="background-image: url(<?php echo esc_url( \Elementor\Group_Control_Image_Size::get_attachment_image_src( $settings['image']['id'], 'thumbnail', $settings ) ); ?>)"></div>
										<?php
									}
									if ( ! empty( esc_url( $settings['rhea_acf_thumb_url']['url'] ) ) ) {
									?>
                                </a>
							<?php
							} else {
								echo '</div>';
							}
							?>
                            </div>

							<?php
						}
						?>
                        <div class="rhea_acf_form">

							<?php
							if ( 'shortcode' == $settings['rhea_acf_source'] ) {
								?>
                                <div class="rhea_acf_shortcode"><?php echo do_shortcode( shortcode_unautop( $settings['rhea_acf_target_shortcode'] ) ); ?></div>
								<?php

							} else {
								?>
                                <form class="rhea_acf_form_box" id="acf_<?php echo esc_attr( $this->get_id() ); ?>"
                                      method="post"
                                      action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
									<?php
									if ( ! empty( $settings['rhea_acf_name_label'] ) ) {
										?>
                                        <label class="rhea_acf_label"
                                               for="acf_name_<?php echo esc_attr( $this->get_id() ); ?>"><?php echo esc_html( $settings['rhea_acf_name_label'] ); ?></label>
										<?php
									}
									?>
                                    <input id="acf_name_<?php echo esc_attr( $this->get_id() ); ?>" class="rhea_acf_text required" type="text" name="name"
                                           placeholder="<?php echo esc_attr( $settings['rhea_acf_name_placeholder'] ); ?>">
									<?php
									if ( ! empty( $settings['rhea_acf_email_label'] ) ) {
										?>
                                        <label class="rhea_acf_label"
                                               for="acf_email_<?php echo esc_attr( $this->get_id() ); ?>"><?php echo esc_html( $settings['rhea_acf_email_label'] ); ?></label>
										<?php
									}
									?>
                                    <input id="acf_email_<?php echo esc_attr( $this->get_id() ); ?>" class="rhea_acf_text email required" type="email" name="email"
                                           placeholder="<?php echo esc_attr( $settings['rhea_acf_email_placeholder'] ) ?>">

									<?php
									if ( ! empty( $settings['rhea_acf_message_label'] ) ) {
										?>
                                        <label class="rhea_acf_label"
                                               for="acf_message_<?php echo esc_attr( $this->get_id() ); ?>"><?php echo esc_html( $settings['rhea_acf_message_label'] ); ?></label>
										<?php
									}
									?>
                                    <textarea id="acf_message_<?php echo esc_attr( $this->get_id() ); ?>" class="rhea_acf_textarea required" rows="8" name="message"
                                              placeholder="<?php echo esc_attr( $settings['rhea_acf_message_placeholder'] ) ?>"></textarea>

									<?php
									$rhea_acf_button_text = esc_html__( 'Submit', 'realhomes-elementor-addon' );
									if ( ! empty( $settings['rhea_acf_button_text'] ) ) {
										$rhea_acf_button_text = $settings['rhea_acf_button_text'];
									}
									?>

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

                                    <input type="hidden" name="nonce"
                                           value="<?php echo esc_attr( wp_create_nonce( 'agent_message_nonce' ) ); ?>"/>
                                    <input type="hidden" name="target"
                                           value="<?php echo esc_attr( antispambot( $settings['rhea_acf_target_email'] ) ); ?>">

									<?php
									if ( ! empty( $settings['rhea_acf_title'] ) ) {
										?>
                                        <input type="hidden" name="agent-name"
                                               value="<?php echo esc_attr( $settings['rhea_acf_title'] ); ?>">
										<?php
									}
									?>
                                    <input type="hidden" name="action" value="rhea_send_message_to_agent"/>

                                    <div class="rhea_acf_submit_wrapper">
                                        <input id="acf_submit_<?php echo esc_attr( $this->get_id() ); ?>"
                                               class="rhea_acf_submit" type="submit" name="submit"
                                               value="<?php echo esc_attr( $rhea_acf_button_text ); ?>">


                                    </div>

                                    <div class="rhea_agent_form__row">
                                        <div class="rhea-ajax-loader">
                                            <span class="rhea_loader_box"><?php rhea_safe_include_svg( 'icons/loader.svg' ); ?></span>
                                        </div>
                                        <div class="rhea-error-container"></div>
                                        <div class="rhea-message-container"></div>
                                    </div>
                                </form>

								<?php
							}

							?>

                        </div>
                    </div>
                </div>

				<?php if ( 'yes' == $settings['show_contact_list_column'] ) { ?>
                    <div class="rhea_acf_inner rhea_acf_agent_contacts">
                        <div class="rhea_acf_contacts_inner">

							<?php

							if ( ! empty( $settings['rhea_contact_phone_number'] ) ) {
								?>
                                <div class="rhea_acf_contact">
                                    <i class="rhea_acf_icon fas fa-phone-alt"></i>
                                    <div class="rhea_acf_contact_detail">
										<?php
										if ( ! empty( $settings['rhea_contact_phone_label'] ) ) {
											?>
                                            <span class="rhea_acf_list_label"><?php echo esc_html( $settings['rhea_contact_phone_label'] ) ?></span>
											<?php
										}
										?>
                                        <a href="tel:<?php echo esc_attr( $settings['rhea_contact_phone_number'] ) ?>"
                                           class="rhea_acf_list_text"><?php echo esc_html( $settings['rhea_contact_phone_number'] ) ?></a>
                                    </div>
                                </div>
								<?php
							}

							if ( ! empty( $settings['rhea_contact_whatsapp_number'] ) ) {
								?>
                                <div class="rhea_acf_contact">
                                    <i class="rhea_acf_icon fab fa-whatsapp"></i>
                                    <div class="rhea_acf_contact_detail">
										<?php
										if ( ! empty( $settings['rhea_contact_whatsapp_label'] ) ) {
											?>
                                            <span class="rhea_acf_list_label"><?php echo esc_html( $settings['rhea_contact_whatsapp_label'] ) ?></span>
											<?php
										}
										?>
                                        <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr( $settings['rhea_contact_whatsapp_number'] ) ?>"
                                           class="rhea_acf_list_text"><?php echo esc_html( $settings['rhea_contact_whatsapp_number'] ) ?></a>
                                    </div>
                                </div>
								<?php
							}

							if ( ! empty( $settings['rhea_contact_email_id'] ) ) {
								?>
                                <div class="rhea_acf_contact">
                                    <i class="rhea_acf_icon fas fa-envelope"></i>
                                    <div class="rhea_acf_contact_detail">
										<?php
										if ( ! empty( $settings['rhea_contact_email_label'] ) ) {
											?>
                                            <span class="rhea_acf_list_label"><?php echo $settings['rhea_contact_email_label'] ?></span>
											<?php
										}
										?>
                                        <a href="mailto:<?php echo esc_attr( antispambot( $settings['rhea_contact_email_id'] ) ) ?>"
                                           class="rhea_acf_list_text"><?php echo esc_attr( antispambot( $settings['rhea_contact_email_id'] ) ) ?></a>
                                    </div>
                                </div>
								<?php
							}
							if ( ! empty( $settings['rhea_contact_office_address'] ) ) {
								?>
                                <div class="rhea_acf_contact">
                                    <i class="rhea_acf_icon fas fa-map-marker-alt"></i>
                                    <div class="rhea_acf_contact_detail">
										<?php
										if ( ! empty( $settings['rhea_contact_office_label'] ) ) {
											?>
                                            <span class="rhea_acf_list_label"><?php echo esc_html( $settings['rhea_contact_office_label'] ) ?></span>
											<?php
										}
										?>
                                        <span class="rhea_acf_list_text"><?php echo wp_kses( $settings['rhea_contact_office_address'], inspiry_allowed_html() ); ?></span>
                                    </div>
                                </div>
								<?php
							}
							?>
                            <div class="rhea_acf_contact">
                                <i class="rhea_acf_icon fas fa-user-circle"></i>
                                <div class="rhea_acf_contact_detail">
									<?php
									if ( $settings['rhea_contact_socials_label'] ) {
										?>
                                        <span class="rhea_acf_list_label"><?php echo esc_html( $settings['rhea_contact_socials_label'] ) ?></span>
										<?php
									}
									if ( $settings['rhea_agent_facebook']['url'] ||
									     $settings['rhea_agent_twitter']['url'] ||
									     $settings['rhea_agent_linkedin']['url'] ||
									     $settings['rhea_agent_instagram']['url'] ||
									     $settings['rhea_agent_pinterest']['url'] ||
									     $settings['rhea_agent_youtube']['url']

									) {
										?>
                                        <ul class="rhea_acf_socials">
											<?php
											if ( $settings['rhea_agent_facebook']['url'] ) {
												$agent_fb_target            = $settings['rhea_agent_facebook']['is_external'] ? ' target="_blank"' : '';
												$agent_fb_nofollow          = $settings['rhea_agent_facebook']['nofollow'] ? ' rel="nofollow"' : '';
												$agent_fb_custom_attributes = $settings['rhea_agent_facebook']['custom_attributes'] ? $settings['rhea_agent_facebook']['custom_attributes'] : ' ';
												?>
                                                <li class="rhea_item_facebook">
                                                    <a href="<?php echo esc_url( $settings['rhea_agent_facebook']['url'] ); ?>"
														<?php echo esc_attr( $agent_fb_target ) . ' ' . esc_attr( $agent_fb_nofollow ) . ' ' . esc_attr( $agent_fb_custom_attributes ); ?>>
                                                        <i class="fab fa-facebook fa-lg"></i>
                                                    </a>
                                                </li>
												<?php
											}
											if ( $settings['rhea_agent_twitter']['url'] ) {
												$agent_twitter_target            = $settings['rhea_agent_twitter']['is_external'] ? ' target="_blank"' : '';
												$agent_twitter_nofollow          = $settings['rhea_agent_twitter']['nofollow'] ? ' rel="nofollow"' : '';
												$agent_twitter_custom_attributes = $settings['rhea_agent_twitter']['custom_attributes'] ? $settings['rhea_agent_twitter']['custom_attributes'] : ' ';
												?>
                                                <li class="rhea_item_twitter">
                                                    <a href="<?php echo esc_url( $settings['rhea_agent_twitter']['url'] ); ?>"
														<?php echo esc_attr( $agent_twitter_target ) . ' ' . esc_attr( $agent_twitter_nofollow ) . ' ' . esc_attr( $agent_twitter_custom_attributes ); ?>>
                                                        <i class="fab fa-twitter fa-lg"></i>
                                                    </a>
                                                </li>
												<?php
											}
											if ( $settings['rhea_agent_linkedin']['url'] ) {
												$agent_in_target            = $settings['rhea_agent_linkedin']['is_external'] ? ' target="_blank"' : '';
												$agent_in_nofollow          = $settings['rhea_agent_linkedin']['nofollow'] ? ' rel="nofollow"' : '';
												$agent_in_custom_attributes = $settings['rhea_agent_linkedin']['custom_attributes'] ? $settings['rhea_agent_linkedin']['custom_attributes'] : ' ';
												?>
                                                <li class="rhea_item_linkedin">
                                                    <a href="<?php echo esc_url( $settings['rhea_agent_linkedin']['url'] ); ?>"
														<?php echo esc_attr( $agent_in_target ) . ' ' . esc_attr( $agent_in_nofollow ) . ' ' . esc_attr( $agent_in_custom_attributes ); ?>>
                                                        <i class="fab fa-linkedin fa-lg"></i>
                                                    </a>
                                                </li>
												<?php
											}
											if ( $settings['rhea_agent_instagram']['url'] ) {
												$agent_insta_target            = $settings['rhea_agent_instagram']['is_external'] ? ' target="_blank"' : '';
												$agent_insta_nofollow          = $settings['rhea_agent_instagram']['nofollow'] ? ' rel="nofollow"' : '';
												$agent_insta_custom_attributes = $settings['rhea_agent_instagram']['custom_attributes'] ? $settings['rhea_agent_instagram']['custom_attributes'] : ' ';
												?>
                                                <li class="rhea_item_instagram">
                                                    <a href="<?php echo esc_url( $settings['rhea_agent_instagram']['url'] ); ?>"
														<?php echo esc_attr( $agent_insta_target ) . ' ' . esc_attr( $agent_insta_nofollow ) . ' ' . esc_attr( $agent_insta_custom_attributes ); ?>>
                                                        <i class="fab fa-instagram fa-lg"></i>
                                                    </a>
                                                </li>
												<?php
											}
											if ( $settings['rhea_agent_pinterest']['url'] ) {
												$agent_pi_target            = $settings['rhea_agent_pinterest']['is_external'] ? ' target="_blank"' : '';
												$agent_pi_nofollow          = $settings['rhea_agent_pinterest']['nofollow'] ? ' rel="nofollow"' : '';
												$agent_pi_custom_attributes = $settings['rhea_agent_pinterest']['custom_attributes'] ? $settings['rhea_agent_pinterest']['custom_attributes'] : ' ';
												?>
                                                <li class="rhea_item_pinterest">
                                                    <a href="<?php echo esc_url( $settings['rhea_agent_pinterest']['url'] ); ?>"
														<?php echo esc_attr( $agent_pi_target ) . ' ' . esc_attr( $agent_pi_nofollow ) . ' ' . esc_attr( $agent_pi_custom_attributes ); ?>>
                                                        <i class="fab fa-pinterest fa-lg"></i>
                                                    </a>
                                                </li>
												<?php
											}
											if ( $settings['rhea_agent_youtube']['url'] ) {
												$agent_yt_target            = $settings['rhea_agent_youtube']['is_external'] ? ' target="_blank"' : '';
												$agent_yt_nofollow          = $settings['rhea_agent_youtube']['nofollow'] ? ' rel="nofollow"' : '';
												$agent_yt_custom_attributes = $settings['rhea_agent_youtube']['custom_attributes'] ? $settings['rhea_agent_youtube']['custom_attributes'] : ' ';
												?>
                                                <li class="rhea_item_youtube">
                                                    <a href="<?php echo esc_url( $settings['rhea_agent_youtube']['url'] ); ?>"
														<?php echo esc_attr( $agent_yt_target ) . ' ' . esc_attr( $agent_yt_nofollow ) . ' ' . esc_attr( $agent_yt_custom_attributes ); ?>>
                                                        <i class="fab fa-youtube fa-lg"></i>
                                                    </a>
                                                </li>
												<?php
											}
											?>
                                        </ul>
										<?php
									}
									?>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php } ?>
            </div>
        </div>
        <script type="application/javascript">
            jQuery(document).on('ready', function () {
                rheaSubmitContactForm("#acf_<?php echo esc_attr( $this->get_id() );?>", "#acf_submit_<?php echo esc_attr( $this->get_id() );?>");
            });
        </script>
		<?php

	}
}