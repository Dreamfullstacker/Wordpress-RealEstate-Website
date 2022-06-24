<?php
/**
 * Field: Area Postfix
 *
 * @since 	3.0.0
 * @package realhomes/dashboard
 */
?>
<p>
	<label for="area-postfix"><?php esc_html_e( 'Area Postfix Text', 'framework' ); ?></label>
	<input id="area-postfix" name="area-postfix" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_property_size_postfix'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_property_size_postfix'][0] );
	    }
	}
	?>" />
</p>

