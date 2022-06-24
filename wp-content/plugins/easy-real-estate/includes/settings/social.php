<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_show_social_menu = $this->get_option( 'theme_show_social_menu', 'true' );
$theme_facebook_link    = $this->get_option( 'theme_facebook_link' );
$theme_twitter_link     = $this->get_option( 'theme_twitter_link' );
$theme_linkedin_link    = $this->get_option( 'theme_linkedin_link' );
$theme_instagram_link   = $this->get_option( 'theme_instagram_link' );
$theme_youtube_link     = $this->get_option( 'theme_youtube_link' );
$theme_pinterest_link   = $this->get_option( 'theme_pinterest_link' );
$theme_rss_link         = $this->get_option( 'theme_rss_link' );
$theme_skype_username   = $this->get_option( 'theme_skype_username' );
$theme_line_id          = $this->get_option( 'theme_line_id' );

if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'inspiry_ere_settings' ) ) {

	// Saving RealHomes Social Login Settings.
	if ( isset( $_POST['rsl_settings'] ) ) {
		update_option( 'rsl_settings', $_POST['rsl_settings'] );
	}

	// Saving Social Profiles Settings.
	update_option( 'theme_show_social_menu', $theme_show_social_menu );
	update_option( 'theme_facebook_link', $theme_facebook_link );
	update_option( 'theme_twitter_link', $theme_twitter_link );
	update_option( 'theme_linkedin_link', $theme_linkedin_link );
	update_option( 'theme_instagram_link', $theme_instagram_link );
	update_option( 'theme_youtube_link', $theme_youtube_link );
	update_option( 'theme_pinterest_link', $theme_pinterest_link );
	update_option( 'theme_rss_link', $theme_rss_link );
	update_option( 'theme_skype_username', $theme_skype_username );
	update_option( 'theme_line_id', $theme_line_id );

	// Additional social networks
	if ( isset( $_POST['inspiry_ere_social_networks'] ) && ! empty( $_POST['inspiry_ere_social_networks'] ) ) {

		$additional_social_networks = $_POST['inspiry_ere_social_networks'];
		if( is_array( $additional_social_networks ) ){
			foreach ( $additional_social_networks as $social_network => $values ) {
				$r = array_filter( $values, 'strlen' );
				if ( empty( $r ) ) {
					unset( $additional_social_networks[ $social_network ] );
				}
			}

			$additional_social_networks = $this->sanitize_social_networks( $additional_social_networks );
			update_option( 'theme_social_networks', $additional_social_networks );
        }
	}else{
		delete_option('theme_social_networks');
    }

	$this->notice();
}
?>
<div class="inspiry-ere-page-content">
    <form method="post" action="" novalidate="novalidate">
        <table id="inspiry-ere-social-networks-table" class="form-table">
            <tbody>
            <tr>
                <th scope="row"><?php esc_html_e( 'Show or Hide Social Icons', 'easy-real-estate' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php esc_html_e( 'Show or Hide Social Icons', 'easy-real-estate' ); ?></span>
                        </legend>
                        <label>
                            <input type="radio" name="theme_show_social_menu"
                                   value="true" <?php checked( $theme_show_social_menu, 'true' ) ?>>
                            <span><?php esc_html_e( 'Show', 'easy-real-estate' ); ?></span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="theme_show_social_menu"
                                   value="false" <?php checked( $theme_show_social_menu, 'false' ) ?>>
                            <span><?php esc_html_e( 'Hide', 'easy-real-estate' ); ?></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row"><label
                            for="theme_facebook_link"><?php esc_html_e( 'Facebook URL', 'easy-real-estate' ); ?></label>
                </th>
                <td><input name="theme_facebook_link" type="url" id="theme_facebook_link"
                           value="<?php echo esc_url( $theme_facebook_link ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label
                            for="theme_twitter_link"><?php esc_html_e( 'Twitter URL', 'easy-real-estate' ); ?></label>
                </th>
                <td><input name="theme_twitter_link" type="url" id="theme_twitter_link"
                           value="<?php echo esc_url( $theme_twitter_link ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label
                            for="theme_linkedin_link"><?php esc_html_e( 'Linkedin URL', 'easy-real-estate' ); ?></label>
                </th>
                <td><input name="theme_linkedin_link" type="url" id="theme_linkedin_link"
                           value="<?php echo esc_url( $theme_linkedin_link ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="theme_instagram_link"><?php esc_html_e( 'Instagram URL', 'easy-real-estate' ); ?></label></th>
                <td><input name="theme_instagram_link" type="url" id="theme_instagram_link" value="<?php echo esc_url( $theme_instagram_link ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="theme_youtube_link"><?php esc_html_e( 'YouTube URL', 'easy-real-estate' ); ?></label></th>
                <td><input name="theme_youtube_link" type="url" id="theme_youtube_link" value="<?php echo esc_url( $theme_youtube_link ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="theme_pinterest_link"><?php esc_html_e( 'Pinterest URL', 'easy-real-estate' ); ?></label></th>
                <td><input name="theme_pinterest_link" type="url" id="theme_pinterest_link" value="<?php echo esc_url( $theme_pinterest_link ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="theme_rss_link"><?php esc_html_e( 'RSS URL', 'easy-real-estate' ); ?></label></th>
                <td><input name="theme_rss_link" type="url" id="theme_rss_link" value="<?php echo esc_url( $theme_rss_link ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="theme_skype_username"><?php esc_html_e( 'Skype Username', 'easy-real-estate' ); ?></label></th>
                <td><input name="theme_skype_username" type="text" id="theme_skype_username" value="<?php echo esc_attr( $theme_skype_username ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="realhomes_line_link"><?php esc_html_e( 'LINE ID', 'easy-real-estate' ); ?></label></th>
                <td><input name="theme_line_id" type="url" id="theme_line_id" value="<?php echo esc_attr( $theme_line_id ); ?>" class="regular-text code"></td>
            </tr>
			<?php
			$theme_social_networks  = get_option( 'theme_social_networks', array() );
			if ( is_array( $theme_social_networks ) && ! empty( $theme_social_networks ) ) :
				foreach ( $theme_social_networks as $i => $social_network ) :
					$title = $social_network['title'];
					$url   = $social_network['url'];
		            $icon  = $social_network['icon'];
		            ?>
                    <tr class="inspiry-ere-sn-tr">
                        <th scope="row">
                            <label for="inspiry-ere-sn-title-<?php echo esc_attr( $i ); ?>" class="inspiry-ere-sn-title"><?php echo esc_html( $title ); ?></label>
                            <label for="inspiry-ere-sn-title-<?php echo esc_attr( $i ); ?>" class="inspiry-ere-sn-field hide"><strong><?php esc_html_e( 'Title', 'easy-real-estate' ); ?></strong></label>
                            <input type="text" id="inspiry-ere-sn-title-<?php echo esc_attr( $i ); ?>" name="inspiry_ere_social_networks[<?php echo esc_attr( $i ); ?>][title]" value="<?php echo esc_attr( $title ); ?>" class="inspiry-ere-sn-field hide code">
                        </th>
                        <td>
                            <div>
                                <label for="inspiry-ere-sn-url-<?php echo esc_attr( $i ); ?>" class="inspiry-ere-sn-field hide"><strong><?php esc_html_e( 'Profile URL', 'easy-real-estate' ); ?></strong></label>
                                <input type="text" id="inspiry-ere-sn-url-<?php echo esc_attr( $i ); ?>" name="inspiry_ere_social_networks[<?php echo esc_attr( $i ); ?>][url]" value="<?php echo esc_attr( $url ); ?>" class="regular-text code">
                            </div>
                            <div>
                                <label for="inspiry-ere-sn-icon-<?php echo esc_attr( $i ); ?>" class="inspiry-ere-sn-field hide"><strong><?php esc_html_e( 'Icon Class', 'easy-real-estate' ); ?></strong> <small>- <em><?php esc_html_e( 'Example: fa-flicker', 'easy-real-estate' ); ?></em></small></label>
                                <input type="text" id="inspiry-ere-sn-icon-<?php echo esc_attr( $i ); ?>" name="inspiry_ere_social_networks[<?php echo esc_attr( $i ); ?>][icon]" value="<?php echo esc_attr( $icon ); ?>" class="inspiry-ere-sn-field  hide code">
                                <div class="inspiry-ere-sn-actions">
                                    <a href="#" class="inspiry-ere-edit-sn"><?php esc_html_e( 'Edit', 'easy-real-estate' ); ?></a>
                                    <a href="#" class="inspiry-ere-update-sn hide"><?php esc_html_e( 'Ok', 'easy-real-estate' ); ?></a>
                                    -
                                    <a href="#" class="inspiry-ere-remove-sn"><?php esc_html_e( 'Remove', 'easy-real-estate' ); ?></a>
                                </div>
                            </div>
                        </td>
                    </tr>
					<?php
				endforeach;
			endif;
			?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row"></th>
                    <td><a href="#" id="inspiry-ere-add-sn" class="inspiry-ere-add-sn"><?php esc_html_e( '+ Add New Social Network', 'easy-real-estate' ); ?></a></p></td>
                </tr>
            </tfoot>
        </table>

		<!-- Social Login Settings -->
		<hr>
		<table class="form-table">
		<?php $rsl_settings = get_option( 'rsl_settings' ); ?>
			<tbody>

				<tr>
					<th>
						<h2><?php esc_html_e( 'Social Login Settings', 'easy-real-estate' ); ?></h2>
					</th>
				</tr>
				<tr>
					<th>
						<h3><?php esc_html_e( 'Facebook Login', 'easy-real-estate' ); ?></h3>
					</th>
				</tr>

				<!-- Enable Facebook -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Enable Facebook', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$enable_social_login_facebook = ! empty( $rsl_settings['enable_social_login_facebook'] ) ? $rsl_settings['enable_social_login_facebook'] : '';
						?>
						<input id="rsl_settings[enable_social_login_facebook]" name="rsl_settings[enable_social_login_facebook]" type="checkbox" value="1" <?php checked( 1, $enable_social_login_facebook ); ?> />
						<label class="description" for="rsl_settings[enable_social_login_facebook]"><?php esc_html_e( 'Enable login/register with facebook on login forms.', 'easy-real-estate' ); ?></label>
					</td>
				</tr>

				<!-- Facebook App ID -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'App ID*', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$facebook_app_id = ! empty( $rsl_settings['facebook_app_id'] ) ? $rsl_settings['facebook_app_id'] : '';
						?>
						<input id="rsl_settings[facebook_app_id]" name="rsl_settings[facebook_app_id]" type="text" class="regular-text" value="<?php echo esc_attr( $facebook_app_id ); ?>"/>
						<p class="description"><label for="rsl_settings[facebook_app_id]"><?php echo sprintf( esc_html__( 'Learn how to get Facebook APP ID and Secret by %s.', 'easy-real-estate' ), '<a href="https://inspirythemes.com/realhomes-social-login-setup/#facebook-login-setup" target="_blank">clicking here</a>' ); ?></label></p>
					</td>
				</tr>

				<!-- Facebook App Secret -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'App Secret*', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$facebook_app_secret = ! empty( $rsl_settings['facebook_app_secret'] ) ? $rsl_settings['facebook_app_secret'] : '';
						?>
						<input id="rsl_settings[facebook_app_secret]" name="rsl_settings[facebook_app_secret]" type="text" class="regular-text" value="<?php echo esc_attr( $facebook_app_secret ); ?>"/>
					</td>
				</tr>

				<tr>
					<th>
						<h3><?php esc_html_e( 'Google Login', 'easy-real-estate' ); ?></h3>
					</th>
				</tr>

				<!-- Enable Google -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Enable Google', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$enable_social_login_google = ! empty( $rsl_settings['enable_social_login_google'] ) ? $rsl_settings['enable_social_login_google'] : '';
						?>
						<input id="rsl_settings[enable_social_login_google]" name="rsl_settings[enable_social_login_google]" type="checkbox" value="1" <?php checked( 1, $enable_social_login_google ); ?> />
						<label class="description" for="rsl_settings[enable_social_login_google]"><?php esc_html_e( 'Enable login/register with google on login forms.', 'easy-real-estate' ); ?></label>
					</td>
				</tr>

				<!-- Google API Key -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'API Key*', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$google_app_api_key = ! empty( $rsl_settings['google_app_api_key'] ) ? $rsl_settings['google_app_api_key'] : '';
						?>
						<input id="rsl_settings[google_app_api_key]" name="rsl_settings[google_app_api_key]" type="text" class="regular-text" value="<?php echo esc_attr( $google_app_api_key ); ?>"/>
						<p class="description"><label for="rsl_settings[google_app_api_key]"><?php echo sprintf( esc_html__( 'Learn how to get Google API Key, Client ID and Client Secret by %s.', 'easy-real-estate' ), '<a href="https://inspirythemes.com/realhomes-social-login-setup/#google-login-setup" target="_blank">clicking here</a>' ); ?></label></p>
					</td>
				</tr>

				<!-- Google Client ID -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Client ID*', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$google_app_client_id = ! empty( $rsl_settings['google_app_client_id'] ) ? $rsl_settings['google_app_client_id'] : '';
						?>
						<input id="rsl_settings[google_app_client_id]" name="rsl_settings[google_app_client_id]" type="text" class="regular-text" value="<?php echo esc_attr( $google_app_client_id ); ?>"/>
					</td>
				</tr>

				<!-- Google Client Secret -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Client Secret*', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$google_app_client_secret = ! empty( $rsl_settings['google_app_client_secret'] ) ? $rsl_settings['google_app_client_secret'] : '';
						?>
						<input id="rsl_settings[google_app_client_secret]" name="rsl_settings[google_app_client_secret]" type="text" class="regular-text" value="<?php echo esc_attr( $google_app_client_secret ); ?>"/>
					</td>
				</tr>

				<tr>
					<th>
						<h3><?php esc_html_e( 'Twitter Login', 'easy-real-estate' ); ?></h3>
					</th>
				</tr>

				<!-- Enable Twitter -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Enable Twitter', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$enable_social_login_twitter = ! empty( $rsl_settings['enable_social_login_twitter'] ) ? $rsl_settings['enable_social_login_twitter'] : '';
						?>
						<input id="rsl_settings[enable_social_login_twitter]" name="rsl_settings[enable_social_login_twitter]" type="checkbox" value="1" <?php checked( 1, $enable_social_login_twitter ); ?> />
						<label class="description" for="rsl_settings[enable_social_login_twitter]"><?php esc_html_e( 'Enable login/register with twitter on login forms.', 'easy-real-estate' ); ?></label>
					</td>
				</tr>

				<!-- Twitter App Consumer Key -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Consumer Key*', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$twitter_app_consumer_key = ! empty( $rsl_settings['twitter_app_consumer_key'] ) ? $rsl_settings['twitter_app_consumer_key'] : '';
						?>
						<input id="rsl_settings[twitter_app_consumer_key]" name="rsl_settings[twitter_app_consumer_key]" type="text" class="regular-text" value="<?php echo esc_attr( $twitter_app_consumer_key ); ?>"/>
						<p class="description"><label for="rsl_settings[twitter_app_consumer_key]"><?php echo sprintf( esc_html__( 'Learn how to get Twitter Consumer Key and Consumer Secret by %s.', 'easy-real-estate' ), '<a href="https://inspirythemes.com/realhomes-social-login-setup/#twitter-login-setup" target="_blank">clicking here</a>' ); ?></label></p>
					</td>
				</tr>

				<!-- Twitter App Consumer Secret -->
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Consumer Secret*', 'easy-real-estate' ); ?>
					</th>
					<td>
						<?php
							$twitter_app_consumer_secret = ! empty( $rsl_settings['twitter_app_consumer_secret'] ) ? $rsl_settings['twitter_app_consumer_secret'] : '';
						?>
						<input id="rsl_settings[twitter_app_consumer_secret]" name="rsl_settings[twitter_app_consumer_secret]" type="text" class="regular-text" value="<?php echo esc_attr( $twitter_app_consumer_secret ); ?>"/>
					</td>
				</tr>

			</tbody>
		</table>
			
        <div class="submit">
			<?php wp_nonce_field( 'inspiry_ere_settings' ); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'easy-real-estate' ); ?>">
        </div>
    </form>
</div>