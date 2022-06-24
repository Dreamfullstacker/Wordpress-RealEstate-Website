<?php
/**
 * Field: Price
 *
 * Price field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes_elementor_addon
 */
global $the_widget_id;
global $settings;
$inspiry_min_price_label = $settings['min_price_label'];
$inspiry_max_price_label = $settings['max_price_label'];

$search_fields_to_display  = RHEA_Search_Form_Widget::rhea_search_select_sort();
if ( is_array($search_fields_to_display) && in_array('min-max-price',$search_fields_to_display)) {

	$field_key = array_search( 'min-max-price', $search_fields_to_display );

	$field_key = intval( $field_key ) + 1;
	?>
    <div class="rhea_prop_search__option rhea_prop_search__select price-for-others rhea_min_price_field"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         style="order: <?php echo esc_attr($field_key);?>">

        <?php if ( 'yes' === $settings['show_labels'] ) { ?>
        <label class="rhea_fields_labels" for="select-min-price-<?php echo esc_attr( $the_widget_id ); ?>">
			<?php
			if ( ! empty( $inspiry_min_price_label ) ) {
				echo esc_html( $inspiry_min_price_label );
			} else {
				esc_html_e( 'Min Price', 'realhomes-elementor-addon' );
			}
			?>
        </label>
        <?php } ?>
        <span class="rhea_prop_search__selectwrap">
		<select name="min-price" id="select-min-price-<?php echo esc_attr( $the_widget_id ); ?>"
                class="rhea_multi_select_picker show-tick"
                data-size="<?php echo esc_attr($settings['rhea_dropdown_items_in'] ); ?>"
        >
			<?php rhea_min_prices_list($settings['min_price_placeholder'],$settings['min_price_drop_down_value']); ?>
		</select>
	</span>
    </div>

    <div class="rhea_prop_search__option rhea_prop_search__select price-for-others rhea_max_price_field"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         style="order: <?php echo esc_attr($field_key);?>">

	<?php if ( 'yes' === $settings['show_labels'] ) { ?>
        <label class="rhea_fields_labels" for="select-max-price-<?php echo esc_attr( $the_widget_id ); ?>">
			<?php
			if ( ! empty( $inspiry_max_price_label ) ) {
				echo esc_html( $inspiry_max_price_label );
			} else {
				esc_html_e( 'Max Price', 'realhomes-elementor-addon' );
			}
			?>
        </label>
        <?php } ?>
        <span class="rhea_prop_search__selectwrap">
		<select name="max-price" id="select-max-price-<?php echo esc_attr( $the_widget_id ); ?>"
                class="rhea_multi_select_picker show-tick"
                data-size="<?php echo esc_attr($settings['rhea_dropdown_items_in'] ); ?>"
        >
			<?php rhea_max_prices_list($settings['max_price_placeholder'],$settings['max_price_drop_down_value']); ?>
		</select>
	</span>
    </div>

	<?php
	/**
	 * Prices for Rent
	 */
	?>
    <div class="rhea_prop_search__option rhea_prop_search__select price-for-rent hide-fields rhea_min_price_field"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         style="order: <?php echo esc_attr($field_key);?>">
	<?php if ( 'yes' === $settings['show_labels'] ) { ?>
        <label for="select-min-price-for-rent-<?php echo esc_attr( $the_widget_id ); ?>">
			<?php
			if ( $inspiry_min_price_label ) {
				echo esc_html( $inspiry_min_price_label );
			} else {
				esc_html_e( 'Min Price', 'realhomes-elementor-addon' );
			}
			?>
        </label>
        <?php } ?>
        <span class="rhea_prop_search__selectwrap">
	    <select name="min-price" id="select-min-price-for-rent-<?php echo esc_attr( $the_widget_id ); ?>"
                class="rhea_multi_select_picker show-tick"
                data-size="<?php echo esc_attr($settings['rhea_dropdown_items_in'] ); ?>"
        >
	        <?php rhea_min_prices_for_rent_list($settings['min_price_placeholder'],$settings['min_rent_price_drop_down_value']); ?>
	    </select>
	</span>
    </div>

    <div class="rhea_prop_search__option rhea_prop_search__select price-for-rent hide-fields rhea_max_price_field"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         style="order: <?php echo esc_attr($field_key);?>">
	<?php if ( 'yes' === $settings['show_labels'] ) { ?>
        <label for="select-max-price-for-rent-<?php echo esc_attr( $the_widget_id ); ?>">
			<?php
			if ( $inspiry_max_price_label ) {
				echo esc_html( $inspiry_max_price_label );
			} else {
				esc_html_e( 'Max Price', 'realhomes-elementor-addon' );
			}
			?>
        </label>
        <?php } ?>
        <span class="rhea_prop_search__selectwrap">
	    <select name="max-price" id="select-max-price-for-rent-<?php echo esc_attr( $the_widget_id ); ?>"
                class="rhea_multi_select_picker show-tick"
                data-size="<?php echo esc_attr($settings['rhea_dropdown_items_in'] ); ?>"
        >
	        <?php rhea_max_prices_for_rent_list($settings['max_price_placeholder'],$settings['max_rent_price_drop_down_value']); ?>
	    </select>
	</span>
    </div>
	<?php
}