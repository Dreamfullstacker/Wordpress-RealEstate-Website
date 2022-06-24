<?php
/*
 * Parent Property for Submit Form
 */
$post_type_object = get_post_type_object( 'property' );
if ( ! empty( $post_type_object ) && $post_type_object->hierarchical ) {
	$parent_properties_dropdown_args = array(
		'post_type'        => 'property',
		'name'             => 'property_parent_id',
		'show_option_none' => esc_html__( '(no parent)', 'framework' ),
		'sort_column'      => 'menu_order, post_title',
		'echo'             => 0,
		'class'            => 'inspiry_select_picker_trigger show-tick',

	);

	if ( inspiry_is_edit_property() ) {
		global $edit_property_id;
		global $target_property;
		$parent_properties_dropdown_args['exclude_tree'] = $edit_property_id;
		$parent_properties_dropdown_args['selected']     = $target_property->post_parent;
	}

	$parent_properties_dropdown = wp_dropdown_pages( $parent_properties_dropdown_args );

	if ( ! empty( $parent_properties_dropdown ) ) {
		?>
        <div class="form-option parent-field-wrapper">
            <label for="property_parent_id"><?php esc_html_e( 'Parent Property', 'framework' ); ?></label>
			<?php
			echo wp_kses( $parent_properties_dropdown, array(
				'select' => array(
					'id'    => array(),
					'class' => array(),
					'name'  => array(),
					'value' => array(),
					'type'  => array(),
				),
				'option' => array(
					'value'    => array(),
					'selected' => array(),
					'class'    => array(),
				),
			) );
			?>
        </div>
		<?php

	}
}
