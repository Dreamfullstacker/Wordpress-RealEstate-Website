<?php
/**
 * Field: Description
 *
 * @since 	3.0.0
 * @package realhomes/dashboard
 */
?>
<label for="description"><?php esc_attr_e( 'Property Description', 'framework' ); ?></label>
<?php
$editor_id       = 'description';
$editor_settings = array(
    'media_buttons' => false,
    'textarea_rows' => 8,
);
if ( realhomes_dashboard_edit_property() ) {
    global $target_property;
    wp_editor( $target_property->post_content, $editor_id, $editor_settings );
} else {
    wp_editor( '', $editor_id, $editor_settings );
}
?>