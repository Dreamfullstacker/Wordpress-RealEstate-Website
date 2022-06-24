<?php
/**
 * Settings page for the Property Analytics tab.
 *
 * @package easy_real_estate
 * @subpackage Property Analytics
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$inspiry_property_analytics_status      = $this->get_option( 'inspiry_property_analytics_status', 'disabled' );
$inspiry_property_analytics_chart_type  = $this->get_option( 'inspiry_property_analytics_chart_type', 'line' );
$inspiry_property_analytics_time_period = $this->get_option( 'inspiry_property_analytics_time_period', 14 );

if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'inspiry_ere_settings' ) ) {
	update_option( 'inspiry_property_analytics_status', $inspiry_property_analytics_status );
	update_option( 'inspiry_property_analytics_chart_type', $inspiry_property_analytics_chart_type );
	update_option( 'inspiry_property_analytics_time_period', $inspiry_property_analytics_time_period );
	$this->notice();
}
?>
<div class="inspiry-ere-page-content">
	<form method="post" action="" novalidate="novalidate">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e( 'Collect Property Analytics Data', 'easy-real-estate' ); ?></th>
					<td>
						<fieldset>
							<legend class="screen-reader-text">
								<span><?php esc_html_e( 'Enabling this option will allow the system to collect each property view from its datail page.', 'easy-real-estate' ); ?></span>
							</legend>
							<label>
								<input type="radio" name="inspiry_property_analytics_status" value="enabled" <?php checked( $inspiry_property_analytics_status, 'enabled' ); ?>>
								<span><?php esc_html_e( 'Enable', 'easy-real-estate' ); ?></span>
							</label>
							<br>
							<label>
								<input type="radio" name="inspiry_property_analytics_status" value="disabled" <?php checked( $inspiry_property_analytics_status, 'disabled' ); ?>>
								<span><?php esc_html_e( 'Disable', 'easy-real-estate' ); ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Chart Type', 'easy-real-estate' ); ?></th>
					<td>
						<fieldset>
							<label>
								<input type="radio" name="inspiry_property_analytics_chart_type" value="line" <?php checked( $inspiry_property_analytics_chart_type, 'line' ); ?>>
								<span><?php esc_html_e( 'Line', 'easy-real-estate' ); ?></span>
							</label>
							<br>
							<label>
								<input type="radio" name="inspiry_property_analytics_chart_type" value="bar" <?php checked( $inspiry_property_analytics_chart_type, 'bar' ); ?>>
								<span><?php esc_html_e( 'Bar', 'easy-real-estate' ); ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Display Property Views Of Last', 'easy-real-estate' ); ?></th>
					<td>
						<fieldset>
							<?php
								$time_period = get_option( 'inspiry_property_analytics_time_period', 14 );
							?>
							<select name="inspiry_property_analytics_time_period" id="inspiry_property_analytics_time_period">
								<option value="7" <?php selected( $time_period, 7 ); ?>>1 Week</option>
								<option value="14" <?php selected( $time_period, 14 ); ?>>2 Weeks</option>
								<option value="30" <?php selected( $time_period, 30 ); ?>>1 Month</option>
							</select>
						</fieldset>
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
