<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Agent_Contact_Form_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_agent_contact_form_to_translate'
		] );
	}

	public function inspiry_agent_contact_form_to_translate( $widgets ) {

		$widgets['rhea-agent-contact-form-widget'] = [
			'conditions' => [ 'widgetType' => 'rhea-agent-contact-form-widget' ],
			'fields'     => [
				[
					'field'       => 'rhea_acf_title',
					'type'        => esc_html__( 'Agent Contact Form: Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_acf_sub_title',
					'type'        => esc_html__( 'Agent Contact Form: Sub Title', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_acf_thumb_url',
					'type'        => esc_html__( 'Agent Contact Form: Thumbnail URL', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINK'
				],
				[
					'field'       => 'rhea_acf_name_label',
					'type'        => esc_html__( 'Agent Contact Form: Name Field Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_acf_name_placeholder',
					'type'        => esc_html__( 'Agent Contact Form: Name Field Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_acf_email_label',
					'type'        => esc_html__( 'Agent Contact Form: Email Field Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_acf_email_placeholder',
					'type'        => esc_html__( 'Agent Contact Form: Email Field Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_acf_message_label',
					'type'        => esc_html__( 'Agent Contact Form: Message Field Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_acf_message_placeholder',
					'type'        => esc_html__( 'Agent Contact Form: Message Field Placeholder', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_acf_button_text',
					'type'        => esc_html__( 'Agent Contact Form: Submit Button Text', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_contact_phone_label',
					'type'        => esc_html__( 'Agent Contact Form: Phone Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_contact_whatsapp_label',
					'type'        => esc_html__( 'Agent Contact Form: WhatsApp Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_contact_email_label',
					'type'        => esc_html__( 'Agent Contact Form: Email Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_contact_office_label',
					'type'        => esc_html__( 'Agent Contact Form: Office Label', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_contact_office_address',
					'type'        => esc_html__( 'Agent Contact Form: Office Address', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'rhea_contact_socials_label',
					'type'        => esc_html__( 'Agent Contact Form: Social Labels', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],


			],
		];

		return $widgets;

	}
}

new RHEA_Agent_Contact_Form_WPML_Translate();