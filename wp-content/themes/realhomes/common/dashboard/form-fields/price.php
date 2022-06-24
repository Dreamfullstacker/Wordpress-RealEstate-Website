<?php
/**
 * Field: Price
 *
 * @since 	3.0.0
 * @package realhomes/dashboard
 */
?>
<p>
	<label for="price"><?php esc_html_e( 'Sale or Rent Price', 'framework' ); ?></label>
	<input id="price" name="price" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_property_price'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_property_price'][0] );
	    }
	}
	?>" title="<?php esc_attr_e( '* Please provide the value in digits only!', 'framework' ); ?>"/>
</p>