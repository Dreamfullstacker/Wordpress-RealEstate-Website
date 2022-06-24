<?php
/**
 * Field: Title
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_form__item rh_form--1-column rh_form--columnAlign">
	<label for="inspiry_property_title"><?php esc_html_e( 'Property Title', 'framework' ); ?></label>
	<input id="inspiry_property_title" name="inspiry_property_title" type="text" class="required" value="<?php
	if ( inspiry_is_edit_property() ) {
	    global $target_property;
	    echo esc_attr( $target_property->post_title );
	}
	?>" title="<?php esc_attr_e( '* Please provide property title!', 'framework' ); ?>" placeholder="<?php esc_attr_e( 'Enter property title', 'framework' ); ?>" autofocus required/>
</div>
<!-- /.rh_form__item -->
