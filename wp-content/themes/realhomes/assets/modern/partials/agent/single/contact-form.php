<?php
/**
 * Agent Contact Form
 *
 * Contact form for the agent.
 *
 * @since    3.0.0
 * @package realhomes/modern
 */

if ( is_singular( 'agent' ) ) {
	global $post;
	$agent_email = get_post_meta( get_the_ID(), 'REAL_HOMES_agent_email', true );
} elseif ( is_author() ) {
	global $current_author;
	$agent_email = $current_author->user_email;
}

$agent_email = is_email( $agent_email );

if ( inspiry_get_agent_custom_form() ) :
	inspiry_agent_custom_form();
elseif ( ! empty( $agent_email ) ) : ?>
	<div class="rh_agent_form">
		<form id="agent-single-form" class="" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">

			<div class="rh_agent_form__field rh_agent_form__text">
				<label for="name"><?php esc_html_e( 'Name', 'framework' ); ?></label>
				<input type="text" name="name" id="name" placeholder="<?php esc_attr_e( 'Your Name', 'framework' ); ?>" class="required" title="<?php esc_attr_e( '* Please provide your name', 'framework' ); ?>">
			</div>
			<!-- /.rh_agent_form__field rh_agent_form__text -->

			<div class="rh_agent_form__field rh_agent_form__text">
				<label for="email"><?php esc_html_e( 'Email', 'framework' ); ?></label>
				<input type="text" name="email" id="email" placeholder="<?php esc_attr_e( 'Your Email', 'framework' ); ?>" class="email required" title="<?php esc_attr_e( '* Please provide valid email address', 'framework' ); ?>">
			</div>
			<!-- /.rh_agent_form__field rh_agent_form__text -->

			<div class="rh_agent_form__field rh_agent_form__text">
				<label for="phone"><?php esc_html_e( 'Phone', 'framework' ); ?></label>
				<input type="text" name="phone" id="phone" placeholder="<?php esc_attr_e( 'Your Phone', 'framework' ); ?>" class="digits required" title="<?php esc_attr_e( '* Please provide valid phone number', 'framework' ); ?>">
			</div>
			<!-- /.rh_agent_form__field rh_agent_form__text -->

			<div class="rh_agent_form__field rh_agent_form__textarea">
				<label for="comment"><?php esc_html_e( 'Message', 'framework' ); ?></label>
				<textarea rows="6" name="message" id="comment" class="required" placeholder="<?php esc_attr_e( 'Your Message', 'framework' ); ?>" title="<?php esc_attr_e( '* Please provide your message', 'framework' ); ?>"></textarea>
			</div>
			<!-- /.rh_agent_form__field rh_agent_form__textarea -->

			<?php
			if ( function_exists( 'ere_gdpr_agreement' ) ) {
				ere_gdpr_agreement( array(
					'id'              => 'rh_inspiry_gdpr',
					'container_class' => 'rh_inspiry_gdpr',
					'title_class'     => 'gdpr-checkbox-label'
				) );
			}

			if ( class_exists( 'Easy_Real_Estate' ) ) {
				if ( ere_is_reCAPTCHA_configured() ) {
					$recaptcha_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
					?>
					<div class="inspiry-recaptcha-wrapper clearfix g-recaptcha-type-<?php echo esc_attr( $recaptcha_type ); ?>">
						<div class="inspiry-google-recaptcha"></div>
					</div>
					<?php
				}
			}
			?>

			<div class="rh_agent_form__row">
				<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'agent_message_nonce' ) ); ?>"/>
				<input type="hidden" name="target" value="<?php echo esc_attr( antispambot( $agent_email ) ); ?>">
                <input type="hidden" name="agent_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                <input type="hidden" name="action" value="send_message_to_agent"/>
				<input type="submit" id="submit-button" value="<?php esc_attr_e( 'Send Message', 'framework' ); ?>" name="submit" class="rh_btn rh_btn--primary">
				<span id="ajax-loader">
                <?php inspiry_safe_include_svg( '/images/loader.svg' ); ?>
            </span>
			</div>
			<!-- /.rh_agent_form__row -->

			<div class="rh_agent_form__row">
				<div id="error-container"></div>
				<div id="message-container"></div>
			</div>
			<!-- /.rh_agent_form__row -->

		</form>
	</div><!-- /.rh_agent_form -->
	<?php
endif;