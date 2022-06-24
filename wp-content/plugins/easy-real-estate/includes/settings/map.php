<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$inspiry_google_maps_api_key     = $this->get_option( 'inspiry_google_maps_api_key' );
$theme_map_localization          = $this->get_option( 'theme_map_localization', 'true' );
$inspiry_google_maps_styles      = $this->get_option( 'inspiry_google_maps_styles' );
$theme_submit_default_address    = $this->get_option( 'theme_submit_default_address', esc_html__( '15421 Southwest 39th Terrace, Miami, FL 33185, USA', 'easy-real-estate' ) );
$theme_submit_default_location   = $this->get_option( 'theme_submit_default_location', esc_html__( '25.7308309,-80.44414899999998', 'easy-real-estate' ) );
$properties_map_default_location = $this->get_option( 'inspiry_properties_map_default_location', esc_html__( '27.664827,-81.515755', 'easy-real-estate' ) );

if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'inspiry_ere_settings' ) ) {
	update_option( 'inspiry_google_maps_api_key', $inspiry_google_maps_api_key );
	update_option( 'theme_map_localization', $theme_map_localization );
	update_option( 'inspiry_google_maps_styles', $inspiry_google_maps_styles );
	update_option( 'theme_submit_default_address', $theme_submit_default_address );
	update_option( 'theme_submit_default_location', $theme_submit_default_location );
	update_option( 'inspiry_properties_map_default_location', $properties_map_default_location );
	$this->notice();
}
?>
<div class="inspiry-ere-page-content">
    <h2 class="title"><?php esc_html_e( 'Default Map', 'easy-real-estate' ); ?></h2>
    <div class="description">
        <p><?php printf( esc_html__( 'By default, %sOpen Street Map%s will be displayed if Google Maps API key is empty.', 'easy-real-estate' ), '<strong><em>', '</em></strong>' ); ?></p>
    </div>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="inspiry_google_maps_api_key"><?php esc_html_e( 'Google Maps API Key', 'easy-real-estate' ); ?></label>
                </th>
                <td>
                    <input name="inspiry_google_maps_api_key" type="text" id="inspiry_google_maps_api_key" value="<?php echo esc_attr( $inspiry_google_maps_api_key ); ?>" class="regular-text code">
                    <p class="description"><a href="https://realhomes.io/documentation/google-maps-setup/" target="_blank"><?php esc_html_e( 'How to get Google Maps API Key?', 'easy-real-estate' ); ?></a></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e( 'Localize Google Maps', 'easy-real-estate' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php esc_html_e( 'Localize Google Maps', 'easy-real-estate' ); ?></span></legend>
                        <label>
                            <input type="radio" name="theme_map_localization" value="true" <?php checked( $theme_map_localization, 'true' ) ?>>
                            <span><?php esc_html_e( 'Yes', 'easy-real-estate' ); ?></span>
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="theme_map_localization" value="false" <?php checked( $theme_map_localization, 'false' ) ?>>
                            <span><?php esc_html_e( 'No', 'easy-real-estate' ); ?></span>
                        </label>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="inspiry_google_maps_styles"><?php esc_html_e( 'Google Maps Styles JSON (optional)', 'easy-real-estate' ); ?></label>
                </th>
                <td>
                    <textarea name="inspiry_google_maps_styles" id="inspiry_google_maps_styles" rows="6" cols="40" class="code"><?php echo stripslashes( $inspiry_google_maps_styles ); ?></textarea>
                    <p class="description"><?php printf( esc_html__( 'You can create Google Maps styles JSON using %s Google Styling Wizard %s or %s Snazzy Maps %s.', 'easy-real-estate' ), '<a href="https://mapstyle.withgoogle.com/" target="_blank">', '</a>', '<a href="https://snazzymaps.com/" target="_blank">', '</a>' ); ?></p>
                </td>
            </tr>
            <tr style="border-top: 1px solid #dddddd;">
                <th scope="row">
                    <label for="theme_submit_default_address"><?php esc_html_e( 'Default Address for New Property', 'easy-real-estate' ); ?></label>
                </th>
                <td>
                    <textarea name="theme_submit_default_address" id="theme_submit_default_address" rows="3" cols="40" class="code"><?php echo stripslashes( $theme_submit_default_address ); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="theme_submit_default_location"><?php esc_html_e( 'Default Map Location for New Property (Latitude,Longitude)', 'easy-real-estate' ); ?></label>
                </th>
                <td>
                    <input name="theme_submit_default_location" type="text" id="theme_submit_default_location" value="<?php echo esc_attr( $theme_submit_default_location ); ?>" class="regular-text code">
                    <p class="description"><?php printf( esc_html__( 'You can use %s OR %s to get Latitude and longitude of your desired location.', 'easy-real-estate' ), '<a href="http://www.latlong.net/" target="_blank">latlong.net</a>', '<a href="https://getlatlong.net/" target="_blank">getlatlong.net</a>' ); ?></p>
                </td>
            </tr>
            <tr style="border-top: 1px solid #dddddd;">
                <th scope="row">
                    <label for="inspiry_properties_map_default_location"><?php esc_html_e( 'Default Properties Map Location (Latitude,Longitude)', 'easy-real-estate' ); ?></label>
                </th>
                <td>
                    <input name="inspiry_properties_map_default_location" type="text" id="inspiry_properties_map_default_location" value="<?php echo esc_attr( $properties_map_default_location ); ?>" class="regular-text code">
                    <p class="description"><?php printf( esc_html__( 'You can use %s OR %s to get Latitude and longitude of your desired location.', 'easy-real-estate' ), '<a href="http://www.latlong.net/" target="_blank">latlong.net</a>', '<a href="https://getlatlong.net/" target="_blank">getlatlong.net</a>' ); ?></p>
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