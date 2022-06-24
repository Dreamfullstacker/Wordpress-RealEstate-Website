(function ($) {
	"use strict";
    function ereWidgetContactForm(form) {
        var $form = $(form),
            submitButton = $form.find('.submit-button'),
            loader = $form.find('.ere_widget_contact_form_loader'),
            messageContainer = $form.find('.message-container'),
            errorContainer = $form.find('.error-container'),
            formOptions = {
                beforeSubmit: function () {
                    submitButton.attr('disabled', 'disabled');
                    messageContainer.fadeOut('fast');
                    errorContainer.html('').fadeOut('fast');
                    loader.css('display', 'inline-block');
                },
                success: function (ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON(ajax_response);
                    loader.fadeOut('fast');
                    submitButton.removeAttr('disabled');
                    if (response.success) {
                        $form.resetForm();
                        messageContainer.html(response.message).fadeIn('fast');

                        // call reset function if it exists
                        if (typeof inspiryResetReCAPTCHA == 'function') {
                            inspiryResetReCAPTCHA();
                        }

                        setTimeout(function () {
                            messageContainer.html('').fadeOut('fast');
                        }, 3000);
                    } else {
                        errorContainer.html(response.message).fadeIn('fast');
                    }
                }
            };

        $form.validate({
            errorLabelContainer: errorContainer,
            submitHandler: function (form) {
                $(form).ajaxSubmit(formOptions);
            }
        });
    }

    $(window).on('load', function () {

        if (jQuery().validate && jQuery().ajaxSubmit) {
            var ereGetContactFormWidgets = $('.ere_widget_contact_form');
            if (ereGetContactFormWidgets.length) {
                $.each(ereGetContactFormWidgets, function (i, widget) {
                    var id = $(widget).attr("id");
                    ereWidgetContactForm('#' + id + ' .ere-contact-form');
                });
            }
        }

        /**
         * RealHomes Social Login
         */
        $('.rsl-provider').on('click', function(e){

            var $provider_btn = $(this);
            var $provider     = $(this).data('provider');
            var $msg_wrap     = $('.rsl-ajax-message');

            $.ajax({
                type: 'POST',
                url: ere_social_login_data.ajax_url,
                dataType: 'json',
                data: {
                    'action' : 'ere_'+ $provider +'_oauth_url'
                },
                beforeSend: function( ) {
                    $provider_btn.addClass('in-progress');
                    $msg_wrap.removeClass('error');
                    $msg_wrap.text('');
                },
                complete: function(){
                    $provider_btn.removeClass('in-progress');
                },
                success: function (response) {

                    if(response.success){
                        $msg_wrap.text(response.message);
                        window.location.replace(response.oauth_url);
                    } else {
                        $msg_wrap.addClass('error');
                        $msg_wrap.text(response.message);
                    }
                },
                error: function(error) {
                    $msg_wrap.addClass('error');
                    $msg_wrap.text(error);
                }
            });
        });
    });

    $(document).on('ready',function () {
        $('body').on('click', '.ere_pagination_wrapper a', function (e) {
            e.preventDefault();

            var thisParent = $(this).parents('.ere_ele_property_ajax_target');
            var id = $(thisParent).attr('id');
            var thisLoader = $(thisParent).find('.rhea_svg_loader');
            var thisInner = $(thisParent).find('.home-properties-section-inner-target');
            var pageNav = $(thisParent).find('.ere_pagination_wrapper a');
            var thisLink = $(this);

            if (!(thisLink).hasClass('current')) {
                var link = $(this).attr('href');
                thisInner.fadeTo('slow', 0.5);

                thisLoader.slideDown('fast');
                // thisContent.fadeOut('fast', function(){
                thisParent.load(link + ' #' + id + ' .home-properties-section-inner-target', function (response, status, xhr) {
                    if (status == 'success') {
                        thisInner.fadeTo('fast', 1);
                        pageNav.removeClass('current');
                        thisLink.addClass('current');
                        thisLoader.slideUp('fast');
                        $('html, body').animate({
                            scrollTop: $('#' + id).offset().top - 32
                        }, 1000);
                    } else {
                        thisInner.fadeTo('fast', 1);
                        thisLoader.slideUp('fast');
                    }
                });
            }
        });
    })

})(jQuery);