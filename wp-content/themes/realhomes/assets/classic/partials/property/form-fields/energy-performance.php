<?php
/**
 * Field: Energy Performance
 *
 * @since 3.9.5
 * @package realhomes/classic
 */

if ( inspiry_is_edit_property() ) {
	global $post_meta_data;

	if ( isset( $post_meta_data['REAL_HOMES_energy_class'] ) ) {
		$energy_class = $post_meta_data['REAL_HOMES_energy_class'][0];
	}

	if ( isset( $post_meta_data['REAL_HOMES_energy_performance'] ) ) {
		$energy_performance = $post_meta_data['REAL_HOMES_energy_performance'][0];
	}

	if ( isset( $post_meta_data['REAL_HOMES_epc_current_rating'] ) ) {
		$current_rating = $post_meta_data['REAL_HOMES_epc_current_rating'][0];
	}

	if ( isset( $post_meta_data['REAL_HOMES_epc_potential_rating'] ) ) {
		$potential_rating = $post_meta_data['REAL_HOMES_epc_potential_rating'][0];
	}
}
?>

<div class="form-option energy-class-field-wrapper">
	<label for="energy-class"><?php esc_html_e( 'Energy Class', 'framework' ); ?></label>
	<span class="selectwrap">
		<select name="energy-class" id="energy-class" class="inspiry_select_picker_trigger show-tick">
			<?php
			$selected = '-1';
			if ( ! empty( $energy_class ) ) {
				$selected = $energy_class;
			}

			$energy_classes_data = get_option( 'inspiry_property_energy_classes' );

			if ( empty( $energy_classes_data ) ) {
				$energy_classes = array(
					'none' => esc_html__( 'None', 'easy-real-estate' ),
				);

				if ( function_exists( 'ere_epc_default_fields' ) ) {
					$energy_classes_data = ere_epc_default_fields();

					if ( ! empty( $energy_classes_data ) && is_array( $energy_classes_data ) ) {
						foreach ( $energy_classes_data as $energy_class ) {
							$energy_classes[ $energy_class['name'] ] = $energy_class['name'];
						}
					}
				}
			} else {
				$energy_classes = array(
					'none' => esc_html__( 'None', 'easy-real-estate' ),
				);
				foreach ( $energy_classes_data as $class => $data ) {
					$energy_classes[ $data['name'] ] = $data['name'];
				}
			}

			foreach ( $energy_classes as $key => $value ) {
				?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php echo ( $key === $selected ) ? 'selected' : ''; ?>><?php echo esc_html( $value ); ?></option>
				<?php
			}
			?>
		</select>
	</span>
</div>

<div class="form-option energy-performance-field-wrapper">
	<label for="energy-performance"><?php esc_html_e( 'Energy Performance', 'framework' ); ?></label>
	<input id="energy-performance" name="energy-performance" type="text" value="<?php echo ( ! empty( $energy_performance ) ) ? esc_attr( $energy_performance ) : false; ?>" title="<?php esc_html_e( 'Energy Performance', 'framework' ); ?>"/>
</div>

<div class="clearfix"></div>

<div class="form-option epc-current-rating-field-wrapper">
	<label for="epc-current-rating"><?php esc_html_e( 'EPC Current Rating', 'framework' ); ?></label>
	<input id="epc-current-rating" name="epc-current-rating" type="text" value="<?php echo ( ! empty( $current_rating ) ) ? esc_attr( $current_rating ) : false; ?>" title="<?php esc_html_e( 'EPC Current Rating', 'framework' ); ?>"/>
</div>

<div class="form-option epc-potential-rating-field-wrapper">
	<label for="epc-potential-rating"><?php esc_html_e( 'EPC Potential Rating', 'framework' ); ?></label>
	<input id="epc-potential-rating" name="epc-potential-rating" type="text" value="<?php echo ( ! empty( $potential_rating ) ) ? esc_attr( $potential_rating ) : false; ?>" title="<?php esc_html_e( 'EPC Potential Rating', 'framework' ); ?>"/>
</div>
