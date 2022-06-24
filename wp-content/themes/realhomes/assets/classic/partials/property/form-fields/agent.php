<div class="form-option agent-fields-wrapper">
    <label><?php esc_html_e( 'What to display in agent information box ?', 'framework' ); ?></label>
    <div class="agent-options">
        <input id="agent_option_none" type="radio" name="agent_display_option" value="none" <?php
		if ( inspiry_is_edit_property() ) {
			global $post_meta_data;
			if ( isset( $post_meta_data['REAL_HOMES_agent_display_option'] ) && ( $post_meta_data['REAL_HOMES_agent_display_option'][0] === "none" ) ) {
				echo 'checked';
			}
		}
		?> />
        <label for="agent_option_none"><?php esc_html_e( 'None', 'framework' ); ?></label>
        <small><?php esc_html_e( '( Agent information box will not be displayed )', 'framework' ); ?></small>
        <br/>
		<?php if ( is_user_logged_in() ) : ?>
            <input id="agent_option_profile" type="radio" name="agent_display_option" value="my_profile_info" <?php
			if ( inspiry_is_edit_property() ) {
				global $post_meta_data;
				if ( isset( $post_meta_data['REAL_HOMES_agent_display_option'] ) && ( $post_meta_data['REAL_HOMES_agent_display_option'][0] === "my_profile_info" ) ) {
					echo 'checked';
				}
			}
			?> />
            <label for="agent_option_profile"><?php esc_html_e( 'My profile information', 'framework' ); ?></label>
			<?php
			$profile_url = inspiry_get_edit_profile_url();
			if ( ! empty( $profile_url ) ) {
				?>
                <small><a href="<?php echo esc_url( $profile_url ); ?>" target="_blank"><?php esc_html_e( '( Edit Profile Information )', 'framework' ); ?></a></small><?php
			} else {
				?>
                <small><a href="<?php echo network_admin_url( 'profile.php' ); ?>" target="_blank"><?php esc_html_e( '( Edit Profile Information )', 'framework' ); ?></a></small><?php
			}
			?>
            <br/>
		<?php endif; ?>
        <input id="agent_option_agent" type="radio" name="agent_display_option" value="agent_info" <?php
		if ( inspiry_is_edit_property() ) {
			global $post_meta_data;
			if ( isset( $post_meta_data['REAL_HOMES_agent_display_option'] ) && ( $post_meta_data['REAL_HOMES_agent_display_option'][0] === "agent_info" ) ) {
				echo 'checked';
			}
		}
		?> />
        <label for="agent_option_agent"><?php esc_html_e( 'Display an agent\'s information', 'framework' ); ?></label>
        <select name="agent_id[]" id="agent-selectbox"
	        <?php
	        $inspiry_search_form_multiselect_types = get_option( 'inspiry_search_form_multiselect_agents', 'yes' );

	        if ( 'yes' == $inspiry_search_form_multiselect_types ) {
		        ?>
                multiple = "multiple"
		        <?php
	        }
	        ?>
                title="<?php esc_attr_e('No Agent Selected','framework') ?>"
                class="inspiry_select_picker_trigger show-tick">
			<?php
			if ( inspiry_is_edit_property() ) {
				global $post_meta_data;
				if ( isset( $post_meta_data['REAL_HOMES_agents'][0] ) ) {
					generate_posts_list( 'agent', $post_meta_data['REAL_HOMES_agents'] );
				} else {
					generate_posts_list( 'agent' );
				}
			} else {
				generate_posts_list( 'agent' );
			}
			?>
        </select>
    </div>
</div>