<?php
/**
 * Field: Property ID
 *
 * Property ID field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes/modern
 */

$inspiry_property_id_label       = get_option( 'inspiry_property_id_label' );
$inspiry_property_id_placeholder = get_option( 'inspiry_property_id_placeholder_text' );
?>
<div class="rh_prop_search__option rh_mod_text_field rh_prop_id_field_wrapper">
    <label for="property-id-txt">
		<?php
		if ( $inspiry_property_id_label ) {
			echo esc_html( $inspiry_property_id_label );
		} else {
			esc_html_e( 'Property ID', 'framework' );
		}
		?>
    </label>
    <input type="text" name="property-id" autocomplete="off" id="property-id-txt"
           value="<?php echo isset( $_GET['property-id'] ) ? esc_attr( $_GET['property-id'] ) : ''; ?>"
           placeholder="<?php echo !empty( $inspiry_property_id_placeholder ) ? esc_attr( $inspiry_property_id_placeholder ) : esc_html( rh_any_text() ); ?>"/>
</div>
