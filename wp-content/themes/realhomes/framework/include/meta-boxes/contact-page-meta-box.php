<?php

if ( ! function_exists( 'rh_contact_page_meta_boxes' ) ) {
	/**
	 * Contact page related information and settings
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	function rh_contact_page_meta_boxes( $meta_boxes ) {

		$classic_design = ( 'classic' == INSPIRY_DESIGN_VARIATION );
		$last_columns   = 12;
		$icon_columns   = 6;

		$fields = array(

			// Contact Map
			array(
				'name'    => esc_html__( 'Map', 'framework' ),
				'id'      => "theme_show_contact_map",
				'type'    => 'radio',
				'std'     => '1',
				'options' => array(
					'1' => esc_html__( 'Show', 'framework' ),
					'0' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'map',
			),
			array(
				'name'    => esc_html__( 'Map Latitude', 'framework' ),
				'desc'    => 'You can use <a href="http://www.latlong.net/" target="_blank">latlong.net</a> OR <a href="http://itouchmap.com/latlong.html" target="_blank">itouchmap.com</a> to get Latitude and longitude of your desired location.',
				'id'      => "theme_map_lati",
				'type'    => 'text',
				'std'     => '-37.817917',
				'columns' => 6,
				'tab'     => 'map',
			),
			array(
				'name'    => esc_html__( 'Map Longitude', 'framework' ),
				'id'      => "theme_map_longi",
				'type'    => 'text',
				'std'     => '144.965065',
				'columns' => 6,
				'tab'     => 'map',
			),
			array(
				'name'    => esc_html__( 'Map Zoom Level', 'framework' ),
				'desc'    => esc_html__( 'Provide Map Zoom Level.', 'framework' ),
				'id'      => "theme_map_zoom",
				'type'    => 'text',
				'std'     => '17',
				'columns' => 6,
				'tab'     => 'map',
			),
		);

		$map_type = inspiry_get_maps_type();
		if ( 'google-maps' == $map_type ) {

			$fields = array_merge( $fields, array(

				array(
					'name'    => esc_html__( 'Map Type', 'framework' ),
					'desc'    => esc_html__( 'Choose Google Map Type', 'framework' ),
					'id'      => "inspiry_contact_map_type",
					'type'    => 'select',
					'options' => array(
						'roadmap'   => esc_html__( 'RoadMap', 'framework' ),
						'satellite' => esc_html__( 'Satellite', 'framework' ),
						'hybrid'    => esc_html__( 'Hybrid', 'framework' ),
						'terrain'   => esc_html__( 'Terrain', 'framework' ),
					),
					'std'     => 'roadmap',
					'columns' => 6,
					'tab'     => 'map',
				)
			) );

			$icon_columns = 12;
		}

		$fields = array_merge( $fields, array(
			array(
				'name'             => esc_html__( 'Google Maps Marker', 'framework' ),
				'desc'             => esc_html__( 'You may upload custom google maps marker for the contact page here. Image size should be around 50px by 50px.', 'framework' ),
				'id'               => "inspiry_contact_map_icon",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'columns'          => $icon_columns,
				'tab'              => 'map',
			),

			// Contact Details
			array(
				'name'    => esc_html__( 'Contact Detail', 'framework' ),
				'id'      => "theme_show_details",
				'type'    => 'radio',
				'std'     => '1',
				'options' => array(
					'1' => esc_html__( 'Show', 'framework' ),
					'0' => esc_html__( 'Hide', 'framework' ),
				),
				'columns' => 12,
				'tab'     => 'detail',
			),
		) );

		if ( $classic_design ) {
			$fields = array_merge( $fields, array(
				array(
					'name'    => esc_html__( 'Contact Details Title', 'framework' ),
					'id'      => "theme_contact_details_title",
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'detail',
				)
			) );

			$last_columns = 6;
		}

		$fields = array_merge( $fields, array(

			array(
				'name'    => esc_html__( 'Cell Number', 'framework' ),
				'id'      => "theme_contact_cell",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'detail',
			),
			array(
				'name'    => esc_html__( 'Phone Number', 'framework' ),
				'id'      => "theme_contact_phone",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'detail',
			),
			array(
				'name'    => esc_html__( 'Fax Number', 'framework' ),
				'id'      => "theme_contact_fax",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'detail',
			),
			array(
				'name'    => esc_html__( 'Display Email', 'framework' ),
				'id'      => "theme_contact_display_email",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'detail',
			),
			array(
				'name'    => esc_html__( 'Contact Address', 'framework' ),
				'id'      => "theme_contact_address",
				'type'    => 'textarea',
				'std'     => '',
				'columns' => $last_columns,
				'tab'     => 'detail',
			),

		) );

		if ( $classic_design ) {
			$fields = array_merge( $fields, array(
				array(
					'name'    => esc_html__( 'Contact Form Heading', 'framework' ),
					'id'      => "theme_contact_form_heading",
					'type'    => 'text',
					'std'     => '',
					'columns' => 6,
					'tab'     => 'form',
				)
			) );
		}

		$fields = array_merge( $fields, array(
			// Contact Form
			array(
				'name'    => esc_html__( 'Name Field Label', 'framework' ),
				'id'      => "theme_contact_form_name_label",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'form',
			),
			array(
				'name'    => esc_html__( 'Email Field Label', 'framework' ),
				'id'      => "theme_contact_form_email_label",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'form',
			),
			array(
				'name'    => esc_html__( 'Phone Number Field Label', 'framework' ),
				'id'      => "theme_contact_form_number_label",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'form',
			),
			array(
				'name'    => esc_html__( 'Message Field Label', 'framework' ),
				'id'      => "theme_contact_form_message_label",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'form',
			),
			array(
				'name'    => esc_html__( 'Contact Form Email', 'framework' ),
				'desc'    => esc_html__( 'Provide email address that will get messages from contact form.', 'framework' ),
				'id'      => "theme_contact_email",
				'type'    => 'text',
				'std'     => get_option( 'admin_email' ),
				'columns' => 6,
				'tab'     => 'form',
			),
			array(
				'name'    => esc_html__( 'Contact Form CC Email', 'framework' ),
				'desc'    => esc_html__( 'You can add multiple comma separated cc email addresses, to get a carbon copy of contact form message.', 'framework' ),
				'id'      => "theme_contact_cc_email",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'form',
			),
			array(
				'name'    => esc_html__( 'Contact Form BCC Email', 'framework' ),
				'desc'    => esc_html__( 'You can add multiple comma separated bcc email addresses, to get a blind carbon copy of contact form message.', 'framework' ),
				'id'      => "theme_contact_bcc_email",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'form',
			),
			array(
				'name'    => esc_html__( 'Contact Form Shortcode ( To Replace Default Form )', 'framework' ),
				'desc'    => esc_html__( 'If you want to replace default contact form with a plugin based form then provide its shortcode here.', 'framework' ),
				'id'      => "inspiry_contact_form_shortcode",
				'type'    => 'text',
				'std'     => '',
				'columns' => 6,
				'tab'     => 'form',
			),
			array(
				'name'    => esc_html__( 'Select Page For Redirection', 'framework' ),
				'desc'    => esc_html__( 'User will be redirected to the selected page after successful submission of the contact form.', 'framework' ),
				'id'      => "inspiry_contact_form_success_redirect_page",
				'type'    => 'select',
				'options' => RH_Data::get_pages_array(),
				'std'     => '',
				'columns' => 6,
				'tab'     => 'form',
			),
		) );

		$meta_boxes[] = array(
			'id'         => 'contact-page-meta-box',
			'title'      => esc_html__( 'Contact Page Settings', 'framework' ),
			'post_types' => array( 'page' ),
			'show'       => array(
				'template' => array(
					'templates/contact.php',
				),
			),
			'context'    => 'normal',
			'priority'   => 'low',
			'tabs'       => array(
				'map'    => array(
					'label' => esc_html__( 'Contact Map', 'framework' ),
					'icon'  => 'fas fa-map-marker-alt',
				),
				'detail' => array(
					'label' => esc_html__( 'Contact Details', 'framework' ),
					'icon'  => 'far fa-address-card',
				),
				'form'   => array(
					'label' => esc_html__( 'Contact Form', 'framework' ),
					'icon'  => 'far fa-envelope-open',
				),
			),
			'tab_style'  => 'left',
			'fields'     => $fields,
		);

		return $meta_boxes;
	}

	add_filter( 'rwmb_meta_boxes', 'rh_contact_page_meta_boxes' );
}