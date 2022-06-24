<?php
/**
 * Field: Title
 *
 * @since    3.0.0
 * @package realhomes/dashboard
 */
?>
<p>
    <label for="inspiry_property_title"><?php esc_html_e( 'Property Title', 'framework' ); ?></label>
    <input id="inspiry_property_title" name="inspiry_property_title" type="text" class="required" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
		global $target_property;
		echo esc_attr( $target_property->post_title );
	}
	?>" title="<?php esc_attr_e( '* Please provide property title', 'framework' ); ?>" autofocus required/>
</p>