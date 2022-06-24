(function ($) {

    wp.customize('inspiry_heading_font_weight', function (value) {
        value.bind(function (to) {
            wp.customize.preview.send('refresh', {});
        });
    });

    wp.customize('inspiry_secondary_font_weight', function (value) {
        value.bind(function (to) {
            wp.customize.preview.send('refresh', {});
        });
    });

    wp.customize('inspiry_body_font_weight', function (value) {
        value.bind(function (to) {
            wp.customize.preview.send('refresh', {});
        });
    });
})(jQuery );