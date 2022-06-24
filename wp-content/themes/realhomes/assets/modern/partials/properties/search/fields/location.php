<?php
/**
 * Field: Location
 *
 * @since 3.0.0
 * @package realhomes/modern
 */

$location_select_count  = inspiry_get_locations_number(); // Number of locations chosen from theme options.
$location_select_names  = inspiry_get_location_select_names(); // Variable that contains location select boxes names.
$location_select_titles = inspiry_get_location_titles(); // Default location select boxes titles.
$rh_locations_placeholders = realhomes_locations_placeholders();
$select_class              = 'inspiry_select_picker_trigger'; // Default class for the location dropdown fields.
$is_location_ajax       = get_option( 'inspiry_ajax_location_field', 'no' ); // Option to check if location field Ajax is enabled.
$multiselect_locations = get_option('inspiry_search_form_multiselect_locations','yes');

$parent_class = '';
if ( 'yes' === $is_location_ajax ) {
	$parent_class = ' inspiry_ajax_location_wrapper ';
	$select_class = '   inspiry_select_picker_trigger inspiry_ajax_location_field';
}

// Generate required location select boxes.
for ( $select_index = 0; $select_index < $location_select_count; $select_index ++ ) {
    $rh_current_select_placeholder = $rh_locations_placeholders[ $select_index ];
	?>
    <div class=" <?php echo esc_attr( $parent_class ) ?> inspiry_select_picker_field rh_prop_search__option rh_location_prop_search_<?php echo esc_attr( $select_index ); ?> rh_prop_search__select"
         data-get-location-placeholder="<?php echo esc_attr( $rh_current_select_placeholder ); ?>">
        <label for="<?php echo esc_attr( $location_select_names[ $select_index ] ); ?>">
			<?php echo esc_html( $location_select_titles[ $select_index ] ); ?>
        </label>

        <span class="rh_prop_search__selectwrap">
            <?php
            if ( 'yes' === $is_location_ajax ) {
	            ?>
                <span class="rh-location-ajax-loader"><?php inspiry_safe_include_svg( '/images/loader.svg' ); ?></span>
            <?php } ?>
			<select id="<?php echo esc_attr( $location_select_names[ $select_index ] ); ?>"
                    class="inspiry_multi_select_picker_location <?php echo esc_attr( $select_class ); ?> show-tick"
                    data-size="5"
                    data-live-search="true"
                    data-none-results-text="<?php esc_attr_e('No results matched','framework') ?>{0}"
                    data-none-selected-text="<?php echo esc_attr( $rh_current_select_placeholder ); ?>"
                    <?php
				if ( 'yes' == $multiselect_locations && $location_select_count <= 1 ) {
					?>
                    name="location[]"
                    data-selected-text-format="count > 2"
                    multiple="multiple"
                    data-actions-box="true"
                    title="<?php
					$loc_placeholder = get_option( 'inspiry_location_placeholder_1' );
					if ( ! empty( $loc_placeholder ) ) {
						echo esc_attr( $loc_placeholder );
					} else {
						esc_attr_e( 'All Locations', 'framework' );
					} ?>"

                    data-count-selected-text="{0} <?php
					$loc_counter_placeholder = get_option( 'inspiry_location_count_placeholder_1' );
					if ( ! empty( $loc_counter_placeholder ) ) {
						echo esc_attr( $loc_counter_placeholder );
					} else {
						esc_attr_e( ' Locations Selected ', 'framework' );
					}
					?>"

					<?php
				}elseif ( 'no' == $multiselect_locations && 'yes' === $is_location_ajax ) {
					?>
                    name="location[]"
                    data-max-options="1"
                    multiple="multiple"
                    title="<?php
					$loc_placeholder = get_option( 'inspiry_location_placeholder_1' );
					if ( ! empty( $loc_placeholder ) ) {
						echo esc_attr( $loc_placeholder );
					} else {
						esc_attr_e( 'All Locations', 'framework' );
					} ?>"
					<?php
				} else {
				    ?>
                    name="<?php echo esc_attr( $location_select_names[ $select_index ] ); ?>"
					<?php
                }
				?> > <?php
                if ( 'yes' === $is_location_ajax && $location_select_count <= 1 ) {
	                inspiry_searched_ajax_locations();
                }
                ?>
			</select>
		</span>
    </div>
	<?php
}

// Important action hook - related JS works based on it.
do_action( 'after_location_fields' );
