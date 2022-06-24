<?php
/**
 * Field: Lot Size Postfix
 *
 * @since    3.9.2
 * @package realhomes/dashboard
 */
?>
<p>
    <label for="lot-size-postfix"><?php esc_html_e( 'Lot Size Postfix Text', 'framework' ); ?></label>
    <input id="lot-size-postfix" name="lot-size-postfix" type="text" value="<?php
	if ( realhomes_dashboard_edit_property() ) {
		global $post_meta_data;
		if ( isset( $post_meta_data['REAL_HOMES_property_lot_size_postfix'] ) ) {
			echo esc_attr( $post_meta_data['REAL_HOMES_property_lot_size_postfix'][0] );
		}
	}
	?>"/>
</p>