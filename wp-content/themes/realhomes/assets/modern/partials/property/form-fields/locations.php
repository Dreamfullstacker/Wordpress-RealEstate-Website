<?php
/**
 * Field: Property Locations
 *
 * @since    3.0.0
 * @package realhomes/modern
 */

$location_select_count  = inspiry_get_locations_number(); // Number of locations chosen from theme options.
$location_select_names  = inspiry_get_location_select_names(); // Variable that contains location select boxes names.
$location_select_titles = inspiry_get_location_titles(); // Default location select boxes titles.
$select_class           = 'inspiry_bs_submit_location inspiry_select_picker_trigger inspiry_bs_default_mod inspiry_bs_orange show-tick'; // Default class for the location dropdown fields.
$is_location_ajax       = get_option( 'inspiry_ajax_location_field', 'no' ); // Option to check if location field Ajax is enabled.

$parent_class = '';
if ( 'yes' === $is_location_ajax ) {
	$parent_class = ' inspiry_ajax_location_wrapper ';
	$select_class = ' inspiry_ajax_location_field inspiry_select_picker_trigger inspiry_bs_default_mod inspiry_bs_orange show-tick';
}
/* Generate required location select boxes */
for ( $i = 0; $i < $location_select_count; $i ++ ) {
	?>
    <div class="<?php echo esc_attr( $parent_class ) ?> inspiry_select_picker_field rh_form__item rh_form--3-column rh_form--columnAlign rh_location_prop_loc_<?php echo esc_attr( $i ); ?> rh_prop_loc__select">
        <label for="<?php echo esc_attr( $location_select_names[ $i ] ); ?>"><?php echo esc_html( $location_select_titles[ $i ] ); ?></label>
        <span class="selectwrap">
            <?php if ( 'yes' === $is_location_ajax ) { ?>
                <span class="rh-location-ajax-loader"><?php inspiry_safe_include_svg( '/images/loader.svg' ); ?></span>
            <?php } ?>
			<select name="<?php echo esc_attr( $location_select_names[ $i ] ); ?>"
                    id="<?php echo esc_attr( $location_select_names[ $i ] ); ?>"
                    class="<?php echo esc_attr( $select_class ); ?>"
                    data-live-search="true"
                    data-size="5"
                    data-none-selected-text="<?php esc_attr_e('None','framework')?>"
				    <?php if ( 'yes' === $is_location_ajax ) { ?>
                    data-none-results-text="<?php esc_html_e( 'No results matched ', 'framework' ); ?> {0}"
					<?php } ?> >
                <?php
	            if ( realhomes_dashboard_edit_property() && 'yes' === $is_location_ajax ) {
		            global $target_property;
		            $selected_term = get_the_terms($target_property->ID,'property-city');
		            if($selected_term){
			            ?>
                        <option class="none" value=""><?php esc_html_e( 'None', 'framework' ); ?></option>
                        <option selected="selected" value="<?php echo esc_attr($selected_term[0]->slug)?>"><?php echo esc_attr($selected_term[0]->name) ?></option>
			            <?php
		            }else{
			            ?>
                        <option class="none" selected="selected" value=""><?php esc_html_e( 'None', 'framework' ); ?></option>
			            <?php
		            }
	            }elseif('yes' === $is_location_ajax ){
		            ?>
                    <option class="none" selected="selected" value=""><?php esc_html_e( 'None', 'framework' ); ?></option>
		            <?php
	            }
	            ?>
            </select>
	    </span>
    </div>
    <!-- /.rh_form__item -->
	<?php
}
// Important action hook - related JS works based on it.
do_action( 'after_location_fields' );