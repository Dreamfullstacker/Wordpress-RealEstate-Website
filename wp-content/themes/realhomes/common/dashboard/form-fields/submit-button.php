<?php
/**
 * Field: Submit Button
 *
 * @since 3.0.0
 */
?>
<div id="submit-property-form-actions"  class="dashboard-form-actions">
    <button type="button" id="previous" class="btn btn-primary previous disabled"><?php esc_html_e( 'Previous', 'framework' ) ?></button>
    <button type="button" id="next" class="btn btn-primary next"><?php esc_html_e( 'Next', 'framework' ) ?></button>
	<?php
	wp_nonce_field( 'submit_property', 'property_nonce' );

	if ( realhomes_dashboard_edit_property() ) :
		global $target_property; ?>
        <input type="hidden" name="action" value="update_property"/>
        <input type="hidden" name="property_id" value="<?php echo esc_attr( $target_property->ID ); ?>"/>
        <button type="button" id="cancel" class="cancel btn btn-secondary"><?php esc_html_e( 'Cancel', 'framework' ) ?></a></button>
        <input type="submit" id="update-property-button" value="<?php esc_attr_e( 'Update Property', 'framework' ); ?>" class="btn btn-primary update-property-button"/>
	<?php
	else :
		?>
        <input type="hidden" name="action" value="add_property"/>
        <input type="submit" id="submit-property-button" value="<?php esc_attr_e( 'Submit Property', 'framework' ); ?>" class="btn btn-primary submit-property-button"/>
	<?php
	endif;
	?>
</div>