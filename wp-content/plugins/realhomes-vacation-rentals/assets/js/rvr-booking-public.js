(function ($) {
    "use strict";

    $(document).ready(function () {

        /**
         * Search Form date range picker (only modern).
         */
        const searchCheckIn = $('#rvr-check-in-search');
        const searchCheckOut = $('#rvr-check-out-search');

        searchCheckIn.on('click', function () {
            searchCheckOut.trigger('click');
        });

        // Setting calendar options from localized calendar names and months data.
        var localeOptions = {
            firstDay: 1
        };

        if ('undefined' !== typeof (availability_calendar_data)) {
            localeOptions.daysOfWeek = availability_calendar_data.day_name;
            localeOptions.monthNames = availability_calendar_data.month_name;
        }

        var searchPickerOptions = {
            autoApply: true,
            drops: 'down',
            opens: 'left',
            autoUpdateInput: false,
            minDate: new Date(),
            parentEl: '.rh_prop_search__form',
            locale: {
                ...localeOptions
            }
        };

        if (searchCheckIn.val() && searchCheckOut.val()) {
            searchPickerOptions.startDate = searchCheckIn.val();
            searchPickerOptions.endDate = searchCheckOut.val();
        }

        searchCheckOut.daterangepicker(searchPickerOptions, function (startDate, endDate, label) {
            // Set focus to the the check-in and check-out fields.
            searchCheckIn.parents('.rh_mod_text_field').addClass('rh_mod_text_field_focused');
            searchCheckOut.parents('.rh_mod_text_field').addClass('rh_mod_text_field_focused');

            // Setting the Check-In and Check-Out dates in their fields.
            searchCheckIn.val(startDate.format('YYYY-MM-DD'));
            searchCheckOut.val(endDate.format('YYYY-MM-DD'));
        });

        /**
         * Booking cost calculation and display handler.
         */
        $(".rvr-booking-form").each(function () {
            var $form = $(this);

            // Booking calendar fields and cost table.
            const checkIn = $form.find('.rvr-check-in');
            const checkOut = $form.find('.rvr-check-out');
            const costTable = $form.children('.booking-cost');

            // Property ID and Per night price.
            const propertyID = $form.find('.property-id').val();
            const pricePerNight = $form.find('.price-per-night').val();

            // Bulk pricing (weekly & monthly).
            var bulkPrices;
            try {
                bulkPrices = JSON.parse($form.find('.bulk-prices').val());
            } catch (error) {
                bulkPrices = {};
            }

            // Service charges and Govt. taxes & property pricing (seasonal/flat).
            const serviceCharges = parseFloat($form.find('.service-charges').val());
            const govtTax = parseFloat($form.find('.govt-charges').val());
            const propertyPricingType = $form.find('.property-pricing').val(); // Seasonal / flat.
            
            checkIn.on('click', function () {
                checkOut.trigger('click');
            });

            // Setting calendar options from localized calendar names and months data.
            var localeOptions = {
                firstDay: 1
            };

            if ('undefined' !== typeof (availability_calendar_data)) {
                localeOptions.daysOfWeek = availability_calendar_data.day_name;
                localeOptions.monthNames = availability_calendar_data.month_name;
            }

            checkOut.daterangepicker({
                autoApply: true,
                drops: 'auto',
                opens: 'left',
                autoUpdateInput: false,
                minDate: new Date(),
                locale: {
                    ...localeOptions
                },
                isInvalidDate: function (ele, funcType = 'invalidDate') {
                    var elDate = ele._d;
                    return setCalendarDateInfo(elDate, funcType);
                },
                isCustomDate: function (ele, funcType = 'customDate') {
                    var elDate = ele._d;
                    return setCalendarDateInfo(elDate, funcType);
                }
            }, async function calculateCost(startDate, endDate, flag) {

                // Setting the Check-In and Check-Out dates in their fields.
                checkIn.val(startDate.format('YYYY-MM-DD'));
                checkOut.val(endDate.format('YYYY-MM-DD'));

                // Do nothing and return if Price Per Night is not available.
                if (0 === parseInt(pricePerNight)) {
                    return;
                }

                let days = parseInt((endDate._d - startDate._d) / 1000 / 60 / 60 / 24);
                days = (days === 0) ? 1 : days; // Total days for booking.

                // Change default per night price if bulk pricing is applicable.
                var defaultPricePerNight = null;
                $.each(bulkPrices, function (key, value) {
                    if (days >= parseInt(key)) {
                        defaultPricePerNight = parseInt(value);
                    }
                });

                if (null === defaultPricePerNight) {
                    defaultPricePerNight = pricePerNight;
                }

                // Set basic cost of staying nights. Also apply seasonal pricing if applicable.
                var costStayingNights = null;
                if ('seasonal' === propertyPricingType) {
                    var fetchStayingNightsCost = {
                        type: 'post',
                        url: ajaxurl,
                        data: {
                            action: 'fetch_staying_nights_cost',
                            property_id: propertyID,
                            default_price: defaultPricePerNight,
                            check_in: startDate.format('YYYY-MM-DD'),
                            check_out: endDate.format('YYYY-MM-DD'),
                        },
                        success: function (response) {
                            costStayingNights = parseInt(response);
                        }
                    };
                    await $.ajax(fetchStayingNightsCost);
                } else {
                    costStayingNights = defaultPricePerNight * days;
                }

                // Average price per night as different per night prices are may applied.
                var avgPricePerNight = Math.round(costStayingNights / days);

                // Calculate service charges.
                var costServiceCharges = (costStayingNights * serviceCharges) / 100;
                costServiceCharges = (isNaN(costServiceCharges)) ? 0 : costServiceCharges;

                // Guests data.
                const book_child_as = $form.find('.book-child-as').val();
                const children = $form.find('select.rvr-child');
                const adults = $form.find('select.rvr-adult');
                const adultsNum = parseInt(adults.val());
                let guestsNum = 0;

                if ('adult' === book_child_as) { // Check if child needs to be booked as an adult.
                    const childrenNum = parseInt(children.val());
                    guestsNum = adultsNum + childrenNum;
                } else {
                    guestsNum = adultsNum;
                }

                const guestsCapacity = $form.find('.guests-capacity').val();
                const extraGuestsNum = ((guestsNum - guestsCapacity) > 0) ? guestsNum - guestsCapacity : 0;
                const extraGuests = $form.find('.extra-guests').val();
                const perExtraGuestPrice = parseInt($form.find('.per-extra-guest-price').val());
                var costExtraGuests = 0;

                // Extra guests cost calculation
                if ('allowed' === extraGuests && $.isNumeric(perExtraGuestPrice)) {
                    costExtraGuests = perExtraGuestPrice * (extraGuestsNum * days);
                }

                // Calculate additional fees.
                var additionalFeesFields = $form.find('.rvr-additional-fees');
                var additionalFeesAmount = 0; // Total amount of all additional fees.
                var additionalFees = []; // Array of all additional fees fields data.
                var additionalFeesPrices = []; // Array of names as keys and prices as values for the price format and then display purpose.

                // Prepare additional fees data if it's available.
                if (additionalFeesFields) {
                    // Number of guests information.
                    adults.off('change.calculation');
                    adults.on('change.calculation', function () { // Redo the calculations on adults change.
                        calculateCost(startDate, endDate, null);
                    });

                    if ('adult' === book_child_as) { // Check if child will be booked as an adult.
                        children.off('change.calculation');
                        children.on('change.calculation', function () { // Redo the calculations on children change.
                            calculateCost(startDate, endDate, null);
                        });
                    }

                    additionalFeesFields = additionalFeesFields.children(); // Assign all additional fees fields to the fields variable if exists.

                    // Loop through all additional fees fields and build an array from their data.
                    additionalFeesFields.each(function () {

                        // Fee data gathering from its field.
                        let fee = [];
                        fee['name'] = $(this).attr('name');
                        fee['label'] = $(this).data('label');
                        fee['type'] = $(this).data('type');
                        fee['calc'] = $(this).data('calculation');
                        fee['amount'] = parseInt($(this).data('amount'));

                        if ('per_stay' !== fee['calc']) {
                            switch (fee['calc']) {
                                case 'per_guest':
                                    fee['amount'] = fee['amount'] * guestsNum; // Per guest fee.
                                    break;
                                case 'per_night':
                                    fee['amount'] = fee['amount'] * days; // Per night fee.
                                    break;
                                case 'per_night_guest':
                                    fee['amount'] = fee['amount'] * (guestsNum * days); // Per guest per night fee.
                            }
                        }

                        // Apply the percentage of staying nights cost if fee type is percentage.
                        if ('percentage' === fee['type']) {
                            fee['amount'] = (costStayingNights * fee['amount']) / 100;
                        }

                        $(this).val(fee['amount']);
                        additionalFeesAmount += fee['amount']; // Add current fee to the total amount of the fees.
                        additionalFeesPrices[fee['name']] = fee['amount']; // Add to the pricing array for the price formation and display in calculation table purpose.

                        additionalFees.push(fee); // Push current fee data to the fees data array.
                    });
                }

                // Calculate sub total.
                var costSubTotal = costStayingNights + costServiceCharges + additionalFeesAmount + costExtraGuests;

                // Calculate Govt. taxes.
                var costGovtTax = (costSubTotal * govtTax) / 100;
                costGovtTax = (isNaN(costGovtTax)) ? 0 : costGovtTax;

                // Prepare total cost of current booking.
                var costTotal = costSubTotal + costGovtTax;

                // Format prices to display in the calculation table.
                $form.ajaxSubmit(
                    {
                        data: {
                            action: 'rvr_format_prices',
                            prices: {
                                avgPricePerNight,
                                costStayingNights,
                                costExtraGuests,
                                costServiceCharges,
                                ...additionalFeesPrices,
                                costGovtTax,
                                costSubTotal,
                                costTotal,
                            }
                        },
                        success: function (response) { // Set prices with their other relevant data to the calculation table and then display the table.
                            var responseJson = $.parseJSON(response);
                            var prices = responseJson.formatted_prices; // Formatted prices.

                            // Set data and values for the default booking calculation fields.
                            const snField = $form.find('.staying-nights-count-field').children('.cost-value');
                            const psnField = $form.find('.staying-nights-field').children('.cost-value');
                            const scField = $form.find('.services-charges-field').children('.cost-value');
                            const stField = $form.find('.subtotal-price-field').children('.cost-value');
                            const gtField = $form.find('.govt-tax-field').children('.cost-value');
                            const tpField = $form.find('.total-price-field').children('.cost-value');

                            snField.text(Math.round(days) + ' x ' + prices.avgPricePerNight);
                            psnField.text(prices.costStayingNights);
                            scField.text(prices.costServiceCharges);
                            stField.text(prices.costSubTotal);
                            gtField.text(prices.costGovtTax);
                            tpField.text(prices.costTotal);

                            snField.data('avg-price-per-night', Math.round(avgPricePerNight));
                            snField.data('total-nights', Math.round(days));
                            psnField.data('staying-nights', Math.round(costStayingNights));
                            scField.data('service-charges', Math.round(costServiceCharges));
                            stField.data('subtotal', Math.round(costSubTotal));
                            gtField.data('govt-tax', Math.round(costGovtTax));
                            tpField.data('total', Math.round(costTotal));

                            // Additional guest details display.
                            const egField = $form.find('.extra-guests-field');
                            if (extraGuestsNum) {
                                const egFieldVal = egField.children('.cost-value');

                                egField.css('display', 'block');
                                egField.find('span').text(extraGuestsNum);
                                egFieldVal.text(prices.costExtraGuests);
                                egFieldVal.data('extra-guests', Math.round(costExtraGuests));
                            } else {
                                egField.css('display', 'none');
                            }

                            // Set additional fees fields data and values in the calculation table.
                            if (additionalFees) {
                                additionalFees.forEach(function (field) {
                                    let feeCalcField = $form.find('.' + field['name'] + '-fee-field').children('.cost-value');
                                    feeCalcField.text(prices[field['name']]);
                                    feeCalcField.data(prices[field['name']].match(/\d/g).join(''));
                                });
                            }
                        }
                    }
                );

                costTable.slideDown('fast');
            });
        });

        // Calendar dates information setter.
        function setCalendarDateInfo(date, funcType) {

            let valid = true, invalid = false;
            if ('customDate' === funcType) {
                valid = 'reserved';
            }

            // Set reserved dates information.
            const availabilityCalendar = $('#property-availability');

            if (availabilityCalendar.length) {
                var reservedDates = availabilityCalendar.data('dates');

                if ('' != reservedDates) {
                    reservedDates = reservedDates.split(",");
                } else {
                    reservedDates = '';
                }

                let calDate = jQuery.datepicker.formatDate('yy-mm-dd', date);
                let today = jQuery.datepicker.formatDate('yy-mm-dd', new Date());

                if (calDate >= today) {
                    if (reservedDates.indexOf(calDate) != -1) {
                        return valid;
                    } else {
                        return invalid;
                    }


                } else {
                    return invalid;
                }

            } else {
                return invalid;
            }
        }

        /**
         * Show/Hide booking cost details.
         */
        $('.rvr-show-details').on('click', function (e) {
            e.preventDefault();

            const bookingCost = $(this).parents('.booking-cost');
            const bookingDetails = bookingCost.find('.booking-cost-details');
            const label = $(this).text();
            const altLabel = $(this).data('alt-label');

            $(this).data('alt-label', label);
            $(this).text(altLabel);
            bookingDetails.slideToggle('fast');
        });

        /**
         * RVR Booking Form AJAX validation and submission
         * Validation Plugin : https://jqueryvalidation.org/
         * Form Ajax Plugin : http://www.malsup.com/jquery/form/
         */
        if (jQuery().validate && jQuery().ajaxSubmit) {

            $(".rvr-booking-form").each(function () {
                var $form = $(this);

                var submitButton = $form.find('.rvr-booking-button'),
                    ajaxLoader = $form.find('.rvr-ajax-loader'),
                    messageContainer = $form.find('.rvr-message-container'),
                    errorContainer = $form.find(".rvr-error-container");

                var formOptions = {
                    beforeSubmit: function () {
                        submitButton.attr('disabled', 'disabled');
                        ajaxLoader.css('display', 'block');
                        ajaxLoader.fadeIn('fast');
                        messageContainer.fadeOut('fast');
                        errorContainer.fadeOut('fast');
                    },
                    success: function (ajaxResponse, statusText, xhr, $form) {
                        var response = JSON.parse(ajaxResponse);
                        ajaxLoader.fadeOut('fast');
                        submitButton.removeAttr('disabled');

                        if (response.checkout_url) {
                            window.location.href = response.checkout_url;
                        }
                        if (response.success) {
                            $form.resetForm();
                            $form.children('.booking-cost').slideUp('fast');

                            messageContainer.html(response.message).fadeIn('fast');

                            setTimeout(function () {
                                messageContainer.fadeOut('fast').empty();
                            }, 5000);

                            // call reset function if it exists
                            if (typeof inspiryResetReCAPTCHA == 'function') {
                                inspiryResetReCAPTCHA();
                            }

                        } else {
                            errorContainer.html(response.message).fadeIn('fast');
                        }
                    }
                };

                $form.validate({
                    submitHandler: function (form) {
                        var data = {
                            price_staying_nights: $form.find('.staying-nights-field').children('.cost-value').data('staying-nights'),
                            extra_guests: $form.find('.extra-guests-field').find('span').text(),
                            extra_guests_cost: $form.find('.extra-guests-field').children('.cost-value').data('extra-guests'),
                            services_charges: $form.find('.services-charges-field').children('.cost-value').data('service-charges'),
                            staying_nights: $form.find('.staying-nights-count-field').children('.cost-value').data('total-nights'),
                            avg_price_per_night: $form.find('.staying-nights-count-field').children('.cost-value').data('avg-price-per-night'),
                            subtotal: $form.find('.subtotal-price-field').children('.cost-value').data('subtotal'),
                            govt_tax: $form.find('.govt-tax-field').children('.cost-value').data('govt-tax'),
                            total_price: $form.find('.total-price-field').children('.cost-value').data('total'),
                        };

                        const bookingCost = {
                            data
                        };

                        $.extend(formOptions, bookingCost);
                        $(form).ajaxSubmit(formOptions);
                    }
                });
            });

        }

        /**
         * Property Availability Calendar
         */
        const availabilityCalendar = $('#property-availability');
        if (availabilityCalendar.length) {
            var reservedDates = availabilityCalendar.data('dates');

            if ('' !== reservedDates) {
                reservedDates = reservedDates.split(",");

                let calendarOptions = {
                    num_next_month: 1,
                    unavailable: reservedDates,
                    minDate: 0,
                    day_first: 1,
                };

                // Setting calendar options from localized calendar names and months data.
                if ('undefined' !== typeof (availability_calendar_data)) {
                    calendarOptions.day_name = availability_calendar_data.day_name;
                    calendarOptions.month_name = availability_calendar_data.month_name;
                }

                availabilityCalendar.calendar(calendarOptions);
            }
        }

    });

})(jQuery);