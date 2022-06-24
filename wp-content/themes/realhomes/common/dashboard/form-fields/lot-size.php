<?php
/**
 * Field: Lot Size
 *
 * @since    3.9.2
 * @package realhomes/dashboard
 */

?>
<p>
    <label for="lot-size"><?php esc_html_e( 'Lot Size', 'framework' ); ?></label>
    <input id="lot-size" name="lot-size" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
		global $post_meta_data;
		if ( isset( $post_meta_data['REAL_HOMES_property_lot_size'] ) ) {
			echo esc_attr( $post_meta_data['REAL_HOMES_property_lot_size'][0] );
		}
	}
	?>" title="<?php esc_attr_e( '* Please provide the value in digits only!', 'framework' ); ?>"/>
</p>