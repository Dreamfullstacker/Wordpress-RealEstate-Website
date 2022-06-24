/**
 * JavaScript Related to Search Form
 */
(function ($) {
	"use strict";

	/**
	 * Change Min and Max Price fields based on selected status for rent
	 */
	if ( localizedSearchParams.rent_slug !== undefined) {

		var property_status_changed = function (new_status) {
			var price_for_others = $('.advance-search-form .price-for-others');
			var price_for_rent = $('.advance-search-form .price-for-rent');
			if (price_for_others.length > 0 && price_for_rent.length > 0) {
				if (new_status == localizedSearchParams.rent_slug) {
					price_for_others.addClass('hide-fields').find('select').prop('disabled', true);
					price_for_rent.removeClass('hide-fields').find('select').prop('disabled', false);
				} else {
					price_for_rent.addClass('hide-fields').find('select').prop('disabled', true);
					price_for_others.removeClass('hide-fields').find('select').prop('disabled', false);
				}
			}
		}
		$('.advance-search-form #select-status').change(function (e) {
			var selected_status = $(this).val();
			property_status_changed(selected_status);
		});

		/* On page load ( as on search page ) */
		var selected_status = $('.advance-search-form #select-status').val();
		if (selected_status == localizedSearchParams.rent_slug) {
			property_status_changed(selected_status);
		}
	}

	/**
	 * Max and Min Price
	 * Shows red outline if min price is bigger than max price
	 */

	/* for normal prices */
	$('#select-min-price,#select-max-price').change(function (obj, e) {
		var min_text_val = $('#select-min-price').val();
		var min_int_val = (isNaN(min_text_val)) ? 0 : parseInt(min_text_val);

		var max_text_val = $('#select-max-price').val();
		var max_int_val = (isNaN(max_text_val)) ? 0 : parseInt(max_text_val);

		if ((min_int_val >= max_int_val) && (min_int_val != 0) && (max_int_val != 0)) {
			$('#select-min-price,#select-max-price').siblings('button.dropdown-toggle').css('outline', '1px solid red');
		} else {
			$('#select-min-price,#select-max-price').siblings('button.dropdown-toggle').css('outline', 'none');
		}
	});

	/* for rent prices */
	$('#select-min-price-for-rent, #select-max-price-for-rent').change(function (obj, e) {
		var min_text_val = $('#select-min-price-for-rent').val();
		var min_int_val = (isNaN(min_text_val)) ? 0 : parseInt(min_text_val);

		var max_text_val = $('#select-max-price-for-rent').val();
		var max_int_val = (isNaN(max_text_val)) ? 0 : parseInt(max_text_val);

		if ((min_int_val >= max_int_val) && (min_int_val != 0) && (max_int_val != 0)) {
			$('#select-min-price-for-rent, #select-max-price-for-rent').siblings('button.dropdown-toggle').css('outline', '1px solid red');
		} else {
			$('#select-min-price-for-rent, #select-max-price-for-rent').siblings('button.dropdown-toggle').css('outline', 'none');
		}
	});

	/**
	 * Max and Min Area
	 * To show red outline if min is bigger than max
	 */
	$('#min-area,#max-area').change(function (obj, e) {
		var min_text_val = $('#min-area').val();
		var min_int_val = (isNaN(min_text_val)) ? 0 : parseInt(min_text_val);

		var max_text_val = $('#max-area').val();
		var max_int_val = (isNaN(max_text_val)) ? 0 : parseInt(max_text_val);

		if ((min_int_val >= max_int_val) && (min_int_val != 0) && (max_int_val != 0)) {
			$('#min-area,#max-area').css('outline', '1px solid red');
		} else {
			$('#min-area,#max-area').css('outline', 'none');
		}
	});


	/**
	 * Disable empty values on submission to reduce query string size
	 */
	$('.advance-search-form').submit(function (event) {
		var searchFormElements = $(this).find(':input');
		$.each(searchFormElements, function (index, element) {
			if (element.value == '' || element.value == 'any') {
				if (!element.disabled) {
					element.disabled = true;
				}
			}
		});
	});

	/**
	 * Add to compare -- Search Page
	 */
	function removeBorder () {
		let screenWidth = $(window).width();
		let isRtl = $('body').hasClass('rtl');

		if ((979 < screenWidth && 1200 > screenWidth) || (767 >= screenWidth && 500 <= screenWidth)) {
			if (!isRtl) {
				let addToCompareSpan = $('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').length;
				if (addToCompareSpan) {
					$('.page-template-template-search .property-item .compare-meta span').css({
						'border': 'none'
					});

					$('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').css({
						'margin-right': '-20px',
						'border-left': 'none'
					});
				}
			} else {
				let addToCompareSpan = $('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').length;
				if (addToCompareSpan) {
					$('.page-template-template-search .property-item .compare-meta span').css({
						'border-left': 'none'
					});

					$('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').css({
						'margin-left': '-20px',
						'border-right': 'none',
						'float': 'left'
					});
				}
			}
		} else if (500 <= screenWidth) {
			if (!isRtl) {
				let addToCompareSpan = $('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').length;
				if (addToCompareSpan) {
					$('.page-template-template-search .property-item .compare-meta span:nth-last-child(2)').css({
						'border': 'none'
					});

					$('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').css({
						'margin-right': '-20px',
						'border-left': '1px solid #dedede'
					});
				}
			} else {
				let addToCompareSpan = $('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').length;
				if (addToCompareSpan) {
					$('.page-template-template-search .property-item .compare-meta span:nth-last-child(2)').css({
						'border': 'none'
					});

					$('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').css({
						'margin-left': '-20px',
						'border-right': '1px solid #dedede',
						'float': 'left'
					});
				}
			}
		} else {
			if (!isRtl) {
				let addToCompareSpan = $('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').length;
				if (addToCompareSpan) {
					$('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').css({
						'margin-right': '0',
						'border-left': 'none'
					});
				}
			} else {
				let addToCompareSpan = $('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').length;
				if (addToCompareSpan) {
					$('.page-template-template-search .property-item .compare-meta span.add-to-compare-span').css({
						'margin-right': '0',
						'border-left': 'none',
						'float': 'right'
					});
				}
			}
		}
	}
	removeBorder();
	/* Execute again on window resize. */
	$(window).on('resize', function () {
		removeBorder();
	});


	/**
	 * Ajax Search for keyword in Search Form
	 */
	$(document).ready(function () {
		$('#keyword-txt').keyup(function () {
			var words = $(this).val().split(' ');
			var wordcounts = words.length;
			if (wordcounts > 1) {
				$('.rh_sfoi_data_fetch_list').slideDown();
				$('.rh_sfoi_ajax_loader').show();
				$.ajax({
					url: frontEndAjaxUrl.sfoiajaxurl,
					type: 'POST',
					data: {
						action: 'rh_sfoi_data_fetch',
						keyword: $(this).val()
					},
					success: function (data) {
						$('.rh_sfoi_data_fetch_list').html(data);
						$('.rh_sfoi_ajax_loader').hide();
					}
				});
			} else {
				$('.rh_sfoi_data_fetch_list').slideUp();
			}
		});
	});

})(jQuery);
