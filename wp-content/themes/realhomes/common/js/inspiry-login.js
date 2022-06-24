( function( $ ) {

	"use strict";

	$( document ).ready( function() {

		var progress_bar = false;

		var rhLoginMessageBox = $('.rh_login_modal_messages');
		var rhLoginMessagesCommon = $('.rh_login_modal_messages .rh_modal__msg');

		var rhLoginModalLoader = $('.rh_modal_login_loader');

		if ( $('#rh_progress').length ) {
			progress_bar = new ProgressBar.Line('#rh_progress', {
				easing: 'easeInOut',
				color: '#1ea69a',
				strokeWidth: 0.3,
			});
		}


        // var modal_switch = $( 'div.switch' );
        // var modal_switch_link = modal_switch.find( 'a' );

        // modal_switch_link.click( function(e) {
        //
        //     e.preventDefault(); // Prevent default.
        //
        //     var switch_to   = $( this ).attr( 'data-switch' ); // Switch to modal.
        //     var target      = '';
        //
        //     if ( 'forgot' === switch_to ) {
        //
        //         var switch_parent = $( this ).parents( 'div.modal' );
        //         target = $( 'div.rh_modal__forgot_wrap' );
        //         switch_parent.slideToggle( 'slow' );
        //         target.slideToggle( 'slow' );
        //
        //     } else if ( 'register' === switch_to ) {
        //
        //         var switch_parent = $( this ).parents( 'div.modal' );
        //
        //         target = $( 'div.rh_modal__register_wrap' );
        //         switch_parent.slideToggle( 'slow' );
        //         target.slideToggle( 'slow' );
        //
        //     } else if ( 'login' === switch_to ) {
        //
        //         var switch_parent = $( this ).parents( 'div.modal' );
        //
        //         target = $( 'div.rh_modal__login_wrap' );
        //         switch_parent.slideToggle( 'slow' );
        //         target.slideToggle( 'slow' );
        //
        //     }
        // } );

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
                    rhLoginMessagesCommon.fadeOut( 50 );
                    loginButton.attr('disabled', 'disabled');
                    rhLoginModalLoader.removeClass('rh_modal_login_loader_hide');
                    // loginAjaxLoader.fadeIn( 200 );
                },
                success: function (ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON( ajax_response );
                    // loginAjaxLoader.fadeOut( 100 );
                    loginButton.removeAttr('disabled');
                    rhLoginModalLoader.addClass('rh_modal_login_loader_hide');
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


            $('#rh_modal__login_form, #login-form').validate({
                submitHandler: function (form) {
                    $(form).ajaxSubmit(loginOptions);
                }
            });


            /**
             * AJAX Register Form
             */
            var registerButton = $('#register-button'),
                registerError = $("#register-error" ),
                registerMessage = $('#register-message');


            var registerOptions = {
                beforeSubmit: function () {
	                if ( progress_bar ) {
		                progress_bar.set(0);
		                progress_bar.animate(1);
	                }
                    registerButton.attr('disabled', 'disabled');
                    rhLoginMessagesCommon.fadeOut('fast');
                    rhLoginModalLoader.removeClass('rh_modal_login_loader_hide');
                },
                success: function (ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON( ajax_response );
                    // registerAjaxLoader.fadeOut('fast');
                    registerButton.removeAttr('disabled');

                    rhLoginMessageBox.slideDown('fast');
                    rhLoginModalLoader.addClass('rh_modal_login_loader_hide');
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

            $('#rh_modal__register_form, #register-form').validate({
                rules: {
                    register_username: {
                        required: true
                    },
                    register_email: {
                        required: true,
                        email: true
                    }
                },
                submitHandler: function (form) {
                    $(form).ajaxSubmit(registerOptions);
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
                    // forgotMessage.fadeOut('fast');
                    // forgotError.fadeOut('fast');
                    rhLoginMessagesCommon.fadeOut('fast');
                    rhLoginModalLoader.removeClass('rh_modal_login_loader_hide');
                },
                success: function (ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON( ajax_response );
                    // forgotAjaxLoader.fadeOut('fast');
                    forgotButton.removeAttr('disabled');
                    rhLoginMessageBox.slideDown('fast');
                    rhLoginModalLoader.addClass('rh_modal_login_loader_hide');
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

            $('#rh_modal__forgot_form, #forgot-form').validate({
                submitHandler: function (form) {
                    $(form).ajaxSubmit(forgotOptions);
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


        /*-----------------------------------------------------------------------------------*/
        /* Login Modal
        /*-----------------------------------------------------------------------------------*/
        function rhSetLoginFormHeight(){
            var heights = $("div.rh_form_modal").map(function ()
            {
                return $(this).height();
            }).get();

            var maxHeight = Math.max.apply(null, heights);


            $('.rh_wrapper_login_forms').css('height',maxHeight);

        }

        $(window).resize(rhSetLoginFormHeight);


        $('.rh_login_target').on('click',function () {
            if(!$(this).hasClass('rh_active')){
                $('.rh_login_tab').removeClass('rh_active');
                $(this).addClass('rh_active');
                $('.rh_form_modal').slideUp(500);
                $('.rh_login_form').slideDown(500);
            }
        });

        $('.rh_register_target').on('click',function () {
            if(!$(this).hasClass('rh_active')){
                $('.rh_login_tab').removeClass('rh_active');
                $(this).addClass('rh_active');
                $('.rh_form_modal').slideUp(500);
                $('.rh_register_form').slideDown(500);
            }
        });

        $('.rh_forget_password_trigger').on('click',function () {
            $('.rh_login_tab').removeClass('rh_active');
            $('.rh_form_modal').slideUp(500);
            $('.rh_password_reset_form').slideDown(500);
        });

        var rhLoginViz = false;
        $('.rh_menu__user_profile, .rhea_menu__user_profile, .rh-user-account-profile-image .user-icon').on('click',function (e) {
            // e.preventDefault();
            $('.rh_login_modal_wrapper').css("display", "flex").hide().fadeIn(500);
            rhSetLoginFormHeight();

            rhLoginViz = true;
        });

        // A common class to ask for login where needed in the theme.
        $('.ask-for-login').on('click',function (event) {
            event.preventDefault();
            $('.rh_login_modal_wrapper').css("display", "flex").hide().fadeIn(500);
            rhSetLoginFormHeight();
            rhLoginViz = true;
        });

        $('.rh_login_close').on('click',function () {
            $('.rh_login_modal_wrapper').fadeOut(500);
            rhLoginViz = false;
            $('.rh_modal_field').val('');
        });


        $('body').on('click','.rh_login_modal_wrapper',function(e) {

            if (e.target === this){
                $(this).fadeOut(500);
                rhLoginMessageBox.slideUp('fast');
            }
        });

        $('body').on('click','.rh_login_modal_box',function(e) {
            if (e.target !== rhLoginMessageBox){
                rhLoginMessageBox.slideUp('fast');
                // rhLoginMessageBox.find('p').fadeOut('fast');
            }
        });


        $('.rh_login_close_message').on('click',function () {
            rhLoginMessageBox.slideUp('fast');
        });

	} );

} )( jQuery );
