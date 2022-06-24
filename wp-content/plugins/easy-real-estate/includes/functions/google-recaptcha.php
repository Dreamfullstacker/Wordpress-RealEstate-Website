<?php
if ( ! function_exists( 'ere_is_reCAPTCHA_configured' ) ) {
	/**
	 * Check if Google reCAPTCHA is properly configured and enabled or not
	 *
	 * @return bool
	 */
	function ere_is_reCAPTCHA_configured() {

		$show_reCAPTCHA = get_option( 'theme_show_reCAPTCHA' );
		if ( $show_reCAPTCHA == 'true' ) {
			$reCAPTCHA_public_key  = get_option( 'theme_recaptcha_public_key' );
			$reCAPTCHA_private_key = get_option( 'theme_recaptcha_private_key' );
			if ( ! empty( $reCAPTCHA_public_key ) && ! empty( $reCAPTCHA_private_key ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'ere_reCAPTCHA_output_markup' ) ) {
	/**
	 * Output Google reCAPTCHA Divs
	 *
	 * @param string $container_class
	 */
	function ere_reCAPTCHA_output_markup( $container_class = 'inspiry-recaptcha-wrapper clearfix' ) {

		if ( ere_is_reCAPTCHA_configured() ) : ?>
			<div class="<?php echo esc_attr( $container_class ); ?>">
				<div class="inspiry-google-recaptcha"></div>
			</div>
		<?php
		endif;
	}
}

if ( ! function_exists( 'ere_output_recaptcha_js' ) ) {
	/**
	 * Output reCAPTCHA JavaScript
	 */
	function ere_output_recaptcha_js() {
		if ( ere_is_reCAPTCHA_configured() ) { ?>
			<script type="text/javascript">
                var RecaptchaOptions = {
                    theme : 'custom', custom_theme_widget : 'recaptcha_widget'
                };
			</script>
			<?php
		}
	}

	add_action( 'wp_head', 'ere_output_recaptcha_js' );
}

if ( ! function_exists( 'ere_recaptcha_callback_generator' ) ) {
	/**
	 * Generates a call back JavaScript function for reCAPTCHA
	 */
	function ere_recaptcha_callback_generator() {
		if ( ere_is_reCAPTCHA_configured() ) {
			$reCAPTCHA_public_key = get_option( 'theme_recaptcha_public_key' );
			$reCPATCHA_type       = get_option( 'inspiry_reCAPTCHA_type', 'v2' );
			?>
			<script type="text/javascript">
                var reCAPTCHAWidgetIDs = [];
                var inspirySiteKey = '<?php echo $reCAPTCHA_public_key; ?>';
                var reCAPTCHAType = '<?php echo $reCPATCHA_type; ?>';

                /**
                 * Render Google reCAPTCHA and store their widget IDs in an array
                 */
                var loadInspiryReCAPTCHA = function() {
                    jQuery( '.inspiry-google-recaptcha' ).each( function( index, el ) {
                        var tempWidgetID;
                        if ('v3' === reCAPTCHAType) {
                            tempWidgetID = grecaptcha.ready(function () {
                                grecaptcha.execute(inspirySiteKey, {action: 'homepage'}).then(function (token) {
									el.innerHTML = '';
                                    el.insertAdjacentHTML('beforeend', '<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                                });
                            });
                        } else {
                            tempWidgetID = grecaptcha.render(el, {
                                'sitekey': inspirySiteKey
                            });
                        }
                        reCAPTCHAWidgetIDs.push( tempWidgetID );
                    } );
                };

                /**
                 * For Google reCAPTCHA reset
                 */
                var inspiryResetReCAPTCHA = function() {
					if ('v3' === reCAPTCHAType) {
						loadInspiryReCAPTCHA();
					} else {
						if( typeof reCAPTCHAWidgetIDs != 'undefined' ) {
							var arrayLength = reCAPTCHAWidgetIDs.length;
							for( var i = 0; i < arrayLength; i++ ) {
								grecaptcha.reset( reCAPTCHAWidgetIDs[i] );
							}
						}
					}
                };
			</script>
			<?php
		}
	}

	add_action( 'wp_footer', 'ere_recaptcha_callback_generator' );
}

if ( ! function_exists( 'ere_verify_google_recaptcha' ) ) {
	/**
	 * This function verifies google recaptcha and echo a json array if fails
	 */
	function ere_verify_google_recaptcha() {

		/**
		 * If Google reCAPTCHA Enabled
		 */
		$show_reCAPTCHA = get_option( 'theme_show_reCAPTCHA' );
		if ( 'true' == $show_reCAPTCHA ) {

			/**
			 * Then, Verify Google reCAPTCHA
			 */
			$reCAPTCHA_public_key  = get_option( 'theme_recaptcha_public_key' );
			$reCAPTCHA_private_key = get_option( 'theme_recaptcha_private_key' );

			if ( ! empty( $reCAPTCHA_public_key ) && ! empty( $reCAPTCHA_private_key ) ) {

				// include reCAPTCHA library - https://github.com/google/recaptcha
				include_once( ERE_PLUGIN_DIR . 'includes/recaptcha/autoload.php' );

				// If the form submission includes the "g-captcha-response" field
				// Create an instance of the service using your secret
				$reCAPTCHA = new \ReCaptcha\ReCaptcha( $reCAPTCHA_private_key, new \ReCaptcha\RequestMethod\CurlPost() );

				// Make the call to verify the response and also pass the user's IP address
				$resp = $reCAPTCHA->verify( $_POST[ 'g-recaptcha-response' ], $_SERVER[ 'REMOTE_ADDR' ] );

				if ( $resp->isSuccess() ) {
					// If the response is a success, Then all is good =)
				} else {
					// reference for error codes - https://developers.google.com/recaptcha/docs/verify
					$error_messages = array(
						'missing-input-secret'   => esc_html__( 'The secret parameter is missing.', 'easy-real-estate' ),
						'invalid-input-secret'   => esc_html__( 'The secret parameter is invalid or malformed.', 'easy-real-estate' ),
						'missing-input-response' => esc_html__( 'The response parameter is missing.', 'easy-real-estate' ),
						'invalid-input-response' => esc_html__( 'The response parameter is invalid or malformed.', 'easy-real-estate' ),
						'bad-request'            => esc_html__( 'The request is invalid or malformed.', 'easy-real-estate' ),
						'timeout-or-duplicate'   => esc_html__( 'The response is no longer valid: either is too old or has been used previously.', 'easy-real-estate' ),
					);
					$error_codes         = $resp->getErrorCodes();
					$final_error_message = $error_messages[ $error_codes[ 0 ] ];
					echo json_encode( array(
						'success' => false,
						'message' => esc_html__( 'reCAPTCHA Failed:', 'easy-real-estate' ) . ' ' . $final_error_message
					) );
					die;
				}
			}
		}
	}
}