<?php
/**
 * Field: Featured
 *
 * @since    3.0.0
 * @package realhomes/dashboard
 */
?>
<p class="checkbox-field">
	<?php

		$disabled = '';
		$checked  = '';

	if ( realhomes_dashboard_edit_property() ) {
		global $post_meta_data;
		if ( isset( $post_meta_data['REAL_HOMES_featured'] ) && ( 1 == $post_meta_data['REAL_HOMES_featured'][0] ) ) {
			$checked = 'checked';
		}
	}

	// Check if inspiry memberships plugin is active.
	if ( inspiry_is_ims_plugin_activated() ) {
		// Check if membership module is enabled.
		$ims_helper_functions  = IMS_Helper_Functions();
		$is_memberships_enable = $ims_helper_functions::is_memberships();

		if ( ! empty( $is_memberships_enable ) ) {
			$current_membership = $ims_helper_functions::ims_get_membership_by_user( wp_get_current_user() );

			// Check user current featured properties.
			if ( isset( $current_membership['current_featured'] ) ) {
				if ( empty( $checked ) && intval( $current_membership['current_featured'] ) === 0 ) {
					$disabled = 'disabled';
				}
			}
		}
	}
	?>
	<input id="featured" name="featured" type="checkbox" <?php echo esc_html( $checked ) . ' ' . esc_html( $disabled ); ?> />
	<label for="featured"><?php esc_html_e( 'Mark this property as featured property', 'framework' ); ?></label>
</p>
