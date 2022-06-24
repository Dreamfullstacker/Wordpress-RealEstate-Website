<?php
if ( ! class_exists( 'RECRM_post_types' ) ) {

	/**
	 * Add contact/enquiry custom post type and contact-tags custom taxonomy
	 */
	class RECRM_post_types {

		public function __construct() {
			add_action( 'init', array( $this, 'contact_post_type' ) );
			add_action( 'init', array( $this, 'contact_tag_taxonomy' ) );
			add_action( 'init', array( $this, 'enquiry_post_type' ) );
		}

		public function contact_post_type() {

			$labels = array(
				'name'                  => _x( 'Contacts', 'Post Type General Name', 'real-estate-crm' ),
				'singular_name'         => _x( 'Contact', 'Post Type Singular Name', 'real-estate-crm' ),
				'menu_name'             => __( 'Contacts', 'real-estate-crm' ),
				'name_admin_bar'        => __( 'Contact', 'real-estate-crm' ),
				'archives'              => __( 'Contact Archives', 'real-estate-crm' ),
				'attributes'            => __( 'Contact Attributes', 'real-estate-crm' ),
				'parent_item_colon'     => __( 'Parent Contact:', 'real-estate-crm' ),
				'all_items'             => __( 'All Contacts', 'real-estate-crm' ),
				'add_new_item'          => __( 'Add New Contact', 'real-estate-crm' ),
				'add_new'               => __( 'Add New', 'real-estate-crm' ),
				'new_item'              => __( 'New Contact', 'real-estate-crm' ),
				'edit_item'             => __( 'Edit Contact', 'real-estate-crm' ),
				'update_item'           => __( 'Update Contact', 'real-estate-crm' ),
				'view_item'             => __( 'View Contact', 'real-estate-crm' ),
				'view_items'            => __( 'View ContactS', 'real-estate-crm' ),
				'search_items'          => __( 'Search Contact', 'real-estate-crm' ),
				'not_found'             => __( 'Not found', 'real-estate-crm' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'real-estate-crm' ),
				'featured_image'        => __( 'Featured Image', 'real-estate-crm' ),
				'set_featured_image'    => __( 'Set featured image', 'real-estate-crm' ),
				'remove_featured_image' => __( 'Remove featured image', 'real-estate-crm' ),
				'use_featured_image'    => __( 'Use as featured image', 'real-estate-crm' ),
				'insert_into_item'      => __( 'Insert into contact', 'real-estate-crm' ),
				'uploaded_to_this_item' => __( 'Uploaded to this contact', 'real-estate-crm' ),
				'items_list'            => __( 'Contacts list', 'real-estate-crm' ),
				'items_list_navigation' => __( 'Contacts list navigation', 'real-estate-crm' ),
				'filter_items_list'     => __( 'Filter contacts list', 'real-estate-crm' ),
			);

			$args   = array(
				'label'               => __( 'Contact', 'real-estate-crm' ),
				'description'         => __( 'Real Estate Contacts.', 'real-estate-crm' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'thumbnail' ),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-groups',
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'can_export'          => false,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => false,
				'capability_type'     => 'post',
			);

			$args = apply_filters( 'recrm_contact_post_type_args', $args );

			register_post_type( 'contact', $args );

		}

		public function contact_tag_taxonomy() {

			$labels = array(
				'name'              => _x( 'Contact Tags', 'taxonomy general name', 'real-estate-crm' ),
				'singular_name'     => _x( 'Contact Tag', 'taxonomy singular name', 'real-estate-crm' ),
				'search_items'      => __( 'Search Contact Tags', 'real-estate-crm' ),
				'all_items'         => __( 'All Contact Tags', 'real-estate-crm' ),
				'parent_item'       => __( 'Parent Contact Tag', 'real-estate-crm' ),
				'parent_item_colon' => __( 'Parent Contact Tag:', 'real-estate-crm' ),
				'edit_item'         => __( 'Edit Contact Tag', 'real-estate-crm' ),
				'update_item'       => __( 'Update Contact Tag', 'real-estate-crm' ),
				'add_new_item'      => __( 'Add New Contact Tag', 'real-estate-crm' ),
				'new_item_name'     => __( 'New Contact Tag Name', 'real-estate-crm' ),
				'menu_name'         => __( 'Tags', 'real-estate-crm' ),
			);

			$args = array(
				'hierarchical' => true,
				'labels'       => $labels,
				'show_ui'      => true,
				'show_in_menu' => false,
				'query_var'    => true,
				'rewrite'      => array( 'slug' => 'tags' ),
			);

			$args = apply_filters( 'recrm_contact_tag_taxonomy_args', $args );

			register_taxonomy( 'contact-tags', array( 'contact' ), $args );
		}


		public function enquiry_post_type() {

			$labels = array(
				'name'                  => _x( 'Enquiries', 'Post Type General Name', 'real-estate-crm' ),
				'singular_name'         => _x( 'Enquiry', 'Post Type Singular Name', 'real-estate-crm' ),
				'menu_name'             => __( 'Enquiries', 'real-estate-crm' ),
				'name_admin_bar'        => __( 'Enquiry', 'real-estate-crm' ),
				'archives'              => __( 'Enquiry Archives', 'real-estate-crm' ),
				'attributes'            => __( 'Enquiry Attributes', 'real-estate-crm' ),
				'parent_item_colon'     => __( 'Parent Enquiry:', 'real-estate-crm' ),
				'all_items'             => __( 'All Enquiries', 'real-estate-crm' ),
				'add_new_item'          => __( 'Add New Enquiry', 'real-estate-crm' ),
				'add_new'               => __( 'Add New', 'real-estate-crm' ),
				'new_item'              => __( 'New Enquiry', 'real-estate-crm' ),
				'edit_item'             => __( 'Edit Enquiry', 'real-estate-crm' ),
				'update_item'           => __( 'Update Enquiry', 'real-estate-crm' ),
				'view_item'             => __( 'View Enquiry', 'real-estate-crm' ),
				'view_items'            => __( 'View Enquiries', 'real-estate-crm' ),
				'search_items'          => __( 'Search Enquiry', 'real-estate-crm' ),
				'not_found'             => __( 'Not found', 'real-estate-crm' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'real-estate-crm' ),
				'featured_image'        => __( 'Featured Image', 'real-estate-crm' ),
				'set_featured_image'    => __( 'Set featured image', 'real-estate-crm' ),
				'remove_featured_image' => __( 'Remove featured image', 'real-estate-crm' ),
				'use_featured_image'    => __( 'Use as featured image', 'real-estate-crm' ),
				'insert_into_item'      => __( 'Insert into enquiry', 'real-estate-crm' ),
				'uploaded_to_this_item' => __( 'Uploaded to this enquiry', 'real-estate-crm' ),
				'items_list'            => __( 'Enquiries list', 'real-estate-crm' ),
				'items_list_navigation' => __( 'Enquiries list navigation', 'real-estate-crm' ),
				'filter_items_list'     => __( 'Filter enquiries list', 'real-estate-crm' ),
			);
			$args   = array(
				'label'               => __( 'Enquiry', 'real-estate-crm' ),
				'description'         => __( 'Real Estate Enquiries.', 'real-estate-crm' ),
				'labels'              => $labels,
				'supports'            => array( 'thumbnail' ),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-groups',
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'can_export'          => false,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => false,
				'capabilities'        => array(
					'create_posts' => false,
				),
				'map_meta_cap'        => true,


			);

			$args = apply_filters( 'recrm_enquiry_post_type_args', $args );

			register_post_type( 'enquiry', $args );

		}

	}

	new RECRM_post_types();
}


