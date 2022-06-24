(function ($) {
    "use strict";

    $(document).ready(function () {

        /*-----------------------------------------------------------------*/
        /* Language Switcher
        /*-----------------------------------------------------------------*/
        $('body').on('click','.inspiry-language',function (e) {

            if($('.inspiry-language-switcher').find('.rh_languages_available').children('.inspiry-language').length > 0){

            $('.rh_wrapper_language_switcher').toggleClass('parent_open');
            $(this).toggleClass('open');
            if($(this).hasClass('open')){
                $('.rh_languages_available').fadeIn(200);
            }else{
                $('.rh_languages_available').fadeOut(200);
            }
            }

            e.stopPropagation();
        });

        $('html').on('click',function () {
            $('.rh_wrapper_language_switcher').removeClass('parent_open');
            $('html .inspiry-language').removeClass('open');
            $('.rh_languages_available').fadeOut(200);
        });
	});
	
})(jQuery);