<?php
/**
 * Add misc metabox tab to property
 *
 * @param $property_metabox_tabs
 *
 * @return array
 */
function ere_misc_metabox_tab( $property_metabox_tabs ) {
	if ( is_array( $property_metabox_tabs ) ) {
		$property_metabox_tabs['misc'] = array(
			'label' => esc_html__( 'Misc', 'easy-real-estate' ),
			'icon'  => 'dashicons-lightbulb',
		);
	}

	return $property_metabox_tabs;
}

add_filter( 'ere_property_metabox_tabs', 'ere_misc_metabox_tab', 80 );


/**
 * Add misc metaboxes fields to property
 *
 * @param $property_metabox_fields
 *
 * @return array
 */
function ere_misc_metabox_fields( $property_metabox_fields ) {

	$first_mc_field_title  = get_option( 'inspiry_mc_first_field_title', esc_html__( 'Property Taxes', 'easy-real-estate' ) );
	$first_mc_field_desc   = get_option( 'inspiry_mc_first_field_desc', esc_html__( 'Provide monthly property tax amount. It will be displayed in the mortgage calculator only.', 'easy-real-estate' ) );
	$first_mc_field_value  = get_option( 'inspiry_mc_first_field_value', '0' );
	$second_mc_field_title = get_option( 'inspiry_mc_second_field_title', esc_html__( 'Additional Fee', 'easy-real-estate' ) );
	$second_mc_field_desc  = get_option( 'inspiry_mc_second_field_desc', esc_html__( 'Provide monthly any additional fee. It will be displayed in the mortgage calculator only.', 'easy-real-estate' ) );
	$second_mc_field_value = get_option( 'inspiry_mc_second_field_value', '0' );

	$ere_misc_fields = array(
		// Misc.
		array(
			'id'        => "REAL_HOMES_sticky",
			'name'      => esc_html__( 'Make this property sticky for home and listings pages', 'easy-real-estate' ),
			'type'      => 'switch',
			'style'     => 'square',
			'on_label'  => esc_html__( 'Yes', 'easy-real-estate' ),
			'off_label' => esc_html__( 'No', 'easy-real-estate' ),
			'std'       => 0,
			'columns'   => 12,
			'class'     => 'inspiry_switch_inline',
			'tab'       => 'misc',
		),
		// Property Label Separator.
		array(
			'type'    => 'divider',
			'columns' => 12,
			'id'      => 'property_label_divider',
			'tab'     => 'misc',
		),
		array(
			'name'    => esc_html__( 'Property Label Text', 'easy-real-estate' ),
			'id'      => 'inspiry_property_label',
			'desc'    => esc_html__( 'You can add a property label to display on property thumbnails. Example: Hot Deal', 'easy-real-estate' ),
			'type'    => 'text',
			'columns' => 6,
			'tab'     => 'misc',
		),
		array(
			'name'    => esc_html__( 'Label Background Color', 'easy-real-estate' ),
			'id'      => 'inspiry_property_label_color',
			'desc'    => esc_html__( 'Set a label background color. Otherwise label text will be displayed with transparent background.', 'easy-real-estate' ),
			'type'    => 'color',
			'columns' => 6,
			'tab'     => 'misc',
		),
		// Property Mortgage Calculator Separator.
		array(
			'type'    => 'divider',
			'columns' => 12,
			'id'      => 'property_mc_divider',
			'tab'     => 'misc',
		),
		array(
			'id'      => 'inspiry_property_tax',
			'name'    => esc_html( $first_mc_field_title ),
			'desc'    => esc_html( $first_mc_field_desc ),
			'std'     => esc_html( $first_mc_field_value ),
			'type'    => 'text',
			'columns' => 6,
			'tab'     => 'misc',
		),
		array(
			'id'      => 'inspiry_additional_fee',
			'name'    => esc_html( $second_mc_field_title ),
			'desc'    => esc_html( $second_mc_field_desc ),
			'std'     => esc_html( $second_mc_field_value ),
			'type'    => 'text',
			'columns' => 6,
			'tab'     => 'misc',
		),
		// Property Attachments Separator.
		array(
			'type'    => 'divider',
			'columns' => 12,
			'id'      => 'property_attachments_divider',
			'tab'     => 'misc',
		),
		array(
			'id'        => "REAL_HOMES_attachments",
			'name'      => esc_html__( 'Attachments', 'easy-real-estate' ),
			'desc'      => esc_html__( 'You can attach PDF files, Map images OR other documents to provide further details related to property.', 'easy-real-estate' ),
			'type'      => 'file_advanced',
			'mime_type' => '',
			'columns'   => 12,
			'tab'       => 'misc',
		),
		// Property Owner Separator.
		array(
			'type'    => 'divider',
			'columns' => 12,
			'id'      => 'property_owner_divider',
			'tab'     => 'misc',
		),
		array(
			'name'    => esc_html__( 'Property Owner Name', 'easy-real-estate' ),
			'id'      => 'inspiry_property_owner_name',
			'type'    => 'text',
			'columns' => 6,
			'tab'     => 'misc',
		),
		array(
			'name'    => esc_html__( 'Owner Contact', 'easy-real-estate' ),
			'id'      => 'inspiry_property_owner_contact',
			'type'    => 'text',
			'columns' => 6,
			'tab'     => 'misc',
		),
		array(
			'id'      => 'inspiry_property_owner_address',
			'name'    => esc_html__( 'Owner Address', 'easy-real-estate' ),
			'type'    => 'text',
			'columns' => 12,
			'tab'     => 'misc',
		),
		array(
			'id'      => "REAL_HOMES_property_private_note",
			'name'    => esc_html__( 'Private Note', 'easy-real-estate' ),
			'desc'    => esc_html__( 'In this textarea, You can write your private note about this property. This field will not be displayed anywhere else.', 'easy-real-estate' ),
			'type'    => 'textarea',
			'std'     => '',
			'columns' => 12,
			'tab'     => 'misc',
		),
		array(
			'id'      => 'inspiry_message_to_reviewer',
			'name'    => esc_html__( 'Message to Reviewer', 'easy-real-estate' ),
			'type'    => 'textarea',
			'columns' => 12,
			'tab'     => 'misc',
		),
	);

	if ( 'fullwidth' === get_option( 'inspiry_property_single_template', 'sidebar' ) ) {
		array_push( $ere_misc_fields,
			array(
				'type'    => 'divider',
				'columns' => 12,
				'id'      => 'property_label_divider_2',
				'tab'     => 'misc',
			),
			array(
				'id'        => 'inspiry_global_property_template_override',
				'name'      => esc_html__( 'Override website level template settings for this property', 'easy-real-estate' ),
				'type'      => 'switch',
				'style'     => 'square',
				'on_label'  => esc_html__( 'Yes', 'easy-real-estate' ),
				'off_label' => esc_html__( 'No', 'easy-real-estate' ),
				'std'       => 0,
				'columns'   => 12,
				'class'     => 'inspiry_switch_inline',
				'tab'       => 'misc',
			)
		);
	}

	return array_merge( $property_metabox_fields, $ere_misc_fields );

}

add_filter( 'ere_property_metabox_fields', 'ere_misc_metabox_fields', 80 );
