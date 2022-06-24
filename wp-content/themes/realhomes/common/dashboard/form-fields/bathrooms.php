<?php
/**
 * Field: Bathrooms
 *
 * @since 	3.0.0
 * @package realhomes/dashboard
 */

?>
<p>
	<label for="bathrooms"><?php esc_html_e( 'Bathrooms', 'framework' ); ?></label>
	<input id="bathrooms" name="bathrooms" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_property_bathrooms'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_property_bathrooms'][0] );
	    }
	}
	?>" title="<?php esc_attr_e( '* Please provide the value in digits only!', 'framework' ); ?>"/>
</p>
