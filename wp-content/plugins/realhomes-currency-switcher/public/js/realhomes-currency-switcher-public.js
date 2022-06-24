/**
 * All of the code for public-facing JavaScript source
 * resides in this file. 
 */
(function( $ ) {

	'use strict';

	$(document).ready(function(){
		
		var currencySwitcherList = $('ul#currency-switcher-list');
		if (currencySwitcherList.length > 0) {     // if currency switcher exists

			// Ajax request data and response handling options.
			var currencySwitcherForm = $('#currency-switcher-form');
			var currencySwitcherOptions = {
				success: function (ajax_response, statusText, xhr, $form) {
					var response = $.parseJSON(ajax_response);
					if (response.success) {
						// create a URL that clears the cache as cookies not works fine with cache.
						var clearCachedURL = '';
						var randNumber = Math.round( Math.random() * 1000000 );
						var baseURL = window.location.origin + window.location.pathname;
						// If query string exists then handle it
						if ( window.location.search ) {
							var queryString = window.location.search;
							var parameters = new URLSearchParams(queryString);
							if ( parameters.get('switch-currency') ) {
								parameters.set('switch-currency', randNumber );
								clearCachedURL = baseURL + '?' + parameters.toString();
							} else {
								clearCachedURL = baseURL + window.location.search  + '&switch-currency=' + randNumber;
							}
						} else {
							clearCachedURL = baseURL + '?switch-currency=' + randNumber;
						}
						window.location.replace( clearCachedURL );
					} else {
						console.log(response);
					}
				}
			};

			// Making an Ajax request upon selecting a currency from the list.
			$('#currency-switcher-list > li').on('click', function (event) {
				currencySwitcherList.fadeOut(200);
				$('.rh_wrapper_currency_switcher').removeClass('open');
				$('#currency-switcher').removeClass('parent_open');
				// get selected currency code
				var selectedCurrencyCode = $(this).data('currency-code');

				if (selectedCurrencyCode) {
					$('#selected-currency .currency_text').html(selectedCurrencyCode);
					$('#selected-currency i').attr('class','currency-flag currency-flag-'+ selectedCurrencyCode.toLowerCase());
					$('#switch-to-currency').val(selectedCurrencyCode);           // set new currency code
					currencySwitcherForm.ajaxSubmit(currencySwitcherOptions);    // submit ajax form to update currency code cookie
				}
			});
				
			// Currency switcher show/hide.
			$('body').on('click','#currency-switcher' ,function (e) {
				$('.rh_wrapper_currency_switcher').toggleClass('parent_open');
				$(this).toggleClass('open');
				if($(this).hasClass('open')){
					currencySwitcherList.fadeIn(200);
				}else{
					currencySwitcherList.fadeOut(200);
				}

				e.stopPropagation();
			});

			// Hidding currency switcher on outside click.
			$('html').on('click',function () {
				$('.rh_wrapper_currency_switcher').removeClass('parent_open');
				$('html #currency-switcher').removeClass('open');
				currencySwitcherList.fadeOut(200);
			});
		}
	});
})( jQuery );