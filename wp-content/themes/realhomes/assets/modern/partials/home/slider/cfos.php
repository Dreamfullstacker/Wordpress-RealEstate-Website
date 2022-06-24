<?php

$theme_contact_name_label_cfos = get_post_meta(get_the_ID(),'theme_contact_name_label_cfos',true);
$theme_contact_name_placeholder_cfos = get_post_meta(get_the_ID(),'theme_contact_name_placeholder_cfos',true);
$theme_contact_email_label_cfos = get_post_meta(get_the_ID(),'theme_contact_email_label_cfos',true);
$theme_contact_email_placeholder_cfos = get_post_meta(get_the_ID(),'theme_contact_email_placeholder_cfos',true);
$theme_contact_number_label_cfos = get_post_meta(get_the_ID(),'theme_contact_number_label_cfos',true);
$theme_contact_number_placeholder_cfos = get_post_meta(get_the_ID(),'theme_contact_number_placeholder_cfos',true);
$theme_contact_message_label_cfos = get_post_meta(get_the_ID(),'theme_contact_message_label_cfos',true);
$theme_contact_message_placeholder_cfos = get_post_meta(get_the_ID(),'theme_contact_message_placeholder_cfos',true);


$theme_contact_form_email_cfos = get_post_meta(get_the_ID(),'theme_contact_form_email_cfos',true);
$theme_contact_form_email_cc_cfos = get_post_meta(get_the_ID(),'theme_contact_form_email_cc_cfos',true);
$theme_contact_form_email_bcc_cfos = get_post_meta(get_the_ID(),'theme_contact_form_email_bcc_cfos',true);



if(!empty($theme_contact_name_label_cfos)){
	$name_label = $theme_contact_name_label_cfos;
}else{
	$name_label = __('Name','framework');
}


if(!empty($theme_contact_name_placeholder_cfos)){
	$name_placeholder = $theme_contact_name_placeholder_cfos;
}else{
	$name_placeholder = __('Your Name','framework');
}

if(!empty($theme_contact_email_label_cfos)){
	$email_label = $theme_contact_email_label_cfos;
}else{
	$email_label = __('Email','framework');
}


if(!empty($theme_contact_email_placeholder_cfos)){
	$email_placeholder = $theme_contact_email_placeholder_cfos;
}else{
	$email_placeholder = __('Your Email','framework');
}


if(!empty($theme_contact_number_label_cfos)){
	$number_label = $theme_contact_number_label_cfos;
}else{
	$number_label = __('Number','framework');
}

if(!empty($theme_contact_number_placeholder_cfos)){
	$number_placeholder = $theme_contact_number_placeholder_cfos;
}else{
	$number_placeholder = __('Your Number','framework');
}


if(!empty($theme_contact_message_label_cfos)){
	$message_label = $theme_contact_message_label_cfos;
}else{
	$message_label = __('Message','framework');
}

if(!empty($theme_contact_message_placeholder_cfos)){
	$message_placeholder = $theme_contact_message_placeholder_cfos;
}else{
	$message_placeholder = __('Tell us about desired property','framework');
}




$cfos_expand_width = '';
if (
	( inspiry_is_gdpr_enabled() && ! empty( inspiry_gdpr_agreement_content() ) ) &&
	( function_exists( 'ere_is_reCAPTCHA_configured' ) && ere_is_reCAPTCHA_configured() )
) {
	$cfos_expand_width = ' cfos_expand_width';
}

