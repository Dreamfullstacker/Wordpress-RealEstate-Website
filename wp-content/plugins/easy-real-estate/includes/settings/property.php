<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$inspiry_auto_property_id_check   = $this->get_option( 'inspiry_auto_property_id_check', 'true' );
$inspiry_auto_property_id_pattern = $this->get_option( 'inspiry_auto_property_id_pattern', 'RH-{ID}-property' );
$inspiry_property_energy_classes  = $this->get_option( 'inspiry_property_energy_classes' );

if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'inspiry_ere_settings' ) ) {
	update_option( 'inspiry_auto_property_id_check', $inspiry_auto_property_id_check );
	update_option( 'inspiry_auto_property_id_pattern', $inspiry_auto_property_id_pattern );

	// Handling property energy classes data.
	if ( isset( $_POST['inspiry_property_energy_classes'] ) && ! empty( $_POST['inspiry_property_energy_classes'] ) ) {

		foreach ( $_POST['inspiry_property_energy_classes'] as $energy_class => $values ) {
			if ( empty( $values['name'] ) || empty( $values['color'] ) ) {
				unset( $_POST['inspiry_property_energy_classes'][ $energy_class ] );
			}
		}

		$inspiry_property_energy_classes = array_values( $_POST['inspiry_property_energy_classes'] );
		if ( is_array( $inspiry_property_energy_classes ) ) {
			update_option( 'inspiry_property_energy_classes', $inspiry_property_energy_classes );
		}
	} else {
		$inspiry_property_energy_classes = '';
		delete_option( 'inspiry_property_energy_classes' );
	}

	$this->notice();
}
?>
<div class="inspiry-ere-page-content">
	<form method="post" action="" novalidate="novalidate">
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row"><?php esc_html_e( 'Enable Auto-Generated Property ID', 'easy-real-estate' ); ?></th>
				<td>
					<fieldset>
						<label>
							<input type="radio" name="inspiry_auto_property_id_check" value="true" <?php checked( $inspiry_auto_property_id_check, 'true' ) ?>>
							<span><?php esc_html_e( 'Enable', 'easy-real-estate' ); ?></span>
						</label>
						<br>
						<label>
							<input type="radio" name="inspiry_auto_property_id_check" value="false" <?php checked( $inspiry_auto_property_id_check, 'false' ) ?>>
							<span><?php esc_html_e( 'Disable', 'easy-real-estate' ); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="inspiry_auto_property_id_pattern"><?php esc_html_e( 'Auto-Generated Property ID Pattern', 'easy-real-estate' ) ?></label>
				</th>
				<td>
					<input name="inspiry_auto_property_id_pattern" type="text" id="inspiry_auto_property_id_pattern" value="<?php echo esc_attr( $inspiry_auto_property_id_pattern ); ?>" class="regular-text code">
					<p class="description">
						<strong><?php esc_html_e( 'Important: ', 'easy-real-estate' ) ?></strong><?php esc_html_e( 'Please use {ID} in your pattern as it will be replaced by the Property ID.', 'easy-real-estate' ); ?>
					</p>
				</td>
			</tr>
			</tbody>
		</table>

		<hr>
		<!-- Energy Performance Classes Settings -->
		<div class="energy-classes-settings">
			<h2><?php esc_html_e( 'Energy Perofrmance Certificate Classes', 'easy-real-estate' ); ?></h2>
			<table class="form-table">
				<tbody>
				<tr>
					<th><?php esc_html_e( 'Class Name', 'easy-real-estate' ); ?></th>
					<th><?php esc_html_e( 'Class Color', 'easy-real-estate' ); ?></th>
					<th></th>
					<th></th>
				</tr>
				</tbody>
				<tbody class="epc-classes-sortable">
					<?php

					if ( empty( $inspiry_property_energy_classes ) ) {
						$energy_classes = ere_epc_default_fields();
					} else {
						$energy_classes = $inspiry_property_energy_classes;
					}

					foreach( $energy_classes as $index => $energy_class ) {
						?>
						<tr class="epc-class draggable">
							<td>
								<a class="reorder-epc-class" draggable="true"></a>
								<input type="text" class="class-name" name="inspiry_property_energy_classes[<?php echo $index; ?>][name]" value="<?php echo esc_attr( $energy_class['name'] ); ?>">
							</td>
							<td>
								<input type="text" class="class-color" name="inspiry_property_energy_classes[<?php echo $index; ?>][color]" value="<?php echo esc_attr( $energy_class['color'] ); ?>">
								<a class="remove-epc-class" href="#"><span class="dashicons dashicons-dismiss"></span></a>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<div class="add-epc-class-wrap">
				<a href="#" class="button button-primary add-epc-class">+ Add more</a>
			</div>
		</div>
		<div class="submit">
			<?php wp_nonce_field( 'inspiry_ere_settings' ); ?>
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'easy-real-estate' ); ?>">
		</div>
	</form>
</div>