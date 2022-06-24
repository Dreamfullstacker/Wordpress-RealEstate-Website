<?php
/**
 * Field: Price Prefix
 *
 * @since 	3.12
 * @package realhomes/dashboard
 */
?>
<p>
	<label for="price-prefix"><?php esc_html_e( 'Price Prefix Text', 'framework' ); ?> <span><?php esc_html_e( 'Example: Starting Form', 'framework' ); ?></span></label>
	<input id="price-prefix" name="price-prefix" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_property_price_prefix'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_property_price_prefix'][0] );
	    }
	}
	?>"/>
</p>