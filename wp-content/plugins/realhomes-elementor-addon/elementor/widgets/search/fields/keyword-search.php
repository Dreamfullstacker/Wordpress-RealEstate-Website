<?php
/**
 * Field: Keyword
 *
 * Keyword field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes_elementor_addon
 */
global $settings;
global $the_widget_id;

$search_fields_to_display = RHEA_Search_Form_Widget::rhea_search_select_sort();

if ( is_array($search_fields_to_display) && in_array( 'keyword-search', $search_fields_to_display ) ) {
	$field_key = array_search( 'keyword-search', $search_fields_to_display );
	$field_key = intval( $field_key ) + 1;
	?>
    <div class="rhea_prop_search__option rhea_mod_text_field rhea_keyword_field"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         id="keyword-search<?php echo esc_attr( $the_widget_id ); ?>"
         style="order: <?php echo esc_attr( $field_key ); ?>">
		<?php
		if ( 'yes' === $settings['show_labels'] ) {
			?>
            <label class="rhea_fields_labels" for="keyword-txt-<?php echo esc_attr( $the_widget_id ); ?>">
				<?php if ( ! empty( $settings['keyword_label'] ) ) {
					echo esc_html( $settings['keyword_label'] );
				} else {
					esc_html_e( 'Keyword', 'realhomes-elementor-addon' );
				} ?>
            </label>
			<?php
		}
		?>
        <input type="text" name="keyword" id="keyword-txt-<?php echo esc_attr( $the_widget_id ); ?>" autocomplete="off"
               value="<?php echo isset( $_GET['keyword'] ) ? esc_attr( $_GET['keyword'] ) : ''; ?>"
               placeholder="<?php if ( ! empty( $settings['keyword_placeholder'] ) ) {
			       echo esc_attr( $settings['keyword_placeholder'] );
		       } else {
			       echo esc_attr__( 'Keyword', 'realhomes-elementor-addon' );
		       } ?>"/>

        <!--    <div class="rhea_sfoi_data_fetch_list"></div>-->
        <!--    <span class="rhea_sfoi_ajax_loader">-->
		<?php //include INSPIRY_THEME_DIR . '/images/loader.svg';
		?><!--</span>-->
		<?php

		?>
    </div>
	<?php
}