<?php
/**
 * Field: Submit Button
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_form__item rh_form--3-column rh_form--columnAlign submit-field-wrapper">
	<?php
	wp_nonce_field( 'submit_property', 'property_nonce' );

	if ( inspiry_is_edit_property() ) {
	    global $target_property; ?>
		<input type="hidden" name="action" value="update_property"/>
		<input type="hidden" name="property_id" value="<?php echo esc_attr( $target_property->ID ); ?>"/>
		<input type="submit" value="<?php esc_attr_e( 'Update Property', 'framework' ); ?>" class="rh_btn rh_btn--primary" />
		<?php

	} else {
	    ?>
		<input type="hidden" name="action" value="add_property"/>
		<input type="submit" value="<?php esc_attr_e( 'Submit Property', 'framework' ); ?>" class="rh_btn rh_btn--primary" />
		<?php
	}
	?>
</div>
<!-- /.rh_form__item -->
