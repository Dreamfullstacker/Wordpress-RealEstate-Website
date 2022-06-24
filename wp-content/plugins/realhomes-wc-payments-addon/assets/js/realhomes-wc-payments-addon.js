(function($){
	"use strict";

	$(document).ready(function(){

		/**
		 * Package Payment.
		 */
		$('.package-woo-payment').on('click', function(event){
			event.preventDefault();

			let package_id = $(this).data('package-id');

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'rhwpa_package_woo_checkout',
                    'package_id': package_id
                },
                success: function(response) {
					response = JSON.parse(response);
					if ( response.success === true ) {
						// Redirect to the checkout page if the request is fulfilled successfully.
						window.location.href = response.checkout_url;
					} else {
						console.log( response );
					}
                }
            });
		});

		/**
		 * Property Payment
		 */
		$( '.property-woo-payment' ).on('click', function(event){
			event.preventDefault();

			let property_id = $(this).data('property-id');
			
			$.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'rhwpa_property_woo_checkout',
                    'property_id': property_id
                },
                success: function(response) {
					response = JSON.parse(response);
					if ( response.success === true ) {
						// Redirect to the checkout page if the request is fulfilled successfully.
						window.location.href = response.checkout_url;
					} else {
						console.log( response );
					}
                }
            });
		});
	});
})(jQuery);