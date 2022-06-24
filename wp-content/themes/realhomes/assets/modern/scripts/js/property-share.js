(function($) {
    "use strict";
    /*-----------------------------------------------------------------------------------*/
    /* Share Button
    /* https://github.com/carrot/share-button
    /*-----------------------------------------------------------------------------------*/
    $(document).ready(function () {
        var shareButtonLabel      = $('#share-button-title').text(),
            propertyTitle         = $('.single-property-title, .rh_page__title').text(),
            propertyThumbnail     = $('.only-for-print img').attr('src'),
            propertyDescription   = $.trim($('.entry-content p:first').text()),
            descriptionTextLength = 100, // Description Test Lenght for Social Media
            descriptionTextLabel  = 'Property URL'; // Label for URL you'd like to share via email

        var config = {
            title: propertyTitle,
            image: propertyThumbnail,
            description: propertyDescription.substring(0, descriptionTextLength),
            ui: {
                flyout: $('body').hasClass('rtl') ? 'bottom center' : 'bottom center',
                // button_text: shareButtonLabel
            },
            networks: {
                email: {
                    title: propertyTitle,
                    description: propertyDescription + '%0A%0A' + descriptionTextLabel + ': ' + window.location.href
                }
            }
        };

        var social_share = new Share( ".share-this", config );
        var social_share_btn = $( '#social-share' );
        social_share_btn.on('click', function(e) {
            e.preventDefault();
            social_share.toggle();
        });
    });
})(jQuery);