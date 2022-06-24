<?php
if ( get_option( 'users_can_register' ) ) {
	?>
    <p class="info-text"><?php esc_html_e( 'Do not have an account? Register here', 'framework' ); ?></p>
    <form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" id="register-form" method="post" enctype="multipart/form-data">

        <div class="form-option">
            <label for="register_username" class="hide"><?php esc_html_e( 'Username', 'framework' ); ?>
                <span>*</span></label>
            <input id="register_username" name="register_username" type="text" class="required"
                   title="<?php esc_html_e( '* Provide username!', 'framework' ); ?>" required/>
        </div>
        <div class="form-option">
            <label for="register_email" class="hide"><?php esc_html_e( 'Email', 'framework' ); ?><span>*</span></label>
            <input id="register_email" name="register_email" type="text" class="email required"
                   title="<?php esc_html_e( '* Provide valid email address!', 'framework' ); ?>" required/>
        </div>
		<?php

		/**
		 * Render custom user registration fields
		 */
		$user_fields = apply_filters( 'inspiry_additional_user_fields', array() );
		if ( is_array( $user_fields ) && ! empty( $user_fields ) ) {
			foreach ( $user_fields as $field ) {

				// Check if field is enabled for the Register Form
				if ( empty( $field['show'] ) || ! is_array( $field['show'] ) || ! in_array( 'register_form', $field['show'] ) ) {
					continue;
				}

				// Validate field data and render it
				if ( ! empty( $field['id'] ) && ! empty( $field['name'] ) ) {

					$required = false;
					if ( ! empty( $field['required'] ) && $field['required'] === true ) {
						$required = true;
					}

					?>
                    <div class="form-option">
                        <label for="<?php echo esc_attr( $field['id'] ); ?>" class="hide">
							<?php
							echo esc_html( $field['name'] );
							echo ( true === $required ) ? '<span>*</span>' : '';
							?>
                        </label>
						<?php
						if ( ! empty( $field['type'] ) && $field['type'] == 'select' && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
							?>
                            <span class="selectwrap">
                                <select name="<?php echo esc_attr( $field['id'] ); ?>" id="<?php echo esc_attr( $field['id'] ); ?>"
                                <?php
                                echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
                                echo ( true === $required ) ? 'class="required inspiry_select_picker_trigger show-tick" required' : 'class="inspiry_select_picker_trigger show-tick"';
                                ?>>
                                    <?php
                                    foreach ( $field['options'] as $key => $value ) {
	                                    echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
                                    }
                                    ?>
                                </select>
                            </span>
							<?php
						} else {
							?>
                            <input
                            type="text"
                            id="<?php echo esc_attr( $field['id'] ); ?>"
                            name="<?php echo esc_attr( $field['id'] ); ?>"
							<?php
							echo ( ! empty( $field['title'] ) ) ? 'title="' . esc_attr( $field['title'] ) . '"' : '';
							echo ( true === $required ) ? 'class="required" required' : '';
							?>/><?php
						}
						?>
                    </div>
					<?php
				}
			}
		}

		$user_sync = inspiry_is_user_sync_enabled();
		if ( 'true' == $user_sync ) {
			$user_roles = inspiry_user_sync_roles();
			if ( ! empty( $user_roles ) && is_array( $user_roles ) ) {
				?>
                <div class="form-option">
                    <label for="user-role" class="hide">
						<?php esc_html_e( 'User Role', 'framework' ); ?>
                        <span>*</span>
                    </label>
                    <span class="selectwrap">
                        <select name="user_role" id="user-role" class="inspiry_select_picker_trigger show-tick">
                            <?php
                            foreach ( $user_roles as $key => $value ) {
	                            echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
                            }
                            ?>
                        </select>
                    </span>
                </div>
				<?php
			}
		}

		if ( class_exists( 'Easy_Real_Estate' ) ) {
			if ( ere_is_reCAPTCHA_configured() ) {
				?>
                <div class="form-option">
					<?php get_template_part( 'common/google-reCAPTCHA/google-reCAPTCHA' ); ?>
                </div>
				<?php
			}
		}
		?>
        <input type="hidden" name="user-cookie" value="1"/>
        <input type="submit" id="register-button" name="user-submit" value="<?php esc_html_e( 'Register', 'framework' ); ?>" class="real-btn register-btn"/>
        <img id="register-loader" class="modal-loader" src="<?php echo esc_attr( INSPIRY_DIR_URI ); ?>/images/ajax-loader.gif" alt="Working...">
        <input type="hidden" name="action" value="inspiry_ajax_register"/>
		<?php
		// Nonce for security.
		wp_nonce_field( 'inspiry-ajax-register-nonce', 'inspiry-secure-register' );
		?>
        <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/' ) ); ?>"/>

        <div>
            <div id="register-message" class="modal-message"></div>
            <div id="register-error" class="modal-error"></div>
        </div>
    </form>
	<?php
}
?>