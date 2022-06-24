<?php
/**
 * Field: Location
 *
 * @since 3.0.0
 * @package realhomes_elementor_addon
 */
global $settings;
global $the_widget_id;
$search_fields_to_display = RHEA_Search_Form_Widget::rhea_search_select_sort();

if ( is_array( $search_fields_to_display ) && in_array( 'location', $search_fields_to_display ) ) {

	$field_key = array_search( 'location', $search_fields_to_display );

	$field_key = intval( $field_key ) + 1;

	$location_select_count = $settings['rhea_select_locations']; // Number of locations chosen from elementor control.

	$location_select_names  = rhea_get_location_select_names(); // Variable that contains location select boxes names.
	$location_select_titles = rhea_get_location_titles(
		$settings['rhea_location_title_1'],
		$settings['rhea_location_title_2'],
		$settings['rhea_location_title_3'],
		$settings['rhea_location_title_4']
	); // Default location select boxes titles.
	$location_placeholder   = rhea_location_placeholder(
		$settings['rhea_location_ph_1'],
		$settings['rhea_location_ph_2'],
		$settings['rhea_location_ph_3'],
		$settings['rhea_location_ph_4']
	);

	$select_class     = 'rhea_multi_select_picker_location'; // Default class for the location dropdown fields

// Generate required location select boxes.

	if ( '1' == $location_select_count && 'yes' == $settings['set_multiple_location'] ) {

		$name_multi = '[]';
	} else {
		$name_multi = '';
	}

	for ( $i = 0; $i < $location_select_count; $i ++ ) {
		?>
        <div class="rhea_prop_search__option rhea_prop_locations_field rhea_location_prop_search_<?php echo esc_attr( $i ) ?> rhea_prop_search__select"
             style="order: <?php echo esc_attr( $field_key ); ?>"
             data-key-position="<?php echo esc_attr( $field_key ); ?>"

             data-get-location-placeholder="<?php echo esc_attr( $location_placeholder[ $i ] ); ?>">

			<?php
			if ( 'yes' === $settings['show_labels'] ) {

				?>
                <label class="rhea_fields_labels" for="<?php echo esc_attr( $location_select_names[ $i ] ); ?>">
					<?php echo esc_html( $location_select_titles[ $i ] ); ?>
                </label>
			<?php } ?>
            <span class="rhea_prop_search__selectwrap">
                <select  id="<?php echo esc_attr( $the_widget_id . $location_select_names[ $i ] ); ?>"
                     class="<?php echo esc_attr( $select_class ); ?> show-tick"
                         data-size="<?php echo esc_attr( $settings['rhea_dropdown_items_in'] ); ?>"
                         data-none-results-text="<?php esc_attr_e('No results matched','framework') ?>{0}"
                         data-none-selected-text="<?php echo esc_attr( $location_placeholder[ $i ] ); ?>"
                         data-live-search="true"
                         <?php
		if ( '1' == $location_select_count && 'yes' == $settings['set_multiple_location'] ) {
		    ?>
            name="location[]"
            data-selected-text-format="count > 2"
            multiple="multiple"
            data-actions-box="true"
            data-count-selected-text="{0} <?php echo esc_attr( $settings['location_count_placeholder'] ) ?>"
            title="<?php echo esc_html( $location_select_titles[ $i ] ); ?>"
			<?php
		}elseif ( '1' == $location_select_count  && 'yes' !== $settings['set_multiple_location'] ) {
		    ?>
            data-max-options="1"
            name="location[]"

			<?php
		}else{
		    ?>
            name="<?php echo esc_attr( $location_select_names[ $i ] . $name_multi ); ?>"
			<?php
        }
                         ?>

                >

                </select>

		</span>
        </div>
		<?php
	}

}

// Important action hook - related JS works based on it.
do_action( 'rhea_after_location_fields' );