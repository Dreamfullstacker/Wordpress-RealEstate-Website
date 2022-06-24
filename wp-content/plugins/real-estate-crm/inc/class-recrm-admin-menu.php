<?php
if ( ! class_exists( 'RECRM_admin_menu' ) ) {

	/**
	 * Class for Admin Menu of plugin
	 */
	class RECRM_admin_menu {

		public function __construct() {
			add_action( 'admin_menu', array( $this, 'real_estate_menu' ) );
			add_action( 'admin_menu', array( $this, 'enquiry_admin_submenu' ) );
			add_action( 'admin_menu', array( $this, 'contact_admin_submenu' ) );
			add_action( 'admin_menu', array( $this, 'add_contact_admin_submenu' ) );
			add_action( 'admin_menu', array( $this, 're_arrange_menu' ) );
		}

		public function real_estate_menu() {

			$page_title = apply_filters('recrm_admin_menu_page_title',esc_html__('Real Estate CRM','real-estate-crm'));
			$menu_label = apply_filters('recrm_admin_menu_menu_label',esc_html__('Real Estate CRM','real-estate-crm'));

			add_menu_page(
				$page_title,
				$menu_label,
				'edit_posts',
				'recrm',
				'',
				RECRM_PLUGIN_URL . '/images/svg/recrm-menu-icon.svg',
				'8'
			);
		}

		public function contact_admin_submenu() {

			$page_title = apply_filters('recrm_admin_menu_contact_page_title',esc_html__('Contacts','real-estate-crm'));
			$menu_label = apply_filters('recrm_admin_menu_contact_menu_label',esc_html__('Contacts','real-estate-crm'));

			add_submenu_page(
				'recrm',
				$page_title,
				$menu_label,
				'edit_posts',
				'edit.php?post_type=contact',
				''
			);
		}


		public function add_contact_admin_submenu() {

			$page_title = apply_filters('recrm_admin_menu_add_contact_page_title',esc_html__('Add Contact','real-estate-crm'));
			$menu_label = apply_filters('recrm_admin_menu_add_contact_menu_label',esc_html__('Add Contact','real-estate-crm'));

			add_submenu_page(
				'recrm',
				$page_title,
				$menu_label,
				'edit_posts',
				'post-new.php?post_type=contact',
				''
			);
		}


		public function enquiry_admin_submenu() {

			$page_title = apply_filters('recrm_admin_menu_enquiry_page_title',esc_html__('Enquiries','real-estate-crm'));
			$menu_label = apply_filters('recrm_admin_menu_enquiry_menu_label',esc_html__('Enquiries','real-estate-crm'));

			add_submenu_page(
				'recrm',
				$page_title,
				$menu_label,
				'edit_posts',
				'edit.php?post_type=enquiry'
			);
		}

		public function re_arrange_menu() {
			global $submenu;
			unset( $submenu['recrm'][0] );
		}

	}

	new RECRM_admin_menu();
}
