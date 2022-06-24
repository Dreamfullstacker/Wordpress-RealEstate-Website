<?php

if ( ! function_exists( 'inspiry_migrate_contact_settings' ) ) {
	/**
	 * Migrate contact page settings from customizer to meta-boxes.
	 *
	 * @param $page_id
	 */
	function inspiry_migrate_contact_settings( $page_id ) {

		$contact_migrated = get_option( 'inspiry_contact_settings_migration', 'false' );

		if ( 'true' != $contact_migrated ) {

			$customizer_data = array();
			$settings_fields = array(
				'theme_show_contact_map',
				'theme_map_lati',
				'theme_map_longi',
				'theme_map_zoom',
				'inspiry_contact_map_type',
				'inspiry_contact_map_icon',
				'theme_show_details',
				'theme_contact_details_title',
				'theme_contact_address',
				'theme_contact_cell',
				'theme_contact_phone',
				'theme_contact_fax',
				'theme_contact_display_email',
				'theme_contact_form_heading',
				'theme_contact_form_name_label',
				'theme_contact_form_email_label',
				'theme_contact_form_number_label',
				'theme_contact_form_message_label',
				'theme_contact_email',
				'theme_contact_cc_email',
				'theme_contact_bcc_email',
				'inspiry_contact_form_shortcode'
			);

			foreach ( $settings_fields as $field ) {

				$customizer_data[ $field ] = get_option( $field );

				if ( ! empty( $customizer_data[ $field ] ) ) {

					$value = $customizer_data[ $field ];

					if ( 'theme_show_contact_map' == $field || 'theme_show_details' == $field ) {
						$value = ( 'true' == $customizer_data[ $field ] ) ? '1' : '0';
					} else if ( 'inspiry_contact_map_icon' == $field ) {
						$value = attachment_url_to_postid( $customizer_data[ $field ] );
					}

					update_post_meta( $page_id, $field, $value );
				}
			}

			// Flag the contact settings migration as done!
			update_option( 'inspiry_contact_settings_migration', 'true' );
		}

	}

	add_action( 'inspiry_before_contact_page_render', 'inspiry_migrate_contact_settings' );
}