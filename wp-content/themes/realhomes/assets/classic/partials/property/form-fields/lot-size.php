<div class="form-option lot-size-field-wrapper">
    <label for="lot-size"><?php esc_html_e( 'Lot Size', 'framework' ); ?></label>
    <input id="lot-size" name="lot-size" type="text" value="<?php
	if ( inspiry_is_edit_property() ) {
		global $post_meta_data;
		if ( isset( $post_meta_data['REAL_HOMES_property_lot_size'] ) ) {
			echo esc_attr( $post_meta_data['REAL_HOMES_property_lot_size'][0] );
		}
	} ?>" title="<?php esc_html_e( '* Please provide the value in only digits!', 'framework' ); ?>"/>
</div>
