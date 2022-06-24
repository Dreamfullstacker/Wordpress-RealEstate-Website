<?php
/**
 * Field: Price Postfix
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_form__item rh_form--3-column rh_form--columnAlign">
	<label for="price-postfix"><?php esc_html_e( 'Price Postfix Text', 'framework' ); ?></label>
	<input id="price-postfix" name="price-postfix" type="text" value="<?php
	if ( inspiry_is_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_property_price_postfix'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_property_price_postfix'][0] );
	    }
	}
	?>"/>
</div>
<!-- /.rh_form__item -->
