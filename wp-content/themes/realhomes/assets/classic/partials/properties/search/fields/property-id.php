<?php
/**
 * Property ID Field
 */

$inspiry_property_id_label = get_option('inspiry_property_id_label');
$inspiry_property_id_placeholder = get_option('inspiry_property_id_placeholder_text');
?>
<div class="option-bar rh-search-field rh_classic_prop_id_field small">
	<label for="property-id-txt">
		<?php echo ( ! empty( $inspiry_property_id_label ) ) ? esc_html( $inspiry_property_id_label ) : esc_html__('Property ID', 'framework'); ?>
	</label>
	<input type="text" name="property-id" id="property-id-txt"
	       value="<?php echo isset( $_GET[ 'property-id' ] ) ? esc_attr( $_GET[ 'property-id' ] ): ''; ?>"
	       placeholder="<?php
           if ( ! empty( $inspiry_property_id_placeholder ) ) {
               echo esc_attr( $inspiry_property_id_placeholder );
           } else {
               echo esc_attr( rh_any_text() );
           } ?>" />
</div>
