<!-- LOGIN -->
<p class="info-text"><?php esc_html_e( 'Already a Member? Log in here.', 'framework' ); ?></p>
<form id="login-form" class="login-form" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" enctype="multipart/form-data">
    <div class="form-option">
        <label for="username"><?php esc_html_e( 'Username', 'framework' ); ?><span>*</span></label>
        <input autocomplete="username" id="username" name="log" type="text" class="required" title="<?php esc_html_e( '* Provide username!', 'framework' ); ?>" autofocus required/>
    </div>
    <div class="form-option">
        <label for="password"><?php esc_html_e( 'Password', 'framework' ); ?><span>*</span></label>
        <input autocomplete="current-password" id="password" name="pwd" type="password" class="required" title="<?php esc_html_e( '* Provide password!', 'framework' ); ?>" required/>
    </div>
	<?php
	if ( class_exists( 'Easy_Real_Estate' ) ) {
		if ( ere_is_reCAPTCHA_configured() ) {
			?>
            <div class="form-option">
				<?php get_template_part( 'common/google-reCAPTCHA/google-reCAPTCHA' ); ?>
            </div>
			<?php
		}
	}
	// nonce for security.
	wp_nonce_field( 'inspiry-ajax-login-nonce', 'inspiry-secure-login' );
	?>
    <input type="hidden" name="redirect_to" value="<?php echo esc_url( inspiry_get_login_redirect_Url() ); ?>"/>
    <input type="hidden" name="action" value="inspiry_ajax_login"/>
    <input type="hidden" name="user-cookie" value="1"/>
    <input type="submit" id="login-button" name="submit" value="<?php esc_attr_e( 'Log in', 'framework' ); ?>" class="real-btn login-btn"/>
    <img id="login-loader" class="modal-loader" src="<?php echo esc_attr( INSPIRY_DIR_URI ); ?>/images/ajax-loader.gif" alt="Working...">
    <div>
        <div id="login-message" class="modal-message"></div>
        <div id="login-error" class="modal-error"></div>
    </div>
</form>


<div class="inspiry-social-login">
	<?php
	/**
	 * For social login
	 */
	do_action( 'wordpress_social_login' );

	/**
	 * RealHomes Social Login.
	 */
	do_action( 'realhomes_social_login' );
	?>
</div>

<!-- FORGOT PASSWORD -->
<p class="forgot-password">
    <a class="toggle-forgot-form" href="#"><?php esc_html_e( 'Forgot password!', 'framework' ); ?></a>
</p>

<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" id="forgot-form" method="post" enctype="multipart/form-data">
    <div class="form-option">
        <label for="reset_username_or_email"><?php esc_html_e( 'Username or Email', 'framework' ); ?>
            <span>*</span></label>
        <input id="reset_username_or_email" name="reset_username_or_email" type="text" class="required" title="<?php esc_html_e( '* Provide username or email!', 'framework' ); ?>" required/>
    </div>
	<?php
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
    <input type="hidden" name="action" value="inspiry_ajax_forgot"/>
    <input type="hidden" name="user-cookie" value="1"/>
    <input type="submit" id="forgot-button" name="user-submit" value="<?php esc_html_e( 'Reset Password', 'framework' ); ?>" class="real-btn register-btn"/>
    <img id="forgot-loader" class="modal-loader" src="<?php echo esc_attr( INSPIRY_DIR_URI ); ?>/images/ajax-loader.gif" alt="Working...">
	<?php wp_nonce_field( 'inspiry-ajax-forgot-nonce', 'inspiry-secure-reset' ); ?>
    <div>
        <div id="forgot-message" class="modal-message"></div>
        <div id="forgot-error" class="modal-error"></div>
    </div>
</form>