<?php
/**
 * Field: Property ID
 *
 * Property ID field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes_elementor_addon
 */
global $the_widget_id;
global $settings;

$search_fields_to_display  = RHEA_Search_Form_Widget::rhea_search_select_sort();
if ( is_array($search_fields_to_display) && in_array('property-id',$search_fields_to_display)) {

	$field_key = array_search( 'property-id', $search_fields_to_display );

	$field_key = intval( $field_key ) + 1;

	?>
    <div class="rhea_prop_search__option rhea_mod_text_field rhea_property_id_field" style="order: <?php echo esc_attr($field_key);?>"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         id="property-id-<?php echo esc_attr( $the_widget_id ); ?>">
	<?php
	if ( 'yes' === $settings['show_labels'] ) {

		?>
        <label class="rhea_fields_labels" for="property-id-txt-<?php echo esc_attr( $the_widget_id ); ?>">
			<?php
			if ( !empty($settings['property_id_label']) ) {
				echo esc_html( $settings['property_id_label'] );
			} else {
				esc_html_e( 'Property ID', 'realhomes-elementor-addon' );
			}
			?>
        </label>
        <?php
	}
	?>
        <input type="text" name="property-id" autocomplete="off"
               id="property-id-txt-<?php echo esc_attr( $the_widget_id ); ?>"
               value="<?php echo isset( $_GET['property-id'] ) ? esc_attr( $_GET['property-id'] ) : ''; ?>"
               placeholder="<?php echo esc_attr($settings['property_id_placeholder'])?>"/>
    </div>

	<?php
}