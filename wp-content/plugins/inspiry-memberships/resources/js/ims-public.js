/**
 * Membership JS file.
 *
 * @since 1.0.0
 */
(function ($) {
    "use strict";

    /**
     *  Dashboard Checkout form scripts.
     */
    var dashboard_checkout_form_scripts = function (ajaxURL) {

		// Checkout form elements.
        var checkoutForm = $('#ims-checkout-form'),
            loader = checkoutForm.find('.ims-form-loader'),
            responseLog = checkoutForm.find('.checkout-form-response-log'),
            package_id = checkoutForm.find('input[name="package_id"]').val();

		// Free payment process action on related button clicked.
        var ims_process_free_membership = function () {

            var proceed_order = $.ajax({
                url: ajaxURL,
                type: "POST",
                data: {
                    checkout_form: 1,
                    membership_id: package_id,
                    action: 'ims_subscribe_membership',
                    nonce: checkoutForm.find('input[name="membership_select_nonce"]').val(),
                },
                dataType: "json"
            });

            proceed_order.done(function (response) {
                loader.hide();
                if (response.success) {
                    responseLog.text(response.message);
                    checkoutForm.find('input[name="order_id"]').val(response.order_id);
                    checkoutForm.find('#ims-submit-order').trigger('click');
                } else {
                    responseLog.addClass('error').text(response.message);
                }
            });

            proceed_order.fail(function (jqXHR, textStatus) {
                responseLog.text("Request failed: " + textStatus);
            });
        };

		// Wire transfer process action on related button clicked.
        var ims_process_bank_transfer = function () {

            var proceed_order = $.ajax({
                url: ajaxURL,
                type: "POST",
                data: {
                    checkout_form: 1,
                    membership_id: package_id,
                    action: "ims_send_wire_receipt",
                    nonce: checkoutForm.find('input[name="membership_wire_nonce"]').val(),
                },
                dataType: "json"
            });

            proceed_order.done(function (response) {
                loader.hide();
                if (response.success) {
                    responseLog.text(response.message);
                    var queryString = '&order_id=' + response.order_id + '&package_id=' + package_id + '&payment_method=direct_bank';
                    window.location.href = checkoutForm.find('input[name="redirect"]').val() + queryString;
                } else {
                    responseLog.addClass('error').text(response.message);
                }
            });

            proceed_order.fail(function (jqXHR, textStatus) {
                responseLog.text("Request failed: " + textStatus);
            });
        };

		// PayPal payment process action on related button clicked.
        var ims_process_paypal_payment = function (action) {

            var proceed_order = $.ajax({
                url: ajaxURL,
                type: "POST",
                data: {
                    checkout_form: 1,
                    membership_id: package_id,
                    action: action,
                    nonce: checkoutForm.find('input[name="membership_paypal_nonce"]').val()
                },
                dataType: "json"
            });

            proceed_order.done(function (response) {
                loader.hide();
                if (response.success) {
                    window.location.href = response.url; // Redirect to URL returned by PayPal.
                } else {
                    responseLog.addClass('error').text(response.message);
                }
            });

            proceed_order.fail(function (jqXHR, textStatus) {
                responseLog.text("Request failed: " + textStatus);
            });
        };

		// Stripe payment process action on related button clicked.
		let ims_stripe_payment_button_action  = function () {
			var checkoutButton = document.querySelector('.stripe-checkout-btn');
			
			if ( checkoutButton && 'undefined' !== typeof( Stripe ) ) {
				
				checkoutButton.addEventListener('click', event => {

				event.preventDefault();
			
				const btn_loader = document.querySelector('.ims-form-loader');
				const stripe_key = checkoutButton.dataset.key;
				const membership_id = checkoutButton.dataset.membership_id;
				const isp_nonce = checkoutButton.dataset.nonce;
				const stripe = Stripe(stripe_key);

				btn_loader.classList.add('active');
				var payment_mode = null
				if (checkoutForm.find('#ims_recurring').is(':checked')) {
					payment_mode = 'recurring';
				} else {
					payment_mode = 'one_time'
				}

				var stripe_payment_request = $.ajax({
					url: ajaxURL,
					type: "POST",
					data: {
						action : "generate_checkout_session",
						membership_id,
						isp_nonce,
						payment_mode
					},
					dataType: "json"
				});
			
				stripe_payment_request.done( function( response ) {
					stripe.redirectToCheckout({ sessionId: response.id });
				} );
			
			});
			
			} else {
				checkoutButton.addEventListener('click', event => {
					alert( 'Required Stripe library is not loaded!' );
				});	 
			}	
		}

		// Display stripe payment button content and add click event when Stripe payment method is selected.
		var ims_display_strip_payment_button = function () {

			var proceed_order = $.ajax({
				url: ajaxURL,
				type: "POST",
				data: {
					checkout_form: 1,
					membership: package_id,
					action: "ims_stripe_button",
					nonce: checkoutForm.find('input[name="membership_select_nonce"]').val()
				},
				dataType: "json"
			});

			proceed_order.done(function (response) {
				var stripeBtn = $('.ims-stripe-button');
				if (response.success) {
					let button_contents = `<button
					class="stripe-checkout-btn btn btn-primary"
					data-membership_id="${response.membership_id}"
					data-nonce="${response.isp_nonce}"
					data-key="${response.publishable_key}"
					>${response.button_label}</button>
					<span class="ims-form-loader">
						<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 128 128"><rect x="0" y="0" width="100%" height="100%" fill="#FFFFFF"></rect><g><path d="M75.4 126.63a11.43 11.43 0 0 1-2.1-22.65 40.9 40.9 0 0 0 30.5-30.6 11.4 11.4 0 1 1 22.27 4.87h.02a63.77 63.77 0 0 1-47.8 48.05v-.02a11.38 11.38 0 0 1-2.93.37z" fill="#1ea69a" fill-opacity="1"></path><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1000ms" repeatCount="indefinite"></animateTransform></g></svg>
					</span>`;
					stripeBtn.html(button_contents);
					ims_stripe_payment_button_action(); // Apply the stripe payment action to the newly added stripe button.
				} else {
					responseLog.addClass('error').text(response.message);
				}
			});

			proceed_order.fail(function (jqXHR, textStatus) {
				responseLog.text("Request failed: " + textStatus);
			});
		};

        // Process payment for selected payment method (wire transfer / paypal).
        $('#ims-btn-complete-payment').on('click', function (event) {
			
            var checkoutForm = $(this).parents('#ims-checkout-form');
            var paymentMethod = checkoutForm.find('input[name="payment_method"]:checked').val();

            loader.show();
            responseLog.removeClass('error').empty();

            if ('paypal' === paymentMethod) {
                if (checkoutForm.find('#ims_recurring').is(':checked')) {
                    ims_process_paypal_payment('ims_paypal_recurring_payment');
                } else {
                    ims_process_paypal_payment('ims_paypal_simple_payment');
                }
            } else if ('direct_bank' === paymentMethod) {
                ims_process_bank_transfer();
            }

            event.preventDefault();
        });

        // Process free subscription without any payment method.
        $('#ims-free-membership-btn').on('click', function (event) {

            loader.show();
            responseLog.removeClass('error').empty();

            // Process free subscription.
            ims_process_free_membership();

            event.preventDefault();
        });

        // Adds current class to clicked payment method.
        $('.payment-method').on('click', function () {
            $('.image-wrap').removeClass('current');
            $(this).find('.image-wrap').addClass('current');
        });

		// Update payment button based on selected payment method.
		var updateFormElements = function () {

            var form = $('#ims-checkout-form'),
                currentMethod = form.find('input[name="payment_method"]:checked').val(),
                recurringPaymentsWrap = form.find('#ims-recurring-wrap'),
                btnWrap = form.find('.ims-btn-inner-wrap'),
                stripeBtn = form.find('.ims-stripe-button');

            responseLog.empty();

            if ('direct_bank' !== currentMethod) {
                recurringPaymentsWrap.removeClass('hide');
            } else {
                recurringPaymentsWrap.addClass('hide');
            }

            if ('stripe' === currentMethod) {
                btnWrap.addClass('hide');
                stripeBtn.removeClass('hide');

                // Add strip payment button
                ims_display_strip_payment_button();
            } else {
                btnWrap.removeClass('hide');
                stripeBtn.addClass('hide').empty();
            }
        };

		// Change form elements based on payment method change.
        updateFormElements();
        $('#payment-methods').on('change', updateFormElements);
    };

    var removeQueryStringParameters = function (url) {
        if (url.indexOf('?') >= 0) {
            var urlParts = url.split('?');
            return urlParts[0];
        }
        return url;
    };

    $(document).ready(function () {
        if (typeof jsData !== "undefined") {
            var ajaxURL = removeQueryStringParameters(jsData.ajaxURL);
            dashboard_checkout_form_scripts(ajaxURL);
        }
    });
})(jQuery);
