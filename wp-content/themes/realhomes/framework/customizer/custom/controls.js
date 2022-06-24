(function ($) {
    "use strict";

    $(document).ready(function () {
        /**
         * Multiple Checkbox Control
         */
        function RhTrigerChange() {
            var checkbox_values = $(this).parents('.customize-control').find('input[type="checkbox"]:checked').map(
                function () {
                    return this.value;
                }
            ).get().join(',');

            $(this).parents('.customize-control').find('input[type="hidden"]').val(checkbox_values).trigger('change');
        }

        $('.customize-control-multiple-checkbox input[type="checkbox"]').on('change', RhTrigerChange);
        $(".rh_sort_trigger").sortable({
            // placeholder: "ui-state-highlight",
            update: RhTrigerChange
        });
    });
})(jQuery);