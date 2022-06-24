<?php
/**
 * Field: Property Status
 *
 * Property Status field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes_elementor_addon
 */
global $the_widget_id;
global $settings;

$search_fields_to_display = RHEA_Search_Form_Widget::rhea_search_select_sort();

if ( is_array($search_fields_to_display) && in_array( 'status', $search_fields_to_display ) ) {

	$field_key = array_search( 'status', $search_fields_to_display );

	$field_key = intval( $field_key ) + 1;
	?>

    <div class="rhea_prop_search__option rhea_prop_search__select rhea_status_field"
         style="order: <?php echo esc_attr( $field_key ); ?>"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         id="status-<?php echo esc_attr( $the_widget_id ); ?>">

		<?php
		if ( 'yes' === $settings['show_labels'] ) {

			?>
            <label class="rhea_fields_labels" for="select-status-<?php echo esc_attr( $the_widget_id ); ?>">
				<?php
				if ( ! empty( $settings['property_status_label'] ) ) {
					echo esc_html( $settings['property_status_label'] );
				} else {
					echo esc_html__( 'Property Status', 'realhomes-elementor-addon' );
				}
				?>
            </label>
			<?php
		}
		?>
        <span class="rhea_prop_search__selectwrap">
		<select name="status[]" id="select-status-<?php echo esc_attr( $the_widget_id ); ?>"
                class="rhea_multi_select_picker show-tick"
                data-size="<?php echo esc_attr($settings['rhea_dropdown_items_in'] ); ?>"
                title="<?php
			    if ( ! empty( $settings['property_status_placeholder'] ) ) {
				    echo esc_attr( $settings['property_status_placeholder'] );
			    } else {
				    esc_attr_e( 'All Status', 'realhomes-elementor-addon' );
			    } ?>"
        >
			<?php
			rhea_hierarchical_options( 'property-status',$settings['property_status_placeholder'],'',$settings['rhea_select_exclude_status'],$settings['default_status_select'] );
			?>
		</select>
	</span>
    </div>
	<?php

}


