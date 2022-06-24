( function( $ ) {

	"use strict";

	$( document ).ready( function() {

		var progress_bar = false;

		var rhLoginMessageBox = $('.rh_login_modal_messages');

		if ( $('#rh_progress').length ) {
			progress_bar = new ProgressBar.Line('#rh_progress', {
				easing: 'easeInOut',
				color: '#1ea69a',
				strokeWidth: 0.3,
			});
		}


        var modal_switch = $( 'div.switch' );
        var modal_switch_link = modal_switch.find( 'a' );

        modal_switch_link.click( function(e) {

            e.preventDefault(); // Prevent default.

            var switch_to   = $( this ).attr( 'data-switch' ); // Switch to modal.
            var target      = '';

            if ( 'forgot' === switch_to ) {

                var switch_parent = $( this ).parents( 'div.modal' );
                target = $( 'div.rh_modal__forgot_wrap' );
                switch_parent.slideToggle( 'slow' );
                target.slideToggle( 'slow' );

            } else if ( 'register' === switch_to ) {

                var switch_parent = $( this ).parents( 'div.modal' );

                target = $( 'div.rh_modal__register_wrap' );
                switch_parent.slideToggle( 'slow' );
                target.slideToggle( 'slow' );

            } else if ( 'login' === switch_to ) {

                var switch_parent = $( this ).parents( 'div.modal' );

                target = $( 'div.rh_modal__login_wrap' );
                switch_parent.slideToggle( 'slow' );
                target.slideToggle( 'slow' );

            }
        } );

        if ( jQuery().validate && jQuery().ajaxSubmit ) {

            /**
             * AJAX Login Form
             */
            var loginButton = $('#login-button'),
                // loginAjaxLoader = $('#login-loader'),
                loginError = $("#login-error" ),
                loginMessage = $('#login-message');

            var loginOptions = {
                beforeSubmit: function () {
                	if ( progress_bar ) {
		                progress_bar.set(0);
		                progress_bar.animate(1);
	                }
                    loginMessage.fadeOut( 50 );
                    loginError.fadeOut( 50 );
                    loginButton.attr('disabled', 'disabled');
                    // loginAjaxLoader.fadeIn( 200 );
                },
                success: function (ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON( ajax_response );
                    // loginAjaxLoader.fadeOut( 100 );
                    loginButton.removeAttr('disabled');

                    rhLoginMessageBox.slideDown('fast');
                    if ( response.success ) {
                        loginMessage.html( response.message ).fadeIn( 200 );
                        if ( window.location.href == response.redirect ) {
                            window.location.reload( true );
                        } else {
                            window.location.replace( response.redirect );
                        }
                    } else {
                        loginError.html( response.message ).fadeIn( 200 );

                        // call reset function if it exists
                        if ( typeof inspiryResetReCAPTCHA == 'function' ) {
                            inspiryResetReCAPTCHA();
                        }
                    }
                }
            };


            $('#rh_modal__login_form').validate({
                submitHandler: function ( form ) {
                    $(form).ajaxSubmit( loginOptions );
                }
            } );


            /**
             * AJAX Register Form
             */
            var registerButton = $('#register-button'),
                // registerAjaxLoader = $('#register-loader'),
                registerError = $("#register-error" ),
                registerMessage = $('#register-message');


            var registerOptions = {
                beforeSubmit: function () {
	                if ( progress_bar ) {
		                progress_bar.set(0);
		                progress_bar.animate(1);
	                }
                    registerButton.attr('disabled', 'disabled');
                    // registerAjaxLoader.fadeIn('fast');
                    registerMessage.fadeOut('fast');
                    registerError.fadeOut('fast');
                },
                success: function (ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON( ajax_response );
                    // registerAjaxLoader.fadeOut('fast');
                    registerButton.removeAttr('disabled');

                    rhLoginMessageBox.slideDown('fast');
                    if ( response.success ) {
                        registerMessage.html( response.message ).fadeIn('fast');
                        $form.resetForm();

                    } else {
                        registerError.html( response.message ).fadeIn('fast');

                        // call reset function if it exists
                        if ( typeof inspiryResetReCAPTCHA == 'function' ) {
                            inspiryResetReCAPTCHA();
                        }
                    }
                }
            };

            $('#rh_modal__register_form').validate({
                rules: {
                    register_username: {
                        required: true
                    },
                    register_email: {
                        required: true,
                        email: true
                    }
                },
                submitHandler: function ( form ) {
                    $(form).ajaxSubmit( registerOptions );
                }
            });


            /**
             * Forgot Password Form
             */
            var forgotButton = $('#forgot-button'),
                // forgotAjaxLoader = $('#forgot-loader'),
                forgotError = $("#forgot-error" ),
                forgotMessage = $('#forgot-message');

            var forgotOptions = {
                beforeSubmit: function () {
	                if ( progress_bar ) {
		                progress_bar.set(0);
		                progress_bar.animate(1);
	                }
                    forgotButton.attr('disabled', 'disabled');
                    // forgotAjaxLoader.fadeIn('fast');
                    forgotMessage.fadeOut('fast');
                    forgotError.fadeOut('fast');
                },
                success: function (ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON( ajax_response );
                    // forgotAjaxLoader.fadeOut('fast');
                    forgotButton.removeAttr('disabled');

                    rhLoginMessageBox.slideDown('fast');
                    if ( response.success ) {
                        forgotMessage.html( response.message ).fadeIn('fast');
                        $form.resetForm();
                    } else {
                        forgotError.html( response.message ).fadeIn('fast');

                        // call reset function if it exists
                        if ( typeof inspiryResetReCAPTCHA == 'function' ) {
                            inspiryResetReCAPTCHA();
                        }
                    }
                }
            };

            $('#rh_modal__forgot_form').validate({
                submitHandler: function ( form ) {
                    $(form).ajaxSubmit( forgotOptions );
                }
            });
        }

        /**
         * Forgot Form
         */
        $('.rh_form #rh_modal__forgot_form').slideUp('fast');
        $('.rh_form .toggle-forgot-form').on('click', function(event){
            event.preventDefault();
            $('.rh_form #rh_modal__forgot_form').slideToggle('fast');
        });


        $('.rh_login_close_message').on('click',function () {
            rhLoginMessageBox.slideUp('fast');
        });

	} );

} )( jQuery );
