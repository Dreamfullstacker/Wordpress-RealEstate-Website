<?php
/**
 * Field: Garages
 *
 * @since 	3.0.0
 * @package realhomes/dashboard
 */
?>
<p>
	<label for="garages"><?php esc_html_e( 'Garages or Parking Spaces', 'framework' ); ?></label>
	<input id="garages" name="garages" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_property_garage'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_property_garage'][0] );
	    }
	}
	?>" title="<?php esc_attr_e( '* Please provide the value in digits only!', 'framework' ); ?>"/>
</p>