<?php
/**
 * Field: Garages
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_form__item rh_form--3-column rh_form--columnAlign">
	<label for="garages"><?php esc_html_e( 'Garages', 'framework' ); ?></label>
	<input id="garages" name="garages" type="text" value="<?php
	if ( inspiry_is_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_property_garage'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_property_garage'][0] );
	    }
	}
	?>" title="<?php esc_attr_e( '* Please provide the value in digits only!', 'framework' ); ?>"/>
</div>
<!-- /.rh_form__item -->
