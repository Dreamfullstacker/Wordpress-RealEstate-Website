<?php
global $settings;
global $the_widget_id;
$rhea_search_button_position = $settings['rhea_search_button_position'];

if ( 'yes' == $rhea_search_button_position ) {
	$search_button_position_class = 'rhea_search_button_at_bottom';
} else {
	$search_button_position_class = '';
}

$rhea_advance_button_animate= '';
$animate_search_button = '';
if('yes' == $settings['rhea_advance_button_animate']){
	$rhea_advance_button_animate = ' rhea-btn-primary ';
}
if('yes' == $settings['rhea_button_animate']){
	$animate_search_button = ' rhea-btn-primary ';
}
?>
<div class="rhea_search_button_wrapper rhea_button_hide  rhea_buttons_bottom <?php echo esc_attr( $search_button_position_class ); ?>">
	<?php if ( 'yes' == $settings['show_advance_fields'] ) { ?>
		<div class="rhea_advanced_expander rhea_advance_<?php echo esc_attr( $settings['rhea_default_advance_state'] . $rhea_advance_button_animate ) ?>"
		     id="advance_bottom_button_<?php echo esc_attr( $the_widget_id ); ?>">
			<?php include RHEA_ASSETS_DIR . '/icons/icon-search-plus.svg'; ?>
		</div>
	<?php } ?>
	<button class="rhea_search_form_button <?php echo esc_attr($animate_search_button)?>" type="submit">
		<?php include RHEA_ASSETS_DIR . '/icons/icon-search.svg'; ?>
		<span>
                <?php
                $inspiry_search_button_text = $settings['search_button_label'];
                if ( ! empty( $inspiry_search_button_text ) ) {
	                echo esc_html( $inspiry_search_button_text );
                } else {
	                echo esc_html__( 'Search', 'realhomes-elementor-addon' );
                }
                ?>
                    </span>
	</button>
</div>


