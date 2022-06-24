<?php
/**
 * Field: Lot Size Postfix
 *
 * @since    3.9.2
 * @package realhomes/modern
 */
?>
<div class="rh_form__item rh_form--3-column rh_form--columnAlign">
    <label for="lot-size-postfix"><?php esc_html_e( 'Lot Size Postfix Text', 'framework' ); ?></label>
    <input id="lot-size-postfix" name="lot-size-postfix" type="text" value="<?php
	if ( inspiry_is_edit_property() ) {
		global $post_meta_data;
		if ( isset( $post_meta_data['REAL_HOMES_property_lot_size_postfix'] ) ) {
			echo esc_attr( $post_meta_data['REAL_HOMES_property_lot_size_postfix'][0] );
		}
	}
	?>"/>
</div>
<!-- /.rh_form__item -->
