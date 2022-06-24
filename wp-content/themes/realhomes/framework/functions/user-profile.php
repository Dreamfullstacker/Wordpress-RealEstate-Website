<?php

if ( ! function_exists( 'inspiry_add_additional_user_fields_admin' ) ) {
	/**
	 * Add user custom fields on backend profile page
	 *
	 * @param $user
	 */
	function inspiry_add_additional_user_fields_admin( $user ) {
		$user_fields = apply_filters( 'inspiry_additional_user_fields', array() );
		if ( is_array( $user_fields ) && ! empty( $user_fields ) ) {
			?>
            <h3>
				<?php
				$custom_fields_heading = apply_filters( 'inspiry_user_custom_fields_backend_heading', esc_html__( 'User Additional Fields', 'framework' ) );
				echo esc_html( $custom_fields_heading );
				?>
            </h3>
            <table class="form-table user-additional-fields">
				<?php


				foreach ( $user_fields as $field ) {

					// Check if field is enabled for the Profile Backend form
					if ( empty( $field['show'] ) || ! is_array( $field['show'] ) || ! in_array( 'profile_backend', $field['show'] ) ) {
						continue;
					}

					// Validate field data and render it
					if ( ! empty( $field['id'] ) && ! empty( $field['name'] ) ) {
						?>
                        <tr>
                            <th><label for="dropdown"><?php echo esc_html( $field['name'] ); ?></label></th>
                            <td>
								<?php
								$field_value = get_the_author_meta( $field['id'], $user->ID );

								if ( ! empty( $field['type'] ) && $field['type'] == 'select' && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
									?>
                                    <select name="<?php echo esc_attr( $field['id'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>">
										<?php
										foreach ( $field['options'] as $key => $value ) {
											$selected = '';
											if ( $key == $field_value ) {
												$selected = 'selected';
											}

											echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
										}
										?>
                                    </select>
									<?php
								} else {
									?>
                                    <input
                                            type="text"
                                            id="<?php echo esc_attr( $field['id'] ); ?>"
                                            name="<?php echo esc_attr( $field['id'] ); ?>"
                                            value="<?php echo esc_attr( $field_value ); ?>"
										<?php
										echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
										?>/>
								<?php } ?>
                            </td>
                        </tr>
						<?php
					}
				}

				?>
            </table>
			<?php
		}
	}

	add_action( 'show_user_profile', 'inspiry_add_additional_user_fields_admin' );
	add_action( 'edit_user_profile', 'inspiry_add_additional_user_fields_admin' );
}

if ( ! function_exists( 'inspiry_save_additional_user_fields_admin' ) ) {
	/**
	 * Save user custom fields on backend profile page
	 *
	 * @param $user_id
	 *
	 * @return bool
	 */
	function inspiry_save_additional_user_fields_admin( $user_id ) {

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		$user_fields = apply_filters( 'inspiry_additional_user_fields', array() );
		if ( is_array( $user_fields ) && ! empty( $user_fields ) ) {
			foreach ( $user_fields as $field ) {

				// Check if field is enabled for the Profile Backend form
				if ( empty( $field['show'] ) || ! is_array( $field['show'] ) || ! in_array( 'profile_backend', $field['show'] ) ) {
					continue;
				}

				// Validate field data and save it as user meta
				if ( ! empty( $field['id'] ) && ! empty( $field['name'] ) ) {
					update_user_meta( $user_id, $field['id'], $_POST[ $field['id'] ] );
				}
			}
		}
	}

	add_action( 'personal_options_update', 'inspiry_save_additional_user_fields_admin' );
	add_action( 'edit_user_profile_update', 'inspiry_save_additional_user_fields_admin' );
}