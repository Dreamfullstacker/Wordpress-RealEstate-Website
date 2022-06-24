<?php


if ( ! class_exists( 'RECRM_Settings' ) ):

	/**
	 * Plugins's settings
	 */
	class RECRM_Settings {

		private $settings_api;

		public function __construct() {
			$this->settings_api = new RECRM_Settings_API;

			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		function admin_init() {

			//set the settings
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );

			//initialize settings
			$this->settings_api->admin_init();
		}

		function admin_menu() {

			add_submenu_page(
				'recrm',
				esc_html__( 'Real Estate CRM Settings', 'real-estate-crm' ),
				esc_html__( 'Settings', 'real-estate-crm' ),
				'manage_options',
				'recrm-settings',
				array( $this, 'recrm_setting_page' )
			);

		}

		function get_settings_sections() {
			$sections = array(
				array(
					'id'    => 'recrm_settings',
					'title' => esc_html__( 'Real Estate CRM Settings', 'real-estate-crm' ),
					'desc' => recrm_feedback_request_message(),
				)
			);

			return $sections;
		}

		function get_settings_fields() {

			$recrm_post_types = array( 0 => __( 'None', 'real-estate-crm' ) );
			$post_types       = get_post_types();

			if ( count( $post_types ) > 0 ) {
				foreach ( $post_types as $post ) {
					$recrm_post_types[ $post ] = $post;
				}
			}

			$settings_fields = array(
				'recrm_settings' => array(
					array(
						'name'              => 'recrm_contact_status_settings',
						'label'             => esc_html__( 'Contact Statuses', 'real-estate-crm' ),
						'desc'              => esc_html__( 'Provide comma separated values e.g (Lead, Customer). First value will be considered default for contact status.', 'real-estate-crm' ),
						'type'              => 'text',
						'default'           => esc_html__( 'Lead, Customer', 'real-estate-crm' ),
						'sanitize_callback' => ''
					),
					array(
						'name'              => 'recrm_contact_prefixes_settings',
						'label'             => esc_html__( 'Contact Prefixes', 'real-estate-crm' ),
						'desc'              => esc_html__( 'Provide comma separated values e.g (Mr, Mrs, Ms, Miss, Dr, Prof, Mr & Mrs).', 'real-estate-crm' ),
						'type'              => 'text',
						'default'           => esc_html__( 'Mr, Mrs, Ms, Miss, Dr, Prof, Mr & Mrs', 'real-estate-crm' ),
						'sanitize_callback' => ''
					),

					array(
						'name'              => 'recrm_contact_source_settings',
						'label'             => esc_html__( 'Source', 'real-estate-crm' ),
						'desc'              => esc_html__( 'Provide comma separated values e.g (Website, Word of Mouth, Newspaper, Friend). First value will be considered default for contact prefix.', 'real-estate-crm' ),
						'type'              => 'textarea',
						'default'           => esc_html__( 'Website, Word of Mouth, Newspaper, Friend' ),
						'sanitize_callback' => ''
					),


					array(
						'name'              => 'recrm_enquiry_status_settings',
						'label'             => esc_html__( 'Enquiry Status', 'real-estate-crm' ),
						'desc'              => esc_html__( 'Provide comma separated values e.g (Open, Close). First value will be considered default for enquiry status.', 'real-estate-crm' ),
						'type'              => 'textarea',
						'default'           => esc_html__( 'Open, Close' ),
						'sanitize_callback' => ''
					),

					array(
						'name'              => 'recrm_enquiry_negotiator_settings',
						'label'             => esc_html__( 'Enquiry Negotiator Source', 'real-estate-crm' ),
						'desc'              => esc_html__( 'Select Negotiator Type', 'real-estate-crm' ),
						'type'              => 'radio',
						'default'           => 'user',
						'options'           => array(
							'cpt'  => esc_html__( 'Custom Post Types', 'real-estate-crm' ),
							'user' => esc_html__( 'Users', 'real-estate-crm' ),
						),
						'sanitize_callback' => ''
					),

					array(
						'name'              => 'recrm_enquiry_negotiator_cpt_settings',
						'label'             => esc_html__( 'Select Custom Post Type For Negotiator Source', 'real-estate-crm' ),
						'desc'              => esc_html__( 'Select Agent Custom Post Type', 'real-estate-crm' ),
						'type'              => 'select',
						'options'           => $recrm_post_types,
						'sanitize_callback' => ''
					),


				)
			);


			return $settings_fields;
		}

		function recrm_setting_page() {
			echo '<div class="wrap">';

			//$this->settings_api->show_navigation();
			$this->settings_api->show_forms();

			echo '</div>';
		}


		function get_pages() {
			/**
			 * Get all the pages
			 *
			 * @return array page names with key value pairs
			 */
			$pages         = get_pages();
			$pages_options = array();
			if ( $pages ) {
				foreach ( $pages as $page ) {
					$pages_options[ $page->ID ] = $page->post_title;
				}
			}

			return $pages_options;
		}

	}

	new RECRM_Settings();
endif;