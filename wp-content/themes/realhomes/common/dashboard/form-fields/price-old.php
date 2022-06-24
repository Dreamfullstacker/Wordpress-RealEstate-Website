<?php
/**
 * Field: OldPrice
 *
 * @since 	3.12
 * @package realhomes/dashboard
 */
?>
<p>
	<label for="price"><?php esc_html_e( 'Old Price', 'framework' ); ?> <span><?php esc_html_e( '( If Any )', 'framework' ); ?></span></label>
	<input id="old-price" name="old-price" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_property_old_price'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_property_old_price'][0] );
	    }
	}
	?>" title="<?php esc_attr_e( '* Please provide the value in digits only!', 'framework' ); ?>"/>
</p>