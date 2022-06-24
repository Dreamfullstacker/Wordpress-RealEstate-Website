<div class="rh_form__login">

	<form id="rh_modal__login_form" class="rh_form__form" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" enctype="multipart/form-data">

		<div class="rh_form__row">
			<div class="rh_form__item rh_form--1-column rh_form--columnAlign">
				<label class="info-text"><?php esc_html_e( 'Already a Member? Log in here.', 'framework' ); ?></label>
			</div>
			<!-- /.rh_form__item -->
		</div>
		<!-- /.rh_form__row -->

		<div class="rh_form__row">
			<div class="rh_form__item rh_form--1-column rh_form--columnAlign">
				<label for="username"><?php esc_html_e( 'Username', 'framework' ); ?><span>*</span></label>
				<input autocomplete="username" id="username" name="log" type="text" class="required" title="<?php esc_html_e( '* Provide username!', 'framework' ); ?>" autofocus required/>
			</div>
			<!-- /.rh_form__item -->
		</div>
		<!-- /.rh_form__row -->

		<div class="rh_form__row">
			<div class="rh_form__item rh_form--1-column rh_form--columnAlign">
				<label for="password"><?php esc_html_e( 'Password', 'framework' ); ?><span>*</span></label>
				<input autocomplete="current-password" id="password" name="pwd" type="password" class="required" title="<?php esc_html_e( '* Provide password!', 'framework' ); ?>" required/>
			</div>
			<!-- /.rh_form__item -->
		</div>
		<!-- /.rh_form__row -->

		<?php
		if ( class_exists( 'Easy_Real_Estate' ) ) {
			if ( ere_is_reCAPTCHA_configured() ) {
				$recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
				if ( 'v2' === $recaptcha_type ) {
					?>
                    <div class="rh_form__row">
                        <div class="rh_form__item rh_form--1-column rh_form--columnAlign">
							<?php get_template_part( 'common/google-reCAPTCHA/google-reCAPTCHA' ); ?>
                        </div>
                        <!-- /.rh_form__item -->
                    </div>
					<?php
				} else {
					get_template_part( 'common/google-reCAPTCHA/google-reCAPTCHA' );
                }
			}
		}

		// nonce for security.
		wp_nonce_field( 'inspiry-ajax-login-nonce', 'inspiry-secure-login' );
		?>
		<div class="rh_form__row">
			<div class="rh_form__item rh_input_btn_wrapper rh_form--3-column rh_form--columnAlign">
				<input type="hidden" name="action" value="inspiry_ajax_login" />
				<input type="hidden" name="redirect_to" value="<?php echo esc_url( inspiry_get_login_redirect_Url() ); ?>" />
				<input type="hidden" name="user-cookie" value="1" />
				<button type="submit" id="login-button" class="rh_btn rh_btn--primary"><?php esc_html_e( 'Login', 'framework' ); ?></button>
			</div>
			<!-- /.rh_form__item -->
		</div>
		<!-- /.rh_form__row -->

		<div class="rh_form__row">
			<div class="rh_form__item rh_form--1-column rh_form--columnAlign rh_form__response">
				<p id="login-message" class="rh_form__msg"></p>
				<p id="login-error" class="rh_form__error"></p>
			</div>
			<!-- /.rh_form__item -->
		</div>
		<!-- /.rh_form__row -->

	</form>

	<div class="rh_form__row">
		<div class="rh_form__item rh_form--1-column rh_form--columnAlign">
			<p class="forgot-password">
				<a class="toggle-forgot-form" href="#"><?php esc_html_e( 'Forgot password!', 'framework' )?></a>
			</p>
		</div>
		<!-- /.rh_form__item -->
	</div>
	<!-- /.rh_form__row -->

	<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" id="rh_modal__forgot_form"  method="post" enctype="multipart/form-data">

		<div class="rh_form__row">
			<div class="rh_form__item rh_form--1-column rh_form--columnAlign">
				<label for="reset_username_or_email"><?php esc_html_e( 'Username or Email', 'framework' ); ?><span>*</span></label>
				<input id="reset_username_or_email" name="reset_username_or_email" type="text" class="required" title="<?php esc_html_e( '* Provide username or email!', 'framework' ); ?>" required/>
			</div>
			<!-- /.rh_form__item -->
		</div>
		<!-- /.rh_form__row -->

		<?php
		if ( class_exists( 'Easy_Real_Estate' ) ) {
			if ( ere_is_reCAPTCHA_configured() ) {
				$recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
				if ( 'v2' === $recaptcha_type ) {
					?>
                    <div class="rh_form__row">
                        <div class="rh_form__item rh_form--2-column rh_form--columnAlign">
							<?php get_template_part( 'common/google-reCAPTCHA/google-reCAPTCHA' ); ?>
                        </div>
                        <!-- /.rh_form__item -->
                    </div>
					<?php
				} else {
					get_template_part( 'common/google-reCAPTCHA/google-reCAPTCHA' );
				}
			}
		}
		?>

		<?php wp_nonce_field( 'inspiry-ajax-forgot-nonce', 'inspiry-secure-reset' ); ?>

		<div class="rh_form__row">
			<div class="rh_form__item rh_input_btn_wrapper rh_form--3-column rh_form--columnAlign">
				<input type="hidden" name="action" value="inspiry_ajax_forgot" />
				<input type="hidden" name="user-cookie" value="1" />
				<input type="submit"  id="forgot-button" name="user-submit" value="<?php esc_html_e( 'Reset Password', 'framework' );?>" class="rh_btn rh_btn--secondary" />
			</div>
			<!-- /.rh_form__item -->
		</div>
		<!-- /.rh_form__row -->

		<div class="rh_form__row">
			<div class="rh_form__item rh_form--1-column rh_form--columnAlign rh_form__response">
				<p id="forgot-message" class="rh_form__msg"></p>
				<p id="forgot-error" class="rh_form__error"></p>
			</div>
			<!-- /.rh_form__item -->
		</div>
		<!-- /.rh_form__row -->

	</form>

</div>
<!-- /.rh_form__login -->