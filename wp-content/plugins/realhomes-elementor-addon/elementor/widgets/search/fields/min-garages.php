<?php
/**
 * Field: Garages
 *
 * Garages field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes_elementor_addon
 */
global $settings;
global $the_widget_id;

$search_fields_to_display = RHEA_Search_Form_Widget::rhea_search_select_sort();
if ( is_array($search_fields_to_display) && in_array( 'min-garages', $search_fields_to_display ) ) {

	$field_key = array_search( 'min-garages', $search_fields_to_display );

	$field_key = intval( $field_key ) + 1;
	?>

    <div class="rhea_prop_search__option rhea_prop_search__select rhea_garages_field"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         style="order: <?php echo esc_attr( $field_key ); ?>">
		<?php
		if ( 'yes' === $settings['show_labels'] ) {
			?>
            <label class="rhea_fields_labels" for="select-garages-<?php echo esc_attr( $the_widget_id ); ?>">
				<?php
				if ( ! empty( $settings['garages_label'] ) ) {
					echo esc_html( $settings['garages_label'] );
				} else {
					esc_html_e( 'Garages', 'realhomes-elementor-addon' );
				}
				?>
            </label>
			<?php
		}
		?>
        <span class="rhea_prop_search__selectwrap">
		<select name="garages" id="select-garages-<?php echo esc_attr( $the_widget_id ); ?>"
                class="rhea_multi_select_picker show-tick"
                data-size="<?php echo esc_attr($settings['rhea_dropdown_items_in'] ); ?>"
        >
            <?php rhea_min_garages($settings['garages_placeholder'],$settings['garages_drop_down_value']); ?>
		</select>
	</span>
    </div>

	<?php

}

