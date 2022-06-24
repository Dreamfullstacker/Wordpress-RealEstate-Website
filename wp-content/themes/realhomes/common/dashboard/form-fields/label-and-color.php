<?php
$inspiry_property_label = '';
$inspiry_property_label_color = '';

if ( realhomes_dashboard_edit_property() ) {
	global $post_meta_data;

	if ( isset( $post_meta_data['inspiry_property_label'] ) ) {
		$inspiry_property_label = $post_meta_data['inspiry_property_label'][0];
	}

	if ( isset( $post_meta_data['inspiry_property_label_color'] ) ) {
		$inspiry_property_label_color = $post_meta_data['inspiry_property_label_color'][0];
	}
}
?>
<div class="col-md-6">
	<p>
		<label for="inspiry_property_label"><?php esc_html_e( 'Property Label Text', 'framework' ); ?></label>
		<input id="inspiry_property_label" name="inspiry_property_label" type="text" value="<?php echo esc_attr( $inspiry_property_label ); ?>" />
		<span class="note"><?php esc_html_e( 'You can add a property label to display on property thumbnails. Example: Hot Deal', 'framework' ); ?></span>
	</p>
</div>
<div class="col-md-6">
	<div class="field-wrap">
		<label for="inspiry_property_label_color"><?php esc_html_e( 'Label Background Color', 'framework' ); ?></label>
        <div class="dashboard-color-picker">
            <input id="inspiry_property_label_color" name="inspiry_property_label_color" type="text" value="<?php echo esc_attr( $inspiry_property_label_color ); ?>" />
        </div>
		<span class="note"><?php esc_html_e( 'Set a label background color. Otherwise label text will be displayed with transparent background.', 'framework' ); ?></span>
	</div>
</div>