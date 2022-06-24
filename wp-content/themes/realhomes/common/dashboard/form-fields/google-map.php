<?php
/**
 * Google Map
 *
 * @since 	3.0.0
 * @package realhomes/dashboard
 */
if ( realhomes_dashboard_edit_property() ) {
	global $post_meta_data; ?>
	<div class="address-map-fields-wrapper">
		<?php
		$property_address = '';
	    if ( isset( $post_meta_data['REAL_HOMES_property_address'] ) && ! empty( $post_meta_data['REAL_HOMES_property_address'][0] ) ) {
	        $property_address = $post_meta_data['REAL_HOMES_property_address'][0];
	    } else {
	        $property_address = get_option( 'theme_submit_default_address' );
	    }

		$property_location = '';
		if ( isset( $post_meta_data['REAL_HOMES_property_location'] ) && ! empty( $post_meta_data['REAL_HOMES_property_location'][0] ) ) {
		    $property_location = $post_meta_data['REAL_HOMES_property_location'][0];
		} else {
		    $property_location = get_option( 'theme_submit_default_location' );
		} ?>
		<div class="map-wrapper">
            <div id="map-address-field-wrapper" class="address-wrapper">
                <label for="address"><?php esc_html_e( 'Address', 'framework' ); ?></label>
                <input type="text" class="required" name="address" id="address" value="<?php echo esc_attr( $property_address ); ?>" title="<?php esc_attr_e( '* Please provide a property address!', 'framework' ); ?>" />
                <button class="btn btn-primary goto-address-button" type="button" value="address"><?php esc_html_e( 'Find Address', 'framework' ); ?></button>
            </div>
			<div class="map-canvas"></div>
			<input type="hidden" name="coordinates" class="map-coordinate" value="<?php echo esc_attr( $property_location ); ?>" />
		</div>
	</div>
	<?php
} else {
	?>
	<div class="address-map-fields-wrapper">
		<div class="map-wrapper">
            <div id="map-address-field-wrapper" class="address-wrapper">
                <label for="address"><?php esc_html_e( 'Address', 'framework' ); ?></label>
                <input type="text" class="required map-address" name="address" id="address" value="<?php echo esc_attr( get_option( 'theme_submit_default_address' ) ); ?>" title="<?php esc_attr_e( '* Please provide a property address!', 'framework' ); ?>" />
                <button class="btn btn-primary goto-address-button" type="button" value="address"><?php esc_html_e( 'Find Address', 'framework' ); ?></button>
            </div>
            <div class="map-canvas"></div>
			<input type="hidden" name="coordinates" class="map-coordinate" value="<?php echo esc_attr( get_option( 'theme_submit_default_location' ) ); ?>" />
		</div>
	</div>
	<?php
}