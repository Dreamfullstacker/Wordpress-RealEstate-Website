(function ($) {
    "use strict";

    $(document).ready(function () {

        // Script for Additional Social Networks
        var fontsLink = '<div><a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank">' + ereSocialLinksL10n.iconLink + '</a></div>';
        $(document).on("click", "#inspiry-ere-add-sn", function (event) {
            var socialNetworksTable = $('#inspiry-ere-social-networks-table');
            var socialNetworkIndex = socialNetworksTable.find('tbody tr').last().index() + 1;
            var socialNetwork =
                '<tr class="inspiry-ere-sn-tr">' +
                '<th scope="row">' +
                '<label for="inspiry-ere-sn-title-' + socialNetworkIndex + '">' + ereSocialLinksL10n.title + '</label>' +
                '<input type="text" id="inspiry-ere-sn-title-' + socialNetworkIndex + '" name="inspiry_ere_social_networks[' + socialNetworkIndex + '][title]" class="code">' +
                '</th>' +
                '<td>' +
                '<div>' +
                '<label for="inspiry-ere-sn-url-' + socialNetworkIndex + '"><strong>' + ereSocialLinksL10n.profileURL + '</strong></label>' +
                '<input type="text" id="inspiry-ere-sn-url-' + socialNetworkIndex + '" name="inspiry_ere_social_networks[' + socialNetworkIndex + '][url]" class="regular-text code">' +
                '</div>' +
                '<div>' +
                '<label for="inspiry-ere-sn-icon-' + socialNetworkIndex + '"><strong>' + ereSocialLinksL10n.iconClass + '</strong> <small>- <em>' + ereSocialLinksL10n.iconExample + '</em></small></label>' +
                '<input type="text" id="inspiry-ere-sn-icon-' + socialNetworkIndex + '" name="inspiry_ere_social_networks[' + socialNetworkIndex + '][icon]" class="code">' +
                '<a href="#" class="inspiry-ere-remove-sn inspiry-ere-sn-btn">-</a>' +
                fontsLink +
                '</div>' +
                '</td>' +
                '</tr>';

            socialNetworksTable.append(socialNetwork);
            event.preventDefault();
        });

        $(document).on("click", ".inspiry-ere-remove-sn", function (event) {
            $(this).closest('.inspiry-ere-sn-tr').remove();
            event.preventDefault();
        });

        $(document).on("click", ".inspiry-ere-edit-sn", function (event) {
            var $this = $(this),
                tableRow = $this.closest('.inspiry-ere-sn-tr');
            tableRow.find('.inspiry-ere-sn-field').removeClass('hide');
            tableRow.find('.inspiry-ere-sn-title').hide();
            $this.siblings('.inspiry-ere-update-sn').removeClass('hide');
            $this.addClass('hide');
            event.preventDefault();
        });

        $(document).on("click", ".inspiry-ere-update-sn", function (event) {
            var $this = $(this),
                tableRow = $this.closest('.inspiry-ere-sn-tr');
            tableRow.find('.inspiry-ere-sn-field').addClass('hide');
            tableRow.find('.inspiry-ere-sn-title').show().html(tableRow.find('input[type="text"]').val());
            $this.siblings('.inspiry-ere-edit-sn').removeClass('hide');
            $this.addClass('hide');
            event.preventDefault();
        });

        /**
         * Formats the price according to current local.
         *
         * @since 0.9.0
         */
        function ereFormatPrice(price) {
            var local = $('html').attr('lang');

            // Check for localized data object to get price number format language tag.
            if (typeof erePriceNumberFormatData !== "undefined") {
                local = erePriceNumberFormatData.local;
            }

            return (new Intl.NumberFormat(local).format(price));
        }

        /**
         * Adds formatted price preview on price fields in Property MetaBox.
         *
         * @since 0.6.0
         */
        function erePricePreview(element) {
            var $element = $(element),
                $price = $element.val(),
                $parent = $element.parent('.rwmb-input');

            if ($price) {
                $price.trim();
            }

            $parent
                .css('position', 'relative')
                .append('<strong class="ere-price-preview"></strong>');

            var $preview = $parent.find('.ere-price-preview');

            if ($price) {
                $price = ereFormatPrice($price);

                if ('NaN' !== $price && '0' !== $price) {
                    $preview.addClass('overlap').text($price);
                }
            }

            $element.on('input', function () {
                var price = $(this).val();

                if (price) {
                    price.trim();
                }

                price = ereFormatPrice(price);
                if ('NaN' === price || '0' === price) {
                    $preview.text('');
                } else {
                    $preview.text(price);
                }
            });

            $element.on('focus', function () {
                $preview.removeClass('overlap');
            });

            $element.on('blur', function () {
                $preview.addClass('overlap');
            });

            $preview.on('click', function () {
                $element.focus();
            });
        }

        erePricePreview('#REAL_HOMES_property_price');
        erePricePreview('#REAL_HOMES_property_old_price');
    });
}(jQuery));