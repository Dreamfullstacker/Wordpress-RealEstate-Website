<?php
/**
 * Field: Property Area
 *
 * Area field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes_elementor_addon
 */
global $the_widget_id;
global $settings;

$search_fields_to_display = RHEA_Search_Form_Widget::rhea_search_select_sort();
if ( is_array($search_fields_to_display) && in_array( 'min-max-area', $search_fields_to_display ) ) {

	$field_key = array_search( 'min-max-area', $search_fields_to_display );

	$field_key = intval( $field_key ) + 1;
	?>
    <div class="rhea_prop_search__option rhea_mod_text_field rhea_min_area_field"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         style="order: <?php echo esc_attr( $field_key ); ?>">

		<?php
		if ( 'yes' === $settings['show_labels'] ) {

			?>
            <label class="rhea_fields_labels" for="min-area-<?php echo esc_attr( $the_widget_id ); ?>">

		<span class="label">
			<?php

			if ( ! empty( $settings['min_area_label'] ) ) {
				echo esc_html( $settings['min_area_label'] );
			} else {
				esc_html_e( 'Min Area', 'realhomes-elementor-addon' );
			}
			?>
	    </span>

				<?php
				if ( ! empty( $settings['area_units_placeholder'] ) ) {
					?>
                    <span class="unit">
                <?php
                echo esc_html( $settings['area_units_placeholder'] );
                ?>
                 </span>
					<?php

				}

				?>

            </label>
			<?php
		}
		?>
        <input type="text" autocomplete="off" name="min-area" id="min-area-<?php echo esc_attr( $the_widget_id ); ?>"
               pattern="[0-9]+"
               value="<?php echo isset( $_GET['min-area'] ) ? esc_attr( $_GET['min-area'] ) : ''; ?>"
               placeholder="<?php echo esc_attr( $settings['min_area_placeholder'] ); ?>"

			<?php if ( ! empty( $settings['area_units_title_attr'] ) ) { ?>
                title="<?php echo esc_attr( $settings['area_units_title_attr'] ); ?>"
			<?php } ?>
        />
    </div>

    <div class="rhea_prop_search__option rhea_mod_text_field rhea_max_area_field"
         style="order: <?php echo esc_attr( $field_key ); ?>">
		<?php
		if ( 'yes' === $settings['show_labels'] ) {
			?>
            <label class="rhea_fields_labels" for="max-area-<?php echo esc_attr( $the_widget_id ); ?>">
		<span class="label">
			<?php
			if ( ! empty( $settings['max_area_label'] ) ) {
				echo esc_html( $settings['max_area_label'] );
			} else {
				esc_html_e( 'Max Area', 'realhomes-elementor-addon' );
			}
			?>
	    </span>
				<?php
				if ( ! empty( $settings['area_units_placeholder'] ) ) {
					?>
                    <span class="unit">
                <?php
                echo esc_html( $settings['area_units_placeholder'] );
                ?>
                 </span>
					<?php
				}
				?>
            </label>
			<?php
		}
		?>
        <input type="text" autocomplete="off" name="max-area" id="max-area-<?php echo esc_attr( $the_widget_id ); ?>"
               pattern="[0-9]+"
               value="<?php echo isset( $_GET['max-area'] ) ? esc_attr( $_GET['max-area'] ) : ''; ?>"
               placeholder="<?php echo esc_attr( $settings['max_area_placeholder'] ); ?>"
			<?php if ( ! empty( $settings['area_units_title_attr'] ) ) { ?>
                title="<?php echo esc_attr( $settings['area_units_title_attr'] ); ?>"
			<?php } ?>
        />
    </div>

	<?php
}