$cfos_hide_labels = '';
if (
	( inspiry_is_gdpr_enabled() && ! empty( inspiry_gdpr_agreement_content() ) ) ||
	( function_exists( 'ere_is_reCAPTCHA_configured' ) && ere_is_reCAPTCHA_configured() )
) {
	$cfos_hide_labels = ' cfos_hide_labels';
}
?>
    <div class="rh_cfos_slide_desc">
        <div class="rh_cfos_wrap <?php echo esc_attr( $cfos_expand_width . $cfos_hide_labels ); ?>">
            <div class="rh_cfos">
                <span class="cfos_phone_icon">
                    <?php inspiry_safe_include_svg( '/images/phone-cfos.svg', '/common/' ); ?>
                </span>
                  <?php if (
                          !empty(get_post_meta(get_the_ID(),'theme_contact_cta_heading_cfos',true))||
                          !empty(get_post_meta(get_the_ID(),'theme_contact_cta_description_cfos',true)) ) {
                      ?>
                      <div class="rh_cfos_labels">

		                  <?php if (!empty(get_post_meta(get_the_ID(),'theme_contact_cta_heading_cfos',true))){
			                  ?>
                              <h3 class="rh_cfos_cta_title"><?php echo esc_html(get_post_meta(get_the_ID(),'theme_contact_cta_heading_cfos',true));?></h3>
			                  <?php
		                  } ?>

		                  <?php if (!empty(get_post_meta(get_the_ID(),'theme_contact_cta_description_cfos',true))){
			                  ?>
                              <span class="rh_cfos_cta_text"><?php echo esc_html(get_post_meta(get_the_ID(),'theme_contact_cta_description_cfos',true));?></span>

			                  <?php
		                  } ?>

                      </div>
                <?php
                  }
                  ?>

                <form class="cfos_contact_form contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" autocomplete="off">


					<?php
					if (
						( inspiry_is_gdpr_enabled() && ! empty( inspiry_gdpr_agreement_content() ) ) &&
						( function_exists( 'ere_is_reCAPTCHA_configured' ) && ere_is_reCAPTCHA_configured() )
					) {
						?>
                        <div class="cfos_half cfos_field_wrapper cfos_name_field">
                            <!--					<label for="cfos-name">-->
							<?php //echo esc_html($contact_form_name_label);?><!--</label>-->
                            <input class="cfos_field required" type="text" name="name" id="cfos-name" placeholder="<?php echo esc_attr($name_placeholder); ?>" title="<?php echo esc_attr__( '* Please provide ', 'framework' ) . esc_attr($name_label); ?>">
                        </div>

                        <div class="cfos_half cfos_field_wrapper cfos_number_field">
                            <!--                    <label for="cfos-number">-->
							<?php //echo esc_html($contact_form_number_label);?><!--</label>-->
                            <input class="cfos_field" autocomplete="off" type="tel" name="cfos-number" id="cfos-number" placeholder="<?php echo esc_attr($number_placeholder)?>">
                        </div>

                        <div class="cfos_full cfos_field_wrapper cfos_email_field">
                            <!--					<label for="cfos-email">-->
							<?php //echo esc_html($contact_form_email_label);?><!--</label>-->
                            <input class="cfos_field required" type="email" name="email" id="cfos-email"
                                   placeholder="<?php echo esc_attr($email_placeholder);?>">
                        </div>
						<?php
					} else {
						?>

                        <div class="cfos_full cfos_field_wrapper cfos_name_field">
                            <label for="cfos-name"><?php echo esc_html( $name_label ); ?></label>
                            <input class="cfos_field required" type="text" name="name" id="cfos-name" placeholder="<?php echo esc_attr($name_placeholder); ?>" title="<?php echo esc_attr__( '* Please provide ', 'framework' ) . esc_attr($name_label); ?>">
                        </div>

                        <div class="cfos_full cfos_field_wrapper cfos_email_field">
                            <label for="cfos-email"><?php echo esc_html( $email_label ); ?></label>
                            <input class="cfos_field required" type="email" name="email" id="cfos-email" placeholder="<?php echo esc_attr($email_placeholder)?>" title="<?php echo esc_attr__( '* Please provide ', 'framework' ) . esc_attr($email_label); ?>">
                        </div>

                        <div class="cfos_full cfos_full_tel cfos_field_wrapper cfos_number_field">
                            <label for="cfos-number">
								<?php echo esc_html( $number_label ); ?></label>
                            <input class="cfos_field" autocomplete="off" type="tel" name="cfos-number" id="cfos-number" placeholder="<?php echo esc_attr($number_placeholder)?>">
                        </div>
						<?php
					}
					?>

                    <div class="cfos_full cfos_field_wrapper cfos_textarea_field">
                        <label for="cfos-message"><?php echo esc_html( $message_label ); ?></label>
                        <textarea cols="40" rows="6" name="message" id="cfos-message" class="cfos_text_field required"
                                  placeholder="<?php echo esc_attr( $message_placeholder); ?>"
                                  title="<?php echo esc_attr__( '* Please provide ', 'framework' ) . esc_attr( $message_label); ?>"></textarea>
                    </div>

					<?php
					if ( function_exists( 'ere_gdpr_agreement' ) ) {
						ere_gdpr_agreement( array(
							'id'              => 'inspiry-gdpr',
							'container_class' => 'cfos_field_wrapper rh_inspiry_gdpr rh_contact__input',
							'title_class'     => 'gdpr-checkbox-label'
						) );
					}

					if ( function_exists( 'ere_is_reCAPTCHA_configured' ) ) {
						/* Display reCAPTCHA if enabled and configured from customizer settings */
						if ( ere_is_reCAPTCHA_configured() ) {
							?>
                            <div class="cfos_field_wrapper cfos_recaptcha rh_contact__input rh_contact__input_recaptcha inspiry-recaptcha-wrapper clearfix">
                                <div class="inspiry-google-recaptcha"></div>
                            </div>
							<?php
						}
					}
					?>

                    <div class="cfos_btn_wrapper cfos_full rh_contact__input rh_contact__submit">
                        <input type="submit" id="submit-button" value="<?php esc_attr_e( 'Submit', 'framework' ); ?>"
                               class="cfos_submit rh_btn rh_btn--primary" name="submit">
                        <span id="ajax-loader"><?php inspiry_safe_include_svg( '/images/loader.svg' ); ?></span>

<!--                        <input type="hidden" name="target" value="--><?php //echo esc_attr( antispambot( $agent_email ) ); ?><!--">-->

                        <input type="hidden" name="action" value="send_message_cfos"/>
                        <input type="hidden" name="the_id" value="<?php echo esc_attr( get_the_ID() ); ?>"/>
<!--                        <input type="hidden" id="cfos_full_number" name="full_phone">-->
                        <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'send_cfos_message_nonce' ) ); ?>"/>
                    </div>

                    <div class="inspiry_error_messages">
                    <div id="error-container"></div>
                    <div id="message-container"></div>
                    </div>
                </form>

            </div>
        </div>
        <!-- /.rh_slide__desc -->
    </div>

<?php
$intl_script = "rhRunIntlTelInput('#cfos-number');";
wp_add_inline_script('inspiry-cfos-js',$intl_script);
?>