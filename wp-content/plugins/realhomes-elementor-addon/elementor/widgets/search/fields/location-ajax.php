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


	$select_class     = 'rhea_multi_select_picker_location'; // Default class for the location dropdown fields


// Generate required location select boxes.


		?>
		<div class="rhea_prop_search__option rhea_prop_locations_field rhea_prop_search__select rhea_location_ajax_parent_<?php echo esc_attr($the_widget_id)?>"
		     style="order: <?php echo esc_attr( $field_key ); ?>"
		     data-key-position="<?php echo esc_attr( $field_key ); ?>"

		     data-get-location-placeholder="<?php echo esc_attr( $settings['rhea_location_ph_1'] ); ?>">

			<?php
			if ( 'yes' === $settings['show_labels'] ) {

				?>
				<label for="rhea_ajax_location">
					<?php echo esc_html( $settings['rhea_location_title_1'] ); ?>
				</label>
			<?php } ?>
            <span class="rhea_prop_search__selectwrap">
                <span class="rhea-location-ajax-loader"><?php rhea_safe_include_svg( 'icons/loader.svg' ); ?></span>
			<select name="location[]"
			        id="rhea_ajax_location_<?php echo esc_attr($the_widget_id)?>"
			        class="<?php echo esc_attr( $select_class ); ?> rhea_ajax_select_location show-tick"
			        title="<?php echo esc_html( $settings['rhea_location_ph_1']); ?>"
			        data-size="<?php echo esc_attr( $settings['rhea_dropdown_items_in'] ); ?>"
			        data-live-search = "true"
                    data-live-search-placeholder = "<?php echo esc_attr($settings['rhea_ajax_input_placeholder']);?>"
                    data-none-results-text = "<?php echo esc_attr($settings['rhea_no_result_matched']); ?> {0}"
                    <?php

				if ( '1' == $location_select_count && 'yes' == $settings['set_multiple_location'] ) {

					?>
					multiple
					data-selected-text-format="count > 2"
					data-count-selected-text="{0} <?php echo esc_attr( $settings['location_count_placeholder'] ) ?>"
					<?php
				}elseif ('' == $settings['set_multiple_location']){
				    ?>
                    data-max-options="1"
                    multiple="multiple"
                    <?php
                }
				?>
			>
                <?php
                rhea_searched_ajax_locations();
                ?>
            </select>
		</span>
		</div>
		<?php

}

// Important action hook - related JS works based on it.
do_action( 'rhea_after_location_fields' );