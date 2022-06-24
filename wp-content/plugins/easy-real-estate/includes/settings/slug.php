<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$inspiry_property_slug         = $this->get_option( 'inspiry_property_slug', esc_html__( 'property', 'easy-real-estate' ) );
$inspiry_agent_slug            = $this->get_option( 'inspiry_agent_slug', esc_html__( 'agent', 'easy-real-estate' ) );
$inspiry_agency_slug           = $this->get_option( 'inspiry_agency_slug', esc_html__( 'agency', 'easy-real-estate' ) );
$inspiry_property_city_slug    = $this->get_option( 'inspiry_property_city_slug', esc_html__( 'property-location', 'easy-real-estate' ) );
$inspiry_property_status_slug  = $this->get_option( 'inspiry_property_status_slug', esc_html__( 'property-status', 'easy-real-estate' ) );
$inspiry_property_type_slug    = $this->get_option( 'inspiry_property_type_slug', esc_html__( 'property-type', 'easy-real-estate' ) );
$inspiry_property_feature_slug = $this->get_option( 'inspiry_property_feature_slug', esc_html__( 'property-feature', 'easy-real-estate' ) );

if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'inspiry_ere_settings' ) ) {
	update_option( 'inspiry_property_slug', $inspiry_property_slug );
	update_option( 'inspiry_agent_slug', $inspiry_agent_slug );
	update_option( 'inspiry_agency_slug', $inspiry_agency_slug );
	update_option( 'inspiry_property_city_slug', $inspiry_property_city_slug );
	update_option( 'inspiry_property_status_slug', $inspiry_property_status_slug );
	update_option( 'inspiry_property_type_slug', $inspiry_property_type_slug );
	update_option( 'inspiry_property_feature_slug', $inspiry_property_feature_slug );
	$this->notice();
}
?>
<div class="inspiry-ere-page-content">
    <h2 class="title"><?php esc_html_e( 'Important Note for URL Slugs', 'easy-real-estate' ); ?></h2>
    <div class="description">
        <p><?php esc_html_e( 'Make sure to re-save permalinks settings after every change in URL slugs to avoid 404 errors. You can do that from [ Settings > Permalinks ]', 'easy-real-estate' ); ?></p>
    </div>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="inspiry_property_slug"><?php esc_html_e( 'Property Slug', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_property_slug" type="text" id="inspiry_property_slug" value="<?php echo esc_attr( $inspiry_property_slug ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_agent_slug"><?php esc_html_e( 'Agent Slug', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_agent_slug" type="text" id="inspiry_agent_slug" value="<?php echo esc_attr( $inspiry_agent_slug ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_agency_slug"><?php esc_html_e( 'Agency Slug', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_agency_slug" type="text" id="inspiry_agency_slug" value="<?php echo esc_attr( $inspiry_agency_slug ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_property_city_slug"><?php esc_html_e( 'Property Location Slug', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_property_city_slug" type="text" id="inspiry_property_city_slug" value="<?php echo esc_attr( $inspiry_property_city_slug ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_property_status_slug"><?php esc_html_e( 'Property Status Slug', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_property_status_slug" type="text" id="inspiry_property_status_slug" value="<?php echo esc_attr( $inspiry_property_status_slug ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_property_type_slug"><?php esc_html_e( 'Property Type Slug', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_property_type_slug" type="text" id="inspiry_property_type_slug" value="<?php echo esc_attr( $inspiry_property_type_slug ); ?>" class="regular-text code"></td>
            </tr>
            <tr>
                <th scope="row"><label for="inspiry_property_feature_slug"><?php esc_html_e( 'Property Feature Slug', 'easy-real-estate' ); ?></label></th>
                <td><input name="inspiry_property_feature_slug" type="text" id="inspiry_property_feature_slug" value="<?php echo esc_attr( $inspiry_property_feature_slug ); ?>" class="regular-text code"></td>
            </tr>
            </tbody>
        </table>
        <div class="submit">
            <?php wp_nonce_field('inspiry_ere_settings'); ?>
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'easy-real-estate' ); ?>">
        </div>
    </form>
</div>