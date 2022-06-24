<?php
/**
 * Field: Agent
 *
 * Agent field for advance property search widget.
 *
 */
global $settings;
global $the_widget_id;

$search_fields_to_display = RHEA_Search_Form_Widget::rhea_search_select_sort();

if ( is_array($search_fields_to_display) && in_array( 'agent', $search_fields_to_display ) ) {

	$field_key = array_search( 'agent', $search_fields_to_display );

	$field_key = intval( $field_key ) + 1;
	?>
    <div class="rhea_prop_search__option rhea_prop_search__select rhea_agent_field"
         data-key-position ="<?php echo esc_attr( $field_key ); ?>"
         id="agent-<?php echo esc_attr( $the_widget_id ); ?>"
         style="order: <?php echo esc_attr( $field_key ); ?>">

		<?php
		if ( 'yes' === $settings['show_labels'] ) {
			?>
            <label class="rhea_fields_labels" for="select-agent-<?php echo esc_attr( $the_widget_id ); ?>">
				<?php
				if ( ! empty( $settings['agent_label'] ) ) {
					echo esc_html( $settings['agent_label'] );
				} else {
					esc_html_e( 'Agent', 'realhomes-elementor-addon' );
				}
				?>
            </label>
			<?php
		}
		?>
        <span class="rhea_prop_search__selectwrap">
		<select name="agents[]" id="select-agent-<?php echo esc_attr( $the_widget_id ); ?>"
                class="rhea_multi_select_picker"
                data-selected-text-format="count > 2"
                data-size="<?php echo esc_attr($settings['rhea_dropdown_items_in'] ); ?>"
			<?php if('yes' == $settings['set_multiple_agents']){ ?>
                multiple
			<?php } ?>

			<?php if ( 'yes' == $settings['show_select_all'] ) { ?>
                data-actions-box="true"
			<?php } ?>
                title="<?php
		        if ( ! empty( $settings['agent_placeholder'] ) ) {
			        echo esc_attr( $settings['agent_placeholder'] );
		        } else {
			        esc_attr_e( 'Agents', 'realhomes-elementor-addon' );
		        } ?>"
                data-count-selected-text="{0} <?php echo esc_attr($settings['agent_count_placeholder'])?>"
        >
                <?php
                if ( 'no' == $settings['set_multiple_agents'] ) {
	                ?>
                    <option value="any">
                    <?php  if ( ! empty( $settings['agent_placeholder'] ) ) {
	                    echo esc_html( $settings['agent_placeholder'] );
                    } else {
	                    esc_html_e( 'All Agents', 'realhomes-elementor-addon' );
                    } ?>
                </option>
	                <?php
                }
                ?>
			<?php rhea_agents_in_search(); ?>
		</select>
	</span>

    </div>

	<?php
}