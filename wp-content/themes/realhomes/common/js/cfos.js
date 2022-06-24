(function ($) {
    "use strict";

    $(document).ready(function () {
        /*-----------------------------------------------------------------------------------*/
        /*	Contact Form Over Slider
        /*-----------------------------------------------------------------------------------*/



        function setTelWdith() {
            var getNumberFieldWidth = $('.cfos_number_field').width();

            $('.iti__country-list').css('width', getNumberFieldWidth + 'px');
        }

        setTelWdith();

        $(window).on('resize', setTelWdith);

    });

    window.rhRunIntlTelInput =  function(cfosID) {
        var rhInputIntlInput = document.querySelector(cfosID);
        window.intlTelInput(rhInputIntlInput, {

            // onlyCountries: ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk",
            //     "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"],
            hiddenInput: "number",
            initialCountry: "auto",
            geoIpLookup: function(success, failure) {
                $.get("https://ipinfo.io", function() {}, "json").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    success(countryCode);
                });
            },
            utilsScript: inspiryUtilsPath.stylesheet_directory,
        });

    }

})(jQuery